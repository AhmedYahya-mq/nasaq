<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

/** @package App\View\Components */
class DesktopMenu extends Component
{
    public $menu;
    public $hasSubMenu;
    public $isActive=false;

    /**
     * Create a new component instance.
     */
    public function __construct($menu = null)
    {
        $this->menu = $menu;
        $this->hasSubMenu = isset($menu['subMenu']) && count($menu['subMenu']) > 0;
        $this->isActive = $menu['active']() ?? false;
    }
    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.desktop-menu');
    }
}
