@props([
    'value' => '',
    'name' => 'phone',
])
<div x-data="phoneInput('{{ $value }}')" class="w-full">
    <!-- input ظاهر للمستخدم -->
    <x-forms.input
        id="phone"
        type="tel"
        name="{{ $name }}_display"
        value="{{ $value }}"
        {{ $attributes }}
        label="رقم الجوال"
        x-ref="input"
        class="w-full border rounded p-2"
    />

    <!-- input مخفي يرسل الرقم الدولي -->
    <input type="hidden" name="{{ $name }}" x-model="number">

    <!-- رسالة الخطأ -->
    <p class="mt-1 text-sm text-red-500" x-show="!isValid" x-text="error"></p>
</div>
