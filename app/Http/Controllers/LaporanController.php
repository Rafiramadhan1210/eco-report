<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Laporan;
use App\Models\Wilayah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class LaporanController extends Controller
{
    public function index()
    {
        $laporan = Laporan::with(['kategori', 'wilayah'])
            ->where('user_id', auth()->id())
            ->latest()->paginate(8);

        return view('laporan.index', compact('laporan'));
    }

    public function create()
    {
        return view('laporan.create', $this->pilihan());
    }

    public function store(Request $request)
    {
        $data = $this->validasi($request, true);

        $data['foto_path'] = $request->file('foto')->store('laporan', 'public');
        unset($data['foto']);

        $data['user_id'] = $request->user()->id;
        $data['status'] = 'Baru';

        Laporan::create($data);

        return redirect()->route('laporan.index')
            ->with('success', 'Laporan berhasil dikirim dan menunggu verifikasi pengurus.');
    }

    public function show(Laporan $laporan)
    {
        abort_unless($laporan->bisaDilihat(auth()->user()), 403, 'Anda tidak memiliki akses ke laporan ini.');

        $laporan->load(['user', 'kategori', 'wilayah', 'tindakLanjut.pengurus', 'komentar.user']);

        return view('laporan.show', compact('laporan'));
    }

    public function edit(Laporan $laporan)
    {
        $this->izinUbah($laporan);

        return view('laporan.edit', ['laporan' => $laporan] + $this->pilihan());
    }

    public function update(Request $request, Laporan $laporan)
    {
        $this->izinUbah($laporan);

        $data = $this->validasi($request, false);

        if ($request->hasFile('foto')) {
            if ($laporan->foto_path) {
                Storage::disk('public')->delete($laporan->foto_path);
            }
            $data['foto_path'] = $request->file('foto')->store('laporan', 'public');
        }
        unset($data['foto']);

        $laporan->update($data);

        return redirect()->route('laporan.show', $laporan)->with('success', 'Laporan berhasil diperbarui.');
    }

    public function destroy(Laporan $laporan)
    {
        $this->izinUbah($laporan);

        if ($laporan->foto_path) {
            Storage::disk('public')->delete($laporan->foto_path);
        }
        $laporan->delete();

        return redirect()->route('laporan.index')->with('success', 'Laporan berhasil dibatalkan.');
    }

    private function izinUbah(Laporan $laporan): void
    {
        abort_unless($laporan->user_id === auth()->id(), 403, 'Ini bukan laporan Anda.');
        abort_unless($laporan->status === 'Baru', 403, 'Laporan hanya bisa diubah atau dibatalkan selama statusnya Baru.');
    }

    private function pilihan(): array
    {
        return [
            'kategori' => Kategori::orderBy('nama_kategori')->get(),
            'wilayah' => Wilayah::orderBy('nama_wilayah')->get(),
        ];
    }

    private function validasi(Request $request, bool $wajibFoto): array
    {
        $lainnya = Kategori::find($request->kategori_id)?->nama_kategori === 'Lainnya';

        $data = $request->validate([
            'kategori_id' => 'required|exists:kategori,id',
            'kategori_lain' => [Rule::requiredIf($lainnya), 'nullable', 'string', 'max:100'],
            'wilayah_id' => 'required|exists:wilayah,id',
            'judul' => 'required|string|max:150',
            'deskripsi' => 'required|string|min:10',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'foto' => [$wajibFoto ? 'required' : 'nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ], [
            'kategori_id.required' => 'Pilih jenis masalah.',
            'kategori_lain.required' => 'Tuliskan jenis masalah yang Anda laporkan.',
            'wilayah_id.required' => 'Pilih wilayah.',
            'judul.required' => 'Judul laporan wajib diisi.',
            'deskripsi.required' => 'Deskripsi wajib diisi.',
            'deskripsi.min' => 'Deskripsi minimal 10 karakter.',
            'latitude.required' => 'Tentukan lokasi pada peta.',
            'longitude.required' => 'Tentukan lokasi pada peta.',
            'latitude.numeric' => 'Koordinat tidak valid.',
            'longitude.numeric' => 'Koordinat tidak valid.',
            'foto.required' => 'Foto wajib diunggah.',
            'foto.image' => 'Berkas harus berupa gambar.',
            'foto.mimes' => 'Foto harus berformat JPG atau PNG.',
            'foto.max' => 'Ukuran foto maksimal 2 MB.',
        ]);

        if (! $lainnya) {
            $data['kategori_lain'] = null;
        }

        return $data;
    }
}
