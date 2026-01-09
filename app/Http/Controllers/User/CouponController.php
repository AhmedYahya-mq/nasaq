<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\CouponRequest;
use App\Http\Responses\User\CouponResponse;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index(Request $request)
    {
        return app(CouponResponse::class)->toResponse($request);
    }

    public function store(CouponRequest $request)
    {
        $data = $request->validated();
        $data['used_count'] = $data['used_count'] ?? 0;

        $coupon = Coupon::create($data);

        return app(CouponResponse::class, ['coupon' => $coupon])->toStoreResponse();
    }

    public function update(CouponRequest $request, Coupon $coupon)
    {
        $coupon->update($request->validated());

        return app(CouponResponse::class, ['coupon' => $coupon])->toStoreResponse();
    }

    public function destroy(Coupon $coupon)
    {
        $coupon->delete();

        return response()->noContent();
    }
}
