@extends('layouts.app')

@section('title', 'Draf Perjanjian Kerja Waktu Tertentu (PKWT)')
@section('page-subtitle', 'Isi variabel formulir di bawah untuk memperbarui draf dokumen secara real-time.')

@section('content')
<!-- Print styles and utility for hiding controls when printing -->
<style>
    @media print {
        /* Sembunyikan seluruh elemen body secara default */
        body * {
            visibility: hidden !important;
        }

        /* Hanya tampilkan area pratinjau dokumen beserta isinya */
        .preview-container, .preview-container * {
            visibility: visible !important;
        }

        /* Posisikan container dokumen agar rapi di halaman cetak */
        .preview-container {
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

<div class="space-y-6" x-data="pkwtForm()">

    <!-- Bagian Form Input Variable -->
    <div class="bg-white dark:bg-gray-800 rounded-3xl border border-gray-100 dark:border-gray-700/80 p-6 sm:p-8 shadow-sm no-print space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-gray-100 dark:border-gray-700 pb-5">
            <div>
                <span class="inline-block px-3 py-1 bg-orange-50 dark:bg-orange-950/50 text-orange-600 dark:text-orange-400 font-extrabold text-[10px] uppercase tracking-wider rounded-full mb-2">Formulir Generator</span>
                <h2 class="text-lg font-black text-gray-900 dark:text-white tracking-tight">Variabel Dokumen PKWT Lengkap</h2>
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
                    <button @click="openDropdown = !openDropdown" @click.outside="openDropdown = false" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl bg-gradient-to-r from-orange-500 to-amber-500 hover:from-orange-600 hover:to-amber-600 text-white text-xs font-bold uppercase tracking-wider transition-all duration-200 shadow-md shadow-orange-500/20 hover:scale-[1.02] active:scale-[0.98]">
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
                        
                        {{-- <button @click="copyPreview(); openDropdown = false" class="w-full text-left px-4 py-2.5 text-xs font-semibold text-gray-700 dark:text-gray-200 hover:bg-orange-50 dark:hover:bg-gray-800/80 flex items-center gap-3 transition-colors">
                            <div class="w-7 h-7 rounded-xl bg-orange-100 text-orange-600 flex items-center justify-center shrink-0">
                                <i class="fa-solid fa-copy text-xs"></i>
                            </div>
                            <span>Salin Teks Dokumen</span>
                        </button> --}}
                        
                        <button @click="exportPDF(); openDropdown = false" class="w-full text-left px-4 py-2.5 text-xs font-semibold text-gray-700 dark:text-gray-200 hover:bg-orange-50 dark:hover:bg-gray-800/80 flex items-center gap-3 transition-colors">
                            <div class="w-7 h-7 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0">
                                <i class="fa-solid fa-file-pdf text-xs"></i>
                            </div>
                            <span>Export PDF (Cetak)</span>
                        </button>
                        
                        <button onclick="window.print(); openDropdown = false" class="w-full text-left px-4 py-2.5 text-xs font-semibold text-gray-700 dark:text-gray-200 hover:bg-orange-50 dark:hover:bg-gray-800/80 flex items-center gap-3 transition-colors">
                            <div class="w-7 h-7 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center shrink-0">
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
                <legend class="px-3 py-1 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-full text-xs font-extrabold uppercase tracking-wider text-orange-600 dark:text-orange-400 shadow-xs">Informasi Umum Surat</legend>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 pt-3">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Nomor Surat</label>
                        <input type="text" x-model="nomorSurat" class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition shadow-xs">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Hari TTD</label>
                        <input type="text" x-model="hariTtd" class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition shadow-xs">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Tanggal TTD</label>
                        <input type="text" x-model="tanggalTtd" class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition shadow-xs">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Kota TTD</label>
                        <input type="text" x-model="kotaTtd" class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition shadow-xs">
                    </div>
                </div>
            </fieldset>

            <!-- Pihak Pertama (Perusahaan) -->
            <fieldset class="border border-gray-200 dark:border-gray-700/80 rounded-2xl p-5 bg-gray-50/50 dark:bg-gray-900/30">
                <legend class="px-3 py-1 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-full text-xs font-extrabold uppercase tracking-wider text-orange-600 dark:text-orange-400 shadow-xs">Pihak Pertama (Perusahaan)</legend>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-3">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Nama Perusahaan</label>
                        <input type="text" x-model="namaPerusahaan" class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition shadow-xs">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Alamat Perusahaan</label>
                        <input type="text" x-model="alamatPerusahaan" class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition shadow-xs">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Diwakili Oleh</label>
                        <input type="text" x-model="diwakiliOleh" class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition shadow-xs">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Jabatan Perwakilan</label>
                        <input type="text" x-model="jabatanPerusahaan" class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition shadow-xs">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Bidang Usaha</label>
                        <input type="text" x-model="bidangUsaha" class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition shadow-xs">
                    </div>
                </div>
            </fieldset>

            <!-- Pihak Kedua (Karyawan) -->
            <fieldset class="border border-gray-200 dark:border-gray-700/80 rounded-2xl p-5 bg-gray-50/50 dark:bg-gray-900/30">
                <legend class="px-3 py-1 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-full text-xs font-extrabold uppercase tracking-wider text-orange-600 dark:text-orange-400 shadow-xs">Pihak Kedua (Karyawan)</legend>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-3">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Nama Karyawan</label>
                        <input type="text" x-model="namaKaryawan" class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition shadow-xs">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">NIK Karyawan</label>
                        <input type="text" x-model="nikKaryawan" class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition shadow-xs">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Tempat, Tgl Lahir</label>
                        <input type="text" x-model="tempatTglLahir" class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition shadow-xs">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">No. HP Karyawan</label>
                        <input type="text" x-model="noHpKaryawan" class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition shadow-xs">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Alamat Domisili</label>
                        <input type="text" x-model="alamatDomisili" class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition shadow-xs">
                    </div>
                </div>
            </fieldset>

            <!-- Detail Perjanjian -->
            <fieldset class="border border-gray-200 dark:border-gray-700/80 rounded-2xl p-5 bg-gray-50/50 dark:bg-gray-900/30">
                <legend class="px-3 py-1 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-full text-xs font-extrabold uppercase tracking-wider text-orange-600 dark:text-orange-400 shadow-xs">Detail Perjanjian</legend>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 pt-3">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Nama Jabatan</label>
                        <input type="text" x-model="namaJabatan" class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition shadow-xs">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Nama Departemen</label>
                        <input type="text" x-model="namaDepartemen" class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition shadow-xs">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Lokasi Kantor</label>
                        <input type="text" x-model="lokasiKantor" class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition shadow-xs">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Masa Kontrak</label>
                        <input type="text" x-model="masaKontrak" class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition shadow-xs">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Tanggal Mulai</label>
                        <input type="text" x-model="tglMulai" class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition shadow-xs">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Tanggal Selesai</label>
                        <input type="text" x-model="tglSelesai" class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition shadow-xs">
                    </div>
                </div>
            </fieldset>

            <!-- Informasi Gaji & Pembayaran -->
            <fieldset class="border border-gray-200 dark:border-gray-700/80 rounded-2xl p-5 bg-gray-50/50 dark:bg-gray-900/30">
                <legend class="px-3 py-1 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-full text-xs font-extrabold uppercase tracking-wider text-orange-600 dark:text-orange-400 shadow-xs">Informasi Gaji & Pembayaran</legend>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 pt-3">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Gaji Pokok (Rp)</label>
                        <input type="text" x-model="gajiPokok" class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition shadow-xs">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Nama Bank</label>
                        <input type="text" x-model="namaBank" class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition shadow-xs">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Nomor Rekening</label>
                        <input type="text" x-model="noRekening" class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition shadow-xs">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Atas Nama Rekening</label>
                        <input type="text" x-model="atasNamaRek" class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition shadow-xs">
                    </div>
                </div>
            </fieldset>
        </div>
    </div>

    <!-- Bagian Textarea Pratinjau & Edit Dokumen (Dirender dengan Tag HTML) -->
    <div class="preview-container bg-white dark:bg-gray-800 rounded-3xl border border-gray-100 dark:border-gray-700/80 p-6 sm:p-8 shadow-sm">
        <div class="mb-5 pb-4 border-b border-gray-100 dark:border-gray-700 flex flex-col sm:flex-row sm:items-center justify-between gap-3 no-print">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-xl bg-orange-100 dark:bg-orange-950/50 text-orange-600 dark:text-orange-400 flex items-center justify-center font-bold text-xs">
                    <i class="fa-solid fa-file-lines"></i>
                </div>
                <span class="text-xs font-extrabold text-gray-800 dark:text-gray-200 uppercase tracking-wider">Pratinjau Dokumen PKWT (Format HTML)</span>
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
    Alpine.data('pkwtForm', () => ({
        nomorSurat: '108/HRD-PKWT/2026',
        hariTtd: 'Jumat',
        tanggalTtd: '24 Juli 2026',
        kotaTtd: 'Jakarta',
        namaPerusahaan: 'PT Digital Sinergi Indonesia',
        alamatPerusahaan: 'Jl. Jenderal Sudirman No. 45, Jakarta Selatan',
        diwakiliOleh: 'Budi Santoso, M.B.A.',
        jabatanPerusahaan: 'Direktur Utama',
        namaKaryawan: 'Rian Hidayat',
        nikKaryawan: '3275031234560002',
        tempatTglLahir: 'Bandung, 12 Agustus 1998',
        alamatDomisili: 'Jl. Merpati Blok C No. 12, Tangerang',
        noHpKaryawan: '081234567890',
        bidangUsaha: 'Teknologi Informasi & Pengembangan Perangkat Lunak',
        namaJabatan: 'Senior Software Engineer',
        namaDepartemen: 'Divisi Teknologi Informasi',
        lokasiKantor: 'Kantor Pusat Jakarta',
        masaKontrak: '12 (dua belas) bulan',
        tglMulai: '1 Agustus 2026',
        tglSelesai: '1 Agustus 2027',
        gajiPokok: '12.000.000',
        namaBank: 'BCA',
        noRekening: '1234567890',
        atasNamaRek: 'Rian Hidayat',
        kontenSuratHtml: '',
        
        init() {
            const initial = JSON.parse(@json(json_encode($initialData ?? [])));
            for (const key in initial) {
                if (this.hasOwnProperty(key)) {
                    this[key] = initial[key];
                }
            }

            this.updateSurat();
            
            const fields = [
                'nomorSurat', 'hariTtd', 'tanggalTtd', 'kotaTtd', 'namaPerusahaan', 
                'alamatPerusahaan', 'diwakiliOleh', 'jabatanPerusahaan', 'namaKaryawan', 
                'nikKaryawan', 'tempatTglLahir', 'alamatDomisili', 'noHpKaryawan', 
                'bidangUsaha', 'namaJabatan', 'namaDepartemen', 'lokasiKantor', 
                'masaKontrak', 'tglMulai', 'tglSelesai', 'gajiPokok', 'namaBank', 
                'noRekening', 'atasNamaRek'
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
                    .signature { width:100%; margin-top:2.5rem }
                    .sig-col { width:48%; display:inline-block; vertical-align:top; }
                </style>`;

            const html = `<!doctype html><html><head><meta charset="utf-8">${styles}</head><body>
                <h4 style="text-align:center">SURAT PERJANJIAN KERJA WAKTU TERTENTU (PKWT)</h4>
                <div class="nomor"><strong>Nomor:</strong> ${esc(this.nomorSurat)}</div>

                <p>Pada hari ini, ${esc(this.hariTtd)} tanggal ${esc(this.tanggalTtd)}, bertempat di ${esc(this.kotaTtd)}, yang bertanda tangan di bawah ini:</p>
                <table style="width:100%; margin-bottom:1rem;text-align:justify">
                    <tr>
                        <td style="width:150px; vertical-align:top">Nama Perusahaan</td>
                        <td style="width:50px; vertical-align:top">:</td>
                        <td>${esc(this.namaPerusahaan)}</td>
                    </tr>
                    <tr>
                        <td style="width:150px; vertical-align:top">Alamat Perusahaan</td>
                        <td style="width:50px; vertical-align:top">:</td>
                        <td>${esc(this.alamatPerusahaan)}</td>
                    </tr>
                    <tr>    
                        <td style="width:150px; vertical-align:top">Diwakili Oleh</td>
                        <td style="width:50px; vertical-align:top">:</td>
                        <td>${esc(this.diwakiliOleh)}</td>
                    </tr>
                    <tr>
                        <td style="width:150px; vertical-align:top">Jabatan</td>
                        <td style="width:50px; vertical-align:top">:</td>
                        <td>${esc(this.jabatanPerusahaan)}</td>
                    </tr>
                </table>
                <p style="text-align: justify;">Dalam hal ini bertindak untuk dan atas nama ${esc(this.namaPerusahaan)}, yang selanjutnya disebut sebagai <strong>PIHAK PERTAMA (PENGUSAHA)</strong>.</p>

                <table style="width:100%; margin-bottom:1rem;text-align:justify">
                    <tr>
                        <td style="width:150px; vertical-align:top">Nama Lengkap</td>
                        <td style="width:50px; vertical-align:top">:</td>
                        <td>${esc(this.namaKaryawan)}</td>
                    </tr>
                    <tr>
                        <td style="width:150px; vertical-align:top">No. KTP / NIK</td>
                        <td style="width:50px; vertical-align:top">:</td>
                        <td>${esc(this.nikKaryawan)}</td>
                    </tr>
                    <tr>    
                        <td style="width:150px; vertical-align:top">Tempat, Tgl Lahir</td>
                        <td style="width:50px; vertical-align:top">:</td>
                        <td>${esc(this.tempatTglLahir)}</td>
                    </tr>
                    <tr>
                        <td style="width:150px; vertical-align:top">Alamat Domisili</td>
                        <td style="width:50px; vertical-align:top">:</td>
                        <td>${esc(this.alamatDomisili)}</td>
                    </tr>
                    <tr>
                        <td style="width:150px; vertical-align:top">No. Telepon / HP</td>
                        <td style="width:50px; vertical-align:top">:</td>
                        <td>${esc(this.noHpKaryawan)}</td>
                    </tr>
                </table>
                <p style="text-align: justify;">Dalam hal ini bertindak untuk dan atas nama diri sendiri, yang selanjutnya disebut sebagai <strong>PIHAK KEDUA (PEKERJA)</strong>.</p>

                <p style="text-align: justify;">Para Pihak menerangkan hal-hal sebagai berikut:</p>
                <ol>
                    <li style="text-align: justify;">PIHAK PERTAMA bergerak di bidang: ${esc(this.bidangUsaha)}.</li>
                    <li style="text-align: justify;">PIHAK KEDUA menyatakan memiliki kualifikasi dan kapasitas yang memadai untuk melaksanakan pekerjaan.</li>
                    <li style="text-align: justify;">Para Pihak sepakat membuat Perjanjian Kerja Waktu Tertentu (PKWT) sesuai peraturan perundang-undangan.</li>
                </ol>

                <h4 class="pasal" style="text-align: center;">PASAL 1<br>JABATAN, PENEMPATAN, DAN URAIAN TUGAS</h4>
                <ol>
                    <li style="text-align: justify;">PIHAK PERTAMA menerima PIHAK KEDUA sebagai: ${esc(this.namaJabatan)}.</li>
                    <li style="text-align: justify;">Penempatan: ${esc(this.namaDepartemen)} — ${esc(this.lokasiKantor)}.</li>
                    <li style="text-align: justify;">Uraian tugas utama:</li>
                    <ol type="a">
                        <li style="text-align: justify;">Mengembangkan, menguji, dan memelihara aplikasi/sistem perangkat lunak perusahaan.</li>
                        <li style="text-align: justify;">Melakukan koordinasi teknis dan integrasi database secara berkala.</li>
                        <li style="text-align: justify;">Menyusun laporan berkala pelaksanaan pekerjaan kepada atasan langsung.</li>
                        <li style="text-align: justify;">Melaksanakan tugas dinas lain sesuai kompetensi.</li>
                    </ol>
                </ol>

                <h4 class="pasal" style="text-align: center;">PASAL 2<br>JANGKA WAKTU PERJANJIAN</h4>
                <ol>
                    <li style="text-align: justify;">Jangka waktu: ${esc(this.masaKontrak)}, terhitung sejak ${esc(this.tglMulai)} sampai ${esc(this.tglSelesai)}.</li>
                    <li style="text-align: justify;">PKWT ini tidak mensyaratkan masa percobaan (probation).</li>
                    <li style="text-align: justify;">Setelah berakhir, hubungan kerja putus demi hukum.</li>
                    <li style="text-align: justify;">Perpanjangan hanya atas kesepakatan tertulis, paling lambat 30 hari sebelum berakhir.</li>
                </ol>

                <h4 class="pasal" style="text-align: center;">PASAL 3<br>HARI KERJA, WAKTU KERJA, DAN LEMBUR</h4>
                <ol>
                    <li style="text-align: justify;">Hari kerja: Senin — Jumat (5 hari).</li>
                    <li style="text-align: justify;">Jam kerja: 8 jam/hari; contoh jam kerja: 08.00 — 17.00, istirahat 12.00 — 13.00.</li>
                    <li style="text-align: justify;">Lembur atas perintah atasan dan dibayar sesuai ketentuan.</li>
                </ol>

                <h4 class="pasal" style="text-align: center;">PASAL 4<br>UPAH, TUNJANGAN, DAN METODE PEMBAYARAN</h4>
                <ol>
                    <li style="text-align: justify;">Rincian upah:</li>
                    <ol type="a">
                        <li style="text-align: justify;">Gaji Pokok: Rp ${esc(this.gajiPokok)} / bulan.</li>
                        <li style="text-align: justify;">Tunjangan Tetap (jika ada): Rp 0 / bulan.</li>
                        <li style="text-align: justify;">Tunjangan Tidak Tetap: Rp 0 / hari.</li>
                    </ol>
                    <li style="text-align: justify;">Pembayaran setiap bulan (contoh: tanggal 28), melalui transfer bank ke:</li>
                    <ol type="a">
                        <li style="text-align: justify;">Bank: ${esc(this.namaBank)}</li>
                        <li style="text-align: justify;">Nomor Rekening: ${esc(this.noRekening)}</li>
                        <li style="text-align: justify;">Atas Nama: ${esc(this.atasNamaRek)}</li>
                    </ol>
                    <li style="text-align: justify;">Potongan PPh 21 dan iuran jaminan sosial berlaku.</li>
                </ol>

                <h4 class="pasal" style="text-align: center;">PASAL 5<br>JAMINAN SOSIAL DAN FASILITAS KESEHATAN</h4>
                <p style="text-align: justify;">PIHAK PERTAMA mendaftarkan PIHAK KEDUA pada BPJS Ketenagakerjaan dan BPJS Kesehatan. Iuran ditanggung bersama sesuai ketentuan.</p>

                <h4 class="pasal" style="text-align: center;">PASAL 6<br>HAK CUTI DAN IZIN</h4>
                <p style="text-align: justify;">Hak cuti diberikan secara proporsional; permohonan diajukan minimal 3 hari kerja sebelumnya; sakit disertai surat keterangan dokter bila diminta.</p>

                <h4 class="pasal" style="text-align: center;">PASAL 7<br>TATA TERTIB, DISIPLIN, DAN SANKSI</h4>
                <p style="text-align: justify;">PIHAK KEDUA wajib mematuhi peraturan perusahaan. Sanksi berjenjang: Teguran Lisan; SP I; SP II; SP III; sampai PHK.</p>

                <h4 class="pasal" style="text-align: center;">PASAL 8<br>KERAHASIAAN DAN HAK KEKAYAAN INTELEKTUAL</h4>
                <p style="text-align: justify;">PIHAK KEDUA wajib menjaga kerahasiaan data dan hasil karya menjadi HKI milik PIHAK PERTAMA.</p>

                <h4 class="pasal" style="text-align: center;">PASAL 9<br>UANG KOMPENSASI PKWT</h4>
                <p style="text-align: justify;">PIHAK PERTAMA wajib memberikan uang kompensasi sesuai PP No.35/2021; pembayaran proporsional berdasarkan masa kerja.</p>

                <h4 class="pasal" style="text-align: center;">PASAL 10<br>PENGAKHIRAN SEBELUM WAKTU DAN GANTI RUGI</h4>
                <p style="text-align: justify;">Pengakhiran atas kesepakatan tertulis, pelanggaran berat, atau meninggal dunia. Pengakhiran di luar ketentuan dapat menimbulkan kewajiban ganti rugi.</p>

                <h4 class="pasal" style="text-align: center;">PASAL 11<br>PENYELESAIAN PERSELISIHAN</h4>
                <p style="text-align: justify;">Diselesaikan musyawarah; jika gagal, melalui prosedur hubungan industrial.</p>

                <h4 class="pasal" style="text-align: center;">PASAL 12<br>PENUTUP</h4>
                <p style="text-align: justify;">Hal-hal belum diatur akan dituangkan dalam addendum/amandemen tertulis. Perjanjian dibuat dan ditandatangani dalam rangkap 2 bermaterai cukup.</p>

                <br>
                <table style="width:100%; margin-bottom:1rem;text-align:justify">
                    <tr>
                        <th style="width:50%; vertical-align:top; text-align:center">PIHAK PERTAMA<br>(PENGUSAHA)</th>
                        <th style="width:50%; vertical-align:top; text-align:center">PIHAK KEDUA<br>(PEKERJA)</th>
                    </tr>
                    <tr>
                        <td style="width:50%; vertical-align:top; text-align:center"><br><br><br><br></td>
                        <td style="width:50%; vertical-align:top; text-align:center"><br><br><br><br></td>
                    </tr>
                    <tr>
                        <th style="width:50%; vertical-align:top; text-align:center; padding-top:2.5rem">(${esc(this.diwakiliOleh)})<br>${esc(this.jabatanPerusahaan)}</th>
                        <th style="width:50%; vertical-align:top; text-align:center; padding-top:2.5rem">(${esc(this.namaKaryawan)})<br>Pekerja / Karyawan</th>
                    </tr>
                </table>
            </body></html>`;

            return html;
        },

        reset() {
            this.nomorSurat = '108/HRD-PKWT/2026';
            this.hariTtd = 'Jumat';
            this.tanggalTtd = '24 Juli 2026';
            this.kotaTtd = 'Jakarta';
            this.namaPerusahaan = 'PT Digital Sinergi Indonesia';
            this.alamatPerusahaan = 'Jl. Jenderal Sudirman No. 45, Jakarta Selatan';
            this.diwakiliOleh = 'Budi Santoso, M.B.A.';
            this.jabatanPerusahaan = 'Direktur Utama';
            this.namaKaryawan = 'Rian Hidayat';
            this.nikKaryawan = '3275031234560002';
            this.tempatTglLahir = 'Bandung, 12 Agustus 1998';
            this.alamatDomisili = 'Jl. Merpati Blok C No. 12, Tangerang';
            this.noHpKaryawan = '081234567890';
            this.bidangUsaha = 'Teknologi Informasi & Pengembangan Perangkat Lunak';
            this.namaJabatan = 'Senior Software Engineer';
            this.namaDepartemen = 'Divisi Teknologi Informasi';
            this.lokasiKantor = 'Kantor Pusat Jakarta';
            this.masaKontrak = '12 (dua belas) bulan';
            this.tglMulai = '1 Agustus 2026';
            this.tglSelesai = '1 Agustus 2027';
            this.gajiPokok = '12.000.000';
            this.namaBank = 'BCA';
            this.noRekening = '1234567890';
            this.atasNamaRek = 'Rian Hidayat';
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
            a.download = 'PKWT-' + (this.nomorSurat.replace(/[\/\\]/g, '-')) + '.doc';
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