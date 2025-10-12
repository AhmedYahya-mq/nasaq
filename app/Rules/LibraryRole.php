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
        if (!str_starts_with($value, 'library/')) {
            $fail("يجب أن يحتوي على مسار صحيح داخل مجلد المكتبة (library/).");
            return;
        }

        $filePath = Storage::disk('local')->path($value);

        // التحقق من وجود الملف فعلياً
        if (!file_exists($filePath)) {
            $fail("الملف المحدد في غير موجود داخل مجلد التخزين الخاص.");
            return;
        }
    }
}
