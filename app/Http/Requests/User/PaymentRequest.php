<?php

namespace App\Http\Requests\User;

use App\Contract\User\Request\PaymentRequest as RequestPaymentRequest;
use App\Rules\CardCvc;
use App\Rules\CardExpirationMonth;
use App\Rules\CardExpirationYear;
use App\Rules\CardNumber;
use Illuminate\Foundation\Http\FormRequest;


class PaymentRequest extends FormRequest implements RequestPaymentRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'cc_type' => 'required|in:creditcard,stcpay',
            'name' => 'sometimes|required_if:cc_type,creditcard|string|max:255',
            'cc_number' => ['sometimes', 'required_if:cc_type,creditcard', new CardNumber()],
            'cc_expiry' => 'sometimes|required_if:cc_type,creditcard|string',
            'cc_exp_month' => ['sometimes', 'nullable', 'digits_between:1,2', new CardExpirationMonth($this->input('cc_exp_year'))],
            'cc_exp_year' => ['sometimes', 'nullable', 'digits:4', new CardExpirationYear($this->input('cc_exp_month'))],
            'cvc' => ['sometimes', 'required_if:cc_type,creditcard'],
            'phone' => 'sometimes|required_if:cc_type,stcpay|regex:/^05[0-9]{8}$/|digits:10',
            'coupon_code' => ['nullable', 'string', 'max:50'],
        ];
    }

    protected function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->input('cc_type') === 'creditcard' && $this->filled('cc_number')) {
                $cardNumberRule = new CardNumber();
                $cardNumberRule->validate('cc_number', $this->input('cc_number'), function ($message) use ($validator) {
                    $validator->errors()->add('cc_number', $message);
                });

                // الآن بعد معرفة نوع البطاقة، نفحص CVC
                if ($this->filled('cvc')) {
                    $cvcRule = new CardCvc($cardNumberRule->getBrand());
                    $cvcRule->validate('cvc', $this->input('cvc'), function ($message) use ($validator) {
                        $validator->errors()->add('cvc', $message);
                    });
                }
            }
        });
    }


    protected function prepareForValidation()
    {
        if ($this->filled('cc_expiry')) {
            $parts = explode('/', $this->input('cc_expiry'));
            if (count($parts) === 2) {
                $month = trim($parts[0]);
                $year  = trim($parts[1]);

                // خلي السنة 4 أرقام
                if (strlen($year) === 2) {
                    $year = '20' . $year;
                }
            }
        }

        $this->merge([
            'cc_exp_month' => $month ?? null,
            'cc_exp_year'  => $year ?? null,
            'coupon_code' => $this->input('coupon_code') ? strtoupper($this->input('coupon_code')) : $this->input('coupon_code'),
        ]);
    }
}
