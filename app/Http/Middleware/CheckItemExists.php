<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckItemExists
{
    /**
     * Explicit allowlist for payable types to prevent abusing arbitrary App\\Models\ classes.
     * Key is the route {type} segment.
     */
    protected array $typeMap = [
        'event' => \App\Models\Event::class,
        'library' => \App\Models\Library::class,
        'membership' => \App\Models\Membership::class,
    ];
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $type = strtolower((string) $request->route('type')); // أو من query string
        $id   = $request->route('id');

        $modelClass = $this->typeMap[$type] ?? null;
        if (!$modelClass) {
            return abort(404, 'Item not found');
        }

        $item = $modelClass::find($id);
        if (!$item) {
            return abort(404, 'Item not found');
        }
        // تحقق اذا العنصر قابل لشراء يكون اسعر اكبر من صفر
        if (method_exists($modelClass, 'isPurchasable') && !$modelClass::isPurchasable($id)) {
            if (method_exists($modelClass, 'redirectRoute')) {
                return redirect($modelClass::redirectRoute($id));
            }
            return abort(403, 'Item not purchasable');
        }
        // تحقق اذا المستخدم قد اشترا العنصر من قبل
        $user = $request->user();
        if ($user && $user->isPurchasedByUser($id, $modelClass::payableType())) {  // هذا يكفي للتحقق
            $previous = url()->previous() && url()->previous() !== url()->current()
                ? url()->previous()
                : route('client.home');
            return redirect($previous)
                ->with('info', __('payments.You_have_already_purchased_this_item', [
                    'item' => __('payments.' . strtolower(class_basename($modelClass)))
                ]));
        }

        // العنصر موجود، تابع الطلب (بدون استخدام session)
        $request->attributes->set('payable_model', $item);
        $request->attributes->set('payable_type', $modelClass);
        $request->attributes->set('payable_id', (int) $id);
        return $next($request);
    }
}
