@php $in = 'mt-1 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm focus:border-emerald-600 focus:ring-emerald-600'; @endphp
<div class="space-y-4">
    <div>
        <label class="text-sm font-medium text-slate-700" for="nama_wilayah">Nama wilayah</label>
        <input id="nama_wilayah" name="nama_wilayah" type="text" class="{{ $in }}" placeholder="Contoh: RT 03" value="{{ old('nama_wilayah', $wilayah->nama_wilayah ?? '') }}">
        @error('nama_wilayah') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="text-sm font-medium text-slate-700" for="jenis">Jenis</label>
        <select id="jenis" name="jenis" class="{{ $in }}">
            @foreach (['RT', 'RW', 'Kelurahan'] as $j)
                <option value="{{ $j }}" @selected(old('jenis', $wilayah->jenis ?? 'RT') === $j)>{{ $j }}</option>
            @endforeach
        </select>
        @error('jenis') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="text-sm font-medium text-slate-700" for="kode_wilayah">Kode wilayah</label>
        <input id="kode_wilayah" name="kode_wilayah" type="text" class="{{ $in }}" placeholder="Contoh: RW01-RT03" value="{{ old('kode_wilayah', $wilayah->kode_wilayah ?? '') }}">
        @error('kode_wilayah') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
    </div>
</div>
