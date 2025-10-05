<?php

namespace App\Exceptions\Payment;

use Exception;

/**
 * استثناء عند محاولة استخدام نوع دفع غير مدعوم.
 *
 * يُستخدم هذا الاستثناء عند تمرير نوع دفع غير معروف أو غير مدعوم للنظام.
 */
class UnsupportedPaymentTypeException extends Exception
{
    /**
     * منشئ الاستثناء.
     *
     * @param string $message رسالة الخطأ (افتراضي: فارغ).
     * @param int $code كود الخطأ (افتراضي: 400).
     * @param \Throwable|null $previous استثناء سابق (اختياري).
     */
    public function __construct(string $message = "", int $code = 400, \Throwable|null $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}
