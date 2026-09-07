@extends('layouts.app')

@section('title', 'Pembayaran Pesanan')

@section('content')
    <div class="container mx-auto max-w-4xl px-4 py-8">
        <a href="{{ route('keranjang.index') }}" class="text-sm font-semibold text-slate-500 hover:text-orange-600">&larr; Kembali ke keranjang</a>
        <div class="mt-5 overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-xl">
            <div class="bg-slate-950 p-6 text-white sm:p-8">
                <p class="text-xs font-bold uppercase tracking-widest text-orange-400">Pesanan #{{ $pesanan->id }}</p>
                <h1 class="mt-2 text-2xl font-black">Selesaikan Pembayaran</h1>
                <p class="mt-1 text-sm text-slate-300">Transfer sesuai total tagihan, lalu unggah bukti pembayaran.</p>
                <div class="mt-5 flex items-center justify-between rounded-2xl bg-white/10 p-4"><div><span class="text-sm text-slate-300">Total Tagihan</span>@if ($pesanan->status === 'Menunggu Pembayaran')<span class="mt-1 block text-xs font-bold text-rose-300">Sisa waktu: <span data-payment-timer data-expires-at="{{ $pesanan->created_at->copy()->addMinutes(30)->timestamp * 1000 }}">30:00</span></span>@endif</div><strong class="text-xl text-orange-400">Rp {{ number_format($pesanan->total, 0, ',', '.') }}</strong></div>
            </div>
            <div class="space-y-7 p-6 sm:p-8">
                @if (session('success')) <div class="rounded-xl bg-emerald-50 p-4 text-sm font-semibold text-emerald-700">{{ session('success') }}</div> @endif
                <div><h2 class="mb-3 text-xs font-extrabold uppercase tracking-widest text-slate-400">Detail Produk</h2><div class="divide-y divide-slate-100 rounded-2xl border border-slate-200">@foreach ($pesanan->items as $item)<div class="flex items-center justify-between gap-4 p-4 text-sm"><div><p class="font-bold text-slate-800">{{ $item->nama_produk }}</p><p class="text-xs text-slate-500">{{ $item->ukuran ? 'Ukuran ' . $item->ukuran . ' · ' : '' }}{{ $item->jumlah }} pcs</p></div><span class="font-bold text-slate-700">Rp {{ number_format($item->harga * $item->jumlah, 0, ',', '.') }}</span></div>@endforeach</div></div>
                <div class="rounded-2xl border border-orange-100 bg-orange-50 p-5"><h2 class="text-xs font-extrabold uppercase tracking-widest text-orange-700">Rekening Tujuan</h2><p class="mt-3 text-sm font-bold text-slate-800">Bank BCA · 123-456-7890</p><p class="text-xs text-slate-600">a.n. Pusat Pelatihan Kompetensi</p><p class="mt-3 text-xs text-slate-500">Status: <strong>{{ $pesanan->status }}</strong></p></div>
                @if ($pesanan->status === 'Menunggu Pembayaran')
                <div class="flex justify-end border-t border-slate-100 pt-6">
                    <form action="{{ route('pesanan.cancel', $pesanan) }}" method="POST">
                        @csrf
                        <button type="submit" class="rounded-xl border border-rose-200 px-4 py-2 text-xs font-bold text-rose-600">Batal Pesanan</button>
                    </form>
                </div>
                <form action="{{ route('pesanan.payment.store', $pesanan) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                    @csrf
                    <div><label class="mb-2 block text-xs font-bold uppercase tracking-wider text-slate-600">Bukti Pembayaran</label><input type="file" name="bukti_pembayaran" accept=".jpg,.jpeg,.png,.pdf" required class="w-full rounded-xl border border-dashed border-slate-300 bg-slate-50 p-4 text-sm"><p class="mt-1 text-xs text-slate-400">JPG, PNG, atau PDF, maksimal 2MB.</p>@error('bukti_pembayaran')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror</div>
                    <div><label class="mb-2 block text-xs font-bold uppercase tracking-wider text-slate-600">Catatan (Opsional)</label><textarea name="catatan" rows="3" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm" placeholder="Contoh: transfer dari rekening atas nama ..."></textarea></div>
                    <button class="w-full rounded-xl bg-orange-600 px-5 py-3.5 text-sm font-bold text-white shadow-lg shadow-orange-600/20 hover:bg-orange-700">Kirim Bukti Pembayaran</button>
                </form>
                @else
                    <div class="rounded-xl bg-slate-50 p-4 text-sm text-slate-600">Pesanan ini berstatus <strong>{{ $pesanan->status }}</strong> dan tidak dapat diubah pada halaman pembayaran.</div>
                @endif
            </div>
        </div>
    </div>
    @if ($pesanan->status === 'Menunggu Pembayaran')
        <script>
            const paymentTimer = document.querySelector('[data-payment-timer]');
            const updatePaymentTimer = () => {
                const remaining = Math.max(0, Number(paymentTimer.dataset.expiresAt) - Date.now());
                const minutes = String(Math.floor(remaining / 60000)).padStart(2, '0');
                const seconds = String(Math.floor((remaining % 60000) / 1000)).padStart(2, '0');
                paymentTimer.textContent = `${minutes}:${seconds}`;
                if (remaining <= 0) {
                    window.location.reload();
                    return;
                }
                setTimeout(updatePaymentTimer, 1000);
            };
            updatePaymentTimer();
        </script>
    @endif
@endsection
