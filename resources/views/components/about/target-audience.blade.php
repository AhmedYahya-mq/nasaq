@props([
    'memberships' => trans('about.memberships.types'),
])
{{--
    استخدام Alpine.js لإدارة حالة التبديل بين شهري/سنوي.
    x-data="{ billing: 'yearly' }"
--}}
<section {{ $attributes->merge(['class' => 'py-20 sm:py-28 bg-muted/30']) }} x-data="membershipSection()">
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
        {{-- 2. مفتاح التبديل بين شهري/سنوي (الميزة الجديدة) --}}
        <div class="mt-10 flex justify-center items-center gap-4">
            <span class="font-medium text-foreground">{{ __('memberships.billing.monthly', ['default' => 'شهري']) }}</span>
            <button
                type="button"
                @click="billing = (billing === 'monthly' ? 'yearly' : 'monthly')"
                class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2"
                :class="billing === 'yearly' ? 'bg-primary' : 'bg-gray-300 dark:bg-gray-600'"
                role="switch"
                :aria-checked="billing === 'yearly'"
            >
                <span
                    aria-hidden="true"
                    class="inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"
                    :class="billing === 'yearly' ? 'translate-x-5' : 'translate-x-0'"
                ></span>
            </button>
            <span class="font-medium text-foreground flex items-center gap-2">
                {{ __('about.memberships.billing_cycle') }}
                <span class="inline-block bg-green-100 text-green-800 text-xs font-bold px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">
                    {{ __('memberships.billing.save_offer', ['default' => 'خصم 20%']) }}
                </span>
            </span>
        </div>

        {{-- 3. شبكة بطاقات العضوية --}}
        @if (!empty($memberships) && is_array($memberships))
            <div class="mt-16 grid sm:grid-cols-2 lg:grid-cols-3 gap-8 items-stretch justify-center">
                @foreach ($memberships as $member)
                    <x-ui.membership-card
                        :title="$member['title']"
                        :desc="$member['desc']"
                        :requirements="$member['requirements'] ?? []"
                        :benefits="$member['benefits'] ?? []"
                        :price="$member['price']"
                        :featured="isset($member['featured']) && $member['featured']" {{-- تمرير خاصية featured ديناميكيًا --}}
                        x-bind:price="billing === 'yearly' ? {{ $member['price'] }} : {{ round($member['price'] / 12 * 1.25) }}" {{-- حساب السعر الشهري ديناميكيًا --}}
                        x-bind:currency="billing === 'yearly' ? '{{ __('memberships.billing.yearly_currency', ['default' => 'ر.س']) }}' : '{{ __('memberships.billing.monthly_currency', ['default' => 'ر.س']) }}'"
                        x-bind:billing-cycle="billing === 'yearly' ? '{{ __('about.memberships.billing_cycle') }}' : '{{ __('memberships.billing.monthly', ['default' => 'شهري']) }}'"
                    />
                @endforeach
            </div>
        @endif
    </div>
</section>
{{-- 4. السكريبت الخاص بالقسم (للتنظيم) --}}
<script>
    function membershipSection() {
        return {
            billing: 'yearly', // القيمة الافتراضية هي سنوي
        }
    }
</script>
