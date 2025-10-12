<?php

namespace App\View\Components\Sections;

use App\Models\Library;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class LibrarySection extends Component
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

    public function render(): View|Closure|string
    {
        return view('components.sections.library-section');
    }
}
