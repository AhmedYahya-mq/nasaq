<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest implements \App\Contract\User\Request\UserRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth('admin')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */

    public function rules(): array
    {
        $user = $this->route('user'); // المستخدم إذا كان التحديث، null إذا إضافة

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user?->id),
            ],
            'phone' => ['required', 'phone:AUTO'],
            'birthday' => ['nullable', 'date'],
            'address' => ['nullable', 'string', 'max:255'],
            'job_title' => ['nullable', 'string', 'max:255'],
            'employment_status' => ['nullable', Rule::in(\App\Enums\EmploymentStatus::getValues())],
            'password' => $user
                ? ['nullable', 'string', 'min:8', 'confirmed'] // تحديث: كلمة المرور اختيارية
                : ['required', 'string', 'min:8', 'confirmed'], // إضافة: كلمة المرور مطلوبة
        ];
    }


    // تجهيز البيانات قبل تحقق
    protected function prepareForValidation()
    {
        if ($this->membership_id === 'none') {
            $this->offsetUnset('membership_id');
        }

        // حذف المسافات من رقم من اي مكان
        if ($this->has('phone')) {
            $phone = preg_replace('/\s+/', '', $this->input('phone'));
            $this->merge(['phone' => $phone]);
        }
    }

    // بعد التحقق
    protected function passedValidation()
    {
        $data = $this->all();
        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = bcrypt($data['password']);
        }
        
        if (isset($data['email'])) {
            $data['email'] = strtolower(trim($data['email']));
        }

        $this->replace($data);
    }
}
