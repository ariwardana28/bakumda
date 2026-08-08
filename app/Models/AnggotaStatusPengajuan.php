<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnggotaStatusPengajuan extends Model
{
    protected $table = 'anggota_pengajuan_status';

    protected $fillable = [
        'anggota_pengajuan_id',
        'status',
        'keterangan',
    ];
}
