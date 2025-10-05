<?php

namespace App\View\Components\Ui;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CardProfile extends Component
{
    public $user;
    public $draftApplication;
    public $hasDraftApplication;
    public $draftMembershipName;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->user = auth()->user();
        $this->draftApplication = $this->user->draftMembershipApplication();
        $this->hasDraftApplication = !is_null($this->draftApplication);

        
        $this->draftMembershipName = $this->hasDraftApplication
            ? $this->draftApplication->membership?->name
            : null;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.ui.card-profile');
    }
}
