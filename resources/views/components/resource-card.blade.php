@php
    $publication = [
        'id' => '1',
        'title' => 'Introduction to Quantum Computing',
        'type' => 'book',
        'price' => 59.99,
        'currency' => 'USD',
        'publisher' => 'TechBooks Publishing',
        'publicationDate' => '2022-08-15',
        'authors' => ['Alice Smith', 'Bob Johnson'],
        'coverImage' => 'https://img.freepik.com/free-vector/gradient-ai-template-design_23-2150380016.jpg',
    ];
@endphp

<div
    class="group relative overflow-hidden rounded-xl bg-card border-0 shadow-md transition-all duration-300 hover:shadow-lg hover:-translate-y-1 cursor-pointer p-6">
    {{-- Header --}}
    <div class="flex items-center justify-between mb-4 absolute z-10 top-4 right-4 left-4">
        {{-- Type Badge --}}
        <span class="px-3 py-1 badget rounded-full text-xs flex items-center">
            @if ($publication['type'] === 'book')
                <svg class="w-3 h-3 mr-1.5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M19 2H9C7.9 2 7 2.9 7 4v16c0 1.1.9 2 2 2h10V2z"></path>
                </svg>
            @else
                <svg class="w-3 h-3 mr-1.5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M19 3H5c-1.1 0-2 .9-2 2v14l4-4h12c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2z"></path>
                </svg>
            @endif
            {{ $publication['type'] === 'book' ? 'Book' : 'Research Paper' }}
        </span>

        {{-- New Badge and animition --}}
        <div class="badget px-3 py-1 text-center rounded-full text-xs flex items-center justify-center cursor-pointer">
            <span class="animate-pulse text-xs font-semibold">New</span>
        </div>
    </div>

    {{-- Cover Image --}}
    @if (!empty($publication['coverImage']))
        <div
            class="w-full max-h-[261.33px] text-center rounded-md overflow-hidden shadow-md">
            <img src="{{ $publication['coverImage'] }}" alt="{{ $publication['title'] }} cover"
                class="aspect-square object-cover object-center hover:scale-105 transition-transform duration-200">
        </div>
    @endif


    {{-- Title & Authors --}}
    <div class="mb-4">
        <h3
            class="text-xl font-semibold text-foreground line-clamp-2 leading-tight mb-2 group-hover:text-primary transition-colors duration-200">
            {{ $publication['title'] }}
        </h3>
        <p class="text-sm text-muted-foreground">by {{ implode(', ', $publication['authors']) }}</p>
    </div>

    {{-- Publisher & Date --}}
    <div class="space-y-3 ">
        <div class="flex items-center text-sm text-muted-foreground">
            <svg class="w-4 h-4 mr-2 text-muted-foreground/80" fill="currentColor" viewBox="0 0 24 24">
                <path d="M3 3h18v18H3V3z"></path>
            </svg>
            <span class="font-medium">{{ $publication['publisher'] }}</span>
        </div>
        <div class="flex items-center text-sm text-muted-foreground">
            <svg class="w-4 h-4 mr-2 text-muted-foreground/80" fill="currentColor" viewBox="0 0 24 24">
                <path d="M19 3H5c-1.1 0-2 .9-2 2v14h18V5c0-1.1-.9-2-2-2z"></path>
            </svg>
            <span>{{ date('F d, Y', strtotime($publication['publicationDate'])) }}</span>
        </div>
    </div>
    <div class="flex items-center justify-between gap-2 mt-3">
        <div class="flex items-center gap-2">
            <div class="badget size-8 text-center rounded-sm text-xs flex items-center justify-center cursor-pointer">
                <x-ui.icon name="eye" class="inline size-4 fill-primary" />
            </div>
            <div class="badget size-8 text-center rounded-sm text-xs flex items-center justify-center cursor-pointer">
                <x-ui.icon name="download" class="size-6 fill-primary" />
            </div>
             <div class="badget size-8 text-center rounded-sm text-xs flex items-center justify-center cursor-pointer">
                <x-ui.icon name="credit-card" class="size-6 fill-primary" />
            </div>
        </div>
        <div class="text-right">
            <div class="text-lg font-bold text-primary flex items-center justify-end">
                <span>{{ number_format($publication['price'], 2) }}</span>
                <x-ui.icon name="riyal" class="w-4 h-4 inline fill-primary" />
            </div>
        </div>
    </div>
    {{-- Hover Accent --}}
    <div
        class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-primary to-purple-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
    </div>
</div>
