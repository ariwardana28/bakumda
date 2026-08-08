<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Casts\Attribute;


class AnggotaCard extends Model
{
    protected $table = 'anggota_card';

    protected $fillable = [
        'anggota_id',
        'card_id',
        'qr_code',
        'jabatan',
        'diterbitkan',
        'berlaku',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
   
    protected $casts = [
        'diterbitkan' => 'datetime',
        'berlaku' => 'datetime',
    ];

    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'anggota_id');
    }

    public function anggotaStatus()
    {
        // Gunakan hasMany jika satu kartu memiliki banyak riwayat status
        return $this->hasMany(AnggotaStatus::class, 'anggota_card_id')->orderBy('id', 'desc');
    }

    public function statuses(): HasMany
    {
        return $this->hasMany(AnggotaStatus::class, 'anggota_card_id');
    }

    // Tambahkan relasi latestStatus agar tidak error saat di-eager load
    public function latestStatus(): HasOne
    {
        return $this->hasOne(AnggotaStatus::class, 'anggota_card_id')->latestOfMany();
    }

    // Relasi untuk semua riwayat masa berlaku
    public function berlakuHistory(): HasMany
    {
        return $this->hasMany(AnggotaBerlaku::class, 'anggota_card_id');
    }

    // Relasi untuk mendapatkan data masa berlaku yang paling baru
    public function latestBerlaku(): HasOne
    {
        return $this->hasOne(AnggotaBerlaku::class, 'anggota_card_id')->latestOfMany();
    }

    /**
     * Accessor untuk mendapatkan status yang akan ditampilkan.
     * Mengambil dari relasi `latestStatus` jika ada, jika tidak, gunakan kolom `status` di tabel ini.
     */
    protected function displayStatus(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->latestStatus->status ?? $this->status ?? 'Draft'
        );
    }

    /**
     * Accessor untuk mendapatkan kelas CSS berdasarkan status.
     * Mengembalikan array berisi kelas untuk badge, dot, dan tombol aksi.
     */
    protected function statusClasses(): Attribute
    {
        return Attribute::make(
            get: function () {
                $statusStr = strtolower($this->display_status);

                $classes = match (true) {
                    in_array($statusStr, ['approved', 'disetujui', 'aktif']) => [
                        'badge' => 'bg-emerald-50 text-emerald-600 dark:bg-emerald-950/40 dark:text-emerald-400 border-emerald-200 dark:border-emerald-800',
                        'dot' => 'bg-emerald-500',
                        'action' => 'text-emerald-600 hover:text-emerald-700 bg-emerald-50 hover:bg-emerald-100 dark:bg-emerald-600/10 dark:text-emerald-400 dark:hover:bg-emerald-600/20',
                    ],
                    in_array($statusStr, ['pending', 'menunggu', 'proses', 'menunggu pembayaran', 'pembayaran diproses']) => [
                        'badge' => 'bg-amber-50 text-amber-600 dark:bg-amber-950/40 dark:text-amber-400 border-amber-200 dark:border-amber-800',
                        'dot' => 'bg-amber-500',
                        'action' => 'text-amber-600 hover:text-amber-700 bg-amber-50 hover:bg-amber-100 dark:bg-amber-600/10 dark:text-amber-400 dark:hover:bg-amber-600/20',
                    ],
                    in_array($statusStr, ['ditolak', 'rejected', 'nonaktif']) => [
                        'badge' => 'bg-rose-50 text-rose-600 dark:bg-rose-950/40 dark:text-rose-400 border-rose-200 dark:border-rose-800',
                        'dot' => 'bg-rose-500',
                        'action' => 'text-rose-600 hover:text-rose-700 bg-rose-50 hover:bg-rose-100 dark:bg-rose-600/10 dark:text-rose-400 dark:hover:bg-rose-600/20',
                    ],
                    default => [
                        'badge' => 'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-300 border-gray-200 dark:border-gray-600',
                        'dot' => 'bg-gray-400',
                        'action' => 'text-brand-600 hover:text-brand-700 bg-brand-50 hover:bg-brand-100 dark:bg-brand-600/10 dark:text-brand-400 dark:hover:bg-brand-600/20',
                    ],
                };

                return (object) $classes;
            }
        );
    }
}
