@extends('layouts.app')

@section('title', 'Draf Surat Permohonan Umum')
@section('page-subtitle', 'Isi variabel formulir di bawah untuk memperbarui draf surat permohonan secara real-time.')

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

<div class="space-y-6" x-data="suratPermohonanForm()">

    <!-- Bagian Form Input Variable -->
    <div class="bg-white dark:bg-gray-800 rounded-3xl border border-gray-100 dark:border-gray-700/80 p-6 sm:p-8 shadow-sm no-print space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-gray-100 dark:border-gray-700 pb-5">
            <div>
                <span class="inline-block px-3 py-1 bg-orange-50 dark:bg-orange-950/50 text-orange-600 dark:text-orange-400 font-extrabold text-[10px] uppercase tracking-wider rounded-full mb-2">Formulir Generator</span>
                <h2 class="text-lg font-black text-gray-900 dark:text-white tracking-tight">Variabel Dokumen Surat Permohonan</h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Ubah nilai di bawah untuk menyesuaikan isi surat permohonan secara langsung.</p>
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
                        
                        <button @click="copyPreview(); openDropdown = false" class="w-full text-left px-4 py-2.5 text-xs font-semibold text-gray-700 dark:text-gray-200 hover:bg-orange-50 dark:hover:bg-gray-800/80 flex items-center gap-3 transition-colors">
                            <div class="w-7 h-7 rounded-xl bg-orange-100 text-orange-600 flex items-center justify-center shrink-0">
                                <i class="fa-solid fa-copy text-xs"></i>
                            </div>
                            <span>Salin Teks Dokumen</span>
                        </button>
                        
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
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Sifat</label>
                        <input type="text" x-model="sifat" class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition shadow-xs">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Lampiran</label>
                        <input type="text" x-model="lampiran" class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition shadow-xs">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Tanggal Surat</label>
                        <input type="text" x-model="tanggalSurat" class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition shadow-xs">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Perihal Permohonan</label>
                        <input type="text" x-model="perihal" class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition shadow-xs">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Kota / Tempat Asal</label>
                        <input type="text" x-model="kotaAsal" class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition shadow-xs">
                    </div>
                </div>
            </fieldset>

            <!-- Penerima Surat -->
            <fieldset class="border border-gray-200 dark:border-gray-700/80 rounded-2xl p-5 bg-gray-50/50 dark:bg-gray-900/30">
                <legend class="px-3 py-1 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-full text-xs font-extrabold uppercase tracking-wider text-orange-600 dark:text-orange-400 shadow-xs">Penerima Surat (Tujuan)</legend>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 pt-3">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Jabatan Penerima</label>
                        <input type="text" x-model="jabatanPenerima" class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition shadow-xs">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Nama Instansi / Perusahaan</label>
                        <input type="text" x-model="namaInstansi" class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition shadow-xs">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Kota / Tempat Tujuan</label>
                        <input type="text" x-model="kotaTujuan" class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition shadow-xs">
                    </div>
                    <div class="md:col-span-3">
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Alamat Lengkap Instansi</label>
                        <input type="text" x-model="alamatInstansi" class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition shadow-xs">
                    </div>
                </div>
            </fieldset>

            <!-- Data Pemohon -->
            <fieldset class="border border-gray-200 dark:border-gray-700/80 rounded-2xl p-5 bg-gray-50/50 dark:bg-gray-900/30">
                <legend class="px-3 py-1 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-full text-xs font-extrabold uppercase tracking-wider text-orange-600 dark:text-orange-400 shadow-xs">Data Pemohon</legend>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 pt-3">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Nama Lengkap Pemohon</label>
                        <input type="text" x-model="namaPemohon" class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition shadow-xs">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">NIK / NIP / NIM</label>
                        <input type="text" x-model="nikPemohon" class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition shadow-xs">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Jabatan / Status Pemohon</label>
                        <input type="text" x-model="jabatanPemohon" class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition shadow-xs">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Alamat Lengkap Pemohon</label>
                        <input type="text" x-model="alamatPemohon" class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition shadow-xs">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">No. Telepon / HP</label>
                        <input type="text" x-model="telpPemohon" class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition shadow-xs">
                    </div>
                </div>
            </fieldset>

            <!-- Isi & Substansi Permohonan -->
            <fieldset class="border border-gray-200 dark:border-gray-700/80 rounded-2xl p-5 bg-gray-50/50 dark:bg-gray-900/30">
                <legend class="px-3 py-1 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-full text-xs font-extrabold uppercase tracking-wider text-orange-600 dark:text-orange-400 shadow-xs">Substansi & Latar Belakang</legend>
                <div class="grid grid-cols-1 gap-4 pt-3">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Latar Belakang / Alasan Permohonan</label>
                        <textarea x-model="latarBelakang" rows="2" class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition shadow-xs"></textarea>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Rincian Permohonan Secara Spesifik</label>
                        <textarea x-model="rincianPermohonan" rows="2" class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition shadow-xs"></textarea>
                    </div>
                    
                    <!-- Dinamis Dokumen Pendukung -->
                    <div class="space-y-3 pt-2">
                        <div class="flex items-center justify-between">
                            <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">Daftar Dokumen Pendukung</label>
                            <button type="button" @click="tambahDokumen()" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-orange-50 dark:bg-orange-950/50 hover:bg-orange-100 text-orange-600 dark:text-orange-400 text-xs font-bold transition-colors shadow-xs">
                                <i class="fa-solid fa-plus text-xs"></i> Tambah Dokumen
                            </button>
                        </div>
                        <template x-for="(doc, index) in daftarDokumen" :key="index">
                            <div class="flex items-center gap-2">
                                <span class="text-xs font-bold text-gray-500 w-6 text-right" x-text="(index + 1) + '.'"></span>
                                <input type="text" x-model="daftarDokumen[index]" @input="updateSurat()" class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition shadow-xs" placeholder="Nama dokumen pendukung...">
                                <button type="button" @click="hapusDokumen(index)" class="p-2.5 text-red-500 hover:text-red-700 rounded-xl hover:bg-red-50 dark:hover:bg-red-950/30 transition-colors" title="Hapus Dokumen">
                                    <i class="fa-solid fa-trash text-xs"></i>
                                </button>
                            </div>
                        </template>
                    </div>
                </div>
            </fieldset>
        </div>
    </div>

    <!-- Bagian Textarea Pratinjau & Edit Dokumen (Dirender dengan Tag HTML) -->
    <div class="preview-card-container bg-white dark:bg-gray-800 rounded-3xl border border-gray-100 dark:border-gray-700/80 p-6 sm:p-8 shadow-sm">
        <div class="mb-5 pb-4 border-b border-gray-100 dark:border-gray-700 flex flex-col sm:flex-row sm:items-center justify-between gap-3 no-print">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-xl bg-orange-100 dark:bg-orange-950/50 text-orange-600 dark:text-orange-400 flex items-center justify-center font-bold text-xs">
                    <i class="fa-solid fa-file-lines"></i>
                </div>
                <span class="text-xs font-extrabold text-gray-800 dark:text-gray-200 uppercase tracking-wider">Pratinjau Dokumen Surat Permohonan (Format HTML)</span>
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
    Alpine.data('suratPermohonanForm', () => ({
        nomorSurat: '015/PRM/VIII/2026',
        sifat: 'Penting',
        lampiran: '1 (satu) Berkas',
        tanggalSurat: '12 Agustus 2026',
        perihal: 'Permohonan Penerbitan Salinan Dokumen Resmi',
        kotaAsal: 'Makassar',

        jabatanPenerima: 'Pimpinan Lembaga Layanan Pendidikan',
        namaInstansi: 'Kantor Dinas Pendidikan dan Kebudayaan',
        alamatInstansi: 'Jl. Jenderal Sudirman No. 88',
        kotaTujuan: 'Makassar',

        namaPemohon: 'Muhammad Fikri, S.Kom.',
        nikPemohon: '3171012308980002',
        jabatanPemohon: 'Alumni / Pengurus Yayasan Pendidikan',
        alamatPemohon: 'Jl. Anggrek Raya Blok C No. 5',
        telpPemohon: '081234567890',

        latarBelakang: 'kebutuhan legalisasi arsip penunjang akreditasi program kerja lembaga tahun anggaran berjalan',
        rincianPermohonan: 'penerbitan salinan dokumen perizinan pendirian serta legalisasi arsip kelembagaan',
        
        daftarDokumen: [
            'Fotokopi Kartu Tanda Penduduk (KTP) / Identitas Diri',
            'Surat Keterangan Aktif dari Kelurahan',
            'Proposal Kegiatan dan Lembar Pengesahan'
        ],

        kontenSuratHtml: '',
        
        init() {
            this.updateSurat();
            
            const fields = [
                'nomorSurat', 'sifat', 'lampiran', 'tanggalSurat', 'perihal', 'kotaAsal',
                'jabatanPenerima', 'namaInstansi', 'alamatInstansi', 'kotaTujuan',
                'namaPemohon', 'nikPemohon', 'jabatanPemohon', 'alamatPemohon', 'telpPemohon',
                'latarBelakang', 'rincianPermohonan'
            ];

            fields.forEach(field => {
                this.$watch(field, () => this.updateSurat());
            });
        },

        tambahDokumen() {
            this.daftarDokumen.push('');
            this.updateSurat();
        },

        hapusDokumen(index) {
            this.daftarDokumen.splice(index, 1);
            this.updateSurat();
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
            let htmlListItems = '';
            this.daftarDokumen.forEach(doc => {
                htmlListItems += `<li>${esc(doc)};</li>\n`;
            });

            const styles = `
                <style>
                    @page { size: A4; margin: 24mm }
                    body {  color:#111; }
                    p { text-align:justify; font-size:11pt; line-height:1.6 }
                    ul { margin-left:1.25rem }
                </style>`;

            const html = `<!doctype html><html><head><meta charset="utf-8">${styles}</head><body>
                <table style="width:100%; margin-bottom:1rem; font-size:11pt;">
                    <tr>
                        <td style="width:100px; vertical-align:top">Nomor</td>
                        <td style="width:20px; vertical-align:top">:</td>
                        <td style="vertical-align:top">${esc(this.nomorSurat)}</td>
                        <td style="text-align:right; vertical-align:top">${esc(this.kotaAsal)}, ${esc(this.tanggalSurat)}</td>
                    </tr>
                    <tr>
                        <td style="vertical-align:top">Sifat</td>
                        <td style="vertical-align:top">:</td>
                        <td colspan="2" style="vertical-align:top">${esc(this.sifat)}</td>
                    </tr>
                    <tr>
                        <td style="vertical-align:top">Lampiran</td>
                        <td style="vertical-align:top">:</td>
                        <td colspan="2" style="vertical-align:top">${esc(this.lampiran)}</td>
                    </tr>
                    <tr>
                        <td style="vertical-align:top">Perihal</td>
                        <td style="vertical-align:top">:</td>
                        <td colspan="2" style="vertical-align:top"><strong>${esc(this.perihal)}</strong></td>
                    </tr>
                </table>

                <div style="margin-top:1.5rem; margin-bottom:1.5rem; font-size:11pt;">
                    <br>
                    Kepada Yth.<br>
                    <strong>${esc(this.jabatanPenerima)}</strong><br>
                    ${esc(this.namaInstansi)}<br>
                    ${esc(this.alamatInstansi)}<br>
                    di -<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;<strong>${esc(this.kotaTujuan)}</strong>
                </div>

                <p>Dengan hormat,</p>
                <p>Sehubungan dengan ${esc(this.latarBelakang)}, maka saya yang bertanda tangan di bawah ini:</p>

                <table style="width:100%; margin-bottom:1rem; margin-left:1rem; font-size:11pt;">
                    <tr>
                        <td style="width:160px; vertical-align:top">Nama Lengkap</td>
                        <td style="width:20px; vertical-align:top">:</td>
                        <td style="vertical-align:top"><strong>${esc(this.namaPemohon)}</strong></td>
                    </tr>
                    <tr>
                        <td style="vertical-align:top">NIK/NIP/NIM</td>
                        <td style="vertical-align:top">:</td>
                        <td style="vertical-align:top">${esc(this.nikPemohon)}</td>
                    </tr>
                    <tr>
                        <td style="vertical-align:top">Jabatan / Instansi</td>
                        <td style="vertical-align:top">:</td>
                        <td style="vertical-align:top">${esc(this.jabatanPemohon)}</td>
                    </tr>
                    <tr>
                        <td style="vertical-align:top">Alamat Lengkap</td>
                        <td style="vertical-align:top">:</td>
                        <td style="vertical-align:top">${esc(this.alamatPemohon)}</td>
                    </tr>
                    <tr>
                        <td style="vertical-align:top">No. Telepon / HP</td>
                        <td style="vertical-align:top">:</td>
                        <td style="vertical-align:top">${esc(this.telpPemohon)}</td>
                    </tr>
                </table>

                <p>Dengan ini mengajukan permohonan kepada Bapak/Ibu untuk dapat ${esc(this.rincianPermohonan)}.</p>

                <p>Sebagai bahan pertimbangan dan kelengkapan administrasi, bersama surat ini saya lampirkan dokumen pendukung sebagai berikut:</p>
                <ol style="margin-left:1.5rem; font-size:11pt; line-height:1.6">
                    ${htmlListItems}
                </ol>

                <p style="margin-top:1rem;">Demikian surat permohonan ini saya sampaikan. Besar harapan saya agar Bapak/Ibu berkenan mempertimbangkan dan mengabulkan permohonan ini. Atas perhatian, bantuan, dan kebijaksanaan Bapak/Ibu, saya ucapkan terima kasih.</p>

                <table style="width:100%; margin-top:2rem; font-size:11pt;">
                    <tr>
                        <td style="width:60%"></td>
                        <td style="width:40%; text-align:center; vertical-align:top">
                            Hormat saya,<br>
                            Pemohon,<br><br><br>
                            <div style="display:inline-block; padding:4px 12px; border:1px dashed #666; font-size:10px; margin-bottom:8px;">[ Materai Rp 10.000 ]</div><br>
                            <strong>(${esc(this.namaPemohon)})</strong>
                        </td>
                    </tr>
                </table>
            </body></html>`;

            return html;
        },

        reset() {
            this.nomorSurat = '015/PRM/VIII/2026';
            this.sifat = 'Penting';
            this.lampiran = '1 (satu) Berkas';
            this.tanggalSurat = '12 Agustus 2026';
            this.perihal = 'Permohonan Penerbitan Salinan Dokumen Resmi';
            this.kotaAsal = 'Makassar';
            this.jabatanPenerima = 'Pimpinan Lembaga Layanan Pendidikan';
            this.namaInstansi = 'Kantor Dinas Pendidikan dan Kebudayaan';
            this.alamatInstansi = 'Jl. Jenderal Sudirman No. 88';
            this.kotaTujuan = 'Makassar';
            this.namaPemohon = 'Muhammad Fikri, S.Kom.';
            this.nikPemohon = '3171012308980002';
            this.jabatanPemohon = 'Alumni / Pengurus Yayasan Pendidikan';
            this.alamatPemohon = 'Jl. Anggrek Raya Blok C No. 5';
            this.telpPemohon = '081234567890';
            this.latarBelakang = 'kebutuhan legalisasi arsip penunjang akreditasi program kerja lembaga tahun anggaran berjalan';
            this.rincianPermohonan = 'penerbitan salinan dokumen perizinan pendirian serta legalisasi arsip kelembagaan';
            this.daftarDokumen = [
                'Fotokopi Kartu Tanda Penduduk (KTP) / Identitas Diri',
                'Surat Keterangan Aktif dari Kelurahan',
                'Proposal Kegiatan dan Lembar Pengesahan'
            ];
            
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
            a.download = 'Surat-Permohonan-' + (this.nomorSurat.replace(/[\/\\]/g, '-')) + '.doc';
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