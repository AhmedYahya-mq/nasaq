<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CardCvc implements ValidationRule
{
    protected ?string $brand;

    public function __construct(?string $brand = null)
    {
        $this->brand = $brand;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!ctype_digit((string)$value)) {
            $fail('رمز التحقق CVC غير صالح.');
            return;
        }

        $length = strlen((string)$value);

        if ($this->brand === 'amex' && $length !== 4) {
            $fail('رمز التحقق CVC لبطاقة أمريكان إكسبرس يجب أن يكون 4 أرقام.');
            return;
        }

        if ($this->brand !== 'amex' && !in_array($length, [3,4])) {
            $fail('رمز التحقق CVC غير صالح.');
            return;
        }
    }
}
