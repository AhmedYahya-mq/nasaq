@props(['event', 'isRegistration' => false])

@php
    $color = $event->event_category->color();
    $date = $event->start_at->locale(app()->getLocale())->translatedFormat('d F Y');
    $time = $event->start_at->setTimezone('Asia/Riyadh')->translatedFormat('h:i A');

@endphp

<div {{ $attributes->merge([
    'class' => 'relative flex flex-col w-full bg-card p-6 rounded-2xl border-l-4 border transition-all duration-300',
]) }}
    style="border-color: {{ $color }};">
    <!-- العنوان والشارة -->
    <div class="flex items-center justify-between gap-3 mb-3">
        <h4 class="font-bold text-foreground text-xl leading-snug truncate">{{ $event->title }}</h4>
        <span class="text-xs font-semibold px-3 py-1 rounded-full border backdrop-blur-sm whitespace-nowrap"
            style="background-color: {{ $color }}20; border-color: {{ $color }}80; color: {{ $color }};">
            {{ $event->event_category->label() }}
        </span>
    </div>

    <div class="flex h-full items-end gap-1">
        <!-- التاريخ والوقت -->
        <div class="flex-1">
            <div class="flex flex-wrap items-center gap-4 text-sm text-muted-foreground mb-3">
                <div class="flex items-center gap-2" style="color: {{ $color }}">
                    <x-ui.icon name="calendar" class="w-4 h-4" />
                    <span class="font-semibold text-muted-foreground">{{ $date }}</span>
                </div>

                <div class="flex items-center gap-2" style="color: {{ $color }}">
                    <x-ui.icon name="hour" class="w-4 h-4" />
                    <span class="font-semibold text-muted-foreground">{{ $time }}</span>
                </div>
            </div>

            <!-- الموقع فقط إذا حضوري -->
            @if ($event->event_type->isPhysical())
                <div class="flex items-center gap-2 text-sm text-muted-foreground mb-4"
                    style="color: {{ $color }}">
                    <x-ui.icon name="map-pin" class="size-4" />
                    <span class="font-semibold line-clamp-2 text-muted-foreground">{{ $event->address }}</span>
                </div>
            @endif
        </div>

        <div class="flex flex-col items-end gap-2">
            @if ($event->hasStarted())
                <a href="{{ route('client.event.open', [$event]) }}" target="_blank" rel="noopener"
                    class="text-sm font-semibold px-1 py-1 rounded-sm border backdrop-blur-sm whitespace-nowrap"
                    style="background-color: {{ $color }}20; border-color: {{ $color }}80; color: {{ $color }};">
                    <x-ui.icon name="arrow-up-square" class="size-6 inline-block mr-1" />
                </a>
            @elseif($event->event_status->isCompleted())
                <span class="text-xs font-semibold px-3 py-1 rounded-full border backdrop-blur-sm whitespace-nowrap"
                    style="background-color: {{ $color }}20; border-color: {{ $color }}80; color: {{ $color }};">
                    منتهي
                </span>
            @else
                <span class="text-xs font-semibold px-3 py-1 rounded-full border backdrop-blur-sm whitespace-nowrap"
                    style="background-color: {{ $color }}20; border-color: {{ $color }}80; color: {{ $color }};">
                    قادم
                </span>
            @endif
        </div>
    </div>
</div>
