<?php

namespace App\View\Components\Pay;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PayForm extends Component
{
    public $item;
    public $isMembership = false;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {

        if (session('payable_type') !== 'App\Models\Membership') {
            $this->item = session('payable_type')::find(session('payable_id'));
            return;
        }
        $this->item = session('payable_type')::find(session('payable_id'));
        $this->isMembership = true;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.pay.pay-form');
    }
}
