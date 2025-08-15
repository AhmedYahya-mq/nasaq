<?php

namespace App\View\Components\Layouts;


use Illuminate\View\Component;

/** @package App\View\Components\Layouts */
class AppLayout extends Component
{
    public $title;


    public function __construct($title = 'موقعي')
    {
        $this->title = $title;
    }


    public function render()
    {
        return view('layouts.app');
    }
}
