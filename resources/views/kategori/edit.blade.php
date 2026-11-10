<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Tambah Kategori</h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-2xl sm:px-6 lg:px-8">
            <form action="{{ route('kategori.store') }}" method="POST" class="rounded-lg bg-white p-6 shadow-sm">
                @csrf
                @include('kategori._form')
                <div class="mt-6 flex justify-end gap-3">
                    <a href="{{ route('kategori.index') }}" class="px-4 py-2 text-gray-600 hover:underline">Batal</a>
                    <x-primary-button>Simpan</x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>