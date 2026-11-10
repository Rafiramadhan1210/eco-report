<?php

namespace App\Http\Controllers;

use App\Models\Komentar;
use App\Models\Laporan;
use Illuminate\Http\Request;

class KomentarController extends Controller
{
    public function store(Request $request, Laporan $laporan)
    {
        abort_unless($laporan->bisaDilihat($request->user()), 403);

        $laporan->komentar()->create([
            'user_id' => $request->user()->id,
            'isi' => $this->validasi($request),
        ]);

        return back()->with('success', 'Komentar ditambahkan.');
    }

    public function update(Request $request, Komentar $komentar)
    {
        abort_unless($komentar->user_id === $request->user()->id, 403, 'Hanya pemilik komentar yang dapat mengubahnya.');

        $komentar->update(['isi' => $this->validasi($request)]);

        return back()->with('success', 'Komentar diperbarui.');
    }

    public function destroy(Request $request, Komentar $komentar)
    {
        abort_unless(
            $komentar->user_id === $request->user()->id || $request->user()->role === 'admin',
            403,
            'Hanya pemilik komentar yang dapat menghapusnya.'
        );

        $komentar->delete();

        return back()->with('success', 'Komentar dihapus.');
    }

    private function validasi(Request $request): string
    {
        return $request->validate(
            ['isi' => 'required|string|max:1000'],
            ['isi.required' => 'Komentar tidak boleh kosong.', 'isi.max' => 'Komentar maksimal 1000 karakter.']
        )['isi'];
    }
}
