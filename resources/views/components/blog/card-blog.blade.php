<article class="relative w-auto h-auto bg-card aspect-[3/2]" role="article" aria-label="{{ $blog->title }}">
    <img src="{{ $photo->url ?? asset('images/placeholder.png') }}" alt="{{ $blog->title }} - {{ $blog->excerpt }}" class="aspect-[3/2] object-cover rounded-lg" loading="lazy">
    <div
        class="p-4 absolute bottom-0 left-1/2 bg-card h-[156px] w-[90%] rounded-2xl -translate-x-1/2 translate-y-1/2 shadow-lg"
        aria-describedby="blog-excerpt-{{ $blog->id }}">
        <h2 class="text-md font-semibold mb-2">
            <a href="{{ route('client.blog.details', ['blog'=>$blog]) }}" class="hover:underline text-primary" tabindex="0">
                {{ $blog->title }}
            </a>
        </h2>
        <p id="blog-excerpt-{{ $blog->id }}" class="text-sm text-muted-foreground mb-4 min-[300px]:line-clamp-2 line-clamp-1 ">
            {{ $blog->excerpt }}
        </p>
        <a href="{{ route('client.blog.details', ['blog'=>$blog]) }}"
            class="text-primary font-medium hover:underline absolute bottom-2 left-1/2 -translate-1/2 grid gap-0.5
                grid-cols-[auto_auto] place-items-center"
            aria-label="{{ __('blog.read_more') }}: {{ $blog->title }}"
            tabindex="0">
            <x-ui.icon name="arrow-long-right" class="size-5 ltr:order-2" />
            <span>{{ __('blog.read_more') }}</span>
        </a>
    </div>
</article>
