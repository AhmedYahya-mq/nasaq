@props([
    'totalPages' => 1,
    'currentPage' => 1,
])

<nav aria-label="Pagination" class="flex items-center justify-center space-x-2 rtl:space-x-reverse">

    <a href="#" @click.prevent="$dispatch('page-changed', Math.max(1, {{ $currentPage }} - 1))"
        :class="{ 'opacity-50 cursor-not-allowed': {{ $currentPage }} === 1 }"
        class="flex h-10 w-10 items-center justify-center rounded-lg bg-card transition hover:bg-accent/20 border border-border"
        aria-label="{{ __('pagination.previous') }}" >
        <x-ui.icon name="arrow-left" class="h-5 w-5 rtl:rotate-180" />

    </a>

    @for ($i = 1; $i <= $totalPages; $i++)
        <a href="#" @click.prevent="$dispatch('page-changed', {{ $i }})"
            class="flex h-10 w-10 items-center justify-center rounded-lg border border-border transition-colors {{ $currentPage == $i ? 'bg-primary text-primary-foreground' : 'bg-card hover:bg-accent/20' }}">
            {{ $i }}
        </a>
    @endfor

    <a href="#" @click.prevent="$dispatch('page-changed', Math.min({{ $totalPages }}, {{ $currentPage }} + 1))"
        :class="{ 'opacity-50 cursor-not-allowed': {{ $currentPage }} === {{ $totalPages }} }"
        class="flex h-10 w-10 items-center justify-center rounded-lg bg-card transition hover:bg-accent/20 border border-border"
        aria-label="{{ __('pagination.next') }}" >
        <x-ui.icon name="arrow-right" class="h-5 w-5 rtl:rotate-180" />

    </a>
</nav>
