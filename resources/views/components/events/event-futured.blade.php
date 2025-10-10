<div
    class="relative overflow-hidden rounded-xl shadow-lg
            bg-gradient-to-br from-primary/10 via-background to-accent/10
            px-4 py-8 sm:px-2 sm:py-4 lg:px-8 flex flex-col lg:grid lg:grid-cols-3 gap-8 sm:gap-4
            transition-all duration-500 hover:shadow-primary/40 group">
    {{-- خلفية زخرفية متحركة --}}
    <div class="absolute inset-0 -z-10 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -left-40 w-96 h-96 bg-primary/20 blur-3xl rounded-full animate-pulse"></div>
        <div class="absolute -bottom-32 -right-32 w-72 h-72 bg-accent/30 blur-2xl rounded-full animate-spin-slow">
        </div>
        <div
            class="absolute top-1/2 left-1/2 w-[120%] h-[2px] bg-primary/40 from-transparent via-primary/40 to-transparent animate-move-x">
        </div>
    </div>

    {{-- العنوان والتاريخ والموقع --}}
    <div class="flex flex-col items-center lg:items-start text-center lg:text-left space-y-4 sm:space-y-2 col-span-2">
        <div
            class="relative overflow-hidden bg-primary/10 p-5 sm:p-2 rounded-2xl shadow-inner transition-transform duration-500 w-full
            before:absolute before:inset-0 before:bg-gradient-to-r before:from-transparent before:via-primary/20 dark:before:via-white/20 before:to-transparent
                   before:-translate-x-full group-hover:before:translate-x-full before:transition-transform before:duration-700
            ">
            <h3 class="text-2xl lg:text-2xl font-extrabold rtl:text-right text-primary drop-shadow">
                {{ $event->title }}
            </h3>
        </div>
        <p
            class="text-base md:text-base lg:text-xl text-muted-foreground leading-relaxed font-medium flex flex-wrap justify-center lg:justify-start gap-x-2">
            <span class="inline-flex items-center gap-1">
                <span class="text-xl md:text-lg lg:text-xl">🗓️</span>
                <span>{{ \Carbon\Carbon::parse($event->start_at)->translatedFormat('d F Y') }}</span>
            </span>
            {{-- clock --}}
            <span class="inline-flex items-center gap-1">
                <span class="text-xl md:text-lg lg:text-xl">⏰</span>
                <span>{{ \Carbon\Carbon::parse($event->start_at)->translatedFormat('h:i A') }}</span>
            </span>
            @if ($event->event_type->isVirtual())
                <span class="inline-flex items-center gap-1">
                    <span class="text-xl md:text-lg lg:text-xl">
                        <x-ui.icon :name="$event->event_method->icon()" class="size-6" />
                    </span>
                    <span>
                        {{ $event->event_method->label() }}
                    </span>
                </span>
            @else
                @if ($event->address)
                    <span class="inline-flex items-center gap-1">
                        <span class="text-xl md:text-lg lg:text-xl">
                            <x-ui.icon name="map-pin" class="size-6 fill-primary *:fill-primary" />
                        </span>
                        <span>{{ $event->address }}</span>
                    </span>
                @endif
            @endif
        </p>
    </div>

    {{-- العداد + الزر --}}
    <div
        class="flex flex-col items-center lg:items-end text-center lg:text-right space-y-6 sm:space-y-3 justify-center col-span-1">
        <div class="w-full flex justify-center lg:justify-end">
            <div class="w-full max-w-xs lg:scale-[85%] lg:text-sm">
                <x-events.countdown :date="$event->start_at" />
            </div>
        </div>
        <a href="#"
            class="relative px-8 sm:px-4 py-3 sm:py-2 font-bold text-base md:text-base lg:text-xl rounded-xl shadow-lg overflow-hidden
                   badget
                   group-hover:shadow-primary/50 hover:shadow-sm transition-all duration-500
                   before:absolute before:inset-0 before:bg-gradient-to-r before:from-transparent before:via-white/20 before:to-transparent
                   before:-translate-x-full group-hover:before:translate-x-full before:transition-transform before:duration-700
                   focus:outline-none focus:ring-2 focus:ring-primary
                   active:scale-95">
            {{ __('events.highlighted_event.register_now_button') }}
        </a>
    </div>
</div>
