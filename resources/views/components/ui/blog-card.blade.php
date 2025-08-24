<div class="relative w-auto h-auto bg-card aspect-[3/2]">
    <img src="{{ asset('images/seminar-1.webp') }}" alt="blog" class="aspect-[3/2] object-cover rounded-lg">
    <div
        class="p-4 absolute bottom-0 left-1/2 bg-card h-[156px] w-[90%] rounded-2xl -translate-x-1/2 translate-y-1/2 shadow-lg">
        <h3 class="text-md font-semibold mb-2">{{ $title }}</h3>
        <p class="text-sm text-muted-foreground mb-4 min-[300px]:line-clamp-2 line-clamp-1 ">{{ $excerpt }}</p>
        <a href="/"
            class="text-primary font-medium hover:underline absolute bottom-2 left-1/2 -translate-1/2 grid gap-0.5
                grid-cols-[auto_auto] place-items-center">
            <x-ui.icon name="arrow-long-right" class="size-5 ltr:order-2" />
            <span>اقرأ المزيد</span>
        </a>
    </div>
</div>
