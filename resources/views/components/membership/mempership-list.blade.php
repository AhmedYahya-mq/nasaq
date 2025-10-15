<section {{ $attributes->merge(['class' => 'py-20 sm:py-28 bg-muted/30']) }}>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- 1. العنوان الرئيسي والوصف --}}
        <div class="text-center  mx-auto">
            <h2 class="text-xl md:text-2xl font-bold text-primary tracking-tight">
                {{ __('about.memberships.title') }}
            </h2>
            <p class="mt-4 text-lg text-muted-foreground">
                {{ __('about.memberships.subtitle') }}
            </p>
        </div>

        {{-- 3. شبكة بطاقات العضوية --}}
        <div class="mt-16 grid sm:grid-cols-2 lg:grid-cols-3 gap-8 items-stretch justify-center">
            @foreach ($memberships as $member)
                <x-membership.membership-card :membership="$member" :featured="isset($member->featured) ? $member->featured : false" />
            @endforeach
        </div>
    </div>
</section>
@push('seo')
    @if ($memberships && $memberships->isNotEmpty())
        @php
            $structuredData = [
                '@context' => 'https://schema.org',
                '@type' => 'ItemList',
                'name' => __('seo.memberships.title'),
                'description' => __('seo.memberships.description'),
                'itemListElement' => $memberships->map(function ($membership, $index) {
                    $offer = [
                        '@type' => 'Offer',
                        'url' => route('client.pay.index', ['type' => 'membership', 'id' => $membership->id]),
                        'priceCurrency' => 'SAR',
                        'price' => $membership->is_discounted
                            ? $membership->discounted_price
                            : $membership->regular_price,
                        'availability' => 'https://schema.org/InStock',
                    ];

                    if ($membership->is_discounted) {
                        $offer['listPrice'] = $membership->regular_price;
                        $offer['discount'] = $membership->regular_price - $membership->discounted_price;
                    }

                    $item = [
                        '@type' => 'Product',
                        'name' => $membership->name,
                        'description' => $membership->description,
                        'image' => $membership->image ?? asset('images/memberships-default.jpg'),
                        'offers' => $offer,
                    ];

                    if (!empty($membership->features)) {
                        $item['additionalProperty'] = collect($membership->features)
                            ->map(function ($feature) {
                                return [
                                    '@type' => 'PropertyValue',
                                    'name' => 'ميزة',
                                    'value' => $feature,
                                ];
                            })
                            ->toArray();
                    }

                    return [
                        '@type' => 'ListItem',
                        'position' => $index + 1,
                        'url' => route('client.pay.index', ['type' => 'membership', 'id' => $membership->id]),
                        'item' => $item,
                    ];
                }),
            ];
        @endphp

        <script type="application/ld+json">
            {!! json_encode($structuredData, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT) !!}
        </script>
    @endif
@endpush
