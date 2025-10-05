<?php

namespace App\Http\Responses\User;

use App\Contract\User\Response\PaymentResponse as ResponsePaymentResponse;
use App\Models\Payment;

class PaymentResponse implements ResponsePaymentResponse
{

    protected ?Payment $payment;

    public function __construct($payment = null)
    {
        $this->payment = $payment;
    }

    /**
     * Create an HTTP response that represents the object.
     */
    public function toResponse($request)
    {
        return app(\App\Contract\User\Resource\PaymentResource::class, ['resource' => $this->payment, 'minimal' => true]);
    }

    public function toResponseWithDetails($request)
    {
        return app(\App\Contract\User\Resource\PaymentResource::class, ['resource' => $this->payment]);
    }

    public function toErrorResponse($message, $code = 400)
    {
        return response()->json([
            'success' => false,
            'message' => $message
        ], $code);
    }


    // callback response with details
    public function toCallbackResponseWithDetails(bool $isSubscription = false)
    {
        if (!$isSubscription) {
            return view('success', [
                'payment' => $this->payment,
            ]);
        }
        return redirect()->route('client.membership.request', ['application' => $this->payment->membershipApplication])
            ->with('success', __('Payment successful, please complete your membership application.'));
    }

    // callback response error
    public function toCallbackErrorResponse($message)
    {
        // model payable
        $type = strtolower(class_basename($this->payment->payable_type));
        return redirect()->route('client.pay.index', [
            'id' => $this->payment->payable_id,
            'type' => $type,
        ])->withErrors(['form' => $message]);
    }
}
