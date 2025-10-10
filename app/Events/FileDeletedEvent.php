<?php

namespace App\Events;

use App\Models\MembershipFile;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class FileDeletedEvent
{
    use Dispatchable, SerializesModels;

    public MembershipFile $file;

    public function __construct(MembershipFile $file)
    {
        $this->file = $file;
    }
}
