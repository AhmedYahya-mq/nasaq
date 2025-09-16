@props([
    'title' => '',
    'subtitle' => '',
    'description' => '',
    'highlights' => [],
    'payment' => null,
    'link' => null,
    'highlight' => false,
])

<div {{ $attributes->class([
    'flex flex-col gap-5 p-5 md:p-8 rounded-2xl shadow-sm ',
    'bg-primary/5 shadow-primary/10' => $highlight,
    ' bg-card' => !$highlight
]) }}>

    {{-- العنوان الرئيسي (بدون أيقونة) --}}
    @if($title || $subtitle)
        <div>
            @if($title)
               
                <h1 class="text-xl sm:text-xl md:text-2xl font-bold text-foreground">{{ $title }}</h1>
            @endif
            @if($subtitle)
               
                <p class="text-sm sm:text-base text-muted-foreground mt-2">{{ $subtitle }}</p>
            @endif
        </div>
    @endif

    {{-- المحتوى التعريفي --}}
    @if($description)
        <div class="text-muted-foreground leading-relaxed text-sm sm:text-base">
            {!! $description !!}
        </div>
    @endif

    {{-- النقاط البارزة (مع إصلاح الخطأ) --}}
    @if(is_array($highlights) && count($highlights) > 0)
        <ul class="list-disc space-y-2 pl-5 rtl:pr-5 rtl:pl-0 text-sm sm:text-base">
            @foreach($highlights as $point)
                <li class="flex items-start gap-2">
                    <span class="text-primary mt-1">✨</span>
                    <span>{{ $point }}</span>
                </li>
            @endforeach
        </ul>
    @endif

    {{-- بيانات الدفع (مع الترجمة الكاملة) --}}
    @if($payment)
        <div class="mt-4 bg-accent/10 p-4 rounded-lg space-y-1 text-sm">
            @if($payment['title'] ?? false)
                <h3 class="font-bold mb-2 text-base">{{ $payment['title'] }}</h3>
            @endif
            @if($payment['bank'] ?? false)
                <p><span class="font-semibold">{{ __('memberships.payment_bank_label') }}:</span> {{ $payment['bank'] }}</p>
            @endif
            @if($payment['account'] ?? false)
                <p><span class="font-semibold">{{ __('memberships.payment_account_label') }}:</span> <span class="font-mono tracking-wider">{{ $payment['account'] }}</span></p>
            @endif
            @if($payment['iban'] ?? false)
                <p><span class="font-semibold">{{ __('memberships.payment_iban_label') }}:</span> <span class="font-mono tracking-wider">{{ $payment['iban'] }}</span></p>
            @endif
            @if($payment['note'] ?? false)
                <p class="text-xs sm:text-sm text-muted-foreground pt-2">{{ $payment['note'] }}</p>
            @endif
        </div>
    @endif

    {{-- الرابط الخارجي (مع الترجمة) --}}
    @if($link)
          <div class="mt-auto pt-4">
        <a href="{{ $link['url'] ?? '#' }}" target="_blank"
           class="inline-block bg-primary/10 text-primary font-semibold px-4 py-2 rounded-full text-sm sm:text-base transition-all duration-300 hover:bg-primary/20 hover:scale-[1.02]">
           {{ $link['label'] ?? __('memberships.more_details') }}
        </a>
    </div>
    @endif
</div>
