@props(['id', 'label', 'disabled' => false, 'icon' => null])

<button
    @if ($disabled) disabled
        class="relative  px-4 py-2 text-sm font-medium text-muted-foreground/35 focus:outline-none"
    @else
        @click="activeTab = '{{ $id }}'"
        class="relative cursor-pointer px-4 py-2 text-sm font-medium  hover:text-primary focus:outline-none"
        :class="activeTab === '{{ $id }}' ? 'text-primary' : 'text-muted-foreground'"
    @endif>

    @if (!empty($icon))
        <x-ui.icon :name="$icon" class="mr-2" />
    @endif
    
    {{ $label }}

    <span class="absolute left-0 right-0 -bottom-px h-0.5 bg-primary transform origin-center transition-all duration-300"
        :class="activeTab === '{{ $id }}' ? 'scale-x-100' : 'scale-x-0'"></span>
</button>
