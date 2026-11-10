<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Kategori Masalah</h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-5xl sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 rounded-lg bg-green-100 px-4 py-3 text-green-800">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="mb-4 rounded-lg bg-red-100 px-4 py-3 text-red-800">{{ session('error') }}</div>
            @endif

            <div class="rounded-lg bg-white p-6 shadow-sm">
                <div class="mb-4 flex justify-end">
                    <a href="{{ route('kategori.create') }}"
                       class="rounded-lg bg-green-600 px-4 py-2 text-sm font-semibold text-white hover:bg-green-700">
                        + Tambah Kategori
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="border-b bg-gray-50 text-gray-600">
                            <tr>
                                <th class="px-4 py-3">No</th>
                                <th class="px-4 py-3">Nama Kategori</th>
                                <th class="px-4 py-3">Deskripsi</th>
                                <th class="px-4 py-3">Prioritas</th>
                                <th class="px-4 py-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($kategori as $item)
                                <tr class="border-b">
                                    <td class="px-4 py-3">{{ $kategori->firstItem() + $loop->index }}</td>
                                    <td class="px-4 py-3 font-medium">{{ $item->nama_kategori }}</td>
                                    <td class="px-4 py-3">{{ $item->deskripsi ?? '-' }}</td>
                                    <td class="px-4 py-3 capitalize">{{ $item->tingkat_prioritas }}</td>
                                    <td class="flex gap-3 px-4 py-3">
                                        <a href="{{ route('kategori.edit', $item) }}" class="text-blue-600 hover:underline">Ubah</a>
                                        <form action="{{ route('kategori.destroy', $item) }}" method="POST"
                                              onsubmit="return confirm('Hapus kategori ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-6 text-center text-gray-500">Belum ada data.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">{{ $kategori->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>