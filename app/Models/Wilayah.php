<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wilayah extends Model
{
    protected $table = 'wilayah';

    protected $fillable = ['nama_wilayah', 'jenis', 'kode_wilayah'];

    public function laporan()
    {
        return $this->hasMany(Laporan::class);
    }

    public function pengguna()
    {
        return $this->hasMany(User::class);
    }
}
