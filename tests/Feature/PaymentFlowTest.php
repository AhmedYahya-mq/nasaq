<?php

namespace Tests\Feature;

use App\Enums\EventStatus;
use App\Enums\LibraryStatus;
use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\Library;
use App\Models\Payment;
use App\Models\PaymentIntent;
use App\Models\User;
use App\Support\PaymentIntentFactory;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class PaymentFlowTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // We validate CSRF via real browser flows. Feature tests focus on payment correctness.
        $this->withoutMiddleware(ValidateCsrfToken::class);
    }

    private function csrfPayload(array $payload = []): array
    {
        return array_merge(['_token' => 'test-token'], $payload);
    }

    private function withCsrfSession(): self
    {
        return $this->withSession(['_token' => 'test-token']);
    }

    private function fakeMoyasarCreateInitiated(string $paymentId = 'pay_test_123', int $amountHalalas = 10000): void
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

    public function test_prepare_creates_intent_and_redirects_to_token_page(): void
    {
        $user = User::factory()->create(['is_active' => true]);
        $event = Event::query()->create([
            'price' => 100,
            'discount' => 0,
            'event_status' => EventStatus::Upcoming,
            'start_at' => Carbon::now()->addDays(2),
            'end_at' => Carbon::now()->addDays(3),
            'capacity' => null,
            'is_featured' => false,
        ]);

        $event = $event->fresh();
        $this->assertFalse($event->isFreeForUser($user));
        $this->assertTrue($event->isRegistrationOpen(), 'Expected event registration to be open in test.');
        $this->assertTrue($event->canUserRegister($user));
        $this->assertTrue($event->isPurchasableFor($user));

        $response = $this->actingAs($user)
            ->from('/events')
            ->post(route('client.pay.prepare'), $this->csrfPayload([
                'type' => 'event',
                'id' => $event->id,
            ]));

        $response->assertStatus(302);

        $location = (string) $response->headers->get('Location');
        $this->assertNotSame('', $location);

        $this->assertMatchesRegularExpression('~/(?:[a-z]{2}/)?payment/([A-Za-z0-9]{64})$~', $location);
        preg_match('~/(?:[a-z]{2}/)?payment/([A-Za-z0-9]{64})$~', $location, $m);
        $token = $m[1] ?? null;
        $this->assertNotNull($token);

        $intent = PaymentIntent::query()->where('token', $token)->first();
        $this->assertNotNull($intent);
        $this->assertSame($user->id, (int) $intent->user_id);

        $response->assertRedirect(route('client.pay.show', ['token' => $intent->token]));
    }

    public function test_create_payment_creates_payment_and_marks_intent_used(): void
    {
        $user = User::factory()->create(['is_active' => true]);
        $event = Event::query()->create([
            'price' => 100,
            'discount' => 0,
            'event_status' => EventStatus::Upcoming,
            'start_at' => Carbon::now()->addDays(2),
            'end_at' => Carbon::now()->addDays(3),
        ]);
        $intent = PaymentIntentFactory::prepare($user->id, $event);

        $this->fakeMoyasarCreateInitiated('pay_test_123', 10000);

        $response = $this->actingAs($user)
            ->withCsrfSession()
            ->post(route('client.pay.create'), $this->csrfPayload([
                'intent_token' => $intent->token,
                'cc_type' => 'creditcard',
                'name' => 'Test User',
                'cc_number' => '4111111111111111',
                'cc_expiry' => '12/30',
                'cvc' => '123',
            ]));

        $response->assertOk()->assertJson([
            'success' => true,
            'moyasar_id' => 'pay_test_123',
        ]);

        $intent->refresh();
        $this->assertSame('used', $intent->status);
        $this->assertNotNull($intent->payment_id);

        $payment = Payment::find($intent->payment_id);
        $this->assertNotNull($payment);
        $this->assertSame('pay_test_123', $payment->moyasar_id);
        // Stored in SAR (payload amount halalas / 100)
        $this->assertSame(100, (int) $payment->amount);
    }

    public function test_callback_verifies_with_gateway_marks_paid_and_registers_event(): void
    {
        $user = User::factory()->create(['is_active' => true]);
        $event = Event::query()->create([
            'price' => 100,
            'discount' => 0,
            'event_status' => EventStatus::Upcoming,
            'start_at' => Carbon::now()->addDays(2),
            'end_at' => Carbon::now()->addDays(3),
        ]);
        $intent = PaymentIntentFactory::prepare($user->id, $event);

        $this->fakeMoyasarCreateInitiated('pay_cb_1', 10000);

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

        $this->fakeMoyasarFindPaid('pay_cb_1', 10000);

        $callback = $this->actingAs($user)->get(route('client.pay.callback', ['id' => 'pay_cb_1']));
        $callback->assertOk()->assertViewIs('success');

        $payment = Payment::where('moyasar_id', 'pay_cb_1')->firstOrFail();
        $this->assertTrue($payment->isPaid());

        $registration = EventRegistration::query()
            ->where('event_id', $event->id)
            ->where('user_id', $user->id)
            ->first();

        $this->assertNotNull($registration);
        $this->assertSame($payment->id, (int) $registration->payment_id);
    }

    public function test_callback_rejects_amount_mismatch_and_redirects_to_failure(): void
    {
        $user = User::factory()->create(['is_active' => true]);
        $event = Event::query()->create([
            'price' => 100,
            'discount' => 0,
            'event_status' => EventStatus::Upcoming,
            'start_at' => Carbon::now()->addDays(2),
            'end_at' => Carbon::now()->addDays(3),
        ]);
        $payment = Payment::create([
            'user_id' => $user->id,
            'moyasar_id' => 'pay_mismatch_1',
            'payable_id' => $event->id,
            'payable_type' => Event::class,
            'amount' => 100, // SAR
            'currency' => 'SAR',
            'status' => 'initiated',
            'source_type' => 'creditcard',
            'raw_response' => [],
            'discount' => 0,
            'membership_discount' => 0,
            'original_price' => 100,
        ]);

        // gateway returns different amount
        $this->fakeMoyasarFindPaid('pay_mismatch_1', 9999);

        $res = $this->actingAs($user)->get(route('client.pay.callback', ['id' => $payment->moyasar_id]));
        $res->assertRedirect(route('client.pay.failure', ['message' => 'Amount mismatch']));
    }

    public function test_callback_rejects_currency_mismatch_and_redirects_to_failure(): void
    {
        $user = User::factory()->create(['is_active' => true]);
        $event = Event::query()->create([
            'price' => 100,
            'discount' => 0,
            'event_status' => EventStatus::Upcoming,
            'start_at' => Carbon::now()->addDays(2),
            'end_at' => Carbon::now()->addDays(3),
        ]);

        $payment = Payment::create([
            'user_id' => $user->id,
            'moyasar_id' => 'pay_curr_mismatch_1',
            'payable_id' => $event->id,
            'payable_type' => Event::class,
            'amount' => 100, // SAR
            'currency' => 'SAR',
            'status' => 'initiated',
            'source_type' => 'creditcard',
            'raw_response' => [],
            'discount' => 0,
            'membership_discount' => 0,
            'original_price' => 100,
        ]);

        // gateway returns USD instead of SAR
        $this->fakeMoyasarFindPaid($payment->moyasar_id, 10000, 'USD');

        $res = $this->actingAs($user)->get(route('client.pay.callback', ['id' => $payment->moyasar_id]));
        $res->assertRedirect(route('client.pay.failure', ['message' => 'Currency mismatch']));
    }

    public function test_webhook_requires_token_when_configured(): void
    {
        Config::set('moyasar.webhook_token', 'secret');
        $res = $this->postJson(route('payment.webhook.moyasar'), ['id' => 'pay_x']);
        $res->assertStatus(401);
    }

    public function test_webhook_is_idempotent_and_registers_event_once(): void
    {
        Config::set('moyasar.webhook_token', 'secret');
        $user = User::factory()->create(['is_active' => true]);
        $event = Event::query()->create([
            'price' => 100,
            'discount' => 0,
            'event_status' => EventStatus::Upcoming,
            'start_at' => Carbon::now()->addDays(2),
            'end_at' => Carbon::now()->addDays(3),
        ]);

        $payment = Payment::create([
            'user_id' => $user->id,
            'moyasar_id' => 'pay_webhook_1',
            'payable_id' => $event->id,
            'payable_type' => Event::class,
            'amount' => 100,
            'currency' => 'SAR',
            'status' => 'initiated',
            'source_type' => 'creditcard',
            'raw_response' => [],
            'discount' => 0,
            'membership_discount' => 0,
            'original_price' => 100,
        ]);

        $this->fakeMoyasarFindPaid('pay_webhook_1', 10000);

        $first = $this->postJson(
            route('payment.webhook.moyasar'),
            ['id' => $payment->moyasar_id],
            ['X-Moyasar-Webhook-Token' => 'secret']
        );
        $first->assertOk();
        $this->assertDatabaseCount('event_registrations', 1);

        // Second call should not duplicate
        $this->fakeMoyasarFindPaid('pay_webhook_1', 10000);
        $second = $this->postJson(
            route('payment.webhook.moyasar'),
            ['id' => $payment->moyasar_id],
            ['X-Moyasar-Webhook-Token' => 'secret']
        );
        $second->assertOk();
        $this->assertDatabaseCount('event_registrations', 1);
    }

    public function test_library_free_then_paid_does_not_allow_download_without_real_payment(): void
    {
        $user = User::factory()->create(['is_active' => true]);
        $library = Library::query()->create([
            'status' => LibraryStatus::Published,
            'type' => 'ebook',
            'price' => 0,
            'discount' => 0,
            'path' => 'test.pdf',
            'published_at' => Carbon::now()->toDateString(),
        ]);

        $ok = $library->savedUser($user->id);
        $this->assertTrue($ok);
        $this->assertTrue($library->isUserRegistered($user->id));

        // Price change to paid: free invoice must NOT grant access.
        $library->update(['price' => 100]);
        $this->assertFalse($library->isUserRegistered($user->id));
    }

    public function test_intent_factory_reuses_prepared_intent_for_same_user_and_item(): void
    {
        $user = User::factory()->create(['is_active' => true]);
        $event = Event::query()->create([
            'price' => 100,
            'discount' => 0,
            'event_status' => EventStatus::Upcoming,
            'start_at' => Carbon::now()->addDays(2),
            'end_at' => Carbon::now()->addDays(3),
        ]);

        $a = PaymentIntentFactory::prepare($user->id, $event);
        $b = PaymentIntentFactory::prepare($user->id, $event);

        $this->assertSame($a->id, $b->id);
        $this->assertDatabaseCount('payment_intents', 1);
    }

    public function test_show_returns_410_when_intent_expired(): void
    {
        $user = User::factory()->create(['is_active' => true]);
        $event = Event::query()->create([
            'price' => 100,
            'discount' => 0,
            'event_status' => EventStatus::Upcoming,
            'start_at' => Carbon::now()->addDays(2),
            'end_at' => Carbon::now()->addDays(3),
        ]);

        $intent = PaymentIntent::create([
            'user_id' => $user->id,
            'payable_type' => Event::class,
            'payable_id' => $event->id,
            'status' => 'prepared',
            'expires_at' => now()->subMinute(),
        ]);

        $this->actingAs($user)
            ->get(route('client.pay.show', ['token' => $intent->token]))
            ->assertStatus(410);
    }

    public function test_idor_cannot_view_other_users_intent_token(): void
    {
        $owner = User::factory()->create(['is_active' => true]);
        $attacker = User::factory()->create(['is_active' => true]);

        $event = Event::query()->create([
            'price' => 100,
            'discount' => 0,
            'event_status' => EventStatus::Upcoming,
            'start_at' => Carbon::now()->addDays(2),
            'end_at' => Carbon::now()->addDays(3),
        ]);

        $intent = PaymentIntentFactory::prepare($owner->id, $event);

        $this->actingAs($attacker)
            ->get(route('client.pay.show', ['token' => $intent->token]))
            ->assertStatus(404);
    }

    public function test_idor_cannot_create_payment_with_other_users_intent_token(): void
    {
        $owner = User::factory()->create(['is_active' => true]);
        $attacker = User::factory()->create(['is_active' => true]);

        $event = Event::query()->create([
            'price' => 100,
            'discount' => 0,
            'event_status' => EventStatus::Upcoming,
            'start_at' => Carbon::now()->addDays(2),
            'end_at' => Carbon::now()->addDays(3),
        ]);

        $intent = PaymentIntentFactory::prepare($owner->id, $event);

        $res = $this->actingAs($attacker)
            ->withCsrfSession()
            ->post(route('client.pay.create'), $this->csrfPayload([
                'intent_token' => $intent->token,
                'cc_type' => 'creditcard',
                'name' => 'Attacker',
                'cc_number' => '4111111111111111',
                'cc_expiry' => '12/30',
                'cvc' => '123',
            ]));

        $res->assertStatus(400)->assertJson([
            'success' => false,
        ]);
    }

    public function test_prepare_replay_is_rejected_by_prevent_duplicate(): void
    {
        $user = User::factory()->create(['is_active' => true]);
        $event = Event::query()->create([
            'price' => 100,
            'discount' => 0,
            'event_status' => EventStatus::Upcoming,
            'start_at' => Carbon::now()->addDays(2),
            'end_at' => Carbon::now()->addDays(3),
        ]);

        $payload = $this->csrfPayload([
            'type' => 'event',
            'id' => $event->id,
        ]);

        $first = $this->actingAs($user)->post(route('client.pay.prepare'), $payload);
        $first->assertStatus(302);

        $second = $this->actingAs($user)->post(route('client.pay.prepare'), $payload);
        $second->assertStatus(429)->assertJson([
            'success' => false,
        ]);
    }

    public function test_payment_create_is_rate_limited(): void
    {
        $user = User::factory()->create(['is_active' => true]);
        $event = Event::query()->create([
            'price' => 100,
            'discount' => 0,
            'event_status' => EventStatus::Upcoming,
            'start_at' => Carbon::now()->addDays(2),
            'end_at' => Carbon::now()->addDays(3),
        ]);
        $intent = PaymentIntentFactory::prepare($user->id, $event);

        $this->fakeMoyasarCreateInitiated('pay_rl_1', 10000);

        // 10 requests per minute allowed, 11th should be blocked.
        for ($i = 0; $i < 10; $i++) {
            $this->actingAs($user)
                ->withCsrfSession()
                ->postJson(route('client.pay.create'), $this->csrfPayload([
                    'intent_token' => $intent->token,
                    'cc_type' => 'creditcard',
                    'name' => 'Test User',
                    'cc_number' => '4111111111111111',
                    'cc_expiry' => '12/30',
                    'cvc' => '123',
                    // vary fingerprint so PreventDuplicateRequest doesn't block before throttle
                    'nonce' => 'n' . $i,
                ]))
                ->assertOk();
        }

        $blocked = $this->actingAs($user)
            ->withCsrfSession()
            ->postJson(route('client.pay.create'), $this->csrfPayload([
                'intent_token' => $intent->token,
                'cc_type' => 'creditcard',
                'name' => 'Test User',
                'cc_number' => '4111111111111111',
                'cc_expiry' => '12/30',
                'cvc' => '123',
                'nonce' => 'n-block',
            ]));

        $blocked->assertStatus(429);
    }
}
