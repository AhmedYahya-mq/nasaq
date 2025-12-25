<?php

namespace App\Http\Requests\User\Profile;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Storage;

class PhotoRequest extends FormRequest implements \App\Contract\User\Profile\PhotoRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // السماح بأكثر الأنواع شيوعاً للصور مع حد الحجم 2MB
            // ملاحظة: بعض الأنواع مثل TIFF/AVIF قد لا تُعرض في جميع المتصفحات.
            'photo' => ['required', 'image', 'max:2048', 'mimes:jpeg,jpg,png,webp,gif,bmp,svg,avif,tiff'],
        ];
    }

    /**
     * رسائل تحقق مخصصة لزيادة وضوح سبب الرفض للمستخدم.
     */
    public function messages(): array
    {
        return [
            'photo.mimes' => 'الصورة الشخصية يجب أن تكون من الأنواع: JPEG, JPG, PNG, WEBP, GIF, BMP, SVG, AVIF, TIFF.',
            'photo.max' => 'حجم الصورة يجب ألا يتجاوز 2MB.',
            'photo.required' => 'يرجى اختيار صورة شخصية.',
            'photo.image' => 'الملف المحدد يجب أن يكون صورة صحيحة.',
        ];
    }

    protected function passedValidation(): void
    {
        $user = $this->user();
        if ($this->hasFile('photo')) {
            $file = $this->file('photo');
            $path = 'photos/profile-photos/' . $user->id;
            $filename = time() . '_profile.' . $file->getClientOriginalExtension();
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }
            $file->storeAs($path, $filename, 'public');
            $user->forceFill([
                'photo' => $path . '/' . $filename,
            ])->save();
        }
    }
}
