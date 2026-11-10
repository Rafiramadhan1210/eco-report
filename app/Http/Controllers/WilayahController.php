<?php

namespace App\Http\Controllers;

use App\Models\Wilayah;
use Illuminate\Http\Request;

class WilayahController extends Controller
{
    public function index(Request $request)
    {
        $q = Wilayah::withCount(['laporan', 'pengguna']);

        if ($request->filled('q')) {
            $q->where('nama_wilayah', 'like', '%' . $request->q . '%');
        }

        $wilayah = $q->orderBy('kode_wilayah')->paginate(10)->withQueryString();

        return view('wilayah.index', compact('wilayah'));
    }

    public function create()
    {
        return view('wilayah.create');
    }

    public function store(Request $request)
    {
        Wilayah::create($this->validasi($request));

        return redirect()->route('wilayah.index')->with('success', 'Wilayah berhasil ditambahkan.');
    }

    public function edit(Wilayah $wilayah)
    {
        return view('wilayah.edit', compact('wilayah'));
    }

    public function update(Request $request, Wilayah $wilayah)
    {
        $wilayah->update($this->validasi($request, $wilayah->id));

        return redirect()->route('wilayah.index')->with('success', 'Wilayah berhasil diperbarui.');
    }

    public function destroy(Wilayah $wilayah)
    {
        if ($wilayah->laporan()->exists() || $wilayah->pengguna()->exists()) {
            return redirect()->route('wilayah.index')
                ->with('error', 'Wilayah tidak bisa dihapus karena masih dipakai laporan atau pengguna.');
        }

        $wilayah->delete();

        return redirect()->route('wilayah.index')->with('success', 'Wilayah berhasil dihapus.');
    }

    private function validasi(Request $request, ?int $id = null): array
    {
        return $request->validate([
            'nama_wilayah' => 'required|string|max:255',
            'jenis' => 'required|in:RT,RW,Kelurahan',
            'kode_wilayah' => 'required|string|max:50|unique:wilayah,kode_wilayah,' . $id,
        ], [
            'nama_wilayah.required' => 'Nama wilayah wajib diisi.',
            'jenis.required' => 'Jenis wilayah wajib dipilih.',
            'kode_wilayah.required' => 'Kode wilayah wajib diisi.',
            'kode_wilayah.unique' => 'Kode wilayah sudah dipakai.',
        ]);
    }
}
