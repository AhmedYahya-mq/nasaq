<?php

namespace App\Mail;

use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentInvoiceMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $payment;
    public $payable;

    /**
     * Create a new message instance.
     */
    public function __construct(Payment $payment)
    {
        $this->payment = $payment;
        $this->payable = $payment->payable;
    }


    /**
     * Build the message.
     */
    public function build()
    {
        // إذا كان إرسال البريد معطلاً، لا ترسل شيء
        if (!config('app.enable_email_notifications')) {
            return $this;
        }

        return $this->subject('إشعار دفع جديد - ' . config('app.name'))
            ->view('emails.payment_invoice')
            ->with([
                'payment' => $this->payment,
                'payable' => $this->payable,
            ]);
    }
}
