<?php

namespace App\Contract\User\Request;

interface CouponRequest
{
    public function all($keys = null);
    public function validated($key = null, $default = null);
    public function header($key = null, $default = null);
}
