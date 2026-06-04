<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Storage;

class LibraryRole implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Accept both 'library/' and 'private/library/' prefixes.
        if (!str_starts_with($value, 'library/') && !str_starts_with($value, 'private/library/')) {
            $fail("يجب أن يحتوي على مسار صحيح داخل مجلد المكتبة (library/ أو private/library/).");
            return;
        }

        // Try multiple candidate locations to be tolerant of existing files.
        $candidates = [$value];
        if (str_starts_with($value, 'library/')) {
            $candidates[] = 'private/' . $value;
        } elseif (str_starts_with($value, 'private/library/')) {
            $candidates[] = preg_replace('#^private/#', '', $value, 1);
        }

        foreach ($candidates as $candidate) {
            $filePath = Storage::disk('local')->path($candidate);
            if (file_exists($filePath)) {
                // found a valid file
                return;
            }
        }

        $fail("الملف المحدد في غير موجود داخل مجلد التخزين الخاص.");
        return;
    }
}
