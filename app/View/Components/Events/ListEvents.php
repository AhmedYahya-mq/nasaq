<?php

namespace App\View\Components\Events;

use App\Enums\EventStatus;
use App\Models\Event;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ListEvents extends Component
{
    public $events;
    public $isPaginated = true;
    public $isOld = false;
    /**
     * Create a new component instance.
     */
    public function __construct($isPaginated = true, $isOld = false)
    {
        if ($isOld) {
            $this->events = Event::withTranslations()->whereIn('event_status', [EventStatus::Ongoing, EventStatus::Completed])->orderBy('start_at', 'desc')->paginate(request()->get('per_page', 10));
        } else {
            $this->events = Event::withTranslations()->upcoming()->orderBy('start_at', 'desc')->paginate(request()->get('per_page', 10));
        }
        $this->isPaginated = $isPaginated;
        $this->isOld = $isOld;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.events.list-events');
    }
}
