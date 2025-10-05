<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class PaymentCallbackRequest extends FormRequest implements \App\Contract\User\Request\PaymentCallbackRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id' => 'required|string|exists:payments,moyasar_id',
            'status' => 'required|string|in:' . implode(',', \App\Enums\PaymentStatus::getValues()),
        ];
    }

    // تعيين أسماء الحقول للرسائل
    public function attributes(): array
    {
        return [
            'id' => 'Payment ID',  // سيظهر هذا الاسم في رسائل الـ validation
            'status' => 'Status',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = ['form' => $validator->errors()->first()];

        throw new ValidationException($validator, response()->json([
            'success' => false,
            'errors' => $errors
        ], 422));
    }
}
