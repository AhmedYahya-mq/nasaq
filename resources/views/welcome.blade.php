<x-layouts.guest-layout title="{{ 'home.page_title' }}">

    @push('seo')
        @php
            $title = 'home.page_title'; // مثال: "الرئيسية"
            $description = __('home.page_description'); // مثال: "أفضل مجتمع للتعلم والمشاركة في المعرفة والثقافة."
            $keywords = __('home.page_keywords'); // مثال: "Nasaq, مجتمع, تعليم, مكتبة, مقالات, فعاليات"
            $ogImage = asset('images/seo-default.jpg'); // صورة افتراضية
        @endphp

        {{-- Title / Meta --}}
        <meta name="description" content="{{ $description }}">
        <meta name="keywords" content="{{ $keywords }}">
        <link rel="canonical" href="{{ url()->current() }}">

        {{-- Open Graph --}}
        <meta property="og:title" content="{{ $title }}">
        <meta property="og:description" content="{{ $description }}">
        <meta property="og:image" content="{{ $ogImage }}">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:site_name" content="{{ __('seo.site_name') }}">
        <meta property="og:type" content="{{ __('seo.og_type') }}">

        {{-- Twitter --}}
        <meta name="twitter:card" content="{{ __('seo.twitter_card') }}">
        <meta name="twitter:title" content="{{ $title }}">
        <meta name="twitter:description" content="{{ $description }}">
        <meta name="twitter:image" content="{{ $ogImage }}">

        {{-- Hreflang --}}
        <link rel="alternate" hreflang="ar" href="{{ route('client.home') }}">
        <link rel="alternate" hreflang="en" href="{{ route('client.locale.home', ['locale' => 'en']) }}">
    @endpush
    @push('scripts')
        @vite('resources/js/pages/events.js')
    @endpush
    <x-sections.hero2 />
    {{-- <x-sections.hero-section /> --}}
    <x-sections.goals-section />
    <x-sections.section-number />
    <section class="bg-background pt-20">
        <div class="mx-auto px-4 lg:px-6">

            <div class="text-center max-w-3xl mx-auto mb-10">
                <h1 class="text-xl font-extrabold text-foreground mb-4 leading-tight drop-shadow-lg">
                    {{ __('events.page_titles.main') }}
                </h1>
            </div>

            <div
                class="mb-16 relative bg-gradient-to-r from-primary/20 via-background to-background rounded-xl shadow-2xl overflow-hidden border border-primary/30">
                <x-events.event-futured class="rounded-xl" />
            </div>

            <div class="">
                {{-- العمود الأول: الفعاليات القادمة --}}
                <x-events.list-events :isPaginated="false" />

            </div>
        </div>
    </section>
    <x-sections.feature-section />
    <x-sections.blogs-section />
</x-layouts.guest-layout>
