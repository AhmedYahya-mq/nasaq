<section class="" itemscope itemtype="http://schema.org/CollectionPage">
    <div class="container mx-auto px-4">
        <header class="text-center mb-12">
            <nav class="mt-8 max-w-3xl mx-auto" aria-label="Library Filters">
                <div class="flex flex-col md:flex-row items-center gap-4">
                    <x-ui.filter-bar />
                </div>
            </nav>
        </header>
        <main>
            <div class="grid items-stretch grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse ($resources as $resource)
                    <x-library.resource-card-in-profile :resource="$resource" />
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
