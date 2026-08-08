<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sertifikat extends Model
{
    protected $table = 'sertifikat';

    protected $fillable = [
        'no_sertifikat',
    ];

    // Tambahkan relasi ke Nilai
    public function nilai()
    {
        return $this->belongsToMany(Nilai::class, 'sertifikat_nilai', 'sertifikat_id', 'nilai_id');
    }

    // Tambahkan relasi/accessor pelatihan agar method with(['pelatihan']) tidak error
    public function getPelatihanAttribute()
    {
        return $this->nilai->first()->materi->pelatihan ?? null;
    }
}