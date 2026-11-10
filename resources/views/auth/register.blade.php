<x-guest-layout>
    <h1 class="text-2xl font-extrabold text-slate-900">Buat akun warga</h1>
    <p class="mt-1 text-sm text-slate-600">Gratis, dan hanya butuh satu menit.</p>

    <form method="POST" action="{{ route('register') }}" class="mt-6 space-y-4">
        @csrf
        <div>
            <label for="name" class="text-sm font-medium text-slate-700">Nama lengkap</label>
            <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus autocomplete="name"
                   class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-emerald-600 focus:ring-emerald-600">
            @error('name') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
        </div>
        <div>
            <label for="email" class="text-sm font-medium text-slate-700">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required autocomplete="username"
                   class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-emerald-600 focus:ring-emerald-600">
            @error('email') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
        </div>
        <div>
            <label for="password" class="text-sm font-medium text-slate-700">Kata sandi</label>
            <input id="password" name="password" type="password" required autocomplete="new-password"
                   class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-emerald-600 focus:ring-emerald-600">
            @error('password') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
        </div>
        <div>
            <label for="password_confirmation" class="text-sm font-medium text-slate-700">Ulangi kata sandi</label>
            <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password"
                   class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-emerald-600 focus:ring-emerald-600">
        </div>
        <button class="w-full rounded-lg bg-emerald-700 px-4 py-2.5 text-sm font-semibold text-white hover:bg-emerald-800">Daftar</button>
    </form>

    <p class="mt-6 text-center text-sm text-slate-600">
        Sudah punya akun? <a href="{{ route('login') }}" class="font-semibold text-emerald-700 hover:underline">Masuk</a>
    </p>
</x-guest-layout>
