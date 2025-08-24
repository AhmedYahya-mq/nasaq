<x-ui.dropdown-menu>
    <x-slot name="trigger">
        <button aria-label="Profile Options"
            class="relative shadow-lg rounded-full active:scale-95 transition-transform duration-150 cursor-pointer">
            <img src="https://ui-avatars.com/api/?name=Ahmed Yahya&bold=true&format=svg" alt="profile" width="32"
                height="32" class="size-8 rounded-full drop-shadow-2xl drop-shadow-card">
        </button>
    </x-slot>

    <div
        class="bg-card z-[51] min-w-[12rem] overflow-x-hidden overflow-y-auto rounded-md border border-border shadow-md">
        {{-- Profile --}}
        <div
            class="p-2 m-1
            [&_svg:not([class*='text-'])]:text-muted-foreground relative flex items-center gap-2
            px-2 py-1.5 text-sm outline-hidden
            data-[inset]:pl-8 [&_svg]:pointer-events-none [&_svg]:shrink-0 [&_svg:not([class*='size-'])]:size-4">
            <img src="{{ auth()->user()?->profile_photo_url ?? 'https://ui-avatars.com/api/?name=Ahmed Yahya&bold=true&format=svg' }}"
                alt="{{ auth()->user()?->name ?? 'Ahmed Yahya' }}" class="h-8 w-8 rounded-full object-cover">
            <div class="flex flex-col">
                <span class="font-medium">{{ auth()->user()?->name ?? 'Ahmed Yahya' }}</span>
                <span class="text-xs text-muted-foreground line-clamp-1 w-32">
                    {{ auth()->user()?->email ?? 'info@example.com' }}
                </span>
            </div>
        </div>
        <hr class="border-primary" />
        {{-- Profile Settings --}}
        <div
            class="p-2 m-1 rounded-md mb-1 hover:bg-accent/20 focus:bg-accent focus
            :text-accent-foreground [&_svg:not([class*='text-'])]:text-muted-foreground relative flex
            cursor-default items-center gap-2 px-2 py-1.5 text
            -sm outline-hidden select-none data-[disabled]:pointer-events-none data-[inset]:pl-8
            [&_svg]:pointer-events-none [&_svg]:shrink-0 [&_svg:not([class*='size-'])]:size-4">
            <a href="{{ route("profile") }}" class="flex items-center gap-2 w-full text-foreground">
                <x-ui.icon name="user" class="size-5" />
                <span>الملف الشخصي</span>
            </a>
        </div>
        <div class="p-2 m-1 rounded-md mb-1 hover:bg-accent/20 focus:bg-accent focus
            :text-accent-foreground [&_svg:not([class*='text-'])]:text-muted-foreground relative flex
            cursor-default items-center gap-2 px-2 py-1.5 text
            -sm outline-hidden select-none data-[disabled]:pointer-events-none data-[inset]:pl-8
            [&_svg]:pointer-events-none [&_svg]:shrink-0 [&_svg:not([class*='size-'])]:size-4"
            onclick="window.location='/'">
            <x-ui.icon name="user" class="size-5" />
            <span>الاعدادات</span>
        </div>
        <div class="p-2 m-1 hover:bg-accent/20 focus:bg-accent focus:text-accent-foreground [&_svg:not([class*='text-'])]:text-muted-foreground relative flex cursor-default items-center gap-2 rounded-sm px-2 py-1.5 text-sm outline-hidden select-none data-[disabled]:pointer-events-none data-[inset]:pl-8 [&_svg]:pointer-events-none [&_svg]:shrink-0 [&_svg:not([class*='size-'])]:size-4"
            onclick="window.location='/'">
            <x-ui.icon name="user" class="size-5" />
            <span>الاشتراكات</span>
        </div>
    </div>
</x-ui.dropdown-menu>
