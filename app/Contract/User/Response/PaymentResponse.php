<?php

namespace App\Contract\User\Response;

use Illuminate\Contracts\Support\Responsable;

interface PaymentResponse extends Responsable
{

    /**
     * Create an HTTP response that represents the object.
     * @param Request $request
     */
    public function toResponse($request);

    
}
