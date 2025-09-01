<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Validation\ValidationException;

class RequirePassword
{
    /**
     * The response factory instance.
     *
     * @var \Illuminate\Contracts\Routing\ResponseFactory
     */
    protected $responseFactory;

    /**
     * The URL generator instance.
     *
     * @var \Illuminate\Contracts\Routing\UrlGenerator
     */
    protected $urlGenerator;

    /**
     * The password timeout.
     *
     * @var int
     */
    protected $passwordTimeout;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Routing\ResponseFactory  $responseFactory
     * @param  \Illuminate\Contracts\Routing\UrlGenerator  $urlGenerator
     * @param  int|null  $passwordTimeout
     */
    public function __construct(ResponseFactory $responseFactory, UrlGenerator $urlGenerator, $passwordTimeout = null)
    {
        $this->responseFactory = $responseFactory;
        $this->urlGenerator = $urlGenerator;
        $this->passwordTimeout = $passwordTimeout ?: 10800;
    }

    /**
     * Specify the redirect route and timeout for the middleware.
     *
     * @param  string|null  $redirectToRoute
     * @param  string|int|null  $passwordTimeoutSeconds
     * @return string
     *
     * @named-arguments-supported
     */
    public static function using($guard = "web", $redirectToRoute = null, $passwordTimeoutSeconds = null)
    {
        return static::class . ':' . implode(',', func_get_args());
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param string|null $redirectToRoute
     * @param int|null $passwordTimeoutSeconds
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = "web", $redirectToRoute = null, $passwordTimeoutSeconds = null)
    {
        $password = $request->input('password');
        if (!is_null($password) || $this->shouldConfirmPassword($request, $guard, $passwordTimeoutSeconds)) {
            if (!$password || !Hash::check($password, $request->user($guard)?->password)) {
                if ($request->expectsJson()) {
                    return response()->json([
                        'message' => __('Password confirmation required.')
                    ], 423);
                }
                if (!is_null($redirectToRoute)) {
                    return  $this->responseFactory->redirectGuest(
                        $this->urlGenerator->route($redirectToRoute)
                    )->withErrors([
                        'password' => __('The provided password does not match our records.'),
                    ]);
                }
                throw ValidationException::withMessages([
                    'password' => __('The provided password does not match our records.'),
                ]);
            }
            $request->session()->put(
                "auth.password_confirmed_at.{$guard}",
                now()->timestamp
            );
        }

        return $next($request);
    }

    /**
     * Determine if the confirmation timeout has expired.
     *
     * @param \Illuminate\Http\Request $request
     * @param string $guard
     * @param int|null $passwordTimeoutSeconds
     * @return bool
     */
    protected function shouldConfirmPassword($request, string $guard, $passwordTimeoutSeconds = null)
    {
        $confirmedAt = $request->session()->get("auth.password_confirmed_at.{$guard}", 0);
        return (now()->timestamp - $confirmedAt) > ($passwordTimeoutSeconds ?? $this->passwordTimeout);
    }
}
