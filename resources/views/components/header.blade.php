<header class="h-16 text-[15px] lg:m-2 lg:rounded-lg shadow-md fixed inset-0 flex-center bg-card">
    <nav class="px-3.5 flex-center-between w-full max-w-7xl mx-auto">
        <a href="/" class="flex-center gap-x-3 z-10">
            <img src="{{ asset('favicon.ico') }}" alt="Nasaq" class="size-8">
            <h3 class="text-lg font-semibold text-primary">{{ __("messages.nsasq") }}</h3>
        </a>

        {{-- Desktop Menu --}}
        <ul class="flex-center not-lg:!hidden gap-x-1">
            @foreach ($menus as $menu)
                <x-desktop-menu :menu="$menu" />
            @endforeach
        </ul>
        <div class="flex-center gap-x-5">
            {{-- <button
            class="bg-background/5 z-[9000] relative px-5 py-1 shadow rounded-xl flex-center"
            >
                تسجيل الدخول
            </button> --}}
            <x-theme-switcher />
            <x-lang-selector />
        </div>
    </nav>
</header>
