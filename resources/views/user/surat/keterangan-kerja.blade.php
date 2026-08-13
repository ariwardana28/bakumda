@extends('layouts.app')

@section('title', 'Draf Surat Keterangan Kerja (Paklaring)')
@section('page-subtitle', 'Isi variabel formulir di bawah untuk memperbarui draf surat keterangan kerja secara real-time.')

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

<div class="space-y-6" x-data="suratKeteranganKerjaForm()">

    <!-- Bagian Form Input Variable -->
    <div class="bg-white dark:bg-gray-800 rounded-3xl border border-gray-100 dark:border-gray-700/80 p-6 sm:p-8 shadow-sm no-print space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-gray-100 dark:border-gray-700 pb-5">
            <div>
                <span class="inline-block px-3 py-1 bg-orange-50 dark:bg-orange-950/50 text-orange-600 dark:text-orange-400 font-extrabold text-[10px] uppercase tracking-wider rounded-full mb-2">Formulir Generator</span>
                <h2 class="text-lg font-black text-gray-900 dark:text-white tracking-tight">Variabel Dokumen Surat Keterangan Kerja</h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Ubah nilai di bawah untuk menyesuaikan isi surat keterangan kerja secara langsung.</p>
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
            <!-- Informasi Umum Perusahaan & Surat -->
            <fieldset class="border border-gray-200 dark:border-gray-700/80 rounded-2xl p-5 bg-gray-50/50 dark:bg-gray-900/30">
                <legend class="px-3 py-1 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-full text-xs font-extrabold uppercase tracking-wider text-orange-600 dark:text-orange-400 shadow-xs">Informasi Perusahaan & Surat</legend>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 pt-3">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Nama Perusahaan / PT</label>
                        <input type="text" x-model="namaPerusahaan" class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition shadow-xs">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Nomor Surat</label>
                        <input type="text" x-model="nomorSurat" class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition shadow-xs">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Kota & Tanggal Surat</label>
                        <input type="text" x-model="tanggalSurat" class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition shadow-xs">
                    </div>
                    <div class="md:col-span-3">
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Alamat Lengkap Perusahaan, Telp, Email</label>
                        <input type="text" x-model="alamatPerusahaan" class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition shadow-xs">
                    </div>
                </div>
            </fieldset>

            <!-- Penandatangan (HRD / Pimpinan) -->
            <fieldset class="border border-gray-200 dark:border-gray-700/80 rounded-2xl p-5 bg-gray-50/50 dark:bg-gray-900/30">
                <legend class="px-3 py-1 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-full text-xs font-extrabold uppercase tracking-wider text-orange-600 dark:text-orange-400 shadow-xs">Pejabat Penandatangan</legend>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 pt-3">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Nama Penandatangan</label>
                        <input type="text" x-model="namaPenandatangan" class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition shadow-xs">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">NIK / NIP Penandatangan</label>
                        <input type="text" x-model="nikPenandatangan" class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition shadow-xs">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Jabatan Penandatangan</label>
                        <input type="text" x-model="jabatanPenandatangan" class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition shadow-xs">
                    </div>
                </div>
            </fieldset>

            <!-- Data Karyawan -->
            <fieldset class="border border-gray-200 dark:border-gray-700/80 rounded-2xl p-5 bg-gray-50/50 dark:bg-gray-900/30">
                <legend class="px-3 py-1 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-full text-xs font-extrabold uppercase tracking-wider text-orange-600 dark:text-orange-400 shadow-xs">Data Karyawan</legend>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 pt-3">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Nama Lengkap Karyawan</label>
                        <input type="text" x-model="namaKaryawan" class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition shadow-xs">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">NIK / NIP Karyawan</label>
                        <input type="text" x-model="nikKaryawan" class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition shadow-xs">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Jabatan Terakhir</label>
                        <input type="text" x-model="jabatanKaryawan" class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition shadow-xs">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Departemen / Divisi</label>
                        <input type="text" x-model="departemen" class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition shadow-xs">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Tanggal Mulai Bekerja</label>
                        <input type="text" x-model="tglMulai" class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition shadow-xs">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Tanggal Berhenti Bekerja</label>
                        <input type="text" x-model="tglBerhenti" class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition shadow-xs">
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
                <span class="text-xs font-extrabold text-gray-800 dark:text-gray-200 uppercase tracking-wider">Pratinjau Dokumen Surat Keterangan Kerja (Format HTML)</span>
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
    Alpine.data('suratKeteranganKerjaForm', () => ({
        namaPerusahaan: 'PT Maharadja Cipta Karya',
        nomorSurat: '050/SKK/VIII/2026',
        tanggalSurat: 'Makassar, 12 Agustus 2026',
        alamatPerusahaan: 'Jl. AP Pettarani No. 45, Makassar | Telp. (0411) 123456 | Email: hr@maharadja.co.id',

        namaPenandatangan: 'Bapak H. Iskandar, M.B.A.',
        nikPenandatangan: 'EMP/HRD/2020/001',
        jabatanPenandatangan: 'Human Resources Manager',

        namaKaryawan: 'Muhammad Fikri, S.Kom.',
        nikKaryawan: 'KRY/2024/098',
        jabatanKaryawan: 'Senior Web Developer',
        departemen: 'Information Technology & Software Development',
        tglMulai: '15 September 2024',
        tglBerhenti: '12 Agustus 2026',

        kontenSuratHtml: '',
        
        init() {
            this.updateSurat();
            
            const fields = [
                'namaPerusahaan', 'nomorSurat', 'tanggalSurat', 'alamatPerusahaan',
                'namaPenandatangan', 'nikPenandatangan', 'jabatanPenandatangan',
                'namaKaryawan', 'nikKaryawan', 'jabatanKaryawan', 'departemen', 'tglMulai', 'tglBerhenti'
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
                    p { text-align:justify; font-size:11pt; line-height:1.6 }
                </style>`;

            const html = `<!doctype html><html><head><meta charset="utf-8">${styles}</head><body>
                <div style="text-align:center; margin-bottom:0.5rem">
                    <strong style="font-size:14pt">${esc(this.namaPerusahaan.toUpperCase())}</strong><br>
                    <span style="font-size:9.5pt">${esc(this.alamatPerusahaan)}</span>
                </div>
                <hr style="border:1px solid #111; margin-bottom:1.5rem">

                <h4 style="text-align:center; margin-bottom:0.25rem">SURAT KETERANGAN KERJA</h4>
                <div style="text-align:center; margin-bottom:1.5rem"><strong>Nomor:</strong> ${esc(this.nomorSurat)}</div>

                <p>Yang bertanda tangan di bawah ini:</p>
                <table style="width:100%; margin-bottom:1rem; text-align:justify">
                    <tr>
                        <td style="width:150px; vertical-align:top">Nama Lengkap</td>
                        <td style="width:20px; vertical-align:top">:</td>
                        <td style="vertical-align:top">${esc(this.namaPenandatangan)}</td>
                    </tr>
                    <tr>
                        <td style="vertical-align:top">NIK / NIP</td>
                        <td style="vertical-align:top">:</td>
                        <td style="vertical-align:top">${esc(this.nikPenandatangan)}</td>
                    </tr>
                    <tr>
                        <td style="vertical-align:top">Jabatan</td>
                        <td style="vertical-align:top">:</td>
                        <td style="vertical-align:top">${esc(this.jabatanPenandatangan)}</td>
                    </tr>
                </table>

                <p>Dengan ini menerangkan dengan sesungguhnya bahwa:</p>
                <table style="width:100%; margin-bottom:1rem; text-align:justify">
                    <tr>
                        <td style="width:160px; vertical-align:top">Nama Lengkap</td>
                        <td style="width:20px; vertical-align:top">:</td>
                        <td style="vertical-align:top"><strong>${esc(this.namaKaryawan)}</strong></td>
                    </tr>
                    <tr>
                        <td style="vertical-align:top">NIK / NIP Karyawan</td>
                        <td style="vertical-align:top">:</td>
                        <td style="vertical-align:top">${esc(this.nikKaryawan)}</td>
                    </tr>
                    <tr>
                        <td style="vertical-align:top">Jabatan Terakhir</td>
                        <td style="vertical-align:top">:</td>
                        <td style="vertical-align:top">${esc(this.jabatanKaryawan)}</td>
                    </tr>
                    <tr>
                        <td style="vertical-align:top">Departemen / Divisi</td>
                        <td style="vertical-align:top">:</td>
                        <td style="vertical-align:top">${esc(this.departemen)}</td>
                    </tr>
                </table>

                <p>Adalah benar pernah bekerja dan menjadi karyawan di ${esc(this.namaPerusahaan)} terhitung sejak tanggal <strong>${esc(this.tglMulai)}</strong> sampai dengan tanggal <strong>${esc(this.tglBerhenti)}</strong> dengan jabatan terakhir sebagai ${esc(this.jabatanKaryawan)}.</p>

                <p>Selama masa kerja tersebut, yang bersangkutan telah menunjukkan dedikasi, loyalitas, serta integritas dan kinerja yang baik bagi perkembangan perusahaan. Yang bersangkutan mengundurkan diri secara resmi atas kemauan sendiri.</p>

                <p>Demikian Surat Keterangan Kerja ini diterbitkan untuk dipergunakan sebagaimana mestinya dan memberikan manfaat bagi pihak yang berkepentingan.</p>

                <table style="width:100%; margin-top:2rem; font-size:11pt;">
                    <tr>
                        <td style="width:60%"></td>
                        <td style="width:40%; text-align:center; vertical-align:top">
                            ${esc(this.tanggalSurat)}<br>
                            Hormat kami,<br>
                            ${esc(this.namaPerusahaan)}<br><br><br>
                            <div style="display:inline-block; padding:4px 12px; border:1px dashed #666; font-size:10px; margin-bottom:8px;">[ Stempel Resmi / Cap ]</div><br>
                            <strong>(${esc(this.namaPenandatangan)})</strong><br>
                            ${esc(this.jabatanPenandatangan)}
                        </td>
                    </tr>
                </table>
            </body></html>`;

            return html;
        },

        reset() {
            this.namaPerusahaan = 'PT Maharadja Cipta Karya';
            this.nomorSurat = '050/SKK/VIII/2026';
            this.tanggalSurat = 'Makassar, 12 Agustus 2026';
            this.alamatPerusahaan = 'Jl. AP Pettarani No. 45, Makassar | Telp. (0411) 123456 | Email: hr@maharadja.co.id';
            this.namaPenandatangan = 'Bapak H. Iskandar, M.B.A.';
            this.nikPenandatangan = 'EMP/HRD/2020/001';
            this.jabatanPenandatangan = 'Human Resources Manager';
            this.namaKaryawan = 'Muhammad Fikri, S.Kom.';
            this.nikKaryawan = 'KRY/2024/098';
            this.jabatanKaryawan = 'Senior Web Developer';
            this.departemen = 'Information Technology & Software Development';
            this.tglMulai = '15 September 2024';
            this.tglBerhenti = '12 Agustus 2026';
            
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
            a.download = 'Surat-Keterangan-Kerja-' + (this.namaKaryawan.replace(/[\/\\]/g, '-')) + '.doc';
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