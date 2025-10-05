<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CardExpirationMonth implements ValidationRule
{
    protected ?int $year;

    public function __construct(?int $year = null)
    {
        $this->year = $year;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!is_numeric($value)) {
            $fail('شهر انتهاء البطاقة غير صالح.');
            return;
        }

        $month = (int) $value;
        if ($month < 1 || $month > 12) {
            $fail('شهر انتهاء البطاقة غير صالح.');
            return;
        }

        if ($this->year) {
            $currentYear = (int) date('Y');
            $currentMonth = (int) date('n');

            if ($this->year < $currentYear) {
                $fail('تاريخ انتهاء البطاقة قديم.');
                return;
            }

            if ($this->year == $currentYear && $month < $currentMonth) {
                $fail('تاريخ انتهاء البطاقة قديم.');
                return;
            }
        }
    }
}
