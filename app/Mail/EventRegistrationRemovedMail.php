<?php

namespace App\Mail;

use App\Models\Event;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EventRegistrationRemovedMail extends Mailable
{
    use Queueable, SerializesModels;

    public User $user;
    public Event $event;

    public function __construct(User $user, Event $event)
    {
        $this->user = $user;
        $this->event = $event;
    }

    public function build()
    {
        if (!config('app.enable_email_notifications')) {
            return $this;
        }

        $eventTitle = $this->event->title_ar ?? $this->event->title_en ?? ('فعالية #' . $this->event->id);

        return $this
            ->subject('تنبيه مهم: إلغاء تسجيل فعالية (' . $eventTitle . ') - ' . config('app.name'))
            ->view('emails.event_registration_removed')
            ->with([
                'user' => $this->user,
                'event' => $this->event,
                'eventTitle' => $eventTitle,
            ]);
    }
}
