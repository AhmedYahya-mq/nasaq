<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Storage;

class ValidUploadedFile implements ValidationRule
{
    protected array $allowedMimes;
    protected int $maxSize; // بالكيلوبايت

    public function __construct(array $allowedMimes = ['jpg','png','jpeg','pdf'], int $maxSize = 5120)
    {
        $this->allowedMimes = $allowedMimes;
        $this->maxSize = $maxSize;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $disk = 'local';
        $basePath = 'temp_files';
        $fullPath = $basePath . '/' . $value;

        // تحقق من وجود الملف
        if (!Storage::disk($disk)->exists($fullPath)) {
            $fail(__('validation.file')); // رسالة "الملف يجب أن يكون ملف."
            return;
        }

        // تحقق من نوع الملف (امتداد)
        $extension = pathinfo($fullPath, PATHINFO_EXTENSION);
        if (!in_array(strtolower($extension), $this->allowedMimes)) {
            $fail(__('validation.mimes', ['attribute' => $attribute, 'values' => implode(',', $this->allowedMimes)]));
            return;
        }

        // تحقق من الحجم
        $sizeKB = Storage::disk($disk)->size($fullPath) / 1024;
        if ($sizeKB > $this->maxSize) {
            $fail(__('validation.max.file', ['attribute' => $attribute, 'max' => $this->maxSize]));
            return;
        }
    }
}
