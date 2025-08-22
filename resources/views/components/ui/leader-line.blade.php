@props(['dirction' => 'right', 'nath' => '0'])

@php
    $isLeft = $dirction === 'left';
    $positionBoxClass =  $isLeft
        ? 'md:left-8 ltr:left-8 not-md:rtl:right-8'
        : 'md:right-8  not-md:ltr:left-8 rtl:right-8';
    $positionClass = $isLeft
        ? 'md:left-0 '
        : 'md:right-0';
    $scaleClass = $isLeft ? 'md:scale-x-[-1] ltr:scale-x-[-1] md:left-0' : 'rtl:right-0 md:right-0 not-md:ltr:left-0 not-md:ltr:scale-x-[-1]';
@endphp

<div class="absolute w-[calc(100dvw*0.5)] not-md:!w-dvw h-[150px] {{ $positionClass }}"
    style="top: calc(150px * {{ $nath }})">
    <svg  class="absolute {{ $scaleClass }}  bottom-0 w-[230px] h-[55px] *:fill-primary *:stroke-primary" xmlns="http://www.w3.org/2000/svg">
        <!-- الخط المائل بدقة 45° -->
        <line class="line" x1="199.49" y1="50" x2="228.28" y2="21.72" stroke-width="2" />
        <!-- الخط المستقيم -->
        <line class="line" x1="20" y1="50" x2="200" y2="50" stroke-width="2" />
        <circle cx="228.28" cy="21.72" r="3" />
    </svg>
    <div data-dirction="{{ $dirction }}" class="box-card absolute top-0 {{ $positionBoxClass }} w-[calc(100dvw*0.42)]  not-md:!w-[77dvw] h-[150px]">
        {{ $slot }}
    </div>
</div>
