<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TindakLanjut extends Model
{
    protected $table = 'tindak_lanjut';

    protected $fillable = ['laporan_id', 'pengurus_id', 'status_baru', 'catatan', 'foto_bukti', 'tanggal_tindak'];

    protected function casts(): array
    {
        return ['tanggal_tindak' => 'datetime'];
    }

    public function laporan()
    {
        return $this->belongsTo(Laporan::class);
    }

    public function pengurus()
    {
        return $this->belongsTo(User::class, 'pengurus_id');
    }

    public function getFotoUrlAttribute(): ?string
    {
        return $this->foto_bukti ? asset('storage/' . $this->foto_bukti) : null;
    }
}
