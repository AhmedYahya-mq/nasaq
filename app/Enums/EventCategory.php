<?php

declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Workshop()
 * @method static static Seminar()
 * @method static static Lecture()
 * @method static static QandASession()
 * @method static static FieldVisit()
 */
final class EventCategory extends Enum
{
    const Workshop = 'Workshop';
    const Seminar = 'Seminar';
    const Lecture = 'Lecture';
    const QandASession = 'Q&A Session';
    const FieldVisit = 'Field Visit';

    public function label($locale = null): string
    {
        return __("enums.event_category.{$this->value}", [], $locale);
    }

    public function description($locale = null): string
    {
        return __("enums.event_category_message.{$this->value}", [], $locale);
    }

    public function color(): string
    {
        return match ($this->value) {
            self::Workshop      => '#3B82F6', // sky-500 — أزرق واضح ومريح
            self::Seminar       => '#10B981', // emerald-500 — أخضر متوازن وواضح
            self::Lecture       => '#8B5CF6', // violet-500 — بنفسجي أنيق وواضح
            self::QandASession  => '#F59E0B', // amber-500 — ذهبي/برتقالي ملفت
            self::FieldVisit    => '#06B6D4', // cyan-500 — أزرق سماوي مشرق
            default             => '#6B7280', // gray-500 — رمادي متوازن
        };
    }

    public function icon()
    {
        return match ($this->value) {
            self::Workshop => 'tools',
            self::Seminar => 'users',
            self::Lecture => 'book',
            self::QandASession => 'question',
            self::FieldVisit => 'map',
            default => 'question',
        };
    }

    public function isWorkshop(): bool
    {
        return $this->value === self::Workshop;
    }

    public function isSeminar(): bool
    {
        return $this->value === self::Seminar;
    }

    public function isLecture(): bool
    {
        return $this->value === self::Lecture;
    }

    public function isQandASession(): bool
    {
        return $this->value === self::QandASession;
    }

    public function isFieldVisit(): bool
    {
        return $this->value === self::FieldVisit;
    }
}
