@props([
    'filters' => [],
    'activeFilter' => '',
])


<div
    x-data="{ isLoading: false }"
    @filter-loading-started.window="isLoading = true"
    @filter-loading-finished.window="isLoading = false"
    class="w-full"
>
    <div class="hidden md:flex md:items-center md:justify-center gap-2 flex-wrap">
        @foreach ($filters as $filter)
            @php
                $isActive = $activeFilter === $filter;
            @endphp
            <button
                @click="$dispatch('filter-changed', '{{ $filter }}')"
                :disabled="isLoading"
                :class="{
                    'bg-primary text-primary-foreground': '{{ $isActive }}',
                    'bg-card text-muted-foreground hover:bg-accent/20': !'{{ $isActive }}',
                    'cursor-not-allowed opacity-70': isLoading
                }"
                class="px-4 py-2 text-sm font-semibold rounded-full border border-border transition-all duration-200 flex items-center gap-x-2"
            >
                <svg x-show="isLoading" class="animate-spin -ml-1 mr-2 h-4 w-4 text-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span>{{ __($filter ) }}</span>
            </button>
        @endforeach
    </div>

    <div class="block md:hidden w-full">
        <select
            @change="$dispatch('filter-changed', $event.target.value)"
            :disabled="isLoading"
            class="w-full bg-card border border-border rounded-lg px-4 py-2.5 focus:ring-primary focus:border-primary transition-colors disabled:opacity-70 disabled:cursor-not-allowed"
        >
            @foreach ($filters as $filter)
                <option value="{{ $filter }}" @selected($activeFilter === $filter)>
                    {{ __($filter) }}
                </option>
            @endforeach
        </select>
    </div>
</div>
