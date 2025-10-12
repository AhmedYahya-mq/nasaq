<?php

namespace App\Notifications;

use App\Models\MembershipApplication;
use App\Enums\MembershipApplication as EnumsMembershipApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class UserRequestStatusNotification extends Notification
{
    use Queueable;

    protected MembershipApplication $application;

    public function __construct(MembershipApplication $application)
    {
        $this->application = $application;
    }

    public function via($notifiable)
    {
        if (!config('app.enable_email_notifications')) {
            return [];
        }
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $status = $this->application->status;

        return (new MailMessage)
            ->subject('حالة طلبك للانضمام إلى المجتمع')
            ->view('emails.user_request_status', [
                'user' => $this->application->user,
                'status' => $status,
                'status_message' => $status->getStatusMessage(),
                'admin_notes' => $this->application->admin_notes,
                'submitted_at' => $this->application->submitted_at,
                'community_logo' => 'https://lightskyblue-shrew-209906.hostingersite.com/favicon.ico', // رابط الشعار
            ]);
    }
}
