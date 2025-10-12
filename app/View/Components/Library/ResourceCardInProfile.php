<?php

namespace App\View\Components\Library;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ResourceCardInProfile extends Component
{
    public $resource;
    /**
     * Create a new component instance.
     */
    public function __construct($resource)
    {
        $this->resource = $resource;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.library.resource-card-in-profile');
    }
}
