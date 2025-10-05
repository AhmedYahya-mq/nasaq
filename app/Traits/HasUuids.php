<?php

namespace App\Traits;

trait HasUuids
{
    use \Illuminate\Database\Eloquent\Concerns\HasUuids;

    public function uniqueIds()
    {
        return ['uuid'];
    }

    /**
     * استخدم UUID بدلاً من ID في الـ Route Model Binding
     */
    public function getRouteKeyName()
    {
        return 'uuid';
    }
}
