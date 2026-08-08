<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnggotaBerlaku extends Model
{
    protected $table = 'anggota_berlaku';

    protected $fillable = [
        'anggota_card_id',
        'diterbitkan',
        'berlaku',
        'status_kartu',
        'jabatan',
        'keterangan',
    ];

     protected $casts = [
        'diterbitkan' => 'datetime',
        'berlaku' => 'datetime',
    ];

    public function anggotaCard()
    {
        return $this->belongsTo(AnggotaCard::class, 'anggota_card_id');
    }
}
