<?php

namespace App\Http\Responses\User;

use App\Contract\User\Resource\EventCollection;
use App\Contract\User\Resource\EventResource;
use App\Contract\User\Response\EventResponse as ResponeEventResponse;
use App\Models\Event;
use Inertia\Inertia;

class EventResponse implements ResponeEventResponse
{
    public $event;
    public function __construct($event = null)
    {
        $this->event = $event;
    }

    public function toResponseUser($request)
    {
        // pagtinated
        $events = Event::withTranslations()->orderBy('start_at', 'desc')->paginate($request->get('per_page', 1));
        return view('events', [
            'events' => $events
        ]);
    }

    public function toResponseView($request)
    {
        return Inertia::render('user/event-details', [
            'event' => $this->event ? app(EventResource::class, ['resource' => $this->event]) : null,
        ])->toResponse($request);
    }

    public function toResponseJson()
    {
        return response()->json([
            'event' => $this->event ? app(EventCollection::class, ['resource' => $this->event, 'minimal' => true]) : null,
        ]);
    }

    public function toResponse($request)
    {
        // pagtinated
        $events = Event::withTranslations()->orderBy('start_at', 'desc')->paginate($request->get('per_page', 1));
        $events = app(EventCollection::class, ['resource' => $events, 'minimal' => true]);
        return Inertia::render('user/events', [
            'events' => $events,
        ])->toResponse($request);
    }

    public function toStoreResponse()
    {
        return Inertia::render('user/events', [
            'event' => app(EventResource::class, ['resource' => $this->event]),
        ])->with('success', __('Event created successfully'));;
    }
}
