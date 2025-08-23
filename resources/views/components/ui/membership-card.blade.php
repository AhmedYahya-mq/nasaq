{{-- @props([
    'title' => 'Default Title',
    'desc' => 'Default description.',
    'price' => 0,
    'requirements' => [],
    'benefits' => [],
])

<div class="group w-full max-w-sm mx-auto rounded-2xl p-6 text-white  font-sans bg-primary transition-all duration-300 hover:-translate-y-2 hover:shadow-xl h-full flex flex-col">

    <div class="flex-shrink-0 text-center ">
        <h3 class="text-3xl font-bold">{{ $title }}</h3>
        <p class="text-base mt-2 max-w-xs mx-auto text-white/90 min-h-[45px]">{{ $desc }}</p>


        <div class="my-5">
            <div class="text-4xl font-bold">
                <span>${{ $price }}</span>
            </div>
            <div class="mt-2 inline-block bg-primary-600 text-xs font-medium shadow-lg  px-4 py-1 rounded-full text-white">
                {{ __('about.memberships.billing_cycle') }}
            </div>
        </div>
    </div>


    <div class="bg-white w-full rounded-2xl p-6 text-gray-700 flex flex-col flex-grow mt-4">

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

        <div class="mt-auto pt-6 border-t">
            <a href="#join"
                class="block w-full px-6 py-3 text-base font-semibold rounded-xl bg-primary text-accent-foreground hover:bg-primary/90 transition-all shadow-md hover:shadow-xl text-center">
                {{ __('about.memberships.join_now') }}
            </a>
        </div>
    </div>
</div> --}}

@props([
    'title' => 'Default Title',
    'desc' => 'Default description for this membership card.',
    'requirements' => [],
    'benefits' => [],
    'price' => 0,
    'originalPrice' => 0,
    'discount' => 0,
    'bgImage' => 'images/bgcard.png',
])

<div class="relative  rounded-2xl p-6 sm:p-8 backdrop-blur-xl border shadow-xl overflow-hidden group hover:shadow-2xl transition-all duration-500 h-[520px] flex flex-col m-0 ">

    {{-- الخلفية --}}
    <div class="absolute inset-0 bg-primary/10">
        <img src="{{ asset($bgImage) }}" alt="Background" class="w-full h-full object-cover opacity-20">
        <div class="absolute inset-0 "></div>
    </div>

  {{-- @if($discount > 0)
    <div class="absolute top-4 z-20">
        <div class="px-2.5 py-1 rounded-full bg-gradient-to-r from-pink-500 to-red-500 text-white text-xs font-bold shadow-lg" dir="ltr">
            -{{ $discount }}%
        </div>
    </div>
@endif --}}

    {{-- المحتوى --}}
    <div class="relative z-10 flex flex-col flex-1">

        {{-- العنوان --}}
        <h3 class="text-xl sm:text-2xl font-bold text-primary text-center mb-2">{{ $title }}</h3>

        {{-- الوصف --}}
        <p class="text-muted-foreground text-xs sm:text-sm text-center leading-relaxed mb-4">
            {{ $desc }}
        </p>

        {{-- المتطلبات --}}
        @if(!empty($requirements))
            <h4 class="text-xs sm:text-sm font-semibold text-primary mb-2">
                {{ app()->getLocale() === 'ar' ? 'المتطلبات' : 'Requirements' }}
            </h4>
            <ul class="space-y-2 text-xs sm:text-sm mb-3">
                @foreach($requirements as $req)
                    <li class="flex items-start gap-2">
                        <span class="w-5 h-5 flex items-center justify-center bg-primary text-white rounded-full shrink-0 text-[10px]">✓</span>
                        <span>{{ $req }}</span>
                    </li>
                @endforeach
            </ul>
        @endif

        {{-- المزايا --}}
        @if(!empty($benefits))
            <h4 class="text-xs sm:text-sm font-semibold text-primary mb-2">
                {{ app()->getLocale() === 'ar' ? 'المزايا' : 'Benefits' }}
            </h4>
            <ul class="space-y-2 text-xs sm:text-sm mb-4">
                @foreach($benefits as $benefit)
                    <li class="flex items-start gap-2">
                        <span class="w-5 h-5 flex items-center justify-center bg-primary text-white rounded-full shrink-0 text-[10px]">✓</span>
                        <span>{{ $benefit }}</span>
                    </li>
                @endforeach
            </ul>
        @endif

        {{-- الأسعار --}}
        <div class="flex items-center justify-center gap-2 sm:gap-3 mb-4">
            <span class="text-2xl sm:text-3xl font-extrabold text-primary">${{ $price }}</span>
            @if($originalPrice > $price)
                <span class="text-xs sm:text-sm text-gray-400 line-through decoration-red-500 decoration-2">${{ $originalPrice }}</span>
            @endif
        </div>

        {{-- زر الانضمام --}}
        <a href="#memberships"
           class="px-5 sm:px-6 py-2.5 sm:py-3 text-sm sm:text-base font-semibold rounded-xl bg-primary text-accent-foreground hover:bg-primary/90 transition-all shadow-md hover:shadow-xl text-center mt-auto">
            {{ app()->getLocale() === 'ar' ? 'انضم الآن' : 'Join Now' }}
        </a>
    </div>
</div>
