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
        $files = $request->file($this->name);

        if (!$files) return response('Invalid file', 400);

        // إذا كان ملف واحد فقط، نحوله لمصفوفة مؤقتًا
        $singleFile = false;
        if (!is_array($files)) {
            $files = [$files];
            $singleFile = true;
        }

        $storedFiles = [];

        foreach ($files as $file) {
            if (!$file || !$file->isValid()) continue;

            if (!Storage::disk($this->disk)->exists($this->basePath)) {
                Storage::disk($this->disk)->makeDirectory($this->basePath, 0755, true);
            }

            $uuidFilename = Str::uuid7()->toString() . '.' . $file->getClientOriginalExtension();
            $file->storeAs($this->basePath, $uuidFilename, $this->disk);

            $storedFiles[] = $uuidFilename;
        }
        // إذا كان إدخال ملف واحد فقط، نعيد العنصر بدل مصفوفة
        return response($storedFiles[0], 200);
    }


    // حذف الملف المؤقت
    public function revert($request)
    {
        $filename = $request->getContent();
        $fullPath = $this->basePath . '/' . $filename;

        if ($filename && Storage::disk($this->disk)->exists($fullPath)) {
            Storage::disk($this->disk)->delete($fullPath);
        }

        return response('', 200);
    }

    // استعادة الملف المؤقت
    public function restore(string $filename)
    {
        $fullPath = $this->basePath . '/' . $filename;

        if (!Storage::disk($this->disk)->exists($fullPath)) {
            return response('File not found', 404);
        }

        $absolutePath = Storage::disk($this->disk)->path($fullPath);

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
        $filename = $request->getContent();
        $fullPath = $this->basePath . '/' . $filename;

        if ($filename && Storage::disk($this->disk)->exists($fullPath)) {
            Storage::disk($this->disk)->delete($fullPath);
        }

        return response('', 200);
    }



    /**
     * نقل الملفات من temp_files إلى public folder
     *
     * @param array|string $filenames أسماء الملفات (يمكن مصفوفة أو ملف واحد)
     * @param string $destinationFolder اسم المجلد الوجهة داخل public
     * @return array مصفوفة كائنات تحتوي على file_name, file_path, file_type
     */
    public function moveToPublic(array|string $filenames, string $destinationFolder = 'uploads'): array
    {
        $filenames = is_array($filenames) ? $filenames : [$filenames];

        $movedFiles = [];
        $sourceDisk = $this->disk; // عادة 'local'
        $targetDisk = 'public';
        $publicPath = trim($destinationFolder, '/');

        // إنشاء مجلد الوجهة داخل public إذا لم يكن موجود
        if (!Storage::disk($targetDisk)->exists($publicPath)) {
            Storage::disk($targetDisk)->makeDirectory($publicPath, 0755, true);
        }

        foreach ($filenames as $file) {
            $sourcePath = $this->basePath . '/' . $file;
            $destinationPath = $publicPath . '/' . $file;

            if (Storage::disk($sourceDisk)->exists($sourcePath)) {
                // نسخ الملف من local إلى public
                Storage::disk($targetDisk)->put(
                    $destinationPath,
                    Storage::disk($sourceDisk)->get($sourcePath)
                );

                // حذف الملف من local بعد النسخ
                Storage::disk($sourceDisk)->delete($sourcePath);

                // إنشاء كائن الملف النهائي
                $fileObject = new \stdClass();
                $fileObject->file_name = pathinfo($file, PATHINFO_BASENAME);
                $fileObject->file_path = Storage::url($destinationPath);
                $fileObject->file_type = mime_content_type(Storage::disk($targetDisk)->path($destinationPath));

                $movedFiles[] = $fileObject;
            }
        }

        return $movedFiles;
    }
}
