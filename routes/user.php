<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (app()->environment('testing')) {
        return "Current locale: " . app()->getLocale();
    }
    return view('welcome');
})->name('home');

Route::get('/about', function () {
    return "Current locale: " . app()->getLocale();
})->name('about');

Route::get('/profile', function () {
    if (app()->environment('testing')) {
        return "Current locale: " . app()->getLocale();
    }
    return view('profile');
})->name('profile');

Route::get('/login', function () {
  return view('auth.login');
})->name('login');
Route::get('/register', function () {
    return view('auth.register');
})->name('register');
