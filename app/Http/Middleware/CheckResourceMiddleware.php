<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CheckResourceMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $res = $request->route('res'); // Route Model Binding
        $user = $request->user();

        // 1️⃣ تحقق من وجود الحدث
        throw_if(!$res, NotFoundHttpException::class, __('library.messages.not_found'));

        // 3️⃣ تحقق من تسجيل المستخدم
        if (!$user) {
            return redirect()->route('login')->with('error', __('library.messages.login_required'));
        }

        // 4️⃣ تحقق أن المستخدم لم يسجل مسبقًا
        if ($res->isUserRegistered($user->id)) {
            return redirect()->route('client.profile', ['tab' => 'library'])->with('info', __('library.messages.already_registered'));
        }

        // 5️⃣ تحقق من الدفع إذا لم يكن الحدث مجاني
        if (!$res->isFree()) {
            return $this->redirectToPayment($res);
        }
        return $next($request);
    }

    /**
     * @param mixed $event
     * @param string|null $message
     * @return Response
     * @throws BindingResolutionException
     * @throws RouteNotFoundException
     * @throws InvalidArgumentException
     */
    protected function redirectToPayment($resource,  $message = null): Response
    {
        return redirect()
            ->route('client.pay.index', [
                'type' => 'library',
                'id' => $resource->id,
            ])
            ->with('error', $message ?? __('library.messages.requires_payment'));
    }
}
