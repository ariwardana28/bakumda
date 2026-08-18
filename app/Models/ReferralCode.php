<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReferralCode extends Model
{
    use HasFactory;

    protected $table = 'referral_codes';

    protected $fillable = [
        'user_id',
        'code',
        'tier_type',
        'target_count',
        'current_uses',
    ];

    // Relasi: Pemilik kode referral adalah seorang User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: Satu kode referral bisa memiliki banyak transaksi penggunaan
    public function transactions()
    {
        return $this->hasMany(ReferralTransaction::class);
    }
}
