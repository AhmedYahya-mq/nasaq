<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PreventIndexing
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // إضافة Header لمنع robots
        $response->headers->set('X-Robots-Tag', 'noindex, nofollow');

        return $response;
    }
}
