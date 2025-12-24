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
            \Laravel\Fortify\Contracts\RegisterViewResponse::class => \App\Http\Responses\AuthClient\RegisterViewResponse::class,

            // profile client
            \App\Contract\User\Profile\PhotoResponse::class => \App\Http\Responses\User\Profile\PhotoResponse::class,

            // Response Admin
            \App\Contract\User\Response\MembershipResponse::class => \App\Http\Responses\User\MembershipResponse::class,
            \App\Contract\User\Response\BlogResponse::class => \App\Http\Responses\User\BlogResponse::class,
            \App\Contract\User\Response\MembershipApplicationResponse::class => \App\Http\Responses\User\MembershipApplicationResponse::class,
            \App\Contract\User\Response\UserResponse::class => \App\Http\Responses\User\UserResponse::class,

            // Response Payment
            \App\Contract\User\Response\PaymentResponse::class => \App\Http\Responses\User\PaymentResponse::class,

            // Event
            \App\Contract\User\Response\EventResponse::class => \App\Http\Responses\User\EventResponse::class,
            \App\Contract\User\Response\EventRegistrationResponse::class => \App\Http\Responses\User\EventRegistrationResponse::class,

            // Library
            \App\Contract\User\Response\LibraryResponse::class => \App\Http\Responses\User\LibraryResponse::class,

        ];
        $bindingRequests = [
            // user profile
            \App\Contract\User\Profile\PhotoRequest::class => \App\Http\Requests\User\Profile\PhotoRequest::class,
            // Membership
            \App\Contract\User\Request\MembershipRequest::class => \App\Http\Requests\User\MembershipRequest::class,
            \App\Contract\User\Request\MembershipApplicationRequest::class => \App\Http\Requests\User\MembershipApplicationRequest::class,
            // blog
            \App\Contract\User\Request\BlogRequest::class => \App\Http\Requests\User\BlogRequest::class,
            // user
            \App\Contract\User\Request\UserRequest::class => \App\Http\Requests\User\UserRequest::class,
            // payment
            \App\Contract\User\Request\PaymentRequest::class => \App\Http\Requests\User\PaymentRequest::class,
            \App\Contract\User\Request\PaymentCallbackRequest::class => \App\Http\Requests\User\PaymentCallbackRequest::class,

            // Membership Application
            \App\Contract\User\Request\MembershipAppRequest::class => \App\Http\Requests\User\MembershipAppRequest::class,

            // Event
            \App\Contract\User\Request\EventRequest::class => \App\Http\Requests\User\EventRequest::class,

            // Library
            \App\Contract\User\Request\LibraryRequest::class => \App\Http\Requests\User\LibraryRequest::class,
        ];
        $bindingResources = [
            // Membership
            \App\Contract\User\Resource\MembershipResource::class => \App\Http\Resources\Membership\MembershipResource::class,
            \App\Contract\User\Resource\MembershipCollection::class => \App\Http\Resources\Membership\MembershipCollection::class,
            \App\Contract\User\Resource\MembershipApplicationResource::class => \App\Http\Resources\MembershipApplication\MembershipApplicationResource::class,
            \App\Contract\User\Resource\MembershipApplicationCollection::class => \App\Http\Resources\MembershipApplication\MembershipApplicationCollection::class,
            // blog
            \App\Contract\User\Resource\BlogResource::class => \App\Http\Resources\Blog\BlogResource::class,
            \App\Contract\User\Resource\BlogCollection::class => \App\Http\Resources\Blog\BlogCollection::class,

            // user
            \App\Contract\User\Resource\UserResource::class => \App\Http\Resources\User\UserResource::class,
            \App\Contract\User\Resource\UserCollection::class => \App\Http\Resources\User\UserCollection::class,

            // payment
            \App\Contract\User\Resource\PaymentResource::class => \App\Http\Resources\Payment\PaymentResource::class,
            \App\Contract\User\Resource\PaymentCollection::class => \App\Http\Resources\Payment\PaymentCollection::class,

            // Event
            \App\Contract\User\Resource\EventResource::class => \App\Http\Resources\Event\EventResource::class,
            \App\Contract\User\Resource\EventCollection::class => \App\Http\Resources\Event\EventCollection::class,
            \App\Contract\User\Resource\EventRegistrationResource::class => \App\Http\Resources\EventRegistration\EventRegistrationResource::class,
            \App\Contract\User\Resource\EventRegistrationCollection::class => \App\Http\Resources\EventRegistration\EventRegistrationCollection::class,

            // Library
            \App\Contract\User\Resource\LibraryResource::class => \App\Http\Resources\Library\LibraryResource::class,
            \App\Contract\User\Resource\LibraryCollection::class => \App\Http\Resources\Library\LibraryCollection::class,
        ];
        $bindingActions = [
            // payment
            \App\Contract\Actions\CreatePaymentIntent::class => \App\Actions\Payment\CreatePaymentIntent::class,
            \App\Contract\Actions\PaymentCallback::class => \App\Actions\Payment\PaymentCallback::class,

            // filepond
            \App\Contract\Actions\FilePondAction::class => \App\Actions\User\FilePondAction::class,

            // Membership Application
            \App\Contract\Actions\MembershipRequestAction::class => \App\Actions\User\MembershipRequestAction::class,

            // Library
            \App\Contract\Actions\FileLibraryHandler::class => \App\Actions\User\FileLibraryHandler::class,
            \App\Contract\Actions\FileLibraryDownload::class => \App\Actions\User\FileLibraryDownload::class,

            // Print Action
            \App\Contract\Actions\PrintAction::class => \App\Actions\User\PrintAction::class,
        ];

        $bindings = array_merge($bindingResponses, $bindingRequests, $bindingResources, $bindingActions);
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
            return route('login');
        });

        RedirectIfAuthenticated::redirectUsing(function ($request) {
            $guards = $request->route()->middleware() ?? [];
            if (array_search('auth:admin', $guards) !== false && Auth::guard('admin')->check()) {
                return route('admin.dashboard');
            }
            return route(config('fortify.home'));
        });
    }
}
