<?php

namespace App\Http\Resources\MembershipApplication;

use App\Contract\User\Resource\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MembershipApplicationResource extends JsonResource
{
    public static $wrap = null;
    protected $minimal = false;

    public function __construct($resource, $minimal = false)
    {
        parent::__construct($resource);
        $this->minimal = $minimal;
    }
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $data = [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'membership_type' => $this->membership_type,
            'notes' => $this->notes,
            'national_id' => $this->national_id,
            'files' => $this->files,
            'current_employer' => $this->current_employer,
            'scfhs_number' => $this->scfhs_number,
            'submitted_at' => $this->submitted_at,
            'reviewed_at' => $this->reviewed_at,
            'admin_notes' => $this->admin_notes,
            'status' => [
                'value' => $this->status->value,
                'label' => $this->status->getLabel(),
                'label_ar' => $this->status->getLabelArabic(),
                'color' => $this->status->color(),
                'icon' => $this->status->icon(),
                'message' => $this->status->getStatusMessageArabic(),
            ],
            'created_at_human' => $this->created_at ? $this->created_at->diffForHumans() : null,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
        // Payment summary (optional)
        try {
            $payment = $this->payment ?? null;
            if ($payment) {
                $data['payment'] = [
                    'invoice_id' => $payment->invoice_id ?? null,
                    'amount' => $payment->amount ?? null,
                    'currency' => $payment->currency ?? null,
                    'original_price' => $payment->original_price ?? null,
                    'discount' => $payment->discount ?? null,
                    'membership_discount' => $payment->membership_discount ?? null,
                    'coupon_discount' => ($payment->coupon_discount ?? $payment->coupon_amount ?? null),
                    'coupon_code' => ($payment->coupon_code ?? optional($payment->coupon)->code ?? null),
                    'created_at' => $payment->created_at ?? null,
                    'status' => [
                        'value' => optional($payment->status)->value,
                        'label' => method_exists(optional($payment->status), 'label') ? $payment->status->label('en') : (string) optional($payment)->status,
                        'color' => method_exists(optional($payment->status), 'color') ? $payment->status->color() : null,
                    ],
                ];
            }
        } catch (\Throwable $e) {
            // silently ignore if relation not available
        }
        if (!$this->minimal) {
            $data['user'] = app(UserResource::class, ['resource' => $this->user, 'minimal' => true]);
            $data['employment_status'] = [
                'value' => $this->employment_status->value,
                'label' => $this->employment_status->getLabel(),
                'label_ar' => $this->employment_status->getLabelArabic(),
                'color' => $this->employment_status->getColor(),
                'icon' => $this->employment_status->getIcon(),
            ];
        }
        return $data;
    }
}
