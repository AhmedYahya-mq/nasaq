<?php

namespace App\Actions\Payment;

use App\Contract\User\Request\PaymentCallbackRequest;
use App\Models\Payment;
use App\Enums\PaymentStatus;
use App\Exceptions\Payment\PaymentCallbackException;
use App\Models\EventRegistration;

class PaymentCallback implements \App\Contract\Actions\PaymentCallback
{
    public Payment $payment;
    public bool $isSubscription = false;

    public function handle(PaymentCallbackRequest $request)
    {
        $this->resolvePayment($request->query('id'));

        $status = $this->resolvePaymentStatus($request->query('status'));

        $this->assertInitialized();

        $this->payment->update([
            'status' => $status->value
        ]);
        if ($status->isFailed() || $status->isCancelled()) {
            throw new PaymentCallbackException($request->query('message'), 400);
        }
        if ($this->payment->payable instanceof \App\Models\Membership) {
            $this->isSubscription = true;
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
        EventRegistration::registerUserToEvent($event->id, $user->id);
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
}
