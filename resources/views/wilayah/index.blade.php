<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h1 class="text-xl font-extrabold text-slate-900">Wilayah</h1>
                <p class="mt-1 text-sm text-slate-500">Data RT, RW, dan kelurahan yang dipakai pada laporan dan pengguna.</p>
            </div>
            <a href="{{ route('wilayah.create') }}" class="rounded-lg bg-emerald-700 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-800">Tambah wilayah</a>
        </div>
    </x-slot>

    <x-alert />

    <form method="GET" class="mb-5 flex gap-3">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama wilayah" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm sm:w-64 focus:border-emerald-600 focus:ring-emerald-600">
        <button class="rounded-lg bg-emerald-700 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-800">Cari</button>
    </form>

    <div class="overflow-x-auto rounded-2xl border border-slate-200 bg-white">
        <table class="w-full text-left text-sm">
            <thead class="border-b border-slate-200 bg-slate-50 text-slate-600">
                <tr>
                    <th class="px-4 py-3 font-semibold">Nama</th>
                    <th class="px-4 py-3 font-semibold">Jenis</th>
                    <th class="px-4 py-3 font-semibold">Kode</th>
                    <th class="px-4 py-3 font-semibold">Pengguna</th>
                    <th class="px-4 py-3 font-semibold">Laporan</th>
                    <th class="px-4 py-3 font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($wilayah as $w)
                    <tr class="border-b border-slate-100 last:border-0">
                        <td class="px-4 py-3 font-medium text-slate-900">{{ $w->nama_wilayah }}</td>
                        <td class="px-4 py-3">{{ $w->jenis }}</td>
                        <td class="px-4 py-3 font-mono text-xs">{{ $w->kode_wilayah }}</td>
                        <td class="px-4 py-3">{{ $w->pengguna_count }}</td>
                        <td class="px-4 py-3">{{ $w->laporan_count }}</td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                <a href="{{ route('wilayah.edit', $w) }}" class="font-medium text-sky-700 hover:underline">Ubah</a>
                                <form action="{{ route('wilayah.destroy', $w) }}" method="POST" onsubmit="return confirm('Hapus wilayah ini?')">
                                    @csrf @method('DELETE')
                                    <button class="font-medium text-rose-600 hover:underline">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-4 py-12 text-center text-slate-500">Belum ada wilayah.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-5">{{ $wilayah->links() }}</div>
</x-app-layout>
