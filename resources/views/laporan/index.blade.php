<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h1 class="text-xl font-extrabold text-slate-900">Laporan saya</h1>
                <p class="mt-1 text-sm text-slate-500">Pantau status setiap laporan yang pernah Anda kirim.</p>
            </div>
            <a href="{{ route('laporan.create') }}" class="rounded-lg bg-emerald-700 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-800">Buat laporan</a>
        </div>
    </x-slot>

    <x-alert />

    <div class="space-y-4">
        @forelse ($laporan as $l)
            <div class="flex flex-col gap-4 rounded-2xl border border-slate-200 bg-white p-4 sm:flex-row">
                @if ($l->foto_url)
                    <img src="{{ $l->foto_url }}" alt="" class="h-32 w-full rounded-xl object-cover sm:w-44">
                @else
                    <div class="grid h-32 w-full place-items-center rounded-xl bg-slate-100 text-3xl sm:w-44">📷</div>
                @endif
                <div class="flex-1">
                    <div class="flex flex-wrap items-center gap-2">
                        <x-status-badge :status="$l->status" />
                        <span class="text-xs text-slate-500">{{ $l->jenis_masalah }} &middot; {{ $l->wilayah->nama_wilayah }}</span>
                    </div>
                    <h2 class="mt-2 font-bold text-slate-900">{{ $l->judul }}</h2>
                    <p class="mt-1 line-clamp-2 text-sm text-slate-600">{{ $l->deskripsi }}</p>
                    <div class="mt-3 flex flex-wrap items-center gap-4 text-sm">
                        <span class="text-xs text-slate-400">{{ $l->created_at->format('d/m/Y H:i') }}</span>
                        <a href="{{ route('laporan.show', $l) }}" class="font-semibold text-emerald-700 hover:underline">Lihat detail</a>
                        @if ($l->status === 'Baru')
                            <a href="{{ route('laporan.edit', $l) }}" class="font-medium text-sky-700 hover:underline">Ubah</a>
                            <form action="{{ route('laporan.destroy', $l) }}" method="POST" onsubmit="return confirm('Batalkan laporan ini?')">
                                @csrf @method('DELETE')
                                <button class="font-medium text-rose-600 hover:underline">Batalkan</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="rounded-2xl border border-dashed border-slate-300 bg-white px-6 py-14 text-center">
                <p class="text-3xl">🌱</p>
                <p class="mt-3 font-semibold text-slate-900">Belum ada laporan</p>
                <p class="mt-1 text-sm text-slate-500">Lihat masalah di sekitar Anda? Kirim laporan pertama sekarang.</p>
                <a href="{{ route('laporan.create') }}" class="mt-5 inline-block rounded-lg bg-emerald-700 px-5 py-2 text-sm font-semibold text-white hover:bg-emerald-800">Buat laporan</a>
            </div>
        @endforelse
    </div>

    <div class="mt-6">{{ $laporan->links() }}</div>
</x-app-layout>
