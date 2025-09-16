<?php

namespace App\View\Components\Ui;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DeviceSessionItem extends Component
{
    // session properties
    public $session;
    /**
     * Create a new component instance.
     */
    public function __construct($session)
    {
        $this->session = $session;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.ui.device-session-item');
    }
}
