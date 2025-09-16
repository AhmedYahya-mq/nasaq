@props([
    'videos' => [],
])

@php
    $hasVideos = !empty($videos);
    $firstVideoId = $hasVideos ? $videos[0]['id'] : null;
@endphp

@if ($hasVideos)
    <div x-data="{ activeVideoId: '{{ $firstVideoId }}' }" class="space-y-6">
        <div class="grid lg:grid-cols-{{ count($videos) > 1 ? '3' : '1' }} gap-6 items-start">

            {{-- 1. الفيديو الرئيسي --}}
            <div class="lg:col-span-2 rounded-2xl overflow-hidden shadow-xl border border-border bg-black">
                <div class="aspect-video min-h-[350px] lg:min-h-[480px]">
                    <iframe :src="`https://www.youtube.com/embed/${activeVideoId}`" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen class="w-full h-full rounded-2xl"></iframe>
                </div>
            </div>

            {{-- 2. قائمة التشغيل (تظهر فقط لو أكثر من فيديو) --}}
            @if (count($videos) > 1)
                <div
                    class="space-y-4 max-h-[480px] overflow-y-auto pr-1 scrollbar-thin scrollbar-thumb-accent/40 scrollbar-track-transparent">
                    <h3 class="text-lg font-bold text-foreground mb-2">
                        {{ __('archive.playlist') }}
                    </h3>

                    @foreach ($videos as $video)
                        <button @click="activeVideoId = '{{ $video['id'] }}'"
                            class="w-full flex items-center gap-4 p-3 rounded-xl transition text-left rtl:text-right group border border-transparent"
                            :class="activeVideoId === '{{ $video['id'] }}' ? 'bg-primary/10 border-primary/30' :
                                'hover:bg-accent/30'">
                            {{-- الصورة المصغرة --}}
                            <div class="relative">
                                <img src="https://i3.ytimg.com/vi/{{ $video['id'] }}/hqdefault.jpg"
                                    alt="{{ $video['title'] }}"
                                    class="w-28 h-16 object-cover rounded-lg shadow-sm transition group-hover:scale-105">
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <svg class="w-8 h-8  drop-shadow-lg opacity-80" fill="currentColor"
                                        viewBox="0 0 20 20">
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
