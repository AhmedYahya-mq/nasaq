<div x-data="phoneInput()" class="w-full">
    <x-forms.input
        id="phone"
        type="tel"
        {{ $attributes }}
        label="{{ $label ?? 'رقم الهاتف' }}"
        x-ref="input"
        placeholder="05X XXX XXXX"
        class="w-full border rounded p-2"
    />
    <p class="mt-1 text-sm text-red-500" x-show="!isValid" x-text="error"></p>
</div>
