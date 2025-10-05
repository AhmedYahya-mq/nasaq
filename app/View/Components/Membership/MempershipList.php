<?php

namespace App\View\Components\Membership;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class MempershipList extends Component
{
    public $memberships;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->memberships = \App\Models\Membership::all();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.membership.mempership-list');
    }
}
