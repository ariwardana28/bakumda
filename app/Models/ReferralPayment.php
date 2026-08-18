<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReferralPayment extends Model
{
    use HasFactory;

    protected $table = 'referral_payments';

    protected $fillable = [
        'user_id',
        'amount',
        'status',
        'bank_name',
        'account_number',
        'account_name',
    ];

    // Relasi: Pencairan dana milik seorang User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: Satu pencairan memiliki banyak detail transaksi
    public function details()
    {
        return $this->hasMany(ReferralPaymentDetail::class);
    }
}
