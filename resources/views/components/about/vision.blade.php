<section class="relative py-20 bg-muted/30 overflow-hidden">
    <div class="max-w-7xl mx-auto px-6 lg:px-12 space-y-20">

        {{-- بطاقة الرؤية (معكوسة: دائرة على اليسار، صورة على اليمين) --}}
        <div class="flex flex-col md:flex-row items-center  gap-10 relative">
            {{-- أيقونة داخل دائرة على اليمين  --}}
            <div class="flex-shrink-0 absolute  top-1/2 transform -translate-y-1/2 z-10 hidden md:flex">
                <div class="size-32 md:size-40 rounded-full bg-primary/10 flex items-center justify-center">
                    <svg class="w-14 h-14 text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"
                              d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12z"/>
                        <circle cx="12" cy="12" r="3.2" stroke-width="1.8"/>
                    </svg>
                </div>
            </div>

            {{-- محتوى الرؤية + صورة على اليمين (تشارك المساحة) --}}
            <div class="flex-1 relative  md:pl-0  ">
                <div class="bg-primary/10 backdrop-blur-sm rounded-xl p-8 border border-primary/20 shadow-lg flex flex-col md:flex-row items-center justify-center gap-8">

                    {{-- النص على اليسار  --}}
                    <div class="flex-1 ">
                        <h3 class="text-3xl font-bold mb-6 text-primary">{{ __('about.vision_title') }}</h3>
                        <p class="text-muted-foreground leading-relaxed mb-6">
                            {{ __('about.vision_text') }}
                        </p>

                        @php($visionPoints = __('about.vision_points'))
                        @if(is_array($visionPoints))
                            <ul class="space-y-4">
                                @foreach($visionPoints as $point)
                                    <li class="flex items-start gap-3">
                                        <span class="mt-1 inline-flex items-center justify-center rounded-md bg-primary/10 text-primary size-6">
                                            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                <path d="M20 6L9 17l-5-5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </span>
                                        <span class="text-sm leading-6 text-muted-foreground">{{ $point }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>

                    {{-- الصورة على اليمين  --}}
                    <div class="flex-shrink-0 w-64 h-64 md:w-80 md:h-80 aspect-square rounded-2xl overflow-hidden border-2 border-primary/20 shadow-lg">
                        <img src="{{ asset('images/vision-image.jpg') }}" alt="صورة الرؤية" class="w-full h-full object-cover">
                    </div>
                </div>
            </div>
        </div>

        {{-- بطاقة الرسالة (معكوسة: دائرة على اليمين، صورة على اليسار) --}}
        <div class="flex flex-col md:flex-row-reverse items-center gap-10 relative">
            {{-- أيقونة داخل دائرة على اليمين --}}
            <div class="flex-shrink-0 absolute  top-1/2 transform -translate-y-1/2 z-10 hidden md:flex">
                <div class="size-32 md:size-40 rounded-full bg-primary/10 flex items-center justify-center">
                    <svg class="w-14 h-14 text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"
                              d="M12 7c.5-2.2 2.2-3.5 4-3.5M9 8c-3 0-5 2.2-5 5 0 3.5 2.8 7 8 7s8-3.5 8-7c0-2.8-2-5-5-5-1.8 0-3 .6-3.7 1.6C10.6 8.4 9.9 8 9 8z"/>
                        <path stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"
                              d="M7 13h2l1.2-2.2L12 14l1.2-2 1 1.6H17"/>
                    </svg>
                </div>
            </div>

            {{-- محتوى الرسالة + صورة على اليسار (تشارك المساحة) --}}
            <div class="flex-1 relative  md:pr-0">
                <div class="bg-primary/10 backdrop-blur-sm rounded-xl p-8 border border-primary/20 shadow-lg flex flex-col md:flex-row items-center gap-8">

                    {{-- الصورة على اليسار  --}}
                    <div class="flex-shrink-0 w-64 h-64 md:w-80 md:h-80 aspect-square rounded-2xl overflow-hidden border-2 border-primary/20 shadow-lg">
                        <img src="{{ asset('images/mission-image.jpg') }}" alt="صورة الرسالة" class="w-full h-full object-cover">
                    </div>

                    {{-- النص على اليمين  --}}
                    <div class="flex-1 ">
                        <h3 class="text-3xl font-bold mb-6 text-primary">{{ __('about.mission_title') }}</h3>
                        <p class="text-muted-foreground leading-relaxed mb-6">
                            {{ __('about.mission_text') }}
                        </p>

                        @php($missionPoints = __('about.mission_points'))
                        @if(is_array($missionPoints))
                            <div class="grid sm:grid-cols-2 gap-3">
                                @foreach($missionPoints as $point)
                                    <div class="flex items-start gap-3 rounded-xl border p-3 bg-card/40">
                                        <span class="mt-1 inline-flex items-center justify-center rounded-full bg-primary/10 text-primary size-6">
                                            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="currentColor">
                                                <circle cx="12" cy="12" r="6"/>
                                            </svg>
                                        </span>
                                        <span class="text-sm leading-6 text-muted-foreground">{{ $point }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
