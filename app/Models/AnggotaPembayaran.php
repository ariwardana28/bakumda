<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnggotaPembayaran extends Model
{
    use HasFactory;

    protected $table = 'anggota_pembayaran';

    protected $fillable = [
        'anggota_card_id',
        'bulan',
        'tahun',
        'status',
        'keterangan',
        'bukti_pembayaran',
        'nominal',
    ];

    public function anggotaCard()
    {
        return $this->belongsTo(AnggotaCard::class, 'anggota_card_id');
    }
}