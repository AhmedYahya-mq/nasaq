<?php

namespace App\View\Components\Events;

use App\Models\Event;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class EventFutured extends Component
{
    public $event;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->event = Event::withTranslations()->featured()->first();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        if (!$this->event) {
            return '';
        }
        return view('components.events.event-futured');
    }
}
