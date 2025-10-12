<?php

namespace App\Traits;

trait HasUlids
{
    use \Illuminate\Database\Eloquent\Concerns\HasUlids;

    public function uniqueIds()
    {
        return ['ulid'];
    }

    /**
     * استخدم UUID بدلاً من ID في الـ Route Model Binding
     */
    public function getRouteKeyName()
    {
        return 'ulid';
    }
}
