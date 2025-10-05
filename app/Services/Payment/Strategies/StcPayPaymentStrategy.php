<?php

namespace App\Services\Payment\Strategies;

use App\DTOs\Payment\PaymentPayloadDTO;

/**
 * استراتيجية الدفع باستخدام STC Pay.
 *
 * هذا الكلاس يطبق واجهة PaymentMethodStrategy ويستخدم لإضافة معلومات STC Pay
 * إلى كائن الدفع (PaymentPayloadDTO) عند إنشاء عملية دفع جديدة.
 *
 * مثال استخدام:
 * $strategy = new StcPayPaymentStrategy();
 * $payload = $strategy->apply($payload, $input);
 */
final class StcPayPaymentStrategy implements PaymentMethodStrategy
{
    /**
     * تطبيق معلومات STC Pay على كائن الدفع.
     *
     * @param PaymentPayloadDTO $payload كائن بيانات الدفع الأساسي.
     * @param array $input بيانات الإدخال التي تحتوي على رقم الجوال.
     *   - phone: رقم الجوال المرتبط بحساب STC Pay.
     * @return PaymentPayloadDTO كائن الدفع بعد إضافة معلومات STC Pay.
     */
    public function apply(PaymentPayloadDTO $payload, array $input): PaymentPayloadDTO
    {
        return $payload->withSource([
            'type' => 'stcpay',
            'mobile' => $input['phone'] ?? '',
        ]);
    }
}
