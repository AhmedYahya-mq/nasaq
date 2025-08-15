<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

/** @package App\View\Components */
class DesktopMenu extends Component
{
    public $menu;
    /**
     * Create a new component instance.
     */
    public function __construct($menu = null)
    {
        $this->menu = $menu;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.desktop-menu', [
            'menu' => $this->menu,
            "hasSubMenu" => isset($this->menu['subMenu']) && count($this->menu['subMenu']) > 0,
        ]);
    }
}
