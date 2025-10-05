<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Membership;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Carbon\Carbon;

class UserMembershipUpgradeTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $oldMembership;
    protected $newMembership;

    protected function setUp(): void
    {
        parent::setUp();
        Carbon::setTestNow('2025-01-01 12:00:00');
    }

    private function setupUserWithMemberships(int $oldPrice, int $newPrice, int $usedDays = 100): void
    {
        $this->oldMembership = Membership::factory()->create([
            'duration_days' => 365,
            'price' => $oldPrice,
        ]);

        $this->newMembership = Membership::factory()->create([
            'duration_days' => 365,
            'price' => $newPrice,
        ]);

        $remainingDays = $this->oldMembership->duration_days - $usedDays;

        $this->user = User::factory()->create([
            'membership_id' => $this->oldMembership->id,
            'membership_started_at' => now()->copy()->subDays($usedDays),
            'membership_expires_at' => now()->copy()->addDays($remainingDays),
        ]);
    }

    // ------------------ UPGRADE ONLY ------------------
    #[\PHPUnit\Framework\Attributes\Test]
    public function it_upgrades_with_only()
    {
        $this->setupUserWithMemberships(100, 200);
        $this->user->upgradeMembership($this->newMembership, 'upgrade_only');

        $expectedExpiry = now()->copy()->addDays(365)->toDateTimeString();
        $this->assertEquals($expectedExpiry, $this->user->membership_expires_at->toDateTimeString(), "Expected expiry datetime for upgrade_only to be {$expectedExpiry}");
    }

    // ------------------ UPGRADE EXTEND ------------------
    #[\PHPUnit\Framework\Attributes\Test]
    public function it_upgrades_with_extend()
    {
        $this->setupUserWithMemberships(100, 200);
        $remainingDays = 265; // 365 - 100
        $this->user->upgradeMembership($this->newMembership, 'upgrade_extend');

        $expectedExpiry = now()->copy()->addDays($remainingDays + 365)->toDateTimeString();
        $this->assertEquals($expectedExpiry, $this->user->membership_expires_at->toDateTimeString(), "Expected expiry datetime for upgrade_extend to be {$expectedExpiry}");
    }

    // ------------------ BALANCE ------------------
    #[\PHPUnit\Framework\Attributes\Test]
    public function it_downgrades_with_balance()
    {
        $this->setupUserWithMemberships(300, 200);
        $oldDayValue = 300 / 365;// 0.8219
        $remainingDays = 265;
        $balanceValue = $remainingDays * $oldDayValue; // 217.808
        $newDayValue = 200 / 365; // 0.5479
        $daysEquivalent = $balanceValue / $newDayValue; // 217.808 / 0.5479 ≈ 397.5
        $expectedExpiry = now()->copy()->addDays(floor($daysEquivalent))->addHours(round(($daysEquivalent - floor($daysEquivalent))*24))->toDateTimeString();
        $this->user->upgradeMembership($this->newMembership, 'upgrade_with_balance');
        $this->assertEquals($expectedExpiry, $this->user->membership_expires_at->toDateTimeString(), "Expected expiry datetime for downgrade with balance to be {$expectedExpiry}");
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_upgrades_with_balance()
    {
        $this->setupUserWithMemberships(100, 200);
        $this->user->upgradeMembership($this->newMembership, 'upgrade_with_balance');

        $oldDayValue = 100 / 365;
        $remainingDays = 265;
        $balanceValue = $remainingDays * $oldDayValue; // 72.602
        $newDayValue = 200 / 365;
        $daysEquivalent = $balanceValue / $newDayValue; // 72.602 / 0.5479 ≈ 132.5
        $expectedExpiry = now()->copy()->addDays(floor($daysEquivalent))->addHours(round(($daysEquivalent - floor($daysEquivalent))*24))->toDateTimeString();

        $this->assertEquals($expectedExpiry, $this->user->membership_expires_at->toDateTimeString(), "Expected expiry datetime for upgrade with balance to be {$expectedExpiry}");
    }

    // ------------------ EXTRA PAYMENT ------------------
    #[\PHPUnit\Framework\Attributes\Test]
    public function it_downgrades_with_extra_payment()
    {
        $this->setupUserWithMemberships(300, 200);
        $remainingDays = 265;
        $totalPrice = 200 + ($remainingDays * (300 / 365)); // 417.808
        $daysEquivalent = $totalPrice / (200 / 365); // ≈762.8
        $expectedExpiry = now()->copy()->addDays(floor($daysEquivalent))->addHours(round(($daysEquivalent - floor($daysEquivalent))*24))->toDateTimeString();

        $result = $this->user->upgradeMembership($this->newMembership, 'upgrade_with_extra_payment');

        $this->assertEquals($expectedExpiry, $result['expires_at']->toDateTimeString(), "Expected expiry datetime for downgrade with extra payment to be {$expectedExpiry}");
        $this->assertEquals($totalPrice, $result['price'], "Expected total price for downgrade with extra payment to be {$totalPrice}");
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_upgrades_with_extra_payment()
    {
        $this->setupUserWithMemberships(100, 200);
        $remainingDays = 265;
        $totalPrice = 200 + ($remainingDays * (100 / 365)); // 272.602
        $daysEquivalent = $totalPrice / (200 / 365); // ≈497.7
        $expectedExpiry = now()->copy()->addDays(floor($daysEquivalent))->addHours(round(($daysEquivalent - floor($daysEquivalent))*24))->toDateTimeString();

        $result = $this->user->upgradeMembership($this->newMembership, 'upgrade_with_extra_payment');

        $this->assertEquals($expectedExpiry, $result['expires_at']->toDateTimeString(), "Expected expiry datetime for upgrade with extra payment to be {$expectedExpiry}");
        $this->assertEquals($totalPrice, $result['price'], "Expected total price for upgrade with extra payment to be {$totalPrice}");
    }
}
