<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ArabicLetters implements ValidationRule
{
    /**
     * Validate the attribute.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!is_string($value)) {
            $fail(__('validation.arabic_letters'));
            return;
        }

        $trimmed = trim($value);
        if ($trimmed === '') {
            $fail(__('validation.arabic_letters'));
            return;
        }

        // Allow Arabic letters and spaces only
        if (!preg_match('/^[\p{Arabic}\s]+$/u', $trimmed)) {
            $fail(__('validation.arabic_letters'));
        }
    }
}
