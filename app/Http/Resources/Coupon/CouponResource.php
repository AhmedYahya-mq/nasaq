<?php

namespace App\Http\Resources\Coupon;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CouponResource extends JsonResource
{
    public static $wrap = 'coupon';

    public function toArray(Request $request): array
    {
        $now = now();
        $startsAt = $this->starts_at;
        $expiresAt = $this->expires_at;
        $hasStarted = $startsAt ? $startsAt->lte($now) : true;
        $notExpired = $expiresAt ? $expiresAt->gte($now) : true;
        $statusValue = $hasStarted && $notExpired ? 'active' : ($expiresAt && $expiresAt->lt($now) ? 'expired' : 'scheduled');
        $statusLabelAr = match ($statusValue) {
            'active' => 'ساري',
            'expired' => 'منتهي',
            default => 'لم يبدأ بعد',
        };
        $statusColor = match ($statusValue) {
            'active' => '#16a34a',
            'expired' => '#ef4444',
            default => '#f59e0b',
        };

        $appliesLabel = match ($this->applies_to) {
            'event' => 'الفعاليات',
            'membership' => 'العضويات',
            'library' => 'المكتبة',
            default => 'الكل',
        };

        return [
            'id' => $this->id,
            'code' => $this->code,
            'discount_type' => $this->discount_type,
            'value' => $this->value,
            'applies_to' => $this->applies_to,
            'applies_to_label' => $appliesLabel,
            'max_uses' => $this->max_uses,
            'used_count' => $this->used_count,
            'remaining_uses' => $this->max_uses ? max($this->max_uses - $this->used_count, 0) : null,
            'starts_at' => $startsAt,
            'expires_at' => $expiresAt,
            'status' => [
                'value' => $statusValue,
                'label_ar' => $statusLabelAr,
                'color' => $statusColor,
            ],
            'is_active' => $statusValue === 'active',
            'discount_display' => $this->discount_type === 'percent' ? ($this->value . '%') : $this->value,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
