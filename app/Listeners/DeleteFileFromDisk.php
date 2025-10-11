<?php

namespace App\Listeners;

use App\Events\FileDeletedEvent;
use Illuminate\Support\Facades\Storage;

class DeleteFileFromDisk
{
    public function handle(FileDeletedEvent $event)
    {
        $file = $event->file;

        $path = str_replace('/storage/', '', $file->file_path);
        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
