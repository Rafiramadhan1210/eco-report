@php
    $in = 'mt-1 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm focus:border-emerald-600 focus:ring-emerald-600';
    $lainId = $kategori->firstWhere('nama_kategori', 'Lainnya')?->id;
    $kategoriAwal = old('kategori_id', $laporan->kategori_id ?? null);
@endphp

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.css">
@endpush

<div class="grid gap-6 lg:grid-cols-2">
    <div class="space-y-4" x-data="{ lain: {{ $lainId && $kategoriAwal == $lainId ? 'true' : 'false' }}, lainId: '{{ $lainId }}', foto: null }">
        <div>
            <label class="text-sm font-medium text-slate-700" for="kategori_id">Jenis masalah</label>
            <select id="kategori_id" name="kategori_id" class="{{ $in }}" @change="lain = ($event.target.value === lainId)">
                <option value="">Pilih jenis masalah</option>
                @foreach ($kategori as $k)
                    <option value="{{ $k->id }}" @selected($kategoriAwal == $k->id)>{{ $k->nama_kategori }}</option>
                @endforeach
            </select>
            @error('kategori_id') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
        </div>

        <div x-show="lain" x-cloak>
            <label class="text-sm font-medium text-slate-700" for="kategori_lain">Tuliskan jenis masalahnya</label>
            <input id="kategori_lain" name="kategori_lain" type="text" maxlength="100" class="{{ $in }}"
                   placeholder="Contoh: lampu jalan mati, bau limbah pabrik"
                   value="{{ old('kategori_lain', $laporan->kategori_lain ?? '') }}">
            @error('kategori_lain') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="text-sm font-medium text-slate-700" for="wilayah_id">Wilayah</label>
            <select id="wilayah_id" name="wilayah_id" class="{{ $in }}">
                <option value="">Pilih wilayah</option>
                @foreach ($wilayah as $w)
                    <option value="{{ $w->id }}" @selected(old('wilayah_id', $laporan->wilayah_id ?? auth()->user()->wilayah_id) == $w->id)>{{ $w->nama_wilayah }} ({{ $w->jenis }})</option>
                @endforeach
            </select>
            @error('wilayah_id') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="text-sm font-medium text-slate-700" for="judul">Judul laporan</label>
            <input id="judul" name="judul" type="text" maxlength="150" class="{{ $in }}" placeholder="Contoh: Selokan depan masjid tersumbat"
                   value="{{ old('judul', $laporan->judul ?? '') }}">
            @error('judul') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="text-sm font-medium text-slate-700" for="deskripsi">Deskripsi</label>
            <textarea id="deskripsi" name="deskripsi" rows="4" class="{{ $in }}" placeholder="Ceritakan kondisinya, sudah berapa lama, dan dampaknya.">{{ old('deskripsi', $laporan->deskripsi ?? '') }}</textarea>
            @error('deskripsi') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="text-sm font-medium text-slate-700" for="foto">Foto (JPG atau PNG, maksimal 2 MB)</label>
            <input id="foto" name="foto" type="file" accept="image/png,image/jpeg"
                   @change="foto = $event.target.files[0] ? URL.createObjectURL($event.target.files[0]) : null"
                   class="mt-1 block w-full text-sm text-slate-600 file:mr-3 file:rounded-lg file:border-0 file:bg-emerald-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-emerald-800 hover:file:bg-emerald-100">
            @error('foto') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
            <img x-show="foto" x-cloak :src="foto" class="mt-3 h-40 w-full rounded-lg object-cover" alt="Pratinjau foto">
            @if (! empty($laporan?->foto_path))
                <img x-show="!foto" src="{{ $laporan->foto_url }}" class="mt-3 h-40 w-full rounded-lg object-cover" alt="Foto saat ini">
                <p x-show="!foto" class="mt-1 text-xs text-slate-500">Foto saat ini. Pilih berkas baru untuk menggantinya.</p>
            @endif
        </div>
    </div>

    <div>
        <div class="flex items-center justify-between">
            <label class="text-sm font-medium text-slate-700">Lokasi masalah</label>
            <button type="button" id="btn-lokasi" class="rounded-lg border border-slate-300 px-3 py-1.5 text-xs font-semibold text-slate-700 hover:bg-slate-50">Gunakan lokasi saya</button>
        </div>
        <p class="mt-1 text-xs text-slate-500">Klik pada peta untuk menaruh penanda di titik yang tepat.</p>
        <div id="peta-form" class="mt-2 h-80 rounded-xl border border-slate-200"></div>
        <div class="mt-3 grid grid-cols-2 gap-3">
            <div>
                <label class="text-xs font-medium text-slate-600" for="latitude">Latitude</label>
                <input id="latitude" name="latitude" type="text" readonly class="{{ $in }} bg-slate-50" value="{{ old('latitude', $laporan->latitude ?? '') }}">
            </div>
            <div>
                <label class="text-xs font-medium text-slate-600" for="longitude">Longitude</label>
                <input id="longitude" name="longitude" type="text" readonly class="{{ $in }} bg-slate-50" value="{{ old('longitude', $laporan->longitude ?? '') }}">
            </div>
        </div>
        @error('latitude') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
        @error('longitude') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
    </div>
</div>

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.js"></script>
    <script>
        (function () {
            const latEl = document.getElementById('latitude');
            const lngEl = document.getElementById('longitude');
            const ada = latEl.value !== '' && lngEl.value !== '';
            const awal = ada ? [parseFloat(latEl.value), parseFloat(lngEl.value)] : [-6.9175, 107.6191];

            const peta = L.map('peta-form').setView(awal, ada ? 17 : 13);
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19, attribution: '&copy; OpenStreetMap'
            }).addTo(peta);

            let penanda = ada ? L.marker(awal).addTo(peta) : null;

            function atur(lat, lng) {
                latEl.value = lat.toFixed(7);
                lngEl.value = lng.toFixed(7);
                if (penanda) { penanda.setLatLng([lat, lng]); } else { penanda = L.marker([lat, lng]).addTo(peta); }
            }

            peta.on('click', e => atur(e.latlng.lat, e.latlng.lng));

            document.getElementById('btn-lokasi').addEventListener('click', function () {
                if (!navigator.geolocation) { alert('Peramban tidak mendukung lokasi. Klik langsung pada peta.'); return; }
                navigator.geolocation.getCurrentPosition(
                    p => { atur(p.coords.latitude, p.coords.longitude); peta.setView([p.coords.latitude, p.coords.longitude], 17); },
                    () => alert('Lokasi tidak bisa diakses. Klik langsung pada peta.')
                );
            });
        })();
    </script>
@endpush
