<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PesananController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->string('status')->toString();
        $statuses = ['Menunggu Pembayaran', 'Menunggu Verifikasi', 'Diproses', 'Dikemas', 'Dikirim', 'Selesai', 'Batal'];
        $pesanans = Pesanan::with('user')->withCount('items')
            ->when(in_array($status, $statuses, true), fn ($query) => $query->where('status', $status))
            ->latest()->paginate(20)->withQueryString();

        return view('admin.pesanan.index', compact('pesanans', 'status', 'statuses'));
    }

    public function show(Pesanan $pesanan)
    {
        $pesanan->load(['user', 'items.produk.gambars']);
        return view('admin.pesanan.show', compact('pesanan'));
    }

    public function updateStatus(Request $request, Pesanan $pesanan)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:Menunggu Pembayaran,Menunggu Verifikasi,Diproses,Dikemas,Dikirim,Selesai,Batal'],
            'catatan' => ['nullable', 'string', 'max:1000'],
        ]);

        $fulfillmentStatuses = ['Diproses', 'Dikemas', 'Dikirim', 'Selesai'];
        if ($pesanan->status === 'Menunggu Pembayaran' && in_array($validated['status'], $fulfillmentStatuses, true)) {
            return back()->with('error', 'Pesanan belum dibayar dan belum dapat diproses.');
        }

        DB::transaction(function () use ($pesanan, $validated) {
            $newStatus = $validated['status'];
            $fulfillmentStatuses = ['Diproses', 'Dikemas', 'Dikirim', 'Selesai'];
            $approvingPayment = $pesanan->status === 'Menunggu Verifikasi'
                && in_array($newStatus, $fulfillmentStatuses, true);

            if ($approvingPayment) {
                $pesanan->load('items.produkUkuran');
                foreach ($pesanan->items as $item) {
                    if (!$item->produkUkuran) {
                        continue;
                    }
                    if ((int) $item->produkUkuran->stok < $item->jumlah) {
                        abort(422, 'Stok untuk ukuran ' . $item->produkUkuran->ukuran . ' tidak mencukupi.');
                    }
                }
                foreach ($pesanan->items as $item) {
                    $item->produkUkuran?->decrement('stok', $item->jumlah);
                }
            }

            $pesanan->update([
                'status' => $newStatus,
                'catatan' => $validated['catatan'] ?? $pesanan->catatan,
            ]);
        });

        return back()->with('success', 'Status pesanan berhasil diperbarui.');
    }
}
