<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class MembershipFile extends Model
{
    use HasFactory;

    public static $path = 'membership_files/';

    protected $dispatchesEvents = [
        'deleted' => \App\Events\FileDeletedEvent::class,
    ];

    protected $fillable = [
        'membership_application_id',
        'file_name',
        'file_path',
        'file_type',
    ];

    protected $appends = [
        'url',
    ];

    // --- العلاقات الأساسية ---
    public function application()
    {
        return $this->belongsTo(MembershipApplication::class);
    }


    // --- رفع ملف واحد أو عدة ملفات ---
    public static function storeFiles($application, $files)
    {
        $files = is_array($files) ? $files : [$files];
        foreach ($files as $file) {
            $path = $file->store(self::$path, 'public');
            self::create([
                'membership_application_id' => $application->id,
                'file_name' => $file->getClientOriginalName(),
                'file_path' => $path,
                'file_type' => $file->getClientMimeType(),
            ]);
        }
    }

    // --- Accessor: رابط الملف ---
    public function getUrlAttribute()
    {
        return $this->file_path;
    }

    // --- Scope: الملفات المعتمدة فقط ---
    public function scopeApproved($q)
    {
        return $q->whereNotNull('approved_at');
    }

    // --- أمثلة استخدام ---
    /*
    MembershipFile::storeFiles($application, $request->file('files')); // رفع ملفات
    $file->approve(); // اعتماد ملف
    $file->url; // رابط الملف
    MembershipFile::approved()->get(); // الملفات المعتمدة
    */
}
