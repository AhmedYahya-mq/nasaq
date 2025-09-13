<?php

namespace App\Http\Controllers\User;

use App\Contract\User\Request\MembershipRequest;
use App\Contract\User\Response\MembershipResponse;
use App\Http\Controllers\Controller;

class MembershipController extends Controller
{

    public function index(): MembershipResponse
    {
        return app(MembershipResponse::class);
    }

    public function store(MembershipRequest $request)
    {
        $membership = \App\Models\Membership::create($request->all());
        return app(MembershipResponse::class)->toResponseMembership($membership);
    }

    public function update(MembershipRequest $request, \App\Models\Membership $membership)
    {
        $membership->update($request->all());
        return app(MembershipResponse::class)->toResponseMembership($membership);
    }

    public function updateTranslation(MembershipRequest $request, \App\Models\Membership $membership)
    {
        $data = $request->only(['name', 'description', 'requirements', 'features']);
        foreach ($data as $field => $value) {
            if (is_array($value)) {
                foreach ($value as $locale => $translation) {
                    $membership->setTranslation($field, $locale, $translation);
                }
            }
        }
        $membership->save();
        return app(MembershipResponse::class)->toResponseMembership($membership);
    }

    public function destroy(int $id)
    {
        $membership = \App\Models\Membership::findOrFail($id);
        $membership->delete();
    }
}
