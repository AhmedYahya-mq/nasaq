@props([
    'type' => 'password',
    'name' => '',
    'id' => '',
    'value' => '',
    'placeholder' => '',
    'label' => '',
    'class' => '',
])

<div class="w-full"
:id="{{ $id }}"
x-data="{
    showPassword: false
}">
    @if (!empty($label))
        <label for="{{ $id }}" class="mb-2 font-medium inline-block">
            {{ $label }}
        </label>
    @endif

    <div class="relative flex items-center">
        <input {{ $attributes }} :type="showPassword ? 'text' : '{{ $type }}'" name="{{ $name }}"
            id="{{ $id }}" value="{{ $value ?? "" }}" placeholder="{{ $placeholder }}"
            aria-label="{{ $placeholder ?: $label }}"
            class="w-full rtl:rtl bg-background text-[0.8125rem] font-normal appearance-none px-[0.9rem] py-2 border border-border rounded-sm outline-none focus:border-primary transition-colors ease-in-out duration-150
            ltr:pr-10 rtl:pl-10
            {{ $class }}" />

        <span x-show="showPassword"
            class="absolute inset-y-0 ltr:right-0 rtl:left-0 flex items-center ltr:pr-3 rtl:pl-3 cursor-pointer text-muted-foreground"
            @click="showPassword = !showPassword">
            <x-ui.icon name="eye" class="size-4" />
        </span>

        <span x-show="!showPassword"
            class="absolute inset-y-0 ltr:right-0 rtl:left-0 flex items-center ltr:pr-3 rtl:pl-3 cursor-pointer text-muted-foreground"
            @click="showPassword = !showPassword">
            <x-ui.icon name="eye-slash" class="size-4" />
        </span>
    </div>
</div>
