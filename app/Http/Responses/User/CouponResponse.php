<?php

namespace App\Http\Responses\User;

use App\Contract\User\Response\CouponResponse as CouponResponseContract;
use App\Http\Resources\Coupon\CouponCollection;
use App\Http\Resources\Coupon\CouponResource;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CouponResponse implements CouponResponseContract
{
    public function __construct(private ?Coupon $coupon = null)
    {
    }

    public function toResponse($request)
    {
        $query = Coupon::query()->orderByDesc('created_at');

        if ($search = $request->get('search')) {
            $query->where('code', 'like', "%{$search}%");
        }

        $coupons = $query->paginate($request->get('per_page', 10))->withQueryString();
        $coupons = app(CouponCollection::class, ['resource' => $coupons]);

        return Inertia::render('user/coupons', [
            'coupons' => $coupons,
        ])->toResponse($request);
    }

    public function toStoreResponse()
    {
        return Inertia::render('user/coupons', [
            'coupon' => app(CouponResource::class, ['resource' => $this->coupon]),
        ])->with('success', __('Coupon saved successfully'));
    }
}
