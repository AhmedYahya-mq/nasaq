@props([
    'title' => 'Default Title',
    'desc' => 'Default description.',
    'price' => 0,
    'requirements' => [],
    'benefits' => [],
    'bgImage' => 'images/bgcard.png',
    'featured' => false,
])

<div @class([
    'w-full max-w-xl mx-auto',
    'rounded-2xl shadow-lg overflow-hidden flex flex-col h-full group transition-all duration-300',
    'border-2 border-primary scale-105 shadow-primary/20' => $featured,
    'border border-transparent' => !$featured,
])>

    {{-- القسم العلوي --}}
    <div class="relative p-6 text-white text-center bg-primary">
        <div class="relative z-10">
            <h3 class="text-2xl font-bold">{{ $title }}</h3>
            <p class="text-sm mt-2 min-h-[40px]">{{ $desc }}</p>
            <div class="my-4">
                <div class="text-4xl font-bold">
                    <span>${{ $price }}</span>
                </div>
                <div class="mt-2 inline-block bg-black/20 text-xs font-medium px-4 py-1 rounded-full text-white">
                    {{ __('about.memberships.billing_cycle') }}
                </div>
            </div>
        </div>

        {{-- البطاقة الداخلية --}}
        <div x-data="{ showAll: false }" class="relative p-6 flex flex-col flex-grow bg-white/70 backdrop-blur-sm rounded-2xl mt-4">
            <div class="absolute inset-0 -z-10">
                <img src="{{ asset($bgImage) }}" alt="" class="w-full h-full object-cover opacity-5 rounded-2xl">
            </div>

            {{-- المتطلبات (دائمًا مفتوحة) --}}
            @if (!empty($requirements))
                <div class="mb-5 text-start">
                    <h4 class="text-base text-primary mb-3">{{ __('about.memberships.requirements_title') }}</h4>
                    <ul class="space-y-2 text-sm text-black">
                        @foreach ($requirements as $req)
                            <li class="flex items-start gap-3">
                                <span class="w-5 h-5 mt-0.5 flex items-center justify-center bg-primary/20 text-primary rounded-full shrink-0 text-[10px]">✓</span>
                                <span class="flex-1">{{ $req }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- المزايا (مع قراءة المزيد) --}}
            @if (!empty($benefits))
                <div class="mb-6 text-start">
                    <h4 class="text-base text-primary mb-3">{{ __('about.memberships.benefits_title') }}</h4>
                    <ul class="space-y-2 text-sm text-black">
                        @foreach ($benefits as $index => $benefit)
                            <li
                                class="flex items-start gap-3"
                                x-show="showAll || {{ $index }} < 3"
                            >
                                <span class="w-5 h-5 mt-0.5 flex items-center justify-center bg-primary text-white rounded-full shrink-0 text-[10px]">✓</span>
                                <span class="flex-1">{{ $benefit }}</span>
                            </li>
                        @endforeach
                    </ul>

                    {{-- زر قراءة المزيد --}}
                    @if (count($benefits) > 3)
                        <button
                            @click="showAll = !showAll"
                            class="mt-3 text-sm font-medium text-primary hover:underline"
                        >
                            <span x-show="!showAll">{{ __('قراءة المزيد') }}</span>
                            <span x-show="showAll">{{ __('إظهار أقل') }}</span>
                        </button>
                    @endif
                </div>
            @endif

            {{-- زر الانضمام --}}
            <div class="mt-auto pt-6 border-t border-black/10 dark:border-white/10">
                <a href="#join" class="block w-full px-6 py-3 text-base font-semibold rounded-xl bg-primary text-accent-foreground hover:bg-primary/90 transition-all shadow-md hover:shadow-xl text-center">
                    {{ __('about.memberships.join_now') }}
                </a>
            </div>
        </div>
    </div>
</div>
