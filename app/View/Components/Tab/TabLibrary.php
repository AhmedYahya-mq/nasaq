<?php

namespace App\View\Components\Tab;

use App\Models\Library;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TabLibrary extends Component
{
    public $resources;

    public function __construct()
    {
        $filter = request()->get('filter', 'all');
        $search = request()->get('search', '');

        $query = Library::query();

        if ($filter !== 'all') {
            $query->where('type', $filter);
        }

        if ($search) {
            $query->whereHas('translationsField', function ($q) use ($search) {
                $q->whereIn('field', ['title', 'description', 'author'])
                    ->where('locale', app()->getLocale())
                    ->where('value', 'like', "%{$search}%");
            });
        }

        $this->resources = $query->withTranslations([], app()->getLocale())
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.tab.tab-library');
    }
}
