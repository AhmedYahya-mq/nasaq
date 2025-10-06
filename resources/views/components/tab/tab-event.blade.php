<div x-data="{
    today: new Date(),
    events: [
        {
            id: 1,
            title: 'ورشة تطوير الويب',
            type: 'workshop',
            date: '2025-10-20',
            time: '10:00 ص',
            url: 'https://example.com/event1'
        },
        {
            id: 2,
            title: 'جلسة الأسئلة التقنية',
            type: 'zoom',
            date: '2025-11-15',
            time: '5:00 م',
            url: 'https://example.com/event2'
        },
        {
            id: 3,
            title: 'الفعالية التعريفية بالمجتمع',
            type: 'in_person',
            // تم تغيير التاريخ ليكون في الماضي لعرض الأزرار في هذا المثال
            date: '2025-09-25',
            time: '8:00 م',
            url: 'https://example.com/event3'
        }
    ],
    colors: {
        zoom: 'blue',
        workshop: 'yellow',
        in_person: 'green'
    },
    hasStarted(event ) {
        const now = new Date();
        // ملاحظة: قمت بتعديل تاريخ الفعالية الثالثة ليكون في الماضي لإظهار الأزرار
        const eventDate = new Date(event.date);
        return eventDate <= now;
    }
}">
    <template x-for="event in events" :key="event.id">
        <div
            class="relative flex flex-col w-full bg-card p-6 rounded-2xl border-l-4 shadow-xl hover:shadow-primary/30 transition-all duration-300 mb-6"
            :class="'border-' + colors[event.type] + '-500'"
        >

            <div class="flex items-start justify-between gap-4">

                <div class="flex-grow">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-xl font-bold text-foreground" x-text="event.title"></h3>

                        <template x-if="!hasStarted(event)">
                            <span class="text-xs font-semibold px-3 py-1 rounded-full border backdrop-blur-sm drop-shadow"
                                :class="'border-' + colors[event.type] + '-400/50 text-' + colors[event.type] + '-600 bg-' + colors[event.type] + '-100/20'">
                                🔔 انتظرونا
                            </span>
                        </template>
                    </div>

                    <div class="flex flex-wrap gap-4 text-sm text-muted-foreground">
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" :class="'text-' + colors[event.type] + '-500'" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10m-12 8h14a2 2 0 002-2V7a2 2 0 00-2-2h-1V3h-2v2H8V3H6v2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                            <span x-text="new Date(event.date ).toLocaleDateString('ar-EG', { year: 'numeric', month: 'long', day: 'numeric' })"></span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" :class="'text-' + colors[event.type] + '-500'" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            <span x-text="event.time"></span>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col items-stretch gap-2" x-show="hasStarted(event)" x-transition>
                    <!-- زر الانتقال -->
                    <a :href="event.url" target="_blank"
                        class="flex items-center justify-center gap-2 px-4 py-2 rounded-lg text-sm font-semibold transition-all duration-200"
                        :class="'bg-' + colors[event.type] + '-600 text-white hover:bg-' + colors[event.type] + '-700'">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" /></svg>
                        <span>انتقال</span>
                    </a>

                    <!-- زر النسخ -->
                    <button
                        @click="navigator.clipboard.writeText(event.url ).then(()=>alert('تم نسخ الرابط!'))"
                        class="flex items-center justify-center gap-2 px-4 py-2 rounded-lg text-sm font-semibold bg-muted/60 text-foreground hover:bg-muted transition-all duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" /></svg>
                        <span>نسخ</span>
                    </button>
                </div>
            </div>
         </div>
    </template>
</div>
