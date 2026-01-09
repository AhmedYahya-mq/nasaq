<?php

namespace App\Http\Requests\User;

use App\Contract\Actions\FilePondAction;
use App\Models\User;
use App\Rules\ValidUploadedFile;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class MembershipAppRequest extends FormRequest implements \App\Contract\User\Request\MembershipAppRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'phone' => ['required', 'phone:AUTO'],
            'job_title' => ['nullable', 'string', 'max:255'],
            'employment_status' => ['nullable', Rule::in(\App\Enums\EmploymentStatus::getValues())],
            'national_id' => ['nullable', 'string', 'max:255'],
            'current_employer' => ['nullable', 'string', 'max:255'],
            'scfhs_number' => ['nullable', 'string', 'max:255'],
            'file' => ['required', 'array', 'max:5'],
            'file.*' => ['required', new ValidUploadedFile(
                ['jpg', 'png', 'jpeg', 'pdf', 'doc', 'docx'],
                10240 // 10MB
            )],
        ];
    }


    // نجاح تحقق
    protected function passedValidation()
    {
        $filePaths = app(FilePondAction::class)->moveToPublic($this->input('file'), 'membership_files');
        $this->merge([
            'file' => $filePaths,
            'status' => \App\Enums\MembershipApplication::Pending,
        ]);
    }
}
