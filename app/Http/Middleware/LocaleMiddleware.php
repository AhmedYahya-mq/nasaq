<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

class LocaleMiddleware
{
    protected array $languages = ['en', 'ar'];

    public function handle($request, Closure $next)
    {
        $locale = $request->route('locale');

        // تحديد اللغة المستخدمة
        if ($locale && in_array($locale, $this->languages)) {
            App::setLocale($locale);
            Session::put('locale', $locale);
        } elseif (Session::has('locale')) {
            $locale = Session::get('locale');
            App::setLocale($locale);
        } else {
            $locale = Config::get('app.locale', 'ar');
            App::setLocale($locale);
            Session::put('locale', $locale);
        }

        // الحصول على اسم الراوت الحالي
        $currentRoute = Route::currentRouteName();
        // إذا الراوت يبدأ بـ client.locale. → نوجهه إلى الراوت بدون locale.
        if (str_starts_with($currentRoute, 'client.locale.') && 'client.locale.home' !== $currentRoute) {
            $newRoute = str_replace('client.locale.', 'client.', $currentRoute);

            // إعادة التوجيه إلى الراوت الجديد مع نفس الباراميترات
            return redirect()->route($newRoute, $request->route()->parameters());
        }

        return $next($request);
    }
}
