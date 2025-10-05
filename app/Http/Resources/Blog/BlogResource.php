<?php

namespace App\Http\Resources\Blog;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource
{
    public static $wrap = null;
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return  [
            'id' => $this->id,
            'title' => $this->title,
            'title_en' => $this->translateField('title', 'en') ?? '',
            'content' => $this->content,
            'content_en' => $this->translate('content', 'en') ?? '',
            'excerpt' => $this->excerpt,
            'excerpt_en' => $this->translateField('excerpt', 'en') ?? '',
            'slug' => $this->slug,
            'image' => $this->firstPhoto(),
            'views' => $this->views,
            'author' => $this->admin ? $this->admin->name : null,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
