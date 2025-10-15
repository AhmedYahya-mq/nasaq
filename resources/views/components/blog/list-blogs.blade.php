<div
    x-data="{
        search: '{{ request()->get('search') }}',
        showFilters: false,
        submitSearch() {
            const params = new URLSearchParams(window.location.search);
            if (this.search) {
                params.set('search', this.search);
            } else {
                params.delete('search');
            }
            window.location.search = params.toString();
        }
    }"
class="relative min-h-auto my-25 px-5 sm:px-10">
    <div class="text-center mb-12">
        <h1 class="text-3xl md:text-5xl font-extrabold text-foreground mb-4 leading-tight">
            {{ __('blog.title') }}
        </h1>
        <p class="text-lg text-muted-foreground max-w-2xl mx-auto">
            {{ __('blog.description') }}
        </p>

        {{-- شريط البحث والفلترة --}}
        @if ($isPaginated)
            <div class="mt-8 max-w-3xl mx-auto flex flex-col gap-6">
                <div class="flex justify-center">
                    <!-- البحث + أيقونة الفلترة -->
                    <div class="flex items-center gap-2 w-full relative">
                        <!-- شريط البحث -->
                        <x-forms.input type="search" name="search" x-model="search"
                            @keydown.enter.prevent="submitSearch()" :placeholder="$placeholder ?? __('library.search_placeholder')" icon="search" class="flex-1" />
                    </div>
                </div>
            </div>
    </div>
    @endif

    <div
        class="mt-16 mb-8 grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8 gap-y-24 items-stretch justify-center">
        @forelse ($blogs as $blog)
            <x-blog.card-blog :blog="$blog" />
        @empty
            <p class="text-center text-muted-foreground col-span-full">
                {{ __('blog.no_blogs_found') }}
            </p>
        @endforelse
    </div>
    <!-- Pagination -->
    @if ($isPaginated)
        {{ $blogs->links('pagination::tailwind') }}
    @endif
</div>
