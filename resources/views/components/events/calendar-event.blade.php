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
                            <li
                                class="group relative bg-card rounded-xl border border-border p-4 hover:shadow-lg transition-all duration-300 hover:-translate-y-1 shadow-sm">
                                <!-- المحتوى الرئيسي -->
                                <div class="flex items-start justify-between gap-3 mb-3">
                                    <!-- معلومات الحدث -->
                                    <div class="flex-1 min-w-0">
                                        <h4 class="font-bold text-card-foreground text-sm leading-tight mb-1 line-clamp-2"
                                            x-text="event.name"></h4>
                                        <div class="flex items-center gap-2 text-xs text-muted-foreground">
                                            <svg class="w-3 h-3 flex-shrink-0" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span x-text="event.start_date"></span>
                                        </div>
                                    </div>

                                    <!-- شارة نوع الحدث - الحل الآمن -->
                                    <div class="flex-shrink-0">
                                        <template
                                            x-if="event.event_type.value === '{{ App\Enums\EventType::Virtual()->value }}'">
                                            <div x-bind:style="`background-color: ${event.event_method.color}20; border-color: ${event.event_method.color}40`"
                                                class="flex items-center gap-1 text-xs font-semibold px-2 py-1 rounded-lg border">
                                                <!-- أيقونة المنصة -->
                                                <template
                                                    x-if="event.event_method.value === '{{ App\Enums\EventMethod::Zoom }}'">
                                                    <x-ui.icon name="{{ App\Enums\EventMethod::Zoom()->icon() }}"
                                                        class="size-3"
                                                        x-bind:style="`color: ${event.event_method.color}`" />
                                                </template>
                                                <template
                                                    x-if="event.event_method.value === '{{ App\Enums\EventMethod::GoogleMeet }}'">
                                                    <x-ui.icon name="{{ App\Enums\EventMethod::GoogleMeet()->icon() }}"
                                                        class="size-3"
                                                        x-bind:style="`color: ${event.event_method.color}`" />
                                                </template>
                                                <template
                                                    x-if="event.event_method.value === '{{ App\Enums\EventMethod::MicrosoftTeams }}'">
                                                    <x-ui.icon
                                                        name="{{ App\Enums\EventMethod::MicrosoftTeams()->icon() }}"
                                                        class="size-3"
                                                        x-bind:style="`color: ${event.event_method.color}`" />
                                                </template>
                                                <template
                                                    x-if="event.event_method.value === '{{ App\Enums\EventMethod::Other }}'">
                                                    <x-ui.icon name="{{ App\Enums\EventMethod::Other()->icon() }}"
                                                        class="size-3"
                                                        x-bind:style="`color: ${event.event_method.color}`" />
                                                </template>
                                                <span class="text-xs"
                                                    x-bind:style="`color: ${event.event_method.color}`"
                                                    x-text="event.event_method.name"></span>
                                            </div>
                                        </template>

                                        <template
                                            x-if="event.event_type.value === '{{ App\Enums\EventType::Physical()->value }}'">
                                            <div
                                                class="flex items-center gap-1 bg-primary/20 text-primary text-xs font-semibold px-2 py-1 rounded-lg border border-primary/30">
                                                <x-ui.icon name="{{ App\Enums\EventType::Physical()->icon() }}"
                                                    class="size-3" />
                                                <span class="text-xs">حضور</span>
                                            </div>
                                        </template>
                                    </div>
                                </div>

                                <!-- معلومات إضافية -->
                                <div class="flex items-center justify-between text-xs text-muted-foreground mb-3">
                                    <div class="flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                        <span x-text="`${event.registrations_count || 0}/${event.capacity || '∞'}`"></span>
                                    </div>

                                    <!-- السعر -->
                                    <div class="flex items-center gap-1" x-show="event.price > 0">
                                        <span x-text="event.final_price"
                                            class="font-semibold text-card-foreground"></span>
                                        <span class="text-xs">
                                            <x-ui.icon name="riyal" class="w-3 h-3 inline-block" />
                                        </span>
                                        <span x-show="event.is_discounted"
                                            class="text-muted-foreground line-through text-xs"
                                            x-text="event.price"></span>
                                    </div>
                                    <div x-show="event.price == 0" class="text-green-600 font-semibold text-xs">
                                        مجاني
                                    </div>
                                </div>

                                <!-- شريط التقدم -->
                                <div x-show="event.capacity > 0" class="mb-3">
                                    <div class="w-full bg-muted rounded-full h-1.5 overflow-hidden">
                                        <div class="h-1.5 rounded-full bg-gradient-to-r from-green-400 to-primary transition-all duration-1000"
                                            x-bind:style="`width: ${Math.min(100, ((event.registrations_count || 0) / event.capacity) * 100)}%`">
                                        </div>
                                    </div>
                                </div>

                                <!-- أزرار التسجيل -->
                                <div class="flex items-center gap-2">
                                    <!-- زر التسجيل المجاني -->
                                    <template x-if="event.price == 0 && event.can_register && !event.is_registered">
                                        <button @click="register(event)"
                                            class="flex-1 bg-primary hover:bg-primary/90 text-primary-foreground py-2 px-3 rounded-lg text-xs font-semibold transition-all duration-200 hover:shadow-md text-center flex items-center justify-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                            </svg>
                                            تسجيل مجاني
                                        </button>
                                    </template>

                                    <!-- زر الدفع -->
                                    <template x-if="event.price > 0 && event.can_register && !event.is_registered">
                                        <button @click="register(event)"
                                            class="flex-1 bg-gradient-to-r from-primary to-primary/80 hover:from-primary/90 hover:to-primary text-primary-foreground py-2 px-3 rounded-lg text-xs font-semibold transition-all duration-200 hover:shadow-md text-center flex items-center justify-center gap-1">
                                            <span x-text="event.final_price"></span>
                                            <x-ui.icon name="riyal" class="w-3 h-3" />
                                        </button>
                                    </template>

                                    <!-- مسجل مسبقاً -->
                                    <template x-if="event.is_registered">
                                        <div
                                            class="flex-1 bg-green-500 text-white py-2 px-3 rounded-lg text-xs font-semibold text-center flex items-center justify-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                            مسجل
                                        </div>
                                    </template>

                                    <!-- غير مسموح بالتسجيل -->
                                    <template x-if="!event.can_register">
                                        <div
                                            class="flex-1 bg-muted text-muted-foreground py-2 px-3 rounded-lg text-xs font-semibold text-center flex items-center justify-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                            </svg>
                                            عضوية مطلوبة
                                        </div>
                                    </template>
                                </div>
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
    <div x-show="isLoading" x-clock
        class="fixed inset-0 bg-black/20 backdrop-blur-sm flex items-center justify-center z-50 p-3">
        <div class="bg-transparent rounded-2xl flex-col shadow-lg w-24 h-24 flex items-center justify-center">
            <div class="animate-spin rounded-full h-12 w-12 border-b-transparent border-4 border-primary mb-2">

            </div>
        </div>
    </div>
</div>
