<x-dropdown-menu
    classMenu="bg-card data-[state=open]:animate-in data-[state=closed]:animate-out data-[state=closed]:fade-out-0 data-[state=open]:fade-in-0 data-[state=closed]:zoom-out-95 data-[state=open]:zoom-in-95 data-[side=bottom]:slide-in-from-top-2 data-[side=left]:slide-in-from-right-2 data-[side=right]:slide-in-from-left-2 data-[side=top]:slide-in-from-bottom-2 z-50 max-h-(--radix-dropdown-menu-content-available-height) min-w-[8rem] origin-(--radix-dropdown-menu-content-transform-origin) overflow-x-hidden overflow-y-auto rounded-md border border-border p-1 shadow-md">

    {{-- زر Trigger --}}
    <x-slot name="trigger">
        <button
            class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium transition-all disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg:not([class*='size-'])]:size-4 shrink-0 [&_svg]:shrink-0 outline-none focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40 aria-invalid:border-destructive border border-border bg-background/30 hover:bg-background/50 shadow-xs  dark:bg-input/30 dark:border-input dark:hover:bg-input/50 size-9">
            {{-- اللغة
            < --}}
            <span>{{ $locale }}</span>
        </button>
    </x-slot>

    <div class="flex flex-col gap-0.5">
        {{-- زر لكل لغة --}}
        @foreach (['ar' => 'ar', 'en' => 'en'] as $key => $lang)
            <a href="{{ route(Route::currentRouteName(), $key) }}"
            @class([
                'bg-primary/35' => $locale === $key,
                "hover:bg-accent/20 text-accent-foreground focus:bg-accent focus:text-accent-foreground data-[variant=destructive]:text-destructive data-[variant=destructive]:focus:bg-destructive/10 dark:data-[variant=destructive]:focus:bg-destructive/20 data-[variant=destructive]:focus:text-destructive data-[variant=destructive]:*:[svg]:!text-destructive [&_svg:not([class*='text-'])]:text-muted-foreground relative flex cursor-default items-center gap-2 rounded-sm px-2 py-1.5 text-sm outline-hidden select-none data-[disabled]:pointer-events-none data-[disabled]:opacity-50 data-[inset]:pl-8 [&_svg]:pointer-events-none [&_svg]:shrink-0 [&_svg:not([class*='size-'])]:size-4" => true,
            ])>
                <span>{{ __('messages.' . $lang) }}</span>
            </a>
        @endforeach
    </div>
</x-dropdown-menu>
