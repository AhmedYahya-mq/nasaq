<?php

namespace App\Http\Responses\Auth;

use App\Contract\Auth\PasswordResetResponse as PasswordResetResponseContract;
use Illuminate\Http\JsonResponse;
use Laravel\Fortify\Fortify;

class PasswordResetResponse implements PasswordResetResponseContract
{
    /**
     * The response status language key.
     *
     * @var string
     */
    protected $status;

    /**
     * Create a new response instance.
     *
     * @param  string  $status
     * @return void
     */
    public function __construct(string $status)
    {
        $this->status = $status;
    }

    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        return  to_route('admin.login')->with('status', __($this->status));
    }
}
