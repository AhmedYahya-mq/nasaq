<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class InvoiceOfficial extends Component
{
    public $payment;
    public $payable;
    /**
     * Create a new component instance.
     */
    public function __construct($payment)
    {
        $this->payment = $payment;
        $this->payable = $payment->payable;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.invoice-official');
    }
}
