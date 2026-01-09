<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CouponRequest extends FormRequest implements \App\Contract\User\Request\CouponRequest
{
    public function authorize(): bool
    {
        return auth('admin')->check();
    }

    public function rules(): array
    {
        $couponId = $this->route('coupon')?->id ?? null;
        $isCreate = $this->isMethod('post');

        return [
            'code' => [
                $isCreate ? 'required' : 'sometimes',
                'string',
                'max:50',
                Rule::unique('coupons', 'code')->ignore($couponId),
            ],
            'discount_type' => [$isCreate ? 'required' : 'sometimes', Rule::in(['percent', 'fixed'])],
            'value' => [$isCreate ? 'required' : 'sometimes', 'integer', 'min:1', 'max:100000'],
            'applies_to' => [$isCreate ? 'required' : 'sometimes', Rule::in(['event', 'membership', 'library', 'all'])],
            'max_uses' => ['nullable', 'integer', 'min:1'],
            'used_count' => ['nullable', 'integer', 'min:0'],
            'starts_at' => ['nullable', 'date'],
            'expires_at' => ['nullable', 'date', 'after_or_equal:starts_at'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'code' => $this->input('code') ? strtoupper($this->input('code')) : $this->input('code'),
        ]);
    }
}
