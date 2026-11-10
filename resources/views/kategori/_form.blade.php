<div class="space-y-4">
    <div>
        <x-input-label for="nama_kategori" value="Nama Kategori" />
        <x-text-input id="nama_kategori" name="nama_kategori" type="text" class="mt-1 block w-full"
            :value="old('nama_kategori', $kategori->nama_kategori ?? '')" />
        <x-input-error :messages="$errors->get('nama_kategori')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="deskripsi" value="Deskripsi" />
        <textarea id="deskripsi" name="deskripsi" rows="3"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('deskripsi', $kategori->deskripsi ?? '') }}</textarea>
        <x-input-error :messages="$errors->get('deskripsi')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="tingkat_prioritas" value="Tingkat Prioritas" />
        <select id="tingkat_prioritas" name="tingkat_prioritas"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            @foreach (['rendah', 'sedang', 'tinggi'] as $p)
                <option value="{{ $p }}"
                    {{ old('tingkat_prioritas', $kategori->tingkat_prioritas ?? 'sedang') === $p ? 'selected' : '' }}>
                    {{ ucfirst($p) }}
                </option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('tingkat_prioritas')" class="mt-2" />
    </div>
</div>