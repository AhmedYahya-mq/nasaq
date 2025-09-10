<?php

namespace App\Http\Requests;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\FailedTwoFactorLoginResponse;
use Laravel\Fortify\Http\Requests\TwoFactorLoginRequest as RequestsTwoFactorLoginRequest;

class TwoFactorLoginRequest extends RequestsTwoFactorLoginRequest
{
    protected $guard;
    public function __construct()
    {
        $this->guard = Auth::guard('admin');
    }

    /**
     * Determine if there is a challenged user in the current session.
     *
     * @return bool
     */
    public function hasChallengedUser()
    {
        if ($this->challengedUser) {
            return true;
        }

        $model = $this->guard->getProvider()->getModel();

        return $this->session()->has('login.id') &&
            $model::find($this->session()->get('login.id'));
    }

    /**
     * Get the user that is attempting the two factor challenge.
     *
     * @return mixed
     */
    public function challengedUser()
    {
        if ($this->challengedUser) {
            return $this->challengedUser;
        }

        $model = $this->guard->getProvider()->getModel();

        if (
            ! $this->session()->has('login.id') ||
            ! $user = $model::find($this->session()->get('login.id'))
        ) {
            throw new HttpResponseException(
                app(FailedTwoFactorLoginResponse::class)->toResponse($this)
            );
        }

        return $this->challengedUser = $user;
    }

    public function prepareForValidation()
    {
        if ($this->has('code')) {
            $this->merge([
                'code' => str_replace('-', '', $this->code)
            ]);
        }
        if ($this->has('recovery_code')) {
            $this->merge([
                'code' => str_replace('-', '', $this->recovery_code)
            ]);
        }
    }
}
