<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', $locale) }}" dir="{{ $locale === 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __($title) }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="relative" >
    <div class="max-h-dvh overflow-hidden relative overflow-x-hidden scrollbar scroll-container">
        <x-topbar />
        <x-header />

        <main>
            {{ $slot }}
        </main>

        <x-footer />
    </div>
    <x-loading />
    @stack('modals')

</body>

</html>
