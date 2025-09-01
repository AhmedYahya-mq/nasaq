
@props([
    'title' => __('library.default_title'),
    'description' => __('library.default_description'),
    'typeText' => __('library.default_type'),
    'author' => __('library.default_author'),
    'publishDate' => __('library.default_publish_date'),
    'thumbnail' => 'https://via.placeholder.com/400x250',
    'price' => __('library.free' ),
    'isPaid' => false,
    'downloadUrl' => '#',
])


<div {{ $attributes->merge(['class' => 'card group relative flex flex-col overflow-hidden border border-border/50 transition-all duration-300 ease-in-out hover:shadow-2xl hover:border-primary/30']) }}>


    <div class="relative h-70 w-full">
        <img src="{{ $thumbnail }}" alt="{{ $title }}" class="h-full w-full rounded-lg object-cover transition-transform duration-500 group-hover:scale-110" />
        <div class="absolute top-4 left-4">
            <span class="bg-card/80 text-foreground text-xs font-bold px-4 py-2 rounded-lg backdrop-blur-sm border border-border/50 shadow-md">
                {{ $typeText }}
            </span>
        </div>
    </div>

    <div class="p-5 flex-grow">
        <h3 class="text-lg font-bold text-foreground transition-colors group-hover:text-primary">
            {{ $title }}
        </h3>

        <div class="mt-2 flex items-center gap-x-4 text-xs text-muted-foreground">
            <div class="flex-center gap-x-1.5">
                <x-ui.icon name="user" class="h-4 w-4" />
                <span>{{ $author }}</span>
            </div>
            <div class="flex-center gap-x-1.5">
                <x-ui.icon name="calendar" class="h-4 w-4" />
                <span>{{ $publishDate }}</span>
            </div>
        </div>

        <p class="mt-4 text-sm text-muted-foreground line-clamp-2 min-h-[40px]">
            {{ $description }}
        </p>
    </div>

    <div class="mt-auto border-t border-border/50 p-5">
        <div class="flex items-center justify-between">
            <span class="text-lg font-extrabold text-primary">{{ $price }}</span>

            <a href="{{ $downloadUrl }}" class="px-5 py-2 bg-primary text-primary-foreground text-sm font-semibold rounded-lg hover:bg-primary/90 transition-colors flex-center gap-x-2">

                @if ($isPaid)
                    <x-ui.icon name="buy" class="h-4 w-4" />
                    <span>{{ __('library.buy_button') }}</span>
                @else
                    <x-ui.icon name="download" class="h-4 w-4" />
                    <span>{{ __('library.download_button') }}</span>
                @endif
            </a>
        </div>
    </div>
</div>
