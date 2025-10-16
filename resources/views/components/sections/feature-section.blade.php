<section id="feature">
    <div class="relative min-h-auto mt-20">
        <h2 class="text-center mb-20">{{ __('home.features.title') }}</h2>
        <div class="flex flex-col gap-36 w-full">

            @foreach(__('home.features.items') as $index => $feature)
                <div class="Seminars grid place-items-center place-content-center grid-cols-1 md:grid-cols-2 md:gap-14 gap-6">

                    {{-- الصورة على حسب الترتيب --}}
                    @if($index % 2 === 0)
                        {{-- النص أولاً ثم الصورة --}}
                        <div class="flex items-start gap-4 rtl:pr-6 ltr:pl-6 not-md:px-5">
                            <div class="flex flex-col justify-center">
                                <h3 class="text-2xl font-bold text-primary">{{ $feature['title'] }}</h3>
                                <div class="p-5">
                                    <p class="text-muted-foreground">{{ $feature['desc'] }}</p>
                                    <ul class="flex flex-col rtl:pr-5 ltr:pl-5 gap-3 mt-5 list-inside text-muted-foreground *:flex *:items-center *:gap-4">
                                        @foreach($feature['points'] as $point)
                                            <li>
                                                <i class="flex items-center justify-center p-3 shadow-lg rounded-full bg-card">
                                                    <x-ui.icon :name="$point['icon']" class="size-8 drop-shadow-lg text-primary *:!fill-primary" />
                                                </i>
                                                <span>{{ $point['text'] }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="md:p-7 not-md:px-5 flex justify-center items-center">
                              <img src="{{ asset($feature['image']) }}" alt="{{ $feature['title'] }} image"
                                class="w-full h-auto object-cover brightness-100 dark:!drop-shadow-[0_35px_35px_rgba(255,255,255,0.15)] drop-shadow-[0_35px_35px_rgba(0,0,0,0.30)]" loading="lazy" />
                        </div>
                    @else
                        {{-- الصورة أولاً ثم النص --}}
                        <div class="flex items-center justify-center h-full rtl:pr-6 ltr:pl-6 not-md:px-5">
                            <img src="{{ asset($feature['image']) }}" alt="{{ $feature['title'] }}"
                                class="w-full h-auto object-cover brightness-100 dark:!drop-shadow-[0_35px_35px_rgba(255,255,255,0.15)] drop-shadow-[0_35px_35px_rgba(0,0,0,0.3)]" />
                        </div>
                        <div class="flex items-start gap-4 not-md:px-5">
                            <div class="flex flex-col">
                                <h3 class="text-2xl font-bold text-primary">{{ $feature['title'] }}</h3>
                                <div class="p-5">
                                    <p class="text-muted-foreground">{{ $feature['desc'] }}</p>
                                    <ul class="flex flex-col rtl:pr-5 ltr:pl-5 gap-3 mt-5 list-inside text-muted-foreground *:flex *:items-center *:gap-4">
                                        @foreach($feature['points'] as $point)
                                            <li>
                                                <i class="flex items-center justify-center p-3 shadow-lg rounded-full bg-card">
                                                    <x-ui.icon :name="$point['icon']" class="size-8 drop-shadow-lg text-primary *:!fill-primary" />
                                                </i>
                                                <span>{{ $point['text'] }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif

                </div>
            @endforeach
        </div>
    </div>
</section>
