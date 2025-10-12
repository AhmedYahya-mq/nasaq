<div class="@container w-full">
    {{-- البطاقة العمودية: كل بطاقة فوق الأخرى --}}
    <div class="grid grid-cols-1 @lg:grid-cols-2 gap-4 mb-12 items-start auto-rows-fr">
        @forelse ($events as $event)
            <x-events.card-event :event="$event" class="h-full" />
        @empty
            <p class="text-center text-muted-foreground col-span-full">
                {{ __('events.messages.no_upcoming_events') }}
            </p>
        @endforelse
    </div>

    {{ $events->links('pagination::tailwind') }}
</div>
