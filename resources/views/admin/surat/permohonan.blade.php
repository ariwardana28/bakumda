@extends('layouts.admin')

@section('title', 'Draf Surat Permohonan Umum')
@section('page-subtitle', 'Isi variabel formulir di bawah untuk memperbarui draf surat permohonan secara real-time.')

@section('content')
<!-- Print styles and utility for hiding controls when printing -->
<style>
    @media print {
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
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700/80 p-6 shadow-sm no-print space-y-5">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-gray-100 dark:border-gray-700 pb-4">
            <div>
                <h2 class="text-base font-bold text-gray-900 dark:text-white">Variabel Dokumen Surat Permohonan</h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Ubah nilai di bawah untuk menyesuaikan isi surat permohonan secara langsung.</p>
            </div>
            <div class="flex flex-wrap items-center gap-2">
                <button @click="copyPreview()" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-sky-50 dark:bg-sky-950/50 hover:bg-sky-100 text-sky-600 dark:text-sky-400 text-xs font-bold uppercase tracking-wider transition-colors shadow-xs">
                    <i class="fa-solid fa-copy text-xs"></i> Salin Teks
                </button>
                <button @click="reset()" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 text-xs font-bold uppercase tracking-wider transition-colors shadow-xs">
                    <i class="fa-solid fa-rotate-left text-xs"></i> Reset
                </button>
                <button @click="exportPDF()" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-700 text-xs font-bold uppercase tracking-wider transition-colors shadow-xs">
                    <i class="fa-solid fa-file-pdf text-xs"></i> Export PDF
                </button>
                <button @click="exportWord()" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-indigo-50 hover:bg-indigo-100 text-indigo-700 text-xs font-bold uppercase tracking-wider transition-colors shadow-xs">
                    <i class="fa-solid fa-file-word text-xs"></i> Export Word
                </button>
                <button onclick="window.print()" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-amber-500 hover:bg-amber-600 text-slate-950 text-xs font-bold uppercase tracking-wider transition-colors shadow-sm">
                    <i class="fa-solid fa-print text-xs"></i> Cetak PDF
                </button>
            </div>
        </div>

        <div class="space-y-5">
            <!-- Informasi Umum Surat -->
            <fieldset class="border border-gray-200 dark:border-gray-700 rounded-xl p-4">
                <legend class="px-2 text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">Informasi Umum Surat</legend>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 pt-2">
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Nomor Surat</label><input type="text" x-model="nomorSurat" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Sifat</label><input type="text" x-model="sifat" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Lampiran</label><input type="text" x-model="lampiran" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Tanggal Surat</label><input type="text" x-model="tanggalSurat" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div class="md:col-span-2"><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Perihal Permohonan</label><input type="text" x-model="perihal" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Kota / Tempat Asal</label><input type="text" x-model="kotaAsal" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                </div>
            </fieldset>

            <!-- Penerima Surat -->
            <fieldset class="border border-gray-200 dark:border-gray-700 rounded-xl p-4">
                <legend class="px-2 text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">Penerima Surat (Tujuan)</legend>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 pt-2">
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Jabatan Penerima</label><input type="text" x-model="jabatanPenerima" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Nama Instansi / Perusahaan</label><input type="text" x-model="namaInstansi" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Kota / Tempat Tujuan</label><input type="text" x-model="kotaTujuan" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div class="md:col-span-3"><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Alamat Lengkap Instansi</label><input type="text" x-model="alamatInstansi" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                </div>
            </fieldset>

            <!-- Data Pemohon -->
            <fieldset class="border border-gray-200 dark:border-gray-700 rounded-xl p-4">
                <legend class="px-2 text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">Data Pemohon</legend>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 pt-2">
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Nama Lengkap Pemohon</label><input type="text" x-model="namaPemohon" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">NIK / NIP / NIM</label><input type="text" x-model="nikPemohon" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Jabatan / Status Pemohon</label><input type="text" x-model="jabatanPemohon" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div class="md:col-span-2"><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Alamat Lengkap Pemohon</label><input type="text" x-model="alamatPemohon" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">No. Telepon / HP</label><input type="text" x-model="telpPemohon" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                </div>
            </fieldset>

            <!-- Isi & Substansi Permohonan -->
            <fieldset class="border border-gray-200 dark:border-gray-700 rounded-xl p-4">
                <legend class="px-2 text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">Substansi & Latar Belakang</legend>
                <div class="grid grid-cols-1 gap-4 pt-2">
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Latar Belakang / Alasan Permohonan</label><textarea x-model="latarBelakang" rows="2" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></textarea></div>
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Rincian Permohonan Secara Spesifik</label><textarea x-model="rincianPermohonan" rows="2" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></textarea></div>
                    
                    <!-- Dinamis Dokumen Pendukung -->
                    <div class="space-y-3 pt-2">
                        <div class="flex items-center justify-between">
                            <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 dark:text-gray-300">Daftar Dokumen Pendukung</label>
                            <button type="button" @click="tambahDokumen()" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-brand-50 dark:bg-brand-950/50 hover:bg-brand-100 text-brand-600 dark:text-brand-400 text-xs font-bold transition-colors">
                                <i class="fa-solid fa-plus text-xs"></i> Tambah Dokumen
                            </button>
                        </div>
                        <template x-for="(doc, index) in daftarDokumen" :key="index">
                            <div class="flex items-center gap-2">
                                <span class="text-xs font-medium text-gray-500 w-6 text-right" x-text="(index + 1) + '.'"></span>
                                <input type="text" x-model="daftarDokumen[index]" @input="updateSurat()" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition" placeholder="Nama dokumen pendukung...">
                                <button type="button" @click="hapusDokumen(index)" class="p-2 text-red-500 hover:text-red-700 rounded-lg hover:bg-red-50 dark:hover:bg-red-950/30 transition-colors" title="Hapus Dokumen">
                                    <i class="fa-solid fa-trash text-xs"></i>
                                </button>
                            </div>
                        </template>
                    </div>
                </div>
            </fieldset>
        </div>
    </div>

    <!-- Bagian Textarea Pratinjau & Edit Dokumen -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700/80 p-8 shadow-sm">
        <div class="mb-4 pb-3 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between no-print">
            <span class="text-xs font-bold text-gray-400 uppercase tracking-wider"><i class="fa-solid fa-file-lines mr-1.5"></i> Textarea Pratinjau & Edit Dokumen Surat Permohonan</span>
            <span class="text-[11px] text-emerald-600 dark:text-emerald-400 font-semibold bg-emerald-50 dark:bg-emerald-950/50 px-2.5 py-1 rounded-lg border border-emerald-200/50">Sinkronisasi & Edit Manual Aktif</span>
        </div>

        <textarea x-ref="preview" 
            x-model="kontenSurat"
            rows="24"
            class="preview-card w-full bg-slate-900 text-slate-100 dark:bg-gray-950 dark:text-gray-100 rounded-xl p-6 font-mono text-sm leading-relaxed shadow-inner border border-gray-700 focus:ring-2 focus:ring-brand-500 outline-none resize-y transition"></textarea>
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

        kontenSurat: '',
        
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

        updateSurat() {
            let listDokumenText = '';
            this.daftarDokumen.forEach((doc, idx) => {
                listDokumenText += `${idx + 1}. ${doc};\n`;
            });

            this.kontenSurat = `Nomor       : ${this.nomorSurat}
Sifat       : ${this.sifat}
Lampiran    : ${this.lampiran}
Perihal     : ${this.perihal}

${this.kotaAsal}, ${this.tanggalSurat}

Kepada Yth.
${this.jabatanPenerima}
${this.namaInstansi}
${this.alamatInstansi}
di -
  ${this.kotaTujuan}

Dengan hormat,

Sehubungan dengan ${this.latarBelakang}, maka saya yang bertanda tangan di bawah ini:

Nama Lengkap      : ${this.namaPemohon}
NIK/NIP/NIM       : ${this.nikPemohon}
Jabatan / Instansi: ${this.jabatanPemohon}
Alamat Lengkap    : ${this.alamatPemohon}
No. Telepon / HP  : ${this.telpPemohon}

Dengan ini mengajukan permohonan kepada Bapak/Ibu untuk dapat ${this.rincianPermohonan}.

Sebagai bahan pertimbangan dan kelengkapan administrasi, bersama surat ini saya lampirkan dokumen pendukung sebagai berikut:
${listDokumenText.trim()}

Demikian surat permohonan ini saya sampaikan. Besar harapan saya agar Bapak/Ibu berkenan mempertimbangkan dan mengabulkan permohonan ini. Atas perhatian, bantuan, dan kebijaksanaan Bapak/Ibu, saya ucapkan terima kasih.


Hormat saya,
Pemohon,


[ Materai Rp 10.000 ]


(${this.namaPemohon})`;
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
                navigator.clipboard.writeText(this.$refs.preview.value);
                alert('Teks dokumen berhasil disalin ke clipboard!');
            } catch (e) {
                alert('Tidak dapat menyalin: ' + e.message);
            }
        },

        escapeHtml(text) {
            if (!text) return '';
            return text
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/\"/g, '&quot;')
                .replace(/\'/g, '&#39;')
                .replace(/\n/g, '<br>');
        },

        exportPDF() {
            const content = this.$refs.preview.value || '';
            const printWindow = window.open('', '_blank');
            const styles = `
                <style>
                    body{font-family: Arial, Helvetica, sans-serif; padding:24px; color:#000}
                    pre{white-space:pre-wrap; font-family:inherit; font-size:12pt}
                </style>`;
            const html = `<html><head><meta charset="utf-8">${styles}</head><body><pre>${this.escapeHtml(content)}</pre></body></html>`;
            printWindow.document.open();
            printWindow.document.write(html);
            printWindow.document.close();
            printWindow.onload = function() {
                printWindow.focus();
                printWindow.print();
            };
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
                    body { font-family: 'Times New Roman', Georgia, serif; color:#111; }
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
                        <td style="vertical-align:top">${esc(this.namaPemohon)}</td>
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
                            [ Materai Rp 10.000 ]<br><br><br>
                            <strong>(${esc(this.namaPemohon)})</strong>
                        </td>
                    </tr>
                </table>
            </body></html>`;

            return html;
        },

        exportWord() {
            const htmlContent = this.buildHtmlDocument();
            const blob = new Blob(['\ufeff', htmlContent], { type: 'application/msword' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            const filename = (this.nomorSurat || 'surat-permohonan').replace(/[^a-z0-9\-_.]/gi, '_') + '.doc';
            a.download = filename;
            document.body.appendChild(a);
            a.click();
            setTimeout(() => { URL.revokeObjectURL(url); a.remove(); }, 1500);
        }
    }));
});
</script>
@endsection