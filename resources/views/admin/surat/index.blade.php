@extends('layouts.admin')

@section('page-title', 'Manajemen Jenis Surat')
@section('page-subtitle', 'Kelola jenis-jenis surat yang tersedia di sistem.')

@section('content')
    <div class="max-w-7xl mx-auto" x-data="{
        suratList: [{
                nama: 'SURAT PERJANJIAN KERJA WAKTU TERTENTU (PKWT)',
                deskripsi: 'Dokumen perjanjian kerja antara perusahaan dan karyawan untuk periode waktu tertentu, mengatur hak, kewajiban, upah, dan durasi kontrak.',
                url: '{{ url('admin/surat/surat-perjanjian-kerja-waktu-tertentu-pkwt') }}'
            },
            {
                nama: 'SURAT PERJANJIAN HUTANG-PIUTANG',
                deskripsi: 'Dokumen hukum yang mengikat pemberi dan penerima pinjaman, mencakup jumlah, jangka waktu, jaminan, dan sanksi keterlambatan.',
                url: '{{ url('admin/surat/surat-perjanjian-hutang-piutang') }}'
            },
            {
                nama: 'SURAT PERJANJIAN KERJA SAMA USAHA',
                deskripsi: 'Kesepakatan antara dua pihak atau lebih untuk menjalankan usaha bersama, mengatur modal, peran, dan skema bagi hasil.',
                url: '{{ url('admin/surat/surat-perjanjian-kerja-sama') }}'
            },
            {
                nama: 'SURAT PERMOHONAN',
                deskripsi: 'Surat resmi yang diajukan oleh individu, organisasi, atau instansi kepada pihak lain untuk meminta bantuan, izin, fasilitas, atau tindak lanjut administratif (seperti permohonan ke BPN atau dinas pemerintah).',
                url: '{{ url('admin/surat/surat-permohonan') }}'
            },
            {
                nama: 'SURAT PENGUNDUURAN DIRI',
                deskripsi: 'Surat resmi dari seorang karyawan kepada manajemen perusahaan yang memberitahukan niat untuk berhenti dari pekerjaan/jabatan secara profesional.',
                url: '{{ url('admin/surat/surat-pengunduran-diri') }}'
            },
            {
                nama: 'SURAT KETERANGAN KERJA (PAKLARING)',
                deskripsi: 'Surat resmi yang diterbitkan oleh perusahaan untuk menerangkan bahwa seseorang pernah atau sedang bekerja di perusahaan tersebut beserta masa jabatan dan kinerjanya.',
                url: '{{ url('admin/surat/surat-keterangan-kerja') }}'
            },
            {
                nama: 'SURAT JUAL BELI (TANAH / KENDARAAN / ASET)',
                deskripsi: 'Surat perjanjian hukum yang menjadi bukti peralihan hak milik atas suatu barang/aset dari penjual kepada pembeli dengan nominal harga yang disepakati.',
                url: '{{ url('admin/surat/surat-jual-beli') }}'
            },
            {
                nama: 'SURAT SEWA MENYEWA (RUMAH / RUKO / ASET)',
                deskripsi: 'Dokumen kesepakatan antara pemilik properti/aset dan penyewa yang mengatur nilai sewa, jangka waktu pemakaian, serta tata tertib perawatan aset selama masa sewa.',
                url: '{{ url('admin/surat/surat-sewa') }}'
            },
            {
                nama: 'SURAT PERJANJIAN PERDAMAIAN',
                deskripsi: 'Dokumen hukum resmi tertulis yang dibuat oleh dua pihak atau lebih yang terlibat dalam perselisihan, konflik, atau sengketa. Dokumen ini berfungsi untuk mencatat kesepakatan penyelesaian masalah secara kekeluargaan (restorative justice / musyawarah mufakat) tanpa melalui proses peradilan, atau untuk menghentikan proses hukum yang sedang berjalan.',
                url: '{{ url('admin/surat/surat-perjanjian-perdamaian') }}'
            },
            {
                nama: 'SURAT PENCABUTAN KUASA',
                deskripsi: 'Dokumen resmi tertulis yang dibuat oleh Pemberi Kuasa untuk menyatakan pembatalan, penarikan, atau penghentian seluruh wewenang/hak bertindak yang sebelumnya telah diberikan kepada Penerima Kuasa (seperti Advokat/Pengacara, Karyawan, atau Pihak Ketiga) melalui Surat Kuasa terdahulu.',
                url: '{{ url('admin/surat/surat-pencabutan-kuasa') }}'
            },

    
    
        ],
        limitStr(str, len) {
            return str.length > len ? str.substring(0, len) + '...' : str;
        }
    }">

        @if (session('success'))
            <div
                class="p-4 mb-6 rounded-xl bg-emerald-50 dark:bg-emerald-900/30 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-400 text-xs font-semibold shadow-xs flex items-center gap-2.5">
                <i class="fa-solid fa-circle-check text-sm text-emerald-500"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <div
            class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100 dark:border-gray-700">
            <div class="p-6 sm:p-8 space-y-6 text-gray-900 dark:text-gray-100">

                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h3 class="text-sm font-bold text-gray-900 dark:text-white">Daftar Jenis Surat</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Berikut adalah daftar jenis surat yang
                            telah terdaftar.</p>
                    </div>
                </div>

                <div class="overflow-x-auto rounded-xl border border-gray-200 dark:border-gray-700">
                    <table class="w-full text-xs text-left text-gray-500 dark:text-gray-400">
                        <thead
                            class="text-[10px] font-bold text-gray-700 dark:text-gray-300 uppercase bg-gray-50 dark:bg-gray-700/50 border-b border-gray-200 dark:border-gray-700 tracking-wider">
                            <tr>
                                <th scope="col" class="px-6 py-4 w-16 text-center">No</th>
                                <th scope="col" class="px-6 py-4">Nama Jenis Surat</th>
                                <th scope="col" class="px-6 py-4">Deskripsi</th>
                                <th scope="col" class="px-6 py-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700 bg-white dark:bg-gray-800">
                            <template x-for="(surat, index) in suratList" :key="index">
                                <tr class="hover:bg-gray-50/70 dark:hover:bg-gray-700/30 transition duration-150">
                                    <td class="px-6 py-4 text-center font-semibold text-gray-400 dark:text-gray-500"
                                        x-text="index + 1 + '.'"></td>
                                    <th scope="row"
                                        class="px-6 py-4 font-bold text-gray-900 dark:text-white max-w-xs truncate"
                                        x-text="surat.nama"></th>
                                    <td class="px-6 py-4 text-gray-600 dark:text-gray-300"
                                        x-text="limitStr(surat.deskripsi, 100)"></td>
                                    <td class="px-6 py-4 text-right space-x-3 whitespace-nowrap">
                                        <a :href="surat.url"
                                            class="inline-flex items-center gap-1 font-semibold text-blue-600 dark:text-blue-400 hover:underline">
                                            <i class="fa-solid fa-eye text-xs"></i>
                                            <span>Lihat</span>
                                        </a>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
