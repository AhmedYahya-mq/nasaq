<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventRegistration extends Model
{
    protected $fillable = [
        'event_id', 'user_id', 'is_attended',
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
    public static function registerUserToEvent($eventId, $userId, $joinIp = null, $joinLink = null)
    {
        return self::create([
            'event_id' => $eventId,
            'user_id' => $userId,
            'join_ip' => $joinIp,
            'join_link' => $joinLink,
            'joined_at' => now(),
            'is_attended' => true,
        ]);
    }
}
