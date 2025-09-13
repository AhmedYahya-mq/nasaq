<?php

namespace App\Http\Resources\Membership;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class MembershipCollection extends ResourceCollection
{
    public static $wrap = null;
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request)
    {
        return $this->collection;
    }
}
