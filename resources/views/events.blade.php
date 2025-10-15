<x-layouts.guest-layout title="{{ 'seo.events.title' }}">

    @push('seo')

        {{-- Meta Tags --}}
        <meta name="description" content="{{ __('seo.events.description') }}">
        <meta name="keywords" content="{{ __('seo.events.keywords') }}">
        <link rel="canonical" href="{{ url()->current() }}">

        {{-- Open Graph --}}
        <meta property="og:title" content="{{ __('seo.events.title') }}">
        <meta property="og:description" content="{{ __('seo.events.description') }}">
        <meta property="og:image" content="{{ asset('favicon.ico') }}">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:site_name" content="{{ __('seo.site_name') }}">
        <meta property="og:type" content="{{ __('seo.og_type') }}">

        {{-- Twitter --}}
        <meta name="twitter:card" content="{{ __('seo.twitter_card') }}">
        <meta name="twitter:title" content="{{ __('seo.events.title') }}">
        <meta name="twitter:description" content="{{ __('seo.events.description') }}">
        <meta name="twitter:image" content="{{ asset('favicon.ico') }}">

        {{-- Hreflang --}}
        <link rel="alternate" hreflang="ar" href="{{ route('client.events') }}">
        <link rel="alternate" hreflang="en" href="{{ route('client.locale.events', ['locale' => 'en']) }}">
    @endpush

    @push('scripts')
        @vite('resources/js/pages/events.js')
    @endpush
    <x-sections.events-section />
</x-layouts.guest-layout>
