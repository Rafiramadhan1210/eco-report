@php $in = 'rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm focus:border-emerald-600 focus:ring-emerald-600'; @endphp
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h1 class="text-xl font-extrabold text-slate-900">Pengguna</h1>
                <p class="mt-1 text-sm text-slate-500">Kelola akun warga, pengurus, dan admin.</p>
            </div>
            <a href="{{ route('pengguna.create') }}" class="rounded-lg bg-emerald-700 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-800">Tambah pengguna</a>
        </div>
    </x-slot>

    <x-alert />

    <form method="GET" class="mb-5 flex flex-wrap gap-3">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama atau email" class="{{ $in }} w-full sm:w-64">
        <select name="role" class="{{ $in }}">
            <option value="">Semua peran</option>
            @foreach (['warga', 'pengurus', 'admin'] as $r)
                <option value="{{ $r }}" @selected(request('role') === $r)>{{ ucfirst($r) }}</option>
            @endforeach
        </select>
        <button class="rounded-lg bg-emerald-700 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-800">Saring</button>
    </form>

    <div class="overflow-x-auto rounded-2xl border border-slate-200 bg-white">
        <table class="w-full text-left text-sm">
            <thead class="border-b border-slate-200 bg-slate-50 text-slate-600">
                <tr>
                    <th class="px-4 py-3 font-semibold">Nama</th>
                    <th class="px-4 py-3 font-semibold">Email</th>
                    <th class="px-4 py-3 font-semibold">Peran</th>
                    <th class="px-4 py-3 font-semibold">Wilayah</th>
                    <th class="px-4 py-3 font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pengguna as $p)
                    <tr class="border-b border-slate-100 last:border-0">
                        <td class="px-4 py-3 font-medium text-slate-900">{{ $p->name }}</td>
                        <td class="px-4 py-3">{{ $p->email }}</td>
                        <td class="px-4 py-3"><span class="rounded-full bg-emerald-50 px-2.5 py-0.5 text-xs font-semibold capitalize text-emerald-800">{{ $p->role }}</span></td>
                        <td class="px-4 py-3">{{ $p->wilayah->nama_wilayah ?? '-' }}</td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                <a href="{{ route('pengguna.edit', $p) }}" class="font-medium text-sky-700 hover:underline">Ubah</a>
                                @if ($p->id !== auth()->id())
                                    <form action="{{ route('pengguna.destroy', $p) }}" method="POST" onsubmit="return confirm('Hapus pengguna ini beserta laporannya?')">
                                        @csrf @method('DELETE')
                                        <button class="font-medium text-rose-600 hover:underline">Hapus</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-4 py-12 text-center text-slate-500">Tidak ada pengguna yang cocok.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-5">{{ $pengguna->links() }}</div>
</x-app-layout>
