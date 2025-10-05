<?php

namespace App\Actions\Payment;

use App\Services\MoyasarPayment;

class FinalizePayment
{
    public function handle(array $payload, \Closure $next)
    {
        $payment = $payload['payment_model'];

        // استدعاء API للتحقق النهائي
        $response = MoyasarPayment::find($payment->moyasar_id);

        if ($response->isPaid()) {
            $payment->update(['status' => 'paid', 'raw_response' => $response->toArray()]);
        } elseif ($response->isFailed()) {
            $payment->update(['status' => 'failed', 'raw_response' => $response->toArray()]);
        }

        return $next($payload);
    }
}
