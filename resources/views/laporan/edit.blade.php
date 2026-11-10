<x-app-layout>
    <x-slot name="header">
        <h1 class="text-xl font-extrabold text-slate-900">Ubah laporan</h1>
        <p class="mt-1 text-sm text-slate-500">Laporan hanya bisa diubah selama statusnya masih Baru.</p>
    </x-slot>

    <form action="{{ route('laporan.update', $laporan) }}" method="POST" enctype="multipart/form-data" class="rounded-2xl border border-slate-200 bg-white p-6">
        @csrf
        @method('PUT')
        @include('laporan._form')
        <div class="mt-8 flex justify-end gap-3 border-t border-slate-100 pt-5">
            <a href="{{ route('laporan.show', $laporan) }}" class="rounded-lg px-4 py-2 text-sm font-medium text-slate-600 hover:bg-slate-100">Batal</a>
            <button class="rounded-lg bg-emerald-700 px-5 py-2 text-sm font-semibold text-white hover:bg-emerald-800">Simpan perubahan</button>
        </div>
    </form>
</x-app-layout>
