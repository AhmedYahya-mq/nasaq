@props([
    'events' => [
        ['title' => __('events.calendar.default_titles.monthly_zoom'), 'type' => 'Zoom', 'time' => '08:00 ' . __('events.time.evening'), 'iso_date' => date('Y-m-d', strtotime('+5 days'))],
        ['title' => __('events.calendar.default_titles.in_person_meeting'), 'type' => 'حضوري', 'time' => '06:30 ' . __('events.time.evening'), 'iso_date' => date('Y-m-d', strtotime('+15 days'))],
        ['title' => __('events.calendar.default_titles.research_workshop'), 'type' => 'ورشة', 'time' => '10:00 ' . __('events.time.morning'), 'iso_date' => date('Y-m-d', strtotime('+25 days'))],
    ],
])

{{-- تعديل: إضافة overflow-hidden لمنع أي تجاوزات غير متوقعة --}}
<div x-data="eventsCalendar({{ json_encode($events) }})" x-init="init()" class="bg-card p-4 sm:p-6 rounded-2xl border border-border shadow-lg overflow-hidden">
    <div class="flex items-center justify-between mb-4">
        {{-- تعديل: تحسين أزرار التنقل --}}
        <button @click="prev()" class="p-2 rounded-full text-muted-foreground hover:bg-accent hover:text-accent-foreground transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
        </button>
        <h3 class="text-lg sm:text-xl font-bold text-center" x-text="monthNames[month] + ' ' + year"></h3>
        <button @click="next()" class="p-2 rounded-full text-muted-foreground hover:bg-accent hover:text-accent-foreground transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
        </button>
    </div>

    {{-- تعديل: استخدام أسماء أيام مختصرة على الجوال --}}
    <div class="grid grid-cols-7 gap-1 sm:gap-2 text-center text-xs sm:text-sm text-muted-foreground mb-2">
        <template x-for="day in dayNames" :key="day">
            <div x-text="window.innerWidth < 640 ? day.substring(0, 2) : day"></div>
        </template>
    </div>

    <div class="grid grid-cols-7 gap-1 sm:gap-2">
        {{-- تعديل: ارتفاع متجاوب للخلايا الفارغة --}}
        <template x-for="blank in blankdays"><div class="h-16 sm:h-20"></div></template>

        <template x-for="date in daysInMonth" :key="date">
            {{-- تعديل: ارتفاع متجاوب وتأثيرات بصرية محسنة --}}
            <div
                class="relative h-16 sm:h-20 border border-border rounded-lg p-1 cursor-pointer transition-all duration-200 ease-in-out"
                :class="{
                    'bg-primary/10 border-primary/50 font-bold': eventsForDate(date).length > 0,
                    'hover:bg-accent/50 hover:border-accent-foreground/20 hover:scale-105': true,
                    'bg-primary text-primary-foreground border-primary-focus scale-105 shadow-lg': isSelected(date)
                }"
                @click="openDay(date)"
            >
                <div class="text-xs sm:text-sm flex justify-center sm:justify-start">
                    <span x-text="date"></span>
                </div>

                {{-- تعديل: إخفاء شارة عدد الفعاليات على الشاشات الصغيرة جدًا لتوفير مساحة --}}
                <template x-if="eventsForDate(date).length > 0">
                    <div class="absolute top-1 right-1 hidden sm:flex items-center justify-center text-[10px] bg-primary text-primary-foreground rounded-full h-5 w-5">
                        <span x-text="eventsForDate(date).length"></span>
                    </div>
                </template>

                {{-- تعديل: تحسين مظهر نقاط الفعاليات --}}
                <div class="absolute bottom-1.5 left-0 right-0 flex justify-center items-end gap-1">
                    <template x-for="event in eventsForDate(date).slice(0, 3)"> {{-- عرض 3 نقاط كحد أقصى --}}
                        <span
                            class="h-1.5 w-1.5 sm:h-2 sm:w-2 rounded-full"
                            :class="{
                                'bg-blue-500': event.type === 'Zoom',
                                'bg-green-500': event.type === 'حضوري',
                                'bg-yellow-500': event.type === 'ورشة'
                            }"
                        ></span>
                    </template>
                </div>
            </div>
        </template>
    </div>

    {{-- تعديل: نافذة منبثقة متجاوبة وجميلة --}}
    <div x-show="showModal" @keydown.escape.window="showModal = false" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50 p-4">
        <div @click.away="showModal = false" x-show="showModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="bg-card rounded-2xl shadow-lg w-full max-w-md">
            <div class="p-6 border-b border-border">
                <h3 class="text-lg font-bold" x-text="modalTitle"></h3>
            </div>
            <div class="p-6 max-h-[60vh] overflow-y-auto">
                <template x-if="selectedEvents.length > 0">
                    <ul class="space-y-3">
                        <template x-for="event in selectedEvents" :key="event.title">
                            <li class="flex items-start gap-3 p-3 bg-accent/20 rounded-lg">
                                <div class="h-2 w-2 rounded-full mt-1.5" :class="{ 'bg-blue-500': event.type === 'Zoom', 'bg-green-500': event.type === 'حضوري', 'bg-yellow-500': event.type === 'ورشة' }"></div>
                                <div>
                                    <p class="font-semibold" x-text="event.title"></p>
                                    <p class="text-sm text-muted-foreground" x-text="event.time"></p>
                                </div>
                            </li>
                        </template>
                    </ul>
                </template>
                <template x-if="selectedEvents.length === 0">
                    <p class="text-muted-foreground text-center py-8">{{ __('events.calendar.no_events') }}</p>
                </template>
            </div>
            <div class="p-4 bg-accent/10 rounded-b-2xl text-center">
                 <button class="text-sm font-semibold text-primary hover:underline" @click="showModal = false">{{ __('events.calendar.close') }}</button>
            </div>
        </div>
    </div>
