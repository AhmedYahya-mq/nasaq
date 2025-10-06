<div
x-data="{
    events: [
        {
            id: 1,
            title: 'ندوة تقنية حول الذكاء الاصطناعي',
            type: 'zoom',
            date: '2025-10-05',
            time: '18:00',
            url: 'https://example.com/ai-event',
            started: true
        },
        {
            id: 2,
            title: 'ورشة عمل تطوير الويب',
            type: 'workshop',
            date: '2025-10-15',
            time: '20:00',
            url: '#',
            started: false
        }
    ],
    copyLink(url) {
        navigator.clipboard.writeText(url);
        alert('✅ تم نسخ الرابط بنجاح');
    }
}"
class="grid grid-cols-1 md:grid-cols-2 gap-6">

    <template x-for="event in events" :key="event.id">
        <div
            class="relative flex flex-col w-full h-full max-w-full bg-card p-6 rounded-2xl border-l-4 shadow-xl hover:shadow-primary/30 transition-all duration-300"
            :class="{
                'border-blue-500': event.type === 'zoom',
                'border-green-500': event.type === 'in_person',
                'border-yellow-500': event.type === 'workshop',
                'border-gray-500': !['zoom','in_person','workshop'].includes(event.type)
            }"
        >
            <!-- العنوان والوسم -->
            <div class="flex items-center justify-between gap-3 mb-2">
                <h4 class="font-bold text-foreground text-xl leading-snug" x-text="event.title"></h4>
                <span
                    class="text-xs font-semibold px-3 py-1 rounded-full border backdrop-blur-sm whitespace-nowrap drop-shadow"
                    :class="{
                        'border-blue-400/50 text-blue-600 bg-blue-100/20': event.type === 'zoom',
                        'border-green-400/50 text-green-600 bg-green-100/20': event.type === 'in_person',
                        'border-yellow-400/50 text-yellow-600 bg-yellow-100/20': event.type === 'workshop'
                    }"
                    x-text="event.type === 'zoom' ? 'Zoom' : (event.type === 'in_person' ? 'مباشر' : 'ورشة')"
                ></span>
            </div>

            <!-- التفاصيل -->
            <div class="flex flex-row items-center justify-between gap-4 mt-2">
                <div class="flex flex-row flex-wrap gap-4 text-sm text-muted-foreground">
                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M8 7V3m8 4V3m-9 8h10m-12 8h14a2 2 0 002-2V7a2 2 0 00-2-2h-1V3h-2v2H8V3H6v2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <span class="font-semibold" x-text="new Date(event.date).toLocaleDateString('ar')"></span>
                    </div>

                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 8v4l3 3m6 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="font-semibold" x-text="event.time"></span>
                    </div>
                </div>

                <!-- الزر أو الأيقونات -->
                <template x-if="!event.started">
                    <span class="px-4 py-2 text-sm bg-muted/50 text-muted-foreground rounded-lg cursor-not-allowed">
                        ⏳ انتظرونا
                    </span>
                </template>

                <template x-if="event.started && event.url && event.url !== '#'">
                    <div class="flex items-center gap-2">
                        <!-- فتح -->
                        <button
                            @click="window.open(event.url, '_blank')"
                            class="p-2 rounded-lg bg-primary text-white hover:bg-primary/80 transition"
                            title="فتح الصفحة">
                           <x-icons.open class="w-5 h-5" />
                        </button>

                        <!-- نسخ -->
                        <button
                            @click="copyLink(event.url)"
                            class="p-2 rounded-lg bg-muted text-foreground hover:bg-muted/70 transition"
                            title="نسخ الرابط">
                           <x-icons.copy class="w-5 h-5" />
                        </button>
                    </div>
                </template>
            </div>
        </div>
    </template>
</div>
