@props(['event', 'isRegistration' => false])

@php
    $type = $event->event_type->slug ?? 'in_person';
    $colors = [
        'zoom' => 'blue',
        'in_person' => 'green',
        'workshop' => 'yellow',
    ];
    $color = $colors[$type] ?? 'gray';

    $date = $event->start_at->locale(app()->getLocale())->translatedFormat('d F Y');
    $time = $event->start_at->locale(app()->getLocale())->translatedFormat('h:i A');

    $isPast = $event->start_at->isPast();
    $buttonText = $isPast
        ? trans('events.button.past')
        : ($event->isFree()
            ? trans('events.buttons.free_registration')
            : trans('events.buttons.pay_registration'));
    $cardLabel = $isPast ? trans('events.past_label') : trans('events.types.' . $type);
@endphp

<div {{ $attributes->merge([
    'class' => 'relative flex flex-col w-full bg-card p-6 rounded-2xl border-l-4 border-' . $color . '-500 shadow-md hover:shadow-' . $color . '-400/30 transition-all duration-300'
]) }}>
    <!-- العنوان والشارة -->
    <div class="flex items-center justify-between gap-3 mb-3">
        <h4 class="font-bold text-foreground text-xl leading-snug truncate">{{ $event->title }}</h4>
        <span class="text-xs font-semibold px-3 py-1 rounded-full border border-{{ $color }}-400/50 text-{{ $color }}-600 bg-{{ $color }}-100/20 backdrop-blur-sm whitespace-nowrap">
            {{ $cardLabel }}
        </span>
    </div>

    <!-- التاريخ والوقت -->
    <div class="flex flex-wrap items-center gap-4 text-sm text-muted-foreground mb-3">
        <div class="flex items-center gap-2">
            <svg class="w-4 h-4 text-{{ $color }}-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <span class="font-semibold">{{ $date }}</span>
        </div>

        <div class="flex items-center gap-2">
            <svg class="w-4 h-4 text-{{ $color }}-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 8v4l3 3m6 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span class="font-semibold">{{ $time }}</span>
        </div>
    </div>

    <!-- الموقع فقط إذا حضوري -->
    @if ($event->event_type->isPhysical())
        <div class="flex items-center gap-2 text-sm text-muted-foreground mb-4">
            <svg class="w-4 h-4 text-{{ $color }}-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            <span class="font-semibold truncate">{{ $event->address }}</span>
        </div>
    @endif

    <!-- زر التسجيل -->
    <div class="mt-auto pt-4 border-t border-border">
        @if ($event->canUserRegister())
            @if (!$isRegistration)
                @if ($event->isFree())
                    <a href="{{ route('client.event.register', ['event' => $event]) }}"
                       class="block w-full text-center bg-primary hover:bg-primary/90 text-primary-foreground py-3 rounded-xl font-bold text-sm shadow-sm transition-all">
                        {{ $buttonText }}
                    </a>
                @else
                    <div class="flex items-center justify-between gap-4">
                        <a href="{{ route('client.event.register', ['event' => $event]) }}"
                           class="flex-1 text-center bg-primary hover:bg-primary/90 text-primary-foreground py-3 rounded-xl font-bold text-sm shadow-sm transition-all">
                            💳 {{ $buttonText }}
                        </a>
                        <div class="text-right">
                            @if ($event->isDiscounted())
                                <div class="text-xs text-muted-foreground line-through">
                                    <span>{{ $event->price }}</span>
                                    <x-ui.icon name="riyal" class="w-3 h-3 inline-block" />
                                </div>
                            @endif
                            <div class="text-lg font-bold text-card-foreground">
                                <span>{{ $event->final_price }}</span>
                                <x-ui.icon name="riyal" class="w-4 h-4 inline-block" />
                            </div>
                        </div>
                    </div>
                @endif
            @else
                <div class="block w-full text-center bg-muted text-muted-foreground py-3 rounded-xl font-bold text-sm">
                    ✅ {{ __('events.labels.already_registered') }}
                </div>
            @endif
        @else
            <div class="block w-full text-center bg-destructive hover:bg-destructive/90 text-white py-3 rounded-xl font-bold text-sm">
                🔒 {{ __('events.labels.membership_required') }}
            </div>
        @endif
    </div>
</div>
