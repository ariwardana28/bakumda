@extends('layouts.admin')

@section('title', 'Draf Surat Pengunduran Diri')
@section('page-subtitle', 'Isi variabel formulir di bawah untuk memperbarui draf surat pengunduran diri secara real-time.')

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

<div class="space-y-6" x-data="suratPengunduranDiriForm()">

    <!-- Bagian Form Input Variable -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700/80 p-6 shadow-sm no-print space-y-5">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-gray-100 dark:border-gray-700 pb-4">
            <div>
                <h2 class="text-base font-bold text-gray-900 dark:text-white">Variabel Dokumen Surat Pengunduran Diri</h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Ubah nilai di bawah untuk menyesuaikan isi surat pengunduran diri secara langsung.</p>
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
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 pt-2">
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Kota Tempat Surat</label><input type="text" x-model="kotaSurat" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Tanggal Surat</label><input type="text" x-model="tanggalSurat" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Tanggal Efektif Berhenti</label><input type="text" x-model="tanggalEfektif" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                </div>
            </fieldset>

            <!-- Penerima / Atasan -->
            <fieldset class="border border-gray-200 dark:border-gray-700 rounded-xl p-4">
                <legend class="px-2 text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">Penerima (Atasan / HRD Manager)</legend>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 pt-2">
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Nama Atasan / HRD Manager</label><input type="text" x-model="namaAtasan" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Jabatan Atasan</label><input type="text" x-model="jabatanAtasan" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Nama Perusahaan / PT</label><input type="text" x-model="namaPerusahaan" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div class="md:col-span-3"><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Alamat Kantor Perusahaan</label><input type="text" x-model="alamatPerusahaan" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                </div>
            </fieldset>

            <!-- Data Karyawan (Pemohon) -->
            <fieldset class="border border-gray-200 dark:border-gray-700 rounded-xl p-4">
                <legend class="px-2 text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">Data Karyawan</legend>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 pt-2">
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Nama Lengkap Karyawan</label><input type="text" x-model="namaKaryawan" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">NIK / NIP Karyawan</label><input type="text" x-model="nikKaryawan" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Jabatan / Posisi</label><input type="text" x-model="jabatanKaryawan" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Departemen / Divisi</label><input type="text" x-model="departemen" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                </div>
            </fieldset>

            <!-- Alasan Pengunduran Diri -->
            <fieldset class="border border-gray-200 dark:border-gray-700 rounded-xl p-4">
                <legend class="px-2 text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">Alasan & Keterangan</legend>
                <div class="grid grid-cols-1 gap-4 pt-2">
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Alasan Singkat Pengunduran Diri</label><textarea x-model="alasanPengunduran" rows="3" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></textarea></div>
                </div>
            </fieldset>
        </div>
    </div>

    <!-- Bagian Textarea Pratinjau & Edit Dokumen -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700/80 p-8 shadow-sm">
        <div class="mb-4 pb-3 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between no-print">
            <span class="text-xs font-bold text-gray-400 uppercase tracking-wider"><i class="fa-solid fa-file-lines mr-1.5"></i> Textarea Pratinjau & Edit Dokumen Surat Pengunduran Diri</span>
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
    Alpine.data('suratPengunduranDiriForm', () => ({
        kotaSurat: 'Makassar',
        tanggalSurat: '12 Agustus 2026',
        tanggalEfektif: '12 September 2026',

        namaAtasan: 'Bapak H. Iskandar, M.B.A.',
        jabatanAtasan: 'HRD Manager',
        namaPerusahaan: 'PT Maharadja Cipta Karya',
        alamatPerusahaan: 'Jl. AP Pettarani No. 45, Makassar',

        namaKaryawan: 'Muhammad Fikri, S.Kom.',
        nikKaryawan: 'KRY/2024/098',
        jabatanKaryawan: 'Software Engineer',
        departemen: 'IT & Software Development',

        alasanPengunduran: 'pertimbangan pengembangan karier serta fokus pada jenjang akademik lanjutan',

        kontenSurat: '',
        
        init() {
            this.updateSurat();
            
            const fields = [
                'kotaSurat', 'tanggalSurat', 'tanggalEfektif',
                'namaAtasan', 'jabatanAtasan', 'namaPerusahaan', 'alamatPerusahaan',
                'namaKaryawan', 'nikKaryawan', 'jabatanKaryawan', 'departemen',
                'alasanPengunduran'
            ];

            fields.forEach(field => {
                this.$watch(field, () => this.updateSurat());
            });
        },

        updateSurat() {
            this.kontenSurat = `Perihal : Pengunduran Diri dari Jabatan ${this.jabatanKaryawan}
Lampiran: -

Kepada Yth.
${this.namaAtasan}
${this.jabatanAtasan}
${this.namaPerusahaan}
${this.alamatPerusahaan}
di -
  Tempat

Dengan hormat,

Bersama surat ini, saya yang bertanda tangan di bawah ini:

Nama Lengkap      : ${this.namaKaryawan}
NIK/NIP Karyawan  : ${this.nikKaryawan}
Jabatan / Posisi  : ${this.jabatanKaryawan}
Departemen / Divisi: ${this.departemen}

Bermaksud untuk mengajukan pengunduran diri dari posisi ${this.jabatanKaryawan} di ${this.namaPerusahaan}, yang efektif terhitung mulai tanggal ${this.tanggalEfektif}.

Keputusan ini saya ambil berdasarkan ${this.alasanPengunduran}. Saya berkomitmen untuk menyelesaikan seluruh tugas dan tanggung jawab yang masih berjalan serta membantu proses pengalihan tugas (handover) kepada karyawan lain sampai batas waktu efektif pengunduran diri saya.

Saya menyampaikan terima kasih yang sebesar-besarnya atas kesempatan, bimbingan, serta pengalaman berharga yang saya dapatkan selama bekerja di ${this.namaPerusahaan}. Saya juga memohon maaf apabila terdapat kesalahan atau kekhilafan selama saya menjalankan tugas di perusahaan ini.

Demikian surat pengunduran diri ini saya sampaikan secara sadar dan tanpa paksaan dari pihak mana pun. Atas perhatian, dukungan, dan kerja sama Bapak/Ibu selama ini, saya ucapkan terima kasih.


${this.kotaSurat}, ${this.tanggalSurat}
Hormat saya,
Pemohon,


[ Materai Rp 10.000 ]


(${this.namaKaryawan})`;
        },

        reset() {
            this.kotaSurat = 'Makassar';
            this.tanggalSurat = '12 Agustus 2026';
            this.tanggalEfektif = '12 September 2026';
            this.namaAtasan = 'Bapak H. Iskandar, M.B.A.';
            this.jabatanAtasan = 'HRD Manager';
            this.namaPerusahaan = 'PT Maharadja Cipta Karya';
            this.alamatPerusahaan = 'Jl. AP Pettarani No. 45, Makassar';
            this.namaKaryawan = 'Muhammad Fikri, S.Kom.';
            this.nikKaryawan = 'KRY/2024/098';
            this.jabatanKaryawan = 'Software Engineer';
            this.departemen = 'IT & Software Development';
            this.alasanPengunduran = 'pertimbangan pengembangan karier serta fokus pada jenjang akademik lanjutan';
            
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
            const styles = `
                <style>
                    @page { size: A4; margin: 24mm }
                    body { font-family: 'Times New Roman', Georgia, serif; color:#111; }
                    p { text-align:justify; font-size:11pt; line-height:1.6 }
                </style>`;

            const html = `<!doctype html><html><head><meta charset="utf-8">${styles}</head><body>
                <table style="width:100%; margin-bottom:1.5rem; font-size:11pt;">
                    <tr>
                        <td style="width:80px; vertical-align:top">Perihal</td>
                        <td style="width:20px; vertical-align:top">:</td>
                        <td style="vertical-align:top"><strong>Pengunduran Diri dari Jabatan ${esc(this.jabatanKaryawan)}</strong></td>
                    </tr>
                    <tr>
                        <td style="vertical-align:top">Lampiran</td>
                        <td style="vertical-align:top">:</td>
                        <td style="vertical-align:top">-</td>
                    </tr>
                </table>

                <div style="margin-bottom:1.5rem; font-size:11pt;">
                    <br>Kepada Yth.<br>
                    <strong>${esc(this.namaAtasan)}</strong><br>
                    ${esc(this.jabatanAtasan)}<br>
                    ${esc(this.namaPerusahaan)}<br>
                    ${esc(this.alamatPerusahaan)}<br>
                    di -<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;<strong>Tempat</strong>
                </div>

                <p>Dengan hormat,</p>
                <p>Bersama surat ini, saya yang bertanda tangan di bawah ini:</p>

                <table style="width:100%; margin-bottom:1rem; margin-left:1rem; font-size:11pt;">
                    <tr>
                        <td style="width:160px; vertical-align:top">Nama Lengkap</td>
                        <td style="width:20px; vertical-align:top">:</td>
                        <td style="vertical-align:top">${esc(this.namaKaryawan)}</td>
                    </tr>
                    <tr>
                        <td style="vertical-align:top">NIK/NIP Karyawan</td>
                        <td style="vertical-align:top">:</td>
                        <td style="vertical-align:top">${esc(this.nikKaryawan)}</td>
                    </tr>
                    <tr>
                        <td style="vertical-align:top">Jabatan / Posisi</td>
                        <td style="vertical-align:top">:</td>
                        <td style="vertical-align:top">${esc(this.jabatanKaryawan)}</td>
                    </tr>
                    <tr>
                        <td style="vertical-align:top">Departemen / Divisi</td>
                        <td style="vertical-align:top">:</td>
                        <td style="vertical-align:top">${esc(this.departemen)}</td>
                    </tr>
                </table>

                <p>Bermaksud untuk mengajukan pengunduran diri dari posisi ${esc(this.jabatanKaryawan)} di ${esc(this.namaPerusahaan)}, yang efektif terhitung mulai tanggal ${esc(this.tanggalEfektif)}.</p>

                <p>Keputusan ini saya ambil berdasarkan ${esc(this.alasanPengunduran)}. Saya berkomitmen untuk menyelesaikan seluruh tugas dan tanggung jawab yang masih berjalan serta membantu proses pengalihan tugas (<em>handover</em>) kepada karyawan lain sampai batas waktu efektif pengunduran diri saya.</p>

                <p>Saya menyampaikan terima kasih yang sebesar-besarnya atas kesempatan, bimbingan, serta pengalaman berharga yang saya dapatkan selama bekerja di ${esc(this.namaPerusahaan)}. Saya juga memohon maaf apabila terdapat kesalahan atau kekhilafan selama saya menjalankan tugas di perusahaan ini.</p>

                <p>Demikian surat pengunduran diri ini saya sampaikan secara sadar dan tanpa paksaan dari pihak mana pun. Atas perhatian, dukungan, dan kerja sama Bapak/Ibu selama ini, saya ucapkan terima kasih.</p>

                <table style="width:100%; margin-top:2rem; font-size:11pt;">
                    <tr>
                        <td style="width:60%"></td>
                        <td style="width:40%; text-align:center; vertical-align:top">
                            ${esc(this.kotaSurat)}, ${esc(this.tanggalSurat)}<br>
                            Hormat saya,<br>
                            Pemohon,<br><br><br>
                            [ Materai Rp 10.000 ]<br><br><br>
                            <strong>(${esc(this.namaKaryawan)})</strong>
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
            const filename = (this.namaKaryawan || 'surat-pengunduran-diri').replace(/[^a-z0-9\-_.]/gi, '_') + '.doc';
            a.download = filename;
            document.body.appendChild(a);
            a.click();
            setTimeout(() => { URL.revokeObjectURL(url); a.remove(); }, 1500);
        }
    }));
});
</script>
@endsection