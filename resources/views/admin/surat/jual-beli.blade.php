@extends('layouts.admin')

@section('title', 'Draf Surat Perjanjian Jual Beli Aset Multiguna')
@section('page-subtitle', 'Isi variabel formulir di bawah untuk memperbarui draf surat perjanjian jual beli aset secara
    real-time.')

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

    <div class="space-y-6" x-data="suratJualBeliAsetForm()">

        <!-- Bagian Form Input Variable -->
        <div
            class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700/80 p-6 shadow-sm no-print space-y-5">
            <div
                class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-gray-100 dark:border-gray-700 pb-4">
                <div>
                    <h2 class="text-base font-bold text-gray-900 dark:text-white">Variabel Dokumen Perjanjian Jual Beli Aset
                    </h2>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Ubah nilai di bawah untuk menyesuaikan isi
                        surat perjanjian secara langsung.</p>
                </div>
                <div class="flex flex-wrap items-center gap-2">
                    <button @click="copyPreview()"
                        class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-sky-50 dark:bg-sky-950/50 hover:bg-sky-100 text-sky-600 dark:text-sky-400 text-xs font-bold uppercase tracking-wider transition-colors shadow-xs">
                        <i class="fa-solid fa-copy text-xs"></i> Salin Teks
                    </button>
                    <button @click="reset()"
                        class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 text-xs font-bold uppercase tracking-wider transition-colors shadow-xs">
                        <i class="fa-solid fa-rotate-left text-xs"></i> Reset
                    </button>
                    <button @click="exportPDF()"
                        class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-700 text-xs font-bold uppercase tracking-wider transition-colors shadow-xs">
                        <i class="fa-solid fa-file-pdf text-xs"></i> Export PDF
                    </button>
                    <button @click="exportWord()"
                        class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-indigo-50 hover:bg-indigo-100 text-indigo-700 text-xs font-bold uppercase tracking-wider transition-colors shadow-xs">
                        <i class="fa-solid fa-file-word text-xs"></i> Export Word
                    </button>
                    <button onclick="window.print()"
                        class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-amber-500 hover:bg-amber-600 text-slate-950 text-xs font-bold uppercase tracking-wider transition-colors shadow-sm">
                        <i class="fa-solid fa-print text-xs"></i> Cetak PDF
                    </button>
                </div>
            </div>

            <div class="space-y-5">
                <!-- Informasi Umum Surat -->
                <fieldset class="border border-gray-200 dark:border-gray-700 rounded-xl p-4">
                    <legend class="px-2 text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                        Informasi Umum Surat</legend>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 pt-2">
                        <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Nomor
                                Surat</label><input type="text" x-model="nomorSurat"
                                class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition">
                        </div>
                        <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Hari
                                TTD</label><input type="text" x-model="hariTtd"
                                class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition">
                        </div>
                        <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Tanggal
                                TTD</label><input type="text" x-model="tanggalTtd"
                                class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition">
                        </div>
                        <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Kota
                                TTD</label><input type="text" x-model="kotaTtd"
                                class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition">
                        </div>
                    </div>
                </fieldset>

                <!-- Pihak Pertama (Penjual) -->
                <fieldset class="border border-gray-200 dark:border-gray-700 rounded-xl p-4">
                    <legend class="px-2 text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">Pihak
                        Pertama (Penjual)</legend>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 pt-2">
                        <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Nama
                                Lengkap</label><input type="text" x-model="namaP1"
                                class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition">
                        </div>
                        <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">No. KTP /
                                NIK</label><input type="text" x-model="nikP1"
                                class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition">
                        </div>
                        <div><label
                                class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Pekerjaan</label><input
                                type="text" x-model="pekerjaanP1"
                                class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition">
                        </div>
                        <div class="md:col-span-2"><label
                                class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Alamat
                                Lengkap</label><input type="text" x-model="alamatP1"
                                class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition">
                        </div>
                        <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">No. Telepon /
                                HP</label><input type="text" x-model="telpP1"
                                class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition">
                        </div>
                    </div>
                </fieldset>

                <!-- Pihak Kedua (Pembeli) -->
                <fieldset class="border border-gray-200 dark:border-gray-700 rounded-xl p-4">
                    <legend class="px-2 text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">Pihak
                        Kedua (Pembeli)</legend>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 pt-2">
                        <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Nama
                                Lengkap</label><input type="text" x-model="namaP2"
                                class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition">
                        </div>
                        <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">No. KTP /
                                NIK</label><input type="text" x-model="nikP2"
                                class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition">
                        </div>
                        <div><label
                                class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Pekerjaan</label><input
                                type="text" x-model="pekerjaanP2"
                                class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition">
                        </div>
                        <div class="md:col-span-2"><label
                                class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Alamat
                                Lengkap</label><input type="text" x-model="alamatP2"
                                class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition">
                        </div>
                        <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">No. Telepon /
                                HP</label><input type="text" x-model="telpP2"
                                class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition">
                        </div>
                    </div>
                </fieldset>

                <!-- Kategori & Detail Objek Aset -->
                <fieldset class="border border-gray-200 dark:border-gray-700 rounded-xl p-4">
                    <legend class="px-2 text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">Objek &
                        Kategori Aset</legend>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 pt-2 mb-4">
                        <div class="md:col-span-3">
                            <label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Pilih Kategori
                                Aset</label>
                            <select x-model="kategoriAset"
                                class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition">
                                <option value="tanah">Tanah / Properti</option>
                                <option value="kendaraan">Kendaraan Bermotor</option>
                                <option value="lainnya">Aset Lainnya (Mesin / Peralatan / Inventaris)</option>
                            </select>
                        </div>
                    </div>

                    <!-- Input Khusus Kategori Tanah -->
                    <div x-show="kategoriAset === 'tanah'"
                        class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 pt-2">
                        <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Jenis & Nomor
                                Alas Hak</label><input type="text" x-model="tanahHak"
                                class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition">
                        </div>
                        <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Luas Tanah /
                                Bangunan</label><input type="text" x-model="tanahLuas"
                                class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition">
                        </div>
                        <div class="md:col-span-1"><label
                                class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Alamat / Lokasi
                                Properti</label><input type="text" x-model="tanahLokasi"
                                class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition">
                        </div>
                        <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Batas
                                Utara</label><input type="text" x-model="tanahUtara"
                                class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition">
                        </div>
                        <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Batas
                                Selatan</label><input type="text" x-model="tanahSelatan"
                                class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition">
                        </div>
                        <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Batas
                                Timur</label><input type="text" x-model="tanahTimur"
                                class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition">
                        </div>
                        <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Batas
                                Barat</label><input type="text" x-model="tanahBarat"
                                class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition">
                        </div>
                    </div>

                    <!-- Input Khusus Kategori Kendaraan -->
                    <div x-show="kategoriAset === 'kendaraan'"
                        class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 pt-2">
                        <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Merek / Tipe /
                                Jenis</label><input type="text" x-model="kendaraanMerek"
                                class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition">
                        </div>
                        <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Tahun Pembuatan
                                / Warna</label><input type="text" x-model="kendaraanTahunWarna"
                                class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition">
                        </div>
                        <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Nomor Polisi
                                (Plat)</label><input type="text" x-model="kendaraanPlat"
                                class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition">
                        </div>
                        <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Nomor Rangka /
                                No. Mesin</label><input type="text" x-model="kendaraanRangkaMesin"
                                class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition">
                        </div>
                        <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">No. BPKB / STNK
                                & Atas Nama</label><input type="text" x-model="kendaraanSurat"
                                class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition">
                        </div>
                    </div>

                    <!-- Input Khusus Kategori Lainnya -->
                    <div x-show="kategoriAset === 'lainnya'"
                        class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 pt-2">
                        <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Nama Barang /
                                Merek</label><input type="text" x-model="lainNama"
                                class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition">
                        </div>
                        <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Spesifikasi /
                                Nomor Seri</label><input type="text" x-model="lainSeri"
                                class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition">
                        </div>
                        <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Jumlah &
                                Kondisi</label><input type="text" x-model="lainKondisi"
                                class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition">
                        </div>
                    </div>
                </fieldset>

                <!-- Harga & Skema Pembayaran -->
                <fieldset class="border border-gray-200 dark:border-gray-700 rounded-xl p-4">
                    <legend class="px-2 text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">Harga,
                        Pembayaran & Sengketa</legend>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 pt-2">
                        <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Harga Total
                                (Rp)</label><input type="text" x-model="hargaTotal"
                                class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition">
                        </div>
                        <div class="md:col-span-2"><label
                                class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Terbilang
                                Harga</label><input type="text" x-model="terbilangHarga"
                                class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition">
                        </div>
                        <div class="md:col-span-3"><label
                                class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Keterangan Skema
                                Pembayaran</label><input type="text" x-model="skemaPembayaran"
                                class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition">
                        </div>
                        <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Nama Saksi
                                I</label><input type="text" x-model="saksi1"
                                class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition">
                        </div>
                        <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Nama Saksi
                                II</label><input type="text" x-model="saksi2"
                                class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition">
                        </div>
                        <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Pengadilan
                                Negeri (Penyelesaian)</label><input type="text" x-model="pengadilanNegeri"
                                class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition">
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>

        <!-- Bagian Textarea Pratinjau & Edit Dokumen -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700/80 p-8 shadow-sm">
            <div
                class="mb-4 pb-3 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between no-print">
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider"><i
                        class="fa-solid fa-file-lines mr-1.5"></i> Textarea Pratinjau & Edit Dokumen Perjanjian Jual Beli
                    Aset</span>
                <span
                    class="text-[11px] text-emerald-600 dark:text-emerald-400 font-semibold bg-emerald-50 dark:bg-emerald-950/50 px-2.5 py-1 rounded-lg border border-emerald-200/50">Sinkronisasi
                    & Edit Manual Aktif</span>
            </div>

            <textarea x-ref="preview" x-model="kontenSurat" rows="24"
                class="preview-card w-full bg-slate-900 text-slate-100 dark:bg-gray-950 dark:text-gray-100 rounded-xl p-6 font-mono text-sm leading-relaxed shadow-inner border border-gray-700 focus:ring-2 focus:ring-brand-500 outline-none resize-y transition"></textarea>
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('suratJualBeliAsetForm', () => ({
                nomorSurat: '030/SPJBA/VIII/2026',
                hariTtd: 'Rabu',
                tanggalTtd: '12 Agustus 2026',
                kotaTtd: 'Makassar',

                namaP1: 'Ahmad Fauzi, S.E.',
                nikP1: '7371011203880001',
                pekerjaanP1: 'Direktur Utama PT Maharadja Cipta Karya',
                alamatP1: 'Jl. AP Pettarani No. 45, Makassar',
                telpP1: '0811-4123-4567',

                namaP2: 'Rahmat Hidayat, S.Kom.',
                nikP2: '7371021508900003',
                pekerjaanP2: 'Pengelola Barbersole Studio',
                alamatP2: 'Jl. Perintis Kemerdekaan Km. 10, Makassar',
                telpP2: '0852-9988-7766',

                kategoriAset: 'kendaraan',

                // Properti Tanah
                tanahHak: 'Sertifikat Hak Milik (SHM) No. 9876/Tamamaung',
                tanahLuas: '250 m²',
                tanahLokasi: 'Jl. Pengayoman No. 15, Makassar',
                tanahUtara: 'Tanah Bpk. Rahman',
                tanahSelatan: 'Jalan Kompleks',
                tanahTimur: 'Ruko Ibu Siska',
                tanahBarat: 'Pekarangan Kosong',

                // Properti Kendaraan
                kendaraanMerek: 'Toyota Innova Zenix Q Hybrid',
                kendaraanTahunWarna: '2024 / Hitam Metalik',
                kendaraanPlat: 'DD 1234 XX',
                kendaraanRangkaMesin: 'MHF12345678 / M20A-FXS',
                kendaraanSurat: 'BPKB No. B-9876543 & STNK a.n. Ahmad Fauzi',

                // Properti Lainnya
                lainNama: 'Mesin Potong Kayu Otomatis / Hitachi C10RJ',
                lainSeri: 'SN-99887765-HIT',
                lainKondisi: '2 Unit / Berfungsi Normal & Baik',

                hargaTotal: '450.000.000',
                terbilangHarga: 'Empat Ratus Lima Puluh Juta Rupiah',
                skemaPembayaran: 'Lunas sekaligus pada saat penandatanganan melalui transfer bank ke Bank Mandiri a.n. Ahmad Fauzi',

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
                        'kategoriAset', 'tanahHak', 'tanahLuas', 'tanahLokasi', 'tanahUtara',
                        'tanahSelatan', 'tanahTimur', 'tanahBarat',
                        'kendaraanMerek', 'kendaraanTahunWarna', 'kendaraanPlat',
                        'kendaraanRangkaMesin', 'kendaraanSurat',
                        'lainNama', 'lainSeri', 'lainKondisi',
                        'hargaTotal', 'terbilangHarga', 'skemaPembayaran', 'saksi1', 'saksi2',
                        'pengadilanNegeri'
                    ];

                    fields.forEach(field => {
                        this.$watch(field, () => this.updateSurat());
                    });
                },

                updateSurat() {
                    let detailObjekText = '';
                    if (this.kategoriAset === 'tanah') {
                        detailObjekText = `KATEGORI TANAH / PROPERTI:
- Jenis Alas Hak: ${this.tanahHak}
- Luas Tanah / Bangunan: ${this.tanahLuas}
- Alamat / Lokasi: ${this.tanahLokasi}
- Batas-Batas: 
    Utara   :${this.tanahUtara},
    Selatan :${this.tanahSelatan}, 
    Timur   :${this.tanahTimur}, 
    Barat   :${this.tanahBarat}`;
                    } else if (this.kategoriAset === 'kendaraan') {
                        detailObjekText = `KATEGORI KENDARAAN BERMOTOR:
- Merek / Tipe / Jenis: ${this.kendaraanMerek}
- Tahun Pembuatan / Warna: ${this.kendaraanTahunWarna}
- Nomor Polisi (Plat): ${this.kendaraanPlat}
- Nomor Rangka / Nomor Mesin: ${this.kendaraanRangkaMesin}
- Nomor BPKB / STNK: ${this.kendaraanSurat}`;
                    } else {
                        detailObjekText = `KATEGORI ASET LAINNYA (MESIN / PERALATAN / INVENTARIS):
- Nama Barang / Merek: ${this.lainNama}
- Spesifikasi / Nomor Seri: ${this.lainSeri}
- Jumlah / Kondisi: ${this.lainKondisi}`;
                    }

                    this.kontenSurat = `SURAT PERJANJIAN JUAL BELI ASET
Nomor: ${this.nomorSurat}

Pada hari ini, ${this.hariTtd} tanggal ${this.tanggalTtd}, bertempat di ${this.kotaTtd}, kami yang bertanda tangan di bawah ini:

1. Nama Lengkap   : ${this.namaP1}
   No. KTP / NIK  : ${this.nikP1}
   Pekerjaan      : ${this.pekerjaanP1}
   Alamat Lengkap : ${this.alamatP1}
   No. Telepon / HP: ${this.telpP1}
Dalam hal ini bertindak sebagai pemilik sah atas objek jual beli, yang selanjutnya disebut sebagai PIHAK PERTAMA (PENJUAL).

2. Nama Lengkap   : ${this.namaP2}
   No. KTP / NIK  : ${this.nikP2}
   Pekerjaan      : ${this.pekerjaanP2}
   Alamat Lengkap : ${this.alamatP2}
   No. Telepon / HP: ${this.telpP2}
In hal ini bertindak sebagai pembeli, yang selanjutnya disebut sebagai PIHAK KEDUA (PEMBELI).

Para Pihak terlebih dahulu menerangkan bahwa PIHAK PERTAMA bermaksud menjual aset milik sah PIHAK PERTAMA kepada PIHAK KEDUA, dan PIHAK KEDUA sepakat untuk membeli aset tersebut dengan syarat dan ketentuan sebagai berikut:

PASAL 1
OBJEK JUAL BELI
PIHAK PERTAMA menjual kepada PIHAK KEDUA sebuah aset dengan rincian identifikasi sebagai berikut:

${detailObjekText}

PASAL 2
HARGA DAN SKEMA PEMBAYARAN
1. Jual beli aset ini disepakati dengan harga total sebesar Rp ${this.hargaTotal},- (${this.terbilangHarga}).
2. Sistem pembayaran disepakati secara: ${this.skemaPembayaran}.
3. Surat Perjanjian ini berlaku sekaligus sebagai bukti tanda terima pembayaran resmi (Kuitansi) setelah dana diterima lunas oleh PIHAK PERTAMA.

PASAL 3
JAMINAN KEBASAN ASET DAN LEGALITAS
PIHAK PERTAMA menjamin sepenuhnya bahwa aset yang dijual kepada PIHAK KEDUA:
1. Merupakan hak milik sah PIHAK PERTAMA dan bebas dari segala tuntutan atau klaim hak dari pihak ketiga.
2. Tidak sedang dijadikan jaminan utang, digadaikan, atau berada dalam sitaan hukum/sengketa.
3. Memiliki kelengkapan dokumen kepemilikan asli yang sah sesuai hukum yang berlaku.

PASAL 4
PENYERAHAN ASET DAN BALIK NAMA / ALIH HAK
1. Penyerahan fisik aset beserta seluruh dokumen kepemilikan asli (Sertifikat / BPKB & STNK / Nota Pembelian) dilakukan oleh PIHAK PERTAMA kepada PIHAK KEDUA segera setelah pelunasan pembayaran diterima.
2. PIHAK PERTAMA bersedia memberikan bantuan teknis dan administratif yang diperlukan untuk proses balik nama, penandatanganan Akta Jual Beli (AJB/Notaris), atau proses alih kepemilikan resmi atas nama PIHAK KEDUA.
3. Segala biaya balik nama dan pajak pembeli menjadi tanggung jawab PIHAK KEDUA, sedangkan pajak penjual/penjualan Aset (jika ada) menjadi tanggung jawab PIHAK PERTAMA.

PASAL 5
PENYELESAIAN SENGKETA
1. Segala perselisihan yang timbul mengenai pelaksanaan Perjanjian ini akan diselesaikan secara musyawarah untuk mufakat.
2. Apabila musyawarah tidak mencapai mufakat, Para Pihak sepakat untuk menyelesaikan permasalahan hukum melalui Kantor Kepaniteraan Pengadilan Negeri ${this.pengadilanNegeri}.

PASAL 6
PENUTUP
Demikian Surat Perjanjian Jual Beli Aset ini dibuat dalam rangkap 2 (dua) bermaterai cukup, yang masing-masing mempunyai kekuatan hukum yang sama dan berlaku sejak ditandatangani oleh Para Pihak secara sadar tanpa ada paksaan dari pihak mana pun.


PIHAK PERTAMA (PENJUAL)                     PIHAK KEDUA (PEMBELI)


[ Materai Rp 10.000 ]                       [ Materai Rp 10.000 ]



(${this.namaP1})                            (${this.namaP2})



SAKSI-SAKSI:

(${this.saksi1})                            (${this.saksi2})
Saksi I                                     Saksi II`;
                },

                reset() {
                    this.nomorSurat = '030/SPJBA/VIII/2026';
                    this.hariTtd = 'Rabu';
                    this.tanggalTtd = '12 Agustus 2026';
                    this.kotaTtd = 'Makassar';
                    this.namaP1 = 'Ahmad Fauzi, S.E.';
                    this.nikP1 = '7371011203880001';
                    this.pekerjaanP1 = 'Direktur Utama PT Maharadja Cipta Karya';
                    this.alamatP1 = 'Jl. AP Pettarani No. 45, Makassar';
                    this.telpP1 = '0811-4123-4567';
                    this.namaP2 = 'Rahmat Hidayat, S.Kom.';
                    this.nikP2 = '7371021508900003';
                    this.pekerjaanP2 = 'Pengelola Barbersole Studio';
                    this.alamatP2 = 'Jl. Perintis Kemerdekaan Km. 10, Makassar';
                    this.telpP2 = '0852-9988-7766';
                    this.kategoriAset = 'kendaraan';
                    this.tanahHak = 'Sertifikat Hak Milik (SHM) No. 9876/Tamamaung';
                    this.tanahLuas = '250 m²';
                    this.tanahLokasi = 'Jl. Pengayoman No. 15, Makassar';
                    this.tanahUtara = 'Tanah Bpk. Rahman';
                    this.tanahSelatan = 'Jalan Kompleks';
                    this.tanahTimur = 'Ruko Ibu Siska';
                    this.tanahBarat = 'Pekarangan Kosong';
                    this.kendaraanMerek = 'Toyota Innova Zenix Q Hybrid';
                    this.kendaraanTahunWarna = '2024 / Hitam Metalik';
                    this.kendaraanPlat = 'DD 1234 XX';
                    this.kendaraanRangkaMesin = 'MHF12345678 / M20A-FXS';
                    this.kendaraanSurat = 'BPKB No. B-9876543 & STNK a.n. Ahmad Fauzi';
                    this.lainNama = 'Mesin Potong Kayu Otomatis / Hitachi C10RJ';
                    this.lainSeri = 'SN-99887765-HIT';
                    this.lainKondisi = '2 Unit / Berfungsi Normal & Baik';
                    this.hargaTotal = '450.000.000';
                    this.terbilangHarga = 'Empat Ratus Lima Puluh Juta Rupiah';
                    this.skemaPembayaran =
                        'Lunas sekaligus pada saat penandatanganan melalui transfer bank ke Bank Mandiri a.n. Ahmad Fauzi';
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
                    const html =
                        `<html><head><meta charset="utf-8">${styles}</head><body><pre>${this.escapeHtml(content)}</pre></body></html>`;
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
                    if (this.kategoriAset === 'tanah') {
                        detailObjekHtml =
                            `<b>KATEGORI TANAH / PROPERTI</b><br>
                - Jenis Alas Hak: ${esc(this.tanahHak)}<br>
                - Luas Tanah / Bangunan: ${esc(this.tanahLuas)}<br>
                - Alamat / Lokasi: ${esc(this.tanahLokasi)}<br>
                - Batas-Batas: Utara (${esc(this.tanahUtara)}), Selatan (${esc(this.tanahSelatan)}), Timur (${esc(this.tanahTimur)}), Barat (${esc(this.tanahBarat)})`;
                    } else if (this.kategoriAset === 'kendaraan') {
                        detailObjekHtml = `<b>KATEGORI KENDARAAN BERMOTOR</b><br>
                - Merek / Tipe / Jenis: ${esc(this.kendaraanMerek)}<br>
                - Tahun Pembuatan / Warna: ${esc(this.kendaraanTahunWarna)}<br>
                - Nomor Polisi (Plat): ${esc(this.kendaraanPlat)}<br>
                - Nomor Rangka / Nomor Mesin: ${esc(this.kendaraanRangkaMesin)}<br>
                - Nomor BPKB / STNK: ${esc(this.kendaraanSurat)}`;
                    } else {
                        detailObjekHtml = `<b>KATEGORI ASET LAINNYA (MESIN / PERALATAN / INVENTARIS)</b><br>
                - Nama Barang / Merek: ${esc(this.lainNama)}<br>
                - Spesifikasi / Nomor Seri: ${esc(this.lainSeri)}<br>
                - Jumlah / Kondisi: ${esc(this.lainKondisi)}`;
                    }

                    const styles = `
                <style>
                    @page { size: A4; margin: 24mm }
                    body { font-family: 'Times New Roman', Georgia, serif; color:#111; }
                    h4.pasal { font-size:12pt; margin-top:1rem; margin-bottom:0.25rem; text-align:center }
                    p { text-align:justify; font-size:11pt; line-height:1.6 }
                </style>`;

                    const html = `<!doctype html><html><head><meta charset="utf-8">${styles}</head><body>
                <h4 style="text-align:center">SURAT PERJANJIAN JUAL BELI ASET</h4>
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
                <p>Dalam hal ini bertindak sebagai pemilik sah atas objek jual beli, yang selanjutnya disebut sebagai <strong>PIHAK PERTAMA (PENJUAL)</strong>.</p>

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
                <p>Dalam hal ini bertindak sebagai pembeli, yang selanjutnya disebut sebagai <strong>PIHAK KEDUA (PEMBELI)</strong>.</p>

                <p>Para Pihak terlebih dahulu menerangkan bahwa PIHAK PERTAMA bermaksud menjual aset milik sah PIHAK PERTAMA kepada PIHAK KEDUA, dan PIHAK KEDUA sepakat untuk membeli aset tersebut dengan syarat dan ketentuan sebagai berikut:</p>

                <h4 class="pasal">PASAL 1<br>OBJEK JUAL BELI</h4>
                <p>PIHAK PERTAMA menjual kepada PIHAK KEDUA sebuah aset dengan rincian identifikasi sebagai berikut:</p>
                <div style="margin-left:1rem; font-size:11pt; line-height:1.6">${detailObjekHtml}</div>

                <h4 class="pasal">PASAL 2<br>HARGA DAN SKEMA PEMBAYARAN</h4>
                <ol style="font-size:11pt; line-height:1.6">
                    <li>Jual beli aset ini disepakati dengan harga total sebesar Rp ${esc(this.hargaTotal)},- (${esc(this.terbilangHarga)}).</li>
                    <li>Sistem pembayaran disepakati secara: ${esc(this.skemaPembayaran)}.</li>
                    <li>Surat Perjanjian ini berlaku sekaligus sebagai bukti tanda terima pembayaran resmi (Kuitansi) setelah dana diterima lunas oleh PIHAK PERTAMA.</li>
                </ol>

                <h4 class="pasal">PASAL 3<br>JAMINAN KEBASAN ASET DAN LEGALITAS</h4>
                <p>PIHAK PERTAMA menjamin sepenuhnya bahwa aset yang dijual kepada PIHAK KEDUA:</p>
                <ol style="font-size:11pt; line-height:1.6">
                    <li>Merupakan hak milik sah PIHAK PERTAMA dan bebas dari segala tuntutan atau klaim hak dari pihak ketiga.</li>
                    <li>Tidak sedang dijadikan jaminan utang, digadaikan, atau berada dalam sitaan hukum/sengketa.</li>
                    <li>Memiliki kelengkapan dokumen kepemilikan asli yang sah sesuai hukum yang berlaku.</li>
                </ol>

                <h4 class="pasal">PASAL 4<br>PENYERAHAN ASET DAN BALIK NAMA / ALIH HAK</h4>
                <ol style="font-size:11pt; line-height:1.6">
                    <li>Penyerahan fisik aset beserta seluruh dokumen kepemilikan asli (Sertifikat / BPKB & STNK / Nota Pembelian) dilakukan oleh PIHAK PERTAMA kepada PIHAK KEDUA segera setelah pelunasan pembayaran diterima.</li>
                    <li>PIHAK PERTAMA bersedia memberikan bantuan teknis dan administratif yang diperlukan untuk proses balik nama, penandatanganan Akta Jual Beli (AJB/Notaris), atau proses alih kepemilikan resmi atas nama PIHAK KEDUA.</li>
                    <li>Segala biaya balik nama dan pajak pembeli menjadi tanggung jawab PIHAK KEDUA, sedangkan pajak penjual/penjualan Aset (jika ada) menjadi tanggung jawab PIHAK PERTAMA.</li>
                </ol>

                <h4 class="pasal">PASAL 5<br>PENYELESAIAN SENGKETA</h4>
                <ol style="font-size:11pt; line-height:1.6">
                    <li>Segala perselisihan yang timbul mengenai pelaksanaan Perjanjian ini akan diselesaikan secara musyawarah untuk mufakat.</li>
                    <li>Apabila musyawarah tidak mencapai mufakat, Para Pihak sepakat untuk menyelesaikan permasalahan hukum melalui Kantor Kepaniteraan Pengadilan Negeri ${esc(this.pengadilanNegeri)}.</li>
                </ol>

                <h4 class="pasal">PASAL 6<br>PENUTUP</h4>
                <p>Demikian Surat Perjanjian Jual Beli Aset ini dibuat dalam rangkap 2 (dua) bermaterai cukup, yang masing-masing mempunyai kekuatan hukum yang sama dan berlaku sejak ditandatangani oleh Para Pihak secara sadar tanpa ada paksaan dari pihak mana pun.</p>

                <br>
                <table style="width:100%; margin-bottom:2rem; text-align:justify">
                    <tr>
                        <th style="width:50%; vertical-align:top; text-align:center">PIHAK PERTAMA (PENJUAL)</th>
                        <th style="width:50%; vertical-align:top; text-align:center">PIHAK KEDUA (PEMBELI)</th>
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
                        <td style="width:50%; vertical-align:top; text-align:center">(${esc(this.saksi1)})<br>Saksi I</td>
                        <td style="width:50%; vertical-align:top; text-align:center">(${esc(this.saksi2)})<br>Saksi II</td>
                    </tr>
                </table>
            </body></html>`;

                    return html;
                },

                exportWord() {
                    const htmlContent = this.buildHtmlDocument();
                    const blob = new Blob(['\ufeff', htmlContent], {
                        type: 'application/msword'
                    });
                    const url = URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    a.href = url;
                    const filename = (this.nomorSurat || 'surat-perjanjian-jual-beli-aset').replace(
                        /[^a-z0-9\-_.]/gi, '_') + '.doc';
                    a.download = filename;
                    document.body.appendChild(a);
                    a.click();
                    setTimeout(() => {
                        URL.revokeObjectURL(url);
                        a.remove();
                    }, 1500);
                }
            }));
        });
    </script>
@endsection
