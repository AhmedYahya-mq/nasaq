<?php

namespace App\View\Components\Events;

use App\Models\Event;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CardEvent extends Component
{
    public Event $event;
    public $isRegistration;
    public $membership_names = [];
    /**
     * Create a new component instance.
     */
    public function __construct(Event $event)
    {
        $this->event = $event;
        $this->isRegistration = $event->isUserRegistered(auth()->id() ?? 0);
        $this->membership_names = $event->memberships()->pluck('name')->toArray();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.events.card-event');
    }
}
