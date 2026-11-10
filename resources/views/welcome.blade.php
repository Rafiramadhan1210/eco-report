<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Eco Report Warga</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap" rel="stylesheet" />
    <style>body{font-family:'Plus Jakarta Sans',ui-sans-serif,system-ui,sans-serif}</style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white text-slate-800 antialiased">
@php
    try {
        $total = \App\Models\Laporan::count();
        $selesai = \App\Models\Laporan::where('status', 'Selesai')->count();
    } catch (\Throwable $e) { $total = 0; $selesai = 0; }
@endphp

<header class="border-b border-slate-100">
    <div class="mx-auto flex h-16 max-w-6xl items-center justify-between px-6">
        <a href="/" class="flex items-center gap-2 font-extrabold text-emerald-900">
            <span class="grid h-8 w-8 place-items-center rounded-lg bg-emerald-800">🌿</span> Eco Report Warga
        </a>
        <nav class="flex items-center gap-2 text-sm font-semibold">
            @auth
                <a href="{{ route('dashboard') }}" class="rounded-lg bg-emerald-700 px-4 py-2 text-white hover:bg-emerald-800">Buka dashboard</a>
            @else
                <a href="{{ route('login') }}" class="px-4 py-2 text-slate-700 hover:text-emerald-800">Masuk</a>
                <a href="{{ route('register') }}" class="rounded-lg bg-emerald-700 px-4 py-2 text-white hover:bg-emerald-800">Daftar</a>
            @endauth
        </nav>
    </div>
</header>

<section class="mx-auto grid max-w-6xl items-center gap-12 px-6 py-16 lg:grid-cols-2 lg:py-24">
    <div>
        <h1 class="text-4xl font-extrabold leading-tight text-slate-900 sm:text-5xl">Masalah di lingkunganmu langsung sampai ke pengurus RT.</h1>
        <p class="mt-6 max-w-lg text-lg text-slate-600">Foto selokan yang tersumbat, tandai titiknya di peta, lalu pantau sampai selesai. Tidak perlu lagi mencari pesan yang tenggelam di grup.</p>
        <div class="mt-8 flex flex-wrap gap-3">
            @auth
                <a href="{{ route('dashboard') }}" class="rounded-lg bg-emerald-700 px-6 py-3 font-semibold text-white hover:bg-emerald-800">Buka dashboard</a>
            @else
                <a href="{{ route('register') }}" class="rounded-lg bg-emerald-700 px-6 py-3 font-semibold text-white hover:bg-emerald-800">Buat laporan pertama</a>
                <a href="{{ route('login') }}" class="rounded-lg border border-slate-300 px-6 py-3 font-semibold text-slate-700 hover:bg-slate-50">Masuk</a>
            @endauth
        </div>
        @if ($total > 0)
            <p class="mt-6 text-sm text-slate-500">{{ $total }} laporan sudah tercatat, {{ $selesai }} di antaranya selesai ditangani.</p>
        @endif
    </div>

    {{-- Contoh laporan --}}
    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-5">
        <div class="rounded-xl border border-slate-200 bg-white p-5">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <p class="font-bold text-slate-900">Selokan depan masjid tersumbat</p>
                    <p class="mt-1 text-xs text-slate-500">Saluran air tersumbat, RT 01</p>
                </div>
                <span class="rounded-full bg-emerald-50 px-2.5 py-0.5 text-xs font-semibold text-emerald-700 ring-1 ring-inset ring-emerald-200">Selesai</span>
            </div>
            <div class="mt-5 space-y-0">
                @foreach ([
                    ['Laporan diterima', 'Warga mengirim foto dan titik lokasi.', 'bg-sky-500'],
                    ['Sedang diproses', 'Pengurus mengecek lokasi dan menjadwalkan petugas.', 'bg-amber-500'],
                    ['Selesai', 'Selokan dibersihkan, foto bukti dilampirkan.', 'bg-emerald-500'],
                ] as $i => [$judul, $ket, $warna])
                    <div class="flex gap-3">
                        <div class="flex flex-col items-center">
                            <span class="mt-1 h-3 w-3 rounded-full {{ $warna }}"></span>
                            @if (! $loop->last)<span class="w-px flex-1 bg-slate-200"></span>@endif
                        </div>
                        <div class="pb-5">
                            <p class="text-sm font-semibold text-slate-900">{{ $judul }}</p>
                            <p class="text-xs text-slate-500">{{ $ket }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<section class="bg-slate-50">
    <div class="mx-auto max-w-6xl px-6 py-16">
        <h2 class="text-2xl font-extrabold text-slate-900">Dari laporan sampai selesai</h2>
        <div class="mt-8 grid gap-8 md:grid-cols-3">
            @foreach ([
                ['Warga melapor', 'Unggah foto, tulis deskripsi, dan klik titik lokasi di peta.'],
                ['Pengurus menindaklanjuti', 'Laporan masuk ke dashboard pengurus wilayah untuk diverifikasi dan diproses.'],
                ['Status bisa dipantau', 'Warga melihat perkembangan dari Baru sampai Selesai dan bisa berkomentar.'],
            ] as $i => [$judul, $ket])
                <div class="border-l-2 border-emerald-700 pl-5">
                    <p class="text-sm font-semibold text-emerald-700">Langkah {{ $i + 1 }}</p>
                    <h3 class="mt-1 text-lg font-bold text-slate-900">{{ $judul }}</h3>
                    <p class="mt-2 text-slate-600">{{ $ket }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section class="mx-auto max-w-6xl px-6 py-16">
    <h2 class="text-2xl font-extrabold text-slate-900">Laporkan apa saja yang mengganggu lingkungan</h2>
    <p class="mt-2 max-w-2xl text-slate-600">Tersedia kategori umum, dan jika masalahmu tidak ada di daftar, pilih Lainnya lalu tulis sendiri.</p>
    <div class="mt-6 flex flex-wrap gap-3">
        @foreach (['🗑️ Sampah liar', '🌊 Selokan tersumbat', '🌳 Pohon tumbang', '💧 Genangan air', '👃 Bau limbah', '💡 Lampu jalan mati', '✍️ Lainnya, tulis sendiri'] as $c)
            <span class="rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-700">{{ $c }}</span>
        @endforeach
    </div>
</section>

<section class="bg-emerald-900">
    <div class="mx-auto flex max-w-6xl flex-col items-start justify-between gap-6 px-6 py-14 md:flex-row md:items-center">
        <div>
            <h2 class="text-2xl font-extrabold text-white">Mulai dari satu laporan.</h2>
            <p class="mt-1 text-emerald-100">Lingkungan yang bersih dimulai dari warga yang mau melapor.</p>
        </div>
        @guest
            <a href="{{ route('register') }}" class="rounded-lg bg-white px-6 py-3 font-semibold text-emerald-900 hover:bg-emerald-50">Daftar sebagai warga</a>
        @endguest
    </div>
</section>

<footer class="py-6 text-center text-sm text-slate-500">&copy; {{ date('Y') }} Eco Report Warga &middot; Proyek 2 D4 Teknik Informatika</footer>
</body>
</html>
