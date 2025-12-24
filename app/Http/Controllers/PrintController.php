<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PrintController extends Controller
{
    // card print controller methods would go here
    public function printCard(Request $request, $format, \App\Contract\Actions\PrintAction $printAction)
    {
        return $printAction->printCard($format);
    }

    public function printCertifi(Request $request, $format, \App\Contract\Actions\PrintAction $printAction)
    {
        return $printAction->printCertifi($format);
    }
}
