@props([
    'title' => 'Unnamed Event',
    'type' => 'zoom', // zoom | in_person | workshop
    'date' => null,
    'time' => null,
    'url' => '#',
    'isPast' => false,
])

@php
    $colors = [
        'zoom' => 'blue',
        'in_person' => 'green',
        'workshop' => 'yellow',
    ];
    $color = $colors[$type] ?? 'gray';

    $buttonText = $isPast ? trans('events.button.past') : trans('events.highlighted_event.register_now_button');
    $cardLabel = $isPast ? trans('events.past_label') : trans('events.types.' . $type);
@endphp

<div
   {{ $attributes->merge(['class' => 'relative flex flex-col w-full h-full max-w-full bg-card p-6 rounded-2xl border-l-4 border-' . $color . '-500 shadow-xl hover:shadow-primary/30 transition-all duration-300']) }}>

    <div class="flex items-center justify-between gap-3 mb-2">
        <h4 class="font-bold text-foreground text-xl leading-snug">{{ $title }}</h4>
        <span
            class="text-xs font-semibold px-3 py-1 rounded-full border border-{{ $color }}-400/50 text-{{ $color }}-600 bg-{{ $color }}-100/20 backdrop-blur-sm whitespace-nowrap drop-shadow">
            {{ $cardLabel }}
        </span>
    </div>

    <div class="flex flex-row items-center justify-between gap-4 mt-2">
        <div class="flex flex-row flex-wrap gap-4 text-sm text-muted-foreground">
            <div class="flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-{{ $color }}-500" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10m-12 8h14a2 2 0 002-2V7a2 2 0 00-2-2h-1V3h-2v2H8V3H6v2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                <span class="font-semibold">{{ \Carbon\Carbon::parse($date)->translatedFormat('d F Y') }}</span>
            </div>
            <div class="flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-{{ $color }}-500" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="font-semibold">{{ $time }}</span>
            </div>
        </div>

        @if ($url && $url !== '#')
            <a href="{{ $url }}"
                class="px-4 py-2 text-sm rounded-lg font-semibold transition-all duration-300 badget">
                {{ $buttonText }}
            </a>
        @else
            <span class="px-4 py-2 text-sm bg-muted/50 text-muted-foreground rounded-lg cursor-not-allowed">
                {{ trans('events.not_available') }}
            </span>
        @endif
    </div>
</div>
