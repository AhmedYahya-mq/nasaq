<?php

namespace App\Contract\Actions;

use Illuminate\Http\Response;

interface PrintAction
{
    public function printCard(string $format): Response;
    public function printCertifi(string $format): Response;
}
