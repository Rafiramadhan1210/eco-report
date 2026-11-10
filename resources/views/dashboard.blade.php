<x-app-layout>
    <x-slot name="header">
        <h1 class="text-xl font-extrabold text-slate-900">Halo, {{ auth()->user()->name }}</h1>
        <p class="mt-1 text-sm text-slate-500">
            Anda masuk sebagai <span class="font-semibold capitalize text-emerald-800">{{ auth()->user()->role }}</span>
            @if (auth()->user()->wilayah) di {{ auth()->user()->wilayah->nama_wilayah }} @endif
        </p>
    </x-slot>

    <x-alert />

    @if (auth()->user()->role === 'warga')
        <div class="mb-8 flex flex-col items-start justify-between gap-4 rounded-2xl bg-emerald-800 p-6 text-white sm:flex-row sm:items-center">
            <div>
                <h2 class="text-lg font-bold">Ada masalah lingkungan di sekitar Anda?</h2>
                <p class="mt-1 text-sm text-emerald-100">Foto, tandai lokasinya, dan kirim ke pengurus wilayah.</p>
            </div>
            <a href="{{ route('laporan.create') }}" class="rounded-lg bg-white px-5 py-2.5 text-sm font-semibold text-emerald-900 hover:bg-emerald-50">Buat laporan</a>
        </div>
    @endif

    @php
        $kartu = [
            ['total', 'Total laporan', 'bg-slate-400'],
            ['Baru', 'Menunggu verifikasi', 'bg-sky-500'],
            ['Diproses', 'Sedang diproses', 'bg-amber-500'],
            ['Selesai', 'Selesai ditangani', 'bg-emerald-500'],
            ['Ditolak', 'Ditolak', 'bg-rose-500'],
        ];
    @endphp
    <div class="grid grid-cols-2 gap-4 md:grid-cols-5">
        @foreach ($kartu as [$kunci, $label, $dot])
            <div class="rounded-2xl border border-slate-200 bg-white p-5">
                <div class="flex items-center gap-2 text-sm text-slate-500"><span class="h-2 w-2 rounded-full {{ $dot }}"></span>{{ $label }}</div>
                <p class="mt-2 text-3xl font-extrabold text-slate-900">{{ $stat[$kunci] }}</p>
            </div>
        @endforeach
    </div>

    @if ($admin)
        <div class="mt-4 grid gap-4 md:grid-cols-3">
            <a href="{{ route('pengguna.index') }}" class="rounded-2xl border border-slate-200 bg-white p-5 hover:border-emerald-300">
                <p class="text-sm text-slate-500">Pengguna terdaftar</p><p class="mt-1 text-2xl font-extrabold">{{ $admin['pengguna'] }}</p>
            </a>
            <a href="{{ route('kategori.index') }}" class="rounded-2xl border border-slate-200 bg-white p-5 hover:border-emerald-300">
                <p class="text-sm text-slate-500">Kategori masalah</p><p class="mt-1 text-2xl font-extrabold">{{ $admin['kategori'] }}</p>
            </a>
            <a href="{{ route('wilayah.index') }}" class="rounded-2xl border border-slate-200 bg-white p-5 hover:border-emerald-300">
                <p class="text-sm text-slate-500">Wilayah</p><p class="mt-1 text-2xl font-extrabold">{{ $admin['wilayah'] }}</p>
            </a>
        </div>
    @endif

    <section class="mt-8 rounded-2xl border border-slate-200 bg-white">
        <div class="flex items-center justify-between border-b border-slate-100 px-6 py-4">
            <h2 class="font-bold text-slate-900">Laporan terbaru</h2>
            <a href="{{ auth()->user()->role === 'warga' ? route('laporan.index') : route('kelola.laporan') }}" class="text-sm font-medium text-emerald-700 hover:underline">Lihat semua</a>
        </div>
        @forelse ($terbaru as $l)
            <a href="{{ route('laporan.show', $l) }}" class="flex items-center justify-between gap-4 border-b border-slate-100 px-6 py-4 last:border-0 hover:bg-slate-50">
                <div class="min-w-0">
                    <p class="truncate font-medium text-slate-900">{{ $l->judul }}</p>
                    <p class="mt-0.5 text-xs text-slate-500">{{ $l->jenis_masalah }} &middot; {{ $l->user->name }} &middot; {{ $l->created_at->format('d/m/Y H:i') }}</p>
                </div>
                <x-status-badge :status="$l->status" />
            </a>
        @empty
            <p class="px-6 py-10 text-center text-sm text-slate-500">Belum ada laporan.</p>
        @endforelse
    </section>
</x-app-layout>
