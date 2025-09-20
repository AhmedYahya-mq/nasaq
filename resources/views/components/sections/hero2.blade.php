<section id="hero">
    <div
        class="relative overflow-hidden grid grid-cols-1 place-items-start place-content-center gap-4 p-4 h-[400px] not-lg:place-items-center dark:bg-primary-foreground bg-primary">
        <div
            class="aspect-video rtl:clip-path-circle-right ltr:clip-path-circle-left bg-[url('http://127.0.0.1:8000/images/hero.svg')] bg-size-[70px] absolute end-0 inset-y-0 hidden lg:block lg:w-[450px]">
            <img src="{{ asset('images/about.png') }}"
                class="object-cover absolute end-0 rtl:clip-path-ellipse-right ltr:clip-path-ellipse-left"
                style="block-size: 100%" alt="Hero Image">
        </div>
        <div class="text-white">
            <h2 class="font-bold text-center lg:text-start text-lg md:text-xl lg:text-2xl ">
                {{ __('home.hero.title') }}
            </h2>
            <p class="text-lg text-center lg:text-start  max-w-2xl">
                {{ __('home.hero.description') }}
            </p>
        </div>
    </div>
</section>
