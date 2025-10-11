<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPasswordNotification extends Notification
{
    use Queueable;

    public $token;

    /**
     * Create a new notification instance.
     *
     * @param string $token
     */
    public function __construct($token)
    {
        $this->token = $token;
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
        $url = $notifiable instanceof \App\Models\Admin
        ? route('admin.password.reset', [  'token' => $this->token,'email' => $notifiable->email])
        : route('password.reset', [  'token' => $this->token,'email' => $notifiable->email]);
        // استخدام قالب HTML مخصص للرسالة
        return (new MailMessage)
            ->subject('إعادة تعيين كلمة المرور')
            ->view('emails.reset-password', ['url' => $url]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
