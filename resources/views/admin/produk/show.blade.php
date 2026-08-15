@extends('layouts.admin')

@section('title', 'Detail Produk - ' . $produk->nama_produk)

@section('content')
<div class="container mx-auto p">
    {{-- Header Section --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8 gap-4">
        <div>
            <h2 class="text-3xl font-bold text-gray-850 tracking-tight">Detail Produk</h2>
            <p class="text-sm text-gray-500 mt-1">Informasi lengkap mengenai produk dan variannya.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.produk.edit', $produk->id) }}" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-600 text-white font-semibold text-sm transition duration-200 shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                Edit Produk
            </a>
            <a href="{{ route('admin.produk.index') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold text-sm transition duration-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali
            </a>
        </div>
    </div>

    {{-- Main Content Grid: Kiri (Galeri Foto), Kanan (Informasi & Varian) --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start" x-data="{ activeImage: '{{ $produk->gambars->isNotEmpty() ? asset('storage/' . $produk->gambars->first()->gambar) : 'https://via.placeholder.com/600' }}' }">
        
        {{-- KOLOM KIRI: Galeri Foto Produk --}}
        <div class="lg:col-span-1 space-y-4">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-4 sticky top-6">
                <h3 class="text-lg font-bold text-gray-800 border-b border-gray-100 pb-3">Galeri Foto</h3>
                
                {{-- Main Active Preview Image --}}
                <div class="w-full aspect-square rounded-xl overflow-hidden border border-gray-200 bg-gray-50 shadow-sm">
                    <img :src="activeImage" alt="{{ $produk->nama_produk }}" class="w-full h-full object-cover transition duration-300">
                </div>

                {{-- Thumbnail List --}}
                @if($produk->gambars->isNotEmpty())
                <div class="grid grid-cols-4 gap-2">
                    @foreach($produk->gambars as $gambar)
                        <button type="button" @click="activeImage = '{{ asset('storage/' . $gambar->gambar) }}'" class="aspect-square rounded-lg overflow-hidden border-2 border-transparent hover:border-blue-500 focus:outline-none transition duration-200">
                            <img src="{{ asset('storage/' . $gambar->gambar) }}" alt="Thumbnail" class="w-full h-full object-cover">
                        </button>
                    @endforeach
                </div>
                @else
                <p class="text-xs text-gray-400 italic text-center py-2">Tidak ada foto tersedia.</p>
                @endif
            </div>
        </div>

        {{-- KOLOM KANAN: Informasi Utama, Deskripsi (CKEditor), & Varian Ukuran --}}
        <div class="lg:col-span-2 space-y-8">
            
            {{-- Informasi Dasar Card --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8 space-y-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-gray-100 pb-4">
                    <div>
                        <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-600 mb-2">
                            {{ $produk->kategori }}
                        </span>
                        <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900">{{ $produk->nama_produk }}</h1>
                    </div>
                    <div>
                        @php
                            $statusColors = [
                                'Tersedia' => 'bg-green-50 text-green-700 border-green-200',
                                'Tidak Tersedia' => 'bg-red-50 text-red-700 border-red-200',
                                'Pre-order' => 'bg-amber-50 text-amber-700 border-amber-200',
                            ];
                            $badgeClass = $statusColors[$produk->status] ?? 'bg-gray-50 text-gray-700 border-gray-200';
                        @endphp
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium border {{ $badgeClass }}">
                            {{ $produk->status }}
                        </span>
                    </div>
                </div>

                {{-- Deskripsi (Hasil render CKEditor dengan plugin Tailwind Typography / prose) --}}
                <div class="space-y-2">
                    <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Deskripsi Produk</h3>
                    <div class="prose prose-sm md:prose-base max-w-none text-gray-600 pt-2">
                        {!! $produk->deskripsi ?? '<p class="italic text-gray-400">Tidak ada deskripsi.</p>' !!}
                    </div>
                </div>
            </div>

            {{-- Varian Ukuran Card (Hanya muncul jika kategori Baju dan memiliki data ukuran) --}}
            @if($produk->kategori === 'Baju' && $produk->ukurans->isNotEmpty())
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8 space-y-6">
                <div class="flex items-center justify-between border-b border-gray-100 pb-4">
                    <h3 class="text-lg font-bold text-gray-800">Daftar Varian Ukuran</h3>
                    <span class="text-xs text-gray-400">Total: {{ $produk->ukurans->count() }} Varian</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-gray-100 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                                <th class="pb-3 px-4">Ukuran</th>
                                <th class="pb-3 px-4">Harga</th>
                                <th class="pb-3 px-4">Stok</th>
                                <th class="pb-3 px-4">Status</th>
                                <th class="pb-3 px-4">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 text-sm text-gray-700">
                            @foreach($produk->ukurans as $ukuran)
                            <tr>
                                <td class="py-3 px-4 font-bold text-gray-900">{{ $ukuran->ukuran }}</td>
                                <td class="py-3 px-4">Rp {{ number_format($ukuran->harga, 0, ',', '.') }}</td>
                                <td class="py-3 px-4">
                                    <span class="font-semibold {{ $ukuran->stok > 0 ? 'text-gray-800' : 'text-red-500' }}">
                                        {{ $ukuran->stok }} pcs
                                    </span>
                                </td>
                                <td class="py-3 px-4">
                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-medium {{ $ukuran->status == 'Tersedia' ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-700' }}">
                                        {{ $ukuran->status }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 text-gray-500 text-xs italic">{{ $ukuran->keterangan ?: '-' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

        </div>

    </div>
</div>
@endsection