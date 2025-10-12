<?php

namespace App\Http\Resources\EventRegistration;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventRegistrationResource extends JsonResource implements \App\Contract\User\Resource\EventRegistrationResource
{
    public static $wrap = 'registration';
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'joined_at' => $this->joined_at,
            'join_ip' => $this->join_ip,
            'join_link' => $this->join_link,
            'is_attended' => $this->is_attended,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'user' => [
                'id' => $this->user->id,
                'member_id' => $this->user->member_id,
                'name' => $this->user->name,
                'email' => $this->user->email,
                'phone' => $this->user->phone,
                'profile_photo_url' => $this->user->profile_photo_url,
                'profile_link' => route('admin.members.show', ['user' => $this->user]),
                'membership_status' => $this->user->membership_status,
                'membership' => $this->user->Membership_name,
            ],
        ];
    }
}
