<?php

namespace App\View\Components\Membership;

use App\Models\MembershipApplication;
use App\Models\User;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class MembershipForm extends Component
{
    public MembershipApplication $application;
    public User $user;
    /**
     * Create a new component instance.
     */
    public function __construct(MembershipApplication $application)
    {
        $this->application = $application;
        $this->user = auth()->user();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.membership.membership-form');
    }
}
