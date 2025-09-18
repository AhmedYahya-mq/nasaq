<li class="group/link w-full my-0.5">
    @if ($hasSubMenu)
        <x-ui.accordion :title="__($menu['name'])"
            classTrigger="w-full cursor-pointer px-3 !py-1  hover:bg-primary/20 hover:text-primary-foreground transition-colors">
            <ul class="flex flex-col gap-1 w-full">
                @foreach ($menu['subMenu'] as $subMenu)
                    <li class="px-3 py-1 hover:bg-primary/20 hover:text-primary-foreground transition-colors">
                        <a href="{{ $isActive || $hasSubMenu ? 'javascript:void(0)' : route($menu['route']) }}"
                            class="flex items-center gap-1 cursor-pointer px-3 py-1 rounded-xl text-foreground
                            {{ $isActive ? 'badget' : '' }} hover:bg-primary/20 transition-colors">
                            {{ __($menu['name']) }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </x-ui.accordion>
    @else
        <a href="{{ $isActive || $hasSubMenu ? 'javascript:void(0)' : route($menu['route']) }}"
            class="flex items-center gap-1 px-2 cursor-pointer text-foreground
                            {{ $isActive ? 'badget' : '' }} hover:bg-primary/20 transition-colors">
            {{ __($menu['name']) }}
        </a>
    @endif
</li>
