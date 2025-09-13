<?php

namespace App\Providers;

use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;
use Illuminate\Auth\Middleware\RedirectIfAuthenticated;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $bindingResponses = [
            // Auth Admin
            \App\Contract\Auth\PasswordResetResponse::class => \App\Http\Responses\Auth\PasswordResetResponse::class,
            \App\Contract\Auth\FailedPasswordResetResponse::class => \App\Http\Responses\Auth\FailedPasswordResetResponse::class,
            \App\Contract\Auth\SuccessfulPasswordResetLinkRequestResponse::class => \App\Http\Responses\Auth\SuccessfulPasswordResetLinkRequestResponse::class,
            \App\Contract\Auth\FailedPasswordResetLinkRequestResponse::class => \App\Http\Responses\Auth\FailedPasswordResetLinkRequestResponse::class,
            \App\Contract\Auth\FailedTwoFactorLoginResponse::class => \App\Http\Responses\Auth\FailedTwoFactorLoginResponse::class,

            // Auth Client
            \Laravel\Fortify\Contracts\LoginViewResponse::class => \App\Http\Responses\AuthClient\LoginViewResponse::class,
            \Laravel\Fortify\Contracts\TwoFactorChallengeViewResponse::class => \App\Http\Responses\AuthClient\TwoFactorChallengeViewResponse::class,
            \Laravel\Fortify\Contracts\RequestPasswordResetLinkViewResponse::class => \App\Http\Responses\AuthClient\RequestPasswordResetLinkViewResponse::class,
            \Laravel\Fortify\Contracts\ResetPasswordViewResponse::class => \App\Http\Responses\AuthClient\ResetPasswordViewResponse::class,

            // profile client
            \App\Contract\User\Profile\PhotoResponse::class => \App\Http\Responses\User\Profile\PhotoResponse::class,

            // Response Admin
            \App\Contract\User\Response\MembershipResponse::class => \App\Http\Responses\User\MembershipResponse::class,
            \App\Contract\User\Response\BlogResponse::class => \App\Http\Responses\User\BlogResponse::class,

        ];
        $bindingRequests = [
            // user profile
            \App\Contract\User\Profile\PhotoRequest::class => \App\Http\Requests\User\Profile\PhotoRequest::class,
            // Membership
            \App\Contract\User\Request\MembershipRequest::class => \App\Http\Requests\User\MembershipRequest::class,
            // blog
            \App\Contract\User\Request\BlogRequest::class => \App\Http\Requests\User\BlogRequest::class,
        ];
        $bindingResources = [
            // Membership
            \App\Contract\User\Resource\MembershipResource::class => \App\Http\Resources\Membership\MembershipResource::class,
            \App\Contract\User\Resource\MembershipCollection::class => \App\Http\Resources\Membership\MembershipCollection::class,
            // blog
            \App\Contract\User\Resource\BlogResource::class => \App\Http\Resources\Blog\BlogResource::class,
            \App\Contract\User\Resource\BlogCollection::class => \App\Http\Resources\Blog\BlogCollection::class,
        ];

        $bindings = array_merge($bindingResponses, $bindingRequests, $bindingResources);
        foreach ($bindings as $abstract => $concrete) {
            $this->app->bind($abstract, $concrete);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        View::composer('*', function ($view) {
            $view->with('locale', App::getLocale());
            $view->with('languages', ['en' => 'gb', 'ar' => 'sa']);
        });

        Authenticate::redirectUsing(function ($request) {
            $guards = $request->route()->middleware() ?? [];
            if (array_search('auth:admin', $guards) !== false) {
                return route('admin.login');
            }
            return route(config('fortify.home'));
        });

        RedirectIfAuthenticated::redirectUsing(function ($request) {
            if (Auth::guard('admin')->check()) {
                return route('admin.dashboard');
            }
            return route(config('fortify.home'));
        });
    }
}
