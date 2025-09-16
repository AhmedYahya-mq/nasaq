<?php

namespace App\Http\Responses\User;

use App\Contract\User\Resource\BlogCollection;
use App\Contract\User\Resource\BlogResource;
use App\Models\Blog;
use Inertia\Inertia;

class BlogResponse implements \App\Contract\User\Response\BlogResponse
{

    /**
     *
     * @return Response
     */
    public function toResponseMembership(Blog $blog)
    {
        return Inertia::render('user/memberships/membership', [
            'membership' => app(BlogResource::class, ['resource' => $blog])
        ])->with('success', __('Membership created successfully'));
    }

    /**
     * Create an HTTP response that represents the object.
     */
    public function toResponse($request)
    {
        $blogs = Blog::withTranslations(locale: ['ar', 'en'])->get();
        return Inertia::render('user/blogs', ['blogs' => app(BlogCollection::class, ['resource' => $blogs])])->toResponse($request);
    }
}
