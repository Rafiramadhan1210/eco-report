<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LaporanMasukController extends Controller
{
    public function index(Request $request)
    {
        $q = $this->dasar()->with(['kategori', 'user', 'wilayah']);

        if ($request->filled('status')) {
            $q->where('status', $request->status);
        }
        if ($request->filled('kategori_id')) {
            $q->where('kategori_id', $request->kategori_id);
        }
        if ($request->filled('q')) {
            $q->where('judul', 'like', '%' . $request->q . '%');
        }

        $laporan = $q->latest()->paginate(10)->withQueryString();
        $kategori = Kategori::orderBy('nama_kategori')->get();

        return view('kelola.laporan', compact('laporan', 'kategori'));
    }

    public function peta()
    {
        $titik = $this->dasar()->with('kategori')->get()->map(fn ($l) => [
            'judul' => $l->judul,
            'status' => $l->status,
            'jenis' => $l->jenis_masalah,
            'lat' => (float) $l->latitude,
            'lng' => (float) $l->longitude,
            'url' => route('laporan.show', $l),
        ]);

        return view('kelola.peta', compact('titik'));
    }

    public function tindakLanjut(Request $request, Laporan $laporan)
    {
        abort_unless($laporan->bisaDilihat($request->user()), 403);

        $data = $request->validate([
            'status' => 'required|in:Diproses,Selesai,Ditolak',
            'catatan' => 'required|string|min:5|max:1000',
            'foto_bukti' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'status.required' => 'Pilih status baru.',
            'catatan.required' => 'Catatan wajib diisi (untuk status Ditolak, tuliskan alasannya).',
            'catatan.min' => 'Catatan minimal 5 karakter.',
            'foto_bukti.image' => 'Foto bukti harus berupa gambar.',
            'foto_bukti.max' => 'Ukuran foto bukti maksimal 2 MB.',
        ]);

        $foto = $request->hasFile('foto_bukti')
            ? $request->file('foto_bukti')->store('bukti', 'public')
            : null;

        $laporan->tindakLanjut()->create([
            'pengurus_id' => $request->user()->id,
            'status_baru' => $data['status'],
            'catatan' => $data['catatan'],
            'foto_bukti' => $foto,
            'tanggal_tindak' => now(),
        ]);

        $laporan->update(['status' => $data['status']]);

        return back()->with('success', 'Status laporan diperbarui menjadi ' . $data['status'] . '.');
    }

    public function destroy(Laporan $laporan)
    {
        if ($laporan->foto_path) {
            Storage::disk('public')->delete($laporan->foto_path);
        }
        $laporan->delete();

        return redirect()->route('kelola.laporan')->with('success', 'Laporan berhasil dihapus.');
    }

    private function dasar()
    {
        $u = auth()->user();
        $q = Laporan::query();

        if ($u->role === 'pengurus') {
            $q->where('wilayah_id', $u->wilayah_id);
        }

        return $q;
    }
}
