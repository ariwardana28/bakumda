<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\VerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * Kirim notifikasi verifikasi email menggunakan template BAKUMDA.
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmail);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'alamat',
        'provinsi',
        'kota',
        'kecamatan',
        'kelurahan',
        'no_hp',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'agama',
        'status_perkawinan',
        'pekerjaan',
        'kewarganegaraan',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the anggota record associated with the user.
     */
    public function anggota()
    {
        return $this->hasOne(\App\Models\Anggota::class);
    }

    // Milik User (pemilik kode)
    public function referralCodes()
    {
        return $this->hasMany(ReferralCode::class);
    }

    // Transaksi referral sebagai pemberi kode (referrer)
    public function referralTransactionsAsReferrer()
    {
        return $this->hasMany(ReferralTransaction::class, 'referrer_id');
    }

    // Histori pencairan dana referral user
    public function referralPayments()
    {
        return $this->hasMany(ReferralPayment::class);
    }

    public function referred()
    {
        return $this->belongsTo(User::class, 'referred_id');
    }

    public function keranjang()
    {
        return $this->hasOne(Keranjang::class);
    }

    public function pesanans()
    {
        return $this->hasMany(Pesanan::class);
    }
}
