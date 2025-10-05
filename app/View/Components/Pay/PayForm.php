<?php

namespace App\View\Components\Pay;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PayForm extends Component
{
    public $item;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->item = session('payable_type')::find(session('payable_id'));
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.pay.pay-form');
    }
}
