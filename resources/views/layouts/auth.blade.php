{{-- resources/views/layouts/auth.blade.php --}}

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', $locale) }}" dir="{{ $locale === 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ isset($title) ? __($title) . ' | ' : '' }}{{ config('app.name', 'Laravel') }}</title>
    @stack('scripts')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="relative">
    <div class="max-h-dvh overflow-hidden relative overflow-x-hidden scrollbar scroll-container">
        <main>
            {{ $slot }}
        </main>
    </div>
    <x-loading />

</body>

</html>
