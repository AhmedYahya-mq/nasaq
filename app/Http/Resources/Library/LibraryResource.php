<?php

namespace App\Http\Resources\Library;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LibraryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->ulid,
            'ulid' => $this->ulid,
            'status' => [
                'label' => $this->status->label('en'),
                'label_ar' => $this->status->label('ar'),
                'value'=> $this->status->value,
            ],
            'type' =>[
                'label' => $this->type->label('en'),
                'label_ar' => $this->type->label('ar'),
                'value'=> $this->type->value,
            ],
            'title' => $this->title_ar,
            'title_en' => $this->title_en,
            'description' => $this->description_ar,
            'description_en' => $this->description_en,
            'author' => $this->author_ar,
            'author_en' => $this->author_en,
            'path' => $this->path,
            'price' => $this->price,
            'discount' => $this->discount,
            'is_free' => $this->isFree(),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
