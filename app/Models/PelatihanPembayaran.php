<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PelatihanPembayaran extends Model
{
    use HasFactory;

    protected $table = 'pelatihan_pembayaran';

    protected $fillable = [
        'pelatihan_id',
        'user_id',
        'pelatihan_anggota_id',
        'jumlah_pembayaran',
        'status_pembayaran',
        'tanggal_pembayaran',
        'bukti_pembayaran',
        'catatan',
        'keterangan_admin',
    ];

    protected $casts = [
        'tanggal_pembayaran' => 'datetime',
    ];

    public function pelatihan(): BelongsTo
    {
        return $this->belongsTo(Pelatihan::class, 'pelatihan_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function pelatihanAnggota(): BelongsTo
    {
        return $this->belongsTo(PelatihanAnggota::class, 'pelatihan_anggota_id');
    }
}