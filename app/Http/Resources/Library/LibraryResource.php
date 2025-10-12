<?php

namespace App\Http\Resources\Library;

use Ahmed\GalleryImages\Contracts\PhotoResourceContract;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LibraryResource extends JsonResource
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
            'ulid' => $this->ulid,
            'status' => [
                'label' => $this->status->label('en'),
                'label_ar' => $this->status->label('ar'),
                'value' => $this->status->value,
                'color' => $this->status->color(),
            ],
            'type' => [
                'label' => $this->type->label('en'),
                'label_ar' => $this->type->label('ar'),
                'value' => $this->type->value,
                'color' => $this->type->color(),
            ],
            'title' => $this->title_ar,
            'title_en' => $this->title_en,
            'description' => $this->description_ar,
            'description_en' => $this->description_en,
            'author' => $this->author_ar,
            'author_en' => $this->author_en,
            'user_count' => $this->users_count ?? 0,
            'poster' => app(PhotoResourceContract::class, ['resource' => $this->photo]),
            'path' => $this->path,
            'price' => $this->price,
            'discount' =>  $this->discount,
            'published_at' => $this->published_at,
            'year_published' => $this->year_published,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
