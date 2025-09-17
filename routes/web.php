<?php
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['web'], 'as' => 'client.'], function () {
    Route::group(['prefix' => '{locale?}', 'where' => ['locale' => 'en|ar'], "as" => "locale."], function () {
        require __DIR__ . '/user.php';
    });
    require __DIR__ . '/user.php';
});


Route::get('upload',fn()=>"upload")->name('upload');
Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    require __DIR__ . '/admin.php';
});


