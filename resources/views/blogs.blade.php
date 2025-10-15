<x-layouts.guest-layout title="{{ 'seo.blogs.title' }}">

    @push('seo')
        {{-- Meta Tags --}}
        <meta name="description" content="{{__('seo.blogs.title') }}">
        <meta name="keywords" content="{{ __('seo.blogs.keywords') }}">
        <link rel="canonical" href="{{ url()->current() }}">

        {{-- Open Graph --}}
        <meta property="og:title" content="{{ __('seo.blogs.title') }}">
        <meta property="og:description" content="{{__('seo.blogs.title') }}">
        <meta property="og:image" content="{{ asset('favicon.ico') }}">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:site_name" content="{{ __('seo.site_name') }}">
        <meta property="og:type" content="website">

        {{-- Twitter --}}
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="{{ __('seo.blogs.title') }}">
        <meta name="twitter:description" content="{{__('seo.blogs.title') }}">
        <meta name="twitter:image" content="{{ asset('favicon.ico') }}">

        {{-- Hreflang --}}
        <link rel="alternate" hreflang="ar" href="{{ route('client.blogs') }}">
        <link rel="alternate" hreflang="en" href="{{ route('client.locale.blogs', ['locale' => 'en']) }}">
    @endpush
    <x-blog.list-blogs />
</x-layouts.guest-layout>
