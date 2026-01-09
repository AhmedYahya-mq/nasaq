<?php

namespace App\Services\Coupon;

use App\Models\Coupon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class CouponCalculator
{
    public function calculate(?string $code, Model $payable): array
    {
        $basePrice = $this->getBasePrice($payable);
        $discount = $this->getBaseDiscount($payable);
        $membershipDiscount = $this->getMembershipDiscount($payable);

        $coupon = null;
        $couponAmount = 0;

        if ($code !== null && $code !== '') {
            $coupon = $this->validateCoupon($code, $payable);
            $couponAmount = $this->calculateCouponAmount($coupon, $basePrice);
        }

        $finalPrice = max(0, (int) round($basePrice - $couponAmount));

        return [
            'coupon' => $coupon,
            'coupon_amount' => (int) $couponAmount,
            'price' => $payable->price,
            'base_price' => (int) round($basePrice),
            'discount' => $discount,
            'membership_discount' => $membershipDiscount,
            'final_price' => $finalPrice,
            'final_price_halalas' => $finalPrice * 100,
        ];
    }

    protected function validateCoupon(string $code, Model $payable): Coupon
    {
        $coupon = Coupon::active()->where('code', strtoupper($code))->first();

        if (!$coupon) {
            throw ValidationException::withMessages([
                'code' => [__('payments.Invalid coupon code.')],
            ]);
        }

        if ($coupon->max_uses !== null && $coupon->used_count >= $coupon->max_uses) {
            throw ValidationException::withMessages([
                'code' => [__('payments.Coupon usage limit reached.')],
            ]);
        }

        $payableType = $this->determinePayableType($payable);
        if (!$coupon->appliesTo($payableType)) {
            throw ValidationException::withMessages([
                'code' => [__('payments.This coupon cannot be applied to this item.')],
            ]);
        }

        return $coupon;
    }

    protected function calculateCouponAmount(Coupon $coupon, float $basePrice): int
    {
        if ($basePrice <= 0) {
            return 0;
        }

        if ($coupon->discount_type === 'percent') {
            $percent = min(max((float) $coupon->value, 0), 100);
            return (int) round($basePrice * ($percent / 100));
        }

        return (int) min((float) $coupon->value, $basePrice);
    }

    protected function determinePayableType(Model $payable): string
    {
        return Str::of(class_basename($payable))->lower()->toString();
    }

    protected function getBasePrice(Model $payable): float
    {
        return (float) ($payable->regular_price ?? $payable->final_price ?? $payable->price ?? 0);
    }

    protected function getBaseDiscount(Model $payable): int
    {
        if (isset($payable->price) && isset($payable->discounted_price)) {
            return max(0, (int) $payable->price - (int) $payable->discounted_price);
        }

        return 0;
    }

    protected function getMembershipDiscount(Model $payable): int
    {
        return (int) ($payable->membership_discount ?? 0);
    }
}
