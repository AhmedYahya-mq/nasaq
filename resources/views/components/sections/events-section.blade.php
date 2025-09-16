<section class="bg-background py-16">
    <div class="container mx-auto px-4">

        <div class="text-center max-w-3xl mx-auto mb-16">
            <h1 class="text-3xl md:text-5xl font-extrabold text-foreground mb-4 leading-tight drop-shadow-lg">
                {{ __('events.page_titles.main') }}
            </h1>
            <p class="text-lg text-muted-foreground font-medium">
                {{ __('events.page_titles.subtitle') }}
            </p>
        </div>

        <div
            class="mb-16 relative bg-gradient-to-r from-primary/20 via-background to-background rounded-xl shadow-2xl overflow-hidden border border-primary/30">
            <x-events.highlighted-event-banner title="{{ __('events.event_titles.september_meeting') }}"
                date="2025-09-25 18:30:00" location="{{ __('events.event_titles.zoom_location') }}"
                url="https://zoom.us/register/xyz" class="rounded-xl" />
        </div>

        <div class="grid lg:grid-cols-2 gap-16 mb-24 items-start">

            {{-- العمود الأول: الفعاليات القادمة --}}
            <div>
                <h2 class="text-2xl font-bold mb-8 text-foreground drop-shadow">
                    {{ __('events.page_titles.upcoming_events') }}
                </h2>

                {{-- البطاقة العمودية: كل بطاقة فوق الأخرى --}}
                <div class="flex flex-col gap-8">
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

                <div class="mt-8 text-left">
                    <a href="#"
                        class="inline-flex items-center gap-2 text-lg font-semibold text-primary bg-primary/10 px-6 py-3 rounded-xl shadow hover:bg-primary/20 hover:text-primary-dark transition-colors focus:outline-none focus:ring-2 focus:ring-primary">
                        {{ __('events.page_titles.view_all_upcoming') }}
                        <x-ui.icon name="arrow-left" class="w-4 h-4 rtl:transform rtl:rotate-180" />
                    </a>
                </div>
            </div>

            {{-- العمود الثاني: التقويم --}}
            <div class="bg-card p-8 rounded-2xl shadow-xl border border-border">
                <h2 class="text-2xl font-bold mb-6 text-foreground text-center lg:text-left drop-shadow">
                    {{ __('events.page_titles.interactive_calendar') }}
                </h2>
                <div class="max-w-full">
                    <x-events.calendar />
                </div>
            </div>

        </div>

        <div class="mb-24">
            <h2 class="text-2xl font-bold mb-8 text-foreground text-center drop-shadow">
                {{ __('events.page_titles.past_events_archive') }}
            </h2>
            <div class="grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                <x-events.archive-card title="{{ __('events.event_titles.first_graduates_meeting') }}"
                imageUrl="https://images.unsplash.com/photo-1555066931-4365d14bab8c"
                    date="2025-06-05" time="06:00 {{ __('events.time.evening') }}"
                    filesUrl="https://www.example.com/file.pdf" registrationUrl="https://example.com/video" />
                <x-events.archive-card title="{{ __('events.event_titles.first_graduates_meeting') }}"
                    date="2025-06-05" time="06:00 {{ __('events.time.evening') }}"
                    imageUrl="https://images.unsplash.com/photo-1555066931-4365d14bab8c"
                    filesUrl="https://www.example.com/file.pdf" registrationUrl="https://example.com/video" />
            </div>

               {{-- 3. زر "مشاهدة الكل" في الأسفل --}}
        <div class="text-center mt-12">
            <a href="" {{-- استبدل 'archive.index' باسم الـ route الصحيح --}}
               class="inline-flex items-center gap-2 px-6 py-3 text-base font-semibold text-primary-foreground bg-primary rounded-lg hover:bg-primary/90 transition-colors duration-200 shadow-md">
                <span>{{ __('events.event_titles.view_all_archives') }}</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                </svg>
            </a>
        </div>
        </div>

        {{-- اقتراح: نقل الأنيميشن إلى ملف CSS أو Tailwind config --}}
        {{-- <link rel="stylesheet" href="{{ asset('css/events-animations.css') }}"> --}}

    </div>
</section>
