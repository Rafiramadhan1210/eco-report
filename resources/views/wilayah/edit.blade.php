<x-app-layout>
    <x-slot name="header"><h1 class="text-xl font-extrabold text-slate-900">Ubah wilayah</h1></x-slot>
    <form action="{{ route('wilayah.update', $wilayah) }}" method="POST" class="max-w-xl rounded-2xl border border-slate-200 bg-white p-6">
        @csrf
        @method('PUT')
        @include('wilayah._form')
        <div class="mt-6 flex justify-end gap-3">
            <a href="{{ route('wilayah.index') }}" class="rounded-lg px-4 py-2 text-sm font-medium text-slate-600 hover:bg-slate-100">Batal</a>
            <button class="rounded-lg bg-emerald-700 px-5 py-2 text-sm font-semibold text-white hover:bg-emerald-800">Perbarui</button>
        </div>
    </form>
</x-app-layout>
