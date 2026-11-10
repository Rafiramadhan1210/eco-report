<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Eco Report Warga</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap" rel="stylesheet" />
    <style>body{font-family:'Plus Jakarta Sans',ui-sans-serif,system-ui,sans-serif}</style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased text-slate-800">
    <div class="grid min-h-screen lg:grid-cols-2">
        <div class="hidden flex-col justify-between bg-emerald-900 p-12 text-emerald-50 lg:flex">
            <a href="/" class="flex items-center gap-2 text-lg font-extrabold">
                <span class="grid h-9 w-9 place-items-center rounded-lg bg-emerald-700">🌿</span> Eco Report Warga
            </a>
            <div>
                <h2 class="max-w-md text-3xl font-extrabold leading-tight">Satu foto dan satu titik lokasi cukup untuk memulai perbaikan.</h2>
                <p class="mt-4 max-w-md text-emerald-100/80">Laporan Anda langsung masuk ke pengurus RT atau kelurahan setempat, lengkap dengan status penanganannya.</p>
            </div>
            <p class="text-sm text-emerald-100/60">Proyek 2 D4 Teknik Informatika</p>
        </div>

        <div class="flex items-center justify-center bg-slate-50 p-6">
            <div class="w-full max-w-md">
                <a href="/" class="mb-8 flex items-center gap-2 font-extrabold text-emerald-900 lg:hidden">
                    <span class="grid h-8 w-8 place-items-center rounded-lg bg-emerald-800">🌿</span> Eco Report Warga
                </a>
                <div class="rounded-2xl border border-slate-200 bg-white p-8">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>
</body>
</html>
