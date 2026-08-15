@extends('layouts.app')

@section('title', 'Katalog Merchandise Resmi')

@section('content')
    <div class="container mx-auto px-4 py-10 max-w-7xl" x-data="merchandiseApp()">

        <!-- Header & Pengantar Minimalis Modern -->
        <div
            class="flex flex-col md:flex-row md:items-end justify-between mb-8 pb-6 border-b border-slate-200/80 dark:border-slate-800 gap-4">
            <div class="space-y-1.5">
                <span
                    class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-orange-500/10 text-orange-600 dark:text-orange-400 font-extrabold text-[10px] uppercase tracking-wider border border-orange-500/20">
                    <i class="fa-solid fa-store text-xs"></i> Official Store
                </span>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-white tracking-tight">Katalog Merchandise
                </h1>
                <p class="text-slate-500 dark:text-slate-400 text-xs sm:text-sm">
                    Temukan koleksi atribut dan merchandise eksklusif resmi organisasi.
                </p>
            </div>

            <!-- Filter / Info Singkat -->
            <div
                class="flex items-center gap-2 text-xs font-semibold text-slate-500 bg-slate-100 dark:bg-slate-800 px-4 py-2 rounded-2xl w-fit">
                <i class="fa-solid fa-box-archive text-orange-500"></i>
                <span>Total Produk: <strong class="text-slate-800 dark:text-slate-200">{{ count($produks) }}</strong></span>
            </div>
        </div>

        <!-- Grid Katalog Produk (Shopee Style Modern & Elegan) -->
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3 sm:gap-4">
            @forelse($produks as $item)
                <div
                    class="bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800/80 rounded-2xl overflow-hidden shadow-xs hover:shadow-xl hover:border-orange-500/50 dark:hover:border-orange-500/50 transition-all duration-300 flex flex-col justify-between group">

                    <div>
                        <!-- Gambar / Banner Produk (Aspect Square ala Marketplace) -->
                        <div
                            class="relative w-full aspect-square bg-slate-100 dark:bg-slate-800 overflow-hidden flex items-center justify-center">
                            @if ($item->gambars->isNotEmpty())
                                <img src="{{ asset('storage/' . $item->gambars->first()->gambar) }}"
                                    alt="{{ $item->nama_produk }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="flex flex-col items-center text-slate-400">
                                    <i class="fa-solid fa-image text-2xl mb-1"></i>
                                    <span class="text-[10px]">No Image</span>
                                </div>
                            @endif

                            <!-- Badge Kategori & Status di atas gambar -->
                            <div class="absolute top-2.5 left-2.5 flex flex-col gap-1 items-start">
                                <span
                                    class="px-2.5 py-0.5 rounded-md bg-slate-900/70 text-white text-[9px] font-extrabold uppercase tracking-wider backdrop-blur-md">
                                    {{ $item->kategori }}
                                </span>
                            </div>

                            <div class="absolute top-2.5 right-2.5">
                                <span
                                    class="px-2 py-0.5 rounded-md bg-emerald-500/90 text-white text-[9px] font-extrabold uppercase tracking-wider backdrop-blur-md shadow-2xs">
                                    {{ $item->status }}
                                </span>
                            </div>
                        </div>

                        <!-- Informasi Produk -->
                        <div class="p-3.5 space-y-2">
                            <h3
                                class="font-bold text-slate-800 dark:text-slate-100 text-xs sm:text-sm line-clamp-2 leading-snug group-hover:text-orange-600 dark:group-hover:text-orange-400 transition-colors">
                                {{ $item->nama_produk }}
                            </h3>

                            <div class="text-[11px] text-slate-400 dark:text-slate-500 line-clamp-1">
                                {!! strip_tags($item->deskripsi) !!}
                            </div>
                        </div>
                    </div>

                    <!-- Footer Card: Harga & Tombol Aksi Cepat -->
                    <div
                        class="p-3.5 pt-0 flex items-center justify-between gap-2 border-t border-slate-100 dark:border-slate-800/60 mt-2">
                        <div class="w-full flex items-center justify-between pt-2">
                            <!-- Tombol Detail -->
                            <a href="{{ route('merchandise.show', $item->slug) }}"
                                class="p-2 rounded-xl bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-300 text-xs transition-colors"
                                title="Lihat Detail">
                                <i class="fa-solid fa-eye"></i>
                            </a>

                            <!-- Tombol Pesan Cepat (Shopee Style Orange Accent) -->
                            <button @click="openModal({{ json_encode($item) }})"
                                class="flex-1 ml-2 inline-flex items-center justify-center gap-1.5 px-3 py-2 rounded-xl bg-orange-600 hover:bg-orange-700 text-white text-[11px] font-bold uppercase tracking-wider shadow-sm shadow-orange-600/20 transition-all duration-200 hover:scale-[1.02] active:scale-[0.98]">
                                <i class="fa-solid fa-cart-plus text-[10px]"></i> Pesan
                            </button>
                        </div>
                    </div>

                </div>
            @empty
                <div
                    class="col-span-full text-center py-16 bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/80 dark:border-slate-800 text-slate-400 space-y-2">
                    <i class="fa-solid fa-box-open text-4xl mb-1 text-slate-300"></i>
                    <p class="text-sm font-bold text-slate-700 dark:text-slate-300">Belum ada produk merchandise tersedia.
                    </p>
                    <p class="text-xs text-slate-400">Silakan cek kembali dalam waktu dekat.</p>
                </div>
            @endforelse
        </div>

        <!-- Modal Pemesanan Cepat (Modern Glassmorphism) -->
        <div x-show="isModalOpen" x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/60 backdrop-blur-sm"
            x-transition.opacity>
            <div @click.outside="closeModal()"
                class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl max-w-md w-full p-6 sm:p-7 shadow-2xl space-y-5 relative"
                x-transition.scale>

                <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-800">
                    <div>
                        <span
                            class="text-[10px] font-extrabold uppercase tracking-wider text-orange-600 dark:text-orange-400">Formulir
                            Cepat</span>
                        <h3 class="font-black text-slate-900 dark:text-white text-base">Konfirmasi Pemesanan</h3>
                    </div>
                    <button @click="closeModal()"
                        class="w-8 h-8 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-500 hover:text-slate-800 dark:hover:text-slate-200 flex items-center justify-center transition-colors">
                        <i class="fa-solid fa-xmark text-sm"></i>
                    </button>
                </div>

                <div
                    class="space-y-1.5 bg-slate-50 dark:bg-slate-800/50 p-3.5 rounded-2xl border border-slate-100 dark:border-slate-800">
                    <h4 class="font-bold text-slate-900 dark:text-white text-sm" x-text="selectedItem?.nama_produk"></h4>
                    <div class="text-xs text-slate-500 dark:text-slate-400 line-clamp-2" x-html="selectedItem?.deskripsi">
                    </div>
                </div>

                <!-- Varian Ukuran (Hanya untuk Baju) -->
                <div x-show="selectedItem?.kategori === 'Baju' && selectedItem?.ukurans && selectedItem?.ukurans.length > 0"
                    class="space-y-2.5">
                    <label class="block font-bold text-slate-700 dark:text-slate-300 text-xs">Pilih Ukuran</label>
                    <div class="grid grid-cols-4 gap-2">
                        <template x-for="ukuran in selectedItem?.ukurans" :key="ukuran.id">
                            <button @click="selectUkuran(ukuran)"
                                :class="{
                                    'bg-orange-600 text-white border-transparent shadow-md shadow-orange-600/20': selectedUkuran
                                        ?.id === ukuran.id,
                                    'bg-slate-50 text-slate-700 dark:bg-slate-800 dark:text-slate-300 border-slate-200 dark:border-slate-700 hover:border-orange-500': selectedUkuran
                                        ?.id !== ukuran.id,
                                    'opacity-40 cursor-not-allowed': ukuran.stok <= 0
                                }"
                                :disabled="ukuran.stok <= 0"
                                class="text-center p-2.5 rounded-xl border transition-all duration-200 text-xs font-bold">
                                <span x-text="ukuran.ukuran"></span>
                                <span class="block text-[9px] font-normal opacity-80"
                                    x-text="ukuran.stok > 0 ? ukuran.stok + ' stok' : 'Habis'"></span>
                            </button>
                        </template>
                    </div>
                    <div x-show="selectedUkuran"
                        class="flex justify-between items-center bg-orange-50 dark:bg-orange-950/30 border border-orange-200/50 dark:border-orange-900/30 px-3.5 py-2.5 rounded-xl text-xs">
                        <span class="text-orange-700 dark:text-orange-300 font-medium">Harga Varian:</span>
                        <span class="font-extrabold text-orange-600 dark:text-orange-400"
                            x-text="`Rp ${new Intl.NumberFormat('id-ID').format(selectedUkuran?.harga || 0)}`"></span>
                    </div>
                </div>

                <!-- Form Input Tambahan -->
                <div class="space-y-3.5 text-xs pt-1">
                    <div>
                        <label class="block font-bold text-slate-700 dark:text-slate-300 mb-1.5">Jumlah Pesanan</label>
                        <input type="number" min="1" x-model.number="jumlah"
                            class="w-full px-4 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-100 outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all">
                    </div>
                    <div x-show="selectedItem?.kategori !== 'Baju'">
                        <label class="block font-bold text-slate-700 dark:text-slate-300 mb-1.5">Catatan Tambahan
                            (Opsional)</label>
                        <input type="text" x-model="catatan" placeholder="Misal: Warna atau spesifikasi khusus"
                            class="w-full px-4 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-100 outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all">
                    </div>
                </div>

                <div class="pt-2 flex items-center gap-3">
                    <button @click="closeModal()"
                        class="w-1/2 py-3 rounded-xl bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 font-bold text-xs uppercase tracking-wider transition-colors">
                        Batal
                    </button>
                    <button @click="submitPemesanan()"
                        class="w-1/2 py-3 rounded-xl bg-orange-600 hover:bg-orange-700 text-white font-bold text-xs uppercase tracking-wider transition-colors shadow-md shadow-orange-600/25">
                        Kirim Pesanan
                    </button>
                </div>

            </div>
        </div>

    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('merchandiseApp', () => ({
                isModalOpen: false,
                selectedItem: null,
                selectedUkuran: null,
                jumlah: 1,
                catatan: '',

                openModal(item) {
                    this.selectedItem = item;
                    this.isModalOpen = true;
                },

                closeModal() {
                    this.isModalOpen = false;
                    setTimeout(() => {
                        this.selectedItem = null;
                        this.selectedUkuran = null;
                        this.jumlah = 1;
                        this.catatan = '';
                    }, 300);
                },

                selectUkuran(ukuran) {
                    this.selectedUkuran = ukuran;
                },

                submitPemesanan() {
                    alert(
                        `Pesanan untuk: ${this.selectedItem.nama_produk}\nJumlah: ${this.jumlah}\nCatatan: ${this.catatan || '-'}\n\nPesanan berhasil diproses!`);
                    this.closeModal();
                }
            }));
        });
    </script>
@endsection
