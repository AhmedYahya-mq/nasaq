<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Upcoming()
 * @method static static Ongoing()
 * @method static static Completed()
 * @method static static Cancelled()
 */
final class EventStatus extends Enum
{
    const Upcoming = 'upcoming';
    const Ongoing = 'ongoing';
    const Completed = 'completed';
    const Cancelled = 'cancelled';

    public function label($locale= null): string
    {
        return __("enums.event_status.{$this->value}", [], $locale);
    }

    public function description($locale=null): string
    {
        return __("enums.event_status_message.{$this->value}", [], $locale);
    }

    public function color(): string
    {
        return match($this->value) {
            self::Upcoming => 'blue',
            self::Ongoing => 'green',
            self::Completed => 'gray',
            self::Cancelled => 'red',
            default => 'gray',
        };
    }

    public function icon(){
        return match($this->value) {
            self::Upcoming => 'clock',
            self::Ongoing => 'play',
            self::Completed => 'check',
            self::Cancelled => 'x',
            default => 'question',
        };
    }

    public function isUpcoming(): bool
    {
        return $this->value === self::Upcoming;
    }

    public function isOngoing(): bool
    {
        return $this->value === self::Ongoing;
    }

    public function isCompleted(): bool
    {
        return $this->value === self::Completed;
    }

    public function isCancelled(): bool
    {
        return $this->value === self::Cancelled;
    }

}
