<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReferralPaymentDetail extends Model
{
    use HasFactory;

    protected $table = 'referral_payment_details';

    protected $fillable = [
        'referral_payment_id',
        'referral_transaction_id',
        'reward_amount',
    ];

    // Relasi ke header pembayaran
    public function payment()
    {
        return $this->belongsTo(ReferralPayment::class, 'referral_payment_id');
    }

    // Relasi ke transaksi referral aslinya
    public function transaction()
    {
        return $this->belongsTo(ReferralTransaction::class, 'referral_transaction_id');
    }
}
