<?php

namespace App\Actions\Fortify;

use App\Http\Requests\TwoFactorLoginRequest;
use App\Http\Responses\Auth\FailedTwoFactorLoginResponse;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use Laravel\Fortify\Contracts\TwoFactorLoginResponse;
use Laravel\Fortify\Events\RecoveryCodeReplaced;
use Laravel\Fortify\Events\TwoFactorAuthenticationFailed;
use Laravel\Fortify\Events\ValidTwoFactorAuthenticationCodeProvided;

class TwoFactorAuthenticatedSessionController extends Controller
{
    /**
     * The guard implementation.
     *
     * @var \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected $guard;

    /**
     * Create a new controller instance.
     *
     * @param  \Illuminate\Contracts\Auth\StatefulGuard  $guard
     * @return void
     */
    public function __construct(StatefulGuard $guard)
    {
        $this->guard = $guard;
    }

    /**
     * Show the two factor authentication challenge view.
     *
     * @param  \App\Http\Requests\TwoFactorLoginRequest  $request
     * @return \Laravel\Fortify\Contracts\TwoFactorChallengeViewResponse
     */
    public function create(TwoFactorLoginRequest $request)
    {
        if (!$request->hasChallengedUser()) {
            throw new HttpResponseException(redirect()->route('admin.login'));
        }
        return Inertia::render('auth/two-factor-challenge', [
            'guard' => 'admin'
        ]);
    }

    /**
     * Attempt to authenticate a new session using the two factor authentication code.
     *
     * @param  \Laravel\Fortify\Http\Requests\TwoFactorLoginRequest  $request
     * @return mixed
     */
    public function store(TwoFactorLoginRequest $request)
    {
        $user = $request->challengedUser();
        if ($code = $request->validRecoveryCode()) {
            $user->replaceRecoveryCode($code);

            event(new RecoveryCodeReplaced($user, $code));
        } elseif (! $request->hasValidCode()) {
            event(new TwoFactorAuthenticationFailed($user));

            return app(FailedTwoFactorLoginResponse::class)->toResponse($request, "admin.two-factor.login");
        }

        event(new ValidTwoFactorAuthenticationCodeProvided($user));

        $this->guard->login($user, $request->remember());

        $request->session()->regenerate();

        return app(TwoFactorLoginResponse::class);
    }
}
