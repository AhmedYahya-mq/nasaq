<?php

namespace App\Contract\User\Response;

use Illuminate\Contracts\Support\Responsable;

interface CouponResponse extends Responsable
{
    public function toStoreResponse();
}
