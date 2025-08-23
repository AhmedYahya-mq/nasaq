<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => '{locale?}', 'where' => ['locale' => 'en|ar']], function () {

    Route::get('/', function () {
        if (app()->environment('testing')) {
            return "Current locale: " . app()->getLocale();
        }
        return view('welcome');
    })->name('home');

    Route::get('/about', function () {
        return view('about');
    })->name('about');
});
