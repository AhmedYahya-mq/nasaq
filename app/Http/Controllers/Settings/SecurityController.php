<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Inertia\Response;
use Laravel\Fortify\Actions\GenerateNewRecoveryCodes;
use Laravel\Fortify\Fortify;

class SecurityController extends Controller
{
    /**
     * Display the security settings page.
     * @param Request $request
     * @return Response
     * @throws BindingResolutionException
     */
    public function index(Request $request)
    {
        return inertia('settings/security', [
            'status' => session('status'),
        ]);
    }

    /**
     * Generate a fresh set of two factor authentication recovery codes.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Laravel\Fortify\Actions\GenerateNewRecoveryCodes  $generate
     * @return \Laravel\Fortify\Contracts\RecoveryCodesGeneratedResponse
     */
    public function store(Request $request, GenerateNewRecoveryCodes $generate)
    {
        $generate($request->user());

        return response()->json(json_decode((Model::$encrypter ?? Crypt::getFacadeRoot())->decrypt(
            $request->user()->two_factor_recovery_codes
        ), true));
    }
}
