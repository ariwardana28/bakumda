@extends('layouts.admin')

@section('title', 'Detail Keranjang')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="mb-6"><a href="{{ route('admin.keranjang.index') }}" class="text-sm font-semibold text-blue-600">&larr;
                Kembali</a>
            <h1 class="mt-3 text-3xl font-black text-gray-800">Detail Keranjang</h1>
            <p class="mt-1 text-sm text-gray-500">{{ $keranjang->user->name }} · {{ $keranjang->user->email }}</p>
        </div>
        @if (session('success'))
            <div class="mb-5 rounded-xl bg-emerald-50 p-4 text-sm font-semibold text-emerald-700">{{ session('success') }}
            </div>
        @endif
        <div class="space-y-3">
            @forelse ($keranjang->items as $item)
                <div class="flex items-center gap-4 rounded-2xl border border-gray-100 bg-white p-4 shadow-sm">
                    <div class="h-16 w-16 overflow-hidden rounded-xl bg-gray-100">
                        @if ($item->produk->gambars->first())
                            <img src="{{ asset('storage/' . $item->produk->gambars->first()->gambar) }}"
                                class="h-full w-full object-cover" alt="">
                        @endif
                    </div>
                    <div class="flex-1">
                        <h2 class="font-bold text-gray-800">{{ $item->produk->nama_produk }}</h2>
                        <p class="text-xs text-gray-500">
                            {{ $item->ukuran ? 'Ukuran: ' . $item->ukuran->ukuran : 'Tanpa varian' }} · {{ $item->jumlah }}
                            pcs</p>
                    </div>
                    <div class="text-right">
                        <p class="font-black text-gray-800">Rp
                            {{ number_format($item->harga * $item->jumlah, 0, ',', '.') }}</p>
                        <form action="{{ route('admin.keranjang.item.destroy', $item) }}" method="POST" class="mt-1">
                            @csrf @method('DELETE')<button class="text-xs font-semibold text-red-600">Hapus item</button>
                        </form>
                    </div>
            </div>@empty<div class="rounded-2xl bg-white p-12 text-center text-gray-500">Keranjang ini kosong.</div>
            @endforelse
        </div>
        @if ($keranjang->items->isNotEmpty())
            <div class="mt-6 flex justify-end rounded-2xl bg-gray-900 p-5 text-xl font-black text-white">Total: Rp
                {{ number_format($keranjang->total, 0, ',', '.') }}</div>
        @endif
    </div>
@endsection
