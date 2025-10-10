<div
    {{ $attributes->merge(['class' => 'relative flex flex-col w-full h-full max-w-full bg-card p-6 rounded-2xl border-l-4 shadow-xl hover:shadow-primary/30 transition-all duration-300']) }}
    style="border-color: {{ $event->event_category->color() }};"
    >
    <div class="flex items-center justify-between gap-3 mb-2">
        <h4 class="font-bold text-foreground text-xl leading-snug">{{ $event->title }}</h4>
        @if ($event->event_type->isVirtual())
            <span style=" --badget-color: {{ $event->event_method->color() }};"
                class="text-sm badget-70 px-2 py-1 rounded-full">
                {{ $event->event_method->label() }}
            </span>
        @else
            <span style=" --badget-color: {{ $event->event_category->color() }};"
                class="text-sm badget-70 px-2 py-1 rounded-full">
                {{ $event->event_category->label() }}
            </span>
        @endif
    </div>
    <div>
        <div class="flex flex-row flex-wrap gap-4 text-sm text-muted-foreground">
            <div class="flex items-center gap-2">
                <x-ui.icon name="calendar" class="w-4 h-4 text-primary" />
                <span
                    class="font-semibold">{{ $event->start_at->locale(app()->getLocale())->translatedFormat('d F Y') }}</span>
            </div>
            <div class="flex items-center gap-2">
                <x-ui.icon name="hour" class="w-4 h-4 text-primary" />
                <span
                    class="font-semibold">{{ $event->start_at->locale(app()->getLocale())->translatedFormat('h:i A') }}</span>
            </div>
            @if ($event->event_type->isPhysical())
                <div class="flex items-center gap-2 py-2">
                    <x-ui.icon name="map-pin" class="w-5 h-5 text-primary" />
                    <span class="font-semibold">{{ $event->address }}</span>
                </div>
            @endif
        </div>
    </div>
    <div>
        <p class="text-sm text-muted-foreground mt-1 line-clamp-3">
            {{ $event->description }}
        </p>
    </div>
    <div class="mt-3">
        @if ($event->isFree())
        <div class="flex justify-between items-end gap-2">
            <a href="#" class="px-2 py-1 text-sm rounded-lg font-semibold transition-all duration-300 badget">
                {{ __('events.buttons.free_registration') }}
            </a>
            <span class="font-bold text-sm">{{ __('events.labels.free') }}</span>
        </div>
        @else
            <div class="flex justify-between items-center gap-2">
                <a href="{{ $event->registration_url }}" target="_blank"
                    class="px-2 py-1 rounded-lg font-semibold transition-all duration-300 badget">
                    {{ __('events.buttons.pay_registration') }}
                </a>
                <div class="flex flex-col items-end">
                    {{-- عرض السعر الأصلي إذا كان هناك خصم --}}
                    @if ($event->isDiscounted())
                        <span class="font-bold mt-1.5 text-sm flex gap-1 line-through text-muted-foreground">
                            <span>{{ $event->price }}</span>
                            <x-ui.icon name="riyal" class="size-5 fill-muted-foreground"/>
                        </span>
                    @endif
                    <span class="font-bold text-md flex gap-1"><span>{{ $event->final_price }}</span> <x-ui.icon name="riyal" class="size-5 fill-primary"/> </span>
                </div>
            </div>
        @endif
    </div>
</div>
