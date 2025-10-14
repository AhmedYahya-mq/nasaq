<?php

use App\Http\Controllers\FilePondController;
use App\Models\Payment;
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
    Route::get('/invoice/{uuid}/', function ($uuid) {
        $payment = Payment::where('moyasar_id', $uuid)->with(['user', 'payable' => function ($q) {
            if (method_exists($q->getModel(), 'scopeWithTranslations')) {
                $q->withTranslations();
            }
        }])->firstOrFail();
        return view('invoice', compact('payment'));
    })->name('invoice.print')->middleware('auth');
    Route::post('/contact', [\App\Http\Controllers\ContactController::class, '__invoke'])->name('contact.sendMail');
});

Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    require __DIR__ . '/admin.php';
});
Route::middleware(['auth:admin', 'verified:admin.verification.notice'])->group(function () {
    Route::get('members/{user}', function ($user) {
        return  redirect()->route('admin.members.show', ['user' => $user]);
    })->name('members.show');
});
