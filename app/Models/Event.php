<?php

namespace App\Models;

use App\Enums\EventCategory;
use App\Enums\EventMethod;
use App\Enums\EventStatus;
use App\Enums\EventType;
use App\Traits\HasTranslations;
use App\Traits\HasUlids;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Event extends Model
{
    use HasUlids, HasTranslations;
    protected $fillable = [
        'ulid',
        'event_type',
        'event_category',
        'event_method',
        'event_status',
        'link',
        'event_status',
        'start_at',
        'end_at',
        'capacity',
        'price',
        'discount',
        'is_featured',
    ];

    protected $translatableFields = [
        'title',
        'description',
        'address',
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
        'price' => 'integer',
        'discount' => 'decimal:2',
        'capacity' => 'integer',
        'event_type' => EventType::class,
        'event_category' => EventCategory::class,
        'event_method' => EventMethod::class,
        'event_status' => EventStatus::class,
    ];

    protected $appends = [
        'final_price',
        'registrations_count',
        'attended_count',
        'not_attended_count',
        'presentage_attended',
        'discounted_price',
    ];

    public function memberships()
    {
        return $this->belongsToMany(Membership::class, 'event_membership');
    }

    public static function isPurchasable($id)
    {
        $event = self::find($id);
        return $event && !$event->isFree();
    }
    public static function redirectRoute($id)
    {
        $event = self::find($id);
        return route('client.event.register', ['event' => $event]);
    }

    // داله تتحقق اذا المستخدم المسجل اذا يمكنه تسجيل اذا في الحدث طبعا اذا الحدث لا يوجد اي عضوية مرتبطة يعني الكل يقدر يسجل مع عضوي او لا
    public function canUserRegister()
    {
        $user = auth()->user();
        if ($this->memberships()->count() === 0) {
            return true; // الحدث مفتوح للجميع
        }

        if ($user && $user->membership) {
            return $this->memberships()->where('membership_id', $user->membership->id)->exists();
        }

        return false;
    }
    public function registrations()
    {
        return $this->hasMany(EventRegistration::class);
    }

    public function getRegistrationsCountAttribute()
    {
        return $this->registrations()->count();
    }

    public function getAttendedCountAttribute()
    {
        return $this->registrations()->where('is_attended', true)->count();
    }
    public function getNotAttendedCountAttribute()
    {
        return $this->registrations()->where('is_attended', false)->count();
    }
    public function getPresentageAttendedAttribute()
    {
        $total = $this->registrations_count;
        if ($total === 0) {
            return 0;
        }
        return round(($this->attended_count / $total) * 100, 2);
    }

    public function isFull()
    {
        if (is_null($this->capacity)) {
            return false;
        }
        return $this->registrations()->count() >= $this->capacity;
    }

    // 1️⃣ السعر بعد خصم الحدث فقط
    public function getEventDiscountedPriceAttribute(): float
    {
        return $this->discount > 0
            ? round($this->price * (1 - $this->discount / 100), 2)
            : $this->price;
    }

    // مبلغ الخصم
    public function getDiscountedPriceAttribute(): int
    {
        return $this->event_discounted_price;
    }

    public function getRegularPriceInHalalasAttribute(): int
    {
        return (int)($this->final_price * 100);
    }

    // مبلغ الخصم حق العضوية
    public function getMembershipDiscountAttribute(): int
    {
        $user = auth()->user();
        if ($user && $user->membership && $user->membership->percent_discount > 0) {
            return round($this->event_discounted_price * $user->membership->percent_discount);
        }
        return 0;
    }

    // 2️⃣ السعر بعد خصم العضوية (إذا المستخدم مسجل ولديه عضوية)
    public function getMembershipDiscountedPriceAttribute(): float
    {
        $user = auth()->user();

        $price = $this->event_discounted_price; // السعر بعد خصم الحدث

        if ($user && $user->membership && $user->membership->percent_discount > 0) {
            return $price -  round($price * $user->membership->percent_discount);
        }

        return $price;
    }

    // 3️⃣ السعر النهائي (محصلة كل الخصومات)
    public function getFinalPriceAttribute(): float
    {
        return $this->membership_discounted_price;
    }

    public function isDiscounted()
    {
        return $this->discount > 0;
    }

    public function isFree()
    {
        return $this->getFinalPriceAttribute() <= 0;
    }

    public function scopeUpcoming($query)
    {
        return $query->where('event_status', EventStatus::Upcoming);
    }

    public function scopeOngoing($query)
    {
        return $query->where('event_status', EventStatus::Ongoing);
    }

    public function scopeCompleted($query)
    {
        return $query->where('event_status', EventStatus::Completed);
    }

    public function scopeCancelled($query)
    {
        return $query->where('event_status', EventStatus::Cancelled);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true)->orderBy('start_at', 'desc');
    }

    /**
     * الحصول على ملخص تواريخ الفعاليات بكفاءة
     *
     * @return array
     */
    public static function getCalendar(): array
    {
        $today = Carbon::now()->toDateString();

        // Query واحد: فقط التواريخ >= اليوم
        $datesData = self::query()
            ->select(DB::raw('DATE(start_at) as date'), DB::raw('COUNT(*) as count'))
            ->whereDate('start_at', '>=', $today)
            ->groupBy(DB::raw('DATE(start_at)'))
            ->orderBy('date')
            ->get();

        $dates = $datesData->pluck('count', 'date')->toArray();

        // أكبر تاريخ من هذه الفعاليات
        $maxDate = !empty($dates) ? max(array_keys($dates)) : null;
        $maxDatePlusOne = $maxDate ? Carbon::parse($maxDate)->addDay()->toDateString() : null;

        return [
            'max' => $maxDatePlusOne,
            'dates' => $dates,
            'now' => $today,
        ];
    }

    // تحقق من ان الحدث مفتوح لتسجيل
    public function isRegistrationOpen()
    {
        $now = Carbon::now();
        return $this->event_status->isUpcoming() && $this->start_at > $now && !$this->isFull();
    }

    // تحقق من ان الحدث بدأ
    public function hasStarted()
    {
        $now = Carbon::now();
        return $this->start_at <= $now;
    }
    // تحقق من ان المستخدم الذي برسل id مسجل في الحدث
    public function isUserRegistered($userId)
    {
        return $this->registrations()->where('user_id', $userId)->exists();
    }
}
