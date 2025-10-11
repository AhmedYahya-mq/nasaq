<?php

namespace App\View\Components\Events;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Calendar extends Component
{
    public $calendar;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->calendar = \App\Models\Event::getCalendar();
        dd($this->calendar);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.events.calendar');
    }
}
