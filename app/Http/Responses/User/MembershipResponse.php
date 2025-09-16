<?php

namespace App\Http\Responses\User;

use App\Contract\User\Resource\MembershipCollection;
use App\Contract\User\Resource\MembershipResource;
use App\Contract\User\Response\MembershipResponse as ResponseMembershipResponse;
use App\Models\Membership;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response;

/** @package App\Http\Responses\User */
class MembershipResponse implements ResponseMembershipResponse
{

    /**
     *
     * @return Response
     */
    public function toResponseMembership(Membership $membership)
    {
        return Inertia::render('user/memberships/membership', [
            'membership' => app(MembershipResource::class, ['resource' => $membership])
        ])->with('success', __('Membership created successfully'));
    }

    /**
     * Create an HTTP response that represents the object.
     */
    public function toResponse($request, ?Membership $membership = null)
    {
        $data['memberships'] = app(MembershipCollection::class, ['resource' => Membership::all()]);
        return Inertia::render('user/memberships/membership', $data)->toResponse($request);
    }
}
