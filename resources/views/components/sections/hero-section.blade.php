<section id="hero">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 p-4 bg-card lg:h-[calc(100dvh-6.9rem)]">
        <div class="flex flex-col items-start justify-center p-5 h-full order-2 lg:order-1">
            <h1 class="text-3xl font-bold mb-4">{{ __('home.hero.title') }}</h1>
            <p class="text-lg text-muted-foreground mb-6">
                {{ __('home.hero.description') }}
            </p>
            <button aria-label="{{ __('home.hero.cta') }}" class="bg-primary !text-white px-4 py-2 rounded-lg hover:bg-primary/80 transition-colors">
                <a class="text-white" href="{{ '/' }}">{{ __('home.hero.cta') }}</a>
            </button>
        </div>

        <div class="flex items-center justify-center *:not-first:p-2 aspect-[3/2] *:not-first:w-[250px] relative h-[calc(100dvh-6.9rem)] w-full lg:aspect-square order-1 lg:order-2">
            <img src="{{ asset('images/froot.webp') }}" class="size-auto" alt="{{ config('app.name') }}">

            <div class="absolute top-[15%] left-2  bg-muted/60 shadow rounded-xl">
                <h2 class="text-xs font-medium">{{ __('home.hero.card1_title') }}</h2>
                <p class="text-[11px] mt-1">{{ __('home.hero.card1_text') }}</p>
            </div>

            <div class="absolute bottom-[15%] left-2 bg-muted/60 shadow rounded-xl">
                <h2 class="text-xs font-medium">{{ __('home.hero.card2_title') }}</h2>
                <p class="text-[11px] mt-1">{{ __('home.hero.card2_text') }}</p>
            </div>

            <div class="absolute right-2 bg-muted/60 shadow rounded-xl">
                <h2 class="text-xs font-medium">{{ __('home.hero.card3_title') }}</h2>
                <p class="text-[11px] mt-1">{{ __('home.hero.card3_text') }}</p>
            </div>
        </div>
    </div>
</section>
