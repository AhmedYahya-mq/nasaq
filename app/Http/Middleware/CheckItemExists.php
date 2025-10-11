<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckItemExists
{
    protected $class = '\\App\\Models\\';
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
        // تحقق اذا العنصر قابل لشراء يكون اسعر اكبر من صفر
        if (method_exists($modelClass, 'isPurchasable') && !$modelClass::isPurchasable($id)) {
            return redirect($modelClass::redirectRoute($id));
        }
        // تحقق اذا المستخدم قد اشترا العنصر من قبل
        $user = $request->user();
        if ($user && $user->isPurchasedByUser($id)) {
            $user = $request->user();

            if ($user && $user->isPurchasedByUser($id)) {
                $previous = url()->previous() && url()->previous() !== url()->current() ? url()->previous() : route('client.home');
                return redirect($previous)
                    ->with('info', __('payments.You_have_already_purchased_this_item', ['item' => __('payments.' . strtolower(class_basename($modelClass)))]));
            }
        }
        // العنصر موجود، تابع الطلب
        session(['payable_type' => $modelClass, 'payable_id' => $id]);
        return $next($request);
    }
}
