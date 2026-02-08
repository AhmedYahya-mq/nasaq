<?php

use App\Http\Controllers\MembershipApplictionController;
use App\Http\Controllers\User\EventController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\Settings\ProfileController;
use App\Http\Controllers\User\Settings\SecurityController;
use App\Http\Middleware\RequirePassword;
use App\Models\Blog;
use App\Models\Payment;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Route;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\PngEncoder;
use Intervention\Image\Encoders\WebpEncoder;
use Laravel\Fortify\Features;
use Laravel\Fortify\Http\Controllers\ConfirmedTwoFactorAuthenticationController;
use Laravel\Fortify\Http\Controllers\RecoveryCodeController;
use Laravel\Fortify\Http\Controllers\TwoFactorAuthenticationController;
use Laravel\Fortify\Http\Controllers\TwoFactorQrCodeController;
use Laravel\Fortify\Http\Controllers\TwoFactorSecretKeyController;
use Laravel\Fortify\RoutePath;
use Mpdf\Mpdf;

use Intervention\Image\ImageManager;

Route::prefix('/')->middleware('auth')->group(function () {
    Route::get('user/profile', [ProfileController::class, 'edit'])->name('profile');
    Route::get('/user/print-card/{format}', [\App\Http\Controllers\PrintController::class, 'printCard'])->name('print.card')->where('format', 'pdf|image');
    Route::get('/user/print-certificate/{format}', [\App\Http\Controllers\PrintController::class, 'printCertifi'])->name('print.certificate')->where('format', 'pdf');

    Route::post(RoutePath::for('user.photoProfile', 'user/profile-photo'), [ProfileController::class, 'photoUpdate'])->name('profile.photo.update');

    if (Features::enabled(Features::twoFactorAuthentication())) {
        $twoFactorMiddleware = Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword')
            ? [RequirePassword::using()]
            : [];
        Route::post(RoutePath::for('two-factor.enable', '/user/two-factor-authentication'), [TwoFactorAuthenticationController::class, 'store'])
            ->middleware($twoFactorMiddleware)
            ->name('two-factor.enable');
        Route::post(RoutePath::for('two-factor.confirm', '/user/confirmed-two-factor-authentication'), [ConfirmedTwoFactorAuthenticationController::class, 'store'])
            ->middleware($twoFactorMiddleware)
            ->name('two-factor.confirm');
        Route::delete(RoutePath::for('two-factor.disable', '/user/two-factor-authentication'), [TwoFactorAuthenticationController::class, 'destroy'])
            ->middleware("auth")
            ->name('two-factor.disable');
        Route::get(RoutePath::for('two-factor.qr-code', '/user/two-factor-qr-code'), [TwoFactorQrCodeController::class, 'show'])
            ->middleware($twoFactorMiddleware)
            ->name('two-factor.qr-code');
        Route::get(RoutePath::for('two-factor.secret-key', '/user/two-factor-secret-key'), [TwoFactorSecretKeyController::class, 'show'])
            ->middleware($twoFactorMiddleware)
            ->name('two-factor.secret-key');
        Route::get(RoutePath::for('two-factor.recovery-codes', '/user/two-factor-recovery-codes'), [RecoveryCodeController::class, 'index'])
            ->name('two-factor.recovery-codes');
        Route::post(RoutePath::for('two-factor.recovery-codes', '/user/two-factor-recovery-codes'), [SecurityController::class, 'store'])
            ->middleware($twoFactorMiddleware)
            ->name('two-factor.regenerate-recovery-codes');
    }

    Route::delete(RoutePath::for("sessions.destroy", "settings/sessions"), [\App\Http\Controllers\User\Settings\OtherBrowserSessionsController::class, 'destroy'])
        ->middleware(RequirePassword::using())
        ->name('sessions.destroy');

    Route::group(['prefix' => 'payment', 'as' => 'pay.'], function () {
        Route::get('{token}', [\App\Http\Controllers\PayController::class, 'show'])->name('show')
            ->where('token', '[A-Za-z0-9]{64}');
        Route::post('prepare', [\App\Http\Controllers\PayController::class, 'prepare'])
            ->name('prepare')
            ->middleware(['throttle:payment', 'prevent.duplicate']);
        Route::post('create/', [\App\Http\Controllers\PayController::class, 'createPayment'])
            ->name('create')
            ->middleware(['throttle:payment', 'prevent.duplicate']);
        Route::get('callback', [\App\Http\Controllers\PayController::class, 'handleCallback'])->name('callback');
        Route::get('success', [\App\Http\Controllers\PayController::class, 'success'])->name('success');
        Route::get('failure', [\App\Http\Controllers\PayController::class, 'failure'])->name('failure');
        Route::post('refund', [\App\Http\Controllers\PayController::class, 'refund'])->name('refund');
        Route::get('status/{paymentId}', [\App\Http\Controllers\PayController::class, 'paymentStatus'])->name('status');
    });

    Route::get('membership/{application}/request', [MembershipApplictionController::class, 'create'])->name('membership.request')->middleware('payment.check');
    Route::post('membership/{application}/request', [MembershipApplictionController::class, 'store'])->name('membership.request.store')->middleware('payment.check');
    Route::get('membership/{application}/resubmit', [MembershipApplictionController::class, 'resubmit'])->name('membership.resubmit');
    Route::get('registration/{event}/request', [EventController::class, 'register'])->name('event.register')->middleware('event.register');

    // حفظ المصدر الكتاب او اي شي في المكتبة حفظه في المفضلة
    Route::get('library/{res}/saved', [\App\Http\Controllers\User\LibraryController::class, 'saved'])->name('library.saved')->middleware('library.saved');
    // download resource
    Route::get('library/{res}/download', [\App\Http\Controllers\User\LibraryController::class, 'download'])->name('library.download')->middleware('library.download');
    Route::get('event/{event}/open', [EventController::class, 'redirctToEvent'])->name('event.open')->middleware('event.open');

    Route::get('/invoice/{uuid}/', function ($uuid) {
        $payment = Payment::where('moyasar_id', $uuid)->with(['user', 'payable' => function ($q) {
            if (method_exists($q->getModel(), 'scopeWithTranslations')) {
                $q->withTranslations();
            }
        }])->firstOrFail();
        // تحثقق من ان المستخدم هو صاحب الفاتورة
        if ($payment->user_id !== auth()->id()) {
            abort(403);
        }
        return view('invoice', compact('payment'));
    })->name('invoice.print');
});

Route::get('/', HomeController::class)->name('home');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/events', EventController::class)->name('events');
Route::get('/event/calendar', [EventController::class, 'calender'])->defaults('not-site-map', true)->name('events.calender');

Route::get('/library', function () {
    return view('library');
})->name('library');

// Route::get('/archives', function () {
//     return view('archives');
// })->name('archives');

// Route::get('/archive', function () {
//     return view('details-archive');
// })->name('archive');

Route::get('/blogs', function () {
    return view('blogs');
})->name('blogs');

Route::get('/blog/{blog}', function ($blog) {
    $blog = Blog::withTranslations([], app()->getLocale())->where('slug', $blog)->firstOrFail();
    return view('blog-details', ['blog' => $blog]);
})->name('blog.details');

Route::get('/memberships', function () {
    return view('memberships');
})->name('memberships');
