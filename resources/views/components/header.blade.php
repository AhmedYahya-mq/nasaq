<header class="h-16 text-[15px] card inset-0 flex-center bg-card relative">
    <nav class="px-3.5 flex-center-between w-full max-w-7xl mx-auto">
        <a href="/" class="flex-center gap-x-3 z-10">
            <img src="{{ asset('favicon.ico') }}" alt="Nasaq" class="size-8">
            <h3 class="text-lg font-semibold text-primary">{{ __('messages.nsasq') }}</h3>
        </a>

        {{-- Desktop Menu --}}
        <ul class="flex-center not-lg:!hidden gap-x-1">
            @foreach ($menus as $menu)
                <x-desktop-menu :menu="$menu" />
            @endforeach
        </ul>

        {{-- Mobile Menu --}}

        <div class="flex-center gap-x-5">
            <button class="bg-background/5  relative md:px-4 px-2 py-1 shadow rounded-xl flex-center">
                تسجيل الدخول
            </button>
            <div class="flex-center gap-x-1">
                <x-ui.button-toggle-menu />
            </div>
        </div>
    </nav>

    <ul x-data x-bind:class="$store.menu.isOpen ? 'bounce-in-left' : 'slide-out-right'"
        class="lg:pb-3 lg:!hidden h-dvh max-h-[calc(100dvh-6.9rem)] flex-center origin-left bounce-in flex-col absolute top-16 left-0  z-50 bg-background w-full gap-x-1 scrollbar">
        {{-- Mobile Menu Items --}}
        @foreach ($menus as $menu)
            <x-mobile-menu :menu="$menu" />
        @endforeach
    </ul>
</header>
