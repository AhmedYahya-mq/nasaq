<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class PreventDuplicateRequest
{
    public function handle(Request $request, Closure $next): Response
    {
        // Prevent rapid replays (double-click / DevTools replay).
        // This is NOT a full payment idempotency mechanism; it's a short-lived lock.
        $userId = $request->user()?->id ?? 0;
        $fingerprint = hash('sha256', $request->method() . '|' . $request->path() . '|' . json_encode($request->all()));
        $key = "dup:req:{$userId}:{$fingerprint}";

        if (!Cache::add($key, true, now()->addSeconds(8))) {
            return response()->json([
                'success' => false,
                'message' => 'Duplicate request detected.',
            ], 429);
        }

        return $next($request);
    }
}
