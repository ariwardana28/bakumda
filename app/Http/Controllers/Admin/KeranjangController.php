<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Keranjang;
use App\Models\KeranjangItem;
use Illuminate\Http\Request;

class KeranjangController extends Controller
{
    public function index()
    {
        $keranjangs = Keranjang::with('user')->withCount('items')->latest()->paginate(20);
        return view('admin.keranjang.index', compact('keranjangs'));
    }

    public function show(Keranjang $keranjang)
    {
        $keranjang->load(['user', 'items.produk.gambars', 'items.ukuran']);
        return view('admin.keranjang.show', compact('keranjang'));
    }

    public function destroyItem(KeranjangItem $item)
    {
        $item->delete();
        return back()->with('success', 'Item dihapus dari keranjang.');
    }
}
