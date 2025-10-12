<?php

namespace App\Http\Responses\User;

use Inertia\Inertia;

class LibraryResponse implements \App\Contract\User\Response\LibraryResponse
{



    /**
     * Create an HTTP response that represents the object.
     */
    public function toResponse($request)
    {
        return Inertia::render('user/library')->toResponse($request);
    }
}
