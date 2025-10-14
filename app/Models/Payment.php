<?php

namespace App\Models;

use App\Enums\PaymentStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'invoice_id',
        'moyasar_id',
        'payable_id',
        'payable_type',
        'amount',
        'currency',
        'status',
        'source_type',
        'company',
        'description',
        'raw_response',
        'discount',
        'membership_discount',
        'original_price',
    ];

    protected $casts = [
        'raw_response' => 'array',
        'status' => PaymentStatus::class,
        'amount' => 'integer',
        'discount' => 'integer',
        'membership_discount' => 'integer',
    ];

    protected $hidden = [
        'raw_response',
        'created_at',
        'updated_at',
    ];

    protected $appends = [
        'transaction_url',
        'message'
    ];

    static protected function booted()
    {
        static::updated(function ($payment) {
            if ($payment->isDirty('status')) {
                event(new \App\Events\PaymentStatusChanged($payment));
            }
            if ($payment->isDirty('status') && $payment->status->isPaid()) {
                event(new \App\Events\PaymentStatusUpdated($payment));
            }
        });

        static::created(function ($payment) {
            if ($payment->status->isPaid()) {
                event(new \App\Events\PaymentStatusUpdated($payment));
            }
        });

        static::creating(function ($payment) {
            if (empty($payment->invoice_id)) {
                $year = date('Y');
                $lastId = DB::table('payments')->max('id') ?? 0;
                $nextId = $lastId + 1;
                $payment->invoice_id = 'NQ_' . $year . str_pad($nextId, 6, '0', STR_PAD_LEFT);
            }
        });
    }

    /**
     * 🔹 المستخدم صاحب عملية الدفع
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function membershipApplication()
    {
        return $this->hasOne(MembershipApplication::class);
    }

    /**
     * 🔹 العنصر المرتبط بالدفع (عضوية / فعالية / مكتبة رقمية ...)
     */
    public function payable()
    {
        return $this->morphTo();
    }

    /**
     * 🔹 هل الدفع ناجح؟
     */
    public function isPaid(): bool
    {
        return $this->status->isPaid();
    }

    /**
     * 🔹 هل الدفع فشل؟
     */
    public function isFailed(): bool
    {
        return $this->status->isFailed();
    }

    /**
     * 🔹 هل الدفع تم استرجاعه؟
     */
    public function isRefunded(): bool
    {
        return $this->status->isRefunded();
    }

    /**
     * 🔹 رابط المعاملة (إذا توفر)
     */
    public function getTransactionUrlAttribute(): ?string
    {
        return $this->raw_response['data']['source']['transaction_url'] ?? null;
    }

    /**
     * 🔹 رسالة الحالة (إذا توفر)
     */
    public function getMessageAttribute(): ?string
    {
        return $this->raw_response['data']['source']['message'] ?? null;
    }
}
