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
