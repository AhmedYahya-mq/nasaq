@props(['default'])

<div x-data="{ activeTab: '{{ $default }}' }" x-cloak class="w-full card !p-0">
    <div class="flex max-[700px]:flex-wrap max-[700px]:*:w-full border-b border-primary/50 p-3 pb-0">
        {{ $header ?? '' }}
    </div>
    <div class="mt-4 p-4 w-full min-h-[325px]">
        {{ $slot }}
    </div>
</div>
