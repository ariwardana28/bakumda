@extends('layouts.app')

@section('title', 'Draf Surat Perjanjian Hutang Piutang')
@section('page-subtitle', 'Isi variabel formulir di bawah untuk memperbarui draf dokumen secara real-time.')

@section('content')
    <!-- Print styles and utility for hiding controls when printing -->
    <style>
        @media print {
            /* Sembunyikan seluruh elemen body secara default */
            body * {
                visibility: hidden !important;
            }

            /* Hanya tampilkan area preview card beserta isinya */
            .preview-card-container, .preview-card-container * {
                visibility: visible !important;
            }

            /* Posisikan container dokumen agar rapi di halaman cetak/PDF */
            .preview-card-container {
                position: absolute !important;
                left: 0 !important;
                top: 0 !important;
                width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
                background: #fff !important;
                border: none !important;
                box-shadow: none !important;
            }

            body {
                background: #fff !important;
                color: #000 !important;
            }

            .no-print {
                display: none !important;
            }

            .print-only {
                display: block !important;
            }

            .preview-card {
                background: #ffffff !important;
                color: #1e293b !important;
                border: none !important;
                box-shadow: none !important;
                padding: 0 !important;
                max-height: none !important;
                overflow: visible !important;
            }

            .preview-card * {
                color: #1e293b !important;
            }
        }
    </style>

    <div class="space-y-6" x-data="hutangPiutangForm()">

        <!-- Bagian Form Input Variable -->
        <div class="bg-white dark:bg-gray-800 rounded-3xl border border-gray-100 dark:border-gray-700/80 p-6 sm:p-8 shadow-sm no-print space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-gray-100 dark:border-gray-700 pb-5">
                <div>
                    <span class="inline-block px-3 py-1 bg-amber-50 dark:bg-amber-950/50 text-amber-600 dark:text-amber-400 font-extrabold text-[10px] uppercase tracking-wider rounded-full mb-2">Formulir Generator</span>
                    <h2 class="text-lg font-black text-gray-900 dark:text-white tracking-tight">Variabel Dokumen Hutang Piutang Lengkap</h2>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Ubah nilai di bawah untuk menyesuaikan isi surat perjanjian secara langsung.</p>
                </div>
                
                <div class="flex items-center gap-2.5 flex-wrap">
                    <!-- Tombol 1: Export ke Word -->
                    <button @click="exportWord()" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl bg-indigo-50 hover:bg-indigo-100 text-indigo-700 dark:bg-indigo-950/50 dark:text-indigo-300 text-xs font-bold uppercase tracking-wider transition-all duration-200 shadow-xs hover:scale-[1.02] active:scale-[0.98]">
                        <i class="fa-solid fa-file-word text-sm"></i> Export ke Word
                    </button>

                    <!-- Tombol 2: Reset -->
                    <button @click="reset()" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 text-xs font-bold uppercase tracking-wider transition-all duration-200 shadow-xs hover:scale-[1.02] active:scale-[0.98]">
                        <i class="fa-solid fa-rotate-left text-sm"></i> Reset
                    </button>

                    <!-- Tombol 3: Dropdown Menu Aksi Lainnya -->
                    <div class="relative" x-data="{ openDropdown: false }">
                        <button @click="openDropdown = !openDropdown" @click.outside="openDropdown = false" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-600 hover:to-orange-600 text-white text-xs font-bold uppercase tracking-wider transition-all duration-200 shadow-md shadow-amber-500/20 hover:scale-[1.02] active:scale-[0.98]">
                            <i class="fa-solid fa-bars text-sm"></i> Menu Lainnya 
                            <i class="fa-solid fa-chevron-down text-[10px] ml-1 transition-transform duration-200" :class="{ 'rotate-180': openDropdown }"></i>
                        </button>
                        
                        <!-- Dropdown Content dengan Animasi dan Styling Modern -->
                        <div x-show="openDropdown" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95 translate-y-1"
                             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                             x-transition:leave-end="opacity-0 scale-95 translate-y-1"
                             class="absolute right-0 mt-2 w-52 bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-700/80 rounded-2xl shadow-xl py-2 z-50 overflow-hidden" 
                             style="display: none;">
                            
                            <div class="px-3 py-1.5 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Aksi Dokumen</div>
                            
                            <button @click="copyPreview(); openDropdown = false" class="w-full text-left px-4 py-2.5 text-xs font-semibold text-gray-700 dark:text-gray-200 hover:bg-amber-50 dark:hover:bg-gray-800/80 flex items-center gap-3 transition-colors">
                                <div class="w-7 h-7 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center shrink-0">
                                    <i class="fa-solid fa-copy text-xs"></i>
                                </div>
                                <span>Salin Teks Dokumen</span>
                            </button>
                            
                            <button @click="exportPDF(); openDropdown = false" class="w-full text-left px-4 py-2.5 text-xs font-semibold text-gray-700 dark:text-gray-200 hover:bg-amber-50 dark:hover:bg-gray-800/80 flex items-center gap-3 transition-colors">
                                <div class="w-7 h-7 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0">
                                    <i class="fa-solid fa-file-pdf text-xs"></i>
                                </div>
                                <span>Export PDF (Cetak)</span>
                            </button>
                            
                            <button onclick="window.print(); openDropdown = false" class="w-full text-left px-4 py-2.5 text-xs font-semibold text-gray-700 dark:text-gray-200 hover:bg-amber-50 dark:hover:bg-gray-800/80 flex items-center gap-3 transition-colors">
                                <div class="w-7 h-7 rounded-xl bg-orange-100 text-orange-600 flex items-center justify-center shrink-0">
                                    <i class="fa-solid fa-print text-xs"></i>
                                </div>
                                <span>Cetak Langsung</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <!-- Informasi Umum Surat -->
                <fieldset class="border border-gray-200 dark:border-gray-700/80 rounded-2xl p-5 bg-gray-50/50 dark:bg-gray-900/30">
                    <legend class="px-3 py-1 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-full text-xs font-extrabold uppercase tracking-wider text-amber-600 dark:text-amber-400 shadow-xs">Informasi Umum Surat</legend>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 pt-3">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Nomor Surat</label>
                            <input type="text" x-model="nomorSurat" class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 outline-none transition shadow-xs">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Hari TTD</label>
                            <input type="text" x-model="hariTtd" class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 outline-none transition shadow-xs">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Tanggal TTD</label>
                            <input type="text" x-model="tanggalTtd" class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 outline-none transition shadow-xs">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Kota TTD</label>
                            <input type="text" x-model="kotaTtd" class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 outline-none transition shadow-xs">
                        </div>
                    </div>
                </fieldset>

                <!-- Pihak Pertama (Pemberi Pinjaman) -->
                <fieldset class="border border-gray-200 dark:border-gray-700/80 rounded-2xl p-5 bg-gray-50/50 dark:bg-gray-900/30">
                    <legend class="px-3 py-1 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-full text-xs font-extrabold uppercase tracking-wider text-amber-600 dark:text-amber-400 shadow-xs">Pihak Pertama (Pemberi Pinjaman)</legend>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 pt-3">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Nama Lengkap</label>
                            <input type="text" x-model="namaP1" class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 outline-none transition shadow-xs">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">No. KTP / NIK</label>
                            <input type="text" x-model="nikP1" class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 outline-none transition shadow-xs">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Pekerjaan</label>
                            <input type="text" x-model="pekerjaanP1" class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 outline-none transition shadow-xs">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Alamat</label>
                            <input type="text" x-model="alamatP1" class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 outline-none transition shadow-xs">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">No. Telepon / HP</label>
                            <input type="text" x-model="telpP1" class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 outline-none transition shadow-xs">
                        </div>
                    </div>
                </fieldset>

                <!-- Pihak Kedua (Penerima Pinjaman) -->
                <fieldset class="border border-gray-200 dark:border-gray-700/80 rounded-2xl p-5 bg-gray-50/50 dark:bg-gray-900/30">
                    <legend class="px-3 py-1 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-full text-xs font-extrabold uppercase tracking-wider text-amber-600 dark:text-amber-400 shadow-xs">Pihak Kedua (Penerima Pinjaman)</legend>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 pt-3">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Nama Lengkap</label>
                            <input type="text" x-model="namaP2" class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 outline-none transition shadow-xs">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">No. KTP / NIK</label>
                            <input type="text" x-model="nikP2" class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 outline-none transition shadow-xs">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Pekerjaan</label>
                            <input type="text" x-model="pekerjaanP2" class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 outline-none transition shadow-xs">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Alamat</label>
                            <input type="text" x-model="alamatP2" class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 outline-none transition shadow-xs">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">No. Telepon / HP</label>
                            <input type="text" x-model="telpP2" class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 outline-none transition shadow-xs">
                        </div>
                    </div>
                </fieldset>

                <!-- Rincian Pinjaman & Pembayaran -->
                <fieldset class="border border-gray-200 dark:border-gray-700/80 rounded-2xl p-5 bg-gray-50/50 dark:bg-gray-900/30">
                    <legend class="px-3 py-1 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-full text-xs font-extrabold uppercase tracking-wider text-amber-600 dark:text-amber-400 shadow-xs">Rincian Pinjaman & Pembayaran</legend>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 pt-3">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Jumlah Pinjaman (Rp)</label>
                            <input type="text" x-model="jumlahPinjaman" class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 outline-none transition shadow-xs">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Terbilang (Rupiah)</label>
                            <input type="text" x-model="terbilangPinjaman" class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 outline-none transition shadow-xs">
                        </div>
                        <div class="md:col-span-3">
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Tujuan Pinjaman</label>
                            <input type="text" x-model="tujuanPinjaman" class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 outline-none transition shadow-xs">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Cara Penyerahan Dana</label>
                            <select x-model="caraPenyerahan" class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 outline-none transition shadow-xs">
                                <option value="Tunai">Tunai</option>
                                <option value="Transfer Bank">Transfer Bank</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Nama Bank</label>
                            <input type="text" x-model="namaBank" class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 outline-none transition shadow-xs">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Nomor Rekening</label>
                            <input type="text" x-model="noRekening" class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 outline-none transition shadow-xs">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Atas Nama Rekening</label>
                            <input type="text" x-model="atasNamaRek" class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 outline-none transition shadow-xs">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Tanggal Jatuh Tempo Pelunasan</label>
                            <input type="text" x-model="tglJatuhTempo" class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 outline-none transition shadow-xs">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Cara Pembayaran</label>
                            <select x-model="caraPembayaran" class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 outline-none transition shadow-xs">
                                <option value="Sekaligus Lunas">Sekaligus Lunas</option>
                                <option value="Angsuran">Angsuran</option>
                            </select>
                        </div>
                    </div>
                </fieldset>

                <!-- Jaminan & Saksi -->
                <fieldset class="border border-gray-200 dark:border-gray-700/80 rounded-2xl p-5 bg-gray-50/50 dark:bg-gray-900/30">
                    <legend class="px-3 py-1 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-full text-xs font-extrabold uppercase tracking-wider text-amber-600 dark:text-amber-400 shadow-xs">Jaminan & Saksi</legend>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 pt-3">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Jenis Jaminan</label>
                            <input type="text" x-model="jenisJaminan" class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 outline-none transition shadow-xs">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Deskripsi / No. Dokumen</label>
                            <input type="text" x-model="deskripsiJaminan" class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 outline-none transition shadow-xs">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Jaminan Atas Nama</label>
                            <input type="text" x-model="atasNamaJaminan" class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 outline-none transition shadow-xs">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Pengadilan Negeri (Penyelesaian)</label>
                            <input type="text" x-model="pengadilanNegeri" class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 outline-none transition shadow-xs">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Nama Saksi 1</label>
                            <input type="text" x-model="saksi1" class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 outline-none transition shadow-xs">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Nama Saksi 2</label>
                            <input type="text" x-model="saksi2" class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 outline-none transition shadow-xs">
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>

        <!-- Bagian Textarea Pratinjau & Edit Dokumen (Dirender dengan Tag HTML) -->
        <div class="preview-card-container bg-white dark:bg-gray-800 rounded-3xl border border-gray-100 dark:border-gray-700/80 p-6 sm:p-8 shadow-sm">
            <div class="mb-5 pb-4 border-b border-gray-100 dark:border-gray-700 flex flex-col sm:flex-row sm:items-center justify-between gap-3 no-print">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-xl bg-amber-100 dark:bg-amber-950/50 text-amber-600 dark:text-amber-400 flex items-center justify-center font-bold text-xs">
                        <i class="fa-solid fa-file-lines"></i>
                    </div>
                    <span class="text-xs font-extrabold text-gray-800 dark:text-gray-200 uppercase tracking-wider">Pratinjau Dokumen Hutang Piutang (Format HTML)</span>
                </div>
                <span class="inline-flex items-center gap-1.5 text-[11px] text-emerald-600 dark:text-emerald-400 font-bold bg-emerald-50 dark:bg-emerald-950/50 px-3 py-1.5 rounded-xl border border-emerald-200/50 shadow-xs">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    Sinkronisasi & Format HTML Aktif
                </span>
            </div>

            <!-- Textarea tersembunyi untuk cadangan -->
            <textarea x-ref="preview" class="hidden"></textarea>

            <!-- Container Pratinjau Dokumen Berbasis Tag HTML yang Estetik -->
            <div class="preview-card w-full bg-slate-900 text-slate-100 dark:bg-gray-950 dark:text-gray-100 rounded-2xl p-6 sm:p-10 font-serif text-sm leading-relaxed shadow-inner border border-slate-800 overflow-x-auto" x-html="kontenSuratHtml"></div>
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('hutangPiutangForm', () => ({
                nomorSurat: '042 / SPHP / JKT / 2026',
                hariTtd: 'Jumat',
                tanggalTtd: '24 Juli 2026',
                kotaTtd: 'Jakarta Selatan',

                namaP1: 'H. Ahmad Subarjo, S.E.',
                nikP1: '3171011234560001',
                pekerjaanP1: 'Pengusaha / Wiraswasta',
                alamatP1: 'Jl. Melati No. 12 RT 004/002, Kel. Tebet Timur, Jakarta Selatan',
                telpP1: '081298765432',

                namaP2: 'Siti Rahmawati, S.Pd.',
                nikP2: '3174059876540003',
                pekerjaanP2: 'Pegawai Swasta',
                alamatP2: 'Jl. Kenanga Blok A5 No. 8, Kel. Kalibata, Jakarta Selatan',
                telpP2: '085612345678',

                jumlahPinjaman: '25.000.000',
                terbilangPinjaman: 'Dua Puluh Lima Juta Rupiah',
                tujuanPinjaman: 'Keperluan tambahan modal usaha perdagangan pakaian dan pengembangan toko',
                caraPenyerahan: 'Transfer Bank',
                namaBank: 'BCA',
                noRekening: '8830123456',
                atasNamaRek: 'Siti Rahmawati',
                tglJatuhTempo: '24 Januari 2027',
                caraPembayaran: 'Sekaligus Lunas',

                jenisJaminan: 'BPKB Kendaraan Bermotor (Mobil)',
                deskripsiJaminan: 'Mobil Toyota Avanza / BPKB No. M-0981234 / Tahun 2018',
                atasNamaJaminan: 'Siti Rahmawati',
                pengadilanNegeri: 'Jakarta Selatan',
                saksi1: 'Drs. Bambang Pamungkas',
                saksi2: 'Muhammad Fikri, S.Kom.',

                kontenSuratHtml: '',
                kontenSuratTeks: '',

                init() {
                    const initial = JSON.parse(@json(json_encode($initialData ?? [])));
                    for (const key in initial) {
                        if (this.hasOwnProperty(key)) {
                            this[key] = initial[key];
                        }
                    }

                    this.updateSurat();

                    const fields = [
                        'nomorSurat', 'hariTtd', 'tanggalTtd', 'kotaTtd',
                        'namaP1', 'nikP1', 'pekerjaanP1', 'alamatP1', 'telpP1',
                        'namaP2', 'nikP2', 'pekerjaanP2', 'alamatP2', 'telpP2',
                        'jumlahPinjaman', 'terbilangPinjaman', 'tujuanPinjaman', 'caraPenyerahan',
                        'namaBank', 'noRekening', 'atasNamaRek', 'tglJatuhTempo', 'caraPembayaran',
                        'jenisJaminan', 'deskripsiJaminan', 'atasNamaJaminan', 'pengadilanNegeri',
                        'saksi1', 'saksi2'
                    ];

                    fields.forEach(field => {
                        this.$watch(field, () => this.updateSurat());
                    });
                },

                escapeHtml(text) {
                    if (!text) return '';
                    return text
                        .replace(/&/g, '&amp;')
                        .replace(/</g, '&lt;')
                        .replace(/>/g, '&gt;')
                        .replace(/\"/g, '&quot;')
                        .replace(/\'/g, '&#39;');
                },

                updateSurat() {
                    this.kontenSuratHtml = this.buildHtmlDocument();
                    this.kontenSuratTeks = `SURAT PERJANJIAN HUTANG PIUTANG\nNomor: ${this.nomorSurat}\n\nPada hari ini, ${this.hariTtd} tanggal ${this.tanggalTtd}, bertempat di ${this.kotaTtd}.\n\nPihak Pertama: ${this.namaP1}\nPihak Kedua: ${this.namaP2}\nJumlah Pinjaman: Rp ${this.jumlahPinjaman}`;
                },

                buildHtmlDocument() {
                    const esc = (t) => this.escapeHtml(t || '');
                    const styles = `
                        <style>
                            @page { size: A4; margin: 24mm }
                            body {color:#111; }
                            h1 { text-align:center; font-size:16pt; margin-bottom:0.25rem }
                            .nomor { text-align:center; margin-bottom:1rem }
                            h4.pasal { font-size:12pt; margin-top:1rem; margin-bottom:0.25rem; text-align:center }
                            p { text-align:justify; font-size:11pt; line-height:1.6 }
                            ul { margin-left:1.25rem }
                            .signature { width:100%; margin-top:2.5rem }
                            .sig-col { width:48%; display:inline-block; vertical-align:top; }
                        </style>`;

                    const html = `<!doctype html><html><head><meta charset="utf-8">${styles}</head><body>
                        <h4 style="text-align:center">SURAT PERJANJIAN HUTANG PIUTANG</h4>
                        <div class="nomor"><strong>Nomor:</strong> ${esc(this.nomorSurat)}</div>

                        <p>Pada hari ini, ${esc(this.hariTtd)} tanggal ${esc(this.tanggalTtd)}, bertempat di ${esc(this.kotaTtd)}, kami yang bertanda tangan di bawah ini:</p>
                        <table style="width:100%; margin-bottom:1rem;text-align:justify">
                            <tr>
                                <td style="width:150px; vertical-align:top">Nama Lengkap</td>
                                <td style="width:50px; vertical-align:top">:</td>
                                <td>${esc(this.namaP1)}</td>
                            </tr>
                            <tr>
                                <td style="width:150px; vertical-align:top">No. KTP / NIK</td>
                                <td style="width:50px; vertical-align:top">:</td>
                                <td>${esc(this.nikP1)}</td>
                            </tr>
                            <tr>
                                <td style="width:150px; vertical-align:top">Pekerjaan</td>
                                <td style="width:50px; vertical-align:top">:</td>
                                <td>${esc(this.pekerjaanP1)}</td>
                            </tr>
                            <tr>
                                <td style="width:150px; vertical-align:top">Alamat</td>
                                <td style="width:50px; vertical-align:top">:</td>
                                <td>${esc(this.alamatP1)}</td>
                            </tr>
                            <tr>
                                <td style="width:150px; vertical-align:top">No. Telepon / HP</td>
                                <td style="width:50px; vertical-align:top">:</td>
                                <td>${esc(this.telpP1)}</td>
                            </tr>
                        </table>
                        <p style="text-align: justify;">Selanjutnya dalam perjanjian ini disebut sebagai <strong>PIHAK PERTAMA</strong>.</p>

                        <table style="width:100%; margin-bottom:1rem;text-align:justify">
                            <tr>
                                <td style="width:150px; vertical-align:top">Nama Lengkap</td>
                                <td style="width:50px; vertical-align:top">:</td>
                                <td>${esc(this.namaP2)}</td>
                            </tr>
                            <tr>
                                <td style="width:150px; vertical-align:top">No. KTP / NIK</td>
                                <td style="width:50px; vertical-align:top">:</td>
                                <td>${esc(this.nikP2)}</td>
                            </tr>
                            <tr>
                                <td style="width:150px; vertical-align:top">Pekerjaan</td>
                                <td style="width:50px; vertical-align:top">:</td>
                                <td>${esc(this.pekerjaanP2)}</td>
                            </tr>
                            <tr>
                                <td style="width:150px; vertical-align:top">Alamat</td>
                                <td style="width:50px; vertical-align:top">:</td>
                                <td>${esc(this.alamatP2)}</td>
                            </tr>
                            <tr>
                                <td style="width:150px; vertical-align:top">No. Telepon / HP</td>
                                <td style="width:50px; vertical-align:top">:</td>
                                <td>${esc(this.telpP2)}</td>
                            </tr>
                        </table>
                        <p style="text-align: justify;">Selanjutnya dalam perjanjian ini disebut sebagai <strong>PIHAK KEDUA</strong>.</p>

                        <p style="text-align: justify;">Para Pihak terlebih dahulu menerangkan bahwa PIHAK PERTAMA telah setuju untuk memberikan pinjaman uang tunai kepada PIHAK KEDUA, dan PIHAK KEDUA telah setuju menerima pinjaman tersebut dari PIHAK PERTAMA dengan ketentuan dan syarat-syarat yang diatur dalam pasal-pasal berikut:</p>

                        <h4 class="pasal" style="text-align: center;">PASAL 1<br>JUMLAH PINJAMAN</h4>
                        <p style="text-align: justify;">PIHAK PERTAMA memberikan pinjaman dana berupa uang tunai kepada PIHAK KEDUA sebesar Rp ${esc(this.jumlahPinjaman)},- (${esc(this.terbilangPinjaman)}).</p>

                        <h4 class="pasal" style="text-align: center;">PASAL 2<br>TUJUAN PINJAMAN & PENYERAHAN DANA</h4>
                        <ol>
                            <li style="text-align: justify;">Pinjaman ini digunakan oleh PIHAK KEDUA untuk keperluan: ${esc(this.tujuanPinjaman)}.</li>
                            <li style="text-align: justify;">Penyerahan dana dilakukan secara ${esc(this.caraPenyerahan)} pada tanggal ${esc(this.tanggalTtd)} ke rekening berikut:
                                <ul style="list-style-type: none; padding-left: 0; margin-top: 6px;">
                                    <li style="display: flex; margin-bottom: 4px;">
                                        <span style="width: 120px; font-weight: 500;">Nama Bank</span>
                                        <span style="width: 20px; text-align: center;">:</span>
                                        <span style="flex: 1;">${esc(this.namaBank)}</span>
                                    </li>
                                    <li style="display: flex; margin-bottom: 4px;">
                                        <span style="width: 120px; font-weight: 500;">No. Rekening</span>
                                        <span style="width: 20px; text-align: center;">:</span>
                                        <span style="flex: 1;">${esc(this.noRekening)}</span>
                                    </li>
                                    <li style="display: flex; margin-bottom: 4px;">
                                        <span style="width: 120px; font-weight: 500;">Atas Nama</span>
                                        <span style="width: 20px; text-align: center;">:</span>
                                        <span style="flex: 1;">${esc(this.atasNamaRek)}</span>
                                    </li>
                                </ul>
                            </li>
                            <li style="text-align: justify;">Surat perjanjian ini sekaligus berlaku sebagai tanda bukti penerimaan uang (Kwitansi) yang sah atas penyerahan dana tersebut.</li>
                        </ol>

                        <h4 class="pasal" style="text-align: center;">PASAL 3<br>JANGKA WAKTU & CARA PEMBAYARAN</h4>
                        <ol type="1">
                            <li style="text-align: justify;">PIHAK KEDUA berjanji dan mengikatkan diri untuk mengembalikan seluruh pinjaman tersebut kepada PIHAK PERTAMA selambat-lambatnya pada tanggal ${esc(this.tglJatuhTempo)}.</li>
                            <li style="text-align: justify;">Pengembalian pinjaman dilakukan secara ${esc(this.caraPembayaran)}.</li>
                            <li style="text-align: justify;">Jika dilakukan secara angsuran, pembayaran dilakukan sesuai jadwal kesepakatan tertulis terpisah yang menjadi bagian tidak terpisahkan dari perjanjian ini.</li>
                        </ol>

                        <h4 class="pasal" style="text-align: center;">PASAL 4<br>JAMINAN (BILA ADA)</h4>
                        <p style="text-align: justify;">Untuk menjamin pelunasan pinjaman ini, PIHAK KEDUA memberikan jaminan berupa:</p>
                        <table style="width:100%; margin-bottom:1rem;">
                            <tr>
                                <td style="width:150px; vertical-align:top">Jenis Jaminan</td>
                                <td style="width:50px; vertical-align:top">:</td>
                                <td>${esc(this.jenisJaminan)}</td>
                            </tr>
                            <tr>
                                <td style="width:150px; vertical-align:top">Deskripsi / No. Dokumen</td>
                                <td style="width:50px; vertical-align:top">:</td>
                                <td>${esc(this.deskripsiJaminan)}</td>
                            </tr>
                            <tr>
                                <td style="width:150px; vertical-align:top">Atas Nama</td>
                                <td style="width:50px; vertical-align:top">:</td>
                                <td>${esc(this.atasNamaJaminan)}</td>
                            </tr>
                        </table>
                        
                        <p style="text-align: justify;">Jaminan tersebut akan dikembalikan secara utuh oleh PIHAK PERTAMA kepada PIHAK KEDUA segera setelah seluruh hutang dilunasi.</p>

                        <h4 class="pasal" style="text-align: center;">PASAL 5<br>SANKSI & DENDA KETERLAMBATAN</h4>
                        <p style="text-align: justify;">Apabila PIHAK KEDUA terlambat melakukan pembayaran sesuai dengan tanggal jatuh tempo yang telah disepakati, maka PIHAK KEDUA dikenakan denda keterlambatan sesuai kesepakatan tambahan dari sisa pinjaman yang belum dibayarkan.</p>

                        <h4 class="pasal" style="text-align: center;">PASAL 6<br>PENYELESAIAN PERSELISIHAN</h4>
                        <ol>
                            <li style="text-align: justify;">Apabila terjadi perselisihan di kemudian hari yang timbul dari pelaksanaan perjanjian ini, Para Pihak sepakat untuk menyelesaikannya secara musyawarah untuk mufakat.</li>
                            <li style="text-align: justify;">Apabila penyelesaian secara musyawarah tidak mencapai mufakat, maka Para Pihak sepakat untuk menyelesaikan permasalahan ini melalui jalur hukum di Kepaniteraan Pengadilan Negeri ${esc(this.pengadilanNegeri)}.</li>
                        </ol>

                        <h4 class="pasal" style="text-align: center;">PASAL 7<br>PENUTUP</h4>
                        <p style="text-align: justify;">Demikian Surat Perjanjian Hutang Piutang ini dibuat dalam rangkap 2 (dua) bermaterai cukup, yang masing-masing mempunyai kekuatan hukum yang sama dan dipegang oleh PIHAK PERTAMA dan PIHAK KEDUA, serta berlaku sejak ditandatangani oleh kedua belah pihak secara sadar tanpa ada paksaan dari pihak manapun.</p>

                        <br>
                        <table style="width:100%; margin-bottom:1rem; text-align:justify">
                            <tr>
                                <th style="width:50%; vertical-align:top; text-align:center">PIHAK PERTAMA<br>(Pemberi Pinjaman)</th>
                                <th style="width:50%; vertical-align:top; text-align:center">PIHAK KEDUA<br>(Penerima Pinjaman)</th>
                            </tr>
                            <tr>
                                <td style="width:50%; vertical-align:top; text-align:center"><br><br><br><br></td>
                                <td style="width:50%; vertical-align:top; text-align:center"><br><br><br><br></td>
                            </tr>
                            <tr>
                                <th style="width:50%; vertical-align:top; text-align:center; padding-top:2.5rem">(${esc(this.namaP1)})</th>
                                <th style="width:50%; vertical-align:top; text-align:center; padding-top:2.5rem">(${esc(this.namaP2)})</th>
                            </tr>
                        </table>

                        <br>
                        <div style="text-align:center; font-weight:bold;">Saksi-Saksi:</div>
                        <table style="width:100%; margin-top:1rem; text-align:justify">
                            <tr>
                                <td style="width:50%; vertical-align:top; text-align:center">Saksi 1 (Satu)<br><br><br><br>(${esc(this.saksi1)})</td>
                                <td style="width:50%; vertical-align:top; text-align:center">Saksi 2 (Dua)<br><br><br><br>(${esc(this.saksi2)})</td>
                            </tr>
                        </table>
                    </body></html>`;

                    return html;
                },

                reset() {
                    this.nomorSurat = '042 / SPHP / JKT / 2026';
                    this.hariTtd = 'Jumat';
                    this.tanggalTtd = '24 Juli 2026';
                    this.kotaTtd = 'Jakarta Selatan';
                    this.namaP1 = 'H. Ahmad Subarjo, S.E.';
                    this.nikP1 = '3171011234560001';
                    this.pekerjaanP1 = 'Pengusaha / Wiraswasta';
                    this.alamatP1 = 'Jl. Melati No. 12 RT 004/002, Kel. Tebet Timur, Jakarta Selatan';
                    this.telpP1 = '081298765432';
                    this.namaP2 = 'Siti Rahmawati, S.Pd.';
                    this.nikP2 = '3174059876540003';
                    this.pekerjaanP2 = 'Pegawai Swasta';
                    this.alamatP2 = 'Jl. Kenanga Blok A5 No. 8, Kel. Kalibata, Jakarta Selatan';
                    this.telpP2 = '085612345678';
                    this.jumlahPinjaman = '25.000.000';
                    this.terbilangPinjaman = 'Dua Puluh Lima Juta Rupiah';
                    this.tujuanPinjaman = 'Keperluan tambahan modal usaha perdagangan pakaian dan pengembangan toko';
                    this.caraPenyerahan = 'Transfer Bank';
                    this.namaBank = 'BCA';
                    this.noRekening = '8830123456';
                    this.atasNamaRek = 'Siti Rahmawati';
                    this.tglJatuhTempo = '24 Januari 2027';
                    this.caraPembayaran = 'Sekaligus Lunas';
                    this.jenisJaminan = 'BPKB Kendaraan Bermotor (Mobil)';
                    this.deskripsiJaminan = 'Mobil Toyota Avanza / BPKB No. M-0981234 / Tahun 2018';
                    this.atasNamaJaminan = 'Siti Rahmawati';
                    this.pengadilanNegeri = 'Jakarta Selatan';
                    this.saksi1 = 'Drs. Bambang Pamungkas';
                    this.saksi2 = 'Muhammad Fikri, S.Kom.';
                    this.updateSurat();
                },

                copyPreview() {
                    try {
                        const tempDiv = document.createElement('div');
                        tempDiv.innerHTML = this.kontenSuratHtml;
                        navigator.clipboard.writeText(tempDiv.innerText || tempDiv.textContent);
                        alert('Teks dokumen berhasil disalin ke clipboard!');
                    } catch (e) {
                        alert('Tidak dapat menyalin: ' + e.message);
                    }
                },

                exportWord() {
                    const fullHtml = this.buildHtmlDocument();
                    const blob = new Blob(['\ufeff' + fullHtml], {
                        type: 'application/msword'
                    });
                    const url = URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    a.href = url;
                    a.download = 'Surat-Perjanjian-Hutang-Piutang-' + (this.nomorSurat.replace(/[\/\\]/g, '-')) + '.doc';
                    document.body.appendChild(a);
                    a.click();
                    document.body.removeChild(a);
                    URL.revokeObjectURL(url);
                },

                exportPDF() {
                    window.print();
                }
            }));
        });
    </script>
@endsection