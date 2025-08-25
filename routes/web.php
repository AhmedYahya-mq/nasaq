<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => '{locale?}', 'where' => ['locale' => 'en|ar']], function () {
    require __DIR__ . '/user.php';
});
require __DIR__ . '/user.php';
