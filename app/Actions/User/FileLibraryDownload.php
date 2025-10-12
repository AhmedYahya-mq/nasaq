<?php

namespace App\Actions\User;

use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Facades\Storage;
use App\Models\Library;

/** @package App\Actions\User */
class FileLibraryDownload implements \App\Contract\Actions\FileLibraryDownload
{
    protected $disk = 'local';
    protected $chunkSize = 5 * 1024 * 1024; // 5 ميجا لكل Chunk

    /**
     * ✅ الدالة العامة التي يستدعيها الكنترولر
     */
    public function download($file): StreamedResponse
    {
        $fileData = $this->prepareFile($file);

        return $this->streamFile(
            $fileData['path'],
            $fileData['name'],
            $fileData['size'],
            $fileData['mime'],
            $fileData['extension']
        );
    }

    /**
     * 🔍 التحقق من الملف واسترجاع بياناته
     */
    protected function prepareFile(Library $file): array
    {
        $disk = Storage::disk($this->disk);

        if (!$file->path || !$disk->exists($file->path)) {
            abort(404, 'الملف غير موجود.');
        }

        return [
            'path' => $disk->path($file->path),
            'name' => basename($file->path),
            'size' => $disk->size($file->path),
            'mime' => Storage::mimeType($file->path),
            'extension' => pathinfo($file->path, PATHINFO_EXTENSION),
        ];
    }

    /**
     * 🧩 إرسال الملف chunk-by-chunk
     */
    protected function streamFile(string $filePath, string $fileName, int $fileSize, string $mimeType, string $extension): StreamedResponse
    {
        return new StreamedResponse(function () use ($filePath) {
            $handle = fopen($filePath, 'rb');
            while (!feof($handle)) {
                echo fread($handle, $this->chunkSize);
                ob_flush();
                flush();
            }
            fclose($handle);
        }, 200, [
            'Content-Type' => $mimeType,
            'Content-Length' => $fileSize,
            'Content-Disposition' => "attachment; filename=\"$fileName\"",
            'Content-Extension' => $extension,
            'Cache-Control' => 'no-cache, private',
        ]);
    }
}
