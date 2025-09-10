<?php
namespace App\Http\Responses\AuthClient;
use Laravel\Fortify\Contracts\RequestPasswordResetLinkViewResponse as ContractsRequestPasswordResetLinkViewResponse;

class RequestPasswordResetLinkViewResponse implements ContractsRequestPasswordResetLinkViewResponse
{
    /**
     * Create an HTTP response that represents the object.
     */
    public function toResponse($request)
    {
        return view('auth.forgot-password');
    }
}
