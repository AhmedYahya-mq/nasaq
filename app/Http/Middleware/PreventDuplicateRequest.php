<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PreventDuplicateRequest
{
    public function handle(Request $request, Closure $next): Response
    {
        // إذا ما في _token نكمل عادي
        // if (!$request->has('_token')) {
        //     return $next($request);
        // }

        // $token = $request->input('_token');

        // // نتحقق إذا موجود بالجلسة
        // if (session()->has("request_tokens.$token")) {
        //     return response()->json([
        //         'status'  => 'failed',
        //         'message' => 'Duplicate request detected.',
        //     ], 429);
        // }

        // // نخزن التوكن في السيشن
        // session()->put("request_tokens.$token", now());

        // نكمل الطلب
        return $next($request);
    }
}
