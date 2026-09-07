<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use App\Models\KeranjangItem;
use App\Models\Produk;
use App\Models\ProdukUkuran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KeranjangController extends Controller
{
    public function index(Request $request)
    {
        $keranjang = $request->user()->keranjang()->with(['items.produk.gambars', 'items.ukuran'])->first();

        return view('user.keranjang.index', compact('keranjang'));
    }

    public function store(Request $request, Produk $produk)
    {
        $validated = $request->validate([
            'produk_ukuran_id' => ['nullable', 'integer', 'exists:produk_ukuran,id'],
            'jumlah' => ['required', 'integer', 'min:1', 'max:999'],
            'catatan' => ['nullable', 'string', 'max:1000'],
        ]);

        $ukuran = null;
        if ($produk->kategori === 'Baju') {
            if (empty($validated['produk_ukuran_id'])) {
                return back()->withErrors(['produk_ukuran_id' => 'Silakan pilih ukuran produk.'])->withInput();
            }

            $ukuran = $produk->ukurans()->find($validated['produk_ukuran_id']);
            if (!$ukuran) {
                return back()->withErrors(['produk_ukuran_id' => 'Varian produk tidak valid.'])->withInput();
            }
        }

        if ($produk->status !== 'Tersedia' || ($ukuran && ((int) $ukuran->stok < $validated['jumlah']))) {
            return back()->with('error', 'Produk atau stok tidak mencukupi.');
        }

        $keranjang = $request->user()->keranjang()->firstOrCreate([]);
        $item = $keranjang->items()->where('produk_id', $produk->id)
            ->where('produk_ukuran_id', $ukuran?->id)->first();
        $jumlahBaru = ($item?->jumlah ?? 0) + $validated['jumlah'];

        if ($ukuran && $jumlahBaru > (int) $ukuran->stok) {
            return back()->with('error', 'Jumlah melebihi stok yang tersedia.');
        }

        $keranjang->items()->updateOrCreate(
            ['produk_id' => $produk->id, 'produk_ukuran_id' => $ukuran?->id],
            [
                'jumlah' => $jumlahBaru,
                'harga' => $ukuran?->harga ?? 0,
                'catatan' => $validated['catatan'] ?? ($item?->catatan),
            ]
        );

        return back()->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

    public function update(Request $request, KeranjangItem $item)
    {
        $this->authorizeItem($request, $item);
        $validated = $request->validate(['jumlah' => ['required', 'integer', 'min:1', 'max:999']]);
        $stok = $item->ukuran?->stok;

        if ($stok !== null && $validated['jumlah'] > (int) $stok) {
            return back()->with('error', 'Jumlah melebihi stok yang tersedia.');
        }

        $item->update(['jumlah' => $validated['jumlah']]);
        return back()->with('success', 'Jumlah produk diperbarui.');
    }

    public function destroy(Request $request, KeranjangItem $item)
    {
        $this->authorizeItem($request, $item);
        $item->delete();
        return back()->with('success', 'Produk dihapus dari keranjang.');
    }

    public function clear(Request $request)
    {
        $request->user()->keranjang?->items()->delete();
        return back()->with('success', 'Keranjang dikosongkan.');
    }

    private function authorizeItem(Request $request, KeranjangItem $item): void
    {
        abort_unless($item->keranjang->user_id === $request->user()->id, 403);
    }
}
