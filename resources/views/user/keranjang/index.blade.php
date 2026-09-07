@extends('layouts.app')

@section('title', 'Keranjang Merchandise')

@section('content')
    <div class="container mx-auto max-w-5xl px-4 py-8">
        <div class="flex items-end justify-between gap-4 mb-8">
            <div>
                <p class="text-xs font-extrabold uppercase tracking-widest text-orange-600">Pesanan Saya</p>
                <h1 class="text-3xl font-black text-slate-900 mt-1">Keranjang Merchandise</h1>
            </div>
            @if ($keranjang?->items->isNotEmpty())
                <form action="{{ route('keranjang.clear') }}" method="POST" onsubmit="return confirm('Kosongkan seluruh keranjang?')">
                    @csrf @method('DELETE')
                    <button class="text-xs font-bold text-rose-600 hover:text-rose-700">Kosongkan</button>
                </form>
            @endif
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('pesanan.index') }}" class="rounded-xl border border-slate-200 bg-white px-4 py-2 text-xs font-bold text-slate-600 hover:border-orange-300">Pesanan Saya</a>
                @if ($keranjang?->items->isNotEmpty())
                    <button type="submit" form="checkout-form" class="rounded-xl bg-orange-600 px-4 py-2 text-xs font-bold text-white hover:bg-orange-700">Checkout Produk Dipilih</button>
                @endif
            </div>
        </div>

        <form id="checkout-form" action="{{ route('pesanan.checkout') }}" method="POST">
            @csrf
        </form>

        @if (session('success'))
            <div class="mb-5 rounded-xl bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-700">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="mb-5 rounded-xl bg-rose-50 px-4 py-3 text-sm font-semibold text-rose-700">{{ session('error') }}</div>
        @endif

        @if ($keranjang?->items->isNotEmpty())
            <div class="space-y-4">
                @foreach ($keranjang->items as $item)
                    <div class="flex flex-col sm:flex-row sm:items-center gap-4 bg-white border border-slate-200 rounded-2xl p-4 shadow-sm">
                        <input type="checkbox" name="item_ids[]" value="{{ $item->id }}" form="checkout-form" class="h-5 w-5 shrink-0 rounded border-slate-300 text-orange-600 focus:ring-orange-500">
                        <div class="w-24 h-24 shrink-0 rounded-xl overflow-hidden bg-slate-100">
                            @if ($item->produk->gambars->first())
                                <img src="{{ asset('storage/' . $item->produk->gambars->first()->gambar) }}" class="w-full h-full object-cover" alt="{{ $item->produk->nama_produk }}">
                            @else
                                <div class="h-full flex items-center justify-center text-slate-400"><i class="fa-solid fa-image"></i></div>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <h2 class="font-bold text-slate-900">{{ $item->produk->nama_produk }}</h2>
                            <p class="text-xs text-slate-500 mt-1">{{ $item->ukuran ? 'Ukuran: ' . $item->ukuran->ukuran : 'Tanpa varian' }}</p>
                            <p class="text-sm font-extrabold text-orange-600 mt-2">Rp {{ number_format($item->harga, 0, ',', '.') }}</p>
                        </div>
                        <div class="flex items-center justify-between sm:justify-end gap-4">
                            <form action="{{ route('keranjang.update', $item) }}" method="POST" class="flex items-center gap-2">
                                @csrf @method('PATCH')
                                <input type="number" name="jumlah" min="1" value="{{ $item->jumlah }}" class="w-20 rounded-lg border border-slate-200 px-2 py-2 text-center text-sm">
                                <button class="rounded-lg bg-slate-900 px-3 py-2 text-xs font-bold text-white">Ubah</button>
                            </form>
                            <div class="text-right min-w-24">
                                <p class="font-black text-slate-900">Rp {{ number_format($item->harga * $item->jumlah, 0, ',', '.') }}</p>
                                <form action="{{ route('keranjang.destroy', $item) }}" method="POST" class="mt-1">
                                    @csrf @method('DELETE')
                                    <button class="text-xs font-semibold text-rose-600 hover:text-rose-700">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-6 flex flex-col sm:flex-row items-center justify-between gap-4 rounded-2xl bg-slate-900 p-5 text-white">
                <span class="text-sm text-slate-300">Total {{ $keranjang->items->sum('jumlah') }} item</span>
                <span class="text-xl font-black">Rp {{ number_format($keranjang->total, 0, ',', '.') }}</span>
            </div>
        @else
            <div class="rounded-2xl border border-dashed border-slate-300 bg-white py-20 text-center">
                <i class="fa-solid fa-cart-shopping text-4xl text-slate-300"></i>
                <h2 class="mt-4 font-bold text-slate-700">Keranjang masih kosong</h2>
                <a href="{{ route('merchandise.index') }}" class="mt-5 inline-flex rounded-xl bg-orange-600 px-5 py-3 text-xs font-bold text-white">Lihat Merchandise</a>
            </div>
        @endif
    </div>
@endsection
