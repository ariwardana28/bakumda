<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kerjasama extends Model
{
    use HasFactory;

    protected $table = 'kerjasamas';

    protected $fillable = [
        'judul',
        'mitra',
        'deskripsi',
        'tanggal_mulai',
        'tanggal_selesai',
        'status',
        'file_dokumen',
        'biaya_pelatihan',
        'user_id',
    ];

    // Relasi ke seluruh riwayat status
    public function statuses()
    {
        return $this->hasMany(KerjasamaStatus::class, 'kerjasama_id');
    }

    // Relasi untuk mengambil status yang paling terakhir (terbaru)
    public function latestStatus()
    {
        return $this->hasOne(KerjasamaStatus::class, 'kerjasama_id')->latestOfMany();
    }

    public function dokumens()
    {
        return $this->hasMany(KerjasamaDokumen::class, 'kerjasama_id');
    }
}
