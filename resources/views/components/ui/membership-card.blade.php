{{-- @props([
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

        <div x-data="{ showAll: false }" class="relative p-6 flex flex-col flex-grow bg-white/70 backdrop-blur-sm rounded-2xl mt-4">
            <div class="absolute inset-0 -z-10">
                <img src="{{ asset($bgImage) }}" alt="" class="w-full h-full object-cover opacity-5 rounded-2xl">
            </div>

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

            <div class="mt-auto pt-6 border-t border-black/10 dark:border-white/10">
                <a href="#join" class="block w-full px-6 py-3 text-base font-semibold rounded-xl bg-primary text-accent-foreground hover:bg-primary/90 transition-all shadow-md hover:shadow-xl text-center">
                    {{ __('about.memberships.join_now') }}
                </a>
            </div>
        </div>
    </div>
</div> --}}





@props([
    'title' => 'Default Title',
    'desc' => 'Default description.',
    'price' => 0,
    'currency' => 'ر.س', // <-- إضافة: عملة قابلة للتخصيص
    'requirements' => [],
    'benefits' => [],
    'bgImage' => 'images/bg-pattern.svg', // <-- إضافة: خلفية SVG خفيفة
    'featured' => false,
    'actionUrl' => '#', // <-- إضافة: رابط مخصص لزر الانضمام
])

<div @class([
    'w-full max-w-md mx-auto rounded-2xl shadow-lg overflow-hidden flex flex-col h-full',
    'border-2 border-primary transform scale-105 shadow-primary/20 z-10' => $featured, // <-- تحسين: إضافة z-index للبطاقة المميزة
    'bg-card border border-border' => !$featured,
])>

    {{-- القسم العلوي: العنوان والسعر --}}
    <div class="p-2 text-center">
        @if ($featured)
            <div class="mb-2">
                <span
                    class="inline-block bg-primary text-primary-foreground text-lg font-bold px-4 py-1 rounded-full uppercase tracking-wider">
                    {{ __('memberships.most_popular', ['default' => 'الأكثر شيوعًا']) }}
                </span>
            </div>
        @endif

        <h3 class="text-lg text-foreground">{{ $title }}</h3>
        <p class="text-sm text-muted-foreground mt-2 min-h-[40px]">{{ $desc }}</p>

        <div class="my-2">
            <div class="text-xl font-bold text-primary flex items-center justify-center gap-1">
                <span>{{ $price }}</span>
                <x-ui.icon name="riyal" class="w-5 h-5 inline fill-primary" />
            </div>
            <div class=" text-xs text-muted-foreground">
                {{ __('about.memberships.billing_cycle') }}
            </div>
        </div>
    </div>

    {{-- القسم السفلي: المزايا والمتطلبات --}}
    <div x-data="{ showAllBenefits: false }" class="p-6 flex flex-col flex-grow bg-muted/30 rounded-t-2xl border-t border-border">
        {{-- المتطلبات --}}
        @if (!empty($requirements))
            <div class="mb-6">
                <h4 class="font-semibold text-foreground mb-3">{{ __('about.memberships.requirements_title') }}</h4>
                <ul class="space-y-2.5 text-sm text-muted-foreground">
                    @foreach ($requirements as $req)
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 mt-0.5 text-amber-500 shrink-0" fill="none" viewBox="0 0 24 24"
                                stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                            </svg>
                            <span>{{ $req }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- المزايا --}}
        @if (!empty($benefits))
            <div class="mb-6">
                <h4 class="font-semibold text-foreground mb-3">{{ __('about.memberships.benefits_title') }}</h4>
                <ul class="space-y-2.5 text-sm text-foreground">
                    @foreach ($benefits as $index => $benefit)
                        <li class="flex items-start gap-3" x-show="showAllBenefits || {{ $index }} < 4"
                            {{-- <-- تحسين: عرض 4 مزايا بدلاً من 3 --}} x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 transform -translate-y-2"
                            x-transition:enter-end="opacity-100 transform translate-y-0">
                            <svg class="w-5 h-5 mt-0.5 text-green-500 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span>{{ $benefit }}</span>
                        </li>
                    @endforeach
                </ul>

                @if (count($benefits) > 4)
                    <button @click="showAllBenefits = !showAllBenefits"
                        class="mt-4 text-sm font-semibold text-primary hover:underline flex items-center gap-1">
                        <span
                            x-show="!showAllBenefits">{{ __('memberships.read_more', ['default' => 'عرض كل المزايا']) }}</span>
                        <span
                            x-show="showAllBenefits">{{ __('memberships.show_less', ['default' => 'إظهار أقل']) }}</span>
                        <svg x-bind:class="{ 'rotate-180': showAllBenefits }" class="w-4 h-4 transition-transform"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                @endif
            </div>
        @endif

        {{-- زر الانضمام --}}
        <div class="mt-auto pt-6">
            <a href="{{ route('client.pay.index', ['type' => 'membership', 'id' => 22]) }}" @class([
                'block w-full px-6 py-3 text-base font-semibold rounded-lg text-center transition-all duration-300',
                'bg-primary text-primary-foreground hover:bg-primary/90 shadow-lg hover:shadow-primary/40' => $featured,
                'bg-accent text-accent-foreground hover:bg-accent/80' => !$featured,
            ])>
                {{ __('about.memberships.join_now') }}
            </a>
        </div>
    </div>
</div>
