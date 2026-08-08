<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnggotaStatus extends Model
{
    protected $table = 'anggota_status';

    protected $fillable = [
        'anggota_card_id',
        'user_id',
        'status',
        'keterangan',
    ];

    public function anggotaCard()
    {
        return $this->belongsTo(AnggotaCard::class, 'anggota_card_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
