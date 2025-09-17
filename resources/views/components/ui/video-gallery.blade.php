@props([
    'videos' => [],
])

@php
    $hasVideos = !empty($videos);
    $firstVideoId = $hasVideos ? $videos[0]['id'] : null;
@endphp

@if ($hasVideos)
    <div x-data="{ activeVideoId: '{{ $firstVideoId }}' }" class="space-y-6">
        <div class="flex flex-col lg:flex-row gap-6 items-start">
            {{-- الفيديو الرئيسي --}}
            <div class="w-full lg:w-2/3 rounded-2xl overflow-hidden shadow-xl border border-border bg-black">
                <div class="aspect-video w-full  flex items-center justify-center">
                    {{-- مشغل الفيديو --}}
                    <iframe
                        :src="`https://www.youtube.com/embed/${activeVideoId}?rel=0&modestbranding=1&iv_load_policy=3`"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen class="w-full h-full rounded-2xl" title="مشغل الفيديو الرئيسي"></iframe>

                </div>
            </div>

            {{-- قائمة التشغيل --}}
            @if (count($videos) > 1)
                <div
                    class="w-full lg:w-1/3 space-y-4 max-h-[480px] overflow-y-auto p-3 scrollbar-thin scrollbar-thumb-accent/40 scrollbar-track-transparent">
                    <h3 class="text-lg font-bold text-foreground mb-2">
                        {{ __('archive.playlist') }}
                    </h3>
                    @foreach ($videos as $video)
                        <button @click="activeVideoId = '{{ $video['id'] }}'"
                            class="w-full flex items-center gap-4 p-3 rounded-xl transition text-left rtl:text-right group border border-transparent focus:outline focus:outline-primary"
                            :class="activeVideoId === '{{ $video['id'] }}' ? 'bg-primary/10 border-primary/30' :
                                'hover:bg-accent/30'"
                            tabindex="0" aria-label="{{ $video['title'] }}">
                            {{-- الصورة المصغرة --}}
                            <div class="relative">
                                <img src="https://i3.ytimg.com/vi/{{ $video['id'] }}/hqdefault.jpg"
                                    alt="{{ $video['title'] }}"
                                    class="w-24 h-14 md:w-28 md:h-16 object-cover rounded-lg shadow-sm transition group-hover:scale-105"
                                    loading="lazy">
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <svg class="w-8 h-8 drop-shadow-lg opacity-80" fill="currentColor"
                                        viewBox="0 0 20 20" aria-hidden="true">
                                        <path d="M6 4l12 6-12 6V4z" />
                                    </svg>
                                </div>
                            </div>
                            {{-- النصوص --}}
                            <div class="flex-1 min-w-0">
                                <p class="font-semibold text-sm truncate"
                                    :class="activeVideoId === '{{ $video['id'] }}' ? 'text-primary' : 'text-foreground'">
                                    {{ $video['title'] }}
                                </p>
                                @if (isset($video['description']))
                                    <p class="text-xs text-muted-foreground line-clamp-2">
                                        {{ $video['description'] }}
                                    </p>
                                @endif
                            </div>
                        </button>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@else
    {{-- لا توجد فيديوهات --}}
    <div class="text-center py-12 bg-card rounded-xl shadow-sm border">
        <p class="text-muted-foreground">
            {{ __('archive.no_videos') }}
        </p>
    </div>
@endif
