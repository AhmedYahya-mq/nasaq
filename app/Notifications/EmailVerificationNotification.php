<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EmailVerificationNotification extends Notification
{
    use Queueable;
    public $token;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        if (!config('app.enable_email_notifications')) {
            return [];
        }
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        // بناء رابط إعادة تعيين كلمة المرور باستخدام الرمز المميز
        $url = $this->verificationUrl($notifiable);
        // استخدام قالب HTML مخصص للرسالة
        return (new MailMessage)
            ->subject('التحقق من عنوان البريد الإلكتروني')  // عنوان الرسالة
            ->view('emails.verify-email', ['url' => $url]);  // استخدام العرض المخصص وتمرير الرابط
    }

    protected function verificationUrl($notifiable)
    {
        $guard = $notifiable instanceof \App\Models\Admin ? "admin.":"";
        return \Illuminate\Support\Facades\URL::temporarySignedRoute(
            $guard.'verification.verify',
            Carbon::now()->addMinutes(60),
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]
        );
    }
}
