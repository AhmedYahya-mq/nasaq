<?php

declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

final class EmploymentStatus extends Enum
{
    const Student = 'student';
    const Graduate = 'graduate';
    const Licensed = 'licensed';
    const Academic = 'academic';
    const Entrepreneur = 'entrepreneur';
    const Employed = 'employed';      // موظف
    const Unemployed = 'unemployed';  // بدون عمل

    // وصف لكل حالة (إنجليزي)
    public static function getDescription($value): string
    {
        return match ($value) {
            self::Student => __('enums.employment_status.student'),
            self::Graduate => __('enums.employment_status.graduate'),
            self::Licensed => __('enums.employment_status.licensed'),
            self::Academic => __('enums.employment_status.academic'),
            self::Entrepreneur => __('enums.employment_status.entrepreneur'),
            self::Employed => __('enums.employment_status.employed'),
            self::Unemployed => __('enums.employment_status.unemployed'),
            default => parent::getDescription($value),
        };
    }

    // وصف بالعربي
    public function getLabelArabic(): string
    {
        return __('enums.employment_status.' . $this->value, [], 'ar');
    }

    public function getLabel(): string
    {
        return __('enums.employment_status.' . $this->value, [], 'en');
    }

    // لون للواجهة حسب الحالة
    public  function getColor(): string
    {
        return match ($this->value) {
            self::Student => 'yellow-600',
            self::Graduate => 'blue-600',
            self::Licensed => 'green-600',
            self::Academic => 'purple-600',
            self::Entrepreneur => 'red-600',
            self::Employed => 'teal-600',
            self::Unemployed => 'gray-600',
            default => 'gray-600',
        };
    }

    // أيقونة لكل حالة
    public function getIcon(): string
    {
        return match ($this->value) {
            self::Student => 'user-graduate',
            self::Graduate => 'user-tie',
            self::Licensed => 'id-badge',
            self::Academic => 'book',
            self::Entrepreneur => 'briefcase',
            self::Employed => 'building',
            self::Unemployed => 'user-slash',
            default => 'question-circle',
        };
    }


    // key => value array of all statuses
    public static function toKeyValueArray(): array
    {
        return [
            self::Student => self::getDescription(self::Student),
            self::Graduate => self::getDescription(self::Graduate),
            self::Licensed => self::getDescription(self::Licensed),
            self::Academic => self::getDescription(self::Academic),
            self::Entrepreneur => self::getDescription(self::Entrepreneur),
            self::Employed => self::getDescription(self::Employed),
            self::Unemployed => self::getDescription(self::Unemployed),
        ];
    }
}
