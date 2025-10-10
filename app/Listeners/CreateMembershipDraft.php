<?php

namespace App\Listeners;

use App\Enums\MembershipApplication as EnumsMembershipApplication;
use App\Events\PaymentStatusChanged;
use App\Models\MembershipApplication;

class CreateMembershipDraft
{
    public function handle(PaymentStatusChanged $event)
    {
        $payment = $event->payment;
        if (!$payment->isPaid() || $payment->payable_type !== \App\Models\Membership::class) {
            throw new \Exception("Payment is not for membership or not paid yet.");
        }
        $membershipId = $payment->payable_id;
        $app = MembershipApplication::firstOrCreate(
            [
                'user_id' => $payment->user_id,
                'membership_id' => $membershipId,
                'status' => EnumsMembershipApplication::Draft,
                'payment_id' => $payment->id
            ],
            [
                'submitted_at' => now(),
                'employment_status' => $payment->user->employment_status,
            ]
        );
        return $app;
    }
}
