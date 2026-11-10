<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    protected $table = 'laporan';

    protected $fillable = [
        'user_id', 'kategori_id', 'wilayah_id', 'kategori_lain',
        'judul', 'deskripsi', 'latitude', 'longitude', 'foto_path', 'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function wilayah()
    {
        return $this->belongsTo(Wilayah::class);
    }

    public function tindakLanjut()
    {
        return $this->hasMany(TindakLanjut::class)->latest('tanggal_tindak');
    }

    public function komentar()
    {
        return $this->hasMany(Komentar::class)->oldest();
    }

    public function getFotoUrlAttribute(): ?string
    {
        return $this->foto_path ? asset('storage/' . $this->foto_path) : null;
    }

    public function getJenisMasalahAttribute(): string
    {
        return $this->kategori_lain ?: ($this->kategori->nama_kategori ?? '-');
    }

    public function bisaDilihat(User $u): bool
    {
        return $u->role === 'admin'
            || ($u->role === 'warga' && $this->user_id === $u->id)
            || ($u->role === 'pengurus' && $u->wilayah_id !== null && $this->wilayah_id === $u->wilayah_id);
    }
}
