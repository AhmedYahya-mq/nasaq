<?php

namespace App\Console\Commands;

use App\Enums\EventStatus;
use Illuminate\Console\Command;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class UpdateEventStatuses extends Command
{
    protected $signature = 'events:update-statuses';
    protected $description = 'Update event statuses based on start and end times';

    public function handle()
    {
        $now = Carbon::now();

        $activated = Event::where('event_status', EventStatus::Upcoming)
            ->where('start_at', '<=', $now)
            ->update(['event_status' => EventStatus::Ongoing]);
        return Command::SUCCESS;
    }
}
