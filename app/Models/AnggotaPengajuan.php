<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Relations\HasOne;

use Illuminate\Database\Eloquent\Model;

class AnggotaPengajuan extends Model
{
    protected $table = 'anggota_pengajuan';

    protected $fillable = [
        'anggota_card_id',
        'action',
        'user_id',
        'keterangan',
    ];

    /**
     * Get all of the statuses for the AnggotaPengajuan.
     */
    public function statuses()
    {
        return $this->hasMany(AnggotaStatusPengajuan::class, 'anggota_pengajuan_id');
    }

    /**
     * Get the latest status for the AnggotaPengajuan.
     */
    public function latestStatus(): HasOne
    {
        return $this->hasOne(AnggotaStatusPengajuan::class, 'anggota_pengajuan_id')->latestOfMany();
    }
}
