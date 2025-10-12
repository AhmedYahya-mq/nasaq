<?php 
namespace App\Contract\User\Response;

use App\Models\EventRegistration;
use Illuminate\Contracts\Support\Responsable;

interface EventRegistrationResponse extends Responsable
{
    public function toResponseJson();
    public function toResponseUser($request);
    public function toStoreResponse(EventRegistration $register);
}