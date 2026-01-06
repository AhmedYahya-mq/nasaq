<x-layouts.guest-layout title="{{ $blog->title }}">

    @push('seo')
        {{-- Meta Tags --}}
        <meta name="description" content="{{ $blog->excerpt ?? \Illuminate\Support\Str::limit(strip_tags($blog->content), 150) }}">
        <meta name="keywords" content="{{ $blog->tags?->pluck('name')?->implode(', ') ?? __('seo.default_keywords') }}">
        <link rel="canonical" href="{{ url()->current() }}">

        {{-- Open Graph --}}
        <meta property="og:title" content="{{ $blog->title }}">
        <meta property="og:description" content="{{ $blog->excerpt ?? \Illuminate\Support\Str::limit(strip_tags($blog->content), 150) }}">
        <meta property="og:image" content="{{ $blog->photos()?->first()?->url ?? asset('favicon.ico') }}">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:site_name" content="{{ __('seo.site_name') }}">
        <meta property="og:type" content="article">

        {{-- Twitter --}}
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="{{ $blog->title }}">
        <meta name="twitter:description" content="{{ $blog->excerpt ?? \Illuminate\Support\Str::limit(strip_tags($blog->content), 150) }}">
        <meta name="twitter:image" content="{{ $blog->photos()?->first()?->url ?? asset('favicon.ico') }}">

        {{-- Hreflang --}}
        <link rel="alternate" hreflang="ar" href="{{ route('client.blog.details', ['blog' => $blog]) }}">
        <link rel="alternate" hreflang="en"
            href="{{ route('client.locale.blog.details', ['locale' => 'en', 'blog' => $blog]) }}">

        @php
            $blogsArray = collect([$blog])->map(function ($blog, $index) {
                return [
                    '@type' => 'ListItem',
                    'position' => $index + 1,
                    'url' => route('client.blog.details', ['blog' => $blog]),
                    'item' => [
                        '@type' => 'BlogPosting',
                        'headline' => $blog->title,
                        'description' => $blog->excerpt ?? \Illuminate\Support\Str::limit(strip_tags($blog->content), 150),
                        'image' => $blog->photos()?->first()?->url ?? asset('favicon.ico'),
                        'author' => [
                            '@type' => 'Person',
                            'name' => __('seo.author'),
                        ],
                        'publisher' => [
                            '@type' => 'Organization',
                            'name' => __('seo.site_name'),
                            'logo' => [
                                '@type' => 'ImageObject',
                                'url' => asset('favicon.ico'),
                            ],
                        ],
                        'datePublished' => $blog->created_at?->toIso8601String(),
                        'mainEntityOfPage' => [
                            '@type' => 'WebPage',
                            '@id' => route('client.blog.details', ['blog' => $blog]),
                        ],
                    ],
                ];
            });

            $structuredData = [
                '@context' => 'https://schema.org',
                '@type' => 'ItemList',
                'name' => __('seo.blog.title'),
                'description' => __('seo.blog.description'),
                'itemListElement' => $blogsArray->toArray(),
            ];
        @endphp

        <script type="application/ld+json">
        {!! json_encode($structuredData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>
    @endpush
    <x-blog.single-blog :blog="$blog" />
</x-layouts.guest-layout>
