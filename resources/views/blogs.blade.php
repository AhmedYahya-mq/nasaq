<x-layouts.guest-layout title="{{__('blog.title')}}">
    <div class="relative min-h-auto my-25 px-5 sm:px-10">
        <div class="text-center mb-12">
            <h1 class="text-3xl md:text-5xl font-extrabold text-foreground mb-4 leading-tight">
                {{__('blog.title')}}
            </h1>
            <p class="text-lg text-muted-foreground max-w-2xl mx-auto">
                {{__('blog.description')}}
            </p>

            {{-- شريط البحث والفلترة --}}
            <div class="mt-8 max-w-3xl mx-auto flex flex-col gap-6">
                <div class="flex justify-center">
                    <x-ui.filter-bar :filters="[__('archive.filters.all')]" active-filter="{{__('blog.search')}}" />
                </div>
            </div>
        </div>

        <div class="mt-16 grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8 gap-y-24 items-stretch justify-center">
            <x-ui.blog-card :title="__('blog.article1_title')" image="blog1.jpg" :excerpt="__('blog.article1_excerpt')" />

            <x-ui.blog-card :title="__('blog.article2_title')" image="blog2.jpg" :excerpt="__('blog.article2_excerpt')" />

            <x-ui.blog-card :title="__('blog.article3_title')" image="blog3.jpg" :excerpt="__('blog.article3_excerpt')" />

        </div>
    </div>
</x-layouts.guest-layout>
