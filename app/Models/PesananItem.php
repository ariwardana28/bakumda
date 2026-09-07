<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PesananItem extends Model
{
    protected $fillable = ['pesanan_id', 'produk_id', 'produk_ukuran_id', 'nama_produk', 'ukuran', 'jumlah', 'harga'];

    protected $casts = ['harga' => 'decimal:2', 'jumlah' => 'integer'];

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class);
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }

    public function produkUkuran()
    {
        return $this->belongsTo(ProdukUkuran::class, 'produk_ukuran_id');
    }
}
