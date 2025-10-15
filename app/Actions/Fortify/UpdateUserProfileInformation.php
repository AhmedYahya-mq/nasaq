<?php

namespace App\Actions\Fortify;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    /**
     * Validate and update the given user's profile information.
     *
     * @param  array<string, string>  $input
     */
    public function update(User|Admin $user, array $input): void
    {
        $this->validetor($user, $input);
        $data = collect($input)
            ->filter(fn($value) => !is_null($value) && $value !== '') // تجاهل null والفارغ ''
            ->only($user->getFillable())
            ->toArray();

        if (
            $input['email'] !== $user->email &&
            $user instanceof MustVerifyEmail
        ) {
            $this->updateVerifiedUser($user, $data);
        } else {
            $user->forceFill($data)->save();
        }
    }

    /**
     * Update the given verified user's profile information.
     *
     * @param  array<string, string>  $input
     */
    protected function updateVerifiedUser(User $user, array $data): void
    {
        $user->forceFill(array_merge($data, ['email_verified_at' => null]))->save();
        $user->sendEmailVerificationNotification();
    }

    protected function rules(Admin|User $user): array
    {
        if ($user instanceof Admin) {
            return [
                'name' => ['required', 'string', 'max:255'],
                'email' => [
                    'required',
                    'string',
                    'email',
                    'max:255',
                    Rule::unique('admins')->ignore($user->id),
                ],
            ];
        } else {
            return [
                'name' => ['required', 'string', 'max:255'],
                'email' => [
                    'required',
                    'string',
                    'email:rfc,dns',
                    'max:255',
                    Rule::unique($user->getTable())->ignore($user->id),
                ],
                'phone' => ['required', 'phone:AUTO'],
                'birthday' => ['required', 'date'],
                'address' => ['nullable', 'string', 'max:255'],
                'job_title' => ['nullable', 'string', 'max:255'],
                'employment_status' => ['nullable', 'string', 'max:50', Rule::in(\App\Enums\EmploymentStatus::getValues())],
                'bio' => ['nullable', 'string', 'max:500'],
            ];
        }
    }

    protected function validetor(Admin|User $user, array $data)
    {
        validator($data, $this->rules($user))->validateWithBag('updateProfileInformation');
    }
}
