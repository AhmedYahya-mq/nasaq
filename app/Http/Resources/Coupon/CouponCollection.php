<?php

namespace App\Http\Resources\Coupon;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CouponCollection extends ResourceCollection
{
    public static $wrap = null;

    public function toArray(Request $request): array
    {
        return $this->collection->map(function ($item) use ($request) {
            return app(\App\Contract\User\Resource\CouponResource::class, ['resource' => $item]);
        })->all();
    }
}
