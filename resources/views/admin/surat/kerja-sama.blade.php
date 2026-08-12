@extends('layouts.admin')

@section('title', 'Draf Surat Perjanjian Kerja Sama Usaha')
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

<div class="space-y-6" x-data="kerjaSamaUsahaForm()">

    <!-- Bagian Form Input Variable -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700/80 p-6 shadow-sm no-print space-y-5">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-gray-100 dark:border-gray-700 pb-4">
            <div>
                <h2 class="text-base font-bold text-gray-900 dark:text-white">Variabel Dokumen Kerja Sama Usaha</h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Ubah nilai di bawah untuk menyesuaikan isi surat perjanjian secara langsung.</p>
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
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Hari TTD</label><input type="text" x-model="hariTtd" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Tanggal TTD</label><input type="text" x-model="tanggalTtd" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Kota TTD</label><input type="text" x-model="kotaTtd" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                </div>
            </fieldset>

            <!-- Pihak Pertama (Penyandang Dana) -->
            <fieldset class="border border-gray-200 dark:border-gray-700 rounded-xl p-4">
                <legend class="px-2 text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">Pihak Pertama (Penyandang Dana / Investor)</legend>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 pt-2">
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Nama Lengkap</label><input type="text" x-model="namaP1" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">No. KTP / NIK</label><input type="text" x-model="nikP1" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Jabatan / Kapasitas</label><input type="text" x-model="jabatanP1" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div class="md:col-span-2"><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Alamat</label><input type="text" x-model="alamatP1" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">No. Telepon / HP</label><input type="text" x-model="telpP1" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                </div>
            </fieldset>

            <!-- Pihak Kedua (Pengelola Usaha) -->
            <fieldset class="border border-gray-200 dark:border-gray-700 rounded-xl p-4">
                <legend class="px-2 text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">Pihak Kedua (Pengelola Usaha)</legend>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 pt-2">
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Nama Lengkap</label><input type="text" x-model="namaP2" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">No. KTP / NIK</label><input type="text" x-model="nikP2" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Jabatan / Kapasitas</label><input type="text" x-model="jabatanP2" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div class="md:col-span-2"><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Alamat</label><input type="text" x-model="alamatP2" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">No. Telepon / HP</label><input type="text" x-model="telpP2" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                </div>
            </fieldset>

            <!-- Rincian Kerja Sama & Keuangan -->
            <fieldset class="border border-gray-200 dark:border-gray-700 rounded-xl p-4">
                <legend class="px-2 text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">Rincian Kerja Sama & Keuangan</legend>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 pt-2">
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Jumlah Modal (Rp)</label><input type="text" x-model="jumlahModal" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div class="md:col-span-2"><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Terbilang Modal</label><input type="text" x-model="terbilangModal" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Nama Bank</label><input type="text" x-model="namaBank" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Nomor Rekening</label><input type="text" x-model="noRekening" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Atas Nama Rekening</label><input type="text" x-model="atasNamaRek" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Persentase Pihak Pertama (%)</label><input type="text" x-model="profitP1" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Persentase Pihak Kedua (%)</label><input type="text" x-model="profitP2" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Jangka Waktu Kontrak</label><input type="text" x-model="jangkaWaktu" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Tanggal Mulai</label><input type="text" x-model="tglMulai" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Tanggal Selesai</label><input type="text" x-model="tglSelesai" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                </div>
            </fieldset>

            <!-- Saksi & Domisili Hukum -->
            <fieldset class="border border-gray-200 dark:border-gray-700 rounded-xl p-4">
                <legend class="px-2 text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">Saksi & Domisili Hukum</legend>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 pt-2">
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Nama Saksi I</label><input type="text" x-model="saksi1" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Nama Saksi II</label><input type="text" x-model="saksi2" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Pengadilan Negeri (Penyelesaian)</label><input type="text" x-model="pengadilanNegeri" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                </div>
            </fieldset>
        </div>
    </div>

    <!-- Bagian Textarea Pratinjau & Edit Dokumen -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700/80 p-8 shadow-sm">
        <div class="mb-4 pb-3 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between no-print">
            <span class="text-xs font-bold text-gray-400 uppercase tracking-wider"><i class="fa-solid fa-file-lines mr-1.5"></i> Textarea Pratinjau & Edit Dokumen Kerja Sama Usaha</span>
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

        kontenSurat: '',
        
        init() {
            // Langsung memanggil updateSurat tanpa menimpa dengan data kosong
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

        updateSurat() {
            this.kontenSurat = `SURAT PERJANJIAN KERJA SAMA USAHA
Nomor: ${this.nomorSurat}

Pada hari ini, ${this.hariTtd} tanggal ${this.tanggalTtd}, bertempat di ${this.kotaTtd}, para pihak yang bertanda tangan di bawah ini:

1. Nama Lengkap      : ${this.namaP1}
   No. KTP / NIK     : ${this.nikP1}
   Jabatan / Kapasitas : ${this.jabatanP1}
   Alamat            : ${this.alamatP1}
   No. Telepon / HP  : ${this.telpP1}
Dalam hal ini bertindak untuk dan atas nama PT Maharadja Cipta Karya, selanjutnya disebut sebagai PIHAK PERTAMA.

2. Nama Lengkap      : ${this.namaP2}
   No. KTP / NIK     : ${this.nikP2}
   Jabatan / Kapasitas : ${this.jabatanP2}
   Alamat            : ${this.alamatP2}
   No. Telepon / HP  : ${this.telpP2}
Dalam hal ini bertindak untuk dan atas nama diri sendiri, selanjutnya disebut sebagai PIHAK KEDUA.

Para Pihak terlebih dahulu menerangkan hal-hal sebagai berikut:
1. Bahwa PIHAK PERTAMA adalah badan usaha yang bergerak di bidang penyediaan modal dan investasi usaha.
2. Bahwa PIHAK KEDUA adalah perorangan yang memiliki keahlian dan mengelola bisnis layanan perawatan dan jasa kreatif "Barbersole".
3. Bahwa Para Pihak bersepakat untuk melakukan kerja sama penyertaan modal dan pengembangan cabang usaha baru Barbersole.

Berdasarkan pertimbangan tersebut, Para Pihak sepakat untuk menandatangani Surat Perjanjian Kerja Sama ini dengan ketentuan sebagai berikut:

PASAL 1
MAKSUD DAN TUJUAN
Maksud dan tujuan dari Perjanjian ini adalah untuk mengatur skema kerja sama penyertaan modal, pengoperasian, serta pembagian hasil usaha dalam pengembangan cabang baru Barbersole di wilayah Makassar secara profesional, transparan, dan saling menguntungkan.

PASAL 2
RUANG LINGKUP KERJA SAMA
Ruang lingkup kerja sama mencakup penyediaan dana investasi oleh PIHAK PERTAMA serta pengelolaan operasional harian, pemasaran, pengadaan peralatan, dan manajemen sumber daya manusia oleh PIHAK KEDUA.

PASAL 3
MODAL INVESTASI DAN PENYETORAN DANA
1. PIHAK PERTAMA menyetorkan modal investasi sebesar Rp ${this.jumlahModal},- (${this.terbilangModal}).
2. Penyetoran dana dilakukan melalui transfer bank ke rekening operasional usaha yang ditunjuk oleh PIHAK KEDUA:
   - Nama Bank: ${this.namaBank}
   - Nomor Rekening: ${this.noRekening}
   - Atas Nama: ${this.atasNamaRek}
3. Modal investasi tersebut dialokasikan secara khusus untuk biaya sewa lokasi, renovasi tempat, pengadaan peralatan kerja, serta operasional awal usaha.

PASAL 4
SKEMA BAGI HASIL DAN LAPORAN KEUANGAN
1. Para Pihak sepakat membagi keuntungan bersih (net profit) yang dihitung dari pendapatan kotor dikurangi biaya operasional rutin bulanan.
2. Porsi pembagilabaan (profit sharing) ditetapkan sebagai berikut:
   - PIHAK PERTAMA berhak atas ${this.profitP1}% dari keuntungan bersih.
   - PIHAK KEDUA berhak atas ${this.profitP2}% dari keuntungan bersih.
3. PIHAK KEDUA wajib menyusun dan menyampaikan Laporan Keuangan Bulanan kepada PIHAK PERTAMA paling lambat tanggal 3 setiap bulannya.
4. Pembayaran pembagilabaan dilakukan setiap bulan pada tanggal 5 melalui transfer bank.

PASAL 5
JANGKA WAKTU DAN PERPANJANGAN
1. Perjanjian ini berlaku untuk jangka waktu ${this.jangkaWaktu}, terhitung sejak tanggal ${this.tglMulai} sampai dengan tanggal ${this.tglSelesai}.
2. Perjanjian ini dapat diperpanjang atas kesepakatan tertulis Para Pihak paling lambat 30 (tiga puluh) hari sebelum jangka waktu Perjanjian berakhir.

PASAL 6
HAK DAN KEWAJIBAN PIHAK PERTAMA
1. Kewajiban PIHAK PERTAMA:
   - Menyetorkan dana modal investasi secara penuh dan tepat waktu sesuai Pasal 3.
   - Menjaga kerahasiaan data operasional dan resep/metode kerja bisnis milik PIHAK KEDUA.
2. Hak PIHAK PERTAMA:
   - Menerima pembagian keuntungan bersih bulanan sesuai porsi dalam Pasal 4.
   - Menerima dan memeriksa laporan keuangan bulanan serta melakukan audit sewaktu-waktu jika diperlukan.

PASAL 7
HAK DAN KEWAJIBAN PIHAK KEDUA
1. Kewajiban PIHAK KEDUA:
   - Mengelola kegiatan operasional unit usaha secara profesional, jujur, dan efisien.
   - Menyusun laporan keuangan yang akurat dan membayarkan bagian keuntungan PIHAK PERTAMA tepat waktu.
   - Merawat seluruh fasilitas dan peralatan usaha milik tempat kerja sama.
2. Hak PIHAK KEDUA:
   - Menerima setoran modal investasi penuh dari PIHAK PERTAMA.
   - Mengambil keputusan teknis operasional harian demi kelancaran usaha.
   - Menerima porsi pembagilabaan sebesar ${this.profitP2}% dari keuntungan bersih.

PASAL 8
KERAHASIAAN INFORMASI (CONFIDENTIALITY)
Para Pihak sepakat untuk menjaga kerahasiaan seluruh dokumen, data keuangan, rahasia dagang, serta sistem operasional yang berkaitan dengan kerja sama ini, dan tidak membocorkannya kepada pihak ketiga tanpa izin tertulis dari pihak lainnya.

PASAL 9
PENGAKHIRAN PERJANJIAN DAN WANPRESTASI
1. Perjanjian ini berakhir demi hukum apabila jangka waktu perjanjian telah selesai dan tidak diperpanjang.
2. Apabila salah satu pihak melanggar ketentuan dalam Perjanjian ini (wanprestasi), pihak yang dirugikan berhak memberikan Surat Peringatan tertulis. Jika dalam 14 (empat belas) hari tidak dilakukan perbaikan, pihak yang dirugikan berhak mengakhiri Perjanjian secara sepihak dan menuntut ganti rugi.

PASAL 10
KEADAAN MEMAKSA (FORCE MAJEURE)
1. Keadaan Memaksa (Force Majeure) adalah kejadian di luar kendali wajar Para Pihak, seperti bencana alam, kebakaran, perang, kerusuhan, atau kebijakan pemerintah yang berdampak langsung pada kelangsungan usaha.
2. Pihak yang mengalami Force Majeure wajib memberitahukan secara tertulis kepada pihak lainnya paling lambat 7 (tujuh) hari kerja sejak terjadinya peristiwa untuk disepakati langkah penanggulangannya.

PASAL 11
PENYELESAIAN SENGKETA
1. Segala perselisihan yang timbul dari Perjanjian ini akan diselesaikan secara musyawarah untuk mufakat.
2. Apabila musyawarah tidak mencapai mufakat dalam waktu 30 (tiga puluh) hari, Para Pihak sepakat memilih domisili hukum yang tetap di Kantor Kepaniteraan Pengadilan Negeri ${this.pengadilanNegeri}.

PASAL 12
PENUTUP
Demikian Perjanjian ini dibuat dalam rangkap 2 (dua) asli bermaterai cukup dan memiliki kekuatan hukum yang sama bagi Para Pihak sejak tanggal ditandatangani.


PIHAK PERTAMA                               PIHAK KEDUA
Direktur Utama PT MCK                       Pengelola Barbersole


[ Materai Rp 10.000 ]                       [ Materai Rp 10.000 ]



(${this.namaP1})                            (${this.namaP2})



SAKSI-SAKSI:

Saksi I                                     Saksi II


(${this.saksi1})                            (${this.saksi2})`;
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
                    h1 { text-align:center; font-size:16pt; margin-bottom:0.25rem }
                    .nomor { text-align:center; margin-bottom:1rem }
                    h4.pasal { font-size:12pt; margin-top:1rem; margin-bottom:0.25rem; text-align:center }
                    p { text-align:justify; font-size:11pt; line-height:1.6 }
                    ul { margin-left:1.25rem }
                    .signature { width:100%; margin-top:2.5rem }
                    .sig-col { width:48%; display:inline-block; vertical-align:top; }
                    
                </style>`;

            const html = `<!doctype html><html><head><meta charset="utf-8">${styles}</head><body>
                <h4 style="text-align:center">SURAT PERJANJIAN KERJA SAMA USAHA</h4>
                <div class="nomor"><strong>Nomor:</strong> ${esc(this.nomorSurat)}</div>

                <p>Pada hari ini, ${esc(this.hariTtd)} tanggal ${esc(this.tanggalTtd)}, bertempat di ${esc(this.kotaTtd)}, para pihak yang bertanda tangan di bawah ini:</p>
                <table style="width:100%; margin-bottom:1rem;text-align:justify">
                    <tr>
                        <td style="width:150px; vertical-align:top">Nama Lengkap</td>
                        <td style="width:50px; vertical-align:top">:</td>
                        <td>${esc(this.namaP1)}</td>
                    </tr>
                    <tr>
                        <td style="width:150px; vertical-align:top">No. KTP / NIK</td>
                        <td style="width:50px; vertical-align:top">:</td>
                        <td>${esc(this.nikP1)}</td>
                    </tr>
                    <tr>
                        <td style="width:150px; vertical-align:top">Jabatan / Kapasitas</td>
                        <td style="width:50px; vertical-align:top">:</td>
                        <td>${esc(this.jabatanP1)}</td>
                    </tr>
                    <tr>
                        <td style="width:150px; vertical-align:top">Alamat</td>
                        <td style="width:50px; vertical-align:top">:</td>
                        <td>${esc(this.alamatP1)}</td>
                    </tr>
                    <tr>
                        <td style="width:150px; vertical-align:top">No. Telepon / HP</td>
                        <td style="width:50px; vertical-align:top">:</td>
                        <td>${esc(this.telpP1)}</td>
                    </tr>
                </table>
                <p style="text-align: justify;">Dalam hal ini bertindak untuk dan atas nama PT Maharadja Cipta Karya, selanjutnya disebut sebagai <strong>PIHAK PERTAMA</strong>.</p>

                <table style="width:100%; margin-bottom:1rem;text-align:justify">
                    <tr>
                        <td style="width:150px; vertical-align:top">Nama Lengkap</td>
                        <td style="width:50px; vertical-align:top">:</td>
                        <td>${esc(this.namaP2)}</td>
                    </tr>
                    <tr>
                        <td style="width:150px; vertical-align:top">No. KTP / NIK</td>
                        <td style="width:50px; vertical-align:top">:</td>
                        <td>${esc(this.nikP2)}</td>
                    </tr>
                    <tr>
                        <td style="width:150px; vertical-align:top">Jabatan / Kapasitas</td>
                        <td style="width:50px; vertical-align:top">:</td>
                        <td>${esc(this.jabatanP2)}</td>
                    </tr>
                    <tr>
                        <td style="width:150px; vertical-align:top">Alamat</td>
                        <td style="width:50px; vertical-align:top">:</td>
                        <td>${esc(this.alamatP2)}</td>
                    </tr>
                    <tr>
                        <td style="width:150px; vertical-align:top">No. Telepon / HP</td>
                        <td style="width:50px; vertical-align:top">:</td>
                        <td>${esc(this.telpP2)}</td>
                    </tr>
                </table>
                <p style="text-align: justify;">Dalam hal ini bertindak untuk dan atas nama diri sendiri, selanjutnya disebut sebagai <strong>PIHAK KEDUA</strong>.</p>

                <p style="text-align: justify;">Para Pihak terlebih dahulu menerangkan hal-hal sebagai berikut:</p>
                <ol>
                    <li style="text-align: justify;">Bahwa PIHAK PERTAMA adalah badan usaha yang bergerak di bidang penyediaan modal dan investasi usaha.</li>
                    <li style="text-align: justify;">Bahwa PIHAK KEDUA adalah perorangan yang memiliki keahlian dan mengelola bisnis layanan perawatan dan jasa kreatif "Barbersole".</li>
                    <li style="text-align: justify;">Bahwa Para Pihak bersepakat untuk melakukan kerja sama penyertaan modal dan pengembangan cabang usaha baru Barbersole.</li>
                </ol>

                <p style="text-align: justify;">Berdasarkan pertimbangan tersebut, Para Pihak sepakat untuk menandatangani Surat Perjanjian Kerja Sama ini dengan ketentuan sebagai berikut:</p>

                <h4 class="pasal" style="text-align: center;">PASAL 1<br>MAKSUD DAN TUJUAN</h4>
                <p style="text-align: justify;">Maksud dan tujuan dari Perjanjian ini adalah untuk mengatur skema kerja sama penyertaan modal, pengoperasian, serta pembagian hasil usaha dalam pengembangan cabang baru Barbersole di wilayah Makassar secara profesional, transparan, dan saling menguntungkan.</p>

                <h4 class="pasal" style="text-align: center;">PASAL 2<br>RUANG LINGKUP KERJA SAMA</h4>
                <p style="text-align: justify;">Ruang lingkup kerja sama mencakup penyediaan dana investasi oleh PIHAK PERTAMA serta pengelolaan operasional harian, pemasaran, pengadaan peralatan, dan manajemen sumber daya manusia oleh PIHAK KEDUA.</p>

                <h4 class="pasal" style="text-align: center;">PASAL 3<br>MODAL INVESTASI DAN PENYETORAN DANA</h4>
                <ol>
                    <li style="text-align: justify;">PIHAK PERTAMA menyetorkan modal investasi sebesar Rp ${esc(this.jumlahModal)},- (${esc(this.terbilangModal)}).</li>
                    <li style="text-align: justify;">Penyetoran dana dilakukan melalui transfer bank ke rekening operasional usaha yang ditunjuk oleh PIHAK KEDUA:
                        <ul style="list-style-type: disc;">
                            <li>Nama Bank: ${esc(this.namaBank)}</li>
                            <li>Nomor Rekening: ${esc(this.noRekening)}</li>
                            <li>Atas Nama: ${esc(this.atasNamaRek)}</li>
                        </ul>
                    </li>
                    <li style="text-align: justify;">Modal investasi tersebut dialokasikan secara khusus untuk biaya sewa lokasi, renovasi tempat, pengadaan peralatan kerja, serta operasional awal usaha.</li>
                </ol>

                <h4 class="pasal" style="text-align: center;">PASAL 4<br>SKEMA BAGI HASIL DAN LAPORAN KEUANGAN</h4>
                <ol>
                    <li style="text-align: justify;">Para Pihak sepakat membagi keuntungan bersih (net profit) yang dihitung dari pendapatan kotor dikurangi biaya operasional rutin bulanan.</li>
                    <li style="text-align: justify;">Porsi pembagilabaan (profit sharing) ditetapkan sebagai berikut:
                        <ul style="list-style-type: disc;">
                            <li>PIHAK PERTAMA berhak atas ${esc(this.profitP1)}% dari keuntungan bersih.</li>
                            <li>PIHAK KEDUA berhak atas ${esc(this.profitP2)}% dari keuntungan bersih.</li>
                        </ul>
                    </li>
                    <li style="text-align: justify;">PIHAK KEDUA wajib menyusun dan menyampaikan Laporan Keuangan Bulanan kepada PIHAK PERTAMA paling lambat tanggal 3 setiap bulannya.</li>
                    <li style="text-align: justify;">Pembayaran pembagilabaan dilakukan setiap bulan pada tanggal 5 melalui transfer bank.</li>
                </ol>

                <h4 class="pasal" style="text-align: center;">PASAL 5<br>JANGKA WAKTU DAN PERPANJANGAN</h4>
                <ol>
                    <li style="text-align: justify;">Perjanjian ini berlaku untuk jangka waktu ${esc(this.jangkaWaktu)}, terhitung sejak tanggal ${esc(this.tglMulai)} sampai dengan tanggal ${esc(this.tglSelesai)}.</li>
                    <li style="text-align: justify;">Perjanjian ini dapat diperpanjang atas kesepakatan tertulis Para Pihak paling lambat 30 (tiga puluh) hari sebelum jangka waktu Perjanjian berakhir.</li>
                </ol>

                <h4 class="pasal" style="text-align: center;">PASAL 6<br>HAK DAN KEWAJIBAN PIHAK PERTAMA</h4>
                <ol>
                    <li style="text-align: justify;">Kewajiban PIHAK PERTAMA:
                        <ol type="a">
                            <li>Menyetorkan dana modal investasi secara penuh dan tepat waktu sesuai Pasal 3.</li>
                            <li>Menjaga kerahasiaan data operasional dan resep/metode kerja bisnis milik PIHAK KEDUA.</li>
                        </ol>
                    </li>
                    <li style="text-align: justify;">Hak PIHAK PERTAMA:
                        <ol type="a">
                            <li>Menerima pembagian keuntungan bersih bulanan sesuai porsi dalam Pasal 4.</li>
                            <li>Menerima dan memeriksa laporan keuangan bulanan serta melakukan audit sewaktu-waktu jika diperlukan.</li>
                        </ol>
                    </li>
                </ol>

                <h4 class="pasal" style="text-align: center;">PASAL 7<br>HAK DAN KEWAJIBAN PIHAK KEDUA</h4>
                <ol>
                    <li style="text-align: justify;">Kewajiban PIHAK KEDUA:
                        <ol type="a">
                            <li>Mengelola kegiatan operasional unit usaha secara profesional, jujur, dan efisien.</li>
                            <li>Menyusun laporan keuangan yang akurat dan membayarkan bagian keuntungan PIHAK PERTAMA tepat waktu.</li>
                            <li>Merawat seluruh fasilitas dan peralatan usaha milik tempat kerja sama.</li>
                        </ol>
                    </li>
                    <li style="text-align: justify;">Hak PIHAK KEDUA:
                        <ol type="a">
                            <li>Menerima setoran modal investasi penuh dari PIHAK PERTAMA.</li>
                            <li>Mengambil keputusan teknis operasional harian demi kelancaran usaha.</li>
                            <li>Menerima porsi pembagilabaan sebesar ${esc(this.profitP2)}% dari keuntungan bersih.</li>
                        </ol>
                    </li>
                </ol>

                <h4 class="pasal" style="text-align: center;">PASAL 8<br>KERAHASIAAN INFORMASI (CONFIDENTIALITY)</h4>
                <p style="text-align: justify;">Para Pihak sepakat untuk menjaga kerahasiaan seluruh dokumen, data keuangan, rahasia dagang, serta sistem operasional yang berkaitan dengan kerja sama ini, dan tidak membocorkannya kepada pihak ketiga tanpa izin tertulis dari pihak lainnya.</p>

                <h4 class="pasal" style="text-align: center;">PASAL 9<br>PENGAKHIRAN PERJANJIAN DAN WANPRESTASI</h4>
                <ol>
                    <li style="text-align: justify;">Perjanjian ini berakhir demi hukum apabila jangka waktu perjanjian telah selesai dan tidak diperpanjang.</li>
                    <li style="text-align: justify;">Apabila salah satu pihak melanggar ketentuan dalam Perjanjian ini (wanprestasi), pihak yang dirugikan berhak memberikan Surat Peringatan tertulis. Jika dalam 14 (empat belas) hari tidak dilakukan perbaikan, pihak yang dirugikan berhak mengakhiri Perjanjian secara sepihak dan menuntut ganti rugi.</li>
                </ol>

                <h4 class="pasal" style="text-align: center;">PASAL 10<br>KEADAAN MEMAKSA (FORCE MAJEURE)</h4>
                <ol>
                    <li style="text-align: justify;">Keadaan Memaksa (Force Majeure) adalah kejadian di luar kendali wajar Para Pihak, seperti bencana alam, kebakaran, perang, kerusuhan, atau kebijakan pemerintah yang berdampak langsung pada kelangsungan usaha.</li>
                    <li style="text-align: justify;">Pihak yang mengalami Force Majeure wajib memberitahukan secara tertulis kepada pihak lainnya paling lambat 7 (tujuh) hari kerja sejak terjadinya peristiwa untuk disepakati langkah penanggulangannya.</li>
                </ol>

                <h4 class="pasal" style="text-align: center;">PASAL 11<br>PENYELESAIAN SENGKETA</h4>
                <ol>
                    <li style="text-align: justify;">Segala perselisihan yang timbul dari Perjanjian ini akan diselesaikan secara musyawarah untuk mufakat.</li>
                    <li style="text-align: justify;">Apabila musyawarah tidak mencapai mufakat dalam waktu 30 (tiga puluh) hari, Para Pihak sepakat memilih domisili hukum yang tetap di Kantor Kepaniteraan Pengadilan Negeri ${esc(this.pengadilanNegeri)}.</li>
                </ol>

                <h4 class="pasal" style="text-align: center;">PASAL 12<br>PENUTUP</h4>
                <p style="text-align: justify;">Demikian Perjanjian ini dibuat dalam rangkap 2 (dua) asli bermaterai cukup dan memiliki kekuatan hukum yang sama bagi Para Pihak sejak tanggal ditandatangani.</p>

                <br>
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

        exportWord() {
            const htmlContent = this.buildHtmlDocument();
            const blob = new Blob(['\ufeff', htmlContent], { type: 'application/msword' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            const filename = (this.nomorSurat || 'surat-perjanjian-kerja-sama-usaha').replace(/[^a-z0-9\-_.]/gi, '_') + '.doc';
            a.download = filename;
            document.body.appendChild(a);
            a.click();
            setTimeout(() => { URL.revokeObjectURL(url); a.remove(); }, 1500);
        }
    }));
});
</script>
@endsection