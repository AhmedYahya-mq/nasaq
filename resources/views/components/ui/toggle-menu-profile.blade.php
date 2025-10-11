<x-ui.dropdown-menu>
    <x-slot name="trigger">
        <button aria-label="Profile Options"
            class="relative point shadow-lg rounded-full active:scale-95 transition-transform duration-150 cursor-pointer">
            <img data-photo-profile src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}" width="32" height="32"
                class="size-8 rounded-full drop-shadow-2xl drop-shadow-card">
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
            <img data-photo-profile src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}"
                class="h-8 w-8 rounded-full object-cover">
            <div class="flex flex-col">
                <span class="font-medium">{{ auth()->user()?->name ?? 'Ahmed Yahya' }}</span>
                <span class="text-xs text-muted-foreground line-clamp-1 w-32">
                    {{ $user->email }}
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
            <a href="{{ route('client.profile') }}" class="flex items-center gap-2 w-full text-foreground">
                <x-ui.icon name="user" class="size-5" />
                <span>الملف الشخصي</span>
            </a>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            {{-- Logout --}}
            <label for="logout"
                class="p-2 m-1 rounded-md mb-1 hover:bg-accent/20 focus:bg-accent focus
                        :text-accent-foreground [&_svg:not([class*='text-'])]:text-muted-foreground relative flex
                        cursor-pointer items-center gap-2 px-2 py-1.5 text
                        -sm outline-hidden select-none data-[disabled]:pointer-events-none data-[inset]:pl-8
                        [&_svg]:pointer-events-none [&_svg]:shrink-0 [&_svg:not([class*='size-'])]:size-4">
                <x-ui.icon name="logout" class="size-5" />
                <input id="logout" type="submit" value="تسجيل الخروج" class="bg-transparent cursor-pointer w-full rtl:text-right">
            </label>
        </form>
    </div>
</x-ui.dropdown-menu>
