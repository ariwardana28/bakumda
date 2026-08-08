<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Materi extends Model
{
    use HasFactory;

    protected $table = 'materi';

    protected $fillable = [
        'pelatihan_id',
        'judul',
        'deskripsi',
        'file',
        'status',
        'gambar',
    ];

    /**
     * Mendapatkan data pelatihan yang memiliki materi ini.
     */
    public function pelatihan(): BelongsTo
    {
        return $this->belongsTo(Pelatihan::class);
    }

    /**
     * Get all of the soal for the Materi.
     */
    public function soal()
    {
        return $this->hasMany(Soal::class);
    }

    public function userKuis()
    {
        // Mendapatkan anggota_id berdasarkan user yang sedang login (sesuaikan dengan logika autentikasi aplikasi Anda)
        $pelatihanAnggotaId = \App\Models\PelatihanAnggota::where('user_id', auth()->id())->value('id');

        return $this->hasOne(Nilai::class, 'materi_id', 'id')
                    ->where('pelatihan_anggota_id', $pelatihanAnggotaId);
    }
    
}
