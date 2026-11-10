@php
    $u = auth()->user();
    $kelola = in_array($u->role, ['pengurus', 'admin']);
    $milikBaru = $u->role === 'warga' && $laporan->user_id === $u->id && $laporan->status === 'Baru';
    $in = 'mt-1 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm focus:border-emerald-600 focus:ring-emerald-600';
    $kembali = $u->role === 'warga' ? route('laporan.index') : route('kelola.laporan');
@endphp

<x-app-layout>
    @push('styles')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.css">
    @endpush

    <x-slot name="header">
        <a href="{{ $kembali }}" class="text-sm font-medium text-emerald-700 hover:underline">&larr; Kembali ke daftar laporan</a>
    </x-slot>

    <x-alert />

    <div class="grid gap-6 lg:grid-cols-3">
        <div class="space-y-6 lg:col-span-2">
            <article class="overflow-hidden rounded-2xl border border-slate-200 bg-white">
                @if ($laporan->foto_url)
                    <img src="{{ $laporan->foto_url }}" alt="Foto laporan" class="h-80 w-full object-cover">
                @else
                    <div class="grid h-48 place-items-center bg-slate-100 text-5xl">📷</div>
                @endif
                <div class="p-6">
                    <div class="flex flex-wrap items-center gap-2">
                        <x-status-badge :status="$laporan->status" />
                        <span class="text-sm text-slate-500">{{ $laporan->jenis_masalah }}</span>
                    </div>
                    <h1 class="mt-3 text-2xl font-extrabold text-slate-900">{{ $laporan->judul }}</h1>
                    <p class="mt-4 whitespace-pre-line leading-relaxed text-slate-700">{{ $laporan->deskripsi }}</p>

                    @if ($milikBaru || $u->role === 'admin')
                        <div class="mt-6 flex flex-wrap gap-3 border-t border-slate-100 pt-5">
                            @if ($milikBaru)
                                <a href="{{ route('laporan.edit', $laporan) }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Ubah laporan</a>
                                <form action="{{ route('laporan.destroy', $laporan) }}" method="POST" onsubmit="return confirm('Batalkan laporan ini?')">
                                    @csrf @method('DELETE')
                                    <button class="rounded-lg border border-rose-200 px-4 py-2 text-sm font-semibold text-rose-700 hover:bg-rose-50">Batalkan laporan</button>
                                </form>
                            @else
                                <form action="{{ route('kelola.laporan.destroy', $laporan) }}" method="POST" onsubmit="return confirm('Hapus laporan ini secara permanen?')">
                                    @csrf @method('DELETE')
                                    <button class="rounded-lg border border-rose-200 px-4 py-2 text-sm font-semibold text-rose-700 hover:bg-rose-50">Hapus laporan</button>
                                </form>
                            @endif
                        </div>
                    @endif
                </div>
            </article>

            <section class="rounded-2xl border border-slate-200 bg-white p-6">
                <h2 class="font-bold text-slate-900">Komentar ({{ $laporan->komentar->count() }})</h2>

                <div class="mt-4 space-y-4">
                    @forelse ($laporan->komentar as $k)
                        <div x-data="{ edit: false }" class="rounded-xl bg-slate-50 p-4">
                            <div class="flex items-start justify-between gap-3">
                                <div class="text-sm">
                                    <span class="font-semibold text-slate-900">{{ $k->user->name }}</span>
                                    <span class="ml-1 rounded bg-white px-1.5 py-0.5 text-xs capitalize text-slate-500">{{ $k->user->role }}</span>
                                    <span class="ml-1 text-xs text-slate-400">{{ $k->created_at->format('d/m/Y H:i') }}</span>
                                </div>
                                <div class="flex gap-3 text-xs">
                                    @if ($k->user_id === $u->id)
                                        <button type="button" @click="edit = !edit" class="font-medium text-emerald-700 hover:underline">Ubah</button>
                                    @endif
                                    @if ($k->user_id === $u->id || $u->role === 'admin')
                                        <form action="{{ route('komentar.destroy', $k) }}" method="POST" onsubmit="return confirm('Hapus komentar ini?')">
                                            @csrf @method('DELETE')
                                            <button class="font-medium text-rose-600 hover:underline">Hapus</button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                            <p x-show="!edit" class="mt-2 whitespace-pre-line text-sm text-slate-700">{{ $k->isi }}</p>
                            <form x-show="edit" x-cloak action="{{ route('komentar.update', $k) }}" method="POST" class="mt-2">
                                @csrf @method('PUT')
                                <textarea name="isi" rows="2" class="{{ $in }}">{{ $k->isi }}</textarea>
                                <button class="mt-2 rounded-lg bg-emerald-700 px-3 py-1.5 text-xs font-semibold text-white">Simpan</button>
                            </form>
                        </div>
                    @empty
                        <p class="text-sm text-slate-500">Belum ada komentar.</p>
                    @endforelse
                </div>

                <form action="{{ route('komentar.store', $laporan) }}" method="POST" class="mt-5">
                    @csrf
                    <textarea name="isi" rows="2" class="{{ $in }}" placeholder="Tulis komentar...">{{ old('isi') }}</textarea>
                    @error('isi') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                    <button class="mt-2 rounded-lg bg-emerald-700 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-800">Kirim komentar</button>
                </form>
            </section>
        </div>

        <aside class="space-y-6">
            <section class="rounded-2xl border border-slate-200 bg-white p-6">
                <h2 class="font-bold text-slate-900">Informasi laporan</h2>
                <dl class="mt-4 space-y-3 text-sm">
                    <div><dt class="text-slate-500">Pelapor</dt><dd class="font-medium">{{ $laporan->user->name }}</dd></div>
                    <div><dt class="text-slate-500">Wilayah</dt><dd class="font-medium">{{ $laporan->wilayah->nama_wilayah }} ({{ $laporan->wilayah->jenis }})</dd></div>
                    <div><dt class="text-slate-500">Dilaporkan</dt><dd class="font-medium">{{ $laporan->created_at->format('d/m/Y H:i') }}</dd></div>
                    <div><dt class="text-slate-500">Koordinat</dt><dd class="font-mono text-xs">{{ $laporan->latitude }}, {{ $laporan->longitude }}</dd></div>
                </dl>
                <div id="peta-detail" class="mt-4 h-52 rounded-xl border border-slate-200"></div>
            </section>

            @if ($kelola)
                <section class="rounded-2xl border border-emerald-200 bg-emerald-50/50 p-6">
                    <h2 class="font-bold text-slate-900">Perbarui status</h2>
                    <form action="{{ route('kelola.tindaklanjut', $laporan) }}" method="POST" enctype="multipart/form-data" class="mt-3 space-y-3">
                        @csrf
                        <div>
                            <label class="text-sm font-medium text-slate-700" for="status">Status baru</label>
                            <select id="status" name="status" class="{{ $in }}">
                                @foreach (['Diproses', 'Selesai', 'Ditolak'] as $s)
                                    <option value="{{ $s }}" @selected(old('status') === $s)>{{ $s }}</option>
                                @endforeach
                            </select>
                            @error('status') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="text-sm font-medium text-slate-700" for="catatan">Catatan tindak lanjut</label>
                            <textarea id="catatan" name="catatan" rows="3" class="{{ $in }}" placeholder="Apa yang sudah atau akan dilakukan? Jika ditolak, tuliskan alasannya.">{{ old('catatan') }}</textarea>
                            @error('catatan') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="text-sm font-medium text-slate-700" for="foto_bukti">Foto bukti (opsional)</label>
                            <input id="foto_bukti" name="foto_bukti" type="file" accept="image/png,image/jpeg"
                                   class="mt-1 block w-full text-sm text-slate-600 file:mr-3 file:rounded-lg file:border-0 file:bg-white file:px-3 file:py-1.5 file:text-sm file:font-semibold file:text-emerald-800">
                            @error('foto_bukti') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                        </div>
                        <button class="w-full rounded-lg bg-emerald-700 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-800">Simpan status</button>
                    </form>
                </section>
            @endif

            <section class="rounded-2xl border border-slate-200 bg-white p-6">
                <h2 class="font-bold text-slate-900">Riwayat tindak lanjut</h2>
                <div class="mt-4">
                    @forelse ($laporan->tindakLanjut as $t)
                        <div class="flex gap-3">
                            <div class="flex flex-col items-center">
                                <span class="mt-1.5 h-2.5 w-2.5 rounded-full bg-emerald-600"></span>
                                @if (! $loop->last)<span class="w-px flex-1 bg-slate-200"></span>@endif
                            </div>
                            <div class="pb-5 text-sm">
                                <x-status-badge :status="$t->status_baru" />
                                <p class="mt-1.5 whitespace-pre-line text-slate-700">{{ $t->catatan }}</p>
                                @if ($t->foto_url)
                                    <a href="{{ $t->foto_url }}" target="_blank"><img src="{{ $t->foto_url }}" alt="Foto bukti" class="mt-2 h-24 rounded-lg object-cover"></a>
                                @endif
                                <p class="mt-1 text-xs text-slate-400">{{ $t->pengurus->name }} &middot; {{ $t->tanggal_tindak->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-slate-500">Belum ada tindak lanjut dari pengurus.</p>
                    @endforelse
                </div>
            </section>
        </aside>
    </div>

    @push('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.js"></script>
        <script>
            (function () {
                const lat = {{ (float) $laporan->latitude }}, lng = {{ (float) $laporan->longitude }};
                const peta = L.map('peta-detail', { scrollWheelZoom: false }).setView([lat, lng], 16);
                L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 19, attribution: '&copy; OpenStreetMap' }).addTo(peta);
                L.marker([lat, lng]).addTo(peta);
            })();
        </script>
    @endpush
</x-app-layout>
