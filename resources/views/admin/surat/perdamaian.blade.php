@extends('layouts.admin')

@section('title', 'Draf Surat Perjanjian Perdamaian')
@section('page-subtitle', 'Isi variabel formulir di bawah untuk memperbarui draf surat perjanjian perdamaian secara real-time.')

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

<div class="space-y-6" x-data="suratPerdamaianForm()">

    <!-- Bagian Form Input Variable -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700/80 p-6 shadow-sm no-print space-y-5">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-gray-100 dark:border-gray-700 pb-4">
            <div>
                <h2 class="text-base font-bold text-gray-900 dark:text-white">Variabel Dokumen Surat Perjanjian Perdamaian</h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Ubah nilai di bawah untuk menyesuaikan isi surat perjanjian perdamaian secara langsung.</p>
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

            <!-- Pihak Pertama -->
            <fieldset class="border border-gray-200 dark:border-gray-700 rounded-xl p-4">
                <legend class="px-2 text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">Pihak Pertama</legend>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 pt-2">
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Nama Lengkap</label><input type="text" x-model="namaP1" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">No. KTP / NIK</label><input type="text" x-model="nikP1" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Pekerjaan</label><input type="text" x-model="pekerjaanP1" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div class="md:col-span-2"><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Alamat Lengkap</label><input type="text" x-model="alamatP1" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">No. Telepon / HP</label><input type="text" x-model="telpP1" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                </div>
            </fieldset>

            <!-- Pihak Kedua -->
            <fieldset class="border border-gray-200 dark:border-gray-700 rounded-xl p-4">
                <legend class="px-2 text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">Pihak Kedua</legend>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 pt-2">
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Nama Lengkap</label><input type="text" x-model="namaP2" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">No. KTP / NIK</label><input type="text" x-model="nikP2" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Pekerjaan</label><input type="text" x-model="pekerjaanP2" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div class="md:col-span-2"><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Alamat Lengkap</label><input type="text" x-model="alamatP2" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">No. Telepon / HP</label><input type="text" x-model="telpP2" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                </div>
            </fieldset>

            <!-- Pokok Sengketa & Kompensasi -->
            <fieldset class="border border-gray-200 dark:border-gray-700 rounded-xl p-4">
                <legend class="px-2 text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">Pokok Sengketa & Kompensasi</legend>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 pt-2">
                    <div class="md:col-span-3"><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Pokok Sengketa / Peristiwa</label><textarea x-model="pokokSengketa" rows="2" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></textarea></div>
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Nominal Kompensasi (Rp)</label><input type="text" x-model="nominalKompensasi" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div class="md:col-span-2"><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Terbilang Kompensasi</label><input type="text" x-model="terbilangKompensasi" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Nama Bank Penerima</label><input type="text" x-model="namaBank" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Nomor Rekening</label><input type="text" x-model="noRekening" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Nomor Laporan Polisi / Instansi</label><input type="text" x-model="nomorLaporan" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Nama Saksi I</label><input type="text" x-model="saksi1" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                    <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Nama Saksi II</label><input type="text" x-model="saksi2" class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none transition"></div>
                </div>
            </fieldset>
        </div>
    </div>

    <!-- Bagian Textarea Pratinjau & Edit Dokumen -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700/80 p-8 shadow-sm">
        <div class="mb-4 pb-3 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between no-print">
            <span class="text-xs font-bold text-gray-400 uppercase tracking-wider"><i class="fa-solid fa-file-lines mr-1.5"></i> Textarea Pratinjau & Edit Dokumen Perjanjian Perdamaian</span>
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
    Alpine.data('suratPerdamaianForm', () => ({
        nomorSurat: '018/SPP/MKS/VIII/2026',
        hariTtd: 'Rabu',
        tanggalTtd: '12 Agustus 2026',
        kotaTtd: 'Makassar',
        
        namaP1: 'H. Abdullah S., S.H.',
        nikP1: '7371011505700001',
        pekerjaanP1: 'Wiraswasta',
        alamatP1: 'Jl. Boulevard Blok F No. 12, Makassar',
        telpP1: '0812-3456-7890',

        namaP2: 'Ahmad Fauzi, S.E.',
        nikP2: '7371011203880001',
        pekerjaanP2: 'Karyawan Swasta',
        alamatP2: 'Jl. AP Pettarani No. 45, Makassar',
        telpP2: '0811-4123-4567',

        pokokSengketa: 'kesalahpahaman mengenai batas lahan pekarangan serta klaim ganti rugi kerusakan pagar pembatas bangunan',
        nominalKompensasi: '25.000.000',
        terbilangKompensasi: 'Dua Puluh Lima Juta Rupiah',
        namaBank: 'Bank Mandiri',
        noRekening: '152-00-1234567-8',
        nomorLaporan: 'LP/450/VIII/2026/SPKT/POLRESTABES MKS',

        saksi1: 'Hendra Wijaya, S.H.',
        saksi2: 'Siti Nurhaliza',

        kontenSurat: '',
        
        init() {
            this.updateSurat();
            
            const fields = [
                'nomorSurat', 'hariTtd', 'tanggalTtd', 'kotaTtd', 
                'namaP1', 'nikP1', 'pekerjaanP1', 'alamatP1', 'telpP1',
                'namaP2', 'nikP2', 'pekerjaanP2', 'alamatP2', 'telpP2',
                'pokokSengketa', 'nominalKompensasi', 'terbilangKompensasi', 'namaBank', 'noRekening', 'nomorLaporan', 'saksi1', 'saksi2'
            ];

            fields.forEach(field => {
                this.$watch(field, () => this.updateSurat());
            });
        },

        updateSurat() {
            this.kontenSurat = `SURAT PERJANJIAN PERDAMAIAN
Nomor: ${this.nomorSurat}

Pada hari ini, ${this.hariTtd} tanggal ${this.tanggalTtd}, bertempat di ${this.kotaTtd}, kami yang bertanda tangan di bawah ini:

1. Nama Lengkap   : ${this.namaP1}
   No. KTP / NIK  : ${this.nikP1}
   Pekerjaan      : ${this.pekerjaanP1}
   Alamat Lengkap : ${this.alamatP1}
   No. Telepon / HP: ${this.telpP1}
Selanjutnya disebut sebagai PIHAK PERTAMA.

2. Nama Lengkap   : ${this.namaP2}
   No. KTP / NIK  : ${this.nikP2}
   Pekerjaan      : ${this.pekerjaanP2}
   Alamat Lengkap : ${this.alamatP2}
   No. Telepon / HP: ${this.telpP2}
Selanjutnya disebut sebagai PIHAK KEDUA.

PIHAK PERTAMA dan PIHAK KEDUA secara bersama-sama selanjutnya disebut sebagai "PARA PIHAK". Para Pihak terlebih dahulu menerangkan hal-hal sebagai berikut:
1. Bahwa sebelum ditandatanganinya kesepakatan ini, telah timbul perselisihan antara Para Pihak mengenai ${this.pokokSengketa}.
2. Bahwa Para Pihak dengan iktikad baik dan tanpa ada unsur paksaan, kekerasan, atau tekanan dari pihak mana pun bersepakat untuk menyelesaikan seluruh perselisihan tersebut secara musyawarah dan damai.

Berdasarkan pertimbangan di atas, Para Pihak sepakat untuk menandatangani Surat Perjanjian Perdamaian ini dengan ketentuan pasal-pasal sebagai berikut:

PASAL 1
KESEPAKATAN PERDAMAAN RESMI
1. Para Pihak dengan ini menyatakan sepakat untuk mengakhiri seluruh perselisihan, sengketa, dan percekcokan yang terjadi antara PIHAK PERTAMA dan PIHAK KEDUA secara musyawarah dan kekeluargaan.
2. Sejak ditandatanganinya Perjanjian ini, seluruh persoalan antara Para Pihak yang berkaitan dengan sengketa tersebut dinyatakan selesai secara tuntas, final, dan mengikat bagi Para Pihak.

PASAL 2
BENTUK DAN TATA CARA PEMBAYARAN KOMPENSASI
1. Sebagai bentuk kesepakatan perdamaian, PIHAK KEDUA bersedia memberikan uang kompensasi / ganti rugi kepada PIHAK PERTAMA sebesar Rp ${this.nominalKompensasi},- (${this.terbilangKompensasi}).
2. Pembayaran kompensasi tersebut dilakukan secara lunas pada saat penandatanganan Perjanjian ini melalui transfer ke rekening bank PIHAK PERTAMA:
   - Nama Bank: ${this.namaBank}
   - Nomor Rekening: ${this.noRekening}
   - Atas Nama: ${this.namaP1}
3. Perjanjian ini berlaku sekaligus sebagai kuitansi dan bukti penerimaan pembayaran yang sah dan mengikat legalitasnya setelah dana efektif diterima di rekening PIHAK PERTAMA.

PASAL 3
PELEPASAN HAK DAN TUNTUTAN HUKUM (RELEASE AND WAIVER)
1. Dengan dilaksanakannya ketentuan sebagaimana dimaksud dalam Pasal 2, PIHAK PERTAMA dan PIHAK KEDUA saling membebaskan, melepaskan, dan mengesampingkan segala bentuk hak tagih, tuntutan, gugatan, maupun laporan hukum baik secara Perdata (Actie) maupun Pidana (Aangifte) di kemudian hari.
2. Para Pihak berjanji dan mengikatkan diri untuk tidak melakukan gugatan perdata, tuntutan pidana, atau tindakan hukum apa pun di masa mendatang terkait dengan objek perselisihan yang telah didamaikan ini.

PASAL 4
PENCABUTAN LAPORAN ATAU GUGATAN HUKUM
1. Apabila peristiwa perselisihan ini telah terlanjur dilaporkan kepada pihak berwajib (Kepolisian / Kejaksaan / Pengadilan) dengan Nomor Laporan ${this.nomorLaporan}, maka pihak Pelapor/Penggugat wajib mengajukan permohonan pencabutan laporan/gugatan secara resmi paling lambat 3 (tiga) hari kerja setelah Perjanjian ini ditandatangani.
2. Para Pihak bersedia hadir dan memberikan keterangan di hadapan pejabat penyidik atau majelis hakim untuk mendukung proses penghentian perkara (Restorative Justice / Penetapan Perdamaian).

PASAL 5
SANKSI DAN DENDA PELANGGARAN KESEPAKATAN
Apabila di kemudian hari salah satu pihak melanggar isi Perjanjian ini (cidera janji) dengan tetap mengajukan tuntutan atau gugatan hukum atas persoalan yang sama, maka pihak yang melanggar wajib mengembalikan seluruh dana kompensasi yang telah diterima secara utuh serta dikenakan denda administratif sebesar 100% (seratus persen) dari nilai kompensasi kepada pihak yang dirugikan.

PASAL 6
KERAHASIAAN DAN MENJAGA NAMA BAIK
1. Para Pihak sepakat untuk menjaga kerahasiaan isi Perjanjian ini dari pihak luar yang tidak berkepentingan.
2. Para Pihak dilarang memberikan pernyataan, komentar, atau konten bernada negatif, menghina, atau mencemarkan nama baik pihak lainnya, baik secara lisan, tertulis, maupun melalui media massa dan media sosial.

PASAL 7
PENUTUP DAN KEKUATAN HUKUM
1. Surat Perjanjian Perdamaian ini dibuat dalam rangkap 2 (dua) asli bermaterai cukup, yang masing-masing mempunyai kekuatan hukum yang sama dan mengikat bagi Para Pihak serta para ahli warisnya.
2. Perjanjian ini berlaku sejak tanggal ditandatangani secara sadar tanpa ada unsur paksaan, kekerasan, atau penipuan dari pihak mana pun.


PIHAK PERTAMA                              PIHAK KEDUA


[ Materai Rp 10.000 ]                      [ Materai Rp 10.000 ]



(${this.namaP1})                           (${this.namaP2})



SAKSI-SAKSI:

(${this.saksi1})                           (${this.saksi2})
Saksi I                                    Saksi II`;
        },

        reset() {
            this.nomorSurat = '018/SPP/MKS/VIII/2026';
            this.hariTtd = 'Rabu';
            this.tanggalTtd = '12 Agustus 2026';
            this.kotaTtd = 'Makassar';
            this.namaP1 = 'H. Abdullah S., S.H.';
            this.nikP1 = '7371011505700001';
            this.pekerjaanP1 = 'Wiraswasta';
            this.alamatP1 = 'Jl. Boulevard Blok F No. 12, Makassar';
            this.telpP1 = '0812-3456-7890';
            this.namaP2 = 'Ahmad Fauzi, S.E.';
            this.nikP2 = '7371011203880001';
            this.pekerjaanP2 = 'Karyawan Swasta';
            this.alamatP2 = 'Jl. AP Pettarani No. 45, Makassar';
            this.telpP2 = '0811-4123-4567';
            this.pokokSengketa = 'kesalahpahaman mengenai batas lahan pekarangan serta klaim ganti rugi kerusakan pagar pembatas bangunan';
            this.nominalKompensasi = '25.000.000';
            this.terbilangKompensasi = 'Dua Puluh Lima Juta Rupiah';
            this.namaBank = 'Bank Mandiri';
            this.noRekening = '152-00-1234567-8';
            this.nomorLaporan = 'LP/450/VIII/2026/SPKT/POLRESTABES MKS';
            this.saksi1 = 'Hendra Wijaya, S.H.';
            this.saksi2 = 'Siti Nurhaliza';
            
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
                <h4 style="text-align:center">SURAT PERJANJIAN PERDAMAIAN</h4>
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
                <p>Selanjutnya disebut sebagai <strong>PIHAK PERTAMA</strong>.</p>

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
                <p>Selanjutnya disebut sebagai <strong>PIHAK KEDUA</strong>.</p>

                <p style="text-align: justify;">PIHAK PERTAMA dan PIHAK KEDUA secara bersama-sama selanjutnya disebut sebagai <strong>"PARA PIHAK"</strong>. Para Pihak terlebih dahulu menerangkan hal-hal sebagai berikut:</p>
                <ol>
                    <li style="text-align: justify;">Bahwa sebelum ditandatanganinya kesepakatan ini, telah timbul perselisihan antara Para Pihak mengenai ${esc(this.pokokSengketa)}.</li>
                    <li style="text-align: justify;">Bahwa Para Pihak dengan iktikad baik dan tanpa ada unsur paksaan, kekerasan, atau tekanan dari pihak mana pun bersepakat untuk menyelesaikan seluruh perselisihan tersebut secara musyawarah dan damai.</li>
                </ol>

                <p>Berdasarkan pertimbangan di atas, Para Pihak sepakat untuk menandatangani Surat Perjanjian Perdamaian ini dengan ketentuan pasal-pasal sebagai berikut:</p>

                <h4 class="pasal">PASAL 1<br>KESEPAKATAN PERDAMAAN RESMI</h4>
                <ol>
                    <li style="text-align: justify;">Para Pihak dengan ini menyatakan sepakat untuk mengakhiri seluruh perselisihan, sengketa, dan percekcokan yang terjadi antara PIHAK PERTAMA dan PIHAK KEDUA secara musyawarah dan kekeluargaan.</li>
                    <li style="text-align: justify;">Sejak ditandatanganinya Perjanjian ini, seluruh persoalan antara Para Pihak yang berkaitan dengan sengketa tersebut dinyatakan selesai secara tuntas, final, dan mengikat bagi Para Pihak.</li>
                </ol>

                <h4 class="pasal">PASAL 2<br>BENTUK DAN TATA CARA PEMBAYARAN KOMPENSASI</h4>
                <ol>
                    <li style="text-align: justify;">Sebagai bentuk kesepakatan perdamaian, PIHAK KEDUA bersedia memberikan uang kompensasi / ganti rugi kepada PIHAK PERTAMA sebesar Rp ${esc(this.nominalKompensasi)},- (${esc(this.terbilangKompensasi)}).</li>
                    <li>Pembayaran kompensasi tersebut dilakukan secara lunas pada saat penandatanganan Perjanjian ini melalui transfer ke rekening bank PIHAK PERTAMA:
                        <br>- Nama Bank: ${esc(this.namaBank)}
                        <br>- Nomor Rekening: ${esc(this.noRekening)}
                        <br>- Atas Nama: ${esc(this.namaP1)}
                    </li>
                    <li style="text-align: justify;">Perjanjian ini berlaku sekaligus sebagai kuitansi dan bukti penerimaan pembayaran yang sah dan mengikat legalitasnya setelah dana efektif diterima di rekening PIHAK PERTAMA.</li>
                </ol>

                <h4 class="pasal">PASAL 3<br>PELEPASAN HAK DAN TUNTUTAN HUKUM (RELEASE AND WAIVER)</h4>
                <ol>
                    <li style="text-align: justify;">Dengan dilaksanakannya ketentuan sebagaimana dimaksud dalam Pasal 2, PIHAK PERTAMA dan PIHAK KEDUA saling membebaskan, melepaskan, dan mengesampingkan segala bentuk hak tagih, tuntutan, gugatan, maupun laporan hukum baik secara Perdata (Actie) maupun Pidana (Aangifte) di kemudian hari.</li>
                    <li style="text-align: justify;">Para Pihak berjanji dan mengikatkan diri untuk tidak melakukan gugatan perdata, tuntutan pidana, atau tindakan hukum apa pun di masa mendatang terkait dengan objek perselisihan yang telah didamaikan ini.</li>
                </ol>

                <h4 class="pasal">PASAL 4<br>PENCABUTAN LAPORAN ATAU GUGATAN HUKUM</h4>
                <ol>
                    <li style="text-align: justify;">Apabila peristiwa perselisihan ini telah terlanjur dilaporkan kepada pihak berwajib (Kepolisian / Kejaksaan / Pengadilan) dengan Nomor Laporan ${esc(this.nomorLaporan)}, maka pihak Pelapor/Penggugat wajib mengajukan permohonan pencabutan laporan/gugatan secara resmi paling lambat 3 (tiga) hari kerja setelah Perjanjian ini ditandatangani.</li>
                    <li style="text-align: justify;">Para Pihak bersedia hadir dan memberikan keterangan di hadapan pejabat penyidik atau majelis hakim untuk mendukung proses penghentian perkara (Restorative Justice / Penetapan Perdamaian).</li>
                </ol>

                <h4 class="pasal">PASAL 5<br>SANKSI DAN DENDA PELANGGARAN KESEPAKATAN</h4>
                <p>Apabila di kemudian hari salah satu pihak melanggar isi Perjanjian ini (cidera janji) dengan tetap mengajukan tuntutan atau gugatan hukum atas persoalan yang sama, maka pihak yang melanggar wajib mengembalikan seluruh dana kompensasi yang telah diterima secara utuh serta dikenakan denda administratif sebesar 100% (seratus persen) dari nilai kompensasi kepada pihak yang dirugikan.</p>

                <h4 class="pasal">PASAL 6<br>KERAHASIAAN DAN MENJAGA NAMA BAIK</h4>
                <ol>
                    <li style="text-align: justify;">Para Pihak sepakat untuk menjaga kerahasiaan isi Perjanjian ini dari pihak luar yang tidak berkepentingan.</li>
                    <li style="text-align: justify;">Para Pihak dilarang memberikan pernyataan, komentar, atau konten bernada negatif, menghina, atau mencemarkan nama baik pihak lainnya, baik secara lisan, tertulis, maupun melalui media massa dan media sosial.</li>
                </ol>

                <h4 class="pasal">PASAL 7<br>PENUTUP DAN KEKUATAN HUKUM</h4>
                <ol>
                    <li style="text-align: justify;">Surat Perjanjian Perdamaian ini dibuat dalam rangkap 2 (dua) asli bermaterai cukup, yang masing-masing mempunyai kekuatan hukum yang sama dan mengikat bagi Para Pihak serta para ahli warisnya.</li>
                    <li style="text-align: justify;">Perjanjian ini berlaku sejak tanggal ditandatangani secara sadar tanpa ada unsur paksaan, kekerasan, atau penipuan dari pihak mana pun.</li>
                </ol>

                <br>
                <table style="width:100%; margin-bottom:2rem; text-align:justify">
                    <tr>
                        <th style="width:50%; vertical-align:top; text-align:center">PIHAK PERTAMA</th>
                        <th style="width:50%; vertical-align:top; text-align:center">PIHAK KEDUA</th>
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
                        <td style="width:50%; vertical-align:top; text-align:center"><br>Saksi I<br><br><br><br>(${esc(this.saksi1)})</td>
                        <td style="width:50%; vertical-align:top; text-align:center"><br>Saksi II<br><br><br><br>(${esc(this.saksi2)})</td>
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
            const filename = (this.nomorSurat || 'surat-perjanjian-perdamaian').replace(/[^a-z0-9\-_.]/gi, '_') + '.doc';
            a.download = filename;
            document.body.appendChild(a);
            a.click();
            setTimeout(() => { URL.revokeObjectURL(url); a.remove(); }, 1500);
        }
    }));
});
</script>
@endsection