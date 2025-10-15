<x-layouts.guest-layout title="{{ 'about.memberships.title' }}">
    @push('seo')
        {{-- Meta Tags --}}
        <meta name="description" content="{{ __('seo.memberships.description') }}">
        <meta name="keywords" content="{{ __('seo.memberships.keywords') }}">
        <link rel="canonical" href="{{ url()->current() }}">

        {{-- Open Graph --}}
        <meta property="og:title" content="{{ __('about.memberships.title') }}">
        <meta property="og:description" content="{{ __('seo.memberships.description') }}">
        <meta property="og:image" content="{{ asset('favicon.ico') }}">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:site_name" content="{{ __('seo.site_name') }}">
        <meta property="og:type" content="{{ __('seo.og_type') }}">

        {{-- Twitter --}}
        <meta name="twitter:card" content="{{ __('seo.twitter_card') }}">
        <meta name="twitter:title" content="{{ __('about.memberships.title') }}">
        <meta name="twitter:description" content="{{ __('seo.memberships.description') }}">
        <meta name="twitter:image" content="{{ asset('favicon.ico') }}">

        {{-- Hreflang --}}
        <link rel="alternate" hreflang="ar" href="{{ route('client.memberships') }}">
        <link rel="alternate" hreflang="en" href="{{ route('client.locale.memberships', ['locale' => 'en']) }}">
    @endpush

    <x-membership.mempership-list />
</x-layouts.guest-layout>
