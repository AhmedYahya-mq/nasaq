<?php

namespace App\Http\Requests\User;

use App\Enums\EventCategory;
use App\Enums\EventMethod;
use App\Enums\EventStatus;
use App\Enums\EventType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

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
        $isUpdateLink = $this->input('update_link', false);
        if ($isUpdateLink) {
            return [
                'link' => ['required', 'url'],
                'address' => $type === EventType::Physical
                    ? ['required', 'string', 'max:255']
                    : ['nullable', 'string', 'max:255']
            ];
        }
        if ($isTranslate) {
            return [
                'title' => ['required', 'string', 'max:100'],
                'description' => ['required', 'string'],
                'address' => $type === EventType::Physical
                    ? ['required', 'string', 'max:255']
                    : ['nullable', 'string', 'max:255']
            ];
        }

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
            'end_at' => [$isCreate ? 'nullable' : 'sometimes', 'date', 'after:start_at'],
            'link' => ['nullable', 'url'],
            'capacity' => [$isCreate ? 'nullable' : 'sometimes', 'integer', 'min:0'],
        ];
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

    protected function passedValidation()
    {
        $defaultValues = [
            'event_method' => EventMethod::Zoom,
            'event_status' => EventStatus::Upcoming,
            'address' => null,
            'link' => null,
            'capacity' => null,
            'price' => 0,
            'discount' => 0,
        ];

        $data = $this->all();

        foreach ($defaultValues as $key => $value) {
            if (empty($this->input($key))) {
                $data[$key] = $value;
            }
        }

        // ضبط الحالة تلقائيًا بناءً على start_at و end_at
        if (isset($data['start_at']) && !$this->input('update_link', false)) {
            $startAt = Carbon::parse($data['start_at']);
            $now = Carbon::now();

            if ($startAt->isAfter($now)) {
                $data['event_status'] = EventStatus::Upcoming;
            } else {
                $data['event_status'] = EventStatus::Ongoing;
            }
        }

        // إضافة الترجمات
        $translations = [];
        foreach (['title', 'description', 'address'] as $field) {
            if (!is_null($this->input($field)) && $this->has($field)) {
                $translations[$field] = $this->input($field);
            }
        }

        $this->merge($data + ['translations' => $translations]);
    }
}
