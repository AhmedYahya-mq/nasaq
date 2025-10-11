<?php declare(strict_types=1);

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
    const Article= 'article';
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
            self::Ebook => 'book',
            self::Audio => 'headphones',
            self::Video => 'video-camera',
            self::Article => 'file-text',
            self::ResearchPaper => 'file-search',
            self::Tutorial => 'graduation-cap',
            default => 'book',
        };
    }

    public function color(): string
    {
        return match ($this->value) {
            self::Ebook => 'blue',
            self::Audio => 'purple',
            self::Video => 'red',
            self::Article => 'yellow',
            self::ResearchPaper => 'green',
            self::Tutorial => 'indigo',
            default => 'gray',
        };
    }

}