</div>

<script>
    function eventsCalendar(events) {
        return {
            month: new Date().getMonth(),
            year: new Date().getFullYear(),
            dayNames: ['{{ __('events.calendar.day_names.0') }}', '{{ __('events.calendar.day_names.1') }}', '{{ __('events.calendar.day_names.2') }}', '{{ __('events.calendar.day_names.3') }}', '{{ __('events.calendar.day_names.4') }}', '{{ __('events.calendar.day_names.5') }}', '{{ __('events.calendar.day_names.6') }}'],
            monthNames: ['{{ __('events.calendar.month_names.0') }}', '{{ __('events.calendar.month_names.1') }}', '{{ __('events.calendar.month_names.2') }}', '{{ __('events.calendar.month_names.3') }}', '{{ __('events.calendar.month_names.4') }}', '{{ __('events.calendar.month_names.5') }}', '{{ __('events.calendar.month_names.6') }}', '{{ __('events.calendar.month_names.7') }}', '{{ __('events.calendar.month_names.8') }}', '{{ __('events.calendar.month_names.9') }}', '{{ __('events.calendar.month_names.10') }}', '{{ __('events.calendar.month_names.11') }}'],
            daysInMonth: [],
            blankdays: [],
            events: events,
            selectedDate: null,
            selectedEvents: [],
            showModal: false,
            modalTitle: '',

            init() { this.calculateDays(); },
            calculateDays() {
                let firstDay = new Date(this.year, this.month).getDay();
                let days = new Date(this.year, this.month + 1, 0).getDate();
                this.blankdays = Array.from({length: firstDay}, (_, i) => i);
                this.daysInMonth = Array.from({length: days}, (_, i) => i + 1);
            },
            prev() {
                if (this.month === 0) { this.month = 11; this.year--; } else { this.month--; }
                this.calculateDays();
            },
            next() {
                if (this.month === 11) { this.month = 0; this.year++; } else { this.month++; }
                this.calculateDays();
            },
            eventsForDate(date) {
                let fullDate = new Date(this.year, this.month, date).toISOString().split('T')[0];
                return this.events.filter(e => e.iso_date === fullDate);
            },
            openDay(date) {
                this.selectedDate = date;
                let fullDate = new Date(this.year, this.month, date);
                this.modalTitle = `{{ __('events.calendar.events_for') }} ${this.dayNames[fullDate.getDay()]}, ${date} ${this.monthNames[this.month]}`;
                this.selectedEvents = this.events.filter(e => e.iso_date === fullDate.toISOString().split('T')[0]);
                this.showModal = true;
            },
            isSelected(date) {
                return this.showModal && this.selectedDate === date;
            }
        }
    }
</script>
