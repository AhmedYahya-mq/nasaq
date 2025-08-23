@props([
    'title' => 'Default Title',
    'desc' => 'Default description.',
    'price' => 0,
    'requirements' => [],
    'benefits' => [],
])

<div class="group w-full max-w-sm mx-auto rounded-2xl p-6 text-white  font-sans bg-primary transition-all duration-300 hover:-translate-y-2 hover:shadow-xl h-full flex flex-col">

    {{-- المحتوى العلوي (داخل الجزء الأخضر) --}}
    <div class="flex-shrink-0 text-center ">
        <h3 class="text-3xl font-bold">{{ $title }}</h3>
        <p class="text-base mt-2 max-w-xs mx-auto text-white/90 min-h-[45px]">{{ $desc }}</p>


        <div class="my-5">
            {{-- السعر --}}
            <div class="text-4xl font-bold">
                <span>${{ $price }}</span>
            </div>
            <div class="mt-2 inline-block bg-primary-600 text-xs font-medium shadow-lg  px-4 py-1 rounded-full text-white">
                {{ __('about.memberships.billing_cycle') }}
            </div>
        </div>
    </div>


    <div class="bg-white w-full rounded-2xl p-6 text-gray-700 flex flex-col flex-grow mt-4">

        {{-- المتطلبات --}}
        @if (!empty($requirements))
            <div class="mb-5 text-start">
                <h4 class="text-base font-semibold text-gray-800 mb-3">
                    {{ __('about.memberships.requirements_title') }}
                </h4>
                <ul class="space-y-2 text-sm text-muted-foreground">
                    @foreach ($requirements as $req)
                        <li class="flex items-start gap-3">
                            <span
                                class="w-5 h-5 mt-0.5 flex items-center justify-center bg-primary/20 text-primary rounded-full shrink-0 text-[10px]">✓</span>
                            <span>{{ $req }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- المزايا --}}
        @if (!empty($benefits))
            <div class="mb-6 text-start">
                <h4 class="text-base font-semibold text-gray-800 mb-3">
                    {{ __('about.memberships.benefits_title') }}
                </h4>
                <ul class="space-y-2 text-sm text-muted-foreground">
                    @foreach ($benefits as $benefit)
                        <li class="flex items-start gap-3">
                            <span
                                class="w-5 h-5 mt-0.5 flex  bg-primary text-white rounded-full shrink-0 text-[10px]">✓</span>
                            <span>{{ $benefit }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- زر الانضمام (في الأسفل دائمًا) --}}
        <div class="mt-auto pt-6 border-t">
            <a href="#join"
                class="block w-full px-6 py-3 text-base font-semibold rounded-xl bg-primary text-accent-foreground hover:bg-primary/90 transition-all shadow-md hover:shadow-xl text-center">
                {{ __('about.memberships.join_now') }}
            </a>
        </div>
    </div>
</div>
