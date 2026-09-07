<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    protected $fillable = ['user_id', 'total', 'status', 'bukti_pembayaran', 'catatan', 'dibayar_pada'];

    protected $casts = ['total' => 'decimal:2', 'dibayar_pada' => 'datetime'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(PesananItem::class);
    }
}
