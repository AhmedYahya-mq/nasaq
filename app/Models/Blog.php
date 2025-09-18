<?php

namespace App\Models;

use Ahmed\GalleryImages\HasPhotos;
use App\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations as TranslatableHasTranslations;

class Blog extends Model
{
     use HasTranslations, HasFactory, TranslatableHasTranslations, HasPhotos;

    protected $fillable = [
        'admin_id',
        'views',
        'slug',
        'content',
    ];

    public $translatable = [
        'content',
    ];
    protected $translatableFields = [
        'title',
        'excerpt',
    ];

    /**
     * العلاقة مع المشرف الذي أنشأ المقال
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

}
