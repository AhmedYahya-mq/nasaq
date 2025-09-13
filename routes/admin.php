<?php

use App\Http\Controllers\User\BlogController;
use App\Http\Controllers\User\MembershipController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware(['auth:admin', 'verified:admin.verification.notice'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');

    // Membership Routes
    Route::get('membership', [MembershipController::class, 'index'])->name('membership');
    Route::post('membership', [MembershipController::class, 'store'])->name('membership.store');
    Route::put('membership/{membership}', [MembershipController::class, 'update'])->name('membership.update');
    Route::put('membership/{membership}/translation', [MembershipController::class, 'updateTranslation'])->name('membership.update.translation');
    Route::delete('membership/{id}', [MembershipController::class, 'destroy'])->name('membership.destroy');


    // blog Routes
    Route::get('blogs',[BlogController::class,'index'])->name('blogs');
    Route::delete('blogs/{id}', [BlogController::class, 'destroy'])->name('blogs.destroy');

    Route::get('membershipApplications', function () {
        return Inertia::render('membershipApplication');
    })->name('membershipApplications');
});

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
