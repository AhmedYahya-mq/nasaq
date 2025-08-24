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
        @if ($icon && $iconPosition === 'leading')
            <span
                class="absolute inset-y-0 ltr:left-0 rtl:right-0 flex items-center ltr:pl-3 rtl:pr-3 !fill-muted-foreground !text-muted-foreground ">
                <x-ui.icon :name="$icon" class="size-4" />
            </span>
        @endif
        <input
            {{ $attributes }} type="{{ $type }}" name="{{ $name }}" id="{{ $id }}" value="{{ $value }}"
            placeholder="{{ $placeholder }}" aria-label="{{ $placeholder ?: $label }}"

            class="w-full rtl:rtl bg-background text-[0.8125rem] font-normal appearance-none px-[0.9rem] py-2 border border-border rounded-sm outline-none focus:border-primary transition-colors ease-in-out duration-150
            @if ($icon && $iconPosition === 'leading') ltr:pl-10 rtl:pr-10 @endif
            @if ($icon && $iconPosition === 'trailing') ltr:pr-10 rtl:pl-10 @endif
            {{ $class }}" />

        @if ($icon && $iconPosition === 'trailing')
            <span
                class="absolute inset-y-0 ltr:right-0 rtl:left-0 flex items-center ltr:pr-3 rtl:pl-3 !fill-muted-foreground !text-muted-foreground">
                <x-ui.icon :name="$icon" class="size-4" />
            </span>
        @endif
    </div>
</div>
