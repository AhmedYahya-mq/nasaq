<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\Request;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

class CheckEventRegister
{
    public function handle(Request $request, Closure $next): Response
    {
        $event = $request->route('event'); // Route Model Binding
        $user = $request->user();

        // 1️⃣ تحقق من وجود الحدث
        throw_if(!$event, NotFoundHttpException::class, __('events.messages.not_found'));

        // 2️⃣ تحقق أن التسجيل مفتوح
        throw_unless($event->isRegistrationOpen(), HttpException::class, 403, __('events.messages.registration_closed'));

        // 3️⃣ تحقق من تسجيل المستخدم
        if (!$user) {
            return redirect()->route('login')->with('error', __('events.messages.login_required'));
        }

        // 4️⃣ تحقق أن المستخدم لم يسجل مسبقًا
        if ($event->isUserRegistered($user->id)) {
            return redirect()->route('client.profile')->with('info', __('events.messages.already_registered'));
        }
        // 5️⃣ تحقق من الدفع إذا لم يكن الحدث مجاني
        if (!$event->isFree()) {
            return $this->redirectToPayment($event);
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
    protected function redirectToPayment($event,  $message = null): Response
    {
        return redirect()
            ->route('pay.index', [
                'type' => 'event',
                'id' => $event->id,
            ])
            ->with('error', $message ?? __('events.messages.requires_payment'));
    }
}
