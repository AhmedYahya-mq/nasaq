<?php

namespace App\Http\Controllers;

use App\Contract\Actions\CreatePaymentIntent;
use App\Contract\Actions\PaymentCallback;
use App\Contract\User\Request\PaymentCallbackRequest;
use App\Contract\User\Request\PaymentRequest;
use App\Contract\User\Response\PaymentResponse;
use App\Models\Event;
use App\Models\Library;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\PaymentIntent;
use App\Models\Membership;
use App\Support\PaymentIntentFactory;

class PayController extends Controller
{
    public function prepare(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            'type' => ['required', 'string', Rule::in(['event', 'library', 'membership'])],
            'id' => ['required', 'integer', 'min:1'],
        ]);

        $type = $data['type'];
        $id = (int) $data['id'];

        $payable = null;

        if ($type === 'event') {
            $event = Event::find($id);
            if (!$event) {
                abort(404);
            }

            if (!$event->isPurchasableFor($user)) {
                return back()->with('error', __('هذا الحدث غير متاح للتسجيل/الدفع حالياً.'));
            }

            $payable = $event;
        } elseif ($type === 'library') {
            $res = Library::find($id);
            if (!$res) {
                abort(404);
            }

            if (!Library::isPurchasable($id)) {
                return back()->with('error', __('هذا المورد غير متاح للشراء حالياً.'));
            }

            $payable = $res;
        } elseif ($type === 'membership') {
            $membership = Membership::find($id);
            if (!$membership) {
                abort(404);
            }

            if (!Membership::isPurchasable((int) $membership->id)) {
                return back()->with('error', __('هذه العضوية غير متاحة للشراء حالياً.'));
            }

            $payable = $membership;
        }

        if (!$payable) {
            return back()->with('error', __('محاولة غير صالحة.'));
        }

        $intent = PaymentIntentFactory::prepare($user->id, $payable);

        return redirect()->route('client.pay.show', ['token' => $intent->token]);
    }

    public function show(string $token, Request $request)
    {
        $user = $request->user();

        $intent = PaymentIntent::query()
            ->where('token', $token)
            ->where('user_id', $user->id)
            ->firstOrFail();

        if ($intent->isExpired()) {
            abort(410, 'Payment intent expired');
        }

        $item = $intent->payable;
        if (!$item) {
            abort(404);
        }

        $isMembership = $item instanceof Membership;

        $membershipAction = null;
        $startAt = null;
        $endsAt = null;

        if ($isMembership) {
            $now = now();
            $change = $user->calculateMembershipChange($item);

            $membershipAction = $change['actionType'] ?? 'new';

            $startAt = match ($membershipAction) {
                'renewal' => $user->membership_started_at?->format('Y-m-d') ?? $now->format('Y-m-d'),
                default => $now->format('Y-m-d'),
            };

            $newExpiresAt = $change['newExpiresAt'] ?? null;
            $endsAt = $newExpiresAt ? $newExpiresAt->format('Y-m-d') : null;
        }

        return view('pay', [
            'item' => $item,
            'intentToken' => $intent->token,
            'isMembership' => $isMembership,
            'membershipAction' => $membershipAction,
            'startAt' => $startAt,
            'endsAt' => $endsAt,
        ]);
    }

    public function createPayment(PaymentRequest $request, CreatePaymentIntent $createPaymentIntent)
    {
        try {
            $payment = $createPaymentIntent->execute($request);
            return app(PaymentResponse::class, ['payment' => $payment]);
        } catch (\Exception $e) {
            return app(PaymentResponse::class)
                ->toErrorResponse($e->getMessage(), 400);
        }
    }


    public function handleCallback(PaymentCallbackRequest $request, PaymentCallback $paymentCallback)
    {
        try {
            $paymentCallback->handle($request);
            return app(PaymentResponse::class, ['payment' => $paymentCallback->payment])
                ->toCallbackResponseWithDetails($paymentCallback->isSubscription);
        } catch (\Exception $e) {
            return app(PaymentResponse::class, ['payment' => $paymentCallback->payment ?? null])
                ->toCallbackErrorResponse($e->getMessage());
        }
    }

    public function success()
    {
        return view('success');
    }

    public function failure(Request $request)
    {
        return view('failure', [
            'message' => $request->query('message'),
        ]);
    }

}
