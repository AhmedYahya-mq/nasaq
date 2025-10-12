<?php

declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;
use Illuminate\Contracts\Container\BindingResolutionException;

final class MembershipStatus extends Enum
{
    const None = 'none';
    const Active = 'active';
    const Expired = 'expired';

    public function isNone(): bool
    {
        return $this->value === self::None;
    }

    public static function getDescription($value): string
    {
        return match ($value) {
            self::None => 'No Membership',
            self::Active => 'Active Membership',
            self::Expired => 'Expired Membership',
            default => parent::getDescription($value),
        };
    }
    /**
     *  جلب الحالة بحسب اللغة المخزنه في appLocale
     * وبستخدم نفس التابع لجلب الرسالة
     * @return string
     * @throws BindingResolutionException
     */
    public function label(): string
    {
        $appLocale = app()->getLocale();
        return __('enums.membership_status.' . $this->value, [], $appLocale);
    }

    public function getStatusMessage(): string
    {
        // English message
        return __('enums.membership_status_message.' . $this->value, []);
    }

    public function getStatusMessageArabic(): string
    {
        // Arabic message
        return __('enums.membership_status_message.' . $this->value, [], 'ar');
    }

    public function getLabel(): string
    {
        return __('enums.membership_status.' . $this->value, [], 'en');
    }

    public function getLabelArabic(): string
    {
        return __('enums.membership_status.' . $this->value, [], 'ar');
    }

    public function getIcon(): string
    {
        return match ($this->value) {
            self::None => 'user-slash',
            self::Active => 'check-circle',
            self::Expired => 'exclamation-circle',
            default => 'question-circle',
        };
    }

    public function getColor(): string
    {
        return match ($this->value) {
            self::Active => 'green',
            self::Expired => 'red',
            default => 'blue',
        };
    }
}
