<?php

namespace App\Http\Controllers;

use Ahmed\GalleryImages\Models\Photo;
use Ahmed\GalleryImages\Contracts\Request\PhotoRequestContract;
use Ahmed\GalleryImages\Contracts\Resources\PhotoCollectionContract;

class PhotoController extends Controller
{

    public function index()
    {
        // Adding 10 to the pagination limit to include extra records for preloading or buffer purposes.
        $photos = Photo::Photos()->paginate(10);
        return app(PhotoCollectionContract::class, ["resource" => $photos]);
    }

    public function store(PhotoRequestContract $request)
    {
        $photos = Photo::createPhotos($request->file('files'));
        return app(PhotoCollectionContract::class, ["resource" => $photos]);
    }
}
