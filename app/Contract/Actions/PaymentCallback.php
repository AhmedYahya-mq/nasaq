<?php

namespace App\Contract\Actions;

use App\Contract\User\Request\PaymentCallbackRequest;

interface PaymentCallback
{
    public function handle(PaymentCallbackRequest $request);
}
