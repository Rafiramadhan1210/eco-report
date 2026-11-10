<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = 'kategori';

    protected $fillable = ['nama_kategori', 'deskripsi', 'tingkat_prioritas'];

    public function laporan()
    {
        return $this->hasMany(Laporan::class);
    }
}
