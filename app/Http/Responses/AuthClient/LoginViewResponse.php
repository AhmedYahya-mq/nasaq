<?php
namespace App\Http\Responses\AuthClient;

use Laravel\Fortify\Contracts\LoginViewResponse as ContractsLoginViewResponse;

class LoginViewResponse implements ContractsLoginViewResponse
{
    /**
     * Create an HTTP response that represents the object.
     */
    public function toResponse($request)
    {
        return view('auth.login');
    }
}
