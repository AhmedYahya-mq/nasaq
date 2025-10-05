<?php

namespace App\Exceptions\Payment;

use Exception;
use Throwable;

/**
 * استثناء عند عدم العثور على العنصر القابل للدفع.
 *
 * يُستخدم هذا الاستثناء عند محاولة تنفيذ عملية دفع على عنصر غير موجود.
 */
class PaymentCallbackException extends Exception
{
    /**
     * منشئ الاستثناء.
     *
     * @param string $message رسالة الخطأ (افتراضي: فارغ).
     * @param int $code كود الخطأ (افتراضي: 404).
     * @param Throwable|null $previous استثناء سابق (اختياري).
     */
    public function __construct(string $message = "", int $code = 404, Throwable|null $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}
