<?php

namespace App\Actions\User;

use App\Contract\Actions\FileLibraryHandler as FileLibraryHandlerContract;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;

class FileLibraryHandler implements FileLibraryHandlerContract
{
    protected string $baseTempDir;

    public function __construct()
    {
        $this->baseTempDir = storage_path('app/tmp/library');
    }

    public function uploadChunk($request): array
    {
        try {
            $filename = $this->normalizeFilename((string) ($request->input('filename') ?? $request->input('name') ?? ''));
            $index = is_numeric($request->input('index')) ? (int) $request->input('index') : null;
            $total = is_numeric($request->input('total')) ? (int) $request->input('total') : null;
            $fileSize = is_numeric($request->input('file_size')) ? (int) $request->input('file_size') : null;
            $uploadHash = $request->input('upload_hash');

            if (!$filename || $index === null) {
                throw new Exception('Missing filename or index.');
            }

            $uploadId = $this->resolveUploadId($filename, $uploadHash, $fileSize, $total);
            $tempDir = $this->tempDir($uploadId);
            $this->ensureDirectory($tempDir);

            $manifest = $this->readManifest($tempDir);

            if ($manifest === null) {
                if ($total === null || $fileSize === null || !$uploadHash) {
                    // Do not create manifest unless we have sufficient info.
                    $manifest = [
                        'upload_id' => $uploadId,
                        'filename' => $filename,
                        'uploaded_chunks' => [],
                        'uploaded_chunk_sizes' => [],
                        'status' => 'uploading',
                    ];
                } else {
                    $manifest = $this->createManifest($uploadId, $filename, $uploadHash, $fileSize, $total);
                    $this->writeManifest($tempDir, $manifest);
                }
            }

            $uploadedFile = $request->file('file') ?? $request->file('chunk');

            if ($uploadedFile === null) {
                throw new Exception('No chunk file uploaded.');
            }

            $chunkPath = $this->chunkPath($tempDir, $index);
            $this->storeChunkFile($uploadedFile, $chunkPath);

            // update manifest under lock
            $this->withUploadLock($tempDir, function (&$m) use ($index, $chunkPath) {
                $m['uploaded_chunks'] = array_values(array_unique(array_merge($m['uploaded_chunks'] ?? [], [$index])));
                $m['uploaded_chunk_sizes'] = $m['uploaded_chunk_sizes'] ?? [];
                $m['uploaded_chunk_sizes'][(string) $index] = filesize($chunkPath) ?: 0;
                $m['updated_at'] = date('c');
            });

            // reload manifest
            $manifest = $this->readManifest($tempDir) ?? $manifest;

            // if manifest complete -> merge
            if ($this->isManifestComplete($manifest)) {
                $final = $this->mergeChunks($tempDir, $manifest);
                $manifest['final_path'] = $final;
                $manifest['status'] = 'completed';
                $manifest['completed_at'] = date('c');
                $manifest['updated_at'] = date('c');
                $this->writeManifest($tempDir, $manifest);
                $this->cleanupTemp($tempDir);
                return $this->progressResponse($manifest, true, 'Upload completed.');
            }

            return $this->progressResponse($manifest, false, 'Chunk uploaded.');
        } catch (Throwable $t) {
            return ['done' => false, 'message' => $t->getMessage(), 'error' => true];
        }
    }

    public function checkUploadedChunks($request): array
    {
        try {
            $filename = $this->normalizeFilename((string) ($request->input('filename') ?? $request->input('name') ?? ''));
            $total = is_numeric($request->input('total')) ? (int) $request->input('total') : null;
            $fileSize = is_numeric($request->input('file_size')) ? (int) $request->input('file_size') : null;
            $uploadHash = $request->input('upload_hash');

            if (!$filename && !$uploadHash) {
                return ['done' => false, 'message' => 'No upload identifier provided.', 'uploaded_chunks' => [], 'missing_chunks' => [], 'progress' => 0];
            }

            $uploadId = $this->resolveUploadId($filename, $uploadHash, $fileSize, $total);
            $tempDir = $this->tempDir($uploadId);
            $manifest = $this->readManifest($tempDir);

            if ($manifest === null) {
                // If we have enough info, create manifest; otherwise return empty progress
                if ($total !== null && $fileSize !== null && $uploadHash) {
                    $manifest = $this->createManifest($uploadId, $filename, $uploadHash, $fileSize, $total);
                    // reconcile any existing chunk files on disk
                    $this->reconcileManifestFromDisk($tempDir, $manifest);
                    $this->writeManifest($tempDir, $manifest);
                } else {
                    return ['done' => false, 'message' => 'No manifest found and insufficient info to create one.', 'uploaded_chunks' => [], 'missing_chunks' => [], 'progress' => 0];
                }
            } else {
                // reconcile with disk in case chunks were uploaded without manifest updates
                $this->reconcileManifestFromDisk($tempDir, $manifest);
                $this->writeManifest($tempDir, $manifest);
            }

            if ($this->isManifestComplete($manifest)) {
                // already complete; ensure final path exists
                if (empty($manifest['final_path'])) {
                    $final = $this->mergeChunks($tempDir, $manifest);
                    $manifest['final_path'] = $final;
                    $manifest['status'] = 'completed';
                    $manifest['completed_at'] = date('c');
                    $manifest['updated_at'] = date('c');
                    $this->writeManifest($tempDir, $manifest);
                    $this->cleanupTemp($tempDir);
                }
                return $this->progressResponse($manifest, true, 'Upload completed.');
            }

            return $this->progressResponse($manifest, false, 'Upload in progress.');
        } catch (Throwable $t) {
            return ['done' => false, 'message' => $t->getMessage(), 'error' => true];
        }
    }

