<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Membership;
use Carbon\Carbon;

class MembershipChangeTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\Test]
    public function it_calculates_membership_change_for_new_membership()
    {
        Carbon::setTestNow(Carbon::create(2025, 9, 22));

        $newMembership = Membership::make([
            'id' => 1,
            'price' => 200,
            'duration_days' => 365,
        ]);

        $user = new User(); // بدون عضوية سابقة

        $result = $user->calculateMembershipChange($newMembership);

        $expectedExpiresAt = Carbon::now()->copy()->addDays($newMembership->duration_days);

        $this->assertNull($result['oldMembership']);
        $this->assertEquals($newMembership->id, $result['newMembership']->id);
        $this->assertEquals($expectedExpiresAt->toDateString(), $result['newExpiresAt']->toDateString());
        $this->assertEquals(200, $result['priceDifference']);
        $this->assertEquals('new', $result['actionType']);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_calculates_membership_change_for_renewal()
    {
        Carbon::setTestNow(Carbon::create(2025, 9, 22));

        $membership = Membership::make([
            'id' => 1,
            'price' => 300,
            'duration_days' => 365,
        ]);

        $user = new User();
        $user->membership = $membership;
        $user->membership_expires_at = Carbon::now()->addDays(100);

        $result = $user->calculateMembershipChange($membership);

        $expectedExpiresAt = Carbon::now()->copy()->addDays(100 + 365);

        $this->assertEquals($membership->id, $result['oldMembership']->id);
        $this->assertEquals($membership->id, $result['newMembership']->id);
        $this->assertEquals($expectedExpiresAt->toDateString(), $result['newExpiresAt']->toDateString());
        $this->assertEquals(300, $result['priceDifference']);
        $this->assertEquals('renewal', $result['actionType']);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_calculates_membership_change_for_upgrade()
    {
        Carbon::setTestNow(Carbon::create(2025, 9, 22));

        $oldMembership = Membership::make([
            'id' => 1,
            'price' => 100,
            'duration_days' => 365,
        ]);

        $newMembership = Membership::make([
            'id' => 2,
            'price' => 350,
            'duration_days' => 365,
        ]);

        $user = new User();
        $user->membership = $oldMembership;
        $user->membership_started_at = Carbon::now()->subDays(315);
        $user->membership_expires_at = Carbon::now()->addDays(100); // متبقي 150 يوم

        $result = $user->calculateMembershipChange($newMembership);

        // حساب الأيام الإضافية بنفس طريقة الدالة
        $remainingDays = 100;
        $remainingValue = $oldMembership->price * $remainingDays / $oldMembership->duration_days;
        $extraDays = round(($remainingValue / $newMembership->price) * $newMembership->duration_days);
        $expectedExpiresAt = Carbon::now()->copy()->addDays($newMembership->duration_days + $extraDays);

        $this->assertEquals('upgrade', $result['actionType']);
        $this->assertEquals($oldMembership->id, $result['oldMembership']->id);
        $this->assertEquals($newMembership->id, $result['newMembership']->id);
        $this->assertEquals($expectedExpiresAt->toDateString(), $result['newExpiresAt']->toDateString());
        $this->assertGreaterThan(0, $result['priceDifference']);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_calculates_membership_change_for_downgrade()
    {
        Carbon::setTestNow(Carbon::create(2024, 9, 22));

        $oldMembership = Membership::make([
            'id' => 1,
            'price' => 300,
            'duration_days' => 365,
        ]);

        $newMembership = Membership::make([
            'id' => 2,
            'price' => 100,
            'duration_days' => 365,
        ]);

        $user = new User();
        $user->membership = $oldMembership;
        $user->membership_started_at = Carbon::now()->subDays(165);
        $user->membership_expires_at = Carbon::now()->addDays(200);

        $result = $user->calculateMembershipChange($newMembership);

        // حساب الأيام الإضافية بنفس طريقة الدالة
        $remainingDays = 200;
        $remainingValue = $oldMembership->price * $remainingDays / $oldMembership->duration_days;
        $extraDays = round(($remainingValue / $newMembership->price) * $newMembership->duration_days);
        $expectedExpiresAt = Carbon::now()->copy()->addDays($extraDays);

        $this->assertEquals('downgrade', $result['actionType']);
        $this->assertEquals($oldMembership->id, $result['oldMembership']->id);
        $this->assertEquals($newMembership->id, $result['newMembership']->id);
        $this->assertEquals($expectedExpiresAt->toDateString(), $result['newExpiresAt']->toDateString());
    }
}
