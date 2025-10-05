<?php

namespace App\Actions\Payment;

use App\Contract\User\Request\PaymentCallbackRequest;
use App\Models\Payment;
use App\Enums\PaymentStatus;
use App\Exceptions\Payment\PaymentCallbackException;

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
