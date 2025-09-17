<?php
namespace App\Http\Responses\AuthClient;
use Laravel\Fortify\Contracts\RegisterViewResponse as ContractsRegisterViewResponse;
class RegisterViewResponse implements ContractsRegisterViewResponse
{
    /**
     * Create an HTTP response that represents the object.
     */
    public function toResponse($request)
    {
        return view('auth.register');
    }
}
