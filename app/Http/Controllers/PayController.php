<?php

namespace App\Http\Controllers;

use App\Contract\Actions\CreatePaymentIntent;
use App\Contract\Actions\PaymentCallback;
use App\Contract\User\Request\PaymentCallbackRequest;
use App\Contract\User\Request\PaymentRequest;
use App\Contract\User\Response\PaymentResponse;
use Illuminate\Http\Request;

class PayController extends Controller
{
    public function index()
    {
        return view('pay');
    }

    public function createPayment(PaymentRequest $request, CreatePaymentIntent $createPaymentIntent)
    {
        try {
            $payment = $createPaymentIntent->execute($request);
            return app(PaymentResponse::class, ['payment' => $payment]);
        } catch (\Exception $e) {
            return app(PaymentResponse::class)
                ->toErrorResponse($e->getMessage(), $e->getCode() ?: 400);
        }
    }


    public function handleCallback(PaymentCallbackRequest $request, PaymentCallback $paymentCallback)
    {
        try {
            $paymentCallback->handle($request);
            return app(PaymentResponse::class, ['payment' => $paymentCallback->payment])
                ->toCallbackResponseWithDetails($paymentCallback->isSubscription);
        } catch (\Exception $e) {
            return app(PaymentResponse::class, ['payment' => $paymentCallback->payment])
                ->toCallbackErrorResponse($e->getMessage());
        }
    }

    public function success()
    {
        return view('pay-success');
    }

    public function failure()
    {
        return view('pay-failure');
    }

    public function refund(Request $request)
    {
        // منطق استرجاع الدفع هنا
    }

    public function paymentStatus($paymentId)
    {
        // منطق جلب حالة الدفع هنا
    }
}
