<?php
namespace App\Contract\Actions;

interface FileLibraryHandler
{
    public function uploadChunk($request): array;
    public function checkUploadedChunks($request): array;
}
