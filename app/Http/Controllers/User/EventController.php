<?php

namespace App\Http\Controllers\User;

use App\Contract\User\Request\EventRequest;
use App\Contract\User\Response\EventResponse;
use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventRegistration;
use Illuminate\Http\Request;

class EventController extends Controller
{

    public function __invoke()
    {
        return app(EventResponse::class)->toResponseUser(request());
    }

    public function calender(Request $request)
    {
        $date = $request->query('date', now()->toDateString());
        $events = Event::upcoming()->whereDate('start_at', $date)->get();
        return app(EventResponse::class, ['event' => $events])->toResponseJson();
    }

    public function index()
    {
        return app(EventResponse::class);
    }

    public function store(EventRequest $request)
    {
        $data = $request->all();
        $event = Event::create($data);
        $event->updateTranslations($data['translations'] ?? [], $request->header('X-Locale', config('app.locale')));
        if (!empty($data['accepted_membership_ids'])) {
            $event->memberships()->sync($data['accepted_membership_ids']);
        }
        return app(EventResponse::class, ['event' => $event])->toStoreResponse();
    }

    public function update(EventRequest $request, Event $event)
    {
        $data = $request->all();
        // اذا كان تاريخ الذي تم ارساله 
        $event->update($data);
        $event->updateTranslations($data['translations'] ?? [], $request->header('X-Locale', config('app.locale')));
        if (array_key_exists('accepted_membership_ids', $data)) {
            $event->memberships()->sync($data['accepted_membership_ids']);
        } else {
            $event->memberships()->detach();
        }

        return app(EventResponse::class, ['event' => $event])->toStoreResponse();
    }

    public function updateTranslation(EventRequest $request, Event $event)
    {
        $data = $request->all();
        $event->updateTranslations($data['translations'], $request->header('X-Locale', config('app.locale')));
        $event->save();
        return app(EventResponse::class, ['event' => $event])->toStoreResponse();
    }

    public function destroy(Event $event)
    {
        $event->memberships()->detach();
        $event->registrations()->delete();
        $event->delete();
    }

    public function show(Event $event)
    {
        return app(EventResponse::class, ['event' => $event])->toResponseView(request());
    }

    public function toogleFutured(Event $event)
    {
        Event::where('is_featured', true)->update(['is_featured' => false]);
        $event->is_featured = !$event->is_featured;
        $event->save();

        return app(EventResponse::class, ['event' => $event])->toResponseApi();
    }

    public function register(Event $event)
    {
        EventRegistration::registerUserToEvent($event->id, auth()->id());
        return back()->with('success', __('events.messages.registration_successful'));
    }

    public function cancel(Event $event)
    {
        $event->event_status = \App\Enums\EventStatus::Cancelled;
        $event->save();
        return app(EventResponse::class, ['event' => $event])->toResponseApi();
    }

    public function complete(Event $event)
    {
        $event->event_status = \App\Enums\EventStatus::Completed;
        $event->save();
        return app(EventResponse::class, ['event' => $event])->toResponseApi();
    }

    public function activate(Event $event)
    {
        $isOld= $event->start_at->isAfter(now());
        if($isOld){
            $event->event_status = \App\Enums\EventStatus::Upcoming;
        }else{
            $event->event_status = \App\Enums\EventStatus::Ongoing;
        }
        $event->save();
        return app(EventResponse::class, ['event' => $event])->toResponseApi();
    }

    public function updateLink(EventRequest $request, Event $event)
    {
        $data = $request->all();
        $event->update($data);
        $event->updateTranslations($data['translations'] ?? [], $request->header('X-Locale', config('app.locale')));
        if (array_key_exists('accepted_membership_ids', $data)) {
            $event->memberships()->sync($data['accepted_membership_ids']);
        } else {
            $event->memberships()->detach();
        }
        return app(EventResponse::class, ['event' => $event])->toResponseApi();
    }

    public function redirctToEvent(Event $event)
    {
        $user = auth()->user();

        // جلب تسجيل المستخدم للفعالية (مضمون أنه موجود بفضل Middleware)
        $registration = EventRegistration::where('event_id', $event->id)
            ->where('user_id', $user->id)
            ->firstOrFail();
        $registration->update([
            'joined_at' => now(),
            'join_ip' => request()->ip(),
            'join_link' => $event->link,
            'is_attended' => true,
        ]);

        // إعادة التوجيه إلى رابط الفعالية
        return redirect()->away($event->link);
    }
}
