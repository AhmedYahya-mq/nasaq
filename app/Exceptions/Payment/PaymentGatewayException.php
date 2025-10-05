<?php

namespace App\Exceptions\Payment;

use Exception;

/**
 * استثناء عند حدوث خطأ في بوابة الدفع.
 *
 * يُستخدم هذا الاستثناء عند فشل الاتصال أو التعامل مع بوابة الدفع الخارجية.
 */
class PaymentGatewayException extends Exception
{
    /**
     * منشئ الاستثناء.
     *
     * @param string $message رسالة الخطأ (افتراضي: فارغ).
     * @param int $code كود الخطأ (افتراضي: 500).
     * @param \Throwable|null $previous استثناء سابق (اختياري).
     */
    public function __construct(string $message = "", int $code = 500, \Throwable|null $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}
