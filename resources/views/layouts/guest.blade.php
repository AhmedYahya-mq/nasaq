<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', $locale) }}" dir="{{ $locale === 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __($title) }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="scroll-smooth overflow-x-hidden scrollbar antialiased">
    <div class="">
        <x-topbar />
        <x-header />

        <main style="padding: 20px;">
            {{ $slot }}
        </main>

        <x-footer />
    </div>
    <x-loading />
</body>

</html>
