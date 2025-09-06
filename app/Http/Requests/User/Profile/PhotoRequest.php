<?php

namespace App\Http\Requests\User\Profile;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Storage;

class PhotoRequest extends FormRequest implements \App\Contract\User\Profile\PhotoRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'photo' => ['required', 'image', 'max:1024', 'mimes:webp'],
        ];
    }

    protected function passedValidation(): void
    {
        // move the uploaded file to a temporary location photos/profile-photos/{user_id}/{time}_profile.{extension}
        // and delete the old photo if exists and update the user photo path

        $user = $this->user();
        if ($this->hasFile('photo')) {
            $file = $this->file('photo');
            $path = 'photos/profile-photos/' . $user->id;
            $filename = time() . '_profile.' . $file->getClientOriginalExtension();
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }
            $file->storeAs($path, $filename, 'public');
            $user->forceFill([
                'photo' => $path . '/' . $filename,
            ])->save();
        }
    }
}
