<?php

namespace App\Http\Controllers\User;

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

    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);
        $blog->delete();
    }
}
