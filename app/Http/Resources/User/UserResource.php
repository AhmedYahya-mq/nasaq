<?php

namespace App\Http\Resources\User;

use App\Contract\User\Resource\MembershipApplicationCollection;
use App\Contract\User\Resource\MembershipApplicationResource;
use App\Contract\User\Resource\MembershipResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'name' => $this->name,
            'english_name' => $this->english_name,
            'gender' => $this->gender,
            'email' => $this->email,
            'profile_photo_url' => $this->profile_photo_url,
            'phone' => $this->phone,
            'birthday' => $this->birthday,
            'address' => $this->address,
            'job_title' => $this->job_title,
            'is_active' => $this->is_active,
            'bio' => $this->bio,
            'email_verified_at' => $this->email_verified_at,
            'two_factor_enabled' => $this->two_factor_enabled,
            'membership_name' => $this->membership_name ?? 'عضوية عادية',
            'membership_id' => $this->membership_id,
            'membership_status' => [
                'value' => $this->membership_status->value,
                'label' => $this->membership_status?->getLabel(),
                'label_ar' => $this->membership_status?->getLabelArabic(),
                'color' => $this->membership_status?->getColor(),
                'icon' => $this->membership_status?->getIcon(),
            ],
            'national_id' => $this->national_id,
            'current_employer' => $this->current_employer,
            'scfhs_number' => $this->scfhs_number,
            'membership_expires_at' => $this->membership_expires_at,
            'membership_started_at' => $this->membership_started_at,
            'membership_active' => $this->hasActiveMembership(),
            'employment_status' => [
                'label' => $this->employment_status?->getLabel() ?? 'غير محدد',
                'label_ar' => $this->employment_status?->getLabelArabic() ?? 'غير محدد',
                'color' => $this->employment_status?->getColor() ?? 'gray',
                'icon' => $this->employment_status?->getIcon() ?? 'default-icon',
                'value' => $this->employment_status?->value ?? null,
            ],
            'membership_Applications_count' => $this->membershipApplications()->count(),
            'remaining_days' => $this->remaining_days + 1, // +1 to include today
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];

        if (!$this->minimal) {
            $data['membership_Application'] = app(MembershipApplicationResource::class, ['resource' => $this->latestApprovedMembershipApplication()]);
        }

        return $data;
    }
}
