<?php

namespace App\Models;

use App\Enums\EmploymentStatus;
use App\Enums\MembershipStatus;
use App\Enums\PaymentStatus;
use App\Notifications\EmailVerificationNotification;
use App\Notifications\ResetPasswordNotification;
use App\Traits\ProfileQrCode;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Laravel\Fortify\TwoFactorAuthenticatable;

class User extends Authenticatable implements \Illuminate\Contracts\Auth\MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, TwoFactorAuthenticatable, ProfileQrCode;
    // خاصية داخلية تحدد الـ guard
    protected $guard = 'web';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'id',
        'name',
        'email',
        'photo',
        'phone',
        'birthday',
        'address',
        'job_title',
        'employment_status',
        'national_id',
        'current_employer',
        'scfhs_number',
        'bio',
        'password',
        'membership_id',
        'member_id',
        'membership_started_at',
        'membership_expires_at',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The accessors to append to the model's array form.
     * @var array{0: 'profile_photo_url'}
     */
    protected $appends = [
        'profile_photo_url',
        'membership_status',
        'membership_name',
        'remaining_days',
        'profile_link'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'two_factor_confirmed_at' => 'datetime',
            'birthday' => 'date',
            'membership_started_at' => 'datetime',
            'membership_expires_at' => 'datetime',
            'membership_status' => MembershipStatus::class,
            'employment_status' => EmploymentStatus::class,
            'is_active' => 'boolean',
        ];
    }


    /**
     * relation with Payment
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     *
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function eventRegistrations()
    {
        return $this->hasMany(EventRegistration::class);
    }


    public function events()
    {
        return $this->belongsToMany(Event::class, 'event_registrations')
            ->withPivot(['is_attended', 'joined_at', 'join_ip', 'join_link'])
            ->withTimestamps();
    }

    public function libraries()
    {
        return $this->belongsToMany(Library::class, 'libraries_users')
            ->withPivot('payment_id')
            ->withTimestamps();
    }

    // auth()->user()->isPurchasedByUser($itemId) 1 1
    public function isPurchasedByUser($itemId, $type): bool
    {
        return $this->payments()
            ->where('payable_type', $type)
            ->where('payable_id', $itemId)
            ->where('status', PaymentStatus::Paid)
            ->exists();
    }

    // profile_link
    public function getProfileLinkAttribute()
    {
        return route('members.show', $this->id);
    }

    /**
     * Get the user's profile photo URL.
     *
     * @return string
     */
    public function getProfilePhotoUrlAttribute()
    {
        if (empty($this->photo)) {
            return "https://ui-avatars.com/api/?name=" . urlencode($this->name) . "&bold=true&format=svg";
        }
        return asset('storage/' . $this->photo);
    }

    /**
     * Override the default password reset notification
     *
     * @param string $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    /**
     * Override the default password reset notification
     *
     * @param string $token
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new EmailVerificationNotification());
    }

    /**
     * Get the guard name attribute.
     * @return string
     */
    public function getGuardNameAttribute(): string
    {
        return $this->guard;
    }

    // --- العلاقات الأساسية ---
    public function membershipApplications()
    {
        return $this->hasMany(MembershipApplication::class);
    }

    /**
     * آخر طلب عضوية تمت الموافقة عليه ويعتبر طلب حق العضوية المفعله حالياً
     *
     * @return MembershipApplication|null
     */
    public function latestApprovedMembershipApplication(): ?MembershipApplication
    {
        return $this->membershipApplications()
            ->where('status', \App\Enums\MembershipApplication::Approved)
            ->latest('submitted_at')
            ->first();
    }


    /**
     * علاقة المستخدم بالعضوية الحالية
     */
    public function membership()
    {
        return $this->belongsTo(Membership::class);
    }


    // --- دوال مساعدة للعضويات ---
    /**
     * الحصول على العضوية الحالية (فعالة) للمستخدم، تشمل العضويات مدى الحياة.
     *
     * @return Membership|null
     */
    /**
     * الحصول على العضوية الحالية (فعالة) للمستخدم.
     *
     * @return Membership|null
     */
    public function currentMemberships(): ?Membership
    {
        if (! $this->membership) {
            return null; // لا توجد عضوية
        }

        // التحقق من أن العضوية لم تنتهِ بعد
        if ($this->membership_expires_at && $this->membership_expires_at->isFuture()) {
            return $this->membership;
        }

        return null; // العضوية منتهية
    }

    /**
     * التحقق من امتلاك المستخدم لعضوية معينة (فعالة).
     */
    public function hasMembership($membershipId): bool
    {
        return $this->currentMemberships() && $this->currentMemberships()->id === $membershipId;
    }

    /**
     * تحقق إذا كانت العضوية الحالية للمستخدم فعالة
     *
     * @return bool
     */
    public function hasActiveMembership(): bool
    {
        return $this->membership
            && $this->membership_expires_at
            && $this->membership_expires_at->isFuture();
    }

    /**
     *الحصول على أسم العضوية الحالية سوا كان نشطه ام لا
     */
    public function getMembershipNameAttribute()
    {
        return $this->membership ? $this->membership->name : null;
    }

    /**
     * الحصول على حالة العضوية الحالية
     *
     * @return string
     */
    public function getMembershipStatusAttribute(): MembershipStatus
    {
        if (! $this->membership) {
            return new MembershipStatus(MembershipStatus::None);
        }
        if ($this->hasActiveMembership()) {
            return new MembershipStatus(MembershipStatus::Active);
        }
        return new MembershipStatus(MembershipStatus::Expired);
    }

    // --- دوال مساعدة أخرى ---
    /**
     * Get the two factor QR code SVG attribute.
     * @return null|string
     * @throws BindingResolutionException
     * @throws InvalidArgumentException
     */
    public function getTwoFactorQrCodeSvgAttribute(): ?string
    {
        if (! $this->two_factor_secret) {
            return null;
        }
        return $this->twoFactorQrCodeSvg();
    }

    /**
     * Get the two factor recovery codes as an array.
     * @return null|array
     * @throws BindingResolutionException
     */
    public function getTwoFactorRecoveryCodesArrayAttribute(): ?array
    {
        if (!$this->two_factor_recovery_codes) {
            return null;
        }
        return json_decode(decrypt($this->two_factor_recovery_codes), true);
    }

    /**
     * Get the two factor enabled attribute.
     * @return bool
     */
    public function getTwoFactorEnabledAttribute(): bool
    {
        return $this->hasEnabledTwoFactorAuthentication();
    }

    /**
     * Get the two factor secret key attribute.
     * @return string
     * @throws BindingResolutionException
     * @throws RuntimeException
     */
    public function getTwoFactorSecretKeyAttribute()
    {
        if (! $this->two_factor_secret) {
            return null;
        }
        return decrypt($this->two_factor_secret);
    }


    /**
     * حساب انتهاء العضوية بعد الترقية أو التجديد
     *
     * @param Membership $newMembership العضوية الجديدة
     * @return array{
     *     oldMembership: Membership|null,
     *     newMembership: Membership,
     *     newExpiresAt: \Carbon\Carbon,
     *     priceDifference: float,
     *     actionType: 'renewal'|'upgrade'|'new'
     * }
     */
    public function calculateMembershipChange(Membership $newMembership): array
    {
        $now = Carbon::now();
        $oldMembership = $this->membership;
        // حالة عضوية جديدة بالكامل (لم يكن لديه عضوية)
        if (!$oldMembership) {
            return [
                'oldMembership' => null,
                'newMembership' => $newMembership,
                'newExpiresAt' => $now->copy()->addDays($newMembership->duration_days),
                'priceDifference' => $newMembership->price,
                'actionType' => 'new',
            ];
        }

        // حساب الوقت المتبقي بدقة
        $currentExpires = $this->hasActiveMembership() ? $this->membership_expires_at : $now;

        $oldPrice = $oldMembership->price;
        $newPrice = $newMembership->price;

        // نفس العضوية → تجديد
        if ($oldMembership->id === $newMembership->id) {
            return [
                'oldMembership' => $oldMembership,
                'newMembership' => $newMembership,
                'newExpiresAt' => $currentExpires->copy()->addDays($newMembership->duration_days),
                'priceDifference' => $newPrice,
                'actionType' => 'renewal',
            ];
        }

        $actionType = $newPrice > $oldPrice ? 'upgrade' : 'downgrade';
        $remainingDays = $currentExpires->greaterThan($now)
            ? ceil($currentExpires->floatDiffInDays($now))
            : 0;
        $remainingDays = abs($remainingDays);
        $remainingValue = $remainingDays > 0 ? ($oldPrice * $remainingDays / $oldMembership->duration_days) : 0;
        $extraDays = $newPrice > 0 ? round(($remainingValue / $newPrice) * $newMembership->duration_days) : 0;
        $newExpiresAt = $actionType === 'upgrade'
            ? $now->copy()->addDays($newMembership->duration_days + $extraDays)
            : $now->copy()->addDays($extraDays);
        return [
            'oldMembership' => $oldMembership,
            'newMembership' => $newMembership,
            'newExpiresAt' => $newExpiresAt,
            'priceDifference' => max(0, $newPrice - $remainingValue),
            'actionType' => $actionType,
            'extraDays' => $extraDays, // أيام إضافية محسوبة
        ];
    }


    /**
     * ترقية العضوية بدون أي اعتبار للعضوية السابقة
     * @param Membership $newMembership
     * @param Carbon $now
     * @return Carbon
     */
    private function upgradeOnly(Membership $newMembership, Carbon $now): Carbon
    {
        // ببساطة نضيف مدة العضوية الجديدة كاملة
        return $now->copy()->addDays($newMembership->duration_days);
    }

    /**
     * ترقية العضوية مع تمديد الوقت المتبقي من العضوية السابقة
     * إذا لم يكن هناك وقت متبقي، ستعامل كعضوية جديدة
     * @param Membership $newMembership
     * @param int $remainingDays
     * @param Carbon $now
     * @return Carbon
     */
    private function upgradeExtend(Membership $newMembership, int $remainingDays, Carbon $now): Carbon
    {
        if ($remainingDays > 0 && $this->membership_expires_at) {
            return $this->membership_expires_at->copy()->addDays($newMembership->duration_days);
        }

        return $this->upgradeOnly($newMembership, $now);
    }

    /**
     * ترقية العضوية مع حساب الرصيد بناءً على الأيام المتبقية من العضوية السابقة
     * بحيث تتعامل مع حالات الترقية أو التخفيض
     *
     * @param Membership $newMembership
     * @param int $remainingDays
     * @param Carbon $now
     * @return Carbon
     */
    private function upgradeWithBalance(Membership $newMembership, int $remainingDays, Carbon $now): Carbon
    {
        if ($remainingDays > 0 && $this->membership_id) {
            $oldMembership = Membership::find($this->membership_id);
            if ($oldMembership) {
                $oldDayValue = $oldMembership->price / $oldMembership->duration_days; // 200 / 365 = 0.5479452
                $balanceValue = $remainingDays * $oldDayValue; // 265 * 0.5479452 = 145.602

                $newDayValue = $newMembership->price / $newMembership->duration_days; // 300 / 365 = 0.8219
                $daysEquivalent = $balanceValue / $newDayValue; // 145.602 / 0.8219 ≈ 177.2

                $wholeDays = floor($daysEquivalent); // 177
                $fraction = abs($daysEquivalent - $wholeDays); // 0.2
                $hoursToAdd = round($fraction * 24); // 5
                return $now->copy()->addDays($wholeDays)->addHours($hoursToAdd);
            }
        }
        return $this->upgradeOnly($newMembership, $now);
    }

    /**
     *  ترقية العضوية مع دفع الفرق في السعر إذا كان هناك فرق
     *  وإلا تعامل مع العضوية الجديدة أو التجديد
     *
     * @param Membership $newMembership
     * @param int $remainingDays
     * @param Carbon $now
     * @return array{expires_at: Carbon, price: float}
     */
    private function upgradeWithExtraPayment(Membership $newMembership, int $remainingDays, Carbon $now): array
    {
        $price = $newMembership->price;

        if ($remainingDays > 0 && $this->membership_id) {
            $oldMembership = Membership::find($this->membership_id);
            if ($oldMembership) {
                $oldDayValue = $oldMembership->price / $oldMembership->duration_days; // 300 / 365 = 0.8219
                $balanceValue = $remainingDays * $oldDayValue; // 265 * 0.8219 = 217.808

                $price = max($newMembership->price + $balanceValue, 0); // 200 + 217.808 =  417.808

                $newDayValue = $newMembership->price / $newMembership->duration_days; // 200 / 365 = 0.5479

                $daysEquivalent = $price / $newDayValue; // 417.808 / 0.5479 ≈ 762.5

                $wholeDays = floor($daysEquivalent); // 762
                $fraction = $daysEquivalent - $wholeDays; // 0.5
                $hoursToAdd = round($fraction * 24); // 12
                return [
                    'expires_at' => $now->copy()->addDays($wholeDays)->addHours($hoursToAdd),
                    'price' => $price,
                ];
            }
        }

        return [
            'expires_at' => $now->copy()->addDays($newMembership->duration_days),
            'price' => $price,
        ];
    }


    /**
     * دالة عامة لترقية العضوية بناءً على نوع الترقية
     * @param Membership $newMembership
     * @param string $upgradeType ['upgrade_only', 'upgrade_extend', 'upgrade_with_balance', 'upgrade_with_extra_payment']
     * @return User|array
     */
    public function upgradeMembership(Membership $newMembership, string $upgradeType = 'upgrade_only')
    {
        $now = now();
        $remainingDays = $this->remaining_days;

        switch ($upgradeType) {
            case 'upgrade_extend':
                $expiresAt = $this->upgradeExtend($newMembership, $remainingDays, $now);
                break;
            case 'upgrade_with_balance':
                $expiresAt = $this->upgradeWithBalance($newMembership, $remainingDays, $now);
                break;
            case 'upgrade_with_extra_payment':
                $result = $this->upgradeWithExtraPayment($newMembership, $remainingDays, $now);
                $expiresAt = $result['expires_at'];
                break;
            case 'upgrade_only':
            default:
                $expiresAt = $this->upgradeOnly($newMembership, $now);
                break;
        }

        $this->update([
            'membership_id' => $newMembership->id,
            'membership_started_at' => now(),
            'membership_expires_at' => $expiresAt,
        ]);

        return $this;
    }


    /**
     *  تجديد العضوية الحالية
     * @return $this
     * @throws Exception
     */
    public function renewMembership()
    {
        if (!$this->membership) {
            throw new \Exception("Cannot renew membership: User has no current membership.");
        }
        $newExpiry = $this->upgradeExtend($this->membership, $this->remaining_days, now());
        $this->membership_started_at = now();
        $this->membership_expires_at = $newExpiry;
        $this->save();
        return $this;
    }

    /**
     * الاشتراك في عضوية جديدة
     * @param  $membership_id
     * @return $this
     */
    public function subscribeMembership(Membership $newMembership)
    {
        $now = now();
        $remainingDays = $this->remaining_days;
        if ($remainingDays > 0 && $this->hasActiveMembership()) {
            $upgradeData = $this->upgradeWithExtraPayment($newMembership, $remainingDays, $now);
            $this->membership_started_at = $now;
            $this->membership_expires_at = $upgradeData['expires_at'];
        } else {
            $this->membership_started_at = $now;
            $this->membership_expires_at = $now->copy()->addDays($newMembership->duration_days);
        }

        $this->membership_id = $newMembership->id;
        $this->save();
        return $this;
    }

    /**
     * الحصول على الأيام المتبقية في العضوية الحالية
     *
     * @return int
     */
    public function getRemainingDaysAttribute(): int
    {
        if ($this->hasActiveMembership()) {
            return now()->diffInDays($this->membership_expires_at, false);
        }
        return 0;
    }

    /**
     * الحصول على طلب العضوية المعلق (المسودة) مع دفع ناجح
     *
     * @return MembershipApplication|null
     */
    public function draftMembershipApplication(): ?\App\Models\MembershipApplication
    {
        return $this->membershipApplications()
            ->where('status', \App\Enums\MembershipApplication::Draft)
            ->whereHas('payment', fn($q) => $q->where('status', \App\Enums\PaymentStatus::Paid))
            ->latest('created_at')
            ->first();
    }


    /**
     * تنظيف الكتب المسجلة حسب حالة الدفع
     */
    public function cleanRegisteredLibraries(): void
    {
        $this->libraries()->get()->each(function ($library) {
            $pivot = $library->users()->where('user_id', $this->id)->first()?->pivot;

            $hasPaid = $pivot?->payment_id
                ? \App\Models\Payment::where('id', $pivot->payment_id)
                ->where('status', \App\Enums\PaymentStatus::Paid)
                ->exists()
                : false;

            if ($library->isFree() || $hasPaid) {
                return;
            }

            $library->users()->detach($this->id);
        });
    }

    /**
     * 🔹 Scope لتنظيف وإرجاع المكتبات بعد التحقق
     */
    public function scopeWithCleanLibraries($query)
    {
        return $query->tap(function ($user) {
            $user->cleanRegisteredLibraries();
        });
    }
}
