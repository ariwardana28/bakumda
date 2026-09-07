@extends('layouts.app')

@section('title', 'Pesanan Saya')

@section('content')
    <div class="container mx-auto max-w-5xl px-4 py-8">
        <div class="mb-6">
            <p class="text-xs font-extrabold uppercase tracking-widest text-orange-600">Riwayat Belanja</p>
            <h1 class="mt-1 text-3xl font-black text-slate-900">Pesanan Saya</h1>
        </div>
        @if (session('success'))
            <div class="mb-5 rounded-xl bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-700">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="mb-5 rounded-xl bg-rose-50 px-4 py-3 text-sm font-semibold text-rose-700">{{ session('error') }}</div>
        @endif
        <div class="mb-6 flex gap-2 overflow-x-auto pb-2">
            @foreach (['' => 'Semua', 'Menunggu Pembayaran' => 'Menunggu Pembayaran', 'Menunggu Verifikasi' => 'Menunggu Proses', 'Diproses' => 'Diproses', 'Dikemas' => 'Dikemas', 'Dikirim' => 'Dikirim', 'Selesai' => 'Selesai', 'Batal' => 'Batal'] as $value => $label)
                <a href="{{ route('pesanan.index', $value ? ['status' => $value] : []) }}"
                    class="shrink-0 rounded-full px-4 py-2 text-xs font-bold {{ $status === $value ? 'bg-orange-600 text-white' : 'bg-white text-slate-500 border border-slate-200 hover:border-orange-300' }}">{{ $label }}</a>
            @endforeach
        </div>
        <div class="space-y-4">
            @forelse ($pesanans as $pesanan)
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <div
                        class="flex flex-col gap-3 border-b border-slate-100 pb-4 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <p class="text-xs text-slate-400">Pesanan #{{ $pesanan->id }} ·
                                {{ $pesanan->created_at->format('d M Y H:i') }}</p>
                            <p class="mt-1 text-sm font-black text-slate-800">{{ $pesanan->items->sum('jumlah') }} item</p>
                        </div>
                        <span
                            class="w-fit rounded-full bg-orange-50 px-3 py-1 text-[11px] font-bold text-orange-700">{{ $pesanan->status === 'Menunggu Verifikasi' ? 'Menunggu Proses' : $pesanan->status }}</span>
                        @if ($pesanan->status === 'Menunggu Pembayaran')
                            <span class="text-xs font-bold text-rose-600" data-order-timer
                                data-cancel-url="{{ route('pesanan.cancel', $pesanan) }}"
                                data-expires-at="{{ $pesanan->created_at->copy()->addMinutes(30)->timestamp * 1000 }}">30:00</span>
                        @endif
                    </div>
                    <div class="divide-y divide-slate-100">
                        @foreach ($pesanan->items as $item)
                            <div class="flex items-center justify-between gap-4 py-3 text-sm">
                                <div>
                                    <p class="font-bold text-slate-800">{{ $item->nama_produk }}</p>
                                    <p class="text-xs text-slate-500">
                                        {{ $item->ukuran ? 'Ukuran ' . $item->ukuran . ' · ' : '' }}{{ $item->jumlah }} pcs
                                    </p>
                                </div><span class="font-bold text-slate-700">Rp
                                    {{ number_format($item->harga * $item->jumlah, 0, ',', '.') }}</span>
                            </div>
                        @endforeach
                    </div>
                    <div class="flex items-center justify-between border-t border-slate-100 pt-4"><span
                            class="text-xs text-slate-500">Total</span><strong class="text-base text-slate-900">Rp
                            {{ number_format($pesanan->total, 0, ',', '.') }}</strong>
                        @if ($pesanan->status === 'Menunggu Pembayaran')
                            <div class="flex items-center gap-2">
                                <form action="{{ route('pesanan.cancel', $pesanan) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="rounded-xl border border-rose-200 px-4 py-2 text-xs font-bold text-rose-600">Batal</button>
                                </form>
                                <a href="{{ route('pesanan.payment', $pesanan) }}"
                                    class="rounded-xl bg-orange-600 px-4 py-2 text-xs font-bold text-white">Bayar Sekarang</a>
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="rounded-2xl border border-dashed border-slate-300 bg-white py-16 text-center"><i
                        class="fa-solid fa-receipt text-4xl text-slate-300"></i>
                    <p class="mt-3 text-sm font-bold text-slate-600">Belum ada pesanan pada status ini.</p>
                </div>
            @endforelse
        </div>
        <div class="mt-6">{{ $pesanans->links() }}</div>
    </div>
    <script>
        document.querySelectorAll('[data-order-timer]').forEach((timer) => {
            const expiresAt = Number(timer.dataset.expiresAt);
            const cancelForm = document.createElement('form');
            cancelForm.method = 'POST';
            cancelForm.action = timer.dataset.cancelUrl;
            cancelForm.innerHTML = '@csrf';
            document.body.appendChild(cancelForm);

            const updateTimer = () => {
                const remaining = Math.max(0, expiresAt - Date.now());
                const minutes = String(Math.floor(remaining / 60000)).padStart(2, '0');
                const seconds = String(Math.floor((remaining % 60000) / 1000)).padStart(2, '0');
                timer.textContent = `${minutes}:${seconds}`;
                if (remaining <= 0) {
                    timer.textContent = 'Dibatalkan';
                    cancelForm.submit();
                    return;
                }
                setTimeout(updateTimer, 1000);
            };
            updateTimer();
        });
    </script>
@endsection
