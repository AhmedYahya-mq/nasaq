<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class BlogRequest extends FormRequest implements \App\Contract\User\Request\BlogRequest
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
            'title'=> ($isCreate ? 'required' : 'sometimes') . '|string|max:55|unique:blogs,title',
            'content'=> ($isCreate ? 'required' : 'sometimes') . '|string',
            'excerpt' => ($isCreate ? 'required' : 'sometimes') . '|string|max:255',
            'image_id' => ($isCreate ? 'required' : 'sometimes') . '|exists:photos,id',

        ];
    }

    protected function passedValidation(): void
    {
        $data = $this->all();
        $slug = Str::slug($data['title'] ?? '');
        if (empty($slug)) {
            $slug = uniqid('blog-', true);
        }
        $data['slug'] = $slug;
        $data['admin_id'] = auth('admin')->id();

        $locale = $this->header('X-Locale', 'ar');
        foreach (['content'] as $field) {
            if (!empty($data[$field])) {
                $data[$field] = [$locale => $data[$field]];
            }
        }
        $this->replace($data);
    }

}
