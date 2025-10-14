<?php

namespace App\Listeners;

use App\Events\PaymentStatusUpdated;
use App\Mail\PaymentInvoiceMail;
use Illuminate\Support\Facades\Mail;

class SendPaymentNotificationEmail
{
    public function handle(PaymentStatusUpdated $event): void
    {
        $payment = $event->payment;

        // تحقق أن الحالة أصبحت مدفوعة
        if ($payment->status->isPaid() && config('app.enable_email_notifications')) {
            $adminEmail = env('CONTACT_EMAIL');
            if ($adminEmail) {
                Mail::to($adminEmail)->queue(new PaymentInvoiceMail($payment));
            }
        }
    }
}
