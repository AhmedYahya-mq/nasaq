{{-- resources/views/components/forms/select.blade.php --}}
@props([
    'name',
    'label',
    'required' => false,
])

@php
    $baseClasses = 'block w-full px-4 py-3 pr-10 rounded-lg border shadow-sm bg-background text-foreground
                   focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition appearance-none';
    $errorClasses = $errors->has($name)
        ? 'border-destructive focus:ring-destructive focus:border-destructive'
        : 'border-border';
@endphp

<div class="w-full">
    {{-- العنوان --}}
    <label for="{{ $name }}" class="block text-sm font-medium text-muted-foreground mb-2">
        {{ $label }}
        @if($required)
            <span class="text-destructive">*</span>
        @endif
    </label>

    {{-- القائمة --}}
    <div class="relative">
        <select
            name="{{ $name }}"
            id="{{ $name }}"
            {{ $required ? 'required' : '' }}
            {{ $attributes->class([$baseClasses, $errorClasses]) }}
        >
            {{ $slot }}
        </select>

        {{-- سهم صغير لليمين --}}
        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
            <svg class="w-5 h-5 text-muted-foreground" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9"/>
            </svg>
        </div>
    </div>

    {{-- رسالة الخطأ --}}
    @error($name)
        <p class="mt-2 text-sm text-destructive font-medium">{{ $message }}</p>
    @enderror
</div>
