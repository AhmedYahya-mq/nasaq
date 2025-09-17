<x-layouts.guest-layout title="الرئيسية">
    <x-sections.hero />
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
                <x-events.highlighted-event-banner title="{{ __('events.event_titles.september_meeting') }}"
                    date="2025-09-25 18:30:00" location="{{ __('events.event_titles.zoom_location') }}"
                    url="https://zoom.us/register/xyz" class="rounded-xl" />
            </div>

            <div class="">
                {{-- العمود الأول: الفعاليات القادمة --}}
                <div class="">
                    <h2 class="text-2xl  w-full font-bold mb-8 text-foreground drop-shadow">
                        {{ __('events.page_titles.upcoming_events') }}
                    </h2>
                    {{-- البطاقة العمودية: كل بطاقة فوق الأخرى --}}
                    <div class="grid md:grid-cols-1 lg:grid-cols-3 gap-4 mb-24 items-start auto-rows-fr">
                        <x-events.event-card title="{{ __('events.event_titles.october_meeting') }}" type="zoom"
                            date="2025-10-15" time="08:00 {{ __('events.time.evening') }}"
                            url="https://zoom.us/register/next-month" />

                        <x-events.event-card title="{{ __('events.event_titles.riyadh_meeting') }}" type="in_person"
                            date="2025-11-05" time="06:30 {{ __('events.time.evening') }}"
                            url="https://forms.gle/riyadh-meeting" />

                        <x-events.event-card title="{{ __('events.event_titles.research_workshop') }}" type="workshop"
                            date="2025-12-01" time="04:00 {{ __('events.time.evening') }}"
                            url="https://forms.gle/research-workshop" />
                    </div>
                </div>

            </div>
        </div>
    </section>
    <x-sections.feature-section />
    <x-sections.blogs-section />
</x-layouts.guest-layout>