    protected function resolveUploadId(?string $filename, $uploadHash, $fileSize, $total): string
    {
        $parts = ['library', $filename ?? '', (string) ($uploadHash ?? ''), (string) ($fileSize ?? ''), (string) ($total ?? '')];
        return hash('sha256', implode('|', $parts));
    }

    protected function tempDir(string $uploadId): string
    {
        return $this->baseTempDir . DIRECTORY_SEPARATOR . $uploadId;
    }

    protected function manifestPath(string $dir): string
    {
        return $dir . DIRECTORY_SEPARATOR . 'manifest.json';
    }

    protected function lockPath(string $dir): string
    {
        return $dir . DIRECTORY_SEPARATOR . 'manifest.lock';
    }

    protected function chunkPath(string $dir, int $index): string
    {
        return $dir . DIRECTORY_SEPARATOR . "chunk_{$index}.part";
    }

    protected function ensureDirectory(string $dir): void
    {
        if (!is_dir($dir)) {
            mkdir($dir, 0775, true);
        }
    }

    protected function readManifest(string $dir): ?array
    {
        $path = $this->manifestPath($dir);
        if (!is_file($path)) {
            return null;
        }
        $json = @file_get_contents($path);
        if ($json === false) {
            return null;
        }
        $data = json_decode($json, true);
        return is_array($data) ? $data : null;
    }

