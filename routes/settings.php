<?php

use App\Actions\Fortify\TwoFactorAuthenticatedSessionController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Settings\PasswordController;
use App\Http\Controllers\Settings\ProfileController;
use App\Http\Controllers\Settings\SecurityController;
use App\Http\Middleware\RequirePassword;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;
use Laravel\Fortify\Http\Controllers\ConfirmedTwoFactorAuthenticationController;
use Laravel\Fortify\Http\Controllers\ProfileInformationController;
use Laravel\Fortify\Http\Controllers\RecoveryCodeController;
use Laravel\Fortify\Http\Controllers\TwoFactorAuthenticationController;
use Laravel\Fortify\Http\Controllers\TwoFactorQrCodeController;
use Laravel\Fortify\Http\Controllers\TwoFactorSecretKeyController;
use Laravel\Fortify\RoutePath;

Route::middleware(['web', 'auth:admin'])->group(function () {
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


    // Two Factor Authentication...
    if (Features::enabled(Features::twoFactorAuthentication())) {
        Route::get('settings/security', [SecurityController::class, "index"])->name('security');
        $twoFactorMiddleware = Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword')
            ? [RequirePassword::using("admin")]
            : [];

        Route::post(RoutePath::for('two-factor.enable', '/user/two-factor-authentication'), [TwoFactorAuthenticationController::class, 'store'])
            ->middleware($twoFactorMiddleware)
            ->name('two-factor.enable');

        Route::post(RoutePath::for('two-factor.confirm', '/user/confirmed-two-factor-authentication'), [ConfirmedTwoFactorAuthenticationController::class, 'store'])
            ->middleware($twoFactorMiddleware)
            ->name('two-factor.confirm');

        Route::delete(RoutePath::for('two-factor.disable', '/user/two-factor-authentication'), [TwoFactorAuthenticationController::class, 'destroy'])
            ->middleware("auth:admin")
            ->name('two-factor.disable');

        Route::get(RoutePath::for('two-factor.qr-code', '/user/two-factor-qr-code'), [TwoFactorQrCodeController::class, 'show'])
            ->middleware($twoFactorMiddleware)
            ->name('two-factor.qr-code');

        Route::get(RoutePath::for('two-factor.secret-key', '/user/two-factor-secret-key'), [TwoFactorSecretKeyController::class, 'show'])
            ->middleware($twoFactorMiddleware)
            ->name('two-factor.secret-key');

        Route::get(RoutePath::for('two-factor.recovery-codes', '/user/two-factor-recovery-codes'), [RecoveryCodeController::class, 'index'])
            ->name('two-factor.recovery-codes');

        Route::post(RoutePath::for('two-factor.recovery-codes', '/user/two-factor-recovery-codes'), [SecurityController::class, 'store'])
            ->name('two-factor.regenerate-recovery-codes');
    }

    // Browser Sessions...
    Route::delete(RoutePath::for("sessions.destroy", "'settings/sessions"), [\App\Http\Controllers\Settings\OtherBrowserSessionsController::class, 'destroy'])
        ->middleware(RequirePassword::using("admin"))
        ->name('sessions.destroy');
    Route::delete(RoutePath::for('sessions.destroyOne', 'settings/sessions/{sessionId}'), [\App\Http\Controllers\Settings\OtherBrowserSessionsController::class, 'destroyOne'])
        ->middleware(RequirePassword::using("admin"))
        ->name('sessions.destroyOne');
});
