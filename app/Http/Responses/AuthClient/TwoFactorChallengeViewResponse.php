<?php
namespace App\Http\Responses\AuthClient;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Laravel\Fortify\Contracts\TwoFactorChallengeViewResponse as ContractsTwoFactorChallengeViewResponse;

class TwoFactorChallengeViewResponse implements ContractsTwoFactorChallengeViewResponse
{
    /**
     * Create an HTTP response that represents the object.
     */
    public function toResponse($request)
    {
        return view('auth.two-factor-challenge-section');
    }
}
