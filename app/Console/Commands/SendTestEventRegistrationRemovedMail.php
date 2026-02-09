<?php

namespace App\Console\Commands;

use App\Mail\EventRegistrationRemovedMail;
use App\Models\Event;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendTestEventRegistrationRemovedMail extends Command
{
    protected $signature = 'mail:test-event-registration-removed
        {to : Recipient email address}
        {--event= : Event ID (optional)}
        {--user= : User ID (optional)}';

    protected $description = 'Send a test "event registration removed" email to a recipient address.';

    public function handle(): int
    {
        // Force-enable emails for this explicit test command.
        config(['app.enable_email_notifications' => true]);

        $to = (string) $this->argument('to');
        if (!filter_var($to, FILTER_VALIDATE_EMAIL)) {
            $this->error('Invalid recipient email.');
            return self::FAILURE;
        }

        $eventId = $this->option('event');
        $userId = $this->option('user');

        /** @var Event $event */
        $event = null;
        if ($eventId && is_numeric($eventId) && (int) $eventId > 0) {
            $event = Event::query()->whereKey((int) $eventId)->first();
            if (!$event) {
                $this->error("Event not found: {$eventId}");
                return self::FAILURE;
            }
        } else {
            $event = new Event();
            $event->id = 0;
            $event->title_ar = 'فعالية تجريبية';
            $event->title_en = 'Test Event';
            $event->start_at = now()->addDays(7);
            $event->end_at = now()->addDays(7)->addHours(2);
        }

        /** @var User $user */
        $user = null;
        if ($userId && is_numeric($userId) && (int) $userId > 0) {
            $user = User::query()->whereKey((int) $userId)->first();
            if (!$user) {
                $this->error("User not found: {$userId}");
                return self::FAILURE;
            }
        } else {
            $user = new User();
            $user->id = 0;
            $user->name = 'مستخدم تجريبي';
            $user->email = $to;
        }

        $mailer = (string) (config('mail.default') ?? 'unknown');
        $this->info("Mailer: {$mailer}");

        Mail::to($to)->send(new EventRegistrationRemovedMail($user, $event));

        $this->info("Test email sent to: {$to}");
        return self::SUCCESS;
    }
}
