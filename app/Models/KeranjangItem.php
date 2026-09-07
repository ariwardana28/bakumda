<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KeranjangItem extends Model
{
    protected $fillable = [
        'keranjang_id', 'produk_id', 'produk_ukuran_id', 'jumlah', 'harga', 'catatan',
    ];

    protected $casts = ['harga' => 'decimal:2', 'jumlah' => 'integer'];

    public function keranjang()
    {
        return $this->belongsTo(Keranjang::class);
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }

    public function ukuran()
    {
        return $this->belongsTo(ProdukUkuran::class, 'produk_ukuran_id');
    }
}
