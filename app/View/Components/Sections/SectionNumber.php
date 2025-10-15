<?php

namespace App\View\Components\Sections;

use App\Enums\EventType;
use App\Models\Event;
use App\Models\Library;
use App\Models\User;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\View\Component;

class SectionNumber extends Component
{
    public $count_members;
    public $count_library;
    public $count_meetings;
    public $count_webinars;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->count_members = User::count();
        $this->count_library = Library::count();
        $this->countByType();
    }

    /**
     * عدد الفعاليات حسب نوعها (افتراضي: Virtual و Physical)
     *
     * @return array<string,int>
     */
    public function countByType()
    {
        $counts = Event::query()
            ->select('event_type', DB::raw('COUNT(*) as total'))
            ->groupBy('event_type')
            ->pluck('total', 'event_type')
            ->toArray();
        $this->count_meetings = $counts[EventType::Physical] ?? 0;
        $this->count_webinars = $counts[EventType::Virtual] ?? 0;
    }


    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.sections.section-number');
    }
}
