<?php

namespace App\Http\Controllers;

use App\Contract\Actions\FilePondAction;
use Illuminate\Http\Request;

class FilePondController extends Controller
{
    protected $filePondAction;

    public function __construct()
    {
        $this->filePondAction = app()->make(FilePondAction::class);
    }

    public function process(Request $request)
    {
        return $this->filePondAction->process($request);
    }

    public function revert(Request $request)
    {
        return $this->filePondAction->revert($request);
    }

    public function restore($id)
    {
        return $this->filePondAction->restore($id);
    }

    public function remove(Request $request)
    {
        return $this->filePondAction->remove($request);
    }
}
