@props([
    'title' => __('events.event_card.default_title'),
    'description' => null, // وصف مختصر للحدث
    'date' => null,
    'time' => null,
    'registrationUrl' => '#',
    'filesUrl' => '#',
    'imageUrl' => null,
])

{{--
    بطاقة أرشيف الحدث - تصميم متجاوب ومحسن
    - تستخدم flex و grid لتوزيع العناصر بشكل متجاوب
    - أزرار الإجراء دائمًا في الأسفل
    - تحسين الوصولية والتأثيرات
--}}

<a href="{{ route('client.archive') }}" rel="noopener noreferrer">
    <div class="flex flex-col bg-card rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 overflow-hidden border border-border/50
        min-h-[400px] md:min-h-[420px] flex-1 h-full
        focus-within:ring-2 focus-within:ring-primary/40"
        tabindex="0" aria-label="{{ $title }}">
        {{-- قسم الصورة (يظهر فقط إذا كانت الصورة موجودة) --}}
        @if ($imageUrl)
            <div class="aspect-video w-full overflow-hidden relative group">
                <img src="{{ $imageUrl }}" alt="{{ __('events.archive_card.image_alt', ['title' => $title]) }}"
                    class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105 group-focus:scale-105"
                    loading="lazy">
                {{-- تدرج خفيف أعلى الصورة لتحسين وضوح النصوص إذا وضعت فوقها --}}
                <div
                    class="absolute inset-0 bg-gradient-to-t from-black/10 via-transparent to-transparent pointer-events-none">
                </div>
            </div>
        @endif

        {{-- قسم المحتوى --}}
        <div class="flex flex-col flex-grow p-4 md:p-6 min-h-[220px] md:min-h-[240px]">
            {{-- العنوان والوسم --}}
            <div class="flex items-start justify-between gap-2 mb-2 md:mb-3">
                <h3 class="font-bold text-base md:text-xl text-foreground leading-tight break-words">
                    {{ $title }}
                </h3>
                <span
                    class="text-xs md:text-sm font-semibold px-3 py-1 rounded-full bg-primary/10 text-primary whitespace-nowrap mt-1">
                    {{ __('events.archive_card.archive_tag') }}
                </span>
            </div>

            {{-- التاريخ والوقت --}}
            @if ($date || $time)
                <div
                    class="flex flex-wrap items-center gap-x-4 gap-y-2 text-sm md:text-base text-muted-foreground mb-4 md:mb-5 border-b border-border pb-4 md:pb-5">
                    @if ($date)
                        <div class="flex items-center gap-2">
                            {{-- أيقونة التاريخ مع وضوح أعلى --}}
                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                aria-hidden="true" focusable="false">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                            <span>{{ \Carbon\Carbon::parse($date)->translatedFormat('d F Y') }}</span>
                        </div>
                    @endif
                    @if ($time)
                        <div class="flex items-center gap-2">
                            {{-- أيقونة الوقت مع وضوح أعلى --}}
                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                aria-hidden="true" focusable="false">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>{{ $time }}</span>
                        </div>
                    @endif
                </div>
            @endif

            @if ($description)
                <p class="text-sm md:text-base text-muted-foreground mb-2 md:mb-3 line-clamp-3">
                    {{ $description }}
                </p>
            @endif
        </div>
    </div>
</a>

{{--
    ملاحظات:
    - استخدم min-h و flex-grow لضمان ثبات ارتفاع البطاقة وتواجد الأزرار في الأسفل دائماً.
    - استخدم focus-visible للأزرار لتحسين الوصولية.
    - استخدم break-words للعنوان لمنع overflow.
    - استخدم تدرج أعلى الصورة لتحسين وضوح النصوص إذا وضعت فوقها.
    - استخدم responsive padding/text sizes.
    - البطاقة مرنة flex-1 وتتكيف مع الشبكة الخارجية.
--}}
