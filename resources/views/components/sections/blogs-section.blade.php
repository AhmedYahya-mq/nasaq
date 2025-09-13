<section id="blogs">
    <div class="relative min-h-auto my-25">
        <h2 class="text-center mb-20">{{ __('home.blogs.title') }}</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-10 gap-y-24 px-2 sm:px-5">
            <x-ui.blog-card
                :title="__('home.blogs.items.0.title')"
                image="blog1.jpg"
                :excerpt="__('home.blogs.items.0.excerpt')" />

            <x-ui.blog-card
                :title="__('home.blogs.items.1.title')"
                image="blog2.jpg"
                :excerpt="__('home.blogs.items.1.excerpt')" />

            <x-ui.blog-card
                :title="__('home.blogs.items.2.title')"
                image="blog3.jpg"
                :excerpt="__('home.blogs.items.2.excerpt')" />
        </div>
    </div>
</section>
