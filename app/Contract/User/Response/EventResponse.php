<?php

namespace App\Contract\User\Response;

use Illuminate\Contracts\Support\Responsable;

interface EventResponse extends Responsable
{
    public function toStoreResponse();
    public function toResponseJson();
    public function toResponseView($request);
    public function toResponseUser($request);
}
