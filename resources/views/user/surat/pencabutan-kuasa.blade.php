@extends('layouts.app')

@section('title', 'Draf Surat Pencabutan Kuasa')
@section('page-subtitle', 'Isi variabel formulir di bawah untuk memperbarui draf surat pencabutan kuasa secara real-time.')

@section('content')
<!-- Print styles and utility for hiding controls when printing -->
<style>
    @media print {
        body * {
            visibility: hidden !important;
        }

        .preview-card-container, .preview-card-container * {
            visibility: visible !important;
        }

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

<div class="space-y-6" x-data="suratPencabutanKuasaForm()">

    <!-- Bagian Form Input Variable -->
    <div class="bg-white dark:bg-gray-800 rounded-3xl border border-gray-100 dark:border-gray-700/80 p-6 sm:p-8 shadow-sm no-print space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-gray-100 dark:border-gray-700 pb-5">
            <div>
                <span class="inline-block px-3 py-1 bg-orange-50 dark:bg-orange-950/50 text-orange-600 dark:text-orange-400 font-extrabold text-[10px] uppercase tracking-wider rounded-full mb-2">Formulir Generator</span>
                <h2 class="text-lg font-black text-gray-900 dark:text-white tracking-tight">Variabel Dokumen Surat Pencabutan Kuasa</h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Ubah nilai di bawah untuk menyesuaikan isi surat pencabutan kuasa secara langsung.</p>
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
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 pt-3">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Nomor Surat Pencabutan</label>
                        <input type="text" x-model="nomorSurat" class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition shadow-xs">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Nomor Surat Kuasa Lama</label>
                        <input type="text" x-model="nomorSuratLama" class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition shadow-xs">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Tanggal Surat Kuasa Lama</label>
                        <input type="text" x-model="tanggalSuratLama" class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition shadow-xs">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Kota & Tanggal Pencabutan</label>
                        <input type="text" x-model="tanggalPencabutan" class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition shadow-xs">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Perihal / Tindakan Kuasa Lama</label>
                        <input type="text" x-model="perihalKuasaLama" class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition shadow-xs">
                    </div>
                </div>
            </fieldset>

            <!-- Pemberi Kuasa -->
            <fieldset class="border border-gray-200 dark:border-gray-700/80 rounded-2xl p-5 bg-gray-50/50 dark:bg-gray-900/30">
                <legend class="px-3 py-1 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-full text-xs font-extrabold uppercase tracking-wider text-orange-600 dark:text-orange-400 shadow-xs">Pemberi Kuasa (Yang Mencabut)</legend>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 pt-3">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Nama Lengkap</label>
                        <input type="text" x-model="namaPemberi" class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition shadow-xs">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">No. KTP / NIK</label>
                        <input type="text" x-model="nikPemberi" class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition shadow-xs">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Pekerjaan</label>
                        <input type="text" x-model="pekerjaanPemberi" class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition shadow-xs">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Alamat Lengkap</label>
                        <input type="text" x-model="alamatPemberi" class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition shadow-xs">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">No. Telepon / HP</label>
                        <input type="text" x-model="telpPemberi" class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition shadow-xs">
                    </div>
                </div>
            </fieldset>

            <!-- Penerima Kuasa -->
            <fieldset class="border border-gray-200 dark:border-gray-700/80 rounded-2xl p-5 bg-gray-50/50 dark:bg-gray-900/30">
                <legend class="px-3 py-1 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-full text-xs font-extrabold uppercase tracking-wider text-orange-600 dark:text-orange-400 shadow-xs">Penerima Kuasa (Yang Dicabut)</legend>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 pt-3">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Nama Lengkap / Advokat</label>
                        <input type="text" x-model="namaPenerima" class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition shadow-xs">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">No. KTP / NIK</label>
                        <input type="text" x-model="nikPenerima" class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition shadow-xs">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Pekerjaan / Profesi</label>
                        <input type="text" x-model="pekerjaanPenerima" class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition shadow-xs">
                    </div>
                    <div class="md:col-span-3">
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Alamat Lengkap Penerima Kuasa</label>
                        <input type="text" x-model="alamatPenerima" class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition shadow-xs">
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
                <span class="text-xs font-extrabold text-gray-800 dark:text-gray-200 uppercase tracking-wider">Pratinjau Dokumen Surat Pencabutan Kuasa (Format HTML)</span>
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
    Alpine.data('suratPencabutanKuasaForm', () => ({
        nomorSurat: '015/SPK-REV/VIII/2026',
        nomorSuratLama: '008/SK/I/2026',
        tanggalSuratLama: '15 Januari 2026',
        tanggalPencabutan: 'Makassar, 12 Agustus 2026',
        perihalKuasaLama: 'pendampingan hukum perkara perdata di Pengadilan Negeri Makassar serta pengurusan dokumen aset',

        namaPemberi: 'H. Abdullah S., S.H.',
        nikPemberi: '7371011505700001',
        pekerjaanPemberi: 'Wiraswasta',
        alamatPemberi: 'Jl. Boulevard Blok F No. 12, Makassar',
        telpPemberi: '0812-3456-7890',

        namaPenerima: 'Advokat M. Yusuf, S.H., M.H.',
        nikPenerima: '7371021005820002',
        pekerjaanPenerima: 'Advokat / Konsultan Hukum',
        alamatPenerima: 'Jl. Ratulangi No. 88, Kota Makassar',

        kontenSuratHtml: '',
        
        init() {
            this.updateSurat();
            
            const fields = [
                'nomorSurat', 'nomorSuratLama', 'tanggalSuratLama', 'tanggalPencabutan', 'perihalKuasaLama',
                'namaPemberi', 'nikPemberi', 'pekerjaanPemberi', 'alamatPemberi', 'telpPemberi',
                'namaPenerima', 'nikPenerima', 'pekerjaanPenerima', 'alamatPenerima'
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
                    h4.pasal { font-size:12pt; margin-top:1rem; margin-bottom:0.25rem; text-align:center }
                    p { text-align:justify; font-size:11pt; line-height:1.6 }
                    ol { margin-left:1.25rem; font-size:11pt; line-height:1.6 }
                </style>`;

            const html = `<!doctype html><html><head><meta charset="utf-8">${styles}</head><body>
                <h4 style="text-align:center">SURAT PENCABUTAN KUASA</h4>
                <div style="text-align:center; margin-bottom:1.5rem"><strong>Nomor:</strong> ${esc(this.nomorSurat)}</div>

                <p>Yang bertanda tangan di bawah ini:</p>
                <table style="width:100%; margin-bottom:1rem; text-align:justify">
                    <tr>
                        <td style="width:150px; vertical-align:top">Nama Lengkap</td>
                        <td style="width:20px; vertical-align:top">:</td>
                        <td>${esc(this.namaPemberi)}</td>
                    </tr>
                    <tr>
                        <td style="vertical-align:top">No. KTP/NIK</td>
                        <td style="vertical-align:top">:</td>
                        <td>${esc(this.nikPemberi)}</td>
                    </tr>
                    <tr>
                        <td style="vertical-align:top">Pekerjaan</td>
                        <td style="vertical-align:top">:</td>
                        <td>${esc(this.pekerjaanPemberi)}</td>
                    </tr>
                    <tr>
                        <td style="vertical-align:top">Alamat Lengkap</td>
                        <td style="vertical-align:top">:</td>
                        <td>${esc(this.alamatPemberi)}</td>
                    </tr>
                    <tr>
                        <td style="vertical-align:top">No. Telepon / HP</td>
                        <td style="vertical-align:top">:</td>
                        <td>${esc(this.telpPemberi)}</td>
                    </tr>
                </table>
                <p>Dalam hal ini bertindak sebagai <strong>PEMBERI KUASA</strong>.</p>

                <p>Dengan ini menyatakan melakukan <strong>PENCABUTAN SURAT KUASA</strong> secara resmi, sehubungan dengan Surat Kuasa Nomor: ${esc(this.nomorSuratLama)} tertanggal ${esc(this.tanggalSuratLama)} yang sebelumnya diberikan kepada:</p>
                <table style="width:100%; margin-bottom:1rem; text-align:justify">
                    <tr>
                        <td style="width:160px; vertical-align:top">Nama Lengkap</td>
                        <td style="width:20px; vertical-align:top">:</td>
                        <td>${esc(this.namaPenerima)}</td>
                    </tr>
                    <tr>
                        <td style="vertical-align:top">No. KTP/NIK</td>
                        <td style="vertical-align:top">:</td>
                        <td>${esc(this.nikPenerima)}</td>
                    </tr>
                    <tr>
                        <td style="vertical-align:top">Pekerjaan / Profesi</td>
                        <td style="vertical-align:top">:</td>
                        <td>${esc(this.pekerjaanPenerima)}</td>
                    </tr>
                    <tr>
                        <td style="vertical-align:top">Alamat Lengkap</td>
                        <td style="vertical-align:top">:</td>
                        <td>${esc(this.alamatPenerima)}</td>
                    </tr>
                </table>
                <p>Selaku <strong>PENERIMA KUASA</strong> untuk melakukan tindakan hukum / administrasi berupa: ${esc(this.perihalKuasaLama)}.</p>

                <p>Terhitung sejak tanggal ditandatanganinya Surat Pencabutan Kuasa ini:</p>
                <ol>
                    <li style="text-align:justify">Surat Kuasa Nomor: ${esc(this.nomorSuratLama)} tertanggal ${esc(this.tanggalSuratLama)} dinyatakan <strong>TIDAK BERLAKU LAGI</strong> dan batal demi hukum.</li>
                    <li style="text-align:justify">PENERIMA KUASA tidak lagi berhak dan dilarang untuk bertindak, mewakili, atau mengatasnamakan PEMBERI KUASA dalam bentuk tindakan hukum atau administratif apa pun.</li>
                    <li style="text-align:justify">Segala tindakan atau perbuatan yang dilakukan oleh PENERIMA KUASA atas nama PEMBERI KUASA sejak tanggal pencabutan ini menjadi tanggung jawab pribadi PENERIMA KUASA sepenuhnya dan berada di luar tanggung jawab PEMBERI KUASA.</li>
                </ol>

                <p style="margin-top:1rem">Demikian Surat Pencabutan Kuasa ini dibuat dengan penuh kesadaran dan tanpa ada paksaan dari pihak mana pun, serta disampaikan kepada pihak-pihak terkait untuk dipergunakan sebagaimana mestinya.</p>

                <br>
                <table style="width:100%; margin-top:2rem; text-align:justify">
                    <tr>
                        <td style="width:50%; vertical-align:top; text-align:center">
                            PEMBERI KUASA<br>
                            (Yang Mencabut Kuasa)<br><br><br>
                            [ Materai Rp 10.000 ]<br><br><br>
                            <strong>(${esc(this.namaPemberi)})</strong>
                        </td>
                        <td style="width:50%; vertical-align:top; text-align:center">
                            ${esc(this.tanggalPencabutan)}<br>
                            PENERIMA KUASA<br>
                            (Yang Menerima Pencabutan)<br><br><br><br><br>
                            <strong>(${esc(this.namaPenerima)})</strong>
                        </td>
                    </tr>
                </table>
            </body></html>`;

            return html;
        },

        reset() {
            this.nomorSurat = '015/SPK-REV/VIII/2026';
            this.nomorSuratLama = '008/SK/I/2026';
            this.tanggalSuratLama = '15 Januari 2026';
            this.tanggalPencabutan = 'Makassar, 12 Agustus 2026';
            this.perihalKuasaLama = 'pendampingan hukum perkara perdata di Pengadilan Negeri Makassar serta pengurusan dokumen aset';
            this.namaPemberi = 'H. Abdullah S., S.H.';
            this.nikPemberi = '7371011505700001';
            this.pekerjaanPemberi = 'Wiraswasta';
            this.alamatPemberi = 'Jl. Boulevard Blok F No. 12, Makassar';
            this.telpPemberi = '0812-3456-7890';
            this.namaPenerima = 'Advokat M. Yusuf, S.H., M.H.';
            this.nikPenerima = '7371021005820002';
            this.pekerjaanPenerima = 'Advokat / Konsultan Hukum';
            this.alamatPenerima = 'Jl. Ratulangi No. 88, Kota Makassar';

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
            a.download = 'Surat-Pencabutan-Kuasa-' + (this.nomorSurat.replace(/[\/\\]/g, '-')) + '.doc';
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