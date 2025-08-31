<section class="relative py-20 md:py-24 bg-gradient-to-br from-primary/5 via-background to-background overflow-hidden">
    <div class="md:p-6 p-2 grid grid-cols-1 gap-2.5 md:grid-cols-[1fr_0.8fr] place-items-center">

        <!-- النصوص -->
        <div class="flex flex-col justify-center not-md:order-2">
            <h1 class="font-bold text-2xl tracking-tight text-primary mb-6 leading-snug">
                {{ __('about.hero.title') }}
            </h1>

            <p class="text-base text-muted-foreground leading-relaxed mb-8 max-w-2xl mx-auto lg:mx-0">

                {{ __('about.hero.description') }}
            </p>

            <!-- النقاط التعريفية -->
            <ul class="space-y-4 rtl:text-right ltr:text-left mb-10 max-w-md mx-auto lg:mx-0">
                <li class="flex items-start gap-3">
                    <span class="w-6 h-6 flex items-center justify-center bg-primary text-white rounded-full shrink-0">✓</span>
                    <span>{{ __('about.hero.point1') }}</span>
                </li>
                <li class="flex items-start gap-3">
                    <span class="w-6 h-6 flex items-center justify-center bg-primary text-white rounded-full shrink-0">✓</span>
                    <span>{{ __('about.hero.point2') }}</span>
                </li>
                <li class="flex items-start gap-3">
                    <span class="w-6 h-6 flex items-center justify-center bg-primary text-white rounded-full shrink-0">✓</span>
                    <span>{{ __('about.hero.point3') }}</span>
                </li>
            </ul>

            <!-- الأزرار -->
            <div class="flex gap-4 justify-center lg:justify-start" >
                <a href="#memberships"
                   class="py-2 px-4 text-base sm:text-lg font-semibold rounded-2xl bg-primary text-accent-foreground hover:bg-primary/90 transition-all shadow-md hover:shadow-xl">
                    {{ __('about.hero.cta_primary') }}
                </a>
                <a href="#vision"
                   class="py-2 px-4 text-base sm:text-lg font-semibold rounded-2xl border border-primary text-primary hover:bg-primary/5 transition-all">
                    {{ __('about.hero.cta_secondary') }}
                </a>
            </div>
        </div>

        <!-- الصورة -->
        <div class="relative not-sm:p-2 not-md:order-1">
            <img src="https://images.unsplash.com/photo-1526256262350-7da7584cf5eb?ixlib=rb-4.0.3&q=80&auto=format&fit=crop&w=1200"
                 alt="Community Collaboration"
                 class="rounded-2xl shadow-lg object-cover aspect-[6/4]" />
        </div>

    </div>

    <!-- قسم الرؤية والرسالة -->
    <div class="max-w-7xl mx-auto mt-20 px-6 lg:px-12">
        <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-2 justify-center">

            {{-- بطاقة الرؤية --}}
            <div class="p-8 rounded-2xl bg-card shadow-lg border border-border flex flex-col hover:shadow-xl transition">
                <div class="w-16 h-16 flex items-center justify-center rounded-full bg-primary/10 text-primary mb-6">
                    <svg class="w-8 h-8" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"
                              d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12z"/>
                        <circle cx="12" cy="12" r="3.2" stroke-width="1.8"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-primary mb-4">{{ __('about.vision_title') }}</h3>
                <p class="text-muted-foreground mb-6">{{ __('about.vision_text') }}</p>
                @php($visionPoints = __('about.vision_points'))
                @if(is_array($visionPoints))
                    <ul class="space-y-3 text-sm text-muted-foreground">
                        @foreach($visionPoints as $point)
                            <li class="flex items-start gap-2">
                                <span class="mt-1 w-5 h-5 flex items-center justify-center rounded bg-primary/10 text-primary text-xs">✓</span>
                                <span>{{ $point }}</span>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

            {{-- بطاقة الرسالة --}}
            <div class="p-8 rounded-2xl bg-card shadow-lg border border-border flex flex-col hover:shadow-xl transition">
                <div class="w-16 h-16 flex items-center justify-center rounded-full bg-primary/10 text-primary mb-6">
                    <svg class="w-8 h-8" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"
                              d="M12 7c.5-2.2 2.2-3.5 4-3.5M9 8c-3 0-5 2.2-5 5 0 3.5 2.8 7 8 7s8-3.5 8-7c0-2.8-2-5-5-5-1.8 0-3 .6-3.7 1.6C10.6 8.4 9.9 8 9 8z"/>
                        <path stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"
                              d="M7 13h2l1.2-2.2L12 14l1.2-2 1 1.6H17"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-primary mb-4">{{ __('about.mission_title') }}</h3>
                <p class="text-muted-foreground mb-6">{{ __('about.mission_text') }}</p>
                @php($missionPoints = __('about.mission_points'))
                @if(is_array($missionPoints))
                    <ul class="space-y-3 text-sm text-muted-foreground">
                        @foreach($missionPoints as $point)
                            <li class="flex items-start gap-2">
                                <span class="mt-1 w-5 h-5 flex items-center justify-center rounded bg-primary/10 text-primary text-xs">✓</span>
                                <span>{{ $point }}</span>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

        </div>
    </div>
</section>
