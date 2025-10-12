<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class CleanOldLibraryFiles extends Command
{
    protected $signature = 'library:clean {days=1 : عدد الأيام التي بعدها يتم حذف الملفات}';
    protected $description = 'حذف الملفات القديمة من مجلد tmp داخل library';

    public function handle()
    {
        $days = (int) $this->argument('days');
        $cutoff = now()->subDays($days)->timestamp;

        $dirs = Storage::disk('local')->directories('tmp');

        foreach ($dirs as $dir) {
            $fullPath = Storage::disk('local')->path($dir);

            if (file_exists($fullPath)) {
                $dirTime = filemtime($fullPath);

                if ($dirTime < $cutoff) {
                    Storage::disk('local')->deleteDirectory($dir);
                    $this->info("🗑️ تم حذف المجلد: {$dir} وكل محتوياته");
                }
            }
        }

        $this->info("✅ تم فحص كل المجلدات.");
    }
    // php artisan library:clean 1
}
