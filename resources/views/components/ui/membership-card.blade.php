{{--
  مسار الملف: resources/views/components/ui/membership-card.blade.php
  الكود النهائي الذي يلتزم بتصميمك 100% ويضيف الأكورديون فقط.
--}}

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
    'max-w-md mx-auto',
    'rounded-2xl shadow-lg overflow-hidden flex flex-col h-full group transition-all duration-300',
    'border-2 border-primary scale-105 shadow-primary/20' => $featured,
    'border border-transparent' => !$featured,
])>

    {{-- 1. القسم العلوي (لم يتغير) --}}
    <div class="relative p-6 text-white text-center bg-primary">
        <div class="relative z-10">
            <h3 class="text-2xl font-bold">{{ $title }}</h3>
            <p class="text-sm mt-2  min-h-[40px]">{{ $desc }}</p>
            <div class="my-4">
                <div class="text-4xl font-bold">
                    <span>${{ $price }}</span>
                </div>
                <div class="mt-2 inline-block bg-black/20 text-xs font-medium px-4 py-1 rounded-full text-white">
                    {{ __('about.memberships.billing_cycle') }}
                </div>
            </div>
        </div>

        {{-- 2. القسم السفلي (البطاقة الزجاجية الداخلية) --}}
        <div x-data="{ open: 'benefits' }" class="relative p-6 flex flex-col flex-grow bg-white/70 backdrop-blur-sm rounded-2xl mt-4">
            <div class="absolute inset-0 -z-10">
                <img src="{{ asset($bgImage) }}" alt="" class="w-full h-full object-cover opacity-5 rounded-2xl">
            </div>

            {{-- المتطلبات (بشكل أكورديون) --}}
            @if (!empty($requirements))
                {{-- تم إرجاع div الحاوية الأصلي مع كلاساته --}}
                <div class="mb-5 text-start">
                    {{-- زر التحكم في الأكورديون --}}
                    <button @click="open = open === 'reqs' ? null : 'reqs'" class="w-full flex justify-between items-center">
                        {{-- تم إرجاع h4 الأصلي مع كلاساته --}}
                        <h4 class="text-base text-primary mb-3">{{ __('about.memberships.requirements_title') }}</h4>
                        <svg class="w-5 h-5 text-primary transition-transform mb-3" :class="{ 'rotate-180': open === 'reqs' }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    {{-- المحتوى القابل للطي --}}
                    <div x-show="open === 'reqs'" x-transition class="overflow-hidden">
                        {{-- تم إرجاع ul الأصلي مع كلاساته --}}
                        <ul class="space-y-2 text-sm text-muted-foreground">
                            @foreach ($requirements as $req)
                                <li class="flex items-start gap-3">
                                    <span class="w-5 h-5 mt-0.5 flex items-center justify-center bg-primary/20 text-primary rounded-full shrink-0 text-[10px]">✓</span>
                                    <span class="flex-1">{{ $req }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            {{-- المزايا (بشكل أكورديون) --}}
            @if (!empty($benefits))
                {{-- تم إرجاع div الحاوية الأصلي مع كلاساته --}}
                <div class="mb-6 text-start">
                    {{-- زر التحكم في الأكورديون --}}
                    <button @click="open = open === 'benefits' ? null : 'benefits'" class="w-full flex justify-between items-center">
                        {{-- تم إرجاع h4 الأصلي مع كلاساته --}}
                        <h4 class="text-base text-primary mb-3">{{ __('about.memberships.benefits_title') }}</h4>
                        <svg class="w-5 h-5 text-primary transition-transform mb-3" :class="{ 'rotate-180': open === 'benefits' }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    {{-- المحتوى القابل للطي --}}
                    <div x-show="open === 'benefits'" x-transition class="overflow-hidden">
                        {{-- تم إرجاع ul الأصلي مع كلاساته --}}
                        <ul class="space-y-2 text-sm text-muted-foreground">
                            @foreach ($benefits as $benefit)
                                <li class="flex items-start gap-3">
                                    <span class="w-5 h-5 mt-0.5 flex items-center justify-center bg-primary text-white rounded-full shrink-0 text-[10px]">✓</span>
                                    <span class="flex-1">{{ $benefit }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            {{-- زر الانضمام (لم يتغير) --}}
            <div class="mt-auto pt-6 border-t border-black/10 dark:border-white/10">
                <a href="#join" class="block w-full px-6 py-3 text-base font-semibold rounded-xl bg-primary text-accent-foreground hover:bg-primary/90 transition-all shadow-md hover:shadow-xl text-center">
                    {{ __('about.memberships.join_now') }}
                </a>
            </div>
        </div>
    </div>
</div>
