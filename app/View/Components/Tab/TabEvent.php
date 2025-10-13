<?php

namespace App\View\Components\Tab;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class TabEvent extends Component
{
    public $events;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->events = Auth::user()->events()->paginate(10)->appends(['tab' => 'events']);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.tab.tab-event');
    }
}
