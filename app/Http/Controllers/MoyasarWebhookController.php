<?php

namespace App\Http\Controllers;

use App\DTOs\Payment\PaymentResponseDTO;
use App\Enums\PaymentStatus;
use App\Models\EventRegistration;
use App\Models\Payment;
use App\Services\PaymentGateway;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class MoyasarWebhookController extends Controller
{
    public function __invoke(Request $request)
    {
        $configuredToken = (string) config('moyasar.webhook_token', '');
        // Safe default: if no webhook token is configured, webhook endpoint is disabled.
        // This prevents an unauthenticated public endpoint from triggering gateway lookups.
        if ($configuredToken === '') {
            abort(404);
        }

        $provided = (string) $request->header('X-Moyasar-Webhook-Token', '');
        if (!hash_equals($configuredToken, $provided)) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        $moyasarId = (string) ($request->input('id')
            ?? $request->input('data.id')
            ?? $request->input('payment.id')
            ?? '');

        if ($moyasarId === '') {
            return response()->json(['success' => false, 'message' => 'Missing payment id'], 400);
        }

        $payment = Payment::where('moyasar_id', $moyasarId)->first();
        if (!$payment) {
            return response()->json(['success' => false, 'message' => 'Payment not found'], 404);
        }

        // Always verify with gateway API (do not trust webhook payload).
        $gateway = PaymentGateway::find($payment->moyasar_id);
        if (!$gateway->success) {
            return response()->json(['success' => false, 'message' => $gateway->error ?? 'Gateway verify failed'], 502);
        }

        $dto = PaymentResponseDTO::fromGatewayResponse($gateway);

        $currency = Arr::get($dto->raw, 'data.currency') ?? Arr::get($dto->raw, 'currency');
        if ($currency && strtoupper((string) $currency) !== strtoupper((string) $payment->currency)) {
            return response()->json(['success' => false, 'message' => 'Currency mismatch'], 400);
        }

        $gatewayAmount = Arr::get($dto->raw, 'data.amount') ?? Arr::get($dto->raw, 'amount');
        $expectedAmount = (int) round(((float) $payment->amount) * 100);
        if (is_numeric($gatewayAmount) && (int) $gatewayAmount !== $expectedAmount) {
            return response()->json(['success' => false, 'message' => 'Amount mismatch'], 400);
        }

        $newStatus = $dto->status;

        // Idempotent updates + one-time side effects.
        $wasInitiated = $payment->status->isInitiated();
        if ($wasInitiated) {
            $payment->update(['status' => $newStatus->value]);
        }

        if (!$wasInitiated || !$newStatus->isPaid()) {
            return response()->json(['success' => true], 200);
        }

        // One-time paid side effects.
        if ($payment->payable instanceof \App\Models\Membership) {
            $user = $payment->user;
            if ($user && $user->membership_id === $payment->payable_id) {
                $user->renewMembership();
            }
        }

        if ($payment->payable instanceof \App\Models\Event) {
            $event = $payment->payable;
            $user = $payment->user;
            if ($event && $user) {
                EventRegistration::registerUserToEvent($event->id, $user->id, $payment->id);
            }
        }

        if ($payment->payable instanceof \App\Models\Library) {
            $res = $payment->payable;
            $user = $payment->user;
            if ($res && $user) {
                $res->savedUser($user->id, $payment->id);
            }
        }

        return response()->json(['success' => true], 200);
    }
}
