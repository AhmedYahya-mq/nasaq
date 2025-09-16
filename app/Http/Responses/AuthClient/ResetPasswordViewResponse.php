<?php
namespace App\Http\Responses\AuthClient;

use Laravel\Fortify\Contracts\ResetPasswordViewResponse as ContractsResetPasswordViewResponse;

class ResetPasswordViewResponse implements ContractsResetPasswordViewResponse
{
    /**
     * Create an HTTP response that represents the object.
     */
    public function toResponse($request)
    {
        return view('auth.reset-password', ['request' => $request]);
    }
}
