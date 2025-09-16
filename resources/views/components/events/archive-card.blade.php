@props([
    'title' => __('events.event_card.default_title'),
    'date' => null,
    'time' => null,
    'registrationUrl' => '#',
    'filesUrl' => '#',
    'imageUrl' => null, // خاصية الصورة
])


<div class="flex flex-col bg-card rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 overflow-hidden border border-border/50">

    {{-- 1. قسم الصورة (يظهر فقط إذا كانت الصورة موجودة) --}}
    @if ($imageUrl)
        <div class="aspect-video w-full overflow-hidden">
            {{--
                - object-cover: تضمن ملء الصورة للمساحة المتاحة دون تشويه.
                - hover:scale-105: تأثير تكبير بسيط عند مرور الماوس.
            --}}
            <img src="{{ $imageUrl }}" alt="صورة الحدث: {{ $title }}" class="w-full h-full object-cover transition-transform duration-300 hover:scale-105">
        </div>
    @endif

    {{-- 2. قسم المحتوى (دائماً موجود) --}}
    <div class="flex flex-col flex-grow p-6">

        {{-- العنوان والوسم --}}
        <div class="flex items-start justify-between gap-4 mb-4">
            <h3 class="font-bold text-lg md:text-xl text-foreground leading-tight">{{ $title }}</h3>
            <span class="text-xs font-semibold px-3 py-1 rounded-full bg-primary/10 text-primary whitespace-nowrap mt-1">
                {{ __('events.archive_card.archive_tag') }}
            </span>
        </div>

        {{-- التاريخ والوقت --}}
        @if ($date || $time)
            <div class="flex flex-wrap items-center gap-x-5 gap-y-2 text-sm text-muted-foreground mb-5 border-b border-border pb-5">
                @if ($date)
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <span>{{ \Carbon\Carbon::parse($date)->translatedFormat('d F Y') }}</span>
                    </div>
                @endif
                @if ($time)
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span>{{ $time }}</span>
                    </div>
                @endif
            </div>
        @endif

        {{-- هذا العنصر يضمن دفع الأزرار لأسفل البطاقة دائمًا --}}
        <div class="flex-grow"></div>

        {{-- 3. قسم الأزرار --}}
        <div class="flex flex-col sm:flex-row gap-3 mt-auto">
            @php
                $hasFiles = $filesUrl && $filesUrl !== '#';
                $hasRecording = $registrationUrl && $registrationUrl !== '#';
            @endphp

            @if($hasFiles || $hasRecording)
                @if($hasFiles)
                    <a href="{{ $filesUrl }}" target="_blank"
                       class="flex-1 text-center px-4 py-2.5 bg-primary text-primary-foreground rounded-lg font-semibold hover:bg-primary/90 transition-all duration-200 shadow-sm">
                        {{ __('events.archive_card.view_files') }}
                    </a>
                @endif

                @if($hasRecording)
                    <a href="{{ $registrationUrl }}" target="_blank"
                       class="flex-1 text-center px-4 py-2.5 bg-accent text-accent-foreground rounded-lg font-semibold hover:bg-accent/80 transition-all duration-200">
                        {{ __('events.archive_card.view_recording') }}
                    </a>
                @endif
            @else
                <div class="w-full text-center px-4 py-2.5 bg-muted/50 text-muted-foreground rounded-lg cursor-not-allowed">
                    {{ __('events.archive_card.no_content_available') }}
                </div>
            @endif
        </div>
    </div>
</div>
