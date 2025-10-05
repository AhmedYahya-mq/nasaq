<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckItemExists
{
    protected $class='\\App\\Models\\';
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $type = $request->route('type'); // أو من query string
        $id   = $request->route('id');

        $modelClass = $this->class . ucfirst($type);
        if (!class_exists($modelClass) || !$modelClass::find($id)) {
            return abort(404, 'Item not found');
        }
        // العنصر موجود، تابع الطلب
        session(['payable_type' => $modelClass, 'payable_id' => $id]);
        return $next($request);
    }
}