    protected function writeManifest(string $dir, array $manifest): void
    {
        $this->ensureDirectory($dir);
        $tmp = $this->manifestPath($dir) . '.tmp';
        file_put_contents($tmp, json_encode($manifest, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
        @rename($tmp, $this->manifestPath($dir));
    }

    protected function withUploadLock(string $dir, callable $callback): void
    {
        $this->ensureDirectory($dir);
        $lock = fopen($this->lockPath($dir), 'c+');
        if ($lock === false) {
            // fallback to no-lock
            $manifest = $this->readManifest($dir) ?? ['uploaded_chunks' => [], 'uploaded_chunk_sizes' => []];
            $callback($manifest);
            $this->writeManifest($dir, $manifest);
            return;
        }

        try {
            flock($lock, LOCK_EX);
            $manifest = $this->readManifest($dir) ?? ['uploaded_chunks' => [], 'uploaded_chunk_sizes' => []];
            $callback($manifest);
            $this->writeManifest($dir, $manifest);
        } finally {
            flock($lock, LOCK_UN);
            fclose($lock);
        }
    }

    protected function createManifest(string $uploadId, string $filename, string $uploadHash, int $fileSize, int $total): array
    {
        return [
            'upload_id' => $uploadId,
            'upload_hash' => $uploadHash,
            'filename' => $filename,
            'original_filename' => $filename,
            'file_size' => $fileSize,
            'total_chunks' => $total,
            'uploaded_chunks' => [],
            'uploaded_chunk_sizes' => [],
            'status' => 'uploading',
            'created_at' => date('c'),
            'updated_at' => date('c'),
        ];
    }

    protected function reconcileManifestFromDisk(string $dir, array &$manifest): void
    {
        $manifest['uploaded_chunks'] = array_values(array_unique($manifest['uploaded_chunks'] ?? []));
        $manifest['uploaded_chunk_sizes'] = $manifest['uploaded_chunk_sizes'] ?? [];

        $files = glob($dir . DIRECTORY_SEPARATOR . 'chunk_*.part') ?: [];
        foreach ($files as $f) {
            if (!is_file($f)) {
                continue;
            }
            if (preg_match('/chunk_(\d+)\.part$/', $f, $m)) {
                $idx = (int) $m[1];
                if (!in_array($idx, $manifest['uploaded_chunks'], true)) {
                    $manifest['uploaded_chunks'][] = $idx;
                }
                $manifest['uploaded_chunk_sizes'][(string) $idx] = filesize($f) ?: 0;
            }
        }

        sort($manifest['uploaded_chunks']);
        $manifest['updated_at'] = date('c');
    }

    protected function isManifestComplete(array $manifest): bool
    {
        $total = isset($manifest['total_chunks']) ? (int) $manifest['total_chunks'] : 0;
        if ($total <= 0) {
            return false;
        }
        $uploaded = array_values(array_unique(array_map('intval', $manifest['uploaded_chunks'] ?? [])));
        sort($uploaded);
        if (count($uploaded) !== $total) {
            return false;
        }
        // verify files exist
        foreach (range(0, $total - 1) as $i) {
            if (!is_file($this->chunkPath($this->tempDir($manifest['upload_id']), $i))) {
                return false;
            }
        }
        return true;
    }

    protected function mergeChunks(string $dir, array $manifest): string
    {
        $filename = $manifest['original_filename'] ?? $manifest['filename'] ?? 'file.bin';
        $relativeFinal = 'private/library/' . Str::random(12) . '_' . $this->normalizeFilename($filename);
        $finalPath = storage_path('app/' . $relativeFinal);
        $temporaryPath = $finalPath . '.tmp';

        $this->ensureDirectory(dirname($finalPath));

        $out = fopen($temporaryPath, 'wb');
        if ($out === false) {
            throw new Exception('Unable to open temporary file for merging.');
        }

        try {
            $total = (int) ($manifest['total_chunks'] ?? 0);
            for ($i = 0; $i < $total; $i++) {
                $partPath = $this->chunkPath($dir, $i);
                if (!is_file($partPath)) {
                    throw new Exception("Missing chunk {$i}.");
                }
                $part = fopen($partPath, 'rb');
                if ($part === false) {
                    throw new Exception("Unable to open chunk {$i} for reading.");
                }
                try {
                    stream_copy_to_stream($part, $out);
                } finally {
                    fclose($part);
                }
            }
        } catch (Throwable $th) {
            fclose($out);
            @unlink($temporaryPath);
            throw $th instanceof Exception ? $th : new Exception($th->getMessage(), 0, $th);
        }

        fclose($out);

        if (!@rename($temporaryPath, $finalPath)) {
            @unlink($temporaryPath);
            throw new Exception('Unable to move merged file into place.');
        }

        return $relativeFinal;
    }

    protected function cleanupTemp(string $dir): void
    {
        $files = glob($dir . DIRECTORY_SEPARATOR . '*') ?: [];
        foreach ($files as $file) {
            if (is_file($file) || is_link($file)) {
                @unlink($file);
            }
        }
        @rmdir($dir);
    }

    protected function storeChunkFile($uploadedFile, string $destinationPath): void
    {
        $directory = dirname($destinationPath);
        $this->ensureDirectory($directory);

        if (method_exists($uploadedFile, 'move')) {
            $uploadedFile->move($directory, basename($destinationPath));
            return;
        }

        // For PSR-7 UploadedFileInterface
        if (is_object($uploadedFile) && method_exists($uploadedFile, 'getStream')) {
            $stream = $uploadedFile->getStream();
            file_put_contents($destinationPath, $stream->getContents());
            return;
        }

        throw new Exception('Invalid uploaded chunk instance.');
    }

    protected function progressResponse(array $manifest, bool $done, string $message): array
    {
        $total = max((int) ($manifest['total_chunks'] ?? 0), 1);
        $uploadedChunks = array_values(array_unique(array_map('intval', $manifest['uploaded_chunks'] ?? [])));
        sort($uploadedChunks);

        $missingChunks = array_values(array_diff(range(0, $total - 1), $uploadedChunks));
        $progress = (int) floor((count($uploadedChunks) / $total) * 100);

        return [
            'done' => $done,
            'status' => $manifest['status'] ?? 'uploading',
            'message' => $message,
            'upload_id' => $manifest['upload_id'] ?? null,
            'final_path' => $manifest['final_path'] ?? null,
            'filename' => $manifest['original_filename'] ?? $manifest['filename'] ?? null,
            'total_chunks' => isset($manifest['total_chunks']) ? (int) $manifest['total_chunks'] : null,
            'uploaded_chunks' => $uploadedChunks,
            'missing_chunks' => $missingChunks,
            'uploaded_count' => count($uploadedChunks),
            'progress' => $progress,
            'file_size' => $manifest['file_size'] ?? null,
            'updated_at' => $manifest['updated_at'] ?? null,
            'completed_at' => $manifest['completed_at'] ?? null,
        ];
    }

    protected function normalizeFilename(string $filename): string
    {
        return basename(trim($filename));
    }
}
