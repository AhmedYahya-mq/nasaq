<?php

namespace App\Http\Responses\User;

use App\Contract\User\Resource\LibraryCollection;
use App\Contract\User\Resource\LibraryResource;
use App\Models\Library;
use Inertia\Inertia;

class LibraryResponse implements \App\Contract\User\Response\LibraryResponse
{
    public $resource;
    public function __construct($resource = null)
    {
        $this->resource = $resource;
    }
    public function toResponseResource()
    {
        return Inertia::render('user/library', [
            'resource' => $this->resource ? app(LibraryResource::class, ['resource' => $this->resource]) : null
        ])->with('success', __('Library item created successfully'));
    }



    /**
     * Create an HTTP response that represents the object.
     */
    public function toResponse($request)
    {
        $query = Library::withTranslations()->withCount('users')->orderBy('created_at', 'desc');

        // البحث إذا جاء في request
        if ($search = $request->get('search')) {
            $query->whereHas('translationsField', function ($q) use ($search) {
                $q->whereIn('field', ['title', 'description', 'author'])
                    ->where('locale', 'ar')
                    ->where('value', 'like', "%{$search}%");
            });
        }

        // تطبيق pagination مع الاحتفاظ بالـ query string
        $resources = $query->paginate($request->get('per_page', 10))
            ->withQueryString();

        return Inertia::render('user/library', [
            'resources' => app(LibraryCollection::class, ['resource' => $resources]),
        ])->toResponse($request);
    }
}
