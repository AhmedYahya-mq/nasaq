@props([
    'type' => 'text',
    'name' => '',
    'id' => '',
    'value' => '',
    'placeholder' => '',
    'label' => '',
    'class' => '',
    'icon' => null,
    'iconPosition' => 'leading',
])

<div class="w-full">
    @if (!empty($label))
        <label for="{{ $id }}" class="mb-2 font-medium inline-block">
            {{ $label }}
        </label>
    @endif

    <div class="relative flex items-center">
        <textarea {{ $attributes }} name="{{ $name }}" id="{{ $id }}"
            placeholder="{{ $placeholder }}" aria-label="{{ $placeholder ?: $label }}"
            class="w-full min-h-14 scrollbar rtl:rtl bg-background text-[0.8125rem] font-normal appearance-none px-[0.9rem] py-2 border border-border rounded-sm outline-none focus:border-primary transition-colors ease-in-out duration-150
            {{ $class }}"  >{{ $value ?? "" }}</textarea>
    </div>
</div>
