<?php

namespace App\Actions\Payment;

use App\Models\Payment;

class SaveInitialData
{
    public function handle(array $payload, \Closure $next)
    {
        // حفظ بيانات المنتج/الخدمة في جدول Payment مع حالة مبدئية
        $payment = Payment::create([
            'user_id' => $payload['user_id'],
            'payable_id' => $payload['payable_id'],
            'payable_type' => $payload['payable_type'],
            'amount' => $payload['amount'],
            'currency' => $payload['currency'],
            'status' => 'initiated',
            'source_type' => $payload['source_type'], // card أو stc
            'description' => $payload['description'] ?? '',
        ]);

        $payload['payment_model'] = $payment;

        return $next($payload);
    }
}
