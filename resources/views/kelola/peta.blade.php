<x-app-layout>
    @push('styles')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.css">
    @endpush

    <x-slot name="header">
        <h1 class="text-xl font-extrabold text-slate-900">Peta sebaran laporan</h1>
        <p class="mt-1 text-sm text-slate-500">Klik penanda untuk melihat ringkasan dan membuka detail laporan.</p>
    </x-slot>

    <div class="mb-4 flex flex-wrap gap-4 text-sm">
        @foreach (['Baru' => '#0ea5e9', 'Diproses' => '#f59e0b', 'Selesai' => '#10b981', 'Ditolak' => '#f43f5e'] as $s => $w)
            <span class="flex items-center gap-2"><span class="h-3 w-3 rounded-full" style="background: {{ $w }}"></span>{{ $s }}</span>
        @endforeach
    </div>

    <div id="peta" class="h-[32rem] rounded-2xl border border-slate-200"></div>

    @push('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.js"></script>
        <script>
            (function () {
                const titik = @json($titik);
                const warna = { Baru: '#0ea5e9', Diproses: '#f59e0b', Selesai: '#10b981', Ditolak: '#f43f5e' };
                const peta = L.map('peta').setView([-6.9175, 107.6191], 14);
                L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 19, attribution: '&copy; OpenStreetMap' }).addTo(peta);

                const batas = [];
                titik.forEach(t => {
                    const m = L.circleMarker([t.lat, t.lng], {
                        radius: 10, color: '#ffffff', weight: 2, fillColor: warna[t.status] || '#64748b', fillOpacity: 0.95
                    }).addTo(peta);
                    const isi = document.createElement('div');
                    isi.innerHTML = '<strong></strong><br><small></small><br><a style="color:#047857">Buka detail</a>';
                    isi.querySelector('strong').textContent = t.judul;
                    isi.querySelector('small').textContent = t.jenis + ' - ' + t.status;
                    isi.querySelector('a').href = t.url;
                    m.bindPopup(isi);
                    batas.push([t.lat, t.lng]);
                });
                if (batas.length) { peta.fitBounds(batas, { padding: [40, 40], maxZoom: 16 }); }
            })();
        </script>
    @endpush
</x-app-layout>
