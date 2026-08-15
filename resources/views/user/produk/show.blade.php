@extends('layouts.app')

@section('title', $produk->nama_produk)

@section('content')
    <div class="container mx-auto" x-data="{
        activeImage: '{{ $produk->gambars->isNotEmpty() ? asset('storage/' . $produk->gambars->first()->gambar) : 'https://via.placeholder.com/600' }}',
        selectedUkuran: null,
        jumlah: 1,
        selectUkuran(ukuran) {
            this.selectedUkuran = ukuran;
        }
    }">

        <!-- Header Card: Nama Produk, Kategori, & Status dipindah ke paling atas dengan desain menyatu -->
        <div
            class="bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 rounded-3xl p-6 sm:p-8 shadow-xl shadow-slate-200/50 dark:shadow-none mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="space-y-2">
                    <div class="flex items-center gap-2">
                        <span
                            class="px-3 py-1 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 text-[10px] font-extrabold uppercase tracking-wider border border-slate-200/80 dark:border-slate-700">
                            {{ $produk->kategori }}
                        </span>
                        @php
                            $statusColors = [
                                'Tersedia' => 'bg-emerald-500/90 text-white',
                                'Tidak Tersedia' => 'bg-rose-500/90 text-white',
                                'Pre-order' => 'bg-amber-500/90 text-white',
                            ];
                        @endphp
                        <span
                            class="px-3 py-1 rounded-full {{ $statusColors[$produk->status] ?? 'bg-slate-500 text-white' }} text-[10px] font-extrabold uppercase tracking-wider shadow-2xs">
                            {{ $produk->status }}
                        </span>
                    </div>
                    <h1 class="text-2xl sm:text-4xl font-black text-slate-900 dark:text-white tracking-tight leading-tight">
                        {{ $produk->nama_produk }}
                    </h1>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-14 items-start">

            <!-- Kolom Kiri: Galeri Foto Produk (5 Kolom) -->
            <div class="lg:col-span-5 space-y-4 lg:sticky lg:top-24">
                <!-- Gambar Utama dengan Efek Ringan & Modern Card -->
                <div
                    class="w-full aspect-square rounded-3xl overflow-hidden border border-slate-200/80 dark:border-slate-800 bg-white dark:bg-slate-900 shadow-xl shadow-slate-200/50 dark:shadow-none relative group flex items-center justify-center p-3">
                    <img :src="activeImage" alt="{{ $produk->nama_produk }}"
                        class="w-full h-full object-cover rounded-2xl transition duration-500 group-hover:scale-105">
                </div>

                <!-- Thumbnail Galeri -->
                @if ($produk->gambars->count() > 1)
                    <div class="grid grid-cols-5 gap-3">
                        @foreach ($produk->gambars as $gambar)
                            <button type="button" @click="activeImage = '{{ asset('storage/' . $gambar->gambar) }}'"
                                :class="{ 'border-orange-600 ring-2 ring-orange-500/20 shadow-md scale-95': activeImage === '{{ asset('storage/' . $gambar->gambar) }}', 'border-slate-200 dark:border-slate-800 opacity-70 hover:opacity-100': activeImage !== '{{ asset('storage/' . $gambar->gambar) }}' }"
                                class="aspect-square rounded-2xl overflow-hidden border-2 focus:outline-none transition-all duration-200 bg-white dark:bg-slate-900 p-1 shadow-xs">
                                <img src="{{ asset('storage/' . $gambar->gambar) }}" alt="Thumbnail"
                                    class="w-full h-full object-cover rounded-xl">
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Kolom Kanan: Informasi, Deskripsi, Harga, Varian & Tombol Aksi (7 Kolom) -->
            <div class="lg:col-span-7 space-y-6">

                <!-- Card Utama Konten Detail -->
                <div
                    class="bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 rounded-3xl p-6 sm:p-8 shadow-xl shadow-slate-200/50 dark:shadow-none space-y-6">

                    <!-- Deskripsi -->
                    <div class="space-y-2">
                        <h3 class="font-bold text-slate-800 dark:text-slate-200 text-xs uppercase tracking-wider">Deskripsi
                            Produk</h3>
                        <div
                            class="prose prose-sm max-w-none text-slate-600 dark:text-slate-400 dark:prose-invert prose-p:leading-relaxed bg-slate-50/80 dark:bg-slate-800/40 p-4 sm:p-5 rounded-2xl border border-slate-100 dark:border-slate-800/80">
                            {!! $produk->deskripsi ?? '<p class="italic text-slate-400">Tidak ada deskripsi untuk produk ini.</p>' !!}
                        </div>
                    </div>

                    <!-- Harga Dinamis -->
                    <div
                        class="bg-gradient-to-br from-orange-50/80 to-amber-50/40 dark:from-orange-950/30 dark:to-slate-900/50 border border-orange-100 dark:border-orange-900/40 p-5 rounded-2xl flex items-center justify-between shadow-xs">
                        <div>
                            <span
                                class="text-[10px] font-extrabold uppercase tracking-widest text-orange-600 dark:text-orange-400 block mb-1">Harga
                                Produk</span>
                            <div class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-white"
                                x-text="selectedUkuran ? `Rp ${new Intl.NumberFormat('id-ID').format(selectedUkuran.harga)}` : '{{ $produk->ukurans->isNotEmpty() ? 'Pilih Varian Ukuran' : 'Harga Hubungi Admin' }}'">
                            </div>
                        </div>
                        <div
                            class="w-12 h-12 rounded-2xl bg-orange-600 text-white flex items-center justify-center text-lg shadow-md shadow-orange-600/30 shrink-0">
                            <i class="fa-solid fa-tag"></i>
                        </div>
                    </div>

                    <!-- Varian Ukuran (jika ada) -->
                    @if ($produk->kategori === 'Baju' && $produk->ukurans->isNotEmpty())
                        <div class="space-y-3 pt-1">
                            <div class="flex items-center justify-between">
                                <label
                                    class="font-bold text-slate-800 dark:text-slate-200 text-xs uppercase tracking-wider">Pilih
                                    Ukuran Varian</label>
                                <span class="text-[11px] font-medium text-orange-600 dark:text-orange-400"
                                    x-show="selectedUkuran" x-text="`Stok tersedia: ${selectedUkuran?.stok} pcs`"></span>
                            </div>
                            <div class="grid grid-cols-4 sm:grid-cols-5 gap-2.5">
                                <template x-for="ukuran in {{ json_encode($produk->ukurans) }}" :key="ukuran.id">
                                    <button type="button" @click="selectUkuran(ukuran)"
                                        :class="{
                                            'bg-orange-600 text-white border-transparent shadow-lg shadow-orange-600/25 scale-[1.02] ring-2 ring-orange-500/30': selectedUkuran
                                                ?.id === ukuran.id,
                                            'bg-slate-50 text-slate-700 dark:bg-slate-800/80 dark:text-slate-300 border-slate-200/80 dark:border-slate-700 hover:border-orange-500': selectedUkuran
                                                ?.id !== ukuran.id,
                                            'opacity-40 cursor-not-allowed bg-slate-100 dark:bg-slate-900': ukuran
                                                .stok <= 0
                                        }"
                                        :disabled="ukuran.stok <= 0"
                                        class="text-center p-3 rounded-2xl border transition-all duration-200 text-xs font-extrabold flex flex-col items-center justify-center gap-0.5">
                                        <span x-text="ukuran.ukuran"></span>
                                        <span class="text-[9px] font-normal opacity-80"
                                            x-text="ukuran.stok > 0 ? 'Tersedia' : 'Habis'"></span>
                                    </button>
                                </template>
                            </div>
                        </div>
                    @endif

                    <!-- Bagian Aksi & Tombol Beli -->
                    <div class="pt-4 border-t border-slate-100 dark:border-slate-800 space-y-4">

                        <div class="flex flex-col sm:flex-row items-stretch gap-3">
                            <!-- Pengatur Jumlah -->
                            <div
                                class="flex items-center justify-between border border-slate-200 dark:border-slate-700 rounded-2xl bg-slate-50 dark:bg-slate-800/50 p-1.5">
                                <button type="button" @click="jumlah = Math.max(1, jumlah - 1)"
                                    class="w-10 h-10 rounded-xl bg-white dark:bg-slate-800 text-slate-600 dark:text-slate-300 shadow-xs hover:bg-slate-100 dark:hover:bg-slate-700 flex items-center justify-center transition-colors">
                                    <i class="fa-solid fa-minus text-xs"></i>
                                </button>
                                <input type="text" x-model.number="jumlah"
                                    class="w-12 text-center bg-transparent border-none focus:ring-0 font-bold text-slate-800 dark:text-slate-100 text-sm">
                                <button type="button" @click="jumlah++"
                                    class="w-10 h-10 rounded-xl bg-white dark:bg-slate-800 text-slate-600 dark:text-slate-300 shadow-xs hover:bg-slate-100 dark:hover:bg-slate-700 flex items-center justify-center transition-colors">
                                    <i class="fa-solid fa-plus text-xs"></i>
                                </button>
                            </div>

                            <!-- Tombol Pesan Utama -->
                            <button type="button"
                                :disabled="({{ $produk->kategori === 'Baju' }} && !selectedUkuran) || '{{ $produk->status }}'
                                !== 'Tersedia'"
                                class="flex-1 inline-flex items-center justify-center gap-2 px-6 py-4 rounded-2xl bg-orange-600 hover:bg-orange-700 text-white text-xs font-bold uppercase tracking-wider shadow-lg shadow-orange-600/25 transition-all duration-200 hover:scale-[1.01] active:scale-[0.99] disabled:opacity-40 disabled:cursor-not-allowed disabled:hover:scale-100 disabled:shadow-none">
                                <i class="fa-solid fa-cart-shopping text-sm"></i>
                                <span>Pesan Sekarang</span>
                            </button>
                        </div>

                        <!-- Pesan Peringatan Validasi -->
                        <div class="space-y-1">
                            <div x-show="({{ $produk->kategori === 'Baju' }} && !selectedUkuran)"
                                class="text-xs text-rose-500 font-medium flex items-center gap-1.5" x-cloak>
                                <i class="fa-solid fa-circle-exclamation"></i> *Silakan pilih ukuran varian terlebih dahulu.
                            </div>
                            <div x-show="'{{ $produk->status }}' !== 'Tersedia'"
                                class="text-xs text-amber-600 dark:text-amber-400 font-medium flex items-center gap-1.5"
                                x-cloak>
                                <i class="fa-solid fa-triangle-exclamation"></i> *Produk ini sedang tidak tersedia untuk
                                dipesan.
                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>
@endsection
