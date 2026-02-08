<?php

use App\Http\Controllers\FilePondController;
use Illuminate\Support\Facades\Route;

// Moyasar server-to-server webhook (payment confirmation)
Route::post('/payment/webhook/moyasar', \App\Http\Controllers\MoyasarWebhookController::class)
    ->name('payment.webhook.moyasar')
    ->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class])
    ->middleware('throttle:60,1');


Route::group(['middleware' => ['web', 'blocked'], 'as' => 'client.'], function () {
    Route::group(['prefix' => '{locale?}', 'where' => ['locale' => 'en|ar'], "as" => "locale."], function () {
        require __DIR__ . '/user.php';
    });
    require __DIR__ . '/user.php';
    Route::post('/filepond/process', [FilePondController::class, 'process'])->middleware('auth')->name('filepond.process');
    Route::delete('/filepond/revert', [FilePondController::class, 'revert'])->middleware('auth')->name('filepond.revert');
    Route::get('/filepond/restore/{id}', [FilePondController::class, 'restore'])->middleware('auth')->name('filepond.restore')->where('id', '.*');
    Route::post('/filepond/remove', [FilePondController::class, 'remove'])->middleware('auth')->name('filepond.remove');
    Route::post('/contact', [\App\Http\Controllers\ContactController::class, '__invoke'])->defaults('not-site-map', true)->name('contact.sendMail');
});

$adminPrefix = config('app.admin_prefix', 'admin');
Route::group([
    'prefix' => $adminPrefix,
    'as' => 'admin.',
    'middleware' => ['prevent.indexing']
], function () {
    require __DIR__ . '/admin.php';
});

Route::get('members/{user}', function ($user) {
    if (!auth('admin')->check()) {
        abort(403, 'هذه صفحة مخصصة للمسؤلين ولايمكنك الوصل لها');
    }
    return  redirect()->route('admin.members.show', ['user' => $user]);
})->middleware('prevent.indexing')->name('members.show');
