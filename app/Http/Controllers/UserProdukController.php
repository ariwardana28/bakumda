<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\ProdukGambar;
use App\Models\ProdukUkuran;
use Illuminate\Http\Request;

class UserProdukController extends Controller
{
    /**
     * Menampilkan daftar katalog merchandise.
     */
    public function index()
    {
        // Mengambil data produk beserta relasi gambar dan ukuran jika diperlukan
        $produks = Produk::with(['gambars', 'ukurans'])->latest()->get();
        

        return view('user.produk.index', compact('produks'));
    }

    /**
     * Menampilkan detail produk berdasarkan slug.
     */
    public function show($slug)
    {
        $produk = Produk::with(['gambars', 'ukurans'])->where('slug', $slug)->firstOrFail();

        return view('user.produk.show', compact('produk'));
    }
}
