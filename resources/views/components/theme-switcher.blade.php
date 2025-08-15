<x-dropdown-menu
    classMenu="bg-card data-[state=open]:animate-in data-[state=closed]:animate-out data-[state=closed]:fade-out-0 data-[state=open]:fade-in-0 data-[state=closed]:zoom-out-95 data-[state=open]:zoom-in-95 data-[side=bottom]:slide-in-from-top-2 data-[side=left]:slide-in-from-right-2 data-[side=right]:slide-in-from-left-2 data-[side=top]:slide-in-from-bottom-2 z-50 max-h-(--radix-dropdown-menu-content-available-height) min-w-[8rem] origin-(--radix-dropdown-menu-content-transform-origin) overflow-x-hidden overflow-y-auto rounded-md border border-border p-1 shadow-md">

    {{-- زر Trigger --}}
    <x-slot name="trigger">
        <button
            class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium transition-all disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg:not([class*='size-'])]:size-4 shrink-0 [&_svg]:shrink-0 outline-none focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40 aria-invalid:border-destructive border border-border bg-background/30 hover:bg-background/50 shadow-xs  dark:bg-input/30 dark:border-input dark:hover:bg-input/50 size-9">
            <i :class="$store.theme.value === 'light' ? 'text-yellow-400' : 'hidden'">
                <x-icon name="sun" class="h-[1.2rem] w-[1.2rem]" />
            </i>
            <i :class="$store.theme.value === 'dark' ? 'text-blue-400' : 'hidden'">
                <x-icon name="moon" class="h-[1.2rem] w-[1.2rem] " />
            </i>
            <i :class="$store.theme.value === 'system' ? 'dark:text-blue-400 text-yellow-400' : 'hidden'">
                <x-icon name="system" class="h-[1.2rem] w-[1.2rem]" />
            </i>

        </button>
    </x-slot>

    <div>
        @foreach (['system' => 'system', 'sun' => 'light', 'moon' => 'dark'] as $icon => $theme)
            {{-- زر لكل ثيم --}}
            <div @click="$store.theme.set('{{ $theme }}')"
                :class="{ 'bg-primary/35': $store.theme.value === '{{ $theme }}' }"
                class="hover:bg-accent/20 focus:bg-accent focus:text-accent-foreground data-[variant=destructive]:text-destructive data-[variant=destructive]:focus:bg-destructive/10 dark:data-[variant=destructive]:focus:bg-destructive/20 data-[variant=destructive]:focus:text-destructive data-[variant=destructive]:*:[svg]:!text-destructive [&_svg:not([class*='text-'])]:text-muted-foreground relative flex cursor-default items-center gap-2 rounded-sm px-2 py-1.5 text-sm outline-hidden select-none data-[disabled]:pointer-events-none data-[disabled]:opacity-50 data-[inset]:pl-8 [&_svg]:pointer-events-none [&_svg]:shrink-0 [&_svg:not([class*='size-'])]:size-4">
                <x-icon name="{{ $icon }}" class="h-[1.2rem] w-[1.2rem]" />
                <span>{{ ucfirst($theme) }}</span>
            </div>
        @endforeach
    </div>
</x-dropdown-menu>
