<?php

namespace App\Support;

use App\Models\PaymentIntent;
use Illuminate\Database\Eloquent\Model;

final class PaymentIntentFactory
{
    public static function prepare(int $userId, Model $payable, int $ttlMinutes = 20): PaymentIntent
    {
        $existing = PaymentIntent::query()
            ->where('user_id', $userId)
            ->where('payable_type', get_class($payable))
            ->where('payable_id', $payable->id)
            ->where('status', 'prepared')
            ->where(function ($q) {
                $q->whereNull('expires_at')->orWhere('expires_at', '>', now());
            })
            ->latest('id')
            ->first();

        if ($existing) {
            return $existing;
        }

        return PaymentIntent::create([
            'user_id' => $userId,
            'payable_type' => get_class($payable),
            'payable_id' => $payable->id,
            'status' => 'prepared',
            'expires_at' => now()->addMinutes($ttlMinutes),
        ]);
    }
}
