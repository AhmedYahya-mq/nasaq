<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\PaymentStatus;
use Symfony\Component\HttpKernel\Exception\HttpException;

class EventRegistration extends Model
{
    protected $fillable = [
        'event_id', 'user_id', 'payment_id', 'is_attended',
        'joined_at', 'join_ip', 'join_link'
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected $casts = [
        'joined_at' => 'datetime',
        'is_attended' => 'boolean',
    ];

    protected $dates = [
        'joined_at',
    ];



    public function scopeAttended($query)
    {
        return $query->where('is_attended', true);
    }
    public function scopeNotAttended($query)
    {
        return $query->where('is_attended', false);
    }

    public function attendedCount()
    {
        return $this->where('is_attended', true)->count();
    }

    public function notAttendedCount()
    {
        return $this->where('is_attended', false)->count();
    }

    public function presentageAttended()
    {
        $total = $this->count();
        if ($total === 0) {
            return 0;
        }
        return round(($this->attended_count / $total) * 100, 2);
    }

    // داله تقوم بنشاء تسجيل جديد للمستخدم في الحدث
    public static function registerUserToEvent(int $eventId, int $userId, ?int $paymentId = null, ?string $joinIp = null, ?string $joinLink = null)
    {
        $event = Event::find($eventId);
        $user = User::find($userId);

        if (!$event || !$user) {
            throw new HttpException(404, 'Event or user not found');
        }

        $requiresPayment = !$event->isFreeForUser($user);
        if ($requiresPayment) {
            if (!$paymentId) {
                throw new HttpException(402, 'Payment required');
            }

            $valid = Payment::query()
                ->whereKey($paymentId)
                ->where('user_id', $userId)
                ->where('payable_type', Event::class)
                ->where('payable_id', $eventId)
                ->where('status', PaymentStatus::Paid)
                ->exists();

            if (!$valid) {
                throw new HttpException(403, 'Payment not verified');
            }
        } else {
            // Even if the event is free-for-user, create a paid 0-amount invoice record for auditing/invoices.
            if (!$paymentId) {
                $paymentId = Payment::createFreeInvoiceForUserPayable(
                    $userId,
                    $event,
                    'Free event registration'
                )->id;
            }
        }

        $registration = self::firstOrCreate(
            [
                'event_id' => $eventId,
                'user_id' => $userId,
            ],
            [
                'payment_id' => $paymentId,
                'join_ip' => $joinIp,
                'join_link' => $joinLink,
                'joined_at' => now(),
                'is_attended' => true,
            ]
        );

        // Backfill payment_id for old free registrations.
        if ($paymentId && !$registration->payment_id) {
            $registration->payment_id = $paymentId;
            $registration->save();
        }

        return $registration;
    }
}
