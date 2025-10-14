<?php

namespace App\View\Components\Blog;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CardBlog extends Component
{
    public $blog;
    public $photo;
    /**
     * Create a new component instance.
     */
    public function __construct($blog)
    {
        $this->blog = $blog;
        $this->photo = $blog->photos->first();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.blog.card-blog');
    }
}
