<?php

namespace App\Http\Controllers;

use App\Contract\Actions\CreatePaymentIntent;
use App\Contract\Actions\PaymentCallback;
use App\Contract\User\Request\PaymentCallbackRequest;
use App\Contract\User\Request\PaymentRequest;
use App\Contract\User\Response\PaymentResponse;
use App\Http\Requests\User\ApplyCouponRequest;
use App\Services\Coupon\CouponCalculator;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

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
                ->toErrorResponse($e->getMessage(), 400);
        }
    }

    public function applyCoupon(ApplyCouponRequest $request, CouponCalculator $calculator)
    {
        $payable = $this->resolvePayableFromSession();

        if (!$payable) {
            return response()->json([
                'success' => false,
                'message' => 'Item not found for this payment session.',
            ], 404);
        }

        try {
            $result = $calculator->calculate($request->input('code'), $payable);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage() ?: 'Invalid coupon code.',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Unable to apply coupon right now.',
            ], 400);
        }

        return response()->json([
            'success' => true,
            'coupon' => $result['coupon'] ? [
                'code' => $result['coupon']->code,
                'discount_type' => $result['coupon']->discount_type,
                'value' => $result['coupon']->value,
            ] : null,
            'amounts' => [
                'base' => $result['base_price'],
                'discount' => $result['discount'],
                'membership_discount' => $result['membership_discount'],
                'coupon' => $result['coupon_amount'],
                'total' => $result['final_price'],
            ],
        ]);
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

    protected function resolvePayableFromSession()
    {
        $type = session('payable_type');
        $id = session('payable_id');

        if (!$type || !$id || !class_exists($type)) {
            return null;
        }

        return $type::find($id);
    }

}
