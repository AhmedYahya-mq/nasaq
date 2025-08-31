<?php

use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Settings\PasswordController;
use App\Http\Controllers\Settings\ProfileController;
use App\Http\Controllers\Settings\SecurityController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;
use Laravel\Fortify\Http\Controllers\ProfileInformationController;
use Laravel\Fortify\RoutePath;

Route::middleware('auth:admin')->group(function () {
    Route::redirect('settings', '/settings/profile');
    // Profile Information...
    if (Features::enabled(Features::updateProfileInformation())) {
        Route::get(RoutePath::for('profile.edit', 'settings/profile'), [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put(RoutePath::for('profile.update', 'settings/profile'), [ProfileInformationController::class, 'update'])
            ->middleware(['auth:admin'])
            ->name('profile.update');
        Route::delete(RoutePath::for('profile.destroy', 'settings/profile'), [ProfileController::class, 'destroy'])->name('profile.destroy');
    }
    // Passwords...
    if (Features::enabled(Features::updatePasswords())) {
        Route::get(RoutePath::for("password.edit", 'settings/password'), [PasswordController::class, 'edit'])->name('password.edit');
        Route::put(RoutePath::for("password.update", 'settings/password'), [PasswordController::class, 'update'])
            ->middleware('throttle:6,1')
            ->name('password.update');
    }


    Route::get('settings/appearance', function () {
        return Inertia::render('settings/appearance');
    })->name('appearance');

    Route::get('settings/security', [SecurityController::class,"index"])->name('security');
    // $twoFactorMiddleware = Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword')
    //     ? ['auth:admin', 'password.confirm']
    //     : ['auth:admin'];
    // Route::post(RoutePath::for('two-factor.enable', '/user/two-factor-authentication'), [TwoFactorAuthenticationController::class, 'store'])
    //     ->middleware($twoFactorMiddleware)
    //     ->name('two-factor.enable');
});
