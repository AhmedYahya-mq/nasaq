<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Translation extends Model
{
    protected $fillable = [
        'table_name',   // اسم الجدول الأصلي مثل blogs, categories
        'record_id',    // id الخاص بالسجل في الجدول الأصلي
        'locale',       // en, ar, fr, ...
        'field',        // العمود المترجم: title, content, excerpt, slug
        'value',        // القيمة المترجمة
    ];

    /**
     * علاقة مع الجدول الأصلي (polymorphic)
     */
    public function translatable()
    {
        return $this->morphTo(null, 'table_name', 'record_id');
    }

    protected $casts = [
        'value' => 'string',
        'locale' => 'string',
        'field' => 'string',
        'table_name' => 'string',
        'record_id' => 'integer',
    ];
}
