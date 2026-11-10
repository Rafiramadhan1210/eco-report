@php $in = 'rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm focus:border-emerald-600 focus:ring-emerald-600'; @endphp
<x-app-layout>
    <x-slot name="header">
        <h1 class="text-xl font-extrabold text-slate-900">{{ auth()->user()->role === 'admin' ? 'Semua laporan' : 'Laporan masuk' }}</h1>
        <p class="mt-1 text-sm text-slate-500">
            @if (auth()->user()->role === 'pengurus')
                Menampilkan laporan di wilayah {{ auth()->user()->wilayah->nama_wilayah ?? '-' }}.
            @else
                Menampilkan laporan dari seluruh wilayah.
            @endif
        </p>
    </x-slot>

    <x-alert />

    <form method="GET" class="mb-5 flex flex-wrap gap-3">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari judul laporan" class="{{ $in }} w-full sm:w-64">
        <select name="status" class="{{ $in }}">
            <option value="">Semua status</option>
            @foreach (['Baru', 'Diproses', 'Selesai', 'Ditolak'] as $s)
                <option value="{{ $s }}" @selected(request('status') === $s)>{{ $s }}</option>
            @endforeach
        </select>
        <select name="kategori_id" class="{{ $in }}">
            <option value="">Semua jenis</option>
            @foreach ($kategori as $k)
                <option value="{{ $k->id }}" @selected(request('kategori_id') == $k->id)>{{ $k->nama_kategori }}</option>
            @endforeach
        </select>
        <button class="rounded-lg bg-emerald-700 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-800">Saring</button>
        @if (request()->hasAny(['q', 'status', 'kategori_id']))
            <a href="{{ route('kelola.laporan') }}" class="px-2 py-2 text-sm text-slate-600 hover:underline">Atur ulang</a>
        @endif
    </form>

    <div class="overflow-x-auto rounded-2xl border border-slate-200 bg-white">
        <table class="w-full text-left text-sm">
            <thead class="border-b border-slate-200 bg-slate-50 text-slate-600">
                <tr>
                    <th class="px-4 py-3 font-semibold">Laporan</th>
                    <th class="px-4 py-3 font-semibold">Jenis</th>
                    <th class="px-4 py-3 font-semibold">Wilayah</th>
                    <th class="px-4 py-3 font-semibold">Status</th>
                    <th class="px-4 py-3 font-semibold">Tanggal</th>
                    <th class="px-4 py-3 font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($laporan as $l)
                    <tr class="border-b border-slate-100 last:border-0">
                        <td class="px-4 py-3">
                            <p class="font-medium text-slate-900">{{ $l->judul }}</p>
                            <p class="text-xs text-slate-500">oleh {{ $l->user->name }}</p>
                        </td>
                        <td class="px-4 py-3">{{ $l->jenis_masalah }}</td>
                        <td class="px-4 py-3">{{ $l->wilayah->nama_wilayah }}</td>
                        <td class="px-4 py-3"><x-status-badge :status="$l->status" /></td>
                        <td class="px-4 py-3 text-slate-500">{{ $l->created_at->format('d/m/Y') }}</td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                <a href="{{ route('laporan.show', $l) }}" class="font-semibold text-emerald-700 hover:underline">Tinjau</a>
                                @if (auth()->user()->role === 'admin')
                                    <form action="{{ route('kelola.laporan.destroy', $l) }}" method="POST" onsubmit="return confirm('Hapus laporan ini secara permanen?')">
                                        @csrf @method('DELETE')
                                        <button class="font-medium text-rose-600 hover:underline">Hapus</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-4 py-12 text-center text-slate-500">Tidak ada laporan yang cocok.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-5">{{ $laporan->links() }}</div>
</x-app-layout>
