<?php

declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class LibraryType extends Enum
{
    const Ebook = 'ebook';
    const Audio = 'audio';
    const Video = 'video';
    const Article = 'article';
    const ResearchPaper = 'research_paper';
    const Tutorial = 'tutorial';

    public static function getDescription($value): string
    {
        return match ($value) {
            self::Ebook => 'كتاب إلكتروني',
            self::Audio => 'صوتي',
            self::Video => 'فيديو',
            self::Article => 'مقال',
            self::ResearchPaper => 'ورقة بحثية',
            self::Tutorial => 'دليل تعليمي',
            default => self::getKey($value),
        };
    }

    public function label($locale = null): string
    {
        return __("enums.library_type.{$this->value}", [], $locale);
    }

    public function icon(): string
    {
        return match ($this->value) {
            self::Ebook => $this->value,
            self::Audio => $this->value,
            self::Video => $this->value,
            self::Article => $this->value,
            self::ResearchPaper => $this->value,
            self::Tutorial => $this->value,
            default => 'book',
        };
    }

    public function color(): string
    {
        return match ($this->value) {
            self::Ebook => '#1E90FF',        // أزرق داكن وواضح
            self::Audio => '#8A2BE2',        // أرجواني مشبع
            self::Video => '#FF4500',        // أحمر برتقالي قوي
            self::Article => '#FFA500',      // برتقالي واضح
            self::ResearchPaper => '#32CD32', // أخضر فاتح وواضح
            self::Tutorial => '#4B0082',     // نيلي غامق
            default => '#808080',            // رمادي متوسط
        };
    }

    public static function cases(): array
    {
        return [
            self::Ebook(),
            self::Audio(),
            self::Video(),
            self::Article(),
            self::ResearchPaper(),
            self::Tutorial(),
        ];
    }
}
