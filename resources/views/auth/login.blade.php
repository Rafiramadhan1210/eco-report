<x-guest-layout>
    <h1 class="text-2xl font-extrabold text-slate-900">Masuk</h1>
    <p class="mt-1 text-sm text-slate-600">Masuk untuk membuat dan memantau laporan.</p>

    <x-auth-session-status class="mt-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="mt-6 space-y-4">
        @csrf
        <div>
            <label for="email" class="text-sm font-medium text-slate-700">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                   class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-emerald-600 focus:ring-emerald-600">
            @error('email') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
        </div>
        <div>
            <label for="password" class="text-sm font-medium text-slate-700">Kata sandi</label>
            <input id="password" name="password" type="password" required autocomplete="current-password"
                   class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-emerald-600 focus:ring-emerald-600">
            @error('password') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
        </div>
        <label class="flex items-center gap-2 text-sm text-slate-600">
            <input type="checkbox" name="remember" class="rounded border-slate-300 text-emerald-700 focus:ring-emerald-600"> Ingat saya
        </label>
        <button class="w-full rounded-lg bg-emerald-700 px-4 py-2.5 text-sm font-semibold text-white hover:bg-emerald-800">Masuk</button>
    </form>

    <p class="mt-6 text-center text-sm text-slate-600">
        Belum punya akun? <a href="{{ route('register') }}" class="font-semibold text-emerald-700 hover:underline">Daftar sebagai warga</a>
    </p>
</x-guest-layout>
