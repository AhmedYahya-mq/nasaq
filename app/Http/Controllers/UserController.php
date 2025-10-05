<?php

namespace App\Http\Controllers;

use App\Contract\User\Request\UserRequest;
use App\Contract\User\Response\UserResponse;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        return app(UserResponse::class);
    }

    public function toogleBlock(User $user)
    {
        $user->update(['is_active' => !$user->is_active]);
        return app(UserResponse::class)->toResponseMemberJson($user);
    }

    public function show(User $user)
    {
        return app(UserResponse::class)->toResponseMemberDatails($user);
    }

    public function upgradeMembership(Request $request, User $user)
    {
        $request->validate([
            'membership_id' => 'required|exists:memberships,id|different:' . $user->membership_id,
            'upgrade_type' => 'required|in:upgrade_extend,upgrade_only,upgrade_with_balance,upgrade_with_extra_payment',
        ], [
            'membership_id.different' => 'يجب اختيار عضوية مختلفة عن العضوية الحالية',
            'upgrade_type.in' => 'نوع الترقية غير صالح',
        ]);
        try {
            $membership = \App\Models\Membership::findOrFail($request->membership_id);
            $user->upgradeMembership($membership, $request->upgrade_type);
            return app(UserResponse::class)->toResponseMemberDatails($user->refresh());;
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    // الاشتراك في عضوية
    public function subscribeMembership(Request $request, User $user)
    {
        $request->validate([
            'membership_id' => 'required|exists:memberships,id',
        ]);
        try {
            $user->subscribeMembership($request->membership_id);
            return app(UserResponse::class)->toResponseMemberDatails($user);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    // تجديد عضوية
    public function renewMembership(Request $request, User $user)
    {
        try {
            $user->renewMembership();
            return app(UserResponse::class)->toResponseMemberDatails($user);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function store(UserRequest $request)
    {
        return app(UserResponse::class)->toResponseMember(User::create($request->all()));
    }

    public function update(UserRequest $request, User $user)
    {
        $user->update($request->all());
        return app(UserResponse::class)->toResponseMember($user);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->noContent();
    }
}
