<div x-data="{ showFilters: false, isLoading: false }" class="w-full space-y-4">

    <!-- البحث + أيقونة الفلترة -->
    <div class="flex items-center gap-2 w-full relative">
        <!-- شريط البحث -->
        <x-forms.input type="search" name="search" :placeholder="__('library.search_placeholder')" icon="search" class="flex-1" />

        <!-- زر الأيقونة -->
        <button @click="showFilters = !showFilters"
            class="p-2 rounded-full border border-border bg-card hover:bg-accent/20 transition relative z-20">
            <!-- أيقونة فلترة -->
            <x-icons.filter-icon class="h-5 w-5 text-foreground" />
        </button>

        <!-- القائمة المنسدلة للموبايل -->
        <div x-show="showFilters" x-transition
            class="absolute top-full left-0 mt-2 w-40 bg-card border border-border rounded-lg shadow-lg md:hidden z-10   ">
            <ul class="divide-y divide-border ">
                @foreach ($filters as $filter)
                    @php $isActive = $activeFilter === $filter; @endphp
                    <li>
                        <button
                            @click="
                                $dispatch('filter-changed', '{{ $filter }}');
                                showFilters = false
                            "
                            class="w-full origin-top-right rtl:origin-top-left rtl:right-0 ltr:left-0   px-4 py-2 text-sm transition hover:bg-accent/20
                                   {{ $isActive ? 'bg-primary text-primary-foreground' : 'text-foreground' }}"
                            :disabled="isLoading">
                            {{ __($filter) }}
                        </button>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <!-- الفلاتر سطح المكتب -->
    <div x-show="showFilters" x-transition class="hidden md:flex md:items-center md:justify-center gap-2 flex-wrap">
        @foreach ($filters as $filter)
            @php $isActive = $activeFilter === $filter; @endphp
            <button @click="$dispatch('filter-changed', '{{ $filter }}')" :disabled="isLoading"
                class="px-4 py-2 text-sm font-semibold rounded-full border border-border transition
                       {{ $isActive ? 'bg-primary text-primary-foreground' : 'bg-card text-muted-foreground hover:bg-accent/20' }}
                       disabled:opacity-70 disabled:cursor-not-allowed">
                {{ __($filter) }}
            </button>
        @endforeach
    </div>
</div>
