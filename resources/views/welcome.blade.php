<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Eco Report Warga</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white text-gray-800 antialiased">

    {{-- Navbar --}}
    <header class="border-b border-gray-100">
        <div class="mx-auto flex max-w-6xl items-center justify-between px-6 py-4">
            <a href="/" class="flex items-center gap-2 text-xl font-bold text-green-700">
                <span>🌿</span> Eco Report Warga
            </a>
            <nav class="flex items-center gap-3 text-sm font-medium">
                @auth
                    <a href="{{ route('dashboard') }}" class="rounded-lg bg-green-600 px-4 py-2 text-white hover:bg-green-700">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="px-4 py-2 text-gray-700 hover:text-green-700">Masuk</a>
                    <a href="{{ route('register') }}" class="rounded-lg bg-green-600 px-4 py-2 text-white hover:bg-green-700">Daftar</a>
                @endauth
            </nav>
        </div>
    </header>

    {{-- Hero --}}
    <section class="bg-gradient-to-b from-green-50 to-white">
        <div class="mx-auto max-w-6xl px-6 py-20 text-center">
            <span class="rounded-full bg-green-100 px-4 py-1 text-sm font-medium text-green-700">
                Pelaporan lingkungan tingkat RT / Kelurahan
            </span>
            <h1 class="mt-6 text-4xl font-extrabold leading-tight text-gray-900 md:text-5xl">
                Lihat masalah lingkungan?<br>
                <span class="text-green-600">Laporkan, pantau, selesaikan.</span>
            </h1>
            <p class="mx-auto mt-6 max-w-2xl text-lg text-gray-600">
                Sampah liar, saluran tersumbat, atau pohon tumbang? Cukup unggah foto dan tandai lokasinya.
                Laporan langsung diterima pengurus wilayahmu dan statusnya bisa kamu pantau.
            </p>
            <div class="mt-8 flex flex-wrap justify-center gap-4">
                @auth
                    <a href="{{ route('dashboard') }}" class="rounded-lg bg-green-600 px-6 py-3 font-semibold text-white hover:bg-green-700">Buka Dashboard</a>
                @else
                    <a href="{{ route('register') }}" class="rounded-lg bg-green-600 px-6 py-3 font-semibold text-white hover:bg-green-700">Mulai Melapor</a>
                    <a href="{{ route('login') }}" class="rounded-lg border border-gray-300 px-6 py-3 font-semibold text-gray-700 hover:bg-gray-50">Masuk</a>
                @endauth
            </div>
        </div>
    </section>

    {{-- Cara kerja --}}
    <section class="mx-auto max-w-6xl px-6 py-16">
        <h2 class="text-center text-2xl font-bold text-gray-900">Cara Kerja</h2>
        <div class="mt-10 grid gap-6 md:grid-cols-3">
            <div class="rounded-2xl border border-gray-100 p-6 shadow-sm">
                <div class="text-3xl">📸</div>
                <h3 class="mt-4 text-lg font-semibold">1. Buat Laporan</h3>
                <p class="mt-2 text-gray-600">Unggah foto, tulis deskripsi singkat, dan tentukan titik lokasi masalah.</p>
            </div>
            <div class="rounded-2xl border border-gray-100 p-6 shadow-sm">
                <div class="text-3xl">✅</div>
                <h3 class="mt-4 text-lg font-semibold">2. Diverifikasi Pengurus</h3>
                <p class="mt-2 text-gray-600">Laporan masuk ke dashboard pengurus wilayahmu untuk diverifikasi dan ditindaklanjuti.</p>
            </div>
            <div class="rounded-2xl border border-gray-100 p-6 shadow-sm">
                <div class="text-3xl">📍</div>
                <h3 class="mt-4 text-lg font-semibold">3. Pantau Status</h3>
                <p class="mt-2 text-gray-600">Pantau perkembangan dari Baru, Diproses, hingga Selesai, dan beri komentar bila perlu.</p>
            </div>
        </div>
    </section>

    {{-- Kategori --}}
    <section class="bg-gray-50">
        <div class="mx-auto max-w-6xl px-6 py-16">
            <h2 class="text-center text-2xl font-bold text-gray-900">Jenis Masalah yang Bisa Dilaporkan</h2>
            <div class="mt-10 grid gap-6 md:grid-cols-3">
                <div class="rounded-2xl bg-white p-6 text-center shadow-sm">
                    <div class="text-4xl">🗑️</div>
                    <h3 class="mt-3 font-semibold">Sampah Liar</h3>
                </div>
                <div class="rounded-2xl bg-white p-6 text-center shadow-sm">
                    <div class="text-4xl">🌊</div>
                    <h3 class="mt-3 font-semibold">Saluran Air Tersumbat</h3>
                </div>
                <div class="rounded-2xl bg-white p-6 text-center shadow-sm">
                    <div class="text-4xl">🌳</div>
                    <h3 class="mt-3 font-semibold">Pohon Tumbang</h3>
                </div>
            </div>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="border-t border-gray-100 py-6 text-center text-sm text-gray-500">
        &copy; {{ date('Y') }} Eco Report Warga. Proyek 2 D4 Teknik Informatika.
    </footer>

</body>
</html>