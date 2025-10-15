<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', $locale) }}" dir="{{ $locale === 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- عنوان الصفحة --}}
    <title>{{ isset($title) ? __($title) . ' | ' : '' }}{{ __('seo.site_name') }}</title>
    @php
        $socials = config('socials', []);
        // جمع روابط التواصل الاجتماعي الصالحة فقط
        $socialUrls = collect($socials)
            ->pluck('url')
            ->filter(fn($url) => !empty($url) && $url !== '#')
            ->values()
            ->all();

        // إعداد البيانات للـ JSON-LD
        $jsonLd = [
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => __('seo.site_name'),
            'url' => url('/'),
            'logo' => asset('favicon.ico'),
            'sameAs' => $socialUrls,
        ];
    @endphp

    <script type="application/ld+json">
        {!! json_encode($jsonLd, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT) !!}
    </script>
    @stack('seo')

    @stack('scripts')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="relative">
    <div class="max-h-dvh relative overflow-hidden overflow-x-hidden scrollbar scroll-container">
        <x-topbar />
        <x-header />

        <main>
            {{ $slot }}
        </main>

        <x-footer />
        <div class="fixed top-4 left-1/2 -translate-x-1/2 z-50">
            <x-toast />
        </div>
    </div>
    <x-loading />
    @stack('models')
</body>

</html>
