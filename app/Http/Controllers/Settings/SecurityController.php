<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Services\Agent;
use Carbon\Carbon;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Inertia\Response;
use Laravel\Fortify\Actions\GenerateNewRecoveryCodes;

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
            'sessions' => $this->sessions($request)->all(),
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


    /**
     * Get the current sessions.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Support\Collection
     */
    public function sessions(Request $request)
    {
        if (config('session.driver') !== 'database') {
            return collect();
        }

        return collect(
            DB::connection(config('session.connection'))->table(config('session.table', 'sessions'))
                ->where('user_id', $request->user('admin')->getAuthIdentifier())
                ->orderBy('last_activity', 'desc')
                ->get()
        )->map(function ($session) use ($request) {
            $agent = $this->createAgent($session);

            return (object) [
                'id' => $session->id,
                'agent' => [
                    'is_desktop' => $agent->isDesktop(),
                    'platform' => $agent->platform(),
                    'browser' => $agent->browser(),
                ],
                'ip_address' => $session->ip_address,
                'is_current_device' => $session->id === $request->session()->getId(),
                'last_active' => Carbon::createFromTimestamp($session->last_activity)->diffForHumans(),
            ];
        });
    }

    /**
     * Create a new agent instance from the given session.
     *
     * @param  mixed  $session
     * @return \Laravel\Jetstream\Agent
     */
    protected function createAgent($session)
    {
        return tap(new Agent(), fn($agent) => $agent->setUserAgent($session->user_agent));
    }
}
