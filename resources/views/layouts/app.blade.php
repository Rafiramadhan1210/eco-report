<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Eco Report Warga</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap" rel="stylesheet" />
    <style>body{font-family:'Plus Jakarta Sans',ui-sans-serif,system-ui,sans-serif}[x-cloak]{display:none!important}</style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="min-h-screen bg-slate-50 text-slate-800 antialiased">
    @include('layouts.navigation')

    @isset($header)
        <header class="border-b border-slate-200 bg-white">
            <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">{{ $header }}</div>
        </header>
    @endisset

    <main class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        {{ $slot }}
    </main>

    <footer class="border-t border-slate-200 py-6 text-center text-xs text-slate-500">
        Eco Report Warga &middot; Proyek 2 D4 Teknik Informatika
    </footer>
    @stack('scripts')
</body>
</html>
