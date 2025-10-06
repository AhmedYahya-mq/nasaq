<?php

use App\Http\Controllers\FilePondController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['web', 'blocked'], 'as' => 'client.'], function () {
    Route::group(['prefix' => '{locale?}', 'where' => ['locale' => 'en|ar'], "as" => "locale."], function () {
        require __DIR__ . '/user.php';
    });
    require __DIR__ . '/user.php';
    Route::post('/filepond/process', [FilePondController::class, 'process'])->name('filepond.process');
    Route::delete('/filepond/revert', [FilePondController::class, 'revert'])->name('filepond.revert');
    Route::get('/filepond/restore/{id}', [FilePondController::class, 'restore'])->name('filepond.restore')->where('id', '.*');
    Route::post('/filepond/remove', [FilePondController::class, 'remove'])->name('filepond.remove');
});


Route::get('upload', fn() => "upload")->name('upload');
Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    require __DIR__ . '/admin.php';
});
