<?php

namespace Database\Seeders;

use App\Models\Kategori;
use App\Models\User;
use App\Models\Wilayah;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Wilayah::create(['nama_wilayah' => 'RW 01', 'jenis' => 'RW', 'kode_wilayah' => 'RW01']);
        $rt1 = Wilayah::create(['nama_wilayah' => 'RT 01', 'jenis' => 'RT', 'kode_wilayah' => 'RW01-RT01']);
        Wilayah::create(['nama_wilayah' => 'RT 02', 'jenis' => 'RT', 'kode_wilayah' => 'RW01-RT02']);

        Kategori::create(['nama_kategori' => 'Sampah Liar', 'deskripsi' => 'Tumpukan sampah di lokasi yang tidak semestinya', 'tingkat_prioritas' => 'sedang']);
        Kategori::create(['nama_kategori' => 'Saluran Air Tersumbat', 'deskripsi' => 'Selokan atau drainase tersumbat', 'tingkat_prioritas' => 'tinggi']);
        Kategori::create(['nama_kategori' => 'Pohon Tumbang', 'deskripsi' => 'Pohon tumbang atau rawan tumbang', 'tingkat_prioritas' => 'tinggi']);
        Kategori::create(['nama_kategori' => 'Lainnya', 'deskripsi' => 'Masalah lain di luar kategori yang tersedia', 'tingkat_prioritas' => 'sedang']);

        User::create(['name' => 'Admin', 'email' => 'admin@ecoreport.test', 'password' => 'password', 'role' => 'admin']);
        User::create(['name' => 'Pengurus RT 01', 'email' => 'pengurus@ecoreport.test', 'password' => 'password', 'role' => 'pengurus', 'wilayah_id' => $rt1->id]);
        User::create(['name' => 'Warga Contoh', 'email' => 'warga@ecoreport.test', 'password' => 'password', 'role' => 'warga', 'wilayah_id' => $rt1->id]);
    }
}