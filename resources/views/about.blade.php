<x-layouts.guest-layout title="seo.about.title">


    @push('seo')
        {{-- Meta Tags --}}
        <meta name="description" content="{{ __('seo.about.description') }}">
        <meta name="keywords" content="{{ __('seo.about.keywords') }}">
        <link rel="canonical" href="{{ url()->current() }}">

        {{-- Open Graph --}}
        <meta property="og:title" content="{{ __('seo.about.title') }}">
        <meta property="og:description"
            content="{{ __('seo.about.description') }}">
        <meta property="og:image" content="{{ asset('favicon.ico') }}">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:site_name" content="{{ __('seo.site_name') }}">
        <meta property="og:type" content="website">

        {{-- Twitter --}}
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="{{ __('seo.about.title') }}">
        <meta name="twitter:description"
            content="{{ __('seo.about.description') }}">
        <meta name="twitter:image" content="{{ asset('favicon.ico') }}">

        {{-- Hreflang --}}
        <link rel="alternate" hreflang="ar" href="{{ route('client.about') }}">
        <link rel="alternate" hreflang="en" href="{{ route('client.locale.about', ['locale' => 'en']) }}">


        @php
            $structuredData = [
                '@context' => 'https://schema.org',
                '@type' => 'AboutPage',
                'name' => __('seo.about.title'),
                'description' => __('seo.about.description', [
                    'fallback' => 'تعرف على مجتمع ناسق ورؤيته ورسالة وأهدافه.',
                ]),
                'url' => url()->current(),
                'publisher' => [
                    '@type' => 'Organization',
                    'name' => __('seo.site_name'),
                    'logo' => [
                        '@type' => 'ImageObject',
                        'url' => asset('favicon.ico'),
                    ],
                ],
            ];
        @endphp

        <script type="application/ld+json">
        {!! json_encode($structuredData, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT) !!}
    </script>
    @endpush

    <x-about.hero />
    <x-sections.goals-section />
    <x-about.communication-methods />
</x-layouts.guest-layout>
