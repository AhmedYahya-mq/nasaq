@props([
    'title' => 'عنوان',
    'class' => 'w-full',
    'classContent' => 'w-full',
    'classTrigger' => 'cursor-pointer'
])

<div x-data="{ open: false }" class="{{ $class }}">

    <!-- العنوان -->
    <div @click="open = !open"
         class="{{ $classTrigger }} py-3 flex-center-between border-b border-muted">
        <span class="font-medium">{{ $title }}</span>
        <svg :class="{'rotate-180': open}" xmlns="http://www.w3.org/2000/svg"
             class="h-5 w-5 transform transition-transform duration-500"
             fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
        </svg>
    </div>

    <!-- المحتوى -->
    <div x-show="open"
         x-transition:enter="transition-all ease-out origin-top duration-500"
         x-transition:enter-start=" max-h-0 "
         x-transition:enter-end=" max-h-screen"
         x-transition:leave="transition-all ease-in origin-top duration-[400ms]"
         x-transition:leave-start=" max-h-screen"
         x-transition:leave-end="max-h-0"
         class="{{ $classContent }} overflow-hidden"
         style="display: none;">
        {{ $slot }}
    </div>

</div>
