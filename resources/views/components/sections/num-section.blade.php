<section id="num">
    <div class="bg-primary/10 p-9 grid md:grid-cols-2 grid-cols-1 gap-5">
        <div>
            <h2 class="text-2xl text-primary font-semibold text-animetion">
                {{ __('home.numbers.title') }}
            </h2>
            <p class="text-justify text-muted-foreground mt-4 px-4 text-normal-animation">
                {{ __('home.numbers.desc') }}
            </p>
        </div>
        <div class="@container">
            <div class="grid grid-cols-1 not-sm:@min-[335px]:grid-cols-2 @min-[400px]:grid-cols-2 gap-9">

                @foreach(__('home.numbers.items') as $item)
                    <div class="flex items-center justify-center gap-x-4">
                        @if($loop->index === 0)
                            <x-icons.users class="size-7 text-primary *:!fill-primary" />
                        @elseif($loop->index === 1)
                            <x-icons.library class="size-7 text-primary *:!fill-primary" />
                        @elseif($loop->index === 2)
                            <x-icons.calendar class="size-7 text-primary *:!fill-primary" />
                        @elseif($loop->index === 3)
                            <x-icons.megaphone class="size-7 text-primary *:!fill-primary" />
                        @endif

                        <div class="flex flex-col justify-start">
                            <h3 class="text-2xl font-bold text-primary counter"
                                data-counter-end="{{ $item['count'] }}">
                            </h3>
                            <p class="text-muted-foreground text-animetion">
                                {{ $item['label'] }}
                            </p>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
</section>
