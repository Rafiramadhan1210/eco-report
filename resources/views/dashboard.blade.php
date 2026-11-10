<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Dashboard</h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">

            <div class="rounded-lg bg-white p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-gray-900">Halo, {{ Auth::user()->name }} 👋</h3>
                <p class="mt-1 text-gray-600">
                    Anda login sebagai
                    <span class="rounded bg-green-100 px-2 py-0.5 text-sm font-medium capitalize text-green-700">
                        {{ Auth::user()->role }}
                    </span>
                </p>
            </div>

            @if (Auth::user()->role === 'admin')
                <div class="grid gap-4 md:grid-cols-3">
                    <div class="rounded-lg bg-white p-6 shadow-sm">
                        <p class="text-sm text-gray-500">Total Kategori</p>
                        <p class="mt-2 text-3xl font-bold text-green-600">{{ \App\Models\Kategori::count() }}</p>
                    </div>
                    <div class="rounded-lg bg-white p-6 shadow-sm">
                        <p class="text-sm text-gray-500">Total Laporan</p>
                        <p class="mt-2 text-3xl font-bold text-green-600">{{ \App\Models\Laporan::count() }}</p>
                    </div>
                    <div class="rounded-lg bg-white p-6 shadow-sm">
                        <p class="text-sm text-gray-500">Total Pengguna</p>
                        <p class="mt-2 text-3xl font-bold text-green-600">{{ \App\Models\User::count() }}</p>
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>