<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProdukUkuran extends Model
{
    protected $table = 'produk_ukuran';

    protected $fillable = [
        'produk_id',
        'ukuran',
        'harga',
        'status',
        'stok',
        'keterangan',
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }
}
