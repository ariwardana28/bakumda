<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelatihan extends Model
{
    protected $table = 'pelatihan';

    protected $fillable = [
        'judul',
        'deskripsi',
        'tanggal_mulai',
        'tanggal_selesai',
        'lokasi',
        'harga',
        'kuota',
        'gambar',
        'status',
    ];

    protected $casts = [
        'tanggal_mulai' => 'datetime',
        'tanggal_selesai' => 'datetime',
    ];

    /**
     * Mendapatkan data pendaftaran milik user yang sedang login untuk pelatihan ini.
     */
    public function userPendaftaran()
    {
        return $this->hasOne(PelatihanAnggota::class, 'pelatihan_id');
    }

    /**
     * Mendapatkan daftar materi yang terkait dengan pelatihan ini.
     */
    public function materi()
    {
        return $this->hasMany(Materi::class, 'pelatihan_id');
    }
}