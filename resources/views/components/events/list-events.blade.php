<div class="mb-8">
    <h2 class="text-2xl  w-full font-bold mb-8 text-foreground drop-shadow">

        {{ $isOld ? __('events.page_titles.view_all_past') : __('events.page_titles.upcoming_events') }}
    </h2>
    {{-- البطاقة العمودية: كل بطاقة فوق الأخرى --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-12 items-start auto-rows-fr">
        @forelse ($events as $event)
            <x-events.card-event :event="$event" class="h-full" />
        @empty
            <p class="text-center text-muted-foreground col-span-full">
                {{ $isOld ? __('events.messages.no_events_past') : __('events.messages.no_upcoming_events') }}
            </p>
        @endforelse
    </div>

    {{ $isPaginated ? $events->links('pagination::tailwind') : '' }}
</div>
@push('seo')
    @if ($events && $events->isNotEmpty())
        @php
            $structuredData = [
                '@context' => 'https://schema.org',
                '@type' => 'ItemList',
                'name' => __('seo.events.title'),
                'description' => __('seo.events.description'),
                'itemListElement' => $events->map(function ($event, $index) {
                    return [
                        '@type' => 'ListItem',
                        'position' => $index + 1,
                        'url' => route('client.event.register', ['event' => $event]),
                        'item' => [
                            '@type' => 'Event',
                            'name' => $event->title,
                            'startDate' => $event->start_at->toIso8601String(),
                            'endDate' => $event->end_at?->toIso8601String(),
                            'location' => [
                                '@type' => 'Place',
                                'name' => $event->location_name ?? 'موقع الفعالية',
                                'address' => $event->address ?? '',
                            ],
                            'image' => $event->image ?? asset('favicon.ico'),
                            'offers' => [
                                '@type' => 'Offer',
                                'url' => route('client.event.register', $event),
                                'price' => $event->final_price ?? 0,
                                'priceCurrency' => 'SAR',
                                'availability' =>
                                    'https://schema.org/' .
                                    ($event->event_status->isUpcoming() ? 'InStock' : 'SoldOut'),
                            ],
                            'organizer' => [
                                '@type' => 'Organization',
                                'name' => __('seo.site_name'),
                                'url' => url('/'),
                            ],
                        ],
                    ];
                }),
            ];
        @endphp

        <script type="application/ld+json">
        {!! json_encode($structuredData, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT) !!}
    </script>
    @endif
@endpush
