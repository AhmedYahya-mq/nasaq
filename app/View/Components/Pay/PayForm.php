<?php

namespace App\View\Components\Pay;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PayForm extends Component
{
    public $item;
    public $isMembership = false;
    public $startAt;
    public $endsAt;
    public $intentToken;
    /**
     * Create a new component instance.
     */
    public function __construct($item = null, $intentToken = null, $isMembership = false, $startAt = null, $endsAt = null)
    {
        $this->item = $item;
        $this->intentToken = $intentToken;
        $this->isMembership = (bool) $isMembership;
        $this->startAt = $startAt;
        $this->endsAt = $endsAt;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.pay.pay-form');
    }
}
