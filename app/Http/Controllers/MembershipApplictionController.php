<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class MembershipApplictionController extends Controller
{
    public function index()
    {
        return Inertia::render('user/memberships/Applications');
    }
}
