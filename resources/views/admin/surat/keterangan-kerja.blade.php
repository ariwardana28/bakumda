@extends('layouts.admin')

@section('title', 'Draf Surat Keterangan Kerja (Paklaring)')
@section('page-subtitle', 'Isi variabel formulir di bawah untuk memperbarui draf surat keterangan kerja secara real-time.')

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

<div class="space-y-6" x-data="suratKeteranganKerjaForm()">

    <!-- Bagian Form Input Variable -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700/80 p-6 shadow-sm no-print space-y-5">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-gray-100 dark:border-gray-700 pb-4">
            <div>
                <h2 class="text-base font-bold text-gray-900 dark:text-white">Variabel Dokumen Surat Keterangan Kerja</h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Ubah nilai di bawah untuk menyesuaikan isi surat keterangan kerja secara langsung.</p>
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
            <!-- Informasi Umum Perusahaan & Surat -->
            <fieldset class="border border-gray-200 dark:border-gray-700 rounded-xl p-4">
                <legend class="px-2 text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">Informasi Perusahaan & Surat</legend>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 pt-2">
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Nama Perusahaan / PT</label><input type="text" x-model="namaPerusahaan" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Nomor Surat</label><input type="text" x-model="nomorSurat" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Kota & Tanggal Surat</label><input type="text" x-model="tanggalSurat" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div class="md:col-span-3"><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Alamat Lengkap Perusahaan, Telp, Email</label><input type="text" x-model="alamatPerusahaan" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                </div>
            </fieldset>

            <!-- Penandatangan (HRD / Pimpinan) -->
            <fieldset class="border border-gray-200 dark:border-gray-700 rounded-xl p-4">
                <legend class="px-2 text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">Pejabat Penandatangan</legend>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 pt-2">
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Nama Penandatangan</label><input type="text" x-model="namaPenandatangan" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">NIK / NIP Penandatangan</label><input type="text" x-model="nikPenandatangan" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Jabatan Penandatangan</label><input type="text" x-model="jabatanPenandatangan" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                </div>
            </fieldset>

            <!-- Data Karyawan -->
            <fieldset class="border border-gray-200 dark:border-gray-700 rounded-xl p-4">
                <legend class="px-2 text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">Data Karyawan</legend>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 pt-2">
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Nama Lengkap Karyawan</label><input type="text" x-model="namaKaryawan" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">NIK / NIP Karyawan</label><input type="text" x-model="nikKaryawan" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Jabatan Terakhir</label><input type="text" x-model="jabatanKaryawan" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Departemen / Divisi</label><input type="text" x-model="departemen" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Tanggal Mulai Bekerja</label><input type="text" x-model="tglMulai" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Tanggal Berhenti Bekerja</label><input type="text" x-model="tglBerhenti" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                </div>
            </fieldset>
        </div>
    </div>

    <!-- Bagian Textarea Pratinjau & Edit Dokumen -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700/80 p-8 shadow-sm">
        <div class="mb-4 pb-3 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between no-print">
            <span class="text-xs font-bold text-gray-400 uppercase tracking-wider"><i class="fa-solid fa-file-lines mr-1.5"></i> Textarea Pratinjau & Edit Dokumen Surat Keterangan Kerja</span>
            <span class="text-[11px] text-emerald-600 dark:text-emerald-400 font-semibold bg-emerald-50 dark:bg-emerald-950/50 px-2.5 py-1 rounded-lg border border-emerald-200/50">Sinkronisasi & Edit Manual Aktif</span>
        </div>

        <textarea x-ref="preview" 
            x-model="kontenSurat"
            rows="22"
            class="preview-card w-full bg-slate-900 text-slate-100 dark:bg-gray-950 dark:text-gray-100 rounded-xl p-6 font-mono text-sm leading-relaxed shadow-inner border border-gray-700 focus:ring-2 focus:ring-brand-500 outline-none resize-y transition"></textarea>
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

        kontenSurat: '',
        
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

        updateSurat() {
            this.kontenSurat = `${this.namaPerusahaan.toUpperCase()}
${this.alamatPerusahaan}

SURAT KETERANGAN KERJA
Nomor: ${this.nomorSurat}

Yang bertanda tangan di bawah ini:

Nama Lengkap      : ${this.namaPenandatangan}
NIK / NIP         : ${this.nikPenandatangan}
Jabatan           : ${this.jabatanPenandatangan}

Dengan ini menerangkan dengan sesungguhnya bahwa:

Nama Lengkap      : ${this.namaKaryawan}
NIK / NIP Karyawan: ${this.nikKaryawan}
Jabatan Terakhir  : ${this.jabatanKaryawan}
Departemen / Divisi: ${this.departemen}

Adalah benar pernah bekerja dan menjadi karyawan di ${this.namaPerusahaan} terhitung sejak tanggal ${this.tglMulai} sampai dengan tanggal ${this.tglBerhenti} dengan jabatan terakhir sebagai ${this.jabatanKaryawan}.

Selama masa kerja tersebut, yang bersangkutan telah menunjukkan dedikasi, loyalitas, serta integritas dan kinerja yang baik bagi perkembangan perusahaan. Yang bersangkutan mengundurkan diri secara resmi atas kemauan sendiri.

Demikian Surat Keterangan Kerja ini diterbitkan untuk dipergunakan sebagaimana mestinya dan memberikan manfaat bagi pihak yang berkepentingan.


${this.tanggalSurat}
Hormat kami,
${this.namaPerusahaan}



[ Tanda Tangan & Cap Perusahaan ]
[ Stempel Resmi ]



(${this.namaPenandatangan})
${this.jabatanPenandatangan}`;
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
                        <td>${esc(this.namaPenandatangan)}</td>
                    </tr>
                    <tr>
                        <td style="vertical-align:top">NIK / NIP</td>
                        <td style="vertical-align:top">:</td>
                        <td>${esc(this.nikPenandatangan)}</td>
                    </tr>
                    <tr>
                        <td style="vertical-align:top">Jabatan</td>
                        <td style="vertical-align:top">:</td>
                        <td>${esc(this.jabatanPenandatangan)}</td>
                    </tr>
                </table>

                <p>Dengan ini menerangkan dengan sesungguhnya bahwa:</p>
                <table style="width:100%; margin-bottom:1rem; text-align:justify">
                    <tr>
                        <td style="width:160px; vertical-align:top">Nama Lengkap</td>
                        <td style="width:20px; vertical-align:top">:</td>
                        <td><strong>${esc(this.namaKaryawan)}</strong></td>
                    </tr>
                    <tr>
                        <td style="vertical-align:top">NIK / NIP Karyawan</td>
                        <td style="vertical-align:top">:</td>
                        <td>${esc(this.nikKaryawan)}</td>
                    </tr>
                    <tr>
                        <td style="vertical-align:top">Jabatan Terakhir</td>
                        <td style="vertical-align:top">:</td>
                        <td>${esc(this.jabatanKaryawan)}</td>
                    </tr>
                    <tr>
                        <td style="vertical-align:top">Departemen / Divisi</td>
                        <td style="vertical-align:top">:</td>
                        <td>${esc(this.departemen)}</td>
                    </tr>
                </table>

                <p>Adalah benar pernah bekerja dan menjadi karyawan di ${esc(this.namaPerusahaan)} terhitung sejak tanggal ${esc(this.tglMulai)} sampai dengan tanggal ${esc(this.tglBerhenti)} dengan jabatan terakhir sebagai ${esc(this.jabatanKaryawan)}.</p>

                <p>Selama masa kerja tersebut, yang bersangkutan telah menunjukkan dedikasi, loyalitas, serta integritas dan kinerja yang baik bagi perkembangan perusahaan. Yang bersangkutan mengundurkan diri secara resmi atas kemauan sendiri.</p>

                <p>Demikian Surat Keterangan Kerja ini diterbitkan untuk dipergunakan sebagaimana mestinya dan memberikan manfaat bagi pihak yang berkepentingan.</p>

                <table style="width:100%; margin-top:2rem; font-size:11pt;">
                    <tr>
                        <td style="width:60%"></td>
                        <td style="width:40%; text-align:center; vertical-align:top">
                            ${esc(this.tanggalSurat)}<br>
                            Hormat kami,<br>
                            ${esc(this.namaPerusahaan)}<br><br><br>
                            [ Tanda Tangan & Cap Perusahaan ]<br>
                            <em>Stempel Resmi</em><br><br><br>
                            <strong>(${esc(this.namaPenandatangan)})</strong><br>
                            ${esc(this.jabatanPenandatangan)}
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
            const filename = (this.namaKaryawan || 'surat-keterangan-kerja').replace(/[^a-z0-9\-_.]/gi, '_') + '.doc';
            a.download = filename;
            document.body.appendChild(a);
            a.click();
            setTimeout(() => { URL.revokeObjectURL(url); a.remove(); }, 1500);
        }
    }));
});
</script>
@endsection