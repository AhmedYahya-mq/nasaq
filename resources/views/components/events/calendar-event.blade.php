@props(['events' => [['title' => __('events.calendar.default_titles.monthly_zoom'), 'type' => 'Zoom', 'time' => '08:00 ' . __('events.time.evening'), 'iso_date' => date('Y-m-d', strtotime('+5 days'))], ['title' => __('events.calendar.default_titles.in_person_meeting'), 'type' => 'in_person', 'time' => '06:30 ' . __('events.time.evening'), 'iso_date' => date('Y-m-d', strtotime('+15 days'))], ['title' => __('events.calendar.default_titles.research_workshop'), 'type' => 'workshop', 'time' => '10:00 ' . __('events.time.morning'), 'iso_date' => date('Y-m-d', strtotime('+25 days'))]]])
@php
    $translations = [
        'dayNames' => [
            __('events.calendar.day_names.0'),
            __('events.calendar.day_names.1'),
            __('events.calendar.day_names.2'),
            __('events.calendar.day_names.3'),
            __('events.calendar.day_names.4'),
            __('events.calendar.day_names.5'),
            __('events.calendar.day_names.6'),
        ],
        'monthNames' => [
            __('events.calendar.month_names.0'),
            __('events.calendar.month_names.1'),
            __('events.calendar.month_names.2'),
            __('events.calendar.month_names.3'),
            __('events.calendar.month_names.4'),
            __('events.calendar.month_names.5'),
            __('events.calendar.month_names.6'),
            __('events.calendar.month_names.7'),
            __('events.calendar.month_names.8'),
            __('events.calendar.month_names.9'),
            __('events.calendar.month_names.10'),
            __('events.calendar.month_names.11'),
        ],
        'no_events' => __('events.calendar.no_events'),
        'events_for' => __('events.calendar.events_for'),
    ];
@endphp

