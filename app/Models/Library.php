<?php

namespace App\Models;

use App\Enums\LibraryStatus;
use App\Enums\LibraryType;
use App\Traits\HasTranslations;
use App\Traits\HasUlids;
use Illuminate\Database\Eloquent\Model;

class Library extends Model
{
    use HasUlids, HasTranslations;

    protected $fillable = [
        'ulid',
        'status',
        'type',
        'path',
        'price',
        'discount',
    ];

    protected $casts = [
        'status' => LibraryStatus::class,
        'type' => LibraryType::class,
        'price' => 'integer',
        'discount' => 'decimal:2',
    ];

    protected $translatableFields = [
        'title',
        'description',
        'author',
    ];

    public function payment()
    {
        return $this->morphOne(Payment::class, 'payable');
    }

    public function isFree(): bool
    {
        return $this->price <= 0;
    }
}
