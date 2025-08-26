<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => '{locale?}', 'where' => ['locale' => 'en|ar'], "as" => "locale."], function () {
    require __DIR__ . '/user.php';
});
require __DIR__ . '/user.php';



Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
  require __DIR__ . '/admin.php';
});
