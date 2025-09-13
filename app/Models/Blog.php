<?php

namespace App\Models;

use App\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
     use HasTranslations, HasFactory;

    protected $fillable = [
        'featured_image',
        'admin_id',
        'views',
        'slug',
    ];

    protected $translatable = [
        'title',
        'content',
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
