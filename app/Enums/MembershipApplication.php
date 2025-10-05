<?php

declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

final class MembershipApplication extends Enum
{
    const Draft = 'draft';
    const Pending = 'pending';
    const Approved = 'approved';
    const Rejected = 'rejected';
    const Cancelled = 'cancelled';

    public static function getDescription($value): string
    {
        return match ($value) {
            self::Draft => 'Draft',
            self::Pending => 'Pending',
            self::Approved => 'Approved',
            self::Rejected => 'Rejected',
            self::Cancelled => 'Cancelled',
            default => parent::getDescription($value),
        };
    }

    public function Holded(): string
    {
        if ($this->isDreft()) {
            return __('enums.membership_application.Holded');
        }
        return '';
    }
    public function label()
    {
        return __('enums.membership_application.' . $this->value);
    }

    public function isDreft(): bool
    {
        return $this->value === self::Draft;
    }
    public function isPending(): bool
    {
        return $this->value === self::Pending;
    }
    public function isApproved(): bool
    {
        return $this->value === self::Approved;
    }
    public function isRejected(): bool
    {
        return $this->value === self::Rejected;
    }
    public function isCancelled(): bool
    {
        return $this->value === self::Cancelled;
    }

    public function getStatusMessage(): string
    {
        // English message
        return __('enums.membership_application_message.' . $this->value, []);
    }

    public function getStatusMessageArabic(): string
    {
        // Arabic message
        return __('enums.membership_application_message.' . $this->value, [], 'ar');
    }

    public function getLabel(): string
    {
        return __('enums.membership_application.' . $this->value, [], 'en');
    }

    public function getLabelArabic(): string
    {
        return __('enums.membership_application.' . $this->value, [], 'ar');
    }

    public function icon(): string
    {
        return match ($this->value) {
            self::Draft => 'file',
            self::Pending => 'hour',
            self::Approved => 'check-circle',
            self::Rejected => 'x-circle',
            self::Cancelled => 'no_symbol_icon',
            default => 'question-circle',
        };
    }

    public function color(): string
    {
        return match ($this->value) {
            self::Draft => 'gray',
            self::Pending => 'yellow',
            self::Approved => 'green',
            self::Rejected => 'red',
            self::Cancelled => 'blue',
            default => 'gray',
        };
    }

    public function getBadgeColors(): array
    {
        return match ($this->value) {
            self::Draft => [
                'background' => '#f0f0f0',
                'color' => '#6c757d',
            ],
            self::Pending => [
                'background' => '#ffe9b3',
                'color' => '#b8860b',
            ],
            self::Approved => [
                'background' => '#d4f7dc',
                'color' => '#218838',
            ],
            self::Rejected => [
                'background' => '#ffd6d6',
                'color' => '#c82333',
            ],
            self::Cancelled => [
                'background' => '#cce5ff',
                'color' => '#004085',
            ],
            default => [
                'background' => '#e3eafc',
                'color' => '#2d3a4a',
            ],
        };
    }
}
