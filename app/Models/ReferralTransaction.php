<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReferralTransaction extends Model
{
    use HasFactory;

    protected $table = 'referral_transactions';

    protected $fillable = [
        'referral_code_id',
        'referrer_id',
        'referred_id',
        'pelatihan_id',
        'reward_amount',
        'is_claimed',
        'status',
    ];

    // Relasi ke master kode referral
    public function referralCode()
    {
        return $this->belongsTo(ReferralCode::class);
    }

    // Relasi ke User pemilik referral (referrer)
    public function referrer()
    {
        return $this->belongsTo(User::class, 'referrer_id');
    }

    // Relasi ke User baru yang mendaftar (referred)
    public function referred()
    {
        return $this->belongsTo(User::class, 'referred_id');
    }

    // Relasi ke detail pembayaran (jika transaksi ini sudah masuk klaim pembayaran)
    public function paymentDetails()
    {
        return $this->hasMany(ReferralPaymentDetail::class);
    }
}
