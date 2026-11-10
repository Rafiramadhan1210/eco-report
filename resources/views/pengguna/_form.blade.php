@php $in = 'mt-1 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm focus:border-emerald-600 focus:ring-emerald-600'; $edit = isset($user); @endphp
<div class="space-y-4">
    <div>
        <label class="text-sm font-medium text-slate-700" for="name">Nama</label>
        <input id="name" name="name" type="text" class="{{ $in }}" value="{{ old('name', $user->name ?? '') }}">
        @error('name') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="text-sm font-medium text-slate-700" for="email">Email</label>
        <input id="email" name="email" type="email" class="{{ $in }}" value="{{ old('email', $user->email ?? '') }}">
        @error('email') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="text-sm font-medium text-slate-700" for="password">Kata sandi @if ($edit)<span class="font-normal text-slate-500">(kosongkan jika tidak diganti)</span>@endif</label>
        <input id="password" name="password" type="password" class="{{ $in }}" autocomplete="new-password">
        @error('password') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
    </div>
    <div class="grid gap-4 sm:grid-cols-2">
        <div>
            <label class="text-sm font-medium text-slate-700" for="role">Peran</label>
            <select id="role" name="role" class="{{ $in }}">
                @foreach (['warga', 'pengurus', 'admin'] as $r)
                    <option value="{{ $r }}" @selected(old('role', $user->role ?? 'warga') === $r)>{{ ucfirst($r) }}</option>
                @endforeach
            </select>
            @error('role') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="text-sm font-medium text-slate-700" for="no_hp">No. HP</label>
            <input id="no_hp" name="no_hp" type="text" class="{{ $in }}" value="{{ old('no_hp', $user->no_hp ?? '') }}">
            @error('no_hp') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
        </div>
    </div>
    <div>
        <label class="text-sm font-medium text-slate-700" for="wilayah_id">Wilayah <span class="font-normal text-slate-500">(wajib untuk pengurus)</span></label>
        <select id="wilayah_id" name="wilayah_id" class="{{ $in }}">
            <option value="">Tanpa wilayah</option>
            @foreach ($wilayah as $w)
                <option value="{{ $w->id }}" @selected(old('wilayah_id', $user->wilayah_id ?? '') == $w->id)>{{ $w->nama_wilayah }} ({{ $w->jenis }})</option>
            @endforeach
        </select>
        @error('wilayah_id') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
    </div>
</div>
