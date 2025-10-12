<?php

use App\Http\Controllers\User\EventController;
use App\Http\Controllers\MembershipApplictionController;
use App\Http\Controllers\User\BlogController;
use App\Http\Controllers\User\LibraryController;
use App\Http\Controllers\User\MembershipController;
use App\Http\Controllers\UserController;
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
    Route::get('memberships', [MembershipController::class, '__invoke'])->name('memberships');

    // Membership Application Routes
    Route::get('membershipApplications', [MembershipApplictionController::class, 'index'])->name('membershipApplications');
    Route::put('membershipApplications/{application}/approve', [MembershipApplictionController::class, 'approve'])->name('membershipApplications.approve');
    Route::put('membershipApplications/{application}/reject', [MembershipApplictionController::class, 'reject'])->name('membershipApplications.reject');

    // Members Routes
    Route::get('members', [UserController::class, 'index'])->name('members');
    Route::put('members/{user}/block', [UserController::class, 'toogleBlock'])->name('members.block');
    Route::get('members/{user}', [UserController::class, 'show'])->name('members.show');
    Route::post('members', [UserController::class, 'store'])->name('members.store');
    Route::put('members/{user}', [UserController::class, 'update'])->name('members.update');
    Route::delete('members/{user}', [UserController::class, 'destroy'])->name('members.destroy');
    Route::post('members/{user}/upgrade-membership', [UserController::class, 'upgradeMembership'])->name('members.upgradeMembership');
    Route::post('members/{user}/subscribe-membership', [UserController::class, 'subscribeMembership'])->name('members.subscribeMembership');
    Route::post('members/{user}/renew-membership', [UserController::class, 'renewMembership'])->name('members.renewMembership');


    // blog Routes
    Route::get('blogs', [BlogController::class, 'index'])->name('blogs');
    Route::post('blogs', [BlogController::class, 'store'])->name('blogs.store');
    Route::put('blogs/{id}', [BlogController::class, 'update'])->name('blogs.update');
    Route::put('blogs/{id}/translation', [BlogController::class, 'updateTranslation'])->name('blogs.update.translation');
    Route::delete('blogs/{id}', [BlogController::class, 'destroy'])->name('blogs.destroy');

    // Event Routes
    Route::get('events', [EventController::class, 'index'])->name('events');
    Route::post('events', [EventController::class, 'store'])->name('events.store');
    Route::put('events/{event}', [EventController::class, 'update'])->name('events.update');
    Route::put('events/{event}/translation', [EventController::class, 'updateTranslation'])->name('events.update.translation');
    Route::delete('events/{event}', [EventController::class, 'destroy'])->name('events.destroy');
    Route::get('events/{event}', [EventController::class, 'show'])->name('events.show');
    Route::put('events/{event}/toggle-featured', [EventController::class, 'toogleFutured'])->name('events.toggleFeatured');

    // library Routes
    Route::get('library', [LibraryController::class, 'index'])->name('library');
});

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
