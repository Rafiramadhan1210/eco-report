<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Laporan;
use App\Models\User;
use App\Models\Wilayah;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $u = auth()->user();

        $q = Laporan::query();
        if ($u->role === 'warga') {
            $q->where('user_id', $u->id);
        } elseif ($u->role === 'pengurus') {
            $q->where('wilayah_id', $u->wilayah_id);
        }

        $stat = ['total' => (clone $q)->count()];
        foreach (['Baru', 'Diproses', 'Selesai', 'Ditolak'] as $s) {
            $stat[$s] = (clone $q)->where('status', $s)->count();
        }

        $terbaru = (clone $q)->with(['kategori', 'user'])->latest()->take(6)->get();

        $admin = $u->role === 'admin'
            ? ['pengguna' => User::count(), 'kategori' => Kategori::count(), 'wilayah' => Wilayah::count()]
            : null;

        return view('dashboard', compact('stat', 'terbaru', 'admin'));
    }
}
