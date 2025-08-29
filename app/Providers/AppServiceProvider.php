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
            // Auth
            \App\Contract\Auth\PasswordResetResponse::class => \App\Http\Responses\Auth\PasswordResetResponse::class,
            \App\Contract\Auth\FailedPasswordResetResponse::class => \App\Http\Responses\Auth\FailedPasswordResetResponse::class,
            \App\Contract\Auth\SuccessfulPasswordResetLinkRequestResponse::class => \App\Http\Responses\Auth\SuccessfulPasswordResetLinkRequestResponse::class,
            \App\Contract\Auth\FailedPasswordResetLinkRequestResponse::class => \App\Http\Responses\Auth\FailedPasswordResetLinkRequestResponse::class,
        ];
        $bindingRequests = [];
        $bindingResources = [];

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
