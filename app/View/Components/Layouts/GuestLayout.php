<?php

namespace App\View\Components\Layouts;

use Illuminate\Contracts\View\View;
use Illuminate\Contracts\Support\Htmlable;
use Closure;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\View\Component;

/** @package App\View\Components\Layouts */
class GuestLayout extends Component
{
    public $title;


    public function __construct($title = 'مرحبا بك')
    {
        $this->title = $title;
    }

    /**
     * @return View|Htmlable|Closure|string
     * @throws BindingResolutionException
     */
    public function render()
    {
        return view('layouts.guest');
    }
}
