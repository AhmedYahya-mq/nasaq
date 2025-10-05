<?php

namespace App\Http\Controllers;

use App\Contract\User\Response\MembershipApplicationResponse;
use App\Models\MembershipApplication;
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
}
