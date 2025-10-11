
<div class="mb-8">
    <h2 class="text-2xl  w-full font-bold mb-8 text-foreground drop-shadow">
        {{ __('events.page_titles.upcoming_events') }}
    </h2>
    {{-- البطاقة العمودية: كل بطاقة فوق الأخرى --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-12 items-start auto-rows-fr">
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
