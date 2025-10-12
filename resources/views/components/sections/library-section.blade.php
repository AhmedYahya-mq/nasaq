<section
   class="py-16 bg-background"
   itemscope itemtype="http://schema.org/CollectionPage">
    <div class="container mx-auto px-4">
        <header class="text-center mb-12">
            <h2 class="text-2x1 text-primary">📚 {{ __('library.section_title') }}</h2>
            <p class="mt-3 text-lg text-muted-foreground max-w-2xl mx-auto">
                {{ __('library.section_subtitle') }}
            </p>
            <nav class="mt-8 max-w-3xl mx-auto" aria-label="Library Filters">
                <div class="flex flex-col md:flex-row items-center gap-4">
                    <x-ui.filter-bar />
                </div>
            </nav>
        </header>
        <main>
            <div class="grid items-stretch grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse ($resources as $resource)
                    <x-library.resource-card :resource="$resource"  />
                @empty
                    <p class="text-center text-muted-foreground col-span-full">No resources found.</p>
                @endforelse
            </div>
            <div class="mt-12">
                {{ $resources->links() }}
            </div>
        </main>
    </div>
</section>
