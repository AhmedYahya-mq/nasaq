<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        \App\Events\PaymentStatusChanged::class => [
            \App\Listeners\CreateMembershipDraft::class,
        ],
        \App\Events\FileDeletedEvent::class => [
            \App\Listeners\DeleteFileFromDisk::class,
        ],
    ];

    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
