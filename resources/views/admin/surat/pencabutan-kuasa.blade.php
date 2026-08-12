@extends('layouts.admin')

@section('title', 'Draf Surat Pencabutan Kuasa')
@section('page-subtitle', 'Isi variabel formulir di bawah untuk memperbarui draf surat pencabutan kuasa secara real-time.')

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

<div class="space-y-6" x-data="suratPencabutanKuasaForm()">

    <!-- Bagian Form Input Variable -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700/80 p-6 shadow-sm no-print space-y-5">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-gray-100 dark:border-gray-700 pb-4">
            <div>
                <h2 class="text-base font-bold text-gray-900 dark:text-white">Variabel Dokumen Surat Pencabutan Kuasa</h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Ubah nilai di bawah untuk menyesuaikan isi surat pencabutan kuasa secara langsung.</p>
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
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Nomor Surat Pencabutan</label><input type="text" x-model="nomorSurat" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Nomor Surat Kuasa Lama</label><input type="text" x-model="nomorSuratLama" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Tanggal Surat Kuasa Lama</label><input type="text" x-model="tanggalSuratLama" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Kota & Tanggal Pencabutan</label><input type="text" x-model="tanggalPencabutan" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div class="md:col-span-2"><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Perihal / Tindakan Kuasa Lama</label><input type="text" x-model="perihalKuasaLama" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                </div>
            </fieldset>

            <!-- Pemberi Kuasa -->
            <fieldset class="border border-gray-200 dark:border-gray-700 rounded-xl p-4">
                <legend class="px-2 text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">Pemberi Kuasa (Yang Mencabut)</legend>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 pt-2">
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Nama Lengkap</label><input type="text" x-model="namaPemberi" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">No. KTP / NIK</label><input type="text" x-model="nikPemberi" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Pekerjaan</label><input type="text" x-model="pekerjaanPemberi" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div class="md:col-span-2"><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Alamat Lengkap</label><input type="text" x-model="alamatPemberi" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">No. Telepon / HP</label><input type="text" x-model="telpPemberi" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                </div>
            </fieldset>

            <!-- Penerima Kuasa -->
            <fieldset class="border border-gray-200 dark:border-gray-700 rounded-xl p-4">
                <legend class="px-2 text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">Penerima Kuasa (Yang Dicabut)</legend>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 pt-2">
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Nama Lengkap / Advokat</label><input type="text" x-model="namaPenerima" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">No. KTP / NIK</label><input type="text" x-model="nikPenerima" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Pekerjaan / Profesi</label><input type="text" x-model="pekerjaanPenerima" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div class="md:col-span-3"><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Alamat Lengkap Penerima Kuasa</label><input type="text" x-model="alamatPenerima" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                </div>
            </fieldset>
        </div>
    </div>

    <!-- Bagian Textarea Pratinjau & Edit Dokumen -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700/80 p-8 shadow-sm">
        <div class="mb-4 pb-3 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between no-print">
            <span class="text-xs font-bold text-gray-400 uppercase tracking-wider"><i class="fa-solid fa-file-lines mr-1.5"></i> Textarea Pratinjau & Edit Dokumen Surat Pencabutan Kuasa</span>
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

        kontenSurat: '',
        
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

        updateSurat() {
            this.kontenSurat = `SURAT PENCABUTAN KUASA
Nomor: ${this.nomorSurat}

Yang bertanda tangan di bawah ini:

Nama Lengkap      : ${this.namaPemberi}
No. KTP/NIK       : ${this.nikPemberi}
Pekerjaan         : ${this.pekerjaanPemberi}
Alamat Lengkap    : ${this.alamatPemberi}
No. Telepon / HP  : ${this.telpPemberi}

Dalam hal ini bertindak sebagai PEMBERI KUASA.

Dengan ini menyatakan melakukan PENCABUTAN SURAT KUASA secara resmi, sehubungan dengan Surat Kuasa Nomor: ${this.nomorSuratLama} tertanggal ${this.tanggalSuratLama} yang sebelumnya diberikan kepada:

Nama Lengkap      : ${this.namaPenerima}
No. KTP/NIK       : ${this.nikPenerima}
Pekerjaan / Profesi: ${this.pekerjaanPenerima}
Alamat Lengkap    : ${this.alamatPenerima}

Selaku PENERIMA KUASA untuk melakukan tindakan hukum / administrasi berupa: ${this.perihalKuasaLama}.

Terhitung sejak tanggal ditandatanganinya Surat Pencabutan Kuasa ini (12 Agustus 2026):
1. Surat Kuasa Nomor: ${this.nomorSuratLama} tertanggal ${this.tanggalSuratLama} dinyatakan TIDAK BERLAKU LAGI dan batal demi hukum.
2. PENERIMA KUASA tidak lagi berhak dan dilarang untuk bertindak, mewakili, atau mengatasnamakan PEMBERI KUASA dalam bentuk tindakan hukum atau administratif apa pun.
3. Segala tindakan atau perbuatan yang dilakukan oleh PENERIMA KUASA atas nama PEMBERI KUASA sejak tanggal pencabutan ini menjadi tanggung jawab pribadi PENERIMA KUASA sepenuhnya dan berada di luar tanggung jawab PEMBERI KUASA.

Demikian Surat Pencabutan Kuasa ini dibuat dengan penuh kesadaran dan tanpa ada paksaan dari pihak mana pun, serta disampaikan kepada pihak-pihak terkait untuk dipergunakan sebagaimana mestinya.


${this.tanggalPencabutan}


PEMBERI KUASA                         PENERIMA KUASA
(Yang Mencabut Kuasa)                 (Yang Menerima Pencabutan)


[ Materai Rp 10.000 ]


(${this.namaPemberi})                 (${this.namaPenerima})`;
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

                <p>Terhitung sejak tanggal ditandatanganinya Surat Pencabutan Kuasa ini (12 Agustus 2026):</p>
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

        exportWord() {
            const htmlContent = this.buildHtmlDocument();
            const blob = new Blob(['\ufeff', htmlContent], { type: 'application/msword' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            const filename = (this.nomorSurat || 'surat-pencabutan-kuasa').replace(/[^a-z0-9\-_.]/gi, '_') + '.doc';
            a.download = filename;
            document.body.appendChild(a);
            a.click();
            setTimeout(() => { URL.revokeObjectURL(url); a.remove(); }, 1500);
        }
    }));
});
</script>
@endsection