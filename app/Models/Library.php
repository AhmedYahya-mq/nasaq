<?php

namespace App\Models;

use Ahmed\GalleryImages\HasPhotos;
use App\Enums\LibraryStatus;
use App\Enums\LibraryType;
use App\Traits\HasTranslations;
use App\Traits\HasUlids;
use Illuminate\Database\Eloquent\Model;

class Library extends Model
{
    use HasUlids, HasTranslations, HasPhotos;

    protected $fillable = [
        'ulid',
        'status',
        'type',
        'path',
        'price',
        'discount',
        'published_at',
    ];

    protected $casts = [
        'status' => LibraryStatus::class,
        'type' => LibraryType::class,
        'price' => 'integer',
        'discount' => 'decimal:2',
        'published_at' => 'date',
    ];

    protected $translatableFields = [
        'title',
        'description',
        'author',
    ];

    protected $appends = [
        'final_price',
        'discounted_price',
        'regular_price_in_halalas',
        'membership_discount',
        'year_published',
    ];

    public function payment()
    {
        return $this->morphOne(Payment::class, 'payable');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'libraries_users', 'library_id', 'user_id')
            ->withPivot('payment_id')
            ->withTimestamps();
    }


    public function scopeType($query, LibraryType $type)
    {
        return $query->where('type', $type);
    }

    public function scopeDraft($query)
    {
        return $query->where('status', LibraryStatus::Draft);
    }

    public function scopePublished($query)
    {
        return $query->where('status', LibraryStatus::Published);
    }

    public function getYearPublishedAttribute(): ?int
    {
        return $this->published_at ? $this->published_at->year : null;
    }

    /**
     * السعر بعد خصم الحدث فقط
     */
    public function getDiscountedPriceAttribute(): float
    {
        return $this->discount > 0
            ? round($this->price * (1 - $this->discount))
            : (int) $this->price;
    }

    /**
     * الخصم الخاص بعضوية المستخدم
     */
    public function getMembershipDiscountAttribute(): float
    {
        $user = auth()->user();

        if ($user && $user->membership && $user->membership->percent_discount > 0) {
            return round($this->discounted_price * $user->membership->percent_discount);
        }

        return 0.0;
    }

    /**
     * السعر النهائي بعد تطبيق كل الخصومات (الحدث + العضوية)
     */
    public function getFinalPriceAttribute(): float
    {
        $price = $this->discounted_price;

        $user = auth()->user();
        if ($user && $user->membership && $user->membership->percent_discount > 0) {
            $price -= $this->membership_discount;
        }

        return round($price);
    }

    /**
     * السعر النهائي بالـ "هللات"
     */
    public function getRegularPriceInHalalasAttribute(): int
    {
        $price = $this->final_price ?? $this->price;
        return round($price * 100);
    }

    /**
     * هل المورد مجاني؟
     */
    public function isFree(): bool
    {
        return $this->price <= 0;
    }

    public static function payableType()
    {
        return Library::class;
    }

    public static function isPurchasable($id): bool
    {
        $res = self::find($id);
        return $res && !$res->isFree();
    }

    // تحقق من ان عليه تخفيض سوا عبر العضوية او عبر خصم مباشر
    public function hasDiscount(): bool
    {
        return $this->discount > 0 || $this->membership_discount > 0;
    }

    public function getPhotoAttribute()
    {
        return $this->photos()->first();
    }


    /**
     * تحديث سجل الدفع للمستخدم بالنسبة لهذا الكتاب
     *
     * @param int $userId
     * @return void
     */
    public function syncPaymentForUser(int $userId): void
    {
        $payment = $this->payment()
            ->where('user_id', $userId)
            ->where('status', \App\Enums\PaymentStatus::Paid)
            ->first();
        $this->users()->syncWithoutDetaching([
            $userId => [
                'payment_id' => $payment?->id,
                'updated_at' => now(),
            ]
        ]);
    }

    public function isUserRegistered(int $userId): bool
    {
        $pivot = $this->users()->where('user_id', $userId)->first()?->pivot;
        if (!$pivot) {
            return false;
        }
        if ($this->isFree()) {
            return true;
        }
        if ($pivot->payment_id) {
            return $this->payment()
                ->where('id', $pivot->payment_id)
                ->where('status', \App\Enums\PaymentStatus::Paid)
                ->exists();
        }
        return false;
    }


    public function savedUser(int $userId, ?int $paymentId = null): bool
    {
        if (! $this->exists) {
            return false;
        }

        if ($this->isUserRegistered($userId)) {
            // حدث فقط إذا هناك تغيير في الدفع
            $this->users()->updateExistingPivot($userId, [
                'payment_id' => $paymentId,
                'updated_at' => now(),
            ]);
            return true;
        }

        $this->users()->attach($userId, [
            'payment_id' => $this->isFree() ? null : $paymentId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        return true;
    }


    public function isPay(int $userId): bool
    {
        if ($this->isFree()) {
            return true;
        }

        $pivot = $this->users()->where('user_id', $userId)->first()?->pivot;

        if (!$pivot || !$pivot->payment_id) {
            return false;
        }

        return Payment::where('id', $pivot->payment_id)
            ->where('status', \App\Enums\PaymentStatus::Paid)
            ->exists();
    }
}
