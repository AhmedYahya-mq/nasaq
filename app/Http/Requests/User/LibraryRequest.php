<?php

namespace App\Http\Requests\User;

use App\Enums\LibraryStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class LibraryRequest extends FormRequest implements \App\Contract\User\Request\LibraryRequest
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
        $library = $this->isMethod('put') || $this->isMethod('patch');
        $req = $library ? 'sometimes' : 'required';
        return [
            'title' => [$req, 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'path' => [$req, 'string', 'max:255'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'path' => [$req, 'string', new \App\Rules\LibraryRole()],
            'discount' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'status' => [$req, 'in:' . implode(',', LibraryStatus::getValues())],
            'type' => [$req, 'in:' . implode(',', \App\Enums\LibraryType::getValues())],
            'author' => ['nullable', 'string', 'max:255'],
            'poster' => ['nullable', 'string', 'exists:photos,id'],
            'published_at' => ['nullable', 'date'],
        ];
    }

    protected function passedValidation(): void
    {
        $data = $this->all();
        $translations = [];
        foreach (['title', 'description', 'author'] as $field) {
            if (!is_null($this->input($field)) && $this->has($field)) {
                $translations[$field] =  $this->input("{$field}");
            }
        }
        $data = array_merge($data, ['translations' => $translations]);
        // price if null set to 0
        if (empty($data['price'])) {
            $data['price'] = 0;
        }
        // discount convert to decimal
        if (!empty($data['discount'])) {
            $data['discount'] = $data['discount'] / 100;
        } else {
            $data['discount'] = 0;
        }

        $this->replace($data);
    }
}
