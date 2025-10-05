<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\MembershipFile;
use Illuminate\Support\Facades\Storage;
class MembershipFileFactory extends Factory
{
    protected $model = MembershipFile::class;


    public function definition(): array
    {
        $sourceFolder = storage_path('app/public/fake_files');

        // يختار ملف عشوائي من المجلد
        $files = glob($sourceFolder . '/*'); // جميع الملفات
        $randomFile = $files[array_rand($files)];

        // نسخ الملف إلى مجلد membership_files
        $fileName = basename($randomFile);
        $destPath = 'membership_files/' . $fileName;
        Storage::disk('public')->putFileAs('membership_files', $randomFile, $fileName);

        // نوع الملف بناءً على امتداد
        $extension = pathinfo($fileName, PATHINFO_EXTENSION);
        $mime = match ($extension) {
            'jpg', 'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'pdf' => 'application/pdf',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            default => 'application/octet-stream',
        };

        return [
            'file_name' => $fileName,
            'file_path' => $destPath,
            'file_type' => $mime,
        ];
    }
}
