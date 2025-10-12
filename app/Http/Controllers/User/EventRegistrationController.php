<?php
namespace App\Http\Controllers\User;
use App\Contract\User\Response\EventRegistrationResponse;
use App\Http\Controllers\Controller;
use App\Models\EventRegistration;
use Illuminate\Http\Request;

class EventRegistrationController extends Controller
{
    protected $eventRegistrationResponse;

    public function __construct(EventRegistrationResponse $eventRegistrationResponse)
    {
        $this->eventRegistrationResponse = $eventRegistrationResponse;
    }

    public function index(Request $request, $id)
    {
        return $this->eventRegistrationResponse->toResponse($request, $id);
    }

    public function toogleAttendance(Request $request,  $eventRegistration)
    {
        $eventRegistration = EventRegistration::findOrFail($eventRegistration);
        $eventRegistration->is_attended = !$eventRegistration->is_attended;
        $eventRegistration->save();
        return $this->eventRegistrationResponse->toStoreResponse($eventRegistration);
    }
}