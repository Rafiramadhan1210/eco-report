@php
    $role = auth()->user()->role;
    $menu = match ($role) {
        'warga' => [
            ['Beranda', 'dashboard', ['dashboard']],
            ['Buat Laporan', 'laporan.create', ['laporan.create']],
            ['Laporan Saya', 'laporan.index', ['laporan.index', 'laporan.edit', 'laporan.show']],
        ],
        'pengurus' => [
            ['Beranda', 'dashboard', ['dashboard']],
            ['Laporan Masuk', 'kelola.laporan', ['kelola.laporan', 'laporan.show']],
            ['Peta', 'kelola.peta', ['kelola.peta']],
        ],
        default => [
            ['Beranda', 'dashboard', ['dashboard']],
            ['Semua Laporan', 'kelola.laporan', ['kelola.laporan', 'laporan.show']],
            ['Peta', 'kelola.peta', ['kelola.peta']],
            ['Kategori', 'kategori.index', ['kategori.*']],
            ['Wilayah', 'wilayah.index', ['wilayah.*']],
            ['Pengguna', 'pengguna.index', ['pengguna.*']],
        ],
    };
@endphp

<nav x-data="{ buka: false }" class="border-b border-slate-200 bg-white">
    <div class="mx-auto flex h-16 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
        <div class="flex items-center gap-8">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-2 font-extrabold text-emerald-900">
                <span class="grid h-8 w-8 place-items-center rounded-lg bg-emerald-800 text-base">🌿</span>
                Eco Report
            </a>
            <div class="hidden items-center gap-1 lg:flex">
                @foreach ($menu as [$label, $rute, $pola])
                    <a href="{{ route($rute) }}"
                       class="rounded-lg px-3 py-2 text-sm font-medium transition {{ request()->routeIs(...$pola) ? 'bg-emerald-50 text-emerald-800' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                        {{ $label }}
                    </a>
                @endforeach
            </div>
        </div>

        <div class="hidden items-center gap-3 lg:flex">
            <span class="rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold capitalize text-emerald-800">{{ $role }}</span>
            <x-dropdown align="right" width="48">
                <x-slot name="trigger">
                    <button class="flex items-center gap-1 rounded-lg px-2 py-1.5 text-sm font-medium text-slate-700 hover:bg-slate-100">
                        {{ auth()->user()->name }}
                        <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.17l3.71-3.94a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd"/></svg>
                    </button>
                </x-slot>
                <x-slot name="content">
                    <x-dropdown-link :href="route('profile.edit')">Profil</x-dropdown-link>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">Keluar</x-dropdown-link>
                    </form>
                </x-slot>
            </x-dropdown>
        </div>

        <button @click="buka = !buka" class="rounded-lg p-2 text-slate-600 hover:bg-slate-100 lg:hidden" aria-label="Menu">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path x-show="!buka" stroke-linecap="round" d="M4 6h16M4 12h16M4 18h16"/>
                <path x-show="buka" x-cloak stroke-linecap="round" d="M6 6l12 12M18 6L6 18"/>
            </svg>
        </button>
    </div>

    <div x-show="buka" x-cloak class="border-t border-slate-200 px-4 py-3 lg:hidden">
        @foreach ($menu as [$label, $rute, $pola])
            <a href="{{ route($rute) }}"
               class="block rounded-lg px-3 py-2 text-sm font-medium {{ request()->routeIs(...$pola) ? 'bg-emerald-50 text-emerald-800' : 'text-slate-600' }}">{{ $label }}</a>
        @endforeach
        <div class="mt-3 border-t border-slate-200 pt-3">
            <p class="px-3 text-sm font-semibold">{{ auth()->user()->name }} <span class="text-xs font-normal capitalize text-slate-500">({{ $role }})</span></p>
            <a href="{{ route('profile.edit') }}" class="mt-1 block rounded-lg px-3 py-2 text-sm text-slate-600">Profil</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="block w-full rounded-lg px-3 py-2 text-left text-sm text-slate-600">Keluar</button>
            </form>
        </div>
    </div>
</nav>
