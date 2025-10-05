<?php

namespace App\Services\Payment\Strategies;

use App\DTOs\Payment\PaymentPayloadDTO;

/**
 * استراتيجية الدفع باستخدام البطاقة الائتمانية.
 *
 * هذا الكلاس يطبق واجهة PaymentMethodStrategy ويستخدم لإضافة معلومات البطاقة الائتمانية
 * إلى كائن الدفع (PaymentPayloadDTO) عند إنشاء عملية دفع جديدة.
 *
 * مثال استخدام:
 * $strategy = new CreditCardPaymentStrategy();
 * $payload = $strategy->apply($payload, $input);
 */
final class CreditCardPaymentStrategy implements PaymentMethodStrategy
{
    /**
     * تطبيق معلومات البطاقة الائتمانية على كائن الدفع.
     *
     * @param PaymentPayloadDTO $payload كائن بيانات الدفع الأساسي.
     * @param array $input بيانات الإدخال التي تحتوي على معلومات البطاقة.
     *   - name: اسم حامل البطاقة.
     *   - cc_number: رقم البطاقة.
     *   - cc_exp_month: شهر انتهاء الصلاحية.
     *   - cc_exp_year: سنة انتهاء الصلاحية.
     *   - cvc: رمز التحقق.
     * @return PaymentPayloadDTO كائن الدفع بعد إضافة معلومات البطاقة.
     */
    public function apply(PaymentPayloadDTO $payload, array $input): PaymentPayloadDTO
    {
        return $payload->withSource([
            'type' => 'creditcard',
            'name' => $input['name'] ?? '',
            'number' => $input['cc_number'] ?? '',
            'month' => $input['cc_exp_month'] ?? '',
            'year' => $input['cc_exp_year'] ?? '',
            'cvc' => $input['cvc'] ?? '',
        ]);
    }
}
