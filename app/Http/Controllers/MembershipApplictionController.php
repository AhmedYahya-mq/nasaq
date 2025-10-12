<?php

namespace App\Http\Controllers;

use App\Contract\Actions\MembershipRequestAction;
use App\Contract\User\Request\MembershipAppRequest;
use App\Contract\User\Response\MembershipApplicationResponse;
use App\Models\MembershipApplication;
use App\Models\Payment;
use Illuminate\Http\Request;

class MembershipApplictionController extends Controller
{
    public function index()
    {
        return app(MembershipApplicationResponse::class);
    }


    public function approve(MembershipApplication $application)
    {
        $application->approve();
        return app(MembershipApplicationResponse::class)->toResponseApprove($application);
    }

    public function reject(Request $request, MembershipApplication $application)
    {
        $request->validate([
            'note' => ['required', 'string', 'max:255'],
        ]);
        $application->reject($request->note);
        return app(MembershipApplicationResponse::class)->toResponseReject($application);
    }

    public function create(MembershipApplication $application)
    {
        return app(MembershipApplicationResponse::class)->toCreate($application);
    }

    public function store(MembershipAppRequest $request, MembershipApplication $application, MembershipRequestAction $action)
    {
        return $action->execute($request, $application);
    }

    public function resubmit(MembershipApplication $application,  MembershipRequestAction $action)
    {
        return $action->resubmit($application);
    }
}
