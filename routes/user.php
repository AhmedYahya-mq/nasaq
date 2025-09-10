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
Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/events', function () {
    return view('events');
})->name('events');

Route::get('/library', function () {
    return view('library');
})->name('library');

Route::get('/archives', function () {
    return view('archives');
})->name('archives');

Route::get('/archive', function(){
    return view('details-archive');
})->name('archive');
