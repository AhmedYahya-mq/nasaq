<x-layouts.guest-layout title="الرئيسية">
    @push('scripts')
        @vite('resources/js/pages/events.js')
    @endpush
    <x-sections.hero2 />
    {{-- <x-sections.hero-section /> --}}
    <x-sections.goals-section />
    <x-sections.num-section />
    <section class="bg-background pt-20">
        <div class="mx-auto px-4 lg:px-6">

            <div class="text-center max-w-3xl mx-auto mb-10">
                <h1 class="text-xl font-extrabold text-foreground mb-4 leading-tight drop-shadow-lg">
                    {{ __('events.page_titles.main') }}
                </h1>
            </div>

            <div
                class="mb-16 relative bg-gradient-to-r from-primary/20 via-background to-background rounded-xl shadow-2xl overflow-hidden border border-primary/30">
                <x-events.event-futured class="rounded-xl" />
            </div>

            <div class="">
                {{-- العمود الأول: الفعاليات القادمة --}}
               <x-events.list-events :isPaginated="false"/>

            </div>
        </div>
    </section>
    <x-sections.feature-section />
    <x-sections.blogs-section />
</x-layouts.guest-layout>
