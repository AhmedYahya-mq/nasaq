<?php

namespace App\Contract\Actions;

use Symfony\Component\HttpFoundation\StreamedResponse;

interface FileLibraryDownload
{
    public function download($file): StreamedResponse;
}
