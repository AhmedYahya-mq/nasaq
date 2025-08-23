<section class="relative py-20 md:py-24 bg-gradient-to-br from-primary/5 via-background to-background overflow-hidden">
    <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-10 md:gap-16 px-4 sm:px-6 lg:px-8 items-center">

        <!-- النصوص -->
        <div class="text-center ">
            <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold tracking-tight text-primary mb-6 leading-snug">
                {{ __('about.hero.title') }}
            </h1>

            <p class="text-base sm:text-lg md:text-xl text-muted-foreground leading-relaxed mb-8 max-w-2xl mx-auto lg:mx-0">
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
            <div class="flex  gap-4 justify-center lg:justify-start">
                <a href="#memberships"
                   class="px-6 sm:px-8 py-3 sm:py-4 text-base sm:text-lg font-semibold rounded-2xl bg-primary text-accent-foreground hover:bg-primary/90 transition-all shadow-md hover:shadow-xl">
                    {{ __('about.hero.cta_primary') }}
                </a>
                <a href="#vision"
                   class="px-6 sm:px-8 py-3 sm:py-4 text-base sm:text-lg font-semibold rounded-2xl border border-primary text-primary hover:bg-primary/5 transition-all">
                    {{ __('about.hero.cta_secondary') }}
                </a>
            </div>
        </div>

        <!-- الصورة -->
        <div class="relative">
            <img src="https://images.unsplash.com/photo-1526256262350-7da7584cf5eb?ixlib=rb-4.0.3&q=80&auto=format&fit=crop&w=1200"
                 alt="Community Collaboration"
                 class="rounded-2xl shadow-lg object-cover w-full h-64 sm:h-80 md:h-[450px]" />
        </div>
    </div>
</section>
