<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', $locale) }}" dir="{{ $locale === 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __($title) }}</title>
    @stack('scripts')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="relative" >
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
