@props(['default'])

<div x-data="{ activeTab: '{{ $default }}' }" x-cloak class="w-full card !p-0">
    <div class="flex max-[580px]:flex-wrap max-[580px]:*:w-full border-b border-primary/50 p-3 pb-0">
        {{ $header ?? '' }}
    </div>
    <div class="mt-4 p-4">
        {{ $slot }}
    </div>
</div>
