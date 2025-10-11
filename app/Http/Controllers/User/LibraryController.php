<?php

namespace App\Http\Controllers\User;

use App\Contract\User\Response\LibraryResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LibraryController extends Controller
{
    public function index()
    {
        return app(LibraryResponse::class);
    }
}
