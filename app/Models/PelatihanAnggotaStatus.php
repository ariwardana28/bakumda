<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PelatihanAnggotaStatus extends Model
{
    protected $table = 'pelatihan_anggota_status';

    protected $fillable = [
        'pelatihan_anggota_id',
        'status',
        'keterangan',
    ];

    public function pelatihanAnggota()
    {
        return $this->belongsTo(PelatihanAnggota::class, 'pelatihan_anggota_id');
    }
}
