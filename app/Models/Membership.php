<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Membership extends Model
{
     use HasFactory, HasTranslations;

    protected $fillable = [
        'name',
        'description',
        'is_active',
        'price',
        'discounted_price',
        'duration_days',
        'requirements',
        'features',
    ];

    public $translatable = [
        'name',
        'description',
        'requirements',
        'features',
    ];

    protected $casts = [
        'requirements' => 'array',
        'features' => 'array',
        'name' => 'array',
        'description' => 'array',
        'price' => 'decimal:2',
        'discounted_price' => 'decimal:2',
        'is_active' => 'boolean',
        'duration_days' => 'integer',
    ];

    /**
     * Scope a query to only include active memberships.
     * @param Builder $query
     * @return Builder
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }
}
