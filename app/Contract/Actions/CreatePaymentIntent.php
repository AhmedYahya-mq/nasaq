<?php
namespace App\Contract\Actions;

use App\Contract\User\Request\PaymentRequest;
use App\Models\Payment;

interface CreatePaymentIntent
{
    public function execute(PaymentRequest $request): Payment;
}
