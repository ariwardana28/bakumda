<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    protected $table = 'anggota';

    protected $fillable = [
        'nama',
        'no_ktp',
        'alamat',
        'provinsi',
        'kota',
        'kecamatan',
        'kelurahan',
        'no_hp',
        'email',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'agama',
        'status_perkawinan',
        'pekerjaan',
        'kewarganegaraan',
        'foto',
        'foto_ktp',
        'pakta_integritas',
        'keterangan',
        'user_id',
    ];

    /**
     * Get the card associated with the Anggota.
     */
    public function card()
    {
        // Mengambil card terbaru yang dimiliki oleh anggota ini
        return $this->hasOne(AnggotaCard::class, 'anggota_id', 'id')->latest('id');
    }

    /**
     * Get all of the edit requests for the Anggota.
     */
    public function editRequests()
    {
        return $this->hasManyThrough(AnggotaPengajuan::class, AnggotaCard::class);
    }

    /**
     * Get the pending edit request for the Anggota.
     * This is a hasOneThrough relationship to find a single pending request.
     */
    public function pendingEditRequest()
    {
        // Mengambil satu permintaan edit terbaru yang statusnya 'approved'.
        // Ini adalah cara yang lebih eksplisit dan seringkali lebih mudah untuk di-debug.
        return $this->hasOne(AnggotaPengajuan::class, 'anggota_card_id', 'id')
                    ->whereHas('latestStatus', function ($query) {
                        $query->where('status', 'approved');
                    })
                    ->latestOfMany();
    }

    public function statuses()
    {
        return $this->hasManyThrough(
            AnggotaStatus::class,
            AnggotaCard::class,
            'anggota_id',        // Foreign key di tabel anggota_card
            'anggota_card_id',   // Foreign key di tabel anggota_status
            'id',                // Local key di tabel anggota
            'id'                 // Local key di tabel anggota_card
        );
    }

    /**
     * Helper untuk mengecek apakah status kartu terakhir sudah approved/aktif.
     */
    public function isApproved()
    {
        $latestStatus = $this->latest_status;
        return $latestStatus && strtolower($latestStatus->status) === 'approved';
    }

    /**
     * Accessor untuk langsung mengambil status terakhir dengan akurat.
     */
    public function getLatestStatusAttribute()
    {
        if ($this->card) {
            return AnggotaStatus::where('anggota_card_id', $this->card->id)->orderBy('id', 'desc')->first();
        }
        return null;
    }
}