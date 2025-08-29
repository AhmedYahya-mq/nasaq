<li class="group/link" @if ($hasSubMenu) x-data="hover"
        x-init="init()" @endif>
    <span class="flex-center gap-1 cursor-pointer px-3 py-1 rounded-xl hover:bg-primary/20 transition-colors">
        {{ __($menu['name']) }}
        @if ($hasSubMenu)
            <x-ui.icon name="chevron-down" class="mt-[0.6px] size-4 group-hover/link:rotate-180 duration-200" />
        @endif
    </span>
    @if ($hasSubMenu)
        <div class="sub-menu"
            @if ($hasSubMenu) x-show="isHovered"  x-transition:enter="transition ease-out grid-cols-3 grid-cols-2 duration-200"
                x-transition:enter-start="opacity-0 -translate-y-1.5"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 -translate-y-1.5" @endif>
            <div class="grid gap-7 z-10 grid-cols-{{ $menu['gridCols'] ?? 1 }}">
                @foreach ($menu['subMenu'] as $subMenu)
                    <div class="relative cursor-pointer">
                        <div class="flex-center gap-x-4 group/menubox">
                            <div
                                class="bg-foreground/10 w-fit p-2
                            rounded-md group-hover/menubox:bg-background
                            group-hover/menubox:text-primary duration-300">
                                @isset($subMenu['icon'])
                                    <div class="size-6 border">
                                    </div>
                                @endisset
                            </div>
                            <div>
                                <h6 class="font-semibold">
                                    {{ __($subMenu['name']) }}
                                </h6>
                                <p class="text-sm text-muted-foreground">
                                    {{ __($subMenu['desc']) ?? 'No description available.' }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</li>
