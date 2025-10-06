<div x-data="{ showFilters: false, isLoading: false }" class="w-full space-y-4">

    <!-- البحث + أيقونة الفلترة -->
    <div class="flex items-center gap-2 w-full relative">
        <!-- شريط البحث -->
        <x-forms.input type="search" name="search" :placeholder="$placeholder ?? __('library.search_placeholder')" icon="search" class="flex-1" />

        <!-- زر الأيقونة -->
        @isset($filters)
            @if (count($filters) > 0)
                <button @click="showFilters = !showFilters"
                    class="p-2 rounded-full border border-border bg-card hover:bg-accent/20 transition relative z-20">
                    <x-icons.filter-icon class="h-5 w-5 text-foreground" />
                </button>
            @endif
        @endisset
    </div>

    @isset($filters)
        @if (count($filters) > 0)
            <!-- الفلاتر (تظهر أسفل البحث في الوسط عند النقر) -->
            <div x-show="showFilters" x-transition class="flex justify-center gap-2 flex-wrap mt-2">
                @foreach ($filters as $filter)
                    @php $isActive = $activeFilter === $filter; @endphp
                    <button @click="$dispatch('filter-changed', '{{ $filter }}'); showFilters = false"
                        :disabled="isLoading"
                        class="px-3 py-1.5 text-xs md:text-sm font-semibold rounded-full border border-border transition
                       {{ $isActive ? 'bg-primary text-primary-foreground' : 'bg-card text-muted-foreground hover:bg-accent/20' }}
                       disabled:opacity-70 disabled:cursor-not-allowed">
                        {{ __($filter) }}
                    </button>
                @endforeach
            </div>
        @endif
    @endisset

</div>
