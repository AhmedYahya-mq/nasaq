<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Virtual()
 * @method static static Physical()
 */
final class EventType extends Enum
{
    const Virtual = 'virtual';
    const Physical = 'physical';

    public function label($locale= null): string
    {
        return __("enums.event_type.{$this->value}", [], $locale);
    }

    public function description($locale=null): string
    {
        return __("enums.event_type_message.{$this->value}", [], $locale);
    }

    public function isVirtual(): bool
    {
        return $this->value === self::Virtual;
    }
    public function isPhysical(): bool
    {
        return $this->value === self::Physical;
    }

    public function color(): string
    {
        return match($this->value) {
            self::Virtual => 'purple',
            self::Physical => 'blue',
            default => 'gray',
        };
    }

    public function icon(): string
    {
        return match($this->value) {
            self::Virtual => 'ph:computer-tower-bold',
            self::Physical => 'map-pin',
            default => 'ph:question-bold',
        };
    }
}
