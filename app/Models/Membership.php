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
        'id',
        'name',
        'description',
        'is_active',
        'price',
        'discounted_price',
        'duration_days',
        'requirements',
        'features',
        'level',
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
        'price' => 'integer',
        'discounted_price' => 'integer',
        'is_active' => 'boolean',
        'duration_days' => 'integer',
    ];

    protected $attributes = [
        'is_active' => true,
        'duration_days' => 365,
        'level' => null,
        'regular_price' => null,
        'discounted_price' => null,
        'regular_price_in_halalas' => null,
        'is_discounted' => null,
        'precentage_discount' => null,
    ];

    public function getRegularPriceAttribute(): float
    {
        if ($this->discounted_price && $this->discounted_price > 0) {
            return $this->discounted_price;
        }
        return $this->price;
    }

    // is_discounted ترجع صح او خطأ اذا كانت العضوية مخفضة السعر
    public function getIsDiscountedAttribute(): bool
    {
        return $this->discounted_price && $this->discounted_price > 0 && $this->discounted_price < $this->price;
    }

    // ترجع نسبة الخصم اذا كانت العضوية مخفضة السعر
    public function getPrecentageDiscountAttribute(): ?int
    {
        if ($this->is_discounted) {
            return (int)round((($this->price - $this->discounted_price) / $this->price) * 100);
        }
        return null;
    }

    // دالة تقوم برجاع المبلغ با هلله
    public function getRegularPriceInHalalasAttribute(): int
    {
        return (int)($this->regular_price * 100);
    }

    protected static function booted(): void
    {
        static::creating(function ($membership) {
            if (is_null($membership->level)) {
                $highestLevel = Membership::max('level');
                $membership->level = $highestLevel ? $highestLevel + 1 : 1;
            }
        });

        static::updating(function ($membership) {
            if (is_null($membership->level)) {
                $highestLevel = Membership::where('id', '!=', $membership->id)->max('level');
                $membership->level = $highestLevel ? $highestLevel + 1 : 1;
            }
        });


        static::addGlobalScope('active', function (Builder $builder) {
            $builder->where('is_active', true);
        });

        static::addGlobalScope('orderByLevel', function (Builder $builder) {
            $builder->orderByLevel();
        });
    }

    /**
     * Scope a query to only include active memberships.
     * @param Builder $query
     * @return Builder
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    // سكوب للترتيب حسب المستوى
    public function scopeOrderByLevel(Builder $query, $direction = 'asc'): Builder
    {
        return $query->orderBy('level', $direction);
    }


    // يرجع صح او خطأ اذا كانت العظوية الاعلى لفل
    // حيث اريد منه استخدامه من اجل اظاهر زرار الترقية
    public function isHigherLevelThan(): bool
    {
        $highestLevel = Membership::max('level');
        return $this->level >= $highestLevel;
    }

    /**
     * الدوال الأساسية: العلاقات مع النماذج الأخرى
     */

    // علاقة العضوية مع الطلبات
    public function applications()
    {
        return $this->hasMany(MembershipApplication::class);
    }

    // علاقة العضوية مع المستخدمين (عضويات المستخدمين)
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_memberships')
            ->withPivot('started_at', 'expires_at')
            ->withTimestamps();
    }
}
