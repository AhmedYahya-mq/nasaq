<?php

declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;
use Illuminate\Contracts\Container\BindingResolutionException;

/** @package App\Enums */
final class PaymentStatus extends Enum
{
    const Initiated = 'initiated';
    const Paid      = 'paid';
    const Failed    = 'failed';
    const Refunded  = 'refunded';
    const Cancelled = 'cancelled';
    public static function tryFrom(string $value): ?self
    {
        $value = strtolower($value);
        return match ($value) {
            self::Initiated => new self(self::Initiated),
            self::Paid      => new self(self::Paid),
            self::Failed    => new self(self::Failed),
            self::Refunded  => new self(self::Refunded),
            self::Cancelled => new self(self::Cancelled),
            default         => null,
        };
    }

    public static function getDescription($value): string
    {
        return match ($value) {
            self::Initiated => 'Initiated',
            self::Paid      => 'Paid',
            self::Failed    => 'Failed',
            self::Refunded  => 'Refunded',
            self::Cancelled => 'Cancelled',
            default         => parent::getDescription($value),
        };
    }

    /**
     * @param string|null $locale
     * @return string
     * @throws BindingResolutionException
     */
    public function label($locale = null): string
    {
        return __('enums.payment_status.' . $this->value, [], $locale);
    }

    public function isInitiated(): bool
    {
        return $this->value === self::Initiated;
    }

    public function isPaid(): bool
    {
        return $this->value === self::Paid;
    }

    public function isFailed(): bool
    {
        return $this->value === self::Failed;
    }

    public function isRefunded(): bool
    {
        return $this->value === self::Refunded;
    }

    public function isCancelled(): bool
    {
        return $this->value === self::Cancelled;
    }

    public function icon(): string
    {
        return match ($this->value) {
            self::Initiated => 'hourglass',
            self::Paid      => 'check-circle',
            self::Failed    => 'x-circle',
            self::Refunded  => 'refresh-cw',
            self::Cancelled => 'slash',
            default         => 'question-circle',
        };
    }

    public function color(): string
    {
        return match ($this->value) {
            self::Initiated => 'yellow',
            self::Paid      => 'green',
            self::Failed    => 'red',
            self::Refunded  => 'blue',
            self::Cancelled => 'gray',
            default         => 'gray',
        };
    }

    public function badget(): array
    {
        return match ($this->value) {
            self::Initiated => [
                'background' => '#fff3cd',
                'color' => '#856404',
            ],
            self::Paid => [
                'background' => '#d4f7dc',
                'color' => '#218838',
            ],
            self::Failed => [
                'background' => '#f8d7da',
                'color' => '#721c24',
            ],
            self::Refunded => [
                'background' => '#cce5ff',
                'color' => '#004085',
            ],
            self::Cancelled => [
                'background' => '#e2e3e5',
                'color' => '#383d41',
            ],
            default => [
                'background' => '#e3eafc',
                'color' => '#2d3a4a',
            ],
        };
    }
}
