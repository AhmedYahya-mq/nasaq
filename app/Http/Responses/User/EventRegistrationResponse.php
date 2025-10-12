<?php

namespace App\Http\Responses\User;

use App\Contract\User\Resource\EventRegistrationCollection;
use App\Contract\User\Resource\EventRegistrationResource;
use App\Models\EventRegistration;

class EventRegistrationResponse implements \App\Contract\User\Response\EventRegistrationResponse
{
    public function toResponseJson() {}

    public function toResponseUser($request) {}

    public function toStoreResponse(EventRegistration $register)
    {
        return app(EventRegistrationResource::class, ['resource' => $register]);
    }

    public function toResponse($request, $id = null)
    {
        $search = $request->query('search', '');
        $resources = EventRegistration::with(['event', 'user'])
            ->where('event_id', $id)
            ->where(function ($query) use ($search) {
                $query->whereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', "%$search%")
                        ->orWhere('phone', 'like', "%$search%")
                        ->orWhere('email', 'like', "%$search%")
                        ->orWhere('member_id', 'like', "%$search%");
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate($request->get('per_page', 1));
        return  app(EventRegistrationCollection::class, ['resource' => $resources]);
    }
}
