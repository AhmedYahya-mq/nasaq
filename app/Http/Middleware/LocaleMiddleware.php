<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

class LocaleMiddleware
{
    protected $languages = ['en', 'ar'];

    public function handle($request, Closure $next)
    {
        $segments = $request->segments();
        $locale = $segments[0] ?? null;
        if ($locale && in_array($locale, $this->languages)) {
            App::setLocale($locale);
            Session::put('locale', $locale);
        } elseif (Session::has('locale')) {
            $locale = Session::get('locale');
            App::setLocale($locale);
        } else {
            $locale = Config::get('app.locale');
            App::setLocale($locale);
        }

        return $next($request);
    }
}
