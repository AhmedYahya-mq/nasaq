<?php

namespace App\Services\Payment\Strategies;

use App\DTOs\Payment\PaymentPayloadDTO;

/**
 * واجهة استراتيجية طرق الدفع.
 *
 * يجب على كل استراتيجية دفع أن تطبق هذه الواجهة وتوفر دالة apply.
 */
interface PaymentMethodStrategy
{
    /**
     * تطبيق معلومات طريقة الدفع على كائن الدفع.
     *
     * @param PaymentPayloadDTO $payload كائن بيانات الدفع الأساسي.
     * @param array $input بيانات الإدخال الخاصة بطريقة الدفع.
     * @return PaymentPayloadDTO كائن الدفع بعد إضافة معلومات الطريقة.
     */
    public function apply(PaymentPayloadDTO $payload, array $input): PaymentPayloadDTO;
}
