<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CardExpirationYear implements ValidationRule
{
    protected ?int $month;

    public function __construct(?int $month = null)
    {
        $this->month = $month;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!is_numeric($value)) {
            $fail('سنة انتهاء البطاقة غير صالحة.');
            return;
        }

        $year = (int) $value;
        if (strlen((string)$value) === 2) {
            $year = (int) ('20' . str_pad((string)$value, 2, '0', STR_PAD_LEFT));
        }

        $currentYear = (int) date('Y');
        $currentMonth = (int) date('n');

        if ($year < $currentYear) {
            $fail('سنة انتهاء البطاقة غير صالحة.');
            return;
        }

        if ($year > $currentYear + 20) {
            $fail('سنة انتهاء البطاقة بعيدة جدًا.');
            return;
        }

        if ($this->month && $year === $currentYear && $this->month < $currentMonth) {
            $fail('سنة انتهاء البطاقة غير صالحة.');
            return;
        }
    }
}
