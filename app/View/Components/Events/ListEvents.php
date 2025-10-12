<?php

namespace App\View\Components\Events;

use App\Models\Event;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ListEvents extends Component
{
    public $events;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->events = Event::withTranslations()->orderBy('start_at', 'desc')->paginate(request()->get('per_page', 1));;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.events.list-events');
    }
}
