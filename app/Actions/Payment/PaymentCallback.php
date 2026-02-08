<?php

namespace App\Actions\Payment;

use App\Contract\User\Request\PaymentCallbackRequest;
use App\Models\Payment;
use App\Enums\PaymentStatus;
use App\DTOs\Payment\PaymentResponseDTO;
use App\Exceptions\Payment\PaymentCallbackException;
use App\Models\EventRegistration;
use App\Services\PaymentGateway;
use Illuminate\Support\Arr;

class PaymentCallback implements \App\Contract\Actions\PaymentCallback
{
    public Payment $payment;
    public bool $isSubscription = false;
    public bool $isRenew = false;

    public function handle(PaymentCallbackRequest $request)
    {
        $this->resolvePayment($request->query('id'));

        // Callback is user-agent driven; never trust query parameters for final status.
        // Verify using Moyasar API server-side.
        $this->assertOwnership($request);

        $verifiedStatus = $this->verifyWithGatewayOrFail();

        $wasInitiated = $this->payment->status->isInitiated();

        // Allow only safe state transitions.
        if ($wasInitiated) {
            $this->payment->update([
                'status' => $verifiedStatus->value,
            ]);
        }

        // If still not paid, stop here.
        if ($verifiedStatus->isFailed() || $verifiedStatus->isCancelled()) {
            throw new PaymentCallbackException($request->query('message') ?? 'Payment failed.', 400);
        }

        if ($verifiedStatus->isInitiated()) {
            throw new PaymentCallbackException('Payment is still pending.', 400);
        }

        if ($this->payment->payable instanceof \App\Models\Membership) {
            $user = $request->user();
            if ($user->membership_id === $this->payment->payable_id) {
                $this->isRenew = true;
            } else {
                $this->isSubscription = true;
            }
        }

        // Side effects must be executed only once on a legitimate initiated→paid transition.
        if (!$wasInitiated) {
            return;
        }

        if ($this->payment->payable instanceof \App\Models\Membership) {
            $user = $request->user();
            if ($this->isRenew) {
                $user->renewMembership();
            }
        }

        if ($this->payment->payable instanceof \App\Models\Event) {
            $this->registerUserToEvent();
        }

        if ($this->payment->payable instanceof \App\Models\Library) {
            $this->savedUserToLibrary();
        }
    }

    protected function registerUserToEvent(): void
    {
        $event = $this->payment->payable;
        $user = $this->payment->user;
        if (!$event || !$user) {
            throw new PaymentCallbackException('Event or User not found for registration', 404);
        }
        EventRegistration::registerUserToEvent($event->id, $user->id, $this->payment->id);
    }

    protected function savedUserToLibrary(): bool
    {
        $res = $this->payment->payable;
        $user = $this->payment->user;
        $is_saved = $res->savedUser($user->id, $this->payment->id);
        return $is_saved;
    }

    protected function resolvePayment(?string $moyasarId): void
    {
        $this->payment = Payment::where('moyasar_id', $moyasarId)->first();

        if (!$this->payment) {
            throw new PaymentCallbackException('Payment not found', 404);
        }
    }

    protected function resolvePaymentStatus(?string $status): PaymentStatus
    {
        $paymentStatus = PaymentStatus::tryFrom($status);
        if (!$paymentStatus) {
            throw new PaymentCallbackException('Payment not successful or invalid status', 400);
        }

        return $paymentStatus;
    }

    protected function assertInitialized(): void
    {
        if (!$this->payment->status->isInitiated()) {
            throw new PaymentCallbackException('Payment not initialized', 400);
        }
    }

    protected function assertOwnership(PaymentCallbackRequest $request): void
    {
        $userId = $request->user()?->id;
        if (!$userId || (int) $this->payment->user_id !== (int) $userId) {
            throw new PaymentCallbackException('Unauthorized payment callback', 403);
        }
    }

    protected function verifyWithGatewayOrFail(): PaymentStatus
    {
        $gateway = PaymentGateway::find($this->payment->moyasar_id);
        if (!$gateway->success) {
            throw new PaymentCallbackException($gateway->error ?? 'Unable to verify payment with gateway', 502);
        }

        $dto = PaymentResponseDTO::fromGatewayResponse($gateway);
        if (!$dto->id || $dto->id !== $this->payment->moyasar_id) {
            throw new PaymentCallbackException('Gateway payment mismatch', 400);
        }

        $currency = Arr::get($dto->raw, 'data.currency') ?? Arr::get($dto->raw, 'currency');
        if ($currency && strtoupper((string) $currency) !== strtoupper((string) $this->payment->currency)) {
            throw new PaymentCallbackException('Currency mismatch', 400);
        }

        $gatewayAmount = Arr::get($dto->raw, 'data.amount') ?? Arr::get($dto->raw, 'amount');
        $expectedAmount = (int) round(((float) $this->payment->amount) * 100);
        if (is_numeric($gatewayAmount) && (int) $gatewayAmount !== $expectedAmount) {
            throw new PaymentCallbackException('Amount mismatch', 400);
        }

        return $dto->status;
    }
}
