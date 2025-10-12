<?php

declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class LibraryStatus extends Enum
{
    const Draft = 'draft';
    const Published = 'published';
    const Archived = 'archived';

    public static function getDescription($value): string
    {
        return match ($value) {
            self::Draft => 'مسودة',
            self::Published => 'منشور',
            self::Archived => 'مؤرشف',
            default => self::getKey($value),
        };
    }

    public function label($locale = null): string
    {
        return __("enums.library_status.{$this->value}", [], $locale);
    }


    public function color(): string
    {
        return match ($this->value) {
            self::Draft => 'gray',
            self::Published => 'green',
            self::Archived => 'red',
            default => 'gray',
        };
    }
}
