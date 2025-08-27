@props([
    'memberships' => trans('about.memberships.types'),
])

<section {{ $attributes->merge(['class' => 'relative py-20 bg-muted/30 overflow-hidden']) }}>
    <div class="max-w-7xl mx-auto px-6 lg:px-12 ">

        <div class="text-center max-w-3xl mx-auto">

            {{-- العنوان الرئيسي --}}
            <h2 class="text-4xl md:text-5xl font-bold text-primary">
                {{ __('about.memberships.title') }}
            </h2>

            {{-- خط فاصل رفيع وأنيق --}}
            <div class="mt-4 mb-6 h-1 w-24 bg-primary/20 mx-auto rounded-full"></div>

            {{-- الوصف --}}
            <p class="text-lg text-muted-foreground mb-12">
                {{ __('about.memberships.subtitle') }}
            </p>
        </div>

        {{-- شبكة بطاقات العضوية --}}
        @if (!empty($memberships) && is_array($memberships))
<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 justify-center">
                @foreach ($memberships as $member)
                    <x-ui.membership-card :title="$member['title']" :desc="$member['desc']" :requirements="$member['requirements'] ?? []" :benefits="$member['benefits'] ?? []"
                        :price="$member['price']" />
                @endforeach
            </div>
        @endif
    </div>
</section>
