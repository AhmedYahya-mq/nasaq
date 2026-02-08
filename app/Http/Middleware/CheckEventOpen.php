<?php

namespace App\Http\Middleware;

use App\Models\Event;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckEventOpen
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $event = $request->route('event'); // Route Model Binding
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        // 1. تحقق من أن المستخدم مسجل للفعالية
        if (!$event->isUserRegistered($user->id)) {
            return redirect()
                ->route('client.profile', ['tab' => 'events'])
                ->with('info', __('events.messages.not_registered'));
        }

        if (!$event->link) {
            return redirect()
                ->route('client.profile', ['tab' => 'events'])
                ->with('info', __('events.messages.not_link'));
        }

        // 2. تحقق من الدفع إذا الفعالية ليست مجانية
        if (!$event->isFreeForUser($user) && !$user->isPurchasedByUser($event->id, Event::payableType())) {
            $previous = url()->previous() && url()->previous() !== url()->current()
                ? url()->previous()
                : route('client.home');

            return redirect($previous)
                ->with('info', __('payments.payid_event'));
        }

        // 3. تحقق من أن الفعالية مفتوحة / مستمرة
        if (!$event->event_status->isOngoing()) {
            return redirect()
                ->route('client.profile', ['tab' => 'events'])
                ->with('error', __('events.messages.event_not_open'));
        }

        // كل الشروط متوفرة، نسمح بالوصول
        return $next($request);
    }
}
