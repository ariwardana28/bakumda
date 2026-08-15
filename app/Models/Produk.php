<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produk';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama_produk', 'slug', 'deskripsi', 'status', 'kategori'
    ];

    /**
     * Get all of the gambars for the Produk.
     */
    public function gambars()
    {
        return $this->hasMany(ProdukGambar::class);
    }

    /**
     * Get all of the ukurans for the Produk.
     */
    public function ukurans()
    {
        return $this->hasMany(ProdukUkuran::class);
    }
}