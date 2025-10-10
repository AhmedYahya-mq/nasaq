<?php

namespace App\Http\Resources\Event;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class EventCollection extends ResourceCollection
{
    public static $wrap = null;
    protected $minimal = false;


    public function __construct($resource, $minimal = false)
    {
        parent::__construct($resource);
        $this->minimal = $minimal;
    }
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
         return $this->collection->map(function ($item) use ($request) {
            return app(\App\Contract\User\Resource\EventResource::class, ['resource' => $item, 'minimal' => $this->minimal]);
        })->all();
    }
}
