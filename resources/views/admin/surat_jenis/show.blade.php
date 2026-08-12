@extends('layouts.admin')

@section('title', 'Draf Perjanjian Kerja Waktu Tertentu (PKWT)')
@section('page-subtitle', 'Isi variabel formulir di bawah untuk memperbarui draf dokumen secara real-time.')

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

<div class="space-y-6" x-data="pkwtForm()">

    <!-- Bagian Form Input Variable -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700/80 p-6 shadow-sm no-print space-y-5">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-gray-100 dark:border-gray-700 pb-4">
            <div>
                <h2 class="text-base font-bold text-gray-900 dark:text-white">Variabel Dokumen PKWT Lengkap</h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Ubah nilai di bawah untuk menyesuaikan isi surat perjanjian secara langsung.</p>
            </div>
            <div class="flex items-center gap-2">
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
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Hari TTD</label><input type="text" x-model="hariTtd" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Tanggal TTD</label><input type="text" x-model="tanggalTtd" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Kota TTD</label><input type="text" x-model="kotaTtd" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                </div>
            </fieldset>

            <!-- Pihak Pertama (Perusahaan) -->
            <fieldset class="border border-gray-200 dark:border-gray-700 rounded-xl p-4">
                <legend class="px-2 text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">Pihak Pertama (Perusahaan)</legend>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-2">
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Nama Perusahaan</label><input type="text" x-model="namaPerusahaan" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Alamat Perusahaan</label><input type="text" x-model="alamatPerusahaan" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Diwakili Oleh</label><input type="text" x-model="diwakiliOleh" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Jabatan Perwakilan</label><input type="text" x-model="jabatanPerusahaan" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div class="md:col-span-2"><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Bidang Usaha</label><input type="text" x-model="bidangUsaha" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                </div>
            </fieldset>

            <!-- Pihak Kedua (Karyawan) -->
            <fieldset class="border border-gray-200 dark:border-gray-700 rounded-xl p-4">
                <legend class="px-2 text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">Pihak Kedua (Karyawan)</legend>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-2">
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Nama Karyawan</label><input type="text" x-model="namaKaryawan" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">NIK Karyawan</label><input type="text" x-model="nikKaryawan" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Tempat, Tgl Lahir</label><input type="text" x-model="tempatTglLahir" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">No. HP Karyawan</label><input type="text" x-model="noHpKaryawan" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div class="md:col-span-2"><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Alamat Domisili</label><input type="text" x-model="alamatDomisili" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                </div>
            </fieldset>

            <!-- Detail Perjanjian -->
            <fieldset class="border border-gray-200 dark:border-gray-700 rounded-xl p-4">
                <legend class="px-2 text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">Detail Perjanjian</legend>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 pt-2">
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Nama Jabatan</label><input type="text" x-model="namaJabatan" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Nama Departemen</label><input type="text" x-model="namaDepartemen" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Lokasi Kantor</label><input type="text" x-model="lokasiKantor" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Masa Kontrak</label><input type="text" x-model="masaKontrak" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Tanggal Mulai</label><input type="text" x-model="tglMulai" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Tanggal Selesai</label><input type="text" x-model="tglSelesai" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                </div>
            </fieldset>

            <!-- Informasi Gaji & Pembayaran -->
            <fieldset class="border border-gray-200 dark:border-gray-700 rounded-xl p-4">
                <legend class="px-2 text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">Informasi Gaji & Pembayaran</legend>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 pt-2">
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Gaji Pokok (Rp)</label><input type="text" x-model="gajiPokok" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Nama Bank</label><input type="text" x-model="namaBank" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Nomor Rekening</label><input type="text" x-model="noRekening" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus;border-brand-500 outline-none transition"></div>
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Atas Nama Rekening</label><input type="text" x-model="atasNamaRek" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                </div>
            </fieldset>
        </div>
    </div>

    <!-- Bagian Textarea Pratinjau & Edit Dokumen -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700/80 p-8 shadow-sm">
        <div class="mb-4 pb-3 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between no-print">
            <span class="text-xs font-bold text-gray-400 uppercase tracking-wider"><i class="fa-solid fa-file-lines mr-1.5"></i> Textarea Pratinjau & Edit Dokumen PKWT</span>
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
        kontenSurat: '',
        
        init() {
            // Merge initial data if available from backend
            const initial = JSON.parse(@json(json_encode($initialData ?? [])));
            for (const key in initial) {
                if (this.hasOwnProperty(key)) {
                    this[key] = initial[key];
                }
            }

            this.updateSurat();
            
            // Watch all properties to update textarea in real-time
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

        updateSurat() {
            // Plain-text preview formatted for readability in textarea
            this.kontenSurat = `SURAT PERJANJIAN KERJA WAKTU TERTENTU (PKWT)\nNomor: ${this.nomorSurat}\n\nPada hari ini, ${this.hariTtd} tanggal ${this.tanggalTtd}, bertempat di ${this.kotaTtd}, yang bertanda tangan di bawah ini:\n\nNama Perusahaan       : ${this.namaPerusahaan}\nAlamat Perusahaan     : ${this.alamatPerusahaan}\nDiwakili Oleh         : ${this.diwakiliOleh}\nJabatan               : ${this.jabatanPerusahaan}\nDalam hal ini bertindak untuk dan atas nama ${this.namaPerusahaan}, yang selanjutnya disebut sebagai PIHAK PERTAMA (PENGUSAHA).\n\nNama Lengkap          : ${this.namaKaryawan}\nNo. KTP / NIK         : ${this.nikKaryawan}\nTempat, Tgl Lahir     : ${this.tempatTglLahir}\nAlamat Domisili       : ${this.alamatDomisili}\nNo. Telepon / HP      : ${this.noHpKaryawan}\nDalam hal ini bertindak untuk dan atas nama diri sendiri, yang selanjutnya disebut sebagai PIHAK KEDUA (PEKERJA).\n\nPARA PIHAK menerangkan hal-hal sebagai berikut:\n1. PIHAK PERTAMA bergerak di bidang: ${this.bidangUsaha}.\n2. PIHAK KEDUA menyatakan memiliki kualifikasi dan kapasitas yang memadai untuk melaksanakan pekerjaan.\n3. Para Pihak sepakat membuat Perjanjian Kerja Waktu Tertentu (PKWT) sesuai peraturan perundang-undangan.\n\nPASAL 1\nJABATAN, PENEMPATAN, DAN URAIAN TUGAS\n1. PIHAK PERTAMA menerima PIHAK KEDUA sebagai: ${this.namaJabatan}.\n2. Penempatan: ${this.namaDepartemen} — ${this.lokasiKantor}.\n3. Uraian tugas utama:\n   - Mengembangkan, menguji, dan memelihara aplikasi/sistem perangkat lunak perusahaan.\n   - Melakukan koordinasi teknis dan integrasi database secara berkala.\n   - Menyusun laporan berkala pelaksanaan pekerjaan kepada atasan langsung.\n   - Melaksanakan tugas dinas lain sesuai kompetensi.\n\nPASAL 2\nJANGKA WAKTU PERJANJIAN\n1. Jangka waktu: ${this.masaKontrak}, terhitung sejak ${this.tglMulai} sampai ${this.tglSelesai}.\n2. PKWT ini tidak mensyaratkan masa percobaan (probation).\n3. Setelah berakhir, hubungan kerja putus demi hukum.\n4. Perpanjangan hanya atas kesepakatan tertulis, paling lambat 30 hari sebelum berakhir.\n\nPASAL 3\nHARI KERJA, WAKTU KERJA, DAN LEMBUR\n1. Hari kerja: Senin — Jumat (5 hari).\n2. Jam kerja: 8 jam/hari; contoh jam kerja: 08.00 — 17.00, istirahat 12.00 — 13.00.\n3. Lembur atas perintah atasan dan dibayar sesuai ketentuan.\n\nPASAL 4\nUPAH, TUNJANGAN, DAN METODE PEMBAYARAN\n1. Rincian upah:\n   - Gaji Pokok: Rp ${this.gajiPokok} / bulan.\n   - Tunjangan Tetap (jika ada): Rp 0 / bulan.\n   - Tunjangan Tidak Tetap: Rp 0 / hari.\n2. Pembayaran setiap bulan (contoh: tanggal 28), melalui transfer bank ke:\n   - Bank: ${this.namaBank}\n   - Nomor Rekening: ${this.noRekening}\n   - Atas Nama: ${this.atasNamaRek}\n3. Potongan PPh 21 dan iuran jaminan sosial berlaku.\n\nPASAL 5\nJAMINAN SOSIAL DAN FASILITAS KESEHATAN\n1. PIHAK PERTAMA mendaftarkan PIHAK KEDUA pada BPJS Ketenagakerjaan dan BPJS Kesehatan.\n2. Iuran ditanggung bersama sesuai ketentuan.\n\nPASAL 6\nHAK CUTI DAN IZIN TIDAK MASUK KERJA\n1. Hak cuti tahunan diberikan secara proporsional sesuai aturan perusahaan.\n2. Permohonan cuti diajukan tertulis minimal 3 hari kerja sebelumnya.\n3. Sakit wajib disertai surat keterangan dokter bila diminta.\n\nPASAL 7\nTATA TERTIB, DISIPLIN, DAN SANKSI\n1. PIHAK KEDUA wajib mematuhi peraturan perusahaan, kode etik, dan SOP.\n2. Sanksi berjenjang: Teguran Lisan; SP I; SP II; SP III; sampai PHK.\n\nPASAL 8\nKERAHASIAAN DAN HAK KEKAYAAN INTELEKTUAL\n1. PIHAK KEDUA wajib menjaga kerahasiaan data, source code, dokumen teknis, dan informasi internal.\n2. Hasil karya selama hubungan kerja menjadi HKI milik PIHAK PERTAMA.\n\nPASAL 9\nUANG KOMPENSASI PKWT\n1. PIHAK PERTAMA wajib memberikan uang kompensasi sesuai PP No.35/2021.\n2. Pembayaran proporsional berdasarkan masa kerja.\n\nPASAL 10\nPENGAKHIRAN SEBELUM WAKTU DAN GANTI RUGI\n1. Pengakhiran dapat terjadi atas kesepakatan tertulis, pelanggaran berat, atau meninggal dunia.\n2. Pengakhiran di luar ketentuan dapat menimbulkan kewajiban ganti rugi.\n\nPASAL 11\nPENYELESAIAN PERSELISIHAN\n1. Diselesaikan musyawarah untuk mufakat terlebih dahulu.\n2. Jika gagal, diselesaikan sesuai prosedur hubungan industrial.\n\nPASAL 12\nPENUTUP\n1. Hal-hal yang belum diatur akan dituangkan dalam addendum/amandemen tertulis.\n2. Perjanjian dibuat dan ditandatangani dalam rangkap 2 bermaterai cukup.\n\nPIHAK PERTAMA                                 PIHAK KEDUA\n(PENGUSAHA)                                     (PEKERJA)\n\n[ Materai Rp 10.000 ]                           [ Materai Rp 10.000 ]\n\n(${this.diwakiliOleh})                          (${this.namaKaryawan})\n${this.jabatanPerusahaan}                       Pekerja / Karyawan`;

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

        buildHtmlDocument() {
            const esc = (t) => this.escapeHtml(t || '');
            const styles = `
                <style>
                    @page { size: A4; margin: 24mm }
                    body { font-family: 'Times New Roman', Georgia, serif; color:#111; }
                    h1 { text-align:center; font-size:16pt; margin-bottom:0.25rem }
                    .nomor { text-align:center; margin-bottom:1rem }
                    h2.pasal { font-size:12pt; margin-top:1rem; margin-bottom:0.25rem }
                    p { text-align:justify; font-size:11pt; line-height:1.6 }
                    ul { margin-left:1.25rem }
                    .signature { width:100%; margin-top:2.5rem }
                    .sig-col { width:48%; display:inline-block; vertical-align:top; }
                </style>`;

            const html = `<!doctype html><html><head><meta charset="utf-8">${styles}</head><body>
                <h1>SURAT PERJANJIAN KERJA WAKTU TERTENTU (PKWT)</h1>
                <div class="nomor"><strong>Nomor:</strong> ${esc(this.nomorSurat)}</div>

                <p>Pada hari ini, ${esc(this.hariTtd)} tanggal ${esc(this.tanggalTtd)}, bertempat di ${esc(this.kotaTtd)}, yang bertanda tangan di bawah ini:</p>

                <p>
                <strong>Nama Perusahaan:</strong> ${esc(this.namaPerusahaan)}<br>
                <strong>Alamat Perusahaan:</strong> ${esc(this.alamatPerusahaan)}<br>
                <strong>Diwakili Oleh:</strong> ${esc(this.diwakiliOleh)}<br>
                <strong>Jabatan:</strong> ${esc(this.jabatanPerusahaan)}
                </p>

                <p>
                <strong>Nama Lengkap:</strong> ${esc(this.namaKaryawan)}<br>
                <strong>No. KTP / NIK:</strong> ${esc(this.nikKaryawan)}<br>
                <strong>Tempat, Tgl Lahir:</strong> ${esc(this.tempatTglLahir)}<br>
                <strong>Alamat Domisili:</strong> ${esc(this.alamatDomisili)}<br>
                <strong>No. Telepon / HP:</strong> ${esc(this.noHpKaryawan)}
                </p>

                <p>Para Pihak menerangkan hal-hal sebagai berikut:</p>
                <ol>
                    <li>PIHAK PERTAMA bergerak di bidang: ${esc(this.bidangUsaha)}.</li>
                    <li>PIHAK KEDUA menyatakan memiliki kualifikasi dan kapasitas yang memadai untuk melaksanakan pekerjaan.</li>
                    <li>Para Pihak sepakat membuat Perjanjian Kerja Waktu Tertentu (PKWT) sesuai peraturan perundang-undangan.</li>
                </ol>

                <h2 class="pasal">PASAL 1<br>JABATAN, PENEMPATAN, DAN URAIAN TUGAS</h2>
                <p>1. PIHAK PERTAMA menerima PIHAK KEDUA sebagai: <strong>${esc(this.namaJabatan)}</strong>.<br>
                2. Penempatan: ${esc(this.namaDepartemen)} — ${esc(this.lokasiKantor)}.</p>
                <p>3. Uraian tugas utama:</p>
                <ul>
                    <li>Mengembangkan, menguji, dan memelihara aplikasi/sistem perangkat lunak perusahaan.</li>
                    <li>Melakukan koordinasi teknis dan integrasi database secara berkala.</li>
                    <li>Menyusun laporan berkala pelaksanaan pekerjaan kepada atasan langsung.</li>
                    <li>Melaksanakan tugas dinas lain sesuai kompetensi.</li>
                </ul>

                <h2 class="pasal">PASAL 2<br>JANGKA WAKTU PERJANJIAN</h2>
                <p>1. Jangka waktu: ${esc(this.masaKontrak)}, terhitung sejak ${esc(this.tglMulai)} sampai ${esc(this.tglSelesai)}.<br>
                2. PKWT ini tidak mensyaratkan masa percobaan (probation).<br>
                3. Setelah berakhir, hubungan kerja putus demi hukum.<br>
                4. Perpanjangan hanya atas kesepakatan tertulis, paling lambat 30 hari sebelum berakhir.</p>

                <h2 class="pasal">PASAL 3<br>HARI KERJA, WAKTU KERJA, DAN LEMBUR</h2>
                <p>1. Hari kerja: Senin — Jumat (5 hari).<br>
                2. Jam kerja: 8 jam/hari; contoh jam kerja: 08.00 — 17.00, istirahat 12.00 — 13.00.<br>
                3. Lembur atas perintah atasan dan dibayar sesuai ketentuan.</p>

                <h2 class="pasal">PASAL 4<br>UPAH, TUNJANGAN, DAN METODE PEMBAYARAN</h2>
                <p>1. Rincian upah:<br>
                - Gaji Pokok: Rp ${esc(this.gajiPokok)} / bulan.<br>
                - Tunjangan Tetap (jika ada): Rp 0 / bulan.<br>
                - Tunjangan Tidak Tetap: Rp 0 / hari.<br>
                2. Pembayaran setiap bulan (contoh: tanggal 28), melalui transfer bank ke:<br>
                - Bank: ${esc(this.namaBank)}<br>
                - Nomor Rekening: ${esc(this.noRekening)}<br>
                - Atas Nama: ${esc(this.atasNamaRek)}<br>
                3. Potongan PPh 21 dan iuran jaminan sosial berlaku.</p>

                <h2 class="pasal">PASAL 5<br>JAMINAN SOSIAL DAN FASILITAS KESEHATAN</h2>
                <p>PIHAK PERTAMA mendaftarkan PIHAK KEDUA pada BPJS Ketenagakerjaan dan BPJS Kesehatan. Iuran ditanggung bersama sesuai ketentuan.</p>

                <h2 class="pasal">PASAL 6<br>HAK CUTI DAN IZIN</h2>
                <p>Hak cuti diberikan secara proporsional; permohonan diajukan minimal 3 hari kerja sebelumnya; sakit disertai surat keterangan dokter bila diminta.</p>

                <h2 class="pasal">PASAL 7<br>TATA TERTIB, DISIPLIN, DAN SANKSI</h2>
                <p>PIHAK KEDUA wajib mematuhi peraturan perusahaan. Sanksi berjenjang: Teguran Lisan; SP I; SP II; SP III; sampai PHK.</p>

                <h2 class="pasal">PASAL 8<br>KERAHASIAAN DAN HAK KEKAYAAN INTELEKTUAL</h2>
                <p>PIHAK KEDUA wajib menjaga kerahasiaan data dan hasil karya menjadi HKI milik PIHAK PERTAMA.</p>

                <h2 class="pasal">PASAL 9<br>UANG KOMPENSASI PKWT</h2>
                <p>PIHAK PERTAMA wajib memberikan uang kompensasi sesuai PP No.35/2021; pembayaran proporsional berdasarkan masa kerja.</p>

                <h2 class="pasal">PASAL 10<br>PENGAKHIRAN SEBELUM WAKTU DAN GANTI RUGI</h2>
                <p>Pengakhiran atas kesepakatan tertulis, pelanggaran berat, atau meninggal dunia. Pengakhiran di luar ketentuan dapat menimbulkan kewajiban ganti rugi.</p>

                <h2 class="pasal">PASAL 11<br>PENYELESAIAN PERSELISIHAN</h2>
                <p>Diselesaikan musyawarah; jika gagal, melalui prosedur hubungan industrial.</p>

                <h2 class="pasal">PASAL 12<br>PENUTUP</h2>
                <p>Hal-hal belum diatur akan dituangkan dalam addendum/amandemen tertulis. Perjanjian dibuat dan ditandatangani dalam rangkap 2 bermaterai cukup.</p>

                <div class="signature">
                    <div class="sig-col">
                        <p>PIHAK PERTAMA<br>(PENGUSAHA)</p>
                        <p>[ Materai Rp 10.000 ]</p>
                        <p style="margin-top:2.5rem">(${esc(this.diwakiliOleh)})<br>${esc(this.jabatanPerusahaan)}</p>
                    </div>
                    <div class="sig-col" style="float:right; text-align:left">
                        <p>PIHAK KEDUA<br>(PEKERJA)</p>
                        <p>[ Materai Rp 10.000 ]</p>
                        <p style="margin-top:2.5rem">(${esc(this.namaKaryawan)})<br>Pekerja / Karyawan</p>
                    </div>
                </div>

            </body></html>`;

            return html;
        },

        exportPDF() {
            const html = this.buildHtmlDocument();
            const printWindow = window.open('', '_blank');
            printWindow.document.open();
            printWindow.document.write(html);
            printWindow.document.close();
            printWindow.onload = function() {
                printWindow.focus();
                printWindow.print();
            };
        },

        exportWord() {
            const html = this.buildHtmlDocument();
            const header = "<html xmlns:o='urn:schemas-microsoft-com:office:office' xmlns:w='urn:schemas-microsoft-com:office:word' xmlns='http://www.w3.org/TR/REC-html40'><head><meta charset='utf-8'><title>Surat PKWT</title></head><body>";
            const footer = '</body></html>';
            // strip the outer html/head/body tags from built html to avoid nesting
            const bodyStart = html.indexOf('<body>');
            const bodyEnd = html.lastIndexOf('</body>');
            const inner = bodyStart !== -1 && bodyEnd !== -1 ? html.substring(bodyStart + 6, bodyEnd) : html;
            const source = header + inner + footer;
            const blob = new Blob(['\ufeff', source], { type: 'application/msword' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            const filename = (this.nomorSurat || 'surat-pkwt').replace(/[^a-z0-9\-_.]/gi, '_') + '.doc';
            a.download = filename;
            document.body.appendChild(a);
            a.click();
            setTimeout(() => { URL.revokeObjectURL(url); a.remove(); }, 1500);
        }
    }));
});
</script>
@endsection