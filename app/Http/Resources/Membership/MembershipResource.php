<?php

namespace App\Http\Resources\Membership;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MembershipResource extends JsonResource
{
    public static $wrap = null;
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            // name ar and en
            'name' => $this->getTranslation('name','ar') ?? '',
            'name_en' => $this->getTranslation('name','en') ?? '',
            'description' => $this->getTranslation('description','ar') ?? '',
            'description_en' => $this->getTranslation('description','en') ?? '',
            'price' => $this->price,
            'discounted_price' => $this->discounted_price,
            'percent_discount' => $this->percent_discount * 100,
            'duration_days' => $this->duration_days,
            'requirements' => $this->getTranslation('requirements','ar') ?? [],
            'requirements_en' => $this->getTranslation('requirements','en') ?? [],
            'features' => $this->getTranslation('features','ar') ?? [],
            'features_en' => $this->getTranslation('features','en') ?? [],
            'level' => $this->level,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

}
