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
        $query = User::query();

        // إذا جاء بحث
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('member_id', 'like', "%{$search}%"); // إضافة member_id
            });
        }

        // ترتيب حسب الأحدث
        $query->orderBy('created_at', 'desc');
        $perPage = 15;
        $users = $query->paginate($perPage) ->withQueryString();
        return Inertia::render('user/memberships/Members', ['members' => app(UserCollection::class, ['resource' => $users,  'minimal' => true])])->toResponse($request);
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
