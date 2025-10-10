<?php

namespace App\Contract\User\Request;

/** @package App\Contract\User\Request */
interface EventRequest
{
    /**
     * @param array|null $keys 
     * @return mixed 
     */
    public function all($keys = null);
    public function header($key = null, $default = null);
}
