<?php

namespace App\Actions\Fortify;

use App\Models\Admin;
use App\Models\User;
use App\Rules\ArabicLetters;
use App\Rules\EnglishLetters;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255', new ArabicLetters()],
            'english_name' => ['required', 'string', 'max:255', new EnglishLetters()],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'gender' => ['required', Rule::in(['male', 'female'])],
            'phone' => ['required', 'phone:AUTO'],
            'birthday' => ['required', 'date'],
            'password' => $this->passwordRules(),
        ])->validate();
        return User::create([
            'name' => $input['name'],
            'english_name' => $input['english_name'],
            'gender' => $input['gender'],
            'email' => $input['email'],
            'phone' => $input['phone'] ?? null,
            'birthday' => $input['birthday'] ?? null,
            'password' => Hash::make($input['password']),
        ]);
    }
}
