<?php

namespace App\Http\Middleware;

use App\Models\Event;
use Closure;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\Request;
use InvalidArgumentException;
use App\Support\PaymentIntentFactory;
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

        // 2️⃣ تحقق من تسجيل المستخدم
        if (!$user) {
            return redirect()->route('login')->with('error', __('events.messages.login_required'));
        }

        // 3️⃣ تحقق من أهلية المستخدم للحدث (العضوية المطلوبة)
        if (!$event->canUserRegister($user)) {
            return redirect()->route('client.profile', ['tab' => 'events'])
                ->with('error', __('events.messages.membership_required'));
        }

        // 4️⃣ تحقق أن التسجيل مفتوح وأن الحدث قابل للشراء/التسجيل
        if (!$event->isRegistrationOpen()) {
            return redirect()->route('client.profile', ['tab' => 'events'])
                ->with('error', __('events.messages.registration_closed'));
        }

        // 5️⃣ تحقق أن المستخدم لم يسجل مسبقًا
        if ($event->isUserRegistered($user->id)) {
            return redirect()->route('client.profile', ['tab' => 'events'])->with('info', __('events.messages.already_registered'));
        }

        // 6️⃣ تحقق من الدفع إذا لم يكن الحدث مجاني
        $requiresPayment = !$event->isFreeForUser($user);
        $alreadyPurchased = $user && $user->isPurchasedByUser($event->id, Event::payableType());

        if ($requiresPayment && !$alreadyPurchased) {
            return $this->redirectToPayment($user->id, $event);
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
    protected function redirectToPayment(int $userId, $event,  $message = null): Response
    {
        $intent = PaymentIntentFactory::prepare($userId, $event);
        return redirect()
            ->route('client.pay.show', ['token' => $intent->token])
            ->with('error', $message ?? __('events.messages.requires_payment'));
    }
}
