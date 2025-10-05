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
        $blog = Blog::create($request->all());
        $blog->updateTranslations(
            $request->only(array_merge(['title', 'excerpt'], $blog->translatable ?? [])),
            $request->header('X-Locale', 'ar')
        );
        $blog->syncPhotosById($request->input('image_id', []));
        return app(BlogResponse::class)->toResponseBlog($blog);
    }

    public function update(BlogRequest $request, $id)
    {
        $blog = Blog::findOrFail($id);
        $blog->update($request->all());
        $blog->updateTranslations(
            $request->only(array_merge(['title', 'excerpt'], $blog->translatable ?? [])),
            $request->header('X-Locale', 'ar')
        );
        if ($request->has('image_id')) {
            $blog->syncPhotosById($request->input('image_id', []));
        }
        return app(BlogResponse::class)->toResponseBlog($blog);
    }

    public function updateTranslation(BlogRequest $request, $id)
    {
        $blog = Blog::findOrFail($id);
        $data = $request->only(['title', 'excerpt']);
        $blog->updateTranslations($data, $request->header('X-Locale', 'ar'));
        $blog->setTranslation('content', $request->header('X-Locale', 'ar'), $data['content'] ?? $blog->content);
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
