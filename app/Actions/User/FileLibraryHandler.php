<?php

namespace App\Actions\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Exception;

class FileLibraryHandler implements \App\Contract\Actions\FileLibraryHandler
{
    protected string $disk;
    protected string $basePath;
    protected string $tempPath;

    public function __construct(
        string $basePath = 'library',
        string $disk = 'local'
    ) {
        $this->basePath = $basePath;
        $this->disk = $disk;
        $this->tempPath = 'tmp';
    }

    /**
     * 🧩 رفع جزء من الملف
     */
    public function uploadChunk($request): array
    {
        $validated = $request->validate([
            'file' => 'required|file',
            'index' => 'required|integer|min:0',
            'total' => 'required|integer|min:1',
            'filename' => 'required|string|max:255',
        ]);

        $file = $validated['file'];
        $index = $validated['index'];
        $total = $validated['total'];
        $filename = basename(strtolower($validated['filename']));
        $hashName = sha1($filename);

        $tempDir = storage_path("app/private/{$this->tempPath}/{$hashName}");
        if (!is_dir($tempDir)) mkdir($tempDir, 0755, true);

        $chunkPath = "{$tempDir}/{$index}";
        if (file_exists($chunkPath)) {
            return [
                'message' => "الجزء {$index} موجود مسبقًا، تم تخطيه.",
                'uploaded' => $index,
                'done' => false,
            ];
        }

        try {
            $file->move($tempDir, (string)$index);
        } catch (Exception $e) {
            throw new Exception("فشل رفع الجزء رقم {$index}: {$e->getMessage()}");
        }

        $uploadedParts = array_diff(scandir($tempDir), ['.', '..']);
        $uploadedCount = count($uploadedParts);

        if ($uploadedCount < $total) {
            return [
                'message' => "✅ تم رفع الجزء " . ($index + 1) . " من {$total}",
                'uploaded' => $uploadedCount,
                'remaining' => $total - $uploadedCount,
                'done' => false,
            ];
        }

        // ✅ دمج الأجزاء عند اكتمال الرفع
        $finalPath = $this->mergeChunks($tempDir, $filename, $total);

        // 🧹 تنظيف المؤقت
        $this->cleanupTemp($tempDir);

        return [
            'message' => '🎉 تم رفع الملف وتجميعه بنجاح!',
            'file_path' => $finalPath,
            'done' => true,
        ];
    }

    /**
     * 🔍 معرفة الأجزاء التي تم رفعها
     */
    public function checkUploadedChunks($request): array
    {
        $validated = $request->validate([
            'filename' => 'required|string|max:255',
        ]);

        $filename = basename(strtolower($validated['filename']));
        $hashName = sha1($filename);
        $tempDir = storage_path("app/private/{$this->tempPath}/{$hashName}");

        if (!is_dir($tempDir)) return ['uploaded_chunks' => []];

        $uploadedParts = array_filter(
            array_map('intval', array_diff(scandir($tempDir), ['.', '..'])),
            fn($i) => $i >= 0
        );

        sort($uploadedParts);

        return [
            'uploaded_chunks' => array_values($uploadedParts),
            'count' => count($uploadedParts),
        ];
    }

    /**
     * 🧩 دمج الأجزاء باستخدام Streaming لتجنب نفاد الذاكرة
     */
    protected function mergeChunks(string $tempDir, string $originalFilename, int $total): string
    {
        $extension = pathinfo($originalFilename, PATHINFO_EXTENSION);
        $uniqueName = Str::uuid()->toString() . ($extension ? ".{$extension}" : '');
        $finalPath = "{$this->basePath}/{$uniqueName}";

        // مسار الملف النهائي على القرص
        $finalFilePath = Storage::disk($this->disk)->path($finalPath);
        $out = fopen($finalFilePath, 'wb');

        for ($i = 0; $i < $total; $i++) {
            $partPath = "{$tempDir}/{$i}";
            if (!file_exists($partPath)) {
                fclose($out);
                throw new Exception("❌ جزء مفقود رقم {$i}");
            }

            $part = fopen($partPath, 'rb');
            while (!feof($part)) {
                fwrite($out, fread($part, 60 * 1024 * 1024)); // قراءة 1MB chunk
            }
            fclose($part);
        }

        fclose($out);
        return $finalPath;
    }

    /**
     * 🧹 تنظيف الملفات المؤقتة بعد الدمج
     */
    protected function cleanupTemp(string $dir): void
    {
        collect(glob("{$dir}/*"))->each(fn($f) => @unlink($f));
        @rmdir($dir);
    }
}
