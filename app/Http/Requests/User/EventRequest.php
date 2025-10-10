<?php

namespace App\Http\Requests\User;

use App\Enums\EventCategory;
use App\Enums\EventMethod;
use App\Enums\EventStatus;
use App\Enums\EventType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EventRequest extends FormRequest implements \App\Contract\User\Request\EventRequest
{
    public function authorize(): bool
    {
        return auth('admin')->check();
    }

    public function rules(): array
    {
        $isCreate = $this->isMethod('post');
        $type = $this->input('event_type') ?? $this->route('event')?->event_type;
        $isTranslate = $this->route()->getActionMethod() === 'updateTranslation';
        // القواعد للترجمة فقط
        if ($isTranslate) {
            return [
                'title' => ['required', 'string', 'max:100'],
                'description' => ['required', 'string'],
                'address' => $type === EventType::Physical
                    ? ['required', 'string', 'max:255']
                    : ['nullable', 'string', 'max:255']
            ];
        }
        // القواعد العادية
        return [
            'event_type' => [
                'required',
                Rule::in(EventType::getValues()),
            ],
            'title' => [$isCreate ? 'required' : 'sometimes', 'string', 'max:100'],
            'description' => [$isCreate ? 'required' : 'sometimes', 'string'],
            'address' => $type === EventType::Physical
                ? [$isCreate ? 'required' : 'nullable', 'string', 'max:255']
                : ['nullable', 'string', 'max:255'],
            'event_method' => $type === EventType::Virtual
                ? [$isCreate ? 'required' : 'sometimes', Rule::in(EventMethod::getValues())]
                : ['nullable'],
            'price' => [$isCreate ? 'nullable' : 'sometimes', 'numeric', 'min:0'],
            'discount' => [$isCreate ? 'nullable' : 'sometimes', 'numeric', 'min:0', 'max:100'],
            'accepted_membership_ids' => ['nullable', 'array'],
            'accepted_membership_ids.*' => ['exists:memberships,id'],
            'event_category' => [$isCreate ? 'required' : 'sometimes', Rule::in(EventCategory::getValues())],
            'start_at' => [$isCreate ? 'required' : 'sometimes', 'date', 'after_or_equal:now'],
            'link' => ['nullable', 'url'],
            'capacity' => [$isCreate ? 'nullable' : 'sometimes', 'integer', 'min:0'],
        ];
    }



    protected function passedValidation()
    {
        $defultValues = [
            'event_method' => EventMethod::Zoom,
            'event_status' => EventStatus::Upcoming,
            'address' => null,
            'link' => null,
            'capacity' => null,
            'price' => 0,
            'discount' => 0,
        ];
        $data = $this->all();
        foreach ($defultValues as $key => $value) {
            if (empty($this->input($key))) {
                $data[$key] = $value;
            }
        }

        // اضافة translations
        $translations = [];
        foreach (['title', 'description', 'address'] as $field) {
            if (!is_null($this->input($field)) && $this->has($field)) {
                $translations[$field] =  $this->input("{$field}");
            }
        }
        $this->merge(array_merge($data, ['translations' => $translations]));
    }

    protected function prepareForValidation()
    {
        $memberships = $this->input('accepted_membership_ids');

        if (is_array($memberships) && count($memberships) === 1 && $memberships[0] == 0) {
            $this->merge([
                'accepted_membership_ids' => null,
            ]);
        }
    }
}
