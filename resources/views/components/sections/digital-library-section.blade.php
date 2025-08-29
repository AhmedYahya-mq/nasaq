<section x-data="{
    activeFilter: '{{ __('library.all') }}',
    filters: ['library.all', 'library.book', 'library.paper', 'library.presentation']

}" @filter-changed.window="activeFilter = $event.detail" class="py-16 bg-background">
    <div class="container mx-auto px-4">

        <div class="text-center mb-12">
            <h3 class="text-2x1 text-foreground">📚 {{ __('library.section_title') }}</h3>
            <p class="mt-3 text-lg text-muted-foreground max-w-2xl mx-auto">
                {{ __('library.section_subtitle') }}
            </p>
            <div class="mt-8 max-w-3xl mx-auto">
                <div class="flex flex-col md:flex-row items-center  gap-4">
                    <x-ui.filter-bar :filters="['library.all', 'library.book', 'library.paper', 'library.presentation']" active-filter="library.all" class="" />
                </div>
            </div>

        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

            {{-- كتاب --}}
            <div x-show="activeFilter === '{{ __('library.all') }}' || activeFilter === '{{ __('library.book') }}'">
                <x-resource-card :title="__('library.book_basics_title')" :description="__('library.book_basics_desc')" :type-text="__('library.book')"
                    thumbnail="{{ asset('images/book3.webp') }}" author="د. سارة أحمد" publish-date="15 أغسطس 2025"
                    :price="__('library.free')" :is-paid="false" />
            </div>

            {{-- ورقة علمية --}}
            <div x-show="activeFilter === '{{ __('library.all') }}' || activeFilter === '{{ __('library.paper') }}'">
                <x-resource-card :title="__('library.ai_paper_title')" :description="__('library.ai_paper_desc')" :type-text="__('library.paper')"
                    thumbnail="{{ asset('images/book2.webp') }}" author="فريق بحثي" publish-date="01 يوليو 2025"
                    price="5$" :is-paid="true" />
            </div>

            {{-- عرض تقديمي --}}
            <div
                x-show="activeFilter === '{{ __('library.all') }}' || activeFilter === '{{ __('library.presentation') }}'">
                <x-resource-card :title="__('library.communication_presentation_title')" :description="__('library.communication_presentation_desc')" :type-text="__('library.presentation')"
                    thumbnail="{{ asset('images/book1.webp') }}" author="أ. خالد محمد" publish-date="20 يونيو 2025"
                    :price="__('library.free')" :is-paid="false" />
            </div>

        </div>

        <div class="mt-12">
            <x-pagination x-bind:total-pages="totalPages" x-bind:current-page="currentPage" />
        </div>
    </div>
</section>
