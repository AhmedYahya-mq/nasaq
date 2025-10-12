<?php

namespace App\Contract\User\Request;

interface LibraryRequest
{
    public function all($keys = null);
    public function header($key = null, $default = null);
    public function only($keys);
}
