<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CheckDownloadAccessMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $res = $request->route('res');
        $user = $request->user();
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => __('library.messages.download_not_allowed'),
            ], 401);
        }
        if (!$res->isUserRegistered($user->id)) {
            return response()->json([
                'status' => 'error',
                'message' => __('library.messages.download_not_allowed'),
            ], 403);
        }
        return $next($request);
    }
}
