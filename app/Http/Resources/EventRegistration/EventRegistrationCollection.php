<?php

namespace App\Http\Resources\EventRegistration;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class EventRegistrationCollection extends ResourceCollection
{
    public static $wrap = 'registrations';
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request)
    {
        return $this->collection->map(function ($item) use ($request) {
            return app(\App\Contract\User\Resource\EventRegistrationResource::class, ['resource' => $item]);
        })->all();
    }
}
