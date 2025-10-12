<div x-data="{
        showFilters: false,
        search: '{{ request('search') ?? '' }}',
        submitSearch() {
            const params = new URLSearchParams(window.location.search);

            // ضع قيمة البحث الجديدة
            params.set('search', this.search);

            // احذف أي قيمة page موجودة
            params.delete('page');

            // أترك الفلاتر الحالية كما هي
            window.location.href = `${window.location.pathname}?${params.toString()}`;
        }
    }" class="w-full space-y-4">

    <!-- البحث + أيقونة الفلترة -->
    <div class="flex items-center gap-2 w-full relative">
        <!-- شريط البحث -->
        <x-forms.input
            type="search"
            name="search"
            x-model="search"
            @keydown.enter.prevent="submitSearch()"
            :placeholder="$placeholder ?? __('library.search_placeholder')"
            icon="search"
            class="flex-1"
        />

        <!-- زر الفلترة -->
        <button
            @click="showFilters = !showFilters"
            aria-label="Toggle Filters"
            class="p-2 rounded-full border border-border bg-card hover:bg-accent/20 transition relative z-20"
        >
            <x-icons.filter-icon class="h-5 w-5 text-foreground" />
        </button>
    </div>

    <!-- الفلاتر -->
    <div x-show="showFilters" x-transition class="flex justify-center gap-2 flex-wrap mt-2">
        <a href="{{ url()->current() . '?' . http_build_query(array_merge(request()->except('page', 'filter'), ['filter' => 'all'])) }}"
            class="px-3 py-1.5 text-xs md:text-sm font-semibold rounded-full border border-border transition
                {{ request()->get('filter') === 'all' ? 'bg-primary text-primary-foreground' : 'bg-card text-muted-foreground hover:bg-accent/20' }}
                disabled:opacity-70 disabled:cursor-not-allowed">
            {{ __('library.all') }}
        </a>

        @foreach (\App\Enums\LibraryType::cases() as $filter)
            <a href="{{ url()->current() . '?' . http_build_query(array_merge(request()->except('page', 'filter'), ['filter' => $filter->value])) }}"
                class="px-3 py-1.5 text-xs md:text-sm font-semibold rounded-full border border-border transition
                    {{ request()->get('filter') === $filter->value ? 'bg-primary text-primary-foreground' : 'bg-card text-muted-foreground hover:bg-accent/20' }}
                    disabled:opacity-70 disabled:cursor-not-allowed">
                {{ __($filter->label()) }}
            </a>
        @endforeach
    </div>

</div>
