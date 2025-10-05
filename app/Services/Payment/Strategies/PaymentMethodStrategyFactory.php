<?php

namespace App\Services\Payment\Strategies;

use App\Exceptions\Payment\UnsupportedPaymentTypeException;

/**
 * مصنع استراتيجيات طرق الدفع.
 *
 * هذا الكلاس مسؤول عن إنشاء الاستراتيجية المناسبة لطريقة الدفع المطلوبة
 * بناءً على نوع الدفع (مثل creditcard أو stcpay).
 *
 * مثال استخدام:
 * $strategy = PaymentMethodStrategyFactory::make('creditcard');
 */
final class PaymentMethodStrategyFactory
{
    /**
     * إنشاء استراتيجية طريقة الدفع المناسبة حسب النوع.
     *
     * @param string|null $type نوع طريقة الدفع (مثال: creditcard, stcpay).
     * @return PaymentMethodStrategy كائن الاستراتيجية المناسب.
     * @throws UnsupportedPaymentTypeException إذا كان النوع غير مدعوم.
     */
    public static function make(?string $type): PaymentMethodStrategy
    {
        $normalized = strtolower((string) $type);
        return match ($normalized) {
            'creditcard' => new CreditCardPaymentStrategy(),
            'stcpay' => new StcPayPaymentStrategy(),
            default => throw new UnsupportedPaymentTypeException('نوع الدفع غير مدعوم.'),
        };
    }
}
