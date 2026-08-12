@extends('layouts.admin')

@section('title', 'Draf Surat Perjanjian Hutang Piutang')
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

    <div class="space-y-6" x-data="hutangPiutangForm()">

        <!-- Bagian Form Input Variable -->
        <div
            class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700/80 p-6 shadow-sm no-print space-y-5">
            <div
                class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-gray-100 dark:border-gray-700 pb-4">
                <div>
                    <h2 class="text-base font-bold text-gray-900 dark:text-white">Variabel Dokumen Hutang Piutang</h2>
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

                <!-- Pihak Pertama (Pemberi Pinjaman) -->
                <fieldset class="border border-gray-200 dark:border-gray-700 rounded-xl p-4">
                    <legend class="px-2 text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">Pihak
                        Pertama (Pemberi Pinjaman)</legend>
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
                                class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Alamat</label><input
                                type="text" x-model="alamatP1"
                                class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition">
                        </div>
                        <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">No. Telepon /
                                HP</label><input type="text" x-model="telpP1"
                                class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition">
                        </div>
                    </div>
                </fieldset>

                <!-- Pihak Kedua (Penerima Pinjaman) -->
                <fieldset class="border border-gray-200 dark:border-gray-700 rounded-xl p-4">
                    <legend class="px-2 text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">Pihak
                        Kedua (Penerima Pinjaman)</legend>
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
                                class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Alamat</label><input
                                type="text" x-model="alamatP2"
                                class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition">
                        </div>
                        <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">No. Telepon /
                                HP</label><input type="text" x-model="telpP2"
                                class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition">
                        </div>
                    </div>
                </fieldset>

                <!-- Rincian Pinjaman & Pembayaran -->
                <fieldset class="border border-gray-200 dark:border-gray-700 rounded-xl p-4">
                    <legend class="px-2 text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">Rincian
                        Pinjaman & Pembayaran</legend>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 pt-2">
                        <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Jumlah Pinjaman
                                (Rp)</label><input type="text" x-model="jumlahPinjaman"
                                class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition">
                        </div>
                        <div class="md:col-span-2"><label
                                class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Terbilang
                                (Rupiah)</label><input type="text" x-model="terbilangPinjaman"
                                class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition">
                        </div>
                        <div class="md:col-span-3"><label
                                class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Tujuan
                                Pinjaman</label><input type="text" x-model="tujuanPinjaman"
                                class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Cara Penyerahan
                                Dana</label>
                            <select x-model="caraPenyerahan"
                                class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition">
                                <option value="Tunai">Tunai</option>
                                <option value="Transfer Bank">Transfer Bank</option>
                            </select>
                        </div>
                        <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Nama
                                Bank</label><input type="text" x-model="namaBank"
                                class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition">
                        </div>
                        <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Nomor
                                Rekening</label><input type="text" x-model="noRekening"
                                class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition">
                        </div>
                        <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Atas Nama
                                Rekening</label><input type="text" x-model="atasNamaRek"
                                class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition">
                        </div>
                        <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Tanggal Jatuh
                                Tempo Pelunasan</label><input type="text" x-model="tglJatuhTempo"
                                class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Cara
                                Pembayaran</label>
                            <select x-model="caraPembayaran"
                                class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition">
                                <option value="Sekaligus Lunas">Sekaligus Lunas</option>
                                <option value="Angsuran">Angsuran</option>
                            </select>
                        </div>
                    </div>
                </fieldset>

                <!-- Jaminan & Saksi -->
                <fieldset class="border border-gray-200 dark:border-gray-700 rounded-xl p-4">
                    <legend class="px-2 text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                        Jaminan & Saksi</legend>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 pt-2">
                        <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Jenis
                                Jaminan</label><input type="text" x-model="jenisJaminan"
                                class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition">
                        </div>
                        <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Deskripsi / No.
                                Dokumen</label><input type="text" x-model="deskripsiJaminan"
                                class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition">
                        </div>
                        <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Jaminan Atas
                                Nama</label><input type="text" x-model="atasNamaJaminan"
                                class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition">
                        </div>
                        <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Pengadilan
                                Negeri (Penyelesaian)</label><input type="text" x-model="pengadilanNegeri"
                                class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition">
                        </div>
                        <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Nama Saksi
                                1</label><input type="text" x-model="saksi1"
                                class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition">
                        </div>
                        <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Nama Saksi
                                2</label><input type="text" x-model="saksi2"
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
                        class="fa-solid fa-file-lines mr-1.5"></i> Textarea Pratinjau & Edit Dokumen Hutang Piutang</span>
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
            Alpine.data('hutangPiutangForm', () => ({
                nomorSurat: '042 / SPHP / JKT / 2026',
                hariTtd: 'Jumat',
                tanggalTtd: '24 Juli 2026',
                kotaTtd: 'Jakarta Selatan',

                namaP1: 'H. Ahmad Subarjo, S.E.',
                nikP1: '3171011234560001',
                pekerjaanP1: 'Pengusaha / Wiraswasta',
                alamatP1: 'Jl. Melati No. 12 RT 004/002, Kel. Tebet Timur, Jakarta Selatan',
                telpP1: '081298765432',

                namaP2: 'Siti Rahmawati, S.Pd.',
                nikP2: '3174059876540003',
                pekerjaanP2: 'Pegawai Swasta',
                alamatP2: 'Jl. Kenanga Blok A5 No. 8, Kel. Kalibata, Jakarta Selatan',
                telpP2: '085612345678',

                jumlahPinjaman: '25.000.000',
                terbilangPinjaman: 'Dua Puluh Lima Juta Rupiah',
                tujuanPinjaman: 'Keperluan tambahan modal usaha perdagangan pakaian dan pengembangan toko',
                caraPenyerahan: 'Transfer Bank',
                namaBank: 'BCA',
                noRekening: '8830123456',
                atasNamaRek: 'Siti Rahmawati',
                tglJatuhTempo: '24 Januari 2027',
                caraPembayaran: 'Sekaligus Lunas',

                jenisJaminan: 'BPKB Kendaraan Bermotor (Mobil)',
                deskripsiJaminan: 'Mobil Toyota Avanza / BPKB No. M-0981234 / Tahun 2018',
                atasNamaJaminan: 'Siti Rahmawati',
                pengadilanNegeri: 'Jakarta Selatan',
                saksi1: 'Drs. Bambang Pamungkas',
                saksi2: 'Muhammad Fikri, S.Kom.',

                kontenSurat: '',

                init() {
                    const initial = JSON.parse(@json(json_encode($initialData ?? [])));
                    for (const key in initial) {
                        if (this.hasOwnProperty(key)) {
                            this[key] = initial[key];
                        }
                    }

                    this.updateSurat();

                    const fields = [
                        'nomorSurat', 'hariTtd', 'tanggalTtd', 'kotaTtd',
                        'namaP1', 'nikP1', 'pekerjaanP1', 'alamatP1', 'telpP1',
                        'namaP2', 'nikP2', 'pekerjaanP2', 'alamatP2', 'telpP2',
                        'jumlahPinjaman', 'terbilangPinjaman', 'tujuanPinjaman', 'caraPenyerahan',
                        'namaBank', 'noRekening', 'atasNamaRek', 'tglJatuhTempo', 'caraPembayaran',
                        'jenisJaminan', 'deskripsiJaminan', 'atasNamaJaminan', 'pengadilanNegeri',
                        'saksi1', 'saksi2'
                    ];

                    fields.forEach(field => {
                        this.$watch(field, () => this.updateSurat());
                    });
                },

                updateSurat() {
                    this.kontenSurat = `SURAT PERJANJIAN HUTANG PIUTANG
Nomor: ${this.nomorSurat}

Pada hari ini, ${this.hariTtd}, tanggal ${this.tanggalTtd}, bertempat di ${this.kotaTtd}, kami yang bertanda tangan di bawah ini:

PIHAK PERTAMA (Pemberi Pinjaman):
Nama Lengkap      : ${this.namaP1}
No. KTP / NIK     : ${this.nikP1}
Pekerjaan         : ${this.pekerjaanP1}
Alamat            : ${this.alamatP1}
No. Telepon / HP  : ${this.telpP1}
Selanjutnya dalam perjanjian ini disebut sebagai PIHAK PERTAMA.

PIHAK KEDUA (Penerima Pinjaman):
Nama Lengkap      : ${this.namaP2}
No. KTP / NIK     : ${this.nikP2}
Pekerjaan         : ${this.pekerjaanP2}
Alamat            : ${this.alamatP2}
No. Telepon / HP  : ${this.telpP2}
Selanjutnya dalam perjanjian ini disebut sebagai PIHAK KEDUA.

Para Pihak terlebih dahulu menerangkan bahwa PIHAK PERTAMA telah setuju untuk memberikan pinjaman uang tunai kepada PIHAK KEDUA, dan PIHAK KEDUA telah setuju menerima pinjaman tersebut dari PIHAK PERTAMA dengan ketentuan dan syarat-syarat yang diatur dalam pasal-pasal berikut:

PASAL 1
JUMLAH PINJAMAN
PIHAK PERTAMA memberikan pinjaman dana berupa uang tunai kepada PIHAK KEDUA sebesar Rp ${this.jumlahPinjaman},- (${this.terbilangPinjaman}).

PASAL 2
TUJUAN PINJAMAN & PENYERAHAN DANA
1. Pinjaman ini digunakan oleh PIHAK KEDUA untuk keperluan: ${this.tujuanPinjaman}.
2. Penyerahan dana dilakukan secara ${this.caraPenyerahan} pada tanggal ${this.tanggalTtd} ke rekening berikut:
   - Nama Bank     : ${this.namaBank}
   - No. Rekening  : ${this.noRekening}
   - Atas Nama     : ${this.atasNamaRek}
3. Surat perjanjian ini sekaligus berlaku sebagai tanda bukti penerimaan uang (Kwitansi) yang sah atas penyerahan dana tersebut.

PASAL 3
JANGKA WAKTU & CARA PEMBAYARAN
1. PIHAK KEDUA berjanji dan mengikatkan diri untuk mengembalikan seluruh pinjaman tersebut kepada PIHAK PERTAMA selambat-lambatnya pada tanggal ${this.tglJatuhTempo}.
2. Pengembalian pinjaman dilakukan secara ${this.caraPembayaran}.
3. Jika dilakukan secara angsuran, pembayaran dilakukan sesuai jadwal kesepakatan tertulis terpisah yang menjadi bagian tidak terpisahkan dari perjanjian ini.

PASAL 4
JAMINAN (BILA ADA)
Untuk menjamin pelunasan pinjaman ini, PIHAK KEDUA memberikan jaminan berupa:
- Jenis Jaminan           : ${this.jenisJaminan}
- Deskripsi / No. Dokumen : ${this.deskripsiJaminan}
- Atas Nama               : ${this.atasNamaJaminan}
Jaminan tersebut akan dikembalikan secara utuh oleh PIHAK PERTAMA kepada PIHAK KEDUA segera setelah seluruh hutang dilunasi.

PASAL 5
SANKSI & DENDA KETERLAMBATAN
Apabila PIHAK KEDUA terlambat melakukan pembayaran sesuai dengan tanggal jatuh tempo yang telah disepakati, maka PIHAK KEDUA dikenakan denda keterlambatan sesuai kesepakatan tambahan dari sisa pinjaman yang belum dibayarkan.

PASAL 6
PENYELESAIAN PERSELISIHAN
1. Apabila terjadi perselisihan di kemudian hari yang timbul dari pelaksanaan perjanjian ini, Para Pihak sepakat untuk menyelesaikannya secara musyawarah untuk mufakat.
2. Apabila penyelesaian secara musyawarah tidak mencapai mufakat, maka Para Pihak sepakat untuk menyelesaikan permasalahan ini melalui jalur hukum di Kepaniteraan Pengadilan Negeri ${this.pengadilanNegeri}.

PASAL 7
PENUTUP
Demikian Surat Perjanjian Hutang Piutang ini dibuat dalam rangkap 2 (dua) bermaterai cukup, yang masing-masing mempunyai kekuatan hukum yang sama dan dipegang oleh PIHAK PERTAMA dan PIHAK KEDUA, serta berlaku sejak ditandatangani oleh kedua belah pihak secara sadar tanpa ada paksaan dari pihak manapun.


PIHAK PERTAMA                               PIHAK KEDUA
(Pemberi Pinjaman)                          (Penerima Pinjaman)

[ Materai Rp 10.000 ]                       [ Materai Rp 10.000 ]


(${this.namaP1})                            (${this.namaP2})



Saksi-Saksi:

Saksi 1 (Satu)                              Saksi 2 (Dua)


(${this.saksi1})                            (${this.saksi2})`;
                },

                reset() {
                    this.nomorSurat = '042 / SPHP / JKT / 2026';
                    this.hariTtd = 'Jumat';
                    this.tanggalTtd = '24 Juli 2026';
                    this.kotaTtd = 'Jakarta Selatan';
                    this.namaP1 = 'H. Ahmad Subarjo, S.E.';
                    this.nikP1 = '3171011234560001';
                    this.pekerjaanP1 = 'Pengusaha / Wiraswasta';
                    this.alamatP1 = 'Jl. Melati No. 12 RT 004/002, Kel. Tebet Timur, Jakarta Selatan';
                    this.telpP1 = '081298765432';
                    this.namaP2 = 'Siti Rahmawati, S.Pd.';
                    this.nikP2 = '3174059876540003';
                    this.pekerjaanP2 = 'Pegawai Swasta';
                    this.alamatP2 = 'Jl. Kenanga Blok A5 No. 8, Kel. Kalibata, Jakarta Selatan';
                    this.telpP2 = '085612345678';
                    this.jumlahPinjaman = '25.000.000';
                    this.terbilangPinjaman = 'Dua Puluh Lima Juta Rupiah';
                    this.tujuanPinjaman =
                        'Keperluan tambahan modal usaha perdagangan pakaian dan pengembangan toko';
                    this.caraPenyerahan = 'Transfer Bank';
                    this.namaBank = 'BCA';
                    this.noRekening = '8830123456';
                    this.atasNamaRek = 'Siti Rahmawati';
                    this.tglJatuhTempo = '24 Januari 2027';
                    this.caraPembayaran = 'Sekaligus Lunas';
                    this.jenisJaminan = 'BPKB Kendaraan Bermotor (Mobil)';
                    this.deskripsiJaminan = 'Mobil Toyota Avanza / BPKB No. M-0981234 / Tahun 2018';
                    this.atasNamaJaminan = 'Siti Rahmawati';
                    this.pengadilanNegeri = 'Jakarta Selatan';
                    this.saksi1 = 'Drs. Bambang Pamungkas';
                    this.saksi2 = 'Muhammad Fikri, S.Kom.';

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
                <h4 style="text-align:center">SURAT PERJANJIAN HUTANG PIUTANG</h4>
                <div class="nomor"><strong>Nomor:</strong> ${esc(this.nomorSurat)}</div>

                <p>Pada hari ini, ${esc(this.hariTtd)} tanggal ${esc(this.tanggalTtd)}, bertempat di ${esc(this.kotaTtd)}, kami yang bertanda tangan di bawah ini:</p>
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
                        <td style="width:150px; vertical-align:top">Pekerjaan</td>
                        <td style="width:50px; vertical-align:top">:</td>
                        <td>${esc(this.pekerjaanP1)}</td>
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
                <p style="text-align: justify;">Selanjutnya dalam perjanjian ini disebut sebagai <strong>PIHAK PERTAMA</strong>.</p>

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
                        <td style="width:150px; vertical-align:top">Pekerjaan</td>
                        <td style="width:50px; vertical-align:top">:</td>
                        <td>${esc(this.pekerjaanP2)}</td>
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
                <p style="text-align: justify;">Selanjutnya dalam perjanjian ini disebut sebagai <strong>PIHAK KEDUA</strong>.</p>

                <p style="text-align: justify;">Para Pihak terlebih dahulu menerangkan bahwa PIHAK PERTAMA telah setuju untuk memberikan pinjaman uang tunai kepada PIHAK KEDUA, dan PIHAK KEDUA telah setuju menerima pinjaman tersebut dari PIHAK PERTAMA dengan ketentuan dan syarat-syarat yang diatur dalam pasal-pasal berikut:</p>

                <h4 class="pasal" style="text-align: center;">PASAL 1<br>JUMLAH PINJAMAN</h4>
                <p style="text-align: justify;">PIHAK PERTAMA memberikan pinjaman dana berupa uang tunai kepada PIHAK KEDUA sebesar Rp ${esc(this.jumlahPinjaman)},- (${esc(this.terbilangPinjaman)}).</p>

                <h4 class="pasal" style="text-align: center;">PASAL 2<br>TUJUAN PINJAMAN & PENYERAHAN DANA</h4>
               <ol>
                    <li style="text-align: justify;">Pinjaman ini digunakan oleh PIHAK KEDUA untuk keperluan: ${esc(this.tujuanPinjaman)}.</li>
                    <li style="text-align: justify;">Penyerahan dana dilakukan secara ${esc(this.caraPenyerahan)} pada tanggal ${esc(this.tanggalTtd)} ke rekening berikut:
                        <ul style="list-style-type: none; padding-left: 0; margin-top: 6px;">
                            <li style="display: flex; margin-bottom: 4px;">
                                <span style="width: 120px; font-weight: 500;">Nama Bank</span>
                                <span style="width: 20px; text-align: center;">:</span>
                                <span style="flex: 1;">${esc(this.namaBank)}</span>
                            </li>
                            <li style="display: flex; margin-bottom: 4px;">
                                <span style="width: 120px; font-weight: 500;">No. Rekening</span>
                                <span style="width: 20px; text-align: center;">:</span>
                                <span style="flex: 1;">${esc(this.noRekening)}</span>
                            </li>
                            <li style="display: flex; margin-bottom: 4px;">
                                <span style="width: 120px; font-weight: 500;">Atas Nama</span>
                                <span style="width: 20px; text-align: center;">:</span>
                                <span style="flex: 1;">${esc(this.atasNamaRek)}</span>
                            </li>
                        </ul>
                    </li>
                    <li style="text-align: justify;">Surat perjanjian ini sekaligus berlaku sebagai tanda bukti penerimaan uang (Kwitansi) yang sah atas penyerahan dana tersebut.</li>
                </ol>

                <h4 class="pasal" style="text-align: center;">PASAL 3<br>JANGKA WAKTU & CARA PEMBAYARAN</h4>
                <ol type="1">
                    <li style="text-align: justify;">PIHAK KEDUA berjanji dan mengikatkan diri untuk mengembalikan seluruh pinjaman tersebut kepada PIHAK PERTAMA selambat-lambatnya pada tanggal ${esc(this.tglJatuhTempo)}.</li>
                    <li style="text-align: justify;">Pengembalian pinjaman dilakukan secara ${esc(this.caraPembayaran)}.</li>
                    <li style="text-align: justify;">Jika dilakukan secara angsuran, pembayaran dilakukan sesuai jadwal kesepakatan tertulis terpisah yang menjadi bagian tidak terpisahkan dari perjanjian ini.</li>
                </ol>

                <h4 class="pasal" style="text-align: center;">PASAL 4<br>JAMINAN (BILA ADA)</h4>
                <p style="text-align: justify;">Untuk menjamin pelunasan pinjaman ini, PIHAK KEDUA memberikan jaminan berupa:</p>
                <table style="width:100%; margin-bottom:1rem;>
                    <tr>
                        <td style="width:150px; vertical-align:top">Jenis Jaminan</td>
                        <td style="width:50px; vertical-align:top">:</td>
                        <td>${esc(this.jenisJaminan)}</td>
                    </tr>
                    <tr>
                        <td style="width:150px; vertical-align:top">Deskripsi / No. Dokumen</td>
                        <td style="width:50px; vertical-align:top">:</td>
                        <td>${esc(this.deskripsiJaminan)}</td>
                    </tr>
                    <tr>
                        <td style="width:150px; vertical-align:top">Atas Nama</td>
                        <td style="width:50px; vertical-align:top">:</td>
                        <td>${esc(this.atasNamaJaminan)}</td>
                    </tr>
                </table>
                
                <p style="text-align: justify;">Jaminan tersebut akan dikembalikan secara utuh oleh PIHAK PERTAMA kepada PIHAK KEDUA segera setelah seluruh hutang dilunasi.</p>

                <h4 class="pasal" style="text-align: center;">PASAL 5<br>SANKSI & DENDA KETERLAMBATAN</h4>
                <p style="text-align: justify;">Apabila PIHAK KEDUA terlambat melakukan pembayaran sesuai dengan tanggal jatuh tempo yang telah disepakati, maka PIHAK KEDUA dikenakan denda keterlambatan sesuai kesepakatan tambahan dari sisa pinjaman yang belum dibayarkan.</p>

                <h4 class="pasal" style="text-align: center;">PASAL 6<br>PENYELESAIAN PERSELISIHAN</h4>
                <ol>
                    <li style="text-align: justify;">Apabila terjadi perselisihan di kemudian hari yang timbul dari pelaksanaan perjanjian ini, Para Pihak sepakat untuk menyelesaikannya secara musyawarah untuk mufakat.</li>
                    <li style="text-align: justify;">Apabila penyelesaian secara musyawarah tidak mencapai mufakat, maka Para Pihak sepakat untuk menyelesaikan permasalahan ini melalui jalur hukum di Kepaniteraan Pengadilan Negeri ${esc(this.pengadilanNegeri)}.</li>
                </ol>

                <h4 class="pasal" style="text-align: center;">PASAL 7<br>PENUTUP</h4>
                <p style="text-align: justify;">Demikian Surat Perjanjian Hutang Piutang ini dibuat dalam rangkap 2 (dua) bermaterai cukup, yang masing-masing mempunyai kekuatan hukum yang sama dan dipegang oleh PIHAK PERTAMA dan PIHAK KEDUA, serta berlaku sejak ditandatangani oleh kedua belah pihak secara sadar tanpa ada paksaan dari pihak manapun.</p>

                <br>
                <table style="width:100%; margin-bottom:1rem; text-align:justify">
                    <tr>
                        <th style="width:50%; vertical-align:top; text-align:center">PIHAK PERTAMA<br>(Pemberi Pinjaman)</th>
                        <th style="width:50%; vertical-align:top; text-align:center">PIHAK KEDUA<br>(Penerima Pinjaman)</th>
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
                <div style="text-align:center; font-weight:bold;">Saksi-Saksi:</div>
                <table style="width:100%; margin-top:1rem; text-align:justify">
                    <tr>
                        <td style="width:50%; vertical-align:top; text-align:center">Saksi 1 (Satu)<br><br><br><br>(${esc(this.saksi1)})</td>
                        <td style="width:50%; vertical-align:top; text-align:center">Saksi 2 (Dua)<br><br><br><br>(${esc(this.saksi2)})</td>
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
                    const filename = (this.nomorSurat || 'surat-hutang-piutang').replace(
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
