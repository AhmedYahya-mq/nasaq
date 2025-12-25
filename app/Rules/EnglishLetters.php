<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class EnglishLetters implements ValidationRule
{
    /**
     * Validate the attribute.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!is_string($value)) {
            $fail(__('validation.english_letters'));
            return;
        }

        $trimmed = trim($value);
        if ($trimmed === '') {
            $fail(__('validation.english_letters'));
            return;
        }

        // Allow English letters (A-Z, a-z) and spaces only
        if (!preg_match('/^[A-Za-z\s]+$/', $trimmed)) {
            $fail(__('validation.english_letters'));
        }
    }
}
