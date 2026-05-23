<?php

namespace App\Services\Payment\Strategies;

use App\DTOs\Payment\PaymentPayloadDTO;

final class ApplePayPaymentStrategy implements PaymentMethodStrategy
{
    public function apply(PaymentPayloadDTO $payload, array $input): PaymentPayloadDTO
    {
        return $payload->withSource([
            'type' => 'applepay',
            'token' => $input['applepay_token'] ?? [],
        ]);
    }
}
