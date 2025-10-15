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
                <div class="flex flex-col justify-start">
                    <h3 class="text-2xl font-bold text-primary counter" data-counter-end="{{ $count_members }}"></h3>
                    <p class="text-muted-foreground text-animetion">
                        {{ __('home.numbers.item1_label') }}
                    </p>
                </div>
                <div class="flex flex-col justify-start">
                    <h3 class="text-2xl font-bold text-primary counter" data-counter-end="{{ $count_library }}"></h3>
                    <p class="text-muted-foreground text-animetion">
                        {{ __('home.numbers.item2_label') }}
                    </p>
                </div>
                <div class="flex flex-col justify-start">
                    <h3 class="text-2xl font-bold text-primary counter" data-counter-end="{{ $count_meetings }}"></h3>
                    <p class="text-muted-foreground text-animetion">
                        {{ __('home.numbers.item3_label') }}
                    </p>
                </div>
                <div class="flex flex-col justify-start">
                    <h3 class="text-2xl font-bold text-primary counter" data-counter-end="{{ $count_webinars }}"></h3>
                    <p class="text-muted-foreground text-animetion">
                        {{ __('home.numbers.item4_label') }}
                    </p>
                </div>

            </div>
        </div>
    </div>
</section>
