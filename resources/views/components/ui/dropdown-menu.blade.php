@props(['classMenu'=>"", 'class'=>"inline-block"])
<div x-data="dropdown" class="{{ $class }}">
    <!-- الزرار -->
    <div x-ref="button" @click="toggle()" class="cursor-pointer">
        {{ $trigger ?? 'Toggle' }}
    </div>

    <!-- القائمة -->
    <div x-ref="menu"
        x-show="open"
        x-transition:enter="transition ease-out grid-cols-3 grid-cols-2 duration-200"
                x-transition:enter-start="opacity-0 -translate-y-2"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 -translate-y-2"
        @click.away="close()"
        class="{{ $classMenu }}"
        style="display: none;">
        {{ $slot}}
    </div>
</div>
