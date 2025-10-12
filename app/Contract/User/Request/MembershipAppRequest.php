<?php

namespace App\Contract\User\Request;

interface MembershipAppRequest
{
    public function all($keys = null);
    public function user();
    public function input($key = null, $default = null);
    public function only($keys);
}
