<?php

namespace App\View\Components\Events;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CalendarEvent extends Component
{
    public $calendar;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->calendar = \App\Models\Event::getCalendar();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        if (!$this->calendar && count($this->calendar) == 0) {
            return '';
        }
        return view('components.events.calendar-event');
    }
}
