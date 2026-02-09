<?php

namespace App\Console\Commands;

use App\Mail\EventRegistrationRemovedMail;
use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class CleanupUnpaidEventRegistrations extends Command
{
    protected $signature = 'events:cleanup-unpaid-registrations
        {--event= : Event ID}
        {--users= : Comma-separated user IDs to check and cleanup}';

    protected $description = 'Remove event registrations for specific users when no paid purchase exists for that event, then email a formal notice.';

    public function handle(): int
    {
        $eventId = $this->option('event');
        if (!$eventId || !is_numeric($eventId) || (int) $eventId <= 0) {
            $this->error('Missing/invalid --event. Example: --event=123');
            return self::FAILURE;
        }

        $usersOption = (string) ($this->option('users') ?? '');
        $userIds = collect(explode(',', $usersOption))
            ->map(fn ($v) => (int) trim((string) $v))
            ->filter(fn ($v) => $v > 0)
            ->unique()
            ->values();

        if ($userIds->isEmpty()) {
            $this->error('Missing/invalid --users. Example: --users=10,11,12');
            return self::FAILURE;
        }

        /** @var Event|null $event */
        $event = Event::query()->whereKey((int) $eventId)->first();
        if (!$event) {
            $this->error("Event not found: {$eventId}");
            return self::FAILURE;
        }

        $this->info('Event: ' . ($event->title_ar ?? $event->title_en ?? ('#' . $event->id)));
        $this->info('Users provided: ' . $userIds->join(', '));

        $summary = [
            'checked' => 0,
            'skipped_free' => 0,
            'skipped_paid' => 0,
            'not_registered' => 0,
            'removed' => 0,
            'emailed' => 0,
            'email_failed' => 0,
        ];

        foreach ($userIds as $userId) {
            $summary['checked']++;

            /** @var User|null $user */
            $user = User::query()->whereKey((int) $userId)->first();
            if (!$user) {
                $this->warn("User not found: {$userId}");
                continue;
            }

            /** @var EventRegistration|null $registration */
            $registration = EventRegistration::query()
                ->where('event_id', $event->id)
                ->where('user_id', $user->id)
                ->first();

            if (!$registration) {
                $summary['not_registered']++;
                $this->line("- User {$user->id}: not registered");
                continue;
            }

            // If the event is currently free for this user, do not remove registration.
            if ($event->isFreeForUser($user)) {
                $summary['skipped_free']++;
                $this->line("- User {$user->id}: skipped (event is free for this user)");
                continue;
            }

            $paidPurchase = Payment::findPaidPurchaseForUserPayable($user->id, $event);
            if ($paidPurchase) {
                $summary['skipped_paid']++;
                $this->line("- User {$user->id}: skipped (paid purchase exists: {$paidPurchase->invoice_id})");
                continue;
            }

            DB::transaction(function () use ($registration) {
                $registration->delete();
            });

            $summary['removed']++;
            $this->line("- User {$user->id}: registration removed");

            try {
                Mail::to($user->email)->send(new EventRegistrationRemovedMail($user, $event));
                $summary['emailed']++;
            } catch (\Throwable $e) {
                $summary['email_failed']++;
                $this->warn("  Email failed for user {$user->id}: {$e->getMessage()}");
            }
        }

        $this->newLine();
        $this->info('Summary:');
        foreach ($summary as $k => $v) {
            $this->line("- {$k}: {$v}");
        }

        return self::SUCCESS;
    }
}
