<?php

namespace App\Http\Controllers\User\Settings;

use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Actions\ConfirmPassword;

class OtherBrowserSessionsController extends Controller
{
    /**
     * Log out from other browser sessions.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        $guard = Auth::guard();

        $guard->logoutOtherDevices($request->password);

        $this->deleteOtherSessionRecords($request);

        return back();
    }

    /**
     * Delete the other browser session records from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function deleteOtherSessionRecords(Request $request)
    {
        if (config('session.driver') !== 'database') {
            return;
        }

        DB::connection(config('session.connection'))->table(config('session.table', 'sessions'))
            ->where('user_id', $request->user()->getAuthIdentifier())
            ->where('id', '!=', $request->session()->getId())
            ->delete();
    }


    /**
     * Destroy the one session.
     * @param Request $request
     * @param string $sessionId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroyOne(Request $request, string $sessionId)
    {
        if (config('session.driver') !== 'database') {
            return back(303);
        }

        DB::connection(config('session.connection'))->table(config('session.table', 'sessions'))
            ->where('user_id', $request->user()->getAuthIdentifier())
            ->where('id', '=', $sessionId)
            ->delete();

        return back(303);
    }
}
