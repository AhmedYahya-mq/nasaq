{{-- هذا السكشن فيه تصميم صفحة عرض تفاصيل بطاقة الارشيف --}}
@php
    $event = (object) [
        'title' => __('archive.sample_event.title'),
        'eventDate' => \Carbon\Carbon::parse('2025-06-05'),
        'tags' => [
            __('archive.sample_event.tags.0'),
            __('archive.sample_event.tags.1'),
            __('archive.sample_event.tags.2'),
            __('archive.sample_event.tags.3'),
        ],
        'heroImageUrl' =>
            'https://images.unsplash.com/photo-1521737604893-d14cc237f11d?auto=format&fit=crop&w=1920&q=80',
        'description' => __('archive.sample_event.description' ),
        'videos' => [
            ['id' => '7Nz3dhQJ6bI', 'title' => __('archive.sample_event.videos.0')],
            ['id' => 'B9GC5VhlYt4', 'title' => __('archive.sample_event.videos.1')],
            ['id' => 'i1ZPDfT5jtE', 'title' => __('archive.sample_event.videos.2')],
        ],
        'images' => [
            'https://images.unsplash.com/photo-1523580494863-6f3031224c94?auto=format&fit=crop',
            'https://images.unsplash.com/photo-1511578314322-379afb476865?auto=format&fit=crop',
            'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop',
        ],
        'files' => [
            ['name' => __('archive.sample_event.files.0.name' ), 'size' => '3.4 MB', 'url' => '#'],
            ['name' => __('archive.sample_event.files.1.name'), 'size' => '12.1 MB', 'url' => '#'],
        ],
    ];
@endphp

<section class="bg-background text-foreground">

    {{-- 1. قسم الـ Hero (العنوان والصورة الرئيسية ) --}}
    <header
        class="relative h-[50vh] min-h-[400px] flex items-center justify-center text-center text-white overflow-hidden">
        {{-- صورة الخلفية مع تأثير Overlay --}}
        <div class="absolute inset-0 bg-black/60 z-10"></div>
        <img src="{{ $event->heroImageUrl }}" alt="{{ __('archive.details.hero_alt', ['title' => $event->title]) }}"
            class="absolute inset-0 w-full h-full object-cover">

        {{-- محتوى العنوان --}}
        <div class="relative z-20 px-4">
            <h1 class="text-xl md:text-2xl font-extrabold tracking-tight leading-tight mb-4">
                {{ $event->title }}
            </h1>
            <div class="flex justify-center items-center gap-4 text-lg opacity-90">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                    <span>{{ $event->eventDate->translatedFormat('d F Y') }}</span>
                </div>
            </div>
            {{-- الوسوم (Tags) --}}
            <div class="mt-6 flex justify-center flex-wrap gap-2">
                @foreach ($event->tags as $tag)
                    <span
                        class="bg-white/20  text-xs font-semibold px-3 py-1 rounded-full">{{ $tag }}</span>
                @endforeach
            </div>
        </div>
    </header>

    <main class="container mx-auto px-4 py-16 space-y-20">

        {{-- 2. قسم "عن الفعالية" (الوصف) --}}
        <section>
            <h2 class="text-xl font-bold mb-6 border-b-2 border-primary pb-3">{{ __('archive.details.about_title') }}</h2>
            <div class="prose prose-lg max-w-none text-muted-foreground">
                <p>{{ $event->description }}</p>
            </div>
        </section>

        {{-- 3. قسم معرض الفيديو --}}
        <section>
            <h2 class="text-xl font-bold mb-8">{{ __('archive.details.videos_title') }}</h2>
            {{-- استدعاء مكون معرض الفيديو وتمرير البيانات له --}}
            <x-ui.video-gallery :videos="$event->videos" />
        </section>

        {{-- 4. قسم معرض الصور --}}
        <section>
            <h2 class="text-xl font-bold mb-8">{{ __('archive.details.images_title') }}</h2>
            {{-- استدعاء مكون معرض الصور وتمرير البيانات له --}}
            <x-ui.image-gallery :images="$event->images" />
        </section>

        {{-- ============================================= --}}
        {{-- 5. قسم الملفات والمرفقات --}}
        {{-- ============================================= --}}
        @if (!empty($event->files))
            <section>
                <h2 class="text-xl font-bold mb-8">{{ __('archive.details.files_title') }}</h2>
                <div class="bg-card border border-border rounded-xl divide-y divide-border">
                    @foreach ($event->files as $file)
                        <a href="{{ $file['url'] }}" target="_blank"
                            class="flex items-center justify-between p-5 hover:bg-accent/50 transition-colors">
                            <div class="flex items-center gap-4">
                                <div class="bg-primary/10 p-3 rounded-lg">
                                    <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-foreground">{{ $file['name'] }}</p>
                                    <p class="text-sm text-muted-foreground">{{ $file['size'] }}</p>
                                </div>
                            </div>
                            <div class="text-muted-foreground">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                </svg>
                            </div>
                        </a>
                    @endforeach
                </div>
            </section>
        @endif

    </main>
</section>
