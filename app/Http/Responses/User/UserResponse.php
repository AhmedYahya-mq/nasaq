<?php

namespace App\Http\Responses\User;

use App\Contract\User\Resource\UserCollection;
use App\Contract\User\Resource\UserResource;
use App\Models\User;
use Inertia\Inertia;

class UserResponse implements \App\Contract\User\Response\UserResponse
{

    public function toResponse($request)
    {
        $data['members'] = app(UserCollection::class, ['resource' => User::orderBy('created_at', 'desc')->get(), 'minimal' => true]);
        return Inertia::render('user/memberships/Members', $data)->toResponse($request);
    }

    public function toResponseMember(User $user)
    {
        return Inertia::render('user/memberships/Members', [
            'member' => app(UserResource::class, ['resource' => $user, 'minimal' => true])
        ]);
    }


    public function toResponseMemberDatails(User $user)
    {
        return Inertia::render('user/userDetails', [
            'member' => app(UserResource::class, ['resource' => $user])
        ]);
    }



    public function toResponseMemberJson(User $user)
    {
        return response()->json([
            'member' => app(UserResource::class, ['resource' => $user, 'minimal' => true])
        ]);
    }
}
