<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware(['auth:admin', 'verified:admin.verification.notice'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
    Route::get('membership', function () {
        return Inertia::render('membership');
    })->name('membership');
    Route::get('membershipApplications', function () {
        return Inertia::render('membershipApplication');
    })->name('membershipApplications');
});

require __DIR__ . '/settings.php';
require __DIR__ . '/auth2.php';
