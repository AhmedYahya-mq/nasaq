<?php

namespace App\Actions\Fortify;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\UpdatesUserPasswords;

class UpdateUserPassword implements UpdatesUserPasswords
{
    use PasswordValidationRules;

    /**
     * Validate and update the user's password.
     *
     * @param  array<string, string>  $input
     */
    public function update(Admin|User $user, array $input): RedirectResponse
    {
        $validated = Validator::make($input, [
            'current_password' => ['required', 'string', 'current_password:' . $user->guard_name],
            'password' => $this->passwordRules(),
        ], [
            'current_password.current_password' => __('The provided password does not match your current password.'),
        ])->validate();
        $user->forceFill([
            'password' => Hash::make($validated['password']),
        ])->save();
        return back();
    }
}
