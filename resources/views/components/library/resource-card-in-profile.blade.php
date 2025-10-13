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
        @if ($resource->isPay(auth()->id()))
      
            <div class="flex flex-col w-full" x-data="downloadResource(true, '{{ $resource->ulid }}', '{{ $resource->title }}')">
                <button x-show="!isLoading && !isComplete && !errorMessage" x-on:click="startDownload()"
                    class="badget-70 badget gap-1 w-full h-10  text-center rounded-sm text-xs flex items-center justify-center cursor-pointer"
                    aria-label="Free Resource">
                    <x-ui.icon name="download" class="size-6 fill-green-600" title="download" />
                    <span class="font-medium text-green-600">{{ __('library.download_button') }}</span>
                </button>
                <div x-show="isLoading" class="flex flex-col items-center justify-center w-full h-10">
                    <div class="flex w-full justify-between items-center gap-2 mb-2">
                        <p class="text-sm text-muted-foreground ">جاري التحميل...</p>
                        <span class="text-sm text-muted-foreground">
                            <span x-text="precent"></span>
                            %
                        </span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                        <div class="bg-primary h-2.5 rounded-full animate-pulse" :style="{ width: precent + '%' }">
                        </div>
                    </div>
                </div>
                {{-- isComplete --}}
                <button x-show="isComplete" disabled
                    class="badget-70 badget gap-1 w-full h-10 text-center rounded-sm text-xs flex items-center justify-center cursor-not-allowed"
                    aria-label="Completed">
                    <x-ui.icon name="check-circle" class="size-6 fill-green-600" title="completed" />
                    <span class="font-medium text-green-600">{{ __('library.downloaded') }}</span>
                </button>
                {{-- error --}}
                <div x-show="errorMessage" class="mt-2 text-sm text-red-600 text-center text-wrap"
                    x-text="errorMessage"></div>
            </div>
        @else
            <div class="flex flex-col w-full">
                {{-- price --}}
                <div class="flex justify-center items-center">
                    @if ($resource->hasDiscount())
                        <div class="text-sm font-bold text-primary line-through flex items-center gap-0.5 justify-end">
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
                {{-- Pay Button --}}
                <a href="{{ route('client.library.saved', [$resource]) }}"
                    class="badget-70 badget gap-1 w-full h-10 text-center rounded-sm text-xs flex items-center justify-center cursor-pointer"
                    aria-label="Free Resource">
                    <x-ui.icon name="credit-card" class="size-6 fill-green-600" title="download" />
                    <span class="font-medium text-green-600">{{ __('payments.Pay') }}</span>
                </a>
            </div>
        @endif

    </footer>
    <div
        class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-primary to-purple-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
    </div>
</article>
