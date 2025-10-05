<?php

namespace App\View\Components\Tab;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TabRequest extends Component
{
    public $membershipApplications;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $user=auth()->user();
        if(!$user){
            abort(403);
        }
        $this->membershipApplications = $user->membershipApplications()->paginate(1)->appends(['tab' => 'requests']);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.tab.tab-request');
    }
}
