<?php

namespace App\Http\Controllers\User;

use App\Contract\User\Request\BlogRequest;
use App\Contract\User\Response\BlogResponse;
use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        return app(BlogResponse::class);
    }

    public function store(BlogRequest $request)
    {
        $data = $request->only((new Blog())->getFillable());
        $blog = Blog::create($data);
        $blog->updateTranslations(
            $request->input('translations', []),
            $request->header('X-Locale', config('app.locale'))
        );
        $blog->syncPhotosById($request->input('image_id', []));
        return app(BlogResponse::class)->toResponseBlog($blog);
    }

    public function update(BlogRequest $request, $id)
    {
        $blog = Blog::findOrFail($id);
        $data = $request->only($blog->getFillable());
        $blog->update($data);
        $translations = $request->input('translations', []);
        if (!empty($translations)) {
            $locale = $request->header('X-Locale', config('app.locale'));
            $blog->updateTranslations($translations, $locale);
        }
        if ($request->has('image_id')) {
            $blog->syncPhotosById($request->input('image_id', []));
        }

        return app(BlogResponse::class)->toResponseBlog($blog);
    }


    public function updateTranslation(BlogRequest $request, $id)
    {
        $blog = Blog::findOrFail($id);
        $data = $request->only(['title', 'excerpt', 'content']);
        $blog->updateTranslations($data, $request->header('X-Locale', 'ar'));
        if (isset($data['content']) && !empty($data['content'])) {
            foreach ($data['content'] as $locale => $value) {
                $blog->setTranslation('content', $locale, $value);
            }
            $blog->save();
        }

        $blog->save();
        return app(BlogResponse::class)->toResponseBlog($blog);
    }

    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);
        $blog->clearTranslations();
        $blog->clearPhotos();
        $blog->delete();
    }
}