<div x-data="eventsCalendar(
    @js($calendar),
    @js($translations),
    '{{ $calendar['now'] ?? now()->toDateString() }}',
    '{{ $calendar['max'] ?? now()->addYears()->toDateString() }}'
)" class="overflow-hidden">

    <!-- Header -->
    <div class="flex flex-col gap-2 mb-4">
        <div class="flex rtl:flex-row-reverse items-center justify-between">
            <button @click="prev()" :disabled="isPrevDisabled"
                class='badget-70 hover:badget-90 transition p-2 rounded-full disabled:cursor-not-allowed disabled:!badget-50'
                class="p-2 rounded-full">
                <x-ui.icon name="arrow-left" class="w-5 h-5" />
            </button>
            <h3 class="text-base font-bold text-center text-foreground" x-text="weekTitle"></h3>
            <button @click="next()" :disabled="isNextDisabled"
                class='badget-70 hover:badget-90 transition p-2 rounded-full disabled:cursor-not-allowed disabled:!badget-50'
                class="p-2 rounded-full">
                <x-ui.icon name="arrow-right" class="w-5 h-5" />
            </button>
        </div>
        <div class="flex justify-between text-xs text-muted-foreground">
            <span x-text="`من ${currentStartDate}`"></span>
            <span x-text="`إلى ${currentEndDate}`"></span>
        </div>
    </div>

    <!-- Week Row (Responsive: flex-wrap on small, grid on large) -->
    <div
        class="
        flex flex-wrap gap-2 justify-between mb-2
        sm:flex-nowrap
        sm:mb-2
        px-0.5
    ">
        <template x-for="day in weekDays" :key="day.iso">
            <div @click="openDay(day)"
                :class="{
                    // اليوم الحالي
                    'border-primary-focus ring-2 ring-primary bg-primary/10': day.iso === (new Date().toISOString()
                        .split('T')[0]),
                    // اليوم المحدد
                    'bg-primary text-primary-foreground border-primary-focus scale-105 shadow-lg': isSelected(day),
                    // وجود أحداث
                    'border-primary bg-primary/10 font-bold': day.eventsCount > 0 && !isSelected(day) && day.iso !== (
                        new Date().toISOString().split('T')[0]),
                }"
                class="
                    relative
                    flex-1
                    flex flex-col items-center justify-center
                    rounded-xl border border-border cursor-pointer
                    transition-all duration-150 ease-in-out
                    bg-accent/10
                    hover:bg-primary/20 hover:border-primary/60 focus:bg-primary/30 focus:border-primary
                    outline-none
                    h-14 min-w-14
                    text-sm py-2
                    md:text-base
                    flex-shrink-0
                    focus:ring-2 focus:ring-primary
                    dark:bg-accent/20
                "
                tabindex="0">
                <!-- رقم الأحداث في الزاوية -->
                <span
                    class="absolute rtl:left-1 ltr:right-1 bottom-1 text-[10px] font-bold text-primary bg-white/80 dark:bg-background/80 rounded px-1 py-0.5 shadow"
                    x-text="day.eventsCount"></span>
                <span class="font-semibold mb-1" x-text="day.dayName"></span>
                <span class="font-bold" x-text="day.date.getDate()"></span>
                <!-- Dots for events -->
                <div class="flex gap-1 mt-1">
                    <template x-for="i in day.eventsCount" :key="i">
                        <span
                            :class="{
                                'w-[3px] h-[3px] sm:w-[5px] sm:h-[5px] md:w-[6px] md:h-[6px]': true,
                                'bg-primary dark:bg-primary-light': true,
                                'rounded-full': true,
                                'shadow': true
                            }"></span>
                    </template>
                </div>
            </div>
        </template>
    </div>

    <!-- Modal -->
    <div x-show="showModal" @keydown.escape.window="showModal = false" x-transition
        class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50 p-3">
        <div @click.away="showModal = false" x-show="showModal" x-transition
            class="bg-card max-h-[95dvh] rounded-2xl flex flex-col shadow-lg w-full max-w-md">
            <div class="p-4 border-b border-border">
                <h3 class="text-base font-semibold" x-text="modalTitle"></h3>
            </div>
            <div class="p-4 flex-1 scrollbar">
                <template x-if="selectedEvents.length > 0">
                    <ul class="space-y-2">
                        <template x-for="event in selectedEvents" :key="event.ulid">
                            <li class="flex items-center justify-between gap-3 card !bg-primary/15">
                                <div class="flex-1">
                                    <h4 class="font-semibold" x-text="event.name"></h4>
                                    <p class="text-sm text-muted-foreground" x-text="event.time"></p>
                                </div>
                                <template
                                    x-if="event.event_type.value === '{{ App\Enums\EventType::Virtual()->value }}'">
                                    <div :style="{ '--badget-color': event.event_method.color }"
                                        class="flex-shrink-0 flex items-center gap-1 badget text-xs font-semibold px-2 py-1 rounded-md border">
                                        <template
                                            x-if="event.event_method.value === '{{ App\Enums\EventMethod::Zoom }}'">
                                            <x-ui.icon name="{{ App\Enums\EventMethod::Zoom()->icon() }}"
                                                class="size-4 text-primary" />
                                        </template>
                                        <template
                                            x-if="event.event_method.value === '{{ App\Enums\EventMethod::GoogleMeet }}'">
                                            <x-ui.icon name="{{ App\Enums\EventMethod::GoogleMeet()->icon() }}"
                                                class="size-4 text-primary" />
                                        </template>
                                        <template
                                            x-if="event.event_method.vlaue === '{{ App\Enums\EventMethod::MicrosoftTeams }}'">
                                            <x-ui.icon name="{{ App\Enums\EventMethod::MicrosoftTeams()->icon() }}"
                                                class="size-4 text-primary" />
                                        </template>
                                        <template
                                            x-if="event.event_method.vlaue === '{{ App\Enums\EventMethod::Other }}'">
                                            <x-ui.icon name="{{ App\Enums\EventMethod::Other()->icon() }}"
                                                class="size-4 text-primary" />
                                        </template>
                                        <span x-text="event.event_method.name"></span>
                                    </div>
                                </template>
                                <template
                                    x-if="event.event_type.value === '{{ App\Enums\EventType::Physical()->value }}'">
                                    <div
                                        class="flex-shrink-0 flex items-center gap-1 badget-70 text-xs font-semibold px-2 py-1 rounded-md border">
                                        <x-ui.icon name="{{ App\Enums\EventType::Physical()->icon() }}"
                                            class="size-4 text-primary" />
                                        <span>
                                            حضور
                                        </span>
                                    </div>
                                </template>
                            </li>
                        </template>
                    </ul>
                </template>
                <template x-if="selectedEvents.length === 0">
                    <p class="text-muted-foreground text-center py-4" x-text="trans.no_events"></p>
                </template>
            </div>
            <div class="p-3 bg-accent/10 rounded-b-lg text-center cursor-pointer">
                <button class="text-xs font-semibold text-primary hover:underline"
                    @click="showModal = false">{{ __('events.calendar.close') }}</button>
            </div>
        </div>
    </div>

    {{-- loading --}}
    <div x-show="isLoading" x-clock class="fixed inset-0 bg-black/20 backdrop-blur-sm flex items-center justify-center z-50 p-3">
        <div class="bg-transparent rounded-2xl flex-col shadow-lg w-24 h-24 flex items-center justify-center">
            <div class="animate-spin rounded-full h-12 w-12 border-b-transparent border-4 border-primary mb-2">

            </div>
        </div>
    </div>
</div>
