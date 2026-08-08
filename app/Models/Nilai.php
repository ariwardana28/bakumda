<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    protected $table = 'nilai';

    protected $fillable = [
        'pelatihan_anggota_id',
        'materi_id',
        'nilai',
        'nilai_total_soal',
        'keterangan',
        'status',
    ];

    public function pelatihanAnggota()
    {
        return $this->belongsTo(PelatihanAnggota::class, 'pelatihan_anggota_id');
    }

    public function materi()
    {
        return $this->belongsTo(Materi::class, 'materi_id');
    }

    public function nilaiSoal()
    {
        return $this->hasMany(NilaiSoal::class);
    }
}
