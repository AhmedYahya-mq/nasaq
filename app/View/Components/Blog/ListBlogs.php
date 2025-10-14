<?php

namespace App\View\Components\Blog;

use App\Models\Blog;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ListBlogs extends Component
{
    public $blogs;
    public $isPaginated = true;
    /**
     * Create a new component instance.
     */
    public function __construct($isPaginated = true)
    {
        $this->isPaginated = $isPaginated;
        $search = request()->get('search', '');
        $query = Blog::query();
        if ($search) {
            $query->whereHas('translationsField', function ($q) use ($search) {
                $q->whereIn('field', ['title', 'excerpt'])
                    ->where('locale', app()->getLocale())
                    ->where('value', 'like', "%{$search}%");
            });
        }
        $this->blogs = $query->withTranslations([], app()->getLocale())
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.blog.list-blogs');
    }
}
