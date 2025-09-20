<x-layouts.guest-layout title="الفعاليات">
    @push('scripts')
        @vite('resources/js/pages/events.js')
    @endpush
    {{-- <x-sections.events-section /> --}}
    <x-about.membership-form/>
</x-layouts.guest-layout>
