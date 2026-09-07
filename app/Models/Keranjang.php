<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    protected $fillable = ['user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(KeranjangItem::class);
    }

    public function getTotalAttribute(): float
    {
        return (float) $this->items->sum(fn ($item) => $item->harga * $item->jumlah);
    }
}
