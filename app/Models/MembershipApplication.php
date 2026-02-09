<?php

namespace App\Models;

use App\Enums\EmploymentStatus;
use App\Enums\MembershipApplication as EnumsMembershipApplication;
use App\Traits\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use RuntimeException;

/** @package App\Models */
class MembershipApplication extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'uuid',
        'user_id',
        'membership_id',
        'payment_id',
        'national_id',
        'employment_status',
        'current_employer',
        'scfhs_number',
        'status',
        'is_resubmit',
        'submitted_at',
        'reviewed_at',
        'admin_notes',
    ];

    protected $casts = [
        'status' => EnumsMembershipApplication::class,
        'employment_status' => EmploymentStatus::class,
        'submitted_at' => 'datetime',
        'reviewed_at' => 'datetime',
        'is_resubmit' => 'boolean',
    ];



    protected static function booted()
    {
        static::creating(function ($model) {
            if (empty($model->submitted_at)) {
                $model->submitted_at = now();
            }
        });

        static::created(function ($model) {
            $model->sendRequestStatusNotification();
        });

        static::addGlobalScope('latest', function ($builder) {
            $builder->orderBy('submitted_at', 'desc');
        });
    }


    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    // is payment done?
    public function isPaymentDone()
    {
        return $this->payment && $this->payment->isPaid();
    }

    /**
     * الدوال الأساسية: العلاقات مع النماذج الأخرى
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function membership()
    {
        return $this->belongsTo(Membership::class);
    }


    public function getMembershipTypeAttribute()
    {
        return $this->membership ? $this->membership->name : null;
    }

    public function files()
    {
        return $this->hasMany(MembershipFile::class);
    }

    /**
     * الملفات المعتمدة فقط
     */
    public function approvedFiles()
    {
        return $this->files()->whereNotNull('approved_at');
    }

    /**
     * @param string|null $reason
     * @return void
     */
    protected function cancelOtherApplications(string $reason = ''): void
    {
        self::where('user_id', $this->user_id)
            ->where('id', '!=', $this->id)
            ->where('status', EnumsMembershipApplication::Pending)
            ->update([
                'status' => EnumsMembershipApplication::Cancelled,
                'reviewed_at' => now(),
                'admin_notes' => $reason,
            ]);
    }

    /**
     * اعتماد الطلب
     */
    public function approve()
    {
        $membership = $this->membership;
        if ($membership && (int) ($membership->regular_price_in_halalas ?? 0) > 0) {
            if (!$this->isPaymentDone()) {
                throw new RuntimeException('لا يمكن اعتماد الطلب بدون دفع ناجح.');
            }

            $payment = $this->payment;
            if (!$payment
                || (int) $payment->user_id !== (int) $this->user_id
                || $payment->payable_type !== Membership::class
                || (int) $payment->payable_id !== (int) $this->membership_id
                || !$payment->isPaid()) {
                throw new RuntimeException('سجل الدفع غير صالح لهذا الطلب.');
            }
        }

        DB::transaction(function () {
            $this->update([
                'status' => EnumsMembershipApplication::Approved,
                'reviewed_at' => now(),
                'admin_notes' => null,
            ]);
            // إلغاء الطلبات الأخرى برسالة رسمية طويلة
            $this->cancelOtherApplications(
                'تم إلغاء هذا الطلب تلقائيًا نظرًا لاعتماد طلب آخر من نفس المستخدم. ' .
                    'وبناءً على سياسة النظام، يسمح بموافقة طلب واحد فقط لكل مستخدم في أي وقت، ' .
                    'لذلك تم إلغاء جميع الطلبات الأخرى التي كانت قيد الانتظار. ' .
                    'الطلب الملغى لن يؤثر على حالة العضوية الحالية، ويمكن مراجعة الطلبات الملغاة ضمن سجل الطلبات.'
            );
            // تفعيل العضوية الجديدة
            $user = $this->user;
            $newMembership = $this->membership;

            // Determine and apply the correct membership operation (new/renewal/upgrade/downgrade)
            $change = $user->calculateMembershipChange($newMembership);

            $user->update([
                'membership_id' => $newMembership->id,
                'membership_started_at' => now(),
                'membership_expires_at' => $change['newExpiresAt'],
            ]);
            $this->sendRequestStatusNotification();
        });
    }

    /**
     * رفض الطلب
     * @param string|null $notes
     */
    public function reject($notes = null)
    {
        DB::transaction(function () use ($notes) {
            $this->update([
                'status' => EnumsMembershipApplication::Rejected,
                'reviewed_at' => now(),
                'admin_notes' => $notes,
            ]);
            // إلغاء الطلبات الأخرى برسالة رسمية طويلة
            $this->cancelOtherApplications(
                'تم إلغاء هذا الطلب تلقائيًا نظرًا لرفض طلب آخر من نفس المستخدم. ' .
                    'وفقًا لسياسة النظام، يسمح بوجود طلب واحد نشط لكل مستخدم في أي وقت. ' .
                    'لذلك تم إلغاء جميع الطلبات الأخرى التي كانت قيد الانتظار. ' .
                    'الطلبات الملغاة لا تؤثر على العضويات الحالية، ويمكن مراجعتها ضمن سجل الطلبات.'
            );
            $this->sendRequestStatusNotification();
        });
    }

    /**
     * Scope
     */
    public function scopePending($q)
    {
        return $q->where('status', EnumsMembershipApplication::Pending);
    }

    public function scopeApproved($q)
    {
        return $q->where('status', EnumsMembershipApplication::Approved);
    }

    public function scopeRejected($q)
    {
        return $q->where('status', EnumsMembershipApplication::Rejected);
    }

    public function scopeCancelled($q)
    {
        return $q->where('status', EnumsMembershipApplication::Cancelled);
    }

    public function scopeNotDraft($query)
    {
        return $query->where('status', '<>', EnumsMembershipApplication::Draft);
    }

    /**
     * أمثلة استخدام
     */
    /*
    $application->approvedFiles()->get(); // الملفات المعتمدة
    $application->approve(); // اعتماد الطلب
    $application->reject('سبب الرفض'); // رفض الطلب
    MembershipApplication::pending()->count(); // عدد الطلبات المعلقة
    */

    public function sendRequestStatusNotification()
    {
        try {
            $this->user->notify(new \App\Notifications\UserRequestStatusNotification($this));
        } catch (\Throwable $e) {
            Log::error("Failed to send notification: " . $e->getMessage());
        }
    }

    // داخل الموديل MembershipApplication
    public static function filterQuery($params = [], $builder = null)
    {
        $query = $builder ?? self::query();

        // فلترة حسب العضو
        if (!empty($params['member_id'])) {
            $query->where('user_id', $params['member_id']);
        }

        // فلترة حسب الحالة
        if (!empty($params['status']) && $params['status'] !== 'all') {
            $query->where('status', $params['status']);
        }

        // فلترة حسب البحث
        if (!empty($params['search'])) {
            $search = $params['search'];
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($uq) use ($search) {
                    $uq->where('name', 'like', "%$search%")
                        ->orWhere('email', 'like', "%$search%")
                        ->orWhere('phone', 'like', "%$search%");
                })
                    ->orWhereHas('membership', function ($mq) use ($search) {
                        $mq->where('name', 'like', "%$search%");
                    });
            });
        }

        return $query;
    }

    public static function paginateFiltered($params = [], $perPage = 10, $builder = null)
    {
        $query = self::filterQuery($params, $builder);
        return $query->paginate($perPage);
    }

    // إضافة Scope على Builder
    public function scopePaginateFiltered($query, $params = [], $perPage = 10)
    {
        return self::filterQuery($params, $query)->paginate($perPage);
    }
}
