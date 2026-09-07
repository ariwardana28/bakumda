<?php

namespace App\Http\Controllers;

use App\Models\KeranjangItem;
use App\Models\Pesanan;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PesananController extends Controller
{
    public function index(Request $request)
    {
        $this->expirePendingOrders($request->user());
        $status = $request->string('status')->toString();
        $allowedStatuses = ['Menunggu Pembayaran', 'Menunggu Verifikasi', 'Diproses', 'Dikemas', 'Dikirim', 'Selesai', 'Batal'];

        $pesanans = $request->user()->pesanans()->with('items')
            ->when(in_array($status, $allowedStatuses, true), fn ($query) => $query->where('status', $status))
            ->latest()->paginate(10)->withQueryString();

        return view('user.pesanan.index', compact('pesanans', 'status', 'allowedStatuses'));
    }

    public function directCheckout(Request $request, Produk $produk)
    {
        $validated = $request->validate([
            'produk_ukuran_id' => ['nullable', 'integer', 'exists:produk_ukuran,id'],
            'jumlah' => ['required', 'integer', 'min:1', 'max:999'],
        ]);

        $ukuran = $produk->kategori === 'Baju'
            ? $produk->ukurans()->find($validated['produk_ukuran_id'] ?? null)
            : null;

        if (($produk->kategori === 'Baju' && !$ukuran) || $produk->status !== 'Tersedia') {
            return back()->with('error', 'Silakan pilih produk dan varian yang tersedia.');
        }
        if ($ukuran && $validated['jumlah'] > (int) $ukuran->stok) {
            return back()->with('error', 'Jumlah melebihi stok yang tersedia.');
        }

        $pesanan = DB::transaction(function () use ($request, $produk, $ukuran, $validated) {
            $pesanan = $request->user()->pesanans()->create([
                'total' => ($ukuran?->harga ?? 0) * $validated['jumlah'],
            ]);
            $pesanan->items()->create([
                'produk_id' => $produk->id,
                'produk_ukuran_id' => $ukuran?->id,
                'nama_produk' => $produk->nama_produk,
                'ukuran' => $ukuran?->ukuran,
                'jumlah' => $validated['jumlah'],
                'harga' => $ukuran?->harga ?? 0,
            ]);
            return $pesanan;
        });

        return redirect()->route('pesanan.payment', $pesanan)->with('success', 'Pesanan siap dibayar.');
    }

    public function checkout(Request $request)
    {
        $validated = $request->validate([
            'item_ids' => ['required', 'array', 'min:1'],
            'item_ids.*' => ['integer', 'exists:keranjang_items,id'],
        ], ['item_ids.required' => 'Pilih minimal satu produk untuk checkout.']);

        $keranjang = $request->user()->keranjang;
        $items = $keranjang?->items()->with(['produk', 'ukuran'])
            ->whereIn('id', $validated['item_ids'])->get();

        if (!$items || $items->count() !== count($validated['item_ids'])) {
            return back()->with('error', 'Item checkout tidak valid.');
        }

        $pesanan = DB::transaction(function () use ($items, $keranjang, $request) {
            $total = 0;
            foreach ($items as $item) {
                if ($item->produk->status !== 'Tersedia') {
                    abort(422, 'Produk "' . $item->produk->nama_produk . '" sudah tidak tersedia.');
                }
                if ($item->ukuran && $item->jumlah > (int) $item->ukuran->stok) {
                    abort(422, 'Stok ukuran ' . $item->ukuran->ukuran . ' tidak mencukupi.');
                }
                $total += $item->harga * $item->jumlah;
            }

            $pesanan = $request->user()->pesanans()->create(['total' => $total]);
            foreach ($items as $item) {
                $pesanan->items()->create([
                    'produk_id' => $item->produk_id,
                    'produk_ukuran_id' => $item->produk_ukuran_id,
                    'nama_produk' => $item->produk->nama_produk,
                    'ukuran' => $item->ukuran?->ukuran,
                    'jumlah' => $item->jumlah,
                    'harga' => $item->harga,
                ]);
            }
            $keranjang->items()->whereIn('id', $items->pluck('id'))->delete();
            return $pesanan;
        });

        return redirect()->route('pesanan.payment', $pesanan)->with('success', 'Checkout berhasil. Silakan lakukan pembayaran.');
    }

    public function payment(Request $request, Pesanan $pesanan)
    {
        abort_unless($pesanan->user_id === $request->user()->id, 403);

        if ($this->isExpired($pesanan)) {
            $pesanan->update(['status' => 'Batal']);

            return redirect()->route('pesanan.index', ['status' => 'Batal'])
                ->with('error', 'Pesanan dibatalkan karena batas pembayaran 30 menit telah lewat.');
        }

        $pesanan->load('items');
        return view('user.pesanan.payment', compact('pesanan'));
    }

    public function cancel(Request $request, Pesanan $pesanan)
    {
        abort_unless($pesanan->user_id === $request->user()->id, 403);

        if ($pesanan->status !== 'Menunggu Pembayaran') {
            return back()->with('error', 'Pesanan ini sudah tidak dapat dibatalkan.');
        }

        $pesanan->update(['status' => 'Batal']);

        return back()->with('success', 'Pesanan berhasil dibatalkan.');
    }

    public function uploadPayment(Request $request, Pesanan $pesanan)
    {
        abort_unless($pesanan->user_id === $request->user()->id, 403);

        if ($this->isExpired($pesanan)) {
            $pesanan->update(['status' => 'Batal']);

            return redirect()->route('pesanan.index', ['status' => 'Batal'])
                ->with('error', 'Pesanan dibatalkan karena batas pembayaran 30 menit telah lewat.');
        }

        if ($pesanan->status !== 'Menunggu Pembayaran') {
            return back()->with('error', 'Pesanan ini tidak menunggu pembayaran.');
        }

        $validated = $request->validate([
            'bukti_pembayaran' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
            'catatan' => ['nullable', 'string', 'max:1000'],
        ]);

        $path = $request->file('bukti_pembayaran')->store('produk/pembayaran', 'public');
        $pesanan->update([
            'bukti_pembayaran' => $path,
            'status' => 'Menunggu Verifikasi',
            'catatan' => $validated['catatan'] ?? null,
            'dibayar_pada' => now(),
        ]);

        return redirect()->route('pesanan.payment', $pesanan)->with('success', 'Bukti pembayaran berhasil dikirim.');
    }

    private function expirePendingOrders($user): void
    {
        $user->pesanans()
            ->where('status', 'Menunggu Pembayaran')
            ->where('created_at', '<=', now()->subMinutes(30))
            ->update(['status' => 'Batal']);
    }

    private function isExpired(Pesanan $pesanan): bool
    {
        return $pesanan->status === 'Menunggu Pembayaran'
            && $pesanan->created_at->lte(now()->subMinutes(30));
    }
}
