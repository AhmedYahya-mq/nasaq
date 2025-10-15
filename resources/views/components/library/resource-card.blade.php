<article
    class="group relative overflow-hidden rounded-xl bg-card border-0 shadow-md transition-all duration-300 hover:shadow-lg hover:-translate-y-1 p-6"
    itemscope itemtype="http://schema.org/Book">
    <header class="flex items-center justify-between mb-4 absolute z-10 top-4 right-4 left-4">
        {{-- Type Badge --}}
        <span style="--badget-color:{{ $resource->type->color() }}"
            class="px-3 py-1 gap-1 badget rounded-full text-xs flex items-center" itemprop="genre">
            <x-ui.icon :name="$resource->type->icon()" class="w-4 h-4" title="{{ $resource->type->label() }}" />
            <span>{{ $resource->type->label() }}</span>
        </span>
        {{-- New Badge and animation --}}
        <div class="badget badget-[#FF9500] px-3 py-1 text-center rounded-full text-xs flex items-center justify-center cursor-pointer"
            aria-label="New Resource">
            <span class="animate-pulse text-xs font-semibold">{{ __('library.new') }}</span>
        </div>
    </header>

    <figure class="w-full max-h-[261.33px] flex items-center justify-center rounded-md overflow-hidden shadow-md mb-2">
        <img src="{{ $resource->photo->url }}" alt="{{ $resource->title }} cover"
            class="aspect-square object-cover object-center hover:scale-105 transition-transform duration-200"
            itemprop="image" loading="lazy">
    </figure>

    <section class="mb-4">
        <h2 class="text-xl font-semibold text-foreground line-clamp-2 leading-tight mb-2 group-hover:text-primary transition-colors duration-200"
            itemprop="name">
            {{ $resource->title }}
        </h2>
        <p class="text-sm text-muted-foreground" itemprop="description">
            {{ $resource->description }}
        </p>
    </section>

    <section class="space-y-3">
        <div class="flex items-center gap-1.5 text-sm text-muted-foreground">
            <svg class="w-4 h-4 mr-2 text-muted-foreground/80" fill="currentColor" viewBox="0 0 24 24"
                aria-hidden="true">
                <path d="M3 3h18v18H3V3z"></path>
            </svg>
            <span class="font-medium" itemprop="author">
                <strong>{{ __('library.author') }}: </strong>
                {{ $resource->author }}
            </span>
        </div>
        <div class="flex items-center gap-1.5 text-sm text-muted-foreground">
            <svg class="w-4 h-4 mr-2 text-muted-foreground/80" fill="currentColor" viewBox="0 0 24 24"
                aria-hidden="true">
                <path d="M19 3H5c-1.1 0-2 .9-2 2v14h18V5c0-1.1-.9-2-2-2z"></path>
            </svg>
            <span itemprop="datePublished">
                <strong>{{ __('library.publish_date') }}: </strong>
                {{ $resource->published_at->locale(app()->getLocale())->translatedFormat('d F Y') }}
            </span>
        </div>
    </section>

    <footer class="flex items-center justify-between gap-2 mt-3">
        <div class="flex items-center gap-2">
            @if ($resource->isFree())
                <a href="{{ route('client.library.saved', [$resource]) }}"
                    class="badget size-8 text-center rounded-sm text-xs flex items-center justify-center cursor-pointer"
                    aria-label="Free Resource">
                    <x-ui.icon name="book-mark" class="size-6 fill-green-600" title="Free" />
                </a>
            @else
                <a href="{{ route('client.library.saved', [$resource]) }}"
                    class="badget size-8 text-center rounded-sm text-xs flex items-center justify-center cursor-pointer"
                    aria-label="Paid Resource">
                    <x-ui.icon name="credit-card" class="size-6 fill-primary" title="Paid" />
                </a>
            @endif
        </div>
        <div class="text-right">
            @if (!$resource->isFree())
                <div class="flex flex-col justify-center items-center">
                    @if ($resource->hasDiscount())
                        <div class="text-md font-bold text-primary line-through flex items-center gap-0.5 justify-end">
                            <span>{{ $resource->price }}</span>
                            <x-ui.icon name="riyal" class="w-3 h-3 inline fill-primary" title="Original Price" />
                        </div>
                    @endif
                    <div class="text-lg font-bold text-primary flex items-center gap-0.5 justify-end" itemprop="offers"
                        itemscope itemtype="http://schema.org/Offer">
                        <span itemprop="price">{{ $resource->final_price }}</span>
                        <x-ui.icon name="riyal" class="w-4 h-4 inline fill-primary" title="Final Price" />
                        <meta itemprop="priceCurrency" content="SAR" />
                    </div>
                </div>
            @else
                <div class="text-lg font-bold text-green-600 flex items-center justify-end">
                    <span>{{ __('library.free') }}</span>
                </div>
            @endif
        </div>
    </footer>
    {{-- Hover Accent --}}
    <div
        class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-primary to-purple-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
    </div>
    {{-- Structured Data --}}

</article>
