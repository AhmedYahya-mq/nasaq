<li class="group/link w-full">
    @if ($hasSubMenu)
    <x-ui.accordion :title="__($menu['name'])" classTrigger="w-full cursor-pointer px-3 !py-1  hover:bg-primary/20 hover:text-primary-foreground transition-colors">
        <ul class="flex flex-col gap-1 w-full">
            @foreach ($menu['subMenu'] as $subMenu)
                <li class="px-3 py-1 hover:bg-primary/20 hover:text-primary-foreground transition-colors">
                    <a href="{{ $subMenu['url'] ?? '#' }}" class="block">
                        {{ __($subMenu['name']) }}
                    </a>
                </li>
            @endforeach
        </ul>
    </x-ui.accordion>
    @else
        <span
            class="flex-center gap-1 cursor-pointer px-3 py-1  hover:bg-primary/20 hover:text-primary-foreground transition-colors">
            {{ __($menu['name']) }}
        </span>
    @endif
</li>
