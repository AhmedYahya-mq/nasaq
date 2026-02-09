<?php

namespace Tests\Feature;

use App\Models\Membership;
use App\Models\Payment;
use App\Support\PaymentIntentFactory;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class MembershipPaymentFlowTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Carbon::setTestNow('2025-01-01 12:00:00');

        // We validate CSRF via real browser flows. Feature tests focus on payment correctness.
        $this->withoutMiddleware(ValidateCsrfToken::class);

        // Avoid notification side effects when approving applications.
        Notification::fake();
    }

    protected function tearDown(): void
    {
        // Avoid leaking frozen time into other test classes.
        Carbon::setTestNow();

        parent::tearDown();
    }

    private function csrfPayload(array $payload = []): array
    {
        return array_merge(['_token' => 'test-token'], $payload);
    }

    private function withCsrfSession(): self
    {
        return $this->withSession(['_token' => 'test-token']);
    }

    private function fakeMoyasarCreateInitiated(string $paymentId, int $amountHalalas): void
    {
        Config::set('moyasar.base_url', 'https://api.moyasar.com/v1');
        Config::set('moyasar.secret_key', 'sk_test');

        Http::fake([
            'https://api.moyasar.com/v1/payments' => Http::response([
                'id' => $paymentId,
                'status' => 'initiated',
                'amount' => $amountHalalas,
                'currency' => 'SAR',
                'source' => [
                    'type' => 'creditcard',
                    'company' => 'visa',
                    'message' => 'Initiated',
                    'transaction_url' => 'https://sandbox.moyasar.com/tx/' . $paymentId,
                ],
                'description' => 'Test payment',
            ], 200),
        ]);
    }

    private function fakeMoyasarFindPaid(string $paymentId, int $amountHalalas, string $currency = 'SAR'): void
    {
        Config::set('moyasar.base_url', 'https://api.moyasar.com/v1');
        Config::set('moyasar.secret_key', 'sk_test');

        Http::fake([
            'https://api.moyasar.com/v1/payments/' . $paymentId => Http::response([
                'id' => $paymentId,
                'status' => 'paid',
                'amount' => $amountHalalas,
                'currency' => $currency,
                'source' => [
                    'type' => 'creditcard',
                    'company' => 'visa',
                    'message' => 'Paid',
                ],
                'description' => 'Test payment',
            ], 200),
        ]);
    }

    public function test_membership_new_purchase_redirects_to_request_and_applies_on_approval(): void
    {
        $membership = Membership::factory()->create([
            'duration_days' => 365,
            'price' => 100,
            'discounted_price' => null,
            'level' => 1,
        ]);

        $user = \App\Models\User::factory()->create([
            'is_active' => true,
            'membership_id' => null,
            'membership_started_at' => null,
            'membership_expires_at' => null,
        ]);

        $intent = PaymentIntentFactory::prepare($user->id, $membership);

        $this->fakeMoyasarCreateInitiated('pay_mem_new_1', 10000);

        $this->actingAs($user)
            ->withCsrfSession()
            ->post(route('client.pay.create'), $this->csrfPayload([
                'intent_token' => $intent->token,
                'cc_type' => 'creditcard',
                'name' => 'Test User',
                'cc_number' => '4111111111111111',
                'cc_expiry' => '12/30',
                'cvc' => '123',
            ]))
            ->assertOk();

        $this->fakeMoyasarFindPaid('pay_mem_new_1', 10000);

        $callback = $this->actingAs($user)->get(route('client.pay.callback', ['id' => 'pay_mem_new_1']));
        $callback->assertRedirect();

        $payment = Payment::where('moyasar_id', 'pay_mem_new_1')->firstOrFail();
        $this->assertTrue($payment->isPaid());
        $this->assertNotNull($payment->membershipApplication);

        $callback->assertRedirect(route('client.membership.request', ['application' => $payment->membershipApplication]));

        // Membership should NOT be applied on callback (only on approval).
        $user->refresh();
        $this->assertNull($user->membership_id);

        $application = $payment->membershipApplication->fresh();
        $this->assertSame($membership->id, (int) $application->membership_id);

        $application->approve();

        $user->refresh();
        $this->assertSame($membership->id, (int) $user->membership_id);

        $expectedExpiry = now()->copy()->addDays(365)->toDateTimeString();
        $this->assertSame($expectedExpiry, $user->membership_expires_at->toDateTimeString());
    }

    public function test_membership_upgrade_redirects_to_request_and_applies_on_approval(): void
    {
        $oldMembership = Membership::factory()->create([
            'duration_days' => 365,
            'price' => 100,
            'discounted_price' => null,
            'level' => 1,
        ]);

        $newMembership = Membership::factory()->create([
            'duration_days' => 365,
            'price' => 200,
            'discounted_price' => null,
            'level' => 2,
        ]);

        $user = \App\Models\User::factory()->create([
            'is_active' => true,
            'membership_id' => $oldMembership->id,
            'membership_started_at' => now()->subDays(30),
            'membership_expires_at' => now()->addDays(90),
        ]);

        $intent = PaymentIntentFactory::prepare($user->id, $newMembership);

        $this->fakeMoyasarCreateInitiated('pay_mem_up_1', 20000);

        $this->actingAs($user)
            ->withCsrfSession()
            ->post(route('client.pay.create'), $this->csrfPayload([
                'intent_token' => $intent->token,
                'cc_type' => 'creditcard',
                'name' => 'Test User',
                'cc_number' => '4111111111111111',
                'cc_expiry' => '12/30',
                'cvc' => '123',
            ]))
            ->assertOk();

        $this->fakeMoyasarFindPaid('pay_mem_up_1', 20000);

        $callback = $this->actingAs($user)->get(route('client.pay.callback', ['id' => 'pay_mem_up_1']));
        $callback->assertRedirect();

        $payment = Payment::where('moyasar_id', 'pay_mem_up_1')->firstOrFail();
        $this->assertTrue($payment->isPaid());
        $this->assertNotNull($payment->membershipApplication);

        $callback->assertRedirect(route('client.membership.request', ['application' => $payment->membershipApplication]));

        // Membership should NOT be changed yet.
        $user->refresh();
        $this->assertSame($oldMembership->id, (int) $user->membership_id);

        $application = $payment->membershipApplication->fresh();
        $this->assertSame($newMembership->id, (int) $application->membership_id);

        // Manual expected expiry based on User::calculateMembershipChange logic:
        // remainingDays = ceil(diff in days), remainingValue = oldPrice * remainingDays / oldDuration,
        // extraDays = round((remainingValue / newPrice) * newDuration),
        // upgrade => now + newDuration + extraDays
        $oldPrice = 100;
        $newPrice = 200;
        $oldDuration = 365;
        $newDuration = 365;
        $remainingDays = abs((int) ceil(now()->copy()->addDays(90)->floatDiffInDays(now())));
        $remainingValue = ($oldPrice * $remainingDays) / $oldDuration;
        $extraDays = (int) round(($remainingValue / $newPrice) * $newDuration);
        $expectedExpiry = now()->copy()->addDays($newDuration + $extraDays)->toDateTimeString();

        $application->approve();

        $user->refresh();
        $this->assertSame($newMembership->id, (int) $user->membership_id);
        $this->assertSame($expectedExpiry, $user->membership_expires_at->toDateTimeString());
    }

    public function test_membership_downgrade_redirects_to_request_and_applies_on_approval(): void
    {
        $oldMembership = Membership::factory()->create([
            'duration_days' => 365,
            'price' => 200,
            'discounted_price' => null,
            'level' => 2,
        ]);

        $newMembership = Membership::factory()->create([
            'duration_days' => 365,
            'price' => 100,
            'discounted_price' => null,
            'level' => 1,
        ]);

        $user = \App\Models\User::factory()->create([
            'is_active' => true,
            'membership_id' => $oldMembership->id,
            'membership_started_at' => now()->subDays(60),
            'membership_expires_at' => now()->addDays(120),
        ]);

        $intent = PaymentIntentFactory::prepare($user->id, $newMembership);

        $this->fakeMoyasarCreateInitiated('pay_mem_down_1', 10000);

        $this->actingAs($user)
            ->withCsrfSession()
            ->post(route('client.pay.create'), $this->csrfPayload([
                'intent_token' => $intent->token,
                'cc_type' => 'creditcard',
                'name' => 'Test User',
                'cc_number' => '4111111111111111',
                'cc_expiry' => '12/30',
                'cvc' => '123',
            ]))
            ->assertOk();

        $this->fakeMoyasarFindPaid('pay_mem_down_1', 10000);

        $callback = $this->actingAs($user)->get(route('client.pay.callback', ['id' => 'pay_mem_down_1']));
        $callback->assertRedirect();

        $payment = Payment::where('moyasar_id', 'pay_mem_down_1')->firstOrFail();
        $this->assertTrue($payment->isPaid());
        $this->assertNotNull($payment->membershipApplication);

        $callback->assertRedirect(route('client.membership.request', ['application' => $payment->membershipApplication]));

        // Membership should NOT be changed yet.
        $user->refresh();
        $this->assertSame($oldMembership->id, (int) $user->membership_id);

        $application = $payment->membershipApplication->fresh();
        $this->assertSame($newMembership->id, (int) $application->membership_id);

        // Manual expected expiry based on User::calculateMembershipChange logic:
        // remainingDays = ceil(diff in days), remainingValue = oldPrice * remainingDays / oldDuration,
        // extraDays = round((remainingValue / newPrice) * newDuration),
        // downgrade => now + extraDays
        $oldPrice = 200;
        $newPrice = 100;
        $oldDuration = 365;
        $newDuration = 365;
        $remainingDays = abs((int) ceil(now()->copy()->addDays(120)->floatDiffInDays(now())));
        $remainingValue = ($oldPrice * $remainingDays) / $oldDuration;
        $extraDays = (int) round(($remainingValue / $newPrice) * $newDuration);
        $expectedExpiry = now()->copy()->addDays($extraDays)->toDateTimeString();

        $application->approve();

        $user->refresh();
        $this->assertSame($newMembership->id, (int) $user->membership_id);
        $this->assertSame($expectedExpiry, $user->membership_expires_at->toDateTimeString());
    }

    public function test_membership_renewal_extends_from_current_expiry_on_approval(): void
    {
        $membership = Membership::factory()->create([
            'duration_days' => 365,
            'price' => 100,
            'discounted_price' => null,
            'level' => 1,
        ]);

        $user = \App\Models\User::factory()->create([
            'is_active' => true,
            'membership_id' => $membership->id,
            'membership_started_at' => now()->subDays(10),
            'membership_expires_at' => now()->addDays(30),
        ]);

        $intent = PaymentIntentFactory::prepare($user->id, $membership);

        $this->fakeMoyasarCreateInitiated('pay_mem_renew_2', 10000);

        $this->actingAs($user)
            ->withCsrfSession()
            ->post(route('client.pay.create'), $this->csrfPayload([
                'intent_token' => $intent->token,
                'cc_type' => 'creditcard',
                'name' => 'Test User',
                'cc_number' => '4111111111111111',
                'cc_expiry' => '12/30',
                'cvc' => '123',
            ]))
            ->assertOk();

        $this->fakeMoyasarFindPaid('pay_mem_renew_2', 10000);

        $callback = $this->actingAs($user)->get(route('client.pay.callback', ['id' => 'pay_mem_renew_2']));
        $callback->assertRedirect();

        $payment = Payment::where('moyasar_id', 'pay_mem_renew_2')->firstOrFail();
        $this->assertTrue($payment->isPaid());
        $this->assertNotNull($payment->membershipApplication);

        $application = $payment->membershipApplication->fresh();

        // Renewal should extend from current expiry (30 days ahead) + 365.
        $expectedExpiry = now()->copy()->addDays(30 + 365)->toDateTimeString();

        $application->approve();

        $user->refresh();
        $this->assertSame($membership->id, (int) $user->membership_id);
        $this->assertSame($expectedExpiry, $user->membership_expires_at->toDateTimeString());
    }
}
