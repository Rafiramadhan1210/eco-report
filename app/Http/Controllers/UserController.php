<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Wilayah;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $q = User::with('wilayah');

        if ($request->filled('q')) {
            $kata = '%' . $request->q . '%';
            $q->where(fn ($w) => $w->where('name', 'like', $kata)->orWhere('email', 'like', $kata));
        }
        if ($request->filled('role')) {
            $q->where('role', $request->role);
        }

        $pengguna = $q->latest()->paginate(10)->withQueryString();

        return view('pengguna.index', compact('pengguna'));
    }

    public function create()
    {
        return view('pengguna.create', ['wilayah' => Wilayah::orderBy('nama_wilayah')->get()]);
    }

    public function store(Request $request)
    {
        User::create($this->validasi($request));

        return redirect()->route('pengguna.index')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        return view('pengguna.edit', [
            'user' => $user,
            'wilayah' => Wilayah::orderBy('nama_wilayah')->get(),
        ]);
    }

    public function update(Request $request, User $user)
    {
        $data = $this->validasi($request, $user);

        if (empty($data['password'])) {
            unset($data['password']);
        }

        $user->update($data);

        return redirect()->route('pengguna.index')->with('success', 'Pengguna berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('pengguna.index')->with('error', 'Anda tidak bisa menghapus akun yang sedang dipakai.');
        }

        $user->delete();

        return redirect()->route('pengguna.index')->with('success', 'Pengguna berhasil dihapus.');
    }

    private function validasi(Request $request, ?User $user = null): array
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user?->id)],
            'password' => [$user ? 'nullable' : 'required', 'string', 'min:8'],
            'role' => 'required|in:warga,pengurus,admin',
            'no_hp' => 'nullable|string|max:20',
            'wilayah_id' => [Rule::requiredIf($request->role === 'pengurus'), 'nullable', 'exists:wilayah,id'],
        ], [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min' => 'Kata sandi minimal 8 karakter.',
            'role.required' => 'Peran wajib dipilih.',
            'wilayah_id.required' => 'Pengurus harus memiliki wilayah.',
        ]);
    }
}
