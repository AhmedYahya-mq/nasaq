<?php

namespace App\Http\Responses\User;

use App\Contract\User\Resource\MembershipApplicationCollection;
use App\Contract\User\Resource\MembershipApplicationResource;
use App\Contract\User\Response\MembershipApplicationResponse as ResponseMembershipApplicationResponse;
use App\Models\MembershipApplication;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response;

/** @package App\Http\Responses\User */
class MembershipApplicationResponse implements ResponseMembershipApplicationResponse
{

    /**
     *
     * @return Response
     */
    public function toResponseMembership(MembershipApplication $membership)
    {
        return Inertia::render('user/memberships/membership', [
            'membership' => app(MembershipApplicationResource::class, ['resource' => $membership])
        ])->with('success', __('Membership created successfully'));
    }

    /**
     * Create an HTTP response that represents the object.
     */
    public function toResponse($request)
    {
        $params = $request->only(['member_id', 'status', 'search', 'page', 'type_api']);
        $paginator = \App\Models\MembershipApplication::notDraft()->paginateFiltered($params, 10);
        if ($request->header('type-api') === 'api') {
            $array = $paginator->toArray();
            $meta = [
                'current_page' => $array['current_page'],
                'from' => $array['from'],
                'last_page' => $array['last_page'],
                'per_page' => $array['per_page'],
                'path' => $array['path'],
                'last_page' => $array['last_page'],
                'links' => [
                    'first' => $array['first_page_url'],
                    'last' => $array['last_page_url'],
                    'prev' => $array['prev_page_url'],
                    'next' => $array['next_page_url'],
                ],
                'to' => $array['to'],
                'total' => $array['total'],
            ];
            $collection = app(MembershipApplicationCollection::class, ['resource' => $paginator]);
            // أرجع البيانات بشكل array مع meta و links
            return response()->json([
                'data' => $collection,
                'meta' => $meta,
                'links' => $meta['links'],
            ]);
        }

        $data['applications'] = app(MembershipApplicationCollection::class, [
            'resource' => $paginator
        ]);
        $data['filters'] = $params;
        if (session()->has('application')) {
            $data['application'] = session('application');
        }
        return Inertia::render('user/memberships/Applications', $data)->toResponse($request);
    }


    public function toResponseApprove($application)
    {
        return back()->with([
            'message' => 'تمت الموافقة على الطلب بنجاح.',
            'alert-type' => 'success',
            'application' => app(MembershipApplicationResource::class, ['resource' => $application]),
        ]);
    }
    public function toResponseReject($application)
    {
        return back()->with([
            'message' => 'تم رفض الطلب بنجاح.',
            'alert-type' => 'success',
            'application' => app(MembershipApplicationResource::class, ['resource' => $application]),
        ]);
    }


    public function toCreate(MembershipApplication $application)
    {
        return view('membership_request',[
            'application' => $application ?? new MembershipApplication(),
        ]);
    }
}
