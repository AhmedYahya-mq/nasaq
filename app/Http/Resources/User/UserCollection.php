<?php

namespace App\Http\Resources\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserCollection extends ResourceCollection
{
    public static $wrap = null;
    protected $minimal = false;
    public function __construct($resource, $minimal = false)
    {
        parent::__construct($resource);
        $this->minimal = $minimal;
    }
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request)
    {
        return $this->collection->map(function ($item) use ($request) {
            return app(\App\Contract\User\Resource\UserResource::class, ['resource' => $item, 'minimal' => $this->minimal])
                ->resolve($request);
        })->all();
    }
}
