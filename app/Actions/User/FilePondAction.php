<?php

namespace App\Actions\User;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\StreamedResponse;

class FilePondAction
{
    protected string $disk = 'local';
    protected string $basePath = 'temp_files';
    protected string $name = 'file';

    public function __construct(
        $name = 'file',
        $basePath = 'temp_files',
        $disk = 'local'
    ) {
        $this->basePath = $basePath;
        $this->name = $name;
        $this->disk = $disk;
    }

    // رفع الملف مؤقتًا
    public function process($request)
    {
        $file = $request->file($this->name);
        if (!$file || !$file->isValid()) return response('Invalid file', 400);

        // إنشاء مجلد temp_files إذا لم يكن موجود
        if (!Storage::disk($this->disk)->exists($this->basePath)) {
            Storage::disk($this->disk)->makeDirectory($this->basePath, 0755, true);
        }

        $folder = Str::uuid7()->toString();
        $filename = $file->getClientOriginalName();
        $fullPath = $this->basePath . '/' . $folder;

        // إنشاء المجلد الخاص بالرفع إذا لم يكن موجودًا
        if (!Storage::disk($this->disk)->exists($fullPath)) {
            Storage::disk($this->disk)->makeDirectory($fullPath, 0755, true);
        }

        $file->storeAs($fullPath, $filename, $this->disk);

        return response($folder, 200); // FilePond expects unique ID
    }

    // حذف الملف المؤقت
    public function revert($request)
    {
        $folder = $request->getContent();
        $fullPath = $this->basePath . '/' . $folder;
        if ($folder && Storage::disk($this->disk)->exists($fullPath)) {
            Storage::disk($this->disk)->deleteDirectory($fullPath);
        }
        return response('', 200);
    }

    // استعادة الملف المؤقت
    public function restore(string $id)
    {
        $fullPath = $this->basePath . '/' . $id;
        $files = Storage::disk($this->disk)->files($fullPath);
        if (empty($files)) return response('File not found', 404);

        $file = $files[0];
        $absolutePath = Storage::disk('local')->path($file); // المسار الكامل للملف

        return new StreamedResponse(function () use ($absolutePath) {
            $stream = fopen($absolutePath, 'rb');
            fpassthru($stream);
        }, 200, [
            'Content-Type' => mime_content_type($absolutePath),
            'Content-Disposition' => 'inline; filename="' . basename($absolutePath) . '"',
        ]);
    }


    // إزالة الملف
    public function remove($request)
    {
        $source = $request->getContent();
        $fullPath = $this->basePath . '/' . $source;
        if ($source && Storage::disk($this->disk)->exists($fullPath)) {
            Storage::disk($this->disk)->delete($fullPath);
        }
        return response('', 200);
    }
}
