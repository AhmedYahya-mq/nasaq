<?php

namespace App\Http\Resources\Event;

use App\Contract\User\Resource\EventRegistrationCollection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    public static $wrap = 'event';
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
        return [
            'id' => $this->id,
            'ulid' => $this->ulid,
            'name' => $this->title,
            'title' => $this->title_ar,
            'title_en' => $this->title_en,
            'description' => $this->description_ar,
            'description_en' => $this->description_en,
            'event_type' => [
                'label' => $this->event_type?->label('en'),
                'value' => $this->event_type?->value,
                'label_ar' => $this->event_type?->label('ar'),
                'color' => $this->event_type?->color(),
                'icon' => $this->event_type?->icon(),
                'name' => $this->event_type?->label(),
            ],
            'event_category' => [
                'label' => $this->event_category?->label('en'),
                'value' => $this->event_category?->value,
                'label_ar' => $this->event_category?->label('ar'),
                'color' => $this->event_category?->color(),
                'icon' => $this->event_category?->icon(),
            ],
            'event_method' => [
                'label' => $this->event_method?->label('en'),
                'value' => $this->event_method?->value,
                'label_ar' => $this->event_method?->label('ar'),
                'color' => $this->event_method?->color(),
                'icon' => $this->event_method?->icon(),
                'name' => $this->event_method?->label(),
            ],
            'event_status' => [
                'label' => $this->event_status?->label('en'),
                'value' => $this->event_status?->value,
                'color' => $this->event_status?->color(),
                'icon' => $this->event_status?->icon(),
                'label_ar' => $this->event_status?->label('ar')
            ],
            'membership_names' => $this->memberships->pluck('name'),
            'membership_ids' => $this->memberships->pluck('id'),
            'link' => $this->link,
            'address' => $this->address_ar,
            'address_en' => $this->address_en,
            'start_at' => $this->start_at,
            'start_date' => $this->start_at->locale(app()->getLocale())->translatedFormat('d F Y h:i A'),
            'can_register' => $this->canUserRegister(),
            'is_registered' => $this->isUserRegistered($request->user()->id ?? 0),
            'end_at' => $this->end_at,
            'capacity' => $this->capacity ?? 0,
            'price' => $this->price,
            'discount' => $this->discount,
            'final_price' => $this->final_price,
            'is_featured' => $this->is_featured,
            'is_full' => $this->isFull(),
            'registrations_count' => $this->registrations_count,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    public function with($request)
    {
        if($this->minimal) {
            return [];
        }
        return [
            'registrations' => app(EventRegistrationCollection::class, ['resource' => $this->whenLoaded('registrations')]),
            'attended_count' => $this->attended_count,
            'not_attended_count' => $this->not_attended_count,
            'presentage_attended' => $this->presentage_attended,
        ];
    }
}
