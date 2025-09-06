<?php

namespace App\Http\Responses\User\Profile;

use App\Contract\User\Profile\PhotoResponse as PhotoResponseContract;
use Illuminate\Http\JsonResponse;

class PhotoResponse implements PhotoResponseContract
{
    public function toResponse($request)
    {
        return new JsonResponse($request->user()->profile_photo_url);
    }
}
