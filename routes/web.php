<?php

use Illuminate\Routing\RouteGroup;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\RoutePath;

Route::group(['middleware' => ['web'], 'as' => 'client.'], function () {
    Route::group(['prefix' => '{locale?}', 'where' => ['locale' => 'en|ar'], "as" => "locale."], function () {
        require __DIR__ . '/user.php';
    });
    require __DIR__ . '/user.php';
});



Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    require __DIR__ . '/admin.php';
});


