@extends('layouts.admin')

@section('title', 'Draf Surat Perjanjian Sewa Menyewa Multiguna')
@section('page-subtitle', 'Isi variabel formulir di bawah untuk memperbarui draf surat perjanjian sewa menyewa secara real-time.')

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

<div class="space-y-6" x-data="suratSewaMenyewaForm()">

    <!-- Bagian Form Input Variable -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700/80 p-6 shadow-sm no-print space-y-5">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-gray-100 dark:border-gray-700 pb-4">
            <div>
                <h2 class="text-base font-bold text-gray-900 dark:text-white">Variabel Dokumen Perjanjian Sewa Menyewa</h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Ubah nilai di bawah untuk menyesuaikan isi surat perjanjian sewa secara langsung.</p>
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

            <!-- Pihak Pertama (Pemilik) -->
            <fieldset class="border border-gray-200 dark:border-gray-700 rounded-xl p-4">
                <legend class="px-2 text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">Pihak Pertama (Pemilik)</legend>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 pt-2">
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Nama Lengkap</label><input type="text" x-model="namaP1" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">No. KTP / NIK</label><input type="text" x-model="nikP1" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Pekerjaan</label><input type="text" x-model="pekerjaanP1" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div class="md:col-span-2"><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Alamat Lengkap</label><input type="text" x-model="alamatP1" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">No. Telepon / HP</label><input type="text" x-model="telpP1" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                </div>
            </fieldset>

            <!-- Pihak Kedua (Penyewa) -->
            <fieldset class="border border-gray-200 dark:border-gray-700 rounded-xl p-4">
                <legend class="px-2 text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">Pihak Kedua (Penyewa)</legend>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 pt-2">
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Nama Lengkap</label><input type="text" x-model="namaP2" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">No. KTP / NIK</label><input type="text" x-model="nikP2" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Pekerjaan</label><input type="text" x-model="pekerjaanP2" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div class="md:col-span-2"><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Alamat Lengkap</label><input type="text" x-model="alamatP2" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">No. Telepon / HP</label><input type="text" x-model="telpP2" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                </div>
            </fieldset>

            <!-- Kategori & Detail Objek Sewa -->
            <fieldset class="border border-gray-200 dark:border-gray-700 rounded-xl p-4">
                <legend class="px-2 text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">Objek & Kategori Sewa</legend>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 pt-2 mb-4">
                    <div class="md:col-span-3">
                        <label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Pilih Kategori Objek Sewa</label>
                        <select x-model="kategoriObjek" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition">
                            <option value="properti">Rumah / Ruko / Properti</option>
                            <option value="kendaraan">Kendaraan / Aset Lainnya</option>
                        </select>
                    </div>
                </div>

                <!-- Input Khusus Kategori Properti -->
                <div x-show="kategoriObjek === 'properti'" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 pt-2">
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Jenis Properti</label><input type="text" x-model="propertiJenis" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Sertifikat / Alas Hak (SHM No.)</label><input type="text" x-model="propertiShm" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Luas Bangunan / Tanah</label><input type="text" x-model="propertiLuas" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div class="md:col-span-2"><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Alamat / Lokasi Properti</label><input type="text" x-model="propertiLokasi" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Fasilitas (Listrik, Air, Kamar)</label><input type="text" x-model="propertiFasilitas" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                </div>

                <!-- Input Khusus Kategori Kendaraan / Aset Lainnya -->
                <div x-show="kategoriObjek === 'kendaraan'" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 pt-2">
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Merek / Tipe / Jenis</label><input type="text" x-model="kendaraanMerek" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Nomor Polisi / Serial Number</label><input type="text" x-model="kendaraanPlat" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Nomor Rangka / Nomor Mesin</label><input type="text" x-model="kendaraanRangkaMesin" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Kondisi Barang</label><input type="text" x-model="kendaraanKondisi" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                </div>
            </fieldset>

            <!-- Harga, Jangka Waktu & Pembayaran -->
            <fieldset class="border border-gray-200 dark:border-gray-700 rounded-xl p-4">
                <legend class="px-2 text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">Harga, Waktu & Rekening Pembayaran</legend>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 pt-2">
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Harga Sewa (Rp)</label><input type="text" x-model="hargaSewa" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div class="md:col-span-2"><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Terbilang Harga Sewa</label><input type="text" x-model="terbilangHarga" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Periode Sewa (per tahun / bulan)</label><input type="text" x-model="periodeSewa" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Jangka Waktu Kontrak</label><input type="text" x-model="jangkaWaktu" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Tanggal Mulai Sewa</label><input type="text" x-model="tglMulai" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Tanggal Selesai Sewa</label><input type="text" x-model="tglSelesai" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Uang Jaminan (Deposit) (Rp)</label><input type="text" x-model="uangDeposit" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Nama Bank</label><input type="text" x-model="namaBank" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Nomor Rekening</label><input type="text" x-model="noRekening" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Atas Nama Rekening</label><input type="text" x-model="atasNamaRek" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
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
            <span class="text-xs font-bold text-gray-400 uppercase tracking-wider"><i class="fa-solid fa-file-lines mr-1.5"></i> Textarea Pratinjau & Edit Dokumen Perjanjian Sewa Menyewa</span>
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
    Alpine.data('suratSewaMenyewaForm', () => ({
        nomorSurat: '040/SPSM/VIII/2026',
        hariTtd: 'Rabu',
        tanggalTtd: '12 Agustus 2026',
        kotaTtd: 'Makassar',
        
        namaP1: 'H. Abdullah S., S.H.',
        nikP1: '7371011505700001',
        pekerjaanP1: 'Pensiunan / Pemilik Properti',
        alamatP1: 'Jl. Boulevard Blok F No. 12, Makassar',
        telpP1: '0812-3456-7890',

        namaP2: 'Rahmat Hidayat, S.Kom.',
        nikP2: '7371021508900003',
        pekerjaanP2: 'Pengusaha / Pengelola Barbersole',
        alamatP2: 'Jl. Perintis Kemerdekaan Km. 10, Makassar',
        telpP2: '0852-9988-7766',

        kategoriObjek: 'properti',

        // Properti
        propertiJenis: 'Rumah Toko (Ruko) 2 Lantai',
        propertiShm: 'No. 5432/Tamamaung',
        propertiLuas: '150 m²',
        propertiLokasi: 'Jl. Pengayoman No. 22, Kota Makassar',
        propertiFasilitas: 'Listrik (2200 Watt), Air PDAM, 2 Kamar Mandi',

        // Kendaraan
        kendaraanMerek: 'Mobil Toyota Avanza G Manual',
        kendaraanPlat: 'DD 1456 AB',
        kendaraanRangkaMesin: 'MHF567890 / 1NR-VE',
        kendaraanKondisi: 'Sangat Layak Pakai & Berfungsi Normal',

        hargaSewa: '35.000.000',
        terbilangHarga: 'Tiga Puluh Lima Juta Rupiah',
        periodeSewa: 'tahun',
        jangkaWaktu: '1 (satu) tahun',
        tglMulai: '12 Agustus 2026',
        tglSelesai: '12 Agustus 2027',
        uangDeposit: '3.000.000',

        namaBank: 'Bank Mandiri',
        noRekening: '152-00-1234567-8',
        atasNamaRek: 'H. Abdullah S.',

        saksi1: 'Hendra Wijaya, S.H.',
        saksi2: 'Siti Nurhaliza',
        pengadilanNegeri: 'Makassar',

        kontenSurat: '',
        
        init() {
            this.updateSurat();
            
            const fields = [
                'nomorSurat', 'hariTtd', 'tanggalTtd', 'kotaTtd', 
                'namaP1', 'nikP1', 'pekerjaanP1', 'alamatP1', 'telpP1',
                'namaP2', 'nikP2', 'pekerjaanP2', 'alamatP2', 'telpP2',
                'kategoriObjek', 'propertiJenis', 'propertiShm', 'propertiLuas', 'propertiLokasi', 'propertiFasilitas',
                'kendaraanMerek', 'kendaraanPlat', 'kendaraanRangkaMesin', 'kendaraanKondisi',
                'hargaSewa', 'terbilangHarga', 'periodeSewa', 'jangkaWaktu', 'tglMulai', 'tglSelesai', 'uangDeposit',
                'namaBank', 'noRekening', 'atasNamaRek', 'saksi1', 'saksi2', 'pengadilanNegeri'
            ];

            fields.forEach(field => {
                this.$watch(field, () => this.updateSurat());
            });
        },

        updateSurat() {
            let detailObjekText = '';
            if (this.kategoriObjek === 'properti') {
                detailObjekText = `KATEGORI RUMAH / RUKO / PROPERTI:
- Jenis Properti: ${this.propertiJenis}
- Sertifikat / Alas Hak: Sertifikat Hak Milik (SHM) No. ${this.propertiShm}
- Luas Bangunan / Tanah: ${this.propertiLuas}
- Alamat / Lokasi: ${this.propertiLokasi}
- Fasilitas: ${this.propertiFasilitas}`;
            } else {
                detailObjekText = `KATEGORI KENDARAAN / ASET LAINNYA:
- Merek / Tipe / Jenis: ${this.kendaraanMerek}
- Nomor Polisi / Serial Number: ${this.kendaraanPlat}
- Nomor Rangka / Nomor Mesin: ${this.kendaraanRangkaMesin}
- Kondisi Barang: ${this.kendaraanKondisi}`;
            }

            this.kontenSurat = `SURAT PERJANJIAN SEWA MENYEWA
Nomor: ${this.nomorSurat}

Pada hari ini, ${this.hariTtd} tanggal ${this.tanggalTtd}, bertempat di ${this.kotaTtd}, kami yang bertanda tangan di bawah ini:

1. Nama Lengkap   : ${this.namaP1}
   No. KTP / NIK  : ${this.nikP1}
   Pekerjaan      : ${this.pekerjaanP1}
   Alamat Lengkap : ${this.alamatP1}
   No. Telepon / HP: ${this.telpP1}
Dalam hal ini bertindak sebagai pemilik sah atas objek sewa, yang selanjutnya disebut sebagai PIHAK PERTAMA (PEMILIK).

2. Nama Lengkap   : ${this.namaP2}
   No. KTP / NIK  : ${this.nikP2}
   Pekerjaan      : ${this.pekerjaanP2}
   Alamat Lengkap : ${this.alamatP2}
   No. Telepon / HP: ${this.telpP2}
Dalam hal ini bertindak sebagai penyewa, yang selanjutnya disebut sebagai PIHAK KEDUA (PENYEWA).

Para Pihak terlebih dahulu menerangkan bahwa PIHAK PERTAMA adalah pemilik sah yang bermaksud menyewakan objek kepada PIHAK KEDUA, dan PIHAK KEDUA sepakat untuk menyewa objek tersebut dengan syarat dan ketentuan sebagai berikut:

PASAL 1
OBJEK SEWA
PIHAK PERTAMA menyewakan kepada PIHAK KEDUA sebuah objek dengan rincian identifikasi sebagai berikut:

${detailObjekText}

PASAL 2
HARGA SEWA DAN SKEMA PEMBAYARAN
1. Harga sewa objek tersebut disepakati sebesar Rp ${this.hargaSewa},- (${this.terbilangHarga}) per ${this.periodeSewa}.
2. Pembayaran dilakukan oleh PIHAK KEDUA secara penuh/lunas di awal pada saat penandatanganan perjanjian ini melalui transfer bank ke rekening PIHAK PERTAMA:
   - Nama Bank: ${this.namaBank}
   - Nomor Rekening: ${this.noRekening}
   - Atas Nama: ${this.atasNamaRek}
3. Surat Perjanjian ini berlaku sekaligus sebagai kuitansi/bukti tanda terima pembayaran resmi yang sah.

PASAL 3
JANGKA WAKTU SEWA
1. Sewa menyewa ini berlangsung untuk jangka waktu ${this.jangkaWaktu}, terhitung sejak tanggal ${this.tglMulai} sampai dengan tanggal ${this.tglSelesai}.
2. Apabila PIHAK KEDUA bermaksud memperpanjang masa sewa, PIHAK KEDUA wajib memberitahukan secara tertulis kepada PIHAK PERTAMA paling lambat 30 (tiga puluh) hari sebelum masa sewa berakhir.

PASAL 4
UANG JAMINAN (DEPOSIT)
1. PIHAK KEDUA menyerahkan uang jaminan (deposit) sebesar Rp ${this.uangDeposit},- kepada PIHAK PERTAMA bersamaan dengan pembayaran sewa.
2. Uang jaminan ini akan dikembalikan secara utuh kepada PIHAK KEDUA setelah masa sewa berakhir, dikurangi biaya perbaikan kerusakan (jika ada) atau tunggakan tagihan bulanan.

PASAL 5
HAK DAN KEWAJIBAN PIHAK KEDUA (PENYELESAIAN OPERASIONAL)
1. PIHAK KEDUA wajib merawat dan menjaga kebersihan serta keutuhan objek sewa dengan sebaik-baiknya.
2. PIHAK KEDUA wajib membayar biaya rutin pemakaian (listrik, air PDAM, iuran lingkungan/kebersihan, internet) selama masa sewa berlangsung.
3. PIHAK KEDUA dilarang menyewakan kembali atau mengalihkan hak sewa objek ini kepada pihak ketiga tanpa izin tertulis dari PIHAK PERTAMA.
4. PIHAK KEDUA dilarang menggunakan objek sewa untuk kegiatan yang melanggar hukum, norma kesusilaan, atau peruntukan yang tidak disepakati.

PASAL 6
PERBAIKAN DAN PERUBAHAN FISIK
1. Kerusakan struktur utama (atap bocor parah, dinding retak struktur, kerusakan mesin bawaan) menjadi tanggung jawab PIHAK PERTAMA.
2. Kerusakan kecil akibat pemakaian sehari-hari (bohlam putus, kran air rusak, servis rutin) menjadi tanggung jawab PIHAK KEDUA.
3. PIHAK KEDUA dilarang mengubah bentuk fisik atau struktur utama objek sewa tanpa persetujuan tertulis dari PIHAK PERTAMA.

PASAL 7
PENYELESAIAN SENGKETA
1. Segala perselisihan yang timbul mengenai pelaksanaan Perjanjian ini akan diselesaikan secara musyawarah untuk mufakat.
2. Apabila musyawarah tidak mencapai mufakat, Para Pihak sepakat untuk menyelesaikan permasalahan hukum melalui Pengadilan Negeri ${this.pengadilanNegeri}.

PASAL 8
PENUTUP
Demikian Surat Perjanjian Sewa Menyewa ini dibuat dalam rangkap 2 (dua) bermaterai cukup, yang masing-masing mempunyai kekuatan hukum yang sama dan berlaku sejak ditandatangani oleh Para Pihak.


PIHAK PERTAMA (PEMILIK)                     PIHAK KEDUA (PENYEWA)


[ Materai Rp 10.000 ]                       [ Materai Rp 10.000 ]



(${this.namaP1})                            (${this.namaP2})



SAKSI-SAKSI:

(${this.saksi1})                            (${this.saksi2})
Saksi I                                     Saksi II`;
        },

        reset() {
            this.nomorSurat = '040/SPSM/VIII/2026';
            this.hariTtd = 'Rabu';
            this.tanggalTtd = '12 Agustus 2026';
            this.kotaTtd = 'Makassar';
            this.namaP1 = 'H. Abdullah S., S.H.';
            this.nikP1 = '7371011505700001';
            this.pekerjaanP1 = 'Pensiunan / Pemilik Properti';
            this.alamatP1 = 'Jl. Boulevard Blok F No. 12, Makassar';
            this.telpP1 = '0812-3456-7890';
            this.namaP2 = 'Rahmat Hidayat, S.Kom.';
            this.nikP2 = '7371021508900003';
            this.pekerjaanP2 = 'Pengusaha / Pengelola Barbersole';
            this.alamatP2 = 'Jl. Perintis Kemerdekaan Km. 10, Makassar';
            this.telpP2 = '0852-9988-7766';
            this.kategoriObjek = 'properti';
            this.propertiJenis = 'Rumah Toko (Ruko) 2 Lantai';
            this.propertiShm = 'No. 5432/Tamamaung';
            this.propertiLuas = '150 m²';
            this.propertiLokasi = 'Jl. Pengayoman No. 22, Kota Makassar';
            this.propertiFasilitas = 'Listrik (2200 Watt), Air PDAM, 2 Kamar Mandi';
            this.kendaraanMerek = 'Mobil Toyota Avanza G Manual';
            this.kendaraanPlat = 'DD 1456 AB';
            this.kendaraanRangkaMesin = 'MHF567890 / 1NR-VE';
            this.kendaraanKondisi = 'Sangat Layak Pakai & Berfungsi Normal';
            this.hargaSewa = '35.000.000';
            this.terbilangHarga = 'Tiga Puluh Lima Juta Rupiah';
            this.periodeSewa = 'tahun';
            this.jangkaWaktu = '1 (satu) tahun';
            this.tglMulai = '12 Agustus 2026';
            this.tglSelesai = '12 Agustus 2027';
            this.uangDeposit = '3.000.000';
            this.namaBank = 'Bank Mandiri';
            this.noRekening = '152-00-1234567-8';
            this.atasNamaRek = 'H. Abdullah S.';
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
            let detailObjekHtml = '';
            if (this.kategoriObjek === 'properti') {
                detailObjekHtml = `<b>KATEGORI RUMAH / RUKO / PROPERTI</b><br>
                - Jenis Properti: ${esc(this.propertiJenis)}<br>
                - Sertifikat / Alas Hak: Sertifikat Hak Milik (SHM) No. ${esc(this.propertiShm)}<br>
                - Luas Bangunan / Tanah: ${esc(this.propertiLuas)}<br>
                - Alamat / Lokasi: ${esc(this.propertiLokasi)}<br>
                - Fasilitas: ${esc(this.propertiFasilitas)}`;
            } else {
                detailObjekHtml = `<b>KATEGORI KENDARAAN / ASET LAINNYA</b><br>
                - Merek / Tipe / Jenis: ${esc(this.kendaraanMerek)}<br>
                - Nomor Polisi / Serial Number: ${esc(this.kendaraanPlat)}<br>
                - Nomor Rangka / Nomor Mesin: ${esc(this.kendaraanRangkaMesin)}<br>
                - Kondisi Barang: ${esc(this.kendaraanKondisi)}`;
            }

            const styles = `
                <style>
                    @page { size: A4; margin: 24mm }
                    body { font-family: 'Times New Roman', Georgia, serif; color:#111; }
                    h4.pasal { font-size:12pt; margin-top:1rem; margin-bottom:0.25rem; text-align:center }
                    p { text-align:justify; font-size:11pt; line-height:1.6 }
                </style>`;

            const html = `<!doctype html><html><head><meta charset="utf-8">${styles}</head><body>
                <h4 style="text-align:center">SURAT PERJANJIAN SEWA MENYEWA</h4>
                <div style="text-align:center; margin-bottom:1.5rem"><strong>Nomor:</strong> ${esc(this.nomorSurat)}</div>

                <p>Pada hari ini, ${esc(this.hariTtd)} tanggal ${esc(this.tanggalTtd)}, bertempat di ${esc(this.kotaTtd)}, kami yang bertanda tangan di bawah ini:</p>
                
                <table style="width:100%; margin-bottom:1rem; text-align:justify">
                    <tr>
                        <td style="width:150px; vertical-align:top">Nama Lengkap</td>
                        <td style="width:20px; vertical-align:top">:</td>
                        <td>${esc(this.namaP1)}</td>
                    </tr>
                    <tr>
                        <td style="vertical-align:top">No. KTP / NIK</td>
                        <td style="vertical-align:top">:</td>
                        <td>${esc(this.nikP1)}</td>
                    </tr>
                    <tr>
                        <td style="vertical-align:top">Pekerjaan</td>
                        <td style="vertical-align:top">:</td>
                        <td>${esc(this.pekerjaanP1)}</td>
                    </tr>
                    <tr>
                        <td style="vertical-align:top">Alamat Lengkap</td>
                        <td style="vertical-align:top">:</td>
                        <td>${esc(this.alamatP1)}</td>
                    </tr>
                    <tr>
                        <td style="vertical-align:top">No. Telepon / HP</td>
                        <td style="vertical-align:top">:</td>
                        <td>${esc(this.telpP1)}</td>
                    </tr>
                </table>
                <p>Dalam hal ini bertindak sebagai pemilik sah atas objek sewa, yang selanjutnya disebut sebagai <strong>PIHAK PERTAMA (PEMILIK)</strong>.</p>

                <table style="width:100%; margin-bottom:1rem; text-align:justify">
                    <tr>
                        <td style="width:150px; vertical-align:top">Nama Lengkap</td>
                        <td style="width:20px; vertical-align:top">:</td>
                        <td>${esc(this.namaP2)}</td>
                    </tr>
                    <tr>
                        <td style="vertical-align:top">No. KTP / NIK</td>
                        <td style="vertical-align:top">:</td>
                        <td>${esc(this.nikP2)}</td>
                    </tr>
                    <tr>
                        <td style="vertical-align:top">Pekerjaan</td>
                        <td style="vertical-align:top">:</td>
                        <td>${esc(this.pekerjaanP2)}</td>
                    </tr>
                    <tr>
                        <td style="vertical-align:top">Alamat Lengkap</td>
                        <td style="vertical-align:top">:</td>
                        <td>${esc(this.alamatP2)}</td>
                    </tr>
                    <tr>
                        <td style="vertical-align:top">No. Telepon / HP</td>
                        <td style="vertical-align:top">:</td>
                        <td>${esc(this.telpP2)}</td>
                    </tr>
                </table>
                <p>Dalam hal ini bertindak sebagai penyewa, yang selanjutnya disebut sebagai <strong>PIHAK KEDUA (PENYEWA)</strong>.</p>

                <p>Para Pihak terlebih dahulu menerangkan bahwa PIHAK PERTAMA adalah pemilik sah yang bermaksud menyewakan objek kepada PIHAK KEDUA, dan PIHAK KEDUA sepakat untuk menyewa objek tersebut dengan syarat dan ketentuan sebagai berikut:</p>

                <h4 class="pasal">PASAL 1<br>OBJEK SEWA</h4>
                <p>PIHAK PERTAMA menyewakan kepada PIHAK KEDUA sebuah objek dengan rincian identifikasi sebagai berikut:</p>
                <div style="margin-left:1rem; font-size:11pt; line-height:1.6">${detailObjekHtml}</div>

                <h4 class="pasal">PASAL 2<br>HARGA SEWA DAN SKEMA PEMBAYARAN</h4>
                <ol style="font-size:11pt; line-height:1.6">
                    <li>Harga sewa objek tersebut disepakati sebesar Rp ${esc(this.hargaSewa)},- (${esc(this.terbilangHarga)}) per ${esc(this.periodeSewa)}.</li>
                    <li>Pembayaran dilakukan oleh PIHAK KEDUA secara penuh/lunas di awal pada saat penandatanganan perjanjian ini melalui transfer bank ke rekening PIHAK PERTAMA:
                        <br>- Nama Bank: ${esc(this.namaBank)}
                        <br>- Nomor Rekening: ${esc(this.noRekening)}
                        <br>- Atas Nama: ${esc(this.atasNamaRek)}
                    </li>
                    <li>Surat Perjanjian ini berlaku sekaligus sebagai kuitansi/bukti tanda terima pembayaran resmi yang sah.</li>
                </ol>

                <h4 class="pasal">PASAL 3<br>JANGKA WAKTU SEWA</h4>
                <ol style="font-size:11pt; line-height:1.6">
                    <li>Sewa menyewa ini berlangsung untuk jangka waktu ${esc(this.jangkaWaktu)}, terhitung sejak tanggal ${esc(this.tglMulai)} sampai dengan tanggal ${esc(this.tglSelesai)}.</li>
                    <li>Apabila PIHAK KEDUA bermaksud memperpanjang masa sewa, PIHAK KEDUA wajib memberitahukan secara tertulis kepada PIHAK PERTAMA paling lambat 30 (tiga puluh) hari sebelum masa sewa berakhir.</li>
                </ol>

                <h4 class="pasal">PASAL 4<br>UANG JAMINAN (DEPOSIT)</h4>
                <ol style="font-size:11pt; line-height:1.6">
                    <li>PIHAK KEDUA menyerahkan uang jaminan (deposit) sebesar Rp ${esc(this.uangDeposit)},- kepada PIHAK PERTAMA bersamaan dengan pembayaran sewa.</li>
                    <li>Uang jaminan ini akan dikembalikan secara utuh kepada PIHAK KEDUA setelah masa sewa berakhir, dikurangi biaya perbaikan kerusakan (jika ada) atau tunggakan tagihan bulanan.</li>
                </ol>

                <h4 class="pasal">PASAL 5<br>HAK DAN KEWAJIBAN PIHAK KEDUA (PENYELESAIAN OPERASIONAL)</h4>
                <ol style="font-size:11pt; line-height:1.6">
                    <li>PIHAK KEDUA wajib merawat dan menjaga kebersihan serta keutuhan objek sewa dengan sebaik-baiknya.</li>
                    <li>PIHAK KEDUA wajib membayar biaya rutin pemakaian (listrik, air PDAM, iuran lingkungan/kebersihan, internet) selama masa sewa berlangsung.</li>
                    <li>PIHAK KEDUA dilarang menyewakan kembali atau mengalihkan hak sewa objek ini kepada pihak ketiga tanpa izin tertulis dari PIHAK PERTAMA.</li>
                    <li>PIHAK KEDUA dilarang menggunakan objek sewa untuk kegiatan yang melanggar hukum, norma kesusilaan, atau peruntukan yang tidak disepakati.</li>
                </ol>

                <h4 class="pasal">PASAL 6<br>PERBAIKAN DAN PERUBAHAN FISIK</h4>
                <ol style="font-size:11pt; line-height:1.6">
                    <li>Kerusakan struktur utama (atap bocor parah, dinding retak struktur, kerusakan mesin bawaan) menjadi tanggung jawab PIHAK PERTAMA.</li>
                    <li>Kerusakan kecil akibat pemakaian sehari-hari (bohlam putus, kran air rusak, servis rutin) menjadi tanggung jawab PIHAK KEDUA.</li>
                    <li>PIHAK KEDUA dilarang mengubah bentuk fisik atau struktur utama objek sewa tanpa persetujuan tertulis dari PIHAK PERTAMA.</li>
                </ol>

                <h4 class="pasal">PASAL 7<br>PENYELESAIAN SENGKETA</h4>
                <ol style="font-size:11pt; line-height:1.6">
                    <li>Segala perselisihan yang timbul mengenai pelaksanaan Perjanjian ini akan diselesaikan secara musyawarah untuk mufakat.</li>
                    <li>Apabila musyawarah tidak mencapai mufakat, Para Pihak sepakat untuk menyelesaikan permasalahan hukum melalui Pengadilan Negeri ${esc(this.pengadilanNegeri)}.</li>
                </ol>

                <h4 class="pasal">PASAL 8<br>PENUTUP</h4>
                <p>Demikian Surat Perjanjian Sewa Menyewa ini dibuat dalam rangkap 2 (dua) bermaterai cukup, yang masing-masing mempunyai kekuatan hukum yang sama dan berlaku sejak ditandatangani oleh Para Pihak.</p>

                <br>
                <table style="width:100%; margin-bottom:2rem; text-align:justify">
                    <tr>
                        <th style="width:50%; vertical-align:top; text-align:center">PIHAK PERTAMA (PEMILIK)</th>
                        <th style="width:50%; vertical-align:top; text-align:center">PIHAK KEDUA (PENYEWA)</th>
                    </tr>
                    <tr>
                        <td style="width:50%; vertical-align:top; text-align:center"><br><br>[ Materai Rp 10.000 ]<br><br></td>
                        <td style="width:50%; vertical-align:top; text-align:center"><br><br>[ Materai Rp 10.000 ]<br><br></td>
                    </tr>
                    <tr>
                        <th style="width:50%; vertical-align:top; text-align:center; padding-top:2rem">(${esc(this.namaP1)})</th>
                        <th style="width:50%; vertical-align:top; text-align:center; padding-top:2rem">(${esc(this.namaP2)})</th>
                    </tr>
                </table>

                <br>
                <div style="text-align:center; font-weight:bold;">SAKSI-SAKSI:</div>
                <table style="width:100%; margin-top:1rem; text-align:justify">
                    <tr>
                        <td style="width:50%; vertical-align:top; text-align:center"><br><br><br>(${esc(this.saksi1)})<br>Saksi I</td>
                        <td style="width:50%; vertical-align:top; text-align:center"><br><br><br>(${esc(this.saksi2)})<br>Saksi II</td>
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
            const filename = (this.nomorSurat || 'surat-perjanjian-sewa-menyewa').replace(/[^a-z0-9\-_.]/gi, '_') + '.doc';
            a.download = filename;
            document.body.appendChild(a);
            a.click();
            setTimeout(() => { URL.revokeObjectURL(url); a.remove(); }, 1500);
        }
    }));
});
</script>
@endsection