@extends('layouts.app')

@section('title', 'Draf Surat Perjanjian Kerja Sama Usaha')
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
            .preview-card-container,
            .preview-card-container * {
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

    <div class="space-y-6" x-data="kerjaSamaUsahaForm()">

        <!-- Bagian Form Input Variable -->
        <div
            class="bg-white dark:bg-gray-800 rounded-3xl border border-gray-100 dark:border-gray-700/80 p-6 sm:p-8 shadow-sm no-print space-y-6">
            <div
                class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-gray-100 dark:border-gray-700 pb-5">
                <div>
                    <span
                        class="inline-block px-3 py-1 bg-orange-50 dark:bg-orange-950/50 text-orange-600 dark:text-orange-400 font-extrabold text-[10px] uppercase tracking-wider rounded-full mb-2">Formulir
                        Generator</span>
                    <h2 class="text-lg font-black text-gray-900 dark:text-white tracking-tight">Variabel Dokumen Kerja Sama
                        Usaha Lengkap</h2>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Ubah nilai di bawah untuk menyesuaikan isi
                        surat perjanjian secara langsung.</p>
                </div>

                <div class="flex items-center gap-2.5 flex-wrap">
                    <!-- Tombol 1: Export ke Word -->
                    <button @click="exportWord()"
                        class="inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl bg-indigo-50 hover:bg-indigo-100 text-indigo-700 dark:bg-indigo-950/50 dark:text-indigo-300 text-xs font-bold uppercase tracking-wider transition-all duration-200 shadow-xs hover:scale-[1.02] active:scale-[0.98]">
                        <i class="fa-solid fa-file-word text-sm"></i> Export ke Word
                    </button>

                    <!-- Tombol 2: Reset -->
                    <button @click="reset()"
                        class="inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 text-xs font-bold uppercase tracking-wider transition-all duration-200 shadow-xs hover:scale-[1.02] active:scale-[0.98]">
                        <i class="fa-solid fa-rotate-left text-sm"></i> Reset
                    </button>

                    <!-- Tombol 3: Dropdown Menu Aksi Lainnya -->
                    <div class="relative" x-data="{ openDropdown: false }">
                        <button @click="openDropdown = !openDropdown" @click.outside="openDropdown = false"
                            class="inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl bg-gradient-to-r from-orange-500 to-amber-500 hover:from-orange-600 hover:to-amber-600 text-white text-xs font-bold uppercase tracking-wider transition-all duration-200 shadow-md shadow-orange-500/20 hover:scale-[1.02] active:scale-[0.98]">
                            <i class="fa-solid fa-bars text-sm"></i> Menu Lainnya
                            <i class="fa-solid fa-chevron-down text-[10px] ml-1 transition-transform duration-200"
                                :class="{ 'rotate-180': openDropdown }"></i>
                        </button>

                        <!-- Dropdown Content dengan Animasi dan Styling Modern -->
                        <div x-show="openDropdown" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-95 translate-y-1"
                            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                            x-transition:leave-end="opacity-0 scale-95 translate-y-1"
                            class="absolute right-0 mt-2 w-52 bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-700/80 rounded-2xl shadow-xl py-2 z-50 overflow-hidden"
                            style="display: none;">

                            <div class="px-3 py-1.5 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Aksi
                                Dokumen</div>

                            <button @click="copyPreview(); openDropdown = false"
                                class="w-full text-left px-4 py-2.5 text-xs font-semibold text-gray-700 dark:text-gray-200 hover:bg-orange-50 dark:hover:bg-gray-800/80 flex items-center gap-3 transition-colors">
                                <div
                                    class="w-7 h-7 rounded-xl bg-orange-100 text-orange-600 flex items-center justify-center shrink-0">
                                    <i class="fa-solid fa-copy text-xs"></i>
                                </div>
                                <span>Salin Teks Dokumen</span>
                            </button>

                            <button @click="exportPDF(); openDropdown = false"
                                class="w-full text-left px-4 py-2.5 text-xs font-semibold text-gray-700 dark:text-gray-200 hover:bg-orange-50 dark:hover:bg-gray-800/80 flex items-center gap-3 transition-colors">
                                <div
                                    class="w-7 h-7 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0">
                                    <i class="fa-solid fa-file-pdf text-xs"></i>
                                </div>
                                <span>Export PDF (Cetak)</span>
                            </button>

                            <button onclick="window.print(); openDropdown = false"
                                class="w-full text-left px-4 py-2.5 text-xs font-semibold text-gray-700 dark:text-gray-200 hover:bg-orange-50 dark:hover:bg-gray-800/80 flex items-center gap-3 transition-colors">
                                <div
                                    class="w-7 h-7 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center shrink-0">
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
                <fieldset
                    class="border border-gray-200 dark:border-gray-700/80 rounded-2xl p-5 bg-gray-50/50 dark:bg-gray-900/30">
                    <legend
                        class="px-3 py-1 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-full text-xs font-extrabold uppercase tracking-wider text-orange-600 dark:text-orange-400 shadow-xs">
                        Informasi Umum Surat</legend>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 pt-3">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Nomor
                                Surat</label>
                            <input type="text" x-model="nomorSurat"
                                class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition shadow-xs">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Hari TTD</label>
                            <input type="text" x-model="hariTtd"
                                class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition shadow-xs">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Tanggal
                                TTD</label>
                            <input type="text" x-model="tanggalTtd"
                                class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition shadow-xs">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Kota TTD</label>
                            <input type="text" x-model="kotaTtd"
                                class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition shadow-xs">
                        </div>
                    </div>
                </fieldset>

                <!-- Pihak Pertama (Penyandang Dana / Investor) -->
                <fieldset
                    class="border border-gray-200 dark:border-gray-700/80 rounded-2xl p-5 bg-gray-50/50 dark:bg-gray-900/30">
                    <legend
                        class="px-3 py-1 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-full text-xs font-extrabold uppercase tracking-wider text-orange-600 dark:text-orange-400 shadow-xs">
                        Pihak Pertama (Penyandang Dana / Investor)</legend>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 pt-3">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Nama
                                Lengkap</label>
                            <input type="text" x-model="namaP1"
                                class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition shadow-xs">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">No. KTP /
                                NIK</label>
                            <input type="text" x-model="nikP1"
                                class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition shadow-xs">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Jabatan /
                                Kapasitas</label>
                            <input type="text" x-model="jabatanP1"
                                class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition shadow-xs">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Alamat</label>
                            <input type="text" x-model="alamatP1"
                                class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition shadow-xs">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">No. Telepon /
                                HP</label>
                            <input type="text" x-model="telpP1"
                                class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition shadow-xs">
                        </div>
                    </div>
                </fieldset>

                <!-- Pihak Kedua (Pengelola Usaha) -->
                <fieldset
                    class="border border-gray-200 dark:border-gray-700/80 rounded-2xl p-5 bg-gray-50/50 dark:bg-gray-900/30">
                    <legend
                        class="px-3 py-1 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-full text-xs font-extrabold uppercase tracking-wider text-orange-600 dark:text-orange-400 shadow-xs">
                        Pihak Kedua (Pengelola Usaha)</legend>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 pt-3">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Nama
                                Lengkap</label>
                            <input type="text" x-model="namaP2"
                                class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition shadow-xs">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">No. KTP /
                                NIK</label>
                            <input type="text" x-model="nikP2"
                                class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition shadow-xs">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Jabatan /
                                Kapasitas</label>
                            <input type="text" x-model="jabatanP2"
                                class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition shadow-xs">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Alamat</label>
                            <input type="text" x-model="alamatP2"
                                class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition shadow-xs">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">No. Telepon /
                                HP</label>
                            <input type="text" x-model="telpP2"
                                class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition shadow-xs">
                        </div>
                    </div>
                </fieldset>

                <!-- Rincian Kerja Sama & Keuangan -->
                <fieldset
                    class="border border-gray-200 dark:border-gray-700/80 rounded-2xl p-5 bg-gray-50/50 dark:bg-gray-900/30">
                    <legend
                        class="px-3 py-1 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-full text-xs font-extrabold uppercase tracking-wider text-orange-600 dark:text-orange-400 shadow-xs">
                        Rincian Kerja Sama & Keuangan</legend>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 pt-3">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Jumlah Modal
                                (Rp)</label>
                            <input type="text" x-model="jumlahModal"
                                class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition shadow-xs">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Terbilang
                                Modal</label>
                            <input type="text" x-model="terbilangModal"
                                class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition shadow-xs">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Nama
                                Bank</label>
                            <input type="text" x-model="namaBank"
                                class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition shadow-xs">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Nomor
                                Rekening</label>
                            <input type="text" x-model="noRekening"
                                class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition shadow-xs">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Atas Nama
                                Rekening</label>
                            <input type="text" x-model="atasNamaRek"
                                class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition shadow-xs">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Persentase Pihak
                                Pertama (%)</label>
                            <input type="text" x-model="profitP1"
                                class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition shadow-xs">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Persentase Pihak
                                Kedua (%)</label>
                            <input type="text" x-model="profitP2"
                                class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition shadow-xs">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Jangka Waktu
                                Kontrak</label>
                            <input type="text" x-model="jangkaWaktu"
                                class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition shadow-xs">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Tanggal
                                Mulai</label>
                            <input type="text" x-model="tglMulai"
                                class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition shadow-xs">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Tanggal
                                Selesai</label>
                            <input type="text" x-model="tglSelesai"
                                class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition shadow-xs">
                        </div>
                    </div>
                </fieldset>

                <!-- Saksi & Domisili Hukum -->
                <fieldset
                    class="border border-gray-200 dark:border-gray-700/80 rounded-2xl p-5 bg-gray-50/50 dark:bg-gray-900/30">
                    <legend
                        class="px-3 py-1 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-full text-xs font-extrabold uppercase tracking-wider text-orange-600 dark:text-orange-400 shadow-xs">
                        Saksi & Domisili Hukum</legend>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 pt-3">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Nama Saksi
                                I</label>
                            <input type="text" x-model="saksi1"
                                class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition shadow-xs">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Nama Saksi
                                II</label>
                            <input type="text" x-model="saksi2"
                                class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition shadow-xs">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Pengadilan
                                Negeri (Penyelesaian)</label>
                            <input type="text" x-model="pengadilanNegeri"
                                class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition shadow-xs">
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>

        <!-- Bagian Textarea Pratinjau & Edit Dokumen (Dirender dengan Tag HTML) -->
        <div
            class="preview-card-container bg-white dark:bg-gray-800 rounded-3xl border border-gray-100 dark:border-gray-700/80 p-6 sm:p-8 shadow-sm">
            <div
                class="mb-5 pb-4 border-b border-gray-100 dark:border-gray-700 flex flex-col sm:flex-row sm:items-center justify-between gap-3 no-print">
                <div class="flex items-center gap-2">
                    <div
                        class="w-8 h-8 rounded-xl bg-orange-100 dark:bg-orange-950/50 text-orange-600 dark:text-orange-400 flex items-center justify-center font-bold text-xs">
                        <i class="fa-solid fa-file-lines"></i>
                    </div>
                    <span
                        class="text-xs font-extrabold text-gray-800 dark:text-gray-200 uppercase tracking-wider">Pratinjau
                        Dokumen Kerja Sama Usaha (Format HTML)</span>
                </div>
                <span
                    class="inline-flex items-center gap-1.5 text-[11px] text-emerald-600 dark:text-emerald-400 font-bold bg-emerald-50 dark:bg-emerald-950/50 px-3 py-1.5 rounded-xl border border-emerald-200/50 shadow-xs">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    Sinkronisasi & Format HTML Aktif
                </span>
            </div>

            <!-- Textarea tersembunyi untuk cadangan -->
            <textarea x-ref="preview" class="hidden"></textarea>

            <!-- Container Pratinjau Dokumen Berbasis Tag HTML yang Estetik -->
            <div class="preview-card w-full bg-slate-900 text-slate-100 dark:bg-gray-950 dark:text-gray-100 rounded-2xl p-6 sm:p-10 font-serif text-sm leading-relaxed shadow-inner border border-slate-800 overflow-x-auto"
                x-html="kontenSuratHtml"></div>
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('kerjaSamaUsahaForm', () => ({
                nomorSurat: '012/SPKS/MKS/VIII/2026',
                hariTtd: 'Rabu',
                tanggalTtd: '12 Agustus 2026',
                kotaTtd: 'Makassar',

                namaP1: 'Ahmad Fauzi, S.E.',
                nikP1: '7371011203880001',
                jabatanP1: 'Direktur Utama PT Maharadja Cipta Karya',
                alamatP1: 'Jl. AP Pettarani No. 45, Makassar',
                telpP1: '0811-4123-4567',

                namaP2: 'Rahmat Hidayat, S.Kom.',
                nikP2: '7371021508900003',
                jabatanP2: 'Pemilik / Pengelola Barbersole Studio',
                alamatP2: 'Jl. Perintis Kemerdekaan Km. 10, Makassar',
                telpP2: '0852-9988-7766',

                jumlahModal: '100.000.000',
                terbilangModal: 'seratus juta rupiah',
                namaBank: 'Bank Mandiri',
                noRekening: '152-00-1234567-8',
                atasNamaRek: 'Barbersole Studio',
                profitP1: '40',
                profitP2: '60',
                jangkaWaktu: '2 (dua) tahun',
                tglMulai: '12 Agustus 2026',
                tglSelesai: '12 Agustus 2028',

                saksi1: 'Hendra Wijaya, S.H.',
                saksi2: 'Siti Nurhaliza',
                pengadilanNegeri: 'Makassar',

                kontenSuratHtml: '',

                init() {
                    this.updateSurat();

                    const fields = [
                        'nomorSurat', 'hariTtd', 'tanggalTtd', 'kotaTtd',
                        'namaP1', 'nikP1', 'jabatanP1', 'alamatP1', 'telpP1',
                        'namaP2', 'nikP2', 'jabatanP2', 'alamatP2', 'telpP2',
                        'jumlahModal', 'terbilangModal', 'namaBank', 'noRekening', 'atasNamaRek',
                        'profitP1', 'profitP2', 'jangkaWaktu', 'tglMulai', 'tglSelesai',
                        'saksi1', 'saksi2', 'pengadilanNegeri'
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
                },

                buildHtmlDocument() {
                    const esc = (t) => this.escapeHtml(t || '');
                    const styles = `
                <style>
                    @page { size: A4; margin: 24mm }
                    body {  color:#111; }
                    h1 { text-align:center; font-size:16pt; margin-bottom:0.25rem }
                    .nomor { text-align:center; margin-bottom:1rem }
                    h4.pasal { font-size:12pt; margin-top:1rem; margin-bottom:0.25rem; text-align:center }
                    p { text-align:justify; font-size:11pt; line-height:1.6 }
                    ul { margin-left:1.25rem }
                </style>`;

                    const html = `<!doctype html><html><head><meta charset="utf-8">${styles}</head><body>
                <h4 style="text-align:center">SURAT PERJANJIAN KERJA SAMA USAHA</h4>
                <div class="nomor"><strong>Nomor:</strong> ${esc(this.nomorSurat)}</div>

                <p>Pada hari ini, <strong>${esc(this.hariTtd)}</strong> tanggal <strong>${esc(this.tanggalTtd)}</strong>, bertempat di <strong>${esc(this.kotaTtd)}</strong>, para pihak yang bertanda tangan di bawah ini:</p>

                <div style="margin-bottom: 1rem;">
                    <p class="font-semibold text-orange-600">1. PIHAK PERTAMA (Penyandang Dana / Investor)</p>
                    <table style="width:100%; margin-top:0.25rem; text-align:justify">
                        <tr><td style="width:150px; vertical-align:top">Nama Lengkap</td><td style="width:20px; vertical-align:top">:</td><td style="vertical-align:top"><strong>${esc(this.namaP1)}</strong></td></tr>
                        <tr><td style="vertical-align:top">No. KTP / NIK</td><td style="vertical-align:top">:</td><td style="vertical-align:top">${esc(this.nikP1)}</td></tr>
                        <tr><td style="vertical-align:top">Jabatan / Kapasitas</td><td style="vertical-align:top">:</td><td style="vertical-align:top">${esc(this.jabatanP1)}</td></tr>
                        <tr><td style="vertical-align:top">Alamat</td><td style="vertical-align:top">:</td><td style="vertical-align:top">${esc(this.alamatP1)}</td></tr>
                        <tr><td style="vertical-align:top">No. Telepon / HP</td><td style="vertical-align:top">:</td><td style="vertical-align:top">${esc(this.telpP1)}</td></tr>
                    </table>
                    <p style="margin-top: 0.5rem; text-align: justify;">Dalam hal ini bertindak untuk dan atas nama PT Maharadja Cipta Karya, selanjutnya disebut sebagai <strong>PIHAK PERTAMA</strong>.</p>
                </div>

                <div style="margin-bottom: 1rem;">
                    <p class="font-semibold text-orange-600">2. PIHAK KEDUA (Pengelola Usaha)</p>
                    <table style="width:100%; margin-top:0.25rem; text-align:justify">
                        <tr><td style="width:150px; vertical-align:top">Nama Lengkap</td><td style="width:20px; vertical-align:top">:</td><td style="vertical-align:top"><strong>${esc(this.namaP2)}</strong></td></tr>
                        <tr><td style="vertical-align:top">No. KTP / NIK</td><td style="vertical-align:top">:</td><td style="vertical-align:top">${esc(this.nikP2)}</td></tr>
                        <tr><td style="vertical-align:top">Jabatan / Kapasitas</td><td style="vertical-align:top">:</td><td style="vertical-align:top">${esc(this.jabatanP2)}</td></tr>
                        <tr><td style="vertical-align:top">Alamat</td><td style="vertical-align:top">:</td><td style="vertical-align:top">${esc(this.alamatP2)}</td></tr>
                        <tr><td style="vertical-align:top">No. Telepon / HP</td><td style="vertical-align:top">:</td><td style="vertical-align:top">${esc(this.telpP2)}</td></tr>
                    </table>
                    <p style="margin-top: 0.5rem; text-align: justify;">Dalam hal ini bertindak untuk dan atas nama diri sendiri, selanjutnya disebut sebagai <strong>PIHAK KEDUA</strong>.</p>
                </div>

                <p style="text-align: justify;">Para Pihak terlebih dahulu menerangkan hal-hal sebagai berikut:</p>
                <ol style="margin-left: 1.5rem; text-align: justify;">
                    <li>Bahwa PIHAK PERTAMA adalah badan usaha yang bergerak di bidang penyediaan modal dan investasi usaha.</li>
                    <li>Bahwa PIHAK KEDUA adalah perorangan yang memiliki keahlian dan mengelola bisnis layanan perawatan dan jasa kreatif "Barbersole".</li>
                    <li>Bahwa Para Pihak bersepakat untuk melakukan kerja sama penyertaan modal dan pengembangan cabang usaha baru Barbersole.</li>
                </ol>

                <p style="text-align: justify; margin-top: 1rem;">Berdasarkan pertimbangan tersebut, Para Pihak sepakat untuk menandatangani Surat Perjanjian Kerja Sama ini dengan ketentuan sebagai berikut:</p>

                <h4 class="pasal">PASAL 1<br>MAKSUD DAN TUJUAN</h4>
                <p>Maksud dan tujuan dari Perjanjian ini adalah untuk mengatur skema kerja sama penyertaan modal, pengoperasian, serta pembagian hasil usaha dalam pengembangan cabang baru Barbersole di wilayah Makassar secara profesional, transparan, dan saling menguntungkan.</p>

                <h4 class="pasal">PASAL 2<br>RUANG LINGKUP KERJA SAMA</h4>
                <p>Ruang lingkup kerja sama mencakup penyediaan dana investasi oleh PIHAK PERTAMA serta pengelolaan operasional harian, pemasaran, pengadaan peralatan, dan manajemen sumber daya manusia oleh PIHAK KEDUA.</p>

                <h4 class="pasal">PASAL 3<br>MODAL INVESTASI DAN PENYETORAN DANA</h4>
                <ol style="margin-left: 1.5rem; text-align: justify;">
                    <li>PIHAK PERTAMA menyetorkan modal investasi sebesar <strong>Rp ${esc(this.jumlahModal)}</strong> (<em>${esc(this.terbilangModal)}</em>).</li>
                    <li>Penyetoran dana dilakukan melalui transfer bank ke rekening operasional usaha yang ditunjuk oleh PIHAK KEDUA:
                        <ul style="list-style-type: disc; margin-top: 0.25rem;">
                            <li>Nama Bank: ${esc(this.namaBank)}</li>
                            <li>Nomor Rekening: ${esc(this.noRekening)}</li>
                            <li>Atas Nama: ${esc(this.atasNamaRek)}</li>
                        </ul>
                    </li>
                    <li>Modal investasi tersebut dialokasikan secara khusus untuk biaya sewa lokasi, renovasi tempat, pengadaan peralatan kerja, serta operasional awal usaha.</li>
                </ol>

                <h4 class="pasal">PASAL 4<br>SKEMA BAGI HASIL DAN LAPORAN KEUANGAN</h4>
                <ol style="margin-left: 1.5rem; text-align: justify;">
                    <li>Para Pihak sepakat membagi keuntungan bersih (net profit) yang dihitung dari pendapatan kotor dikurangi biaya operasional rutin bulanan.</li>
                    <li>Porsi pembagian laba (profit sharing) ditetapkan sebagai berikut:
                        <ul style="list-style-type: disc; margin-top: 0.25rem;">
                            <li>PIHAK PERTAMA berhak atas <strong>${esc(this.profitP1)}%</strong> dari keuntungan bersih.</li>
                            <li>PIHAK KEDUA berhak atas <strong>${esc(this.profitP2)}%</strong> dari keuntungan bersih.</li>
                        </ul>
                    </li>
                    <li>PIHAK KEDUA wajib menyusun dan menyampaikan Laporan Keuangan Bulanan kepada PIHAK PERTAMA paling lambat tanggal 3 setiap bulannya.</li>
                    <li>Pembayaran pembagian laba dilakukan setiap bulan pada tanggal 5 melalui transfer bank.</li>
                </ol>

                <h4 class="pasal">PASAL 5<br>JANGKA WAKTU DAN PERPANJANGAN</h4>
                <ol style="margin-left: 1.5rem; text-align: justify;">
                    <li>Perjanjian ini berlaku untuk jangka waktu <strong>${esc(this.jangkaWaktu)}</strong>, terhitung sejak tanggal ${esc(this.tglMulai)} sampai dengan tanggal ${esc(this.tglSelesai)}.</li>
                    <li>Perjanjian ini dapat diperpanjang atas kesepakatan tertulis Para Pihak paling lambat 30 (tiga puluh) hari sebelum jangka waktu Perjanjian berakhir.</li>
                </ol>

                <h4 class="pasal">PASAL 6<br>HAK DAN KEWAJIBAN PIHAK PERTAMA</h4>
                <ol style="margin-left: 1.5rem; text-align: justify;">
                    <li>Kewajiban PIHAK PERTAMA:
                        <ul style="list-style-type: disc; margin-top: 0.25rem;">
                            <li>Menyetorkan dana modal investasi secara penuh dan tepat waktu sesuai Pasal 3.</li>
                            <li>Menjaga kerahasiaan data operasional dan resep/metode kerja bisnis milik PIHAK KEDUA.</li>
                        </ul>
                    </li>
                    <li>Hak PIHAK PERTAMA:
                        <ul style="list-style-type: disc; margin-top: 0.25rem;">
                            <li>Menerima pembagian keuntungan bersih bulanan sesuai porsi dalam Pasal 4.</li>
                            <li>Menerima dan memeriksa laporan keuangan bulanan serta melakukan audit sewaktu-waktu jika diperlukan.</li>
                        </ul>
                    </li>
                </ol>

                <h4 class="pasal">PASAL 7<br>HAK DAN KEWAJIBAN PIHAK KEDUA</h4>
                <ol style="margin-left: 1.5rem; text-align: justify;">
                    <li>Kewajiban PIHAK KEDUA:
                        <ul style="list-style-type: disc; margin-top: 0.25rem;">
                            <li>Mengelola kegiatan operasional unit usaha secara profesional, jujur, dan efisien.</li>
                            <li>Menyusun laporan keuangan yang akurat dan membayarkan bagian keuntungan PIHAK PERTAMA tepat waktu.</li>
                            <li>Merawat seluruh fasilitas dan peralatan usaha milik tempat kerja sama.</li>
                        </ul>
                    </li>
                    <li>Hak PIHAK KEDUA:
                        <ul style="list-style-type: disc; margin-top: 0.25rem;">
                            <li>Menerima setoran modal investasi penuh dari PIHAK PERTAMA.</li>
                            <li>Mengambil keputusan teknis operasional harian demi kelancaran usaha.</li>
                            <li>Menerima porsi pembagian laba sebesar ${esc(this.profitP2)}% dari keuntungan bersih.</li>
                        </ul>
                    </li>
                </ol>

                <h4 class="pasal">PASAL 8<br>KERAHASIAAN INFORMASI (CONFIDENTIALITY)</h4>
                <p>Para Pihak sepakat untuk menjaga kerahasiaan seluruh dokumen, data keuangan, rahasia dagang, serta sistem operasional yang berkaitan dengan kerja sama ini, dan tidak membocorkannya kepada pihak ketiga tanpa izin tertulis dari pihak lainnya.</p>

                <h4 class="pasal">PASAL 9<br>PENGAKHIRAN PERJANJIAN DAN WANPRESTASI</h4>
                <ol style="margin-left: 1.5rem; text-align: justify;">
                    <li>Perjanjian ini berakhir demi hukum apabila jangka waktu perjanjian telah selesai dan tidak diperpanjang.</li>
                    <li>Apabila salah satu pihak melanggar ketentuan dalam Perjanjian ini (wanprestasi), pihak yang dirugikan berhak memberikan Surat Peringatan tertulis. Jika dalam 14 (empat belas) hari tidak dilakukan perbaikan, pihak yang dirugikan berhak mengakhiri Perjanjian secara sepihak dan menuntut ganti rugi.</li>
                </ol>

                <h4 class="pasal">PASAL 10<br>KEADAAN MEMAKSA (FORCE MAJEURE)</h4>
                <ol style="margin-left: 1.5rem; text-align: justify;">
                    <li>Keadaan Memaksa (Force Majeure) adalah kejadian di luar kendali wajar Para Pihak, seperti bencana alam, kebakaran, perang, kerusuhan, atau kebijakan pemerintah yang berdampak langsung pada kelangsungan usaha.</li>
                    <li>Pihak yang mengalami Force Majeure wajib memberitahukan secara tertulis kepada pihak lainnya paling lambat 7 (tujuh) hari kerja sejak terjadinya peristiwa untuk disepakati langkah penanggulangannya.</li>
                </ol>

                <h4 class="pasal">PASAL 11<br>PENYELESAIAN SENGKETA</h4>
                <ol style="margin-left: 1.5rem; text-align: justify;">
                    <li>Segala perselisihan yang timbul dari Perjanjian ini akan diselesaikan secara musyawarah untuk mufakat.</li>
                    <li>Apabila musyawarah tidak mencapai mufakat dalam waktu 30 (tiga puluh) hari, Para Pihak sepakat memilih domisili hukum yang tetap di Kantor Kepaniteraan Pengadilan Negeri <strong>${esc(this.pengadilanNegeri)}</strong>.</li>
                </ol>

                <h4 class="pasal">PASAL 12<br>PENUTUP</h4>
                <p>Demikian Perjanjian ini dibuat dalam rangkap 2 (dua) asli bermaterai cukup dan memiliki kekuatan hukum yang sama bagi Para Pihak sejak tanggal ditandatangani.</p>

                <br><br>
                <table style="width:100%; margin-bottom:1rem; text-align:justify">
                    <tr>
                        <th style="width:50%; vertical-align:top; text-align:center">PIHAK PERTAMA<br>Direktur Utama PT MCK</th>
                        <th style="width:50%; vertical-align:top; text-align:center">PIHAK KEDUA<br>Pengelola Barbersole</th>
                    </tr>
                    <tr>
                        <td style="width:50%; vertical-align:top; text-align:center"><br><br>[ Materai Rp 10.000 ]<br><br></td>
                        <td style="width:50%; vertical-align:top; text-align:center"><br><br>[ Materai Rp 10.000 ]<br><br></td>
                    </tr>
                    <tr>
                        <th style="width:50%; vertical-align:top; text-align:center; padding-top:2.5rem">(${esc(this.namaP1)})</th>
                        <th style="width:50%; vertical-align:top; text-align:center; padding-top:2.5rem">(${esc(this.namaP2)})</th>
                    </tr>
                </table>

                <br>
                <div style="text-align:center; font-weight:bold;">SAKSI-SAKSI:</div>
                <table style="width:100%; margin-top:1rem; text-align:justify">
                    <tr>
                        <td style="width:50%; vertical-align:top; text-align:center"><b>Saksi</b> I<br><br><br><br>(${esc(this.saksi1)})</td>
                        <td style="width:50%; vertical-align:top; text-align:center"><b>Saksi</b> II<br><br><br><br>(${esc(this.saksi2)})</td>
                    </tr>
                </table>
            </body></html>`;

                    return html;
                },

                reset() {
                    this.nomorSurat = '012/SPKS/MKS/VIII/2026';
                    this.hariTtd = 'Rabu';
                    this.tanggalTtd = '12 Agustus 2026';
                    this.kotaTtd = 'Makassar';
                    this.namaP1 = 'Ahmad Fauzi, S.E.';
                    this.nikP1 = '7371011203880001';
                    this.jabatanP1 = 'Direktur Utama PT Maharadja Cipta Karya';
                    this.alamatP1 = 'Jl. AP Pettarani No. 45, Makassar';
                    this.telpP1 = '0811-4123-4567';
                    this.namaP2 = 'Rahmat Hidayat, S.Kom.';
                    this.nikP2 = '7371021508900003';
                    this.jabatanP2 = 'Pemilik / Pengelola Barbersole Studio';
                    this.alamatP2 = 'Jl. Perintis Kemerdekaan Km. 10, Makassar';
                    this.telpP2 = '0852-9988-7766';
                    this.jumlahModal = '100.000.000';
                    this.terbilangModal = 'seratus juta rupiah';
                    this.namaBank = 'Bank Mandiri';
                    this.noRekening = '152-00-1234567-8';
                    this.atasNamaRek = 'Barbersole Studio';
                    this.profitP1 = '40';
                    this.profitP2 = '60';
                    this.jangkaWaktu = '2 (dua) tahun';
                    this.tglMulai = '12 Agustus 2026';
                    this.tglSelesai = '12 Agustus 2028';
                    this.saksi1 = 'Hendra Wijaya, S.H.';
                    this.saksi2 = 'Siti Nurhaliza';
                    this.pengadilanNegeri = 'Makassar';

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
                    a.download = 'Surat-Perjanjian-Kerja-Sama-Usaha-' + (this.nomorSurat.replace(
                        /[\/\\]/g, '-')) + '.doc';
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
