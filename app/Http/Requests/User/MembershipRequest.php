<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class MembershipRequest extends FormRequest implements \App\Contract\User\Request\MembershipRequest
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
        $isCreate = $this->isMethod('post');

        return [
            // Translatable: expect arrays keyed by locale
            'name' => ($isCreate ? 'required' : 'sometimes') . '|string|max:55',
            'description' => 'nullable|string|max:255',
            // Scalars
            'is_active' => 'sometimes|in:true,false,1,0',
            'price' => ($isCreate ? 'required' : 'sometimes') . '|numeric|min:0',
            'discounted_price' => 'nullable|numeric|min:0|lte:price',
            'duration_days' => 'nullable|integer|min:1',
            'requirements' => ($isCreate ? 'required' : 'sometimes') . '|array',
            'requirements.*' => 'required|string|max:255',

            'features' => ($isCreate ? 'required' : 'sometimes') . '|array',
            'features.*' => 'required|string|max:255',
            'sort_order' => 'sometimes|integer|min:0',
        ];
    }

    protected function passedValidation(): void
    {
        $data = $this->all();
        $defultValues = [
            'is_active' => true,
            'sort_order' => 0,
            'duration_days' => 365,
            'discounted_price' => null,
        ];
        foreach ($defultValues as $field => $value) {
            if (!isset($data[$field])) {
                $data[$field] = $value;
            }
        }
        $locale = $this->header('X-Locale', 'ar');
        foreach (['name', 'description'] as $field) {
            if (!empty($data[$field])) {
                $data[$field] = [$locale => $data[$field]];
            }
        }
        foreach (['requirements', 'features'] as $field) {
            if (!empty($data[$field]) && is_array($data[$field])) {
                $data[$field] = [$locale => array_values($data[$field])];
            }
        }
        $this->replace($data);
    }
}
