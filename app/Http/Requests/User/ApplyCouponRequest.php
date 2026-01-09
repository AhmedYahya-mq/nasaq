<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class ApplyCouponRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'code' => ['required', 'string', 'max:50'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'code' => $this->input('code') ? strtoupper($this->input('code')) : $this->input('code'),
        ]);
    }
}
