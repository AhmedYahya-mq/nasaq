<?php

use App\Http\Controllers\MembershipApplictionController;
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

    // Membership Application Routes
    Route::get('membershipApplications', [MembershipApplictionController::class, 'index'])->name('membershipApplications');
    // Route::put('membershipApplications/{id}/approve', [MembershipController::class, 'approve'])->name('membershipApplications.approve');
    // Route::put('membershipApplications/{id}/reject', [MembershipController::class, 'reject'])->name('membershipApplications.reject');


    // blog Routes
    Route::get('blogs',[BlogController::class,'index'])->name('blogs');
    Route::post('blogs', [BlogController::class, 'store'])->name('blogs.store');
    Route::put('blogs/{id}', [BlogController::class, 'update'])->name('blogs.update');
    Route::put('blogs/{id}/translation', [BlogController::class, 'updateTranslation'])->name('blogs.update.translation');
    Route::delete('blogs/{id}', [BlogController::class, 'destroy'])->name('blogs.destroy');
});

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
