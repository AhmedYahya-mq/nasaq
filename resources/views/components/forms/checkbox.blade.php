@props([
    'id' => '',
    'label' => '',
])

<label for="{{ $id }}" class="flex flex-row items-center gap-2.5 cursor-pointer select-none text-md">
    <input {{ $attributes }} id="{{ $id }}" type="checkbox"  class="peer hidden" />
    <div for="{{ $id }}"
        class="h-5 w-5 flex rounded-md border border-crad bg-background peer-checked:bg-primary transition">
        <svg fill="none" viewBox="0 0 24 24" class="w-5 h-5 stroke-background"
            xmlns="http://www.w3.org/2000/svg">
            <path d="M4 12.6111L8.92308 17.5L20 6.5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            </path>
        </svg>
    </div>
    {{ $label }}
</label>
