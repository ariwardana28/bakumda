<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

use Illuminate\Database\Eloquent\Model;

class PelatihanAnggota extends Model
{
    protected $table = 'pelatihan_anggota';

    protected $fillable = [
        'pelatihan_id',
        'users_id',
        'nama',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'agama',
        'status_perkawinan',
        'pekerjaan',
        'kewarganegaraan',
        'email',
        'no_hp',
        'no_ktp',
        'alamat',
        'provinsi',
        'kota',
        'kecamatan',
        'kelurahan',
        'foto',
        'foto_ktp',
        'pakta_integritas',
        'keterangan',
        'bukti_pembayaran',
        'catatan_pembayaran',
    ];

    public function pelatihan(): BelongsTo
    {
        return $this->belongsTo(Pelatihan::class, 'pelatihan_id');
    }

    /**
     * Get the user that owns the PelatihanAnggota.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function statuses()
    {
        return $this->hasMany(PelatihanAnggotaStatus::class);
    }

    public function latestStatus()
    {
        // Mengambil record status terbaru berdasarkan ID (atau created_at)
        return $this->hasOne(PelatihanAnggotaStatus::class)->latestOfMany();
    }
}
