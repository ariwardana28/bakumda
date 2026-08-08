@extends('layouts.admin')

@section('content')
<div class="py-8 bg-gray-50/50 dark:bg-gray-950 min-h-screen transition-colors duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">

        <!-- ================= HERO BANNER ================= -->
        <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-gray-950 via-gray-900 to-indigo-950 p-8 sm:p-12 shadow-2xl border border-gray-800/80 group">
            <!-- Efek Backdrop Glow & Watermark Icon Timbangan -->
            <div class="absolute -right-16 -top-16 w-96 h-96 bg-amber-500/10 rounded-full blur-3xl pointer-events-none transition-transform duration-700 group-hover:scale-125"></div>
            <div class="absolute right-10 -bottom-10 opacity-10 hidden lg:block pointer-events-none transition-transform duration-500 group-hover:scale-110">
                <svg class="w-72 h-72 text-white" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"></path>
                </svg>
            </div>

            <div class="relative z-10 max-w-2xl space-y-5">
                <!-- Badge Atas -->
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-amber-500/15 border border-amber-500/30 text-amber-300 text-xs font-semibold tracking-wide uppercase shadow-inner backdrop-blur-md">
                    <span class="w-2 h-2 rounded-full bg-amber-400 animate-pulse"></span>
                    Sertifikasi & Pendidikan Hukum Resmi
                </div>

                <!-- Judul Utama -->
                <h1 class="text-3xl sm:text-5xl font-extrabold text-white tracking-tight leading-[1.15]">
                    Tingkatkan Kompetensi Melalui <span class="text-transparent bg-clip-text bg-gradient-to-r from-amber-400 to-amber-200">Sertifikasi Profesi Hukum</span>
                </h1>

                <!-- Deskripsi -->
                <p class="text-sm sm:text-base text-gray-300 leading-relaxed font-normal">
                    Ikuti program pendidikan khusus, pelatihan intensif, dan uji kompetensi hukum tersertifikasi untuk memperkuat legalitas, keahlian advokasi, serta profesionalisme Anda di bidang hukum.
                </p>

                <!-- Tombol Aksi -->
                <div class="pt-2 flex flex-wrap items-center gap-4">
                    <a href="/sertifikasi/formulir" class="inline-flex items-center gap-2.5 px-7 py-3.5 rounded-2xl bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-gray-950 font-extrabold text-xs sm:text-sm uppercase tracking-wider shadow-xl shadow-amber-500/20 transition-all duration-300 hover:scale-[1.03] active:scale-95">
                        <span>Mulai Pendaftaran Sertifikasi</span>
                        <i class="fa-solid fa-arrow-right text-xs"></i>
                    </a>
                    <a href="#persyaratan" class="inline-flex items-center gap-2 px-6 py-3.5 rounded-2xl bg-gray-800/80 hover:bg-gray-800 text-gray-200 hover:text-white font-semibold text-xs sm:text-sm border border-gray-700/80 backdrop-blur-sm transition-all">
                        <span>Lihat Persyaratan</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- ================= SECTION FASILITAS & MANFAAT ================= -->
        <div class="space-y-6">
            <div class="text-center max-w-xl mx-auto space-y-1">
                <h2 class="text-xl sm:text-2xl font-extrabold text-gray-900 dark:text-white tracking-tight">Manfaat & Fasilitas Sertifikasi</h2>
                <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">Keunggulan dan hak eksklusif yang Anda dapatkan setelah mengikuti program sertifikasi hukum.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Card 1 -->
                <div class="group bg-white dark:bg-gray-900 border border-gray-200/80 dark:border-gray-800 rounded-3xl p-7 shadow-sm hover:shadow-xl hover:border-amber-500/30 dark:hover:border-amber-500/30 transition-all duration-300 flex flex-col justify-between hover:-translate-y-1">
                    <div class="space-y-4">
                        <div class="w-14 h-14 rounded-2xl bg-amber-500/10 border border-amber-500/20 flex items-center justify-center text-amber-600 dark:text-amber-400 text-xl font-bold transition-transform duration-300 group-hover:scale-110 shadow-sm">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <h3 class="text-sm sm:text-base font-extrabold text-gray-900 dark:text-white uppercase tracking-wider">Sertifikat Resmi & Legal</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed">
                            Mendapatkan sertifikat kelulusan resmi berstandar nasional yang dilengkapi atribut validasi serta gelar non-akademik kompetensi hukum.
                        </p>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="group bg-white dark:bg-gray-900 border border-gray-200/80 dark:border-gray-800 rounded-3xl p-7 shadow-sm hover:shadow-xl hover:border-indigo-500/30 dark:hover:border-indigo-500/30 transition-all duration-300 flex flex-col justify-between hover:-translate-y-1">
                    <div class="space-y-4">
                        <div class="w-14 h-14 rounded-2xl bg-indigo-500/10 border border-indigo-500/20 flex items-center justify-center text-indigo-600 dark:text-indigo-400 text-xl font-bold transition-transform duration-300 group-hover:scale-110 shadow-sm">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                        <h3 class="text-sm sm:text-base font-extrabold text-gray-900 dark:text-white uppercase tracking-wider">Kurikulum & Pemateri Expert</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed">
                            Dibimbing langsung oleh para praktisi hukum senior, akademisi terkemuka, hakim, serta advokat profesional berpengalaman.
                        </p>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="group bg-white dark:bg-gray-900 border border-gray-200/80 dark:border-gray-800 rounded-3xl p-7 shadow-sm hover:shadow-xl hover:border-emerald-500/30 dark:hover:border-emerald-500/30 transition-all duration-300 flex flex-col justify-between hover:-translate-y-1">
                    <div class="space-y-4">
                        <div class="w-14 h-14 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center text-emerald-600 dark:text-emerald-400 text-xl font-bold transition-transform duration-300 group-hover:scale-110 shadow-sm">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </div>
                        <h3 class="text-sm sm:text-base font-extrabold text-gray-900 dark:text-white uppercase tracking-wider">Jejaring & Praktik Kasus</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed">
                            Memperluas koneksi profesional di bidang hukum serta kesempatan studi kasus nyata dalam penanganan litigasi maupun non-litigasi.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- ================= SECTION PERSYARATAN LENGKAP ================= -->
        <div id="persyaratan" class="bg-white dark:bg-gray-900 border border-gray-200/80 dark:border-gray-800 rounded-3xl p-8 sm:p-10 shadow-sm space-y-8">
            <div class="max-w-3xl space-y-2">
                <span class="inline-block px-3.5 py-1 text-xs font-semibold tracking-widest text-indigo-600 dark:text-indigo-400 uppercase bg-indigo-500/10 rounded-full border border-indigo-500/20">
                    Ketentuan Administrasi
                </span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">
                    Persyaratan Pendaftaran Sertifikasi Hukum
                </h2>
                <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">
                    Mohon persiapkan beberapa dokumen dan kriteria berikut sebelum mengisi formulir pendaftaran online.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <!-- Item Syarat 1 -->
                <div class="flex items-start gap-4 p-5 rounded-2xl bg-gray-50/80 dark:bg-gray-950/40 border border-gray-100 dark:border-gray-800/80 transition-all hover:bg-gray-100/80 dark:hover:bg-gray-950/70">
                    <div class="flex-shrink-0 w-10 h-10 rounded-xl bg-amber-500/10 text-amber-600 dark:text-amber-400 flex items-center justify-center font-black text-xs font-mono border border-amber-500/20">
                        01
                    </div>
                    <div class="space-y-1">
                        <h4 class="text-sm font-extrabold text-gray-900 dark:text-white">Latar Belakang Pendidikan</h4>
                        <p class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed">
                            Diutamakan lulusan S1 Ilmu Hukum, Magister Hukum (S2), praktisi hukum, atau masyarakat umum yang memiliki minat mendalam di bidang hukum.
                        </p>
                    </div>
                </div>

                <!-- Item Syarat 2 -->
                <div class="flex items-start gap-4 p-5 rounded-2xl bg-gray-50/80 dark:bg-gray-950/40 border border-gray-100 dark:border-gray-800/80 transition-all hover:bg-gray-100/80 dark:hover:bg-gray-950/70">
                    <div class="flex-shrink-0 w-10 h-10 rounded-xl bg-amber-500/10 text-amber-600 dark:text-amber-400 flex items-center justify-center font-black text-xs font-mono border border-amber-500/20">
                        02
                    </div>
                    <div class="space-y-1">
                        <h4 class="text-sm font-extrabold text-gray-900 dark:text-white">Identitas Diri (KTP / NIK)</h4>
                        <p class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed">
                            Melampirkan nomor NIK yang valid serta data diri lengkap sesuai Kartu Tanda Penduduk (KTP) yang berlaku.
                        </p>
                    </div>
                </div>

                <!-- Item Syarat 3 -->
                <div class="flex items-start gap-4 p-5 rounded-2xl bg-gray-50/80 dark:bg-gray-950/40 border border-gray-100 dark:border-gray-800/80 transition-all hover:bg-gray-100/80 dark:hover:bg-gray-950/70">
                    <div class="flex-shrink-0 w-10 h-10 rounded-xl bg-amber-500/10 text-amber-600 dark:text-amber-400 flex items-center justify-center font-black text-xs font-mono border border-amber-500/20">
                        03
                    </div>
                    <div class="space-y-1">
                        <h4 class="text-sm font-extrabold text-gray-900 dark:text-white">Scan Ijazah Terakhir</h4>
                        <p class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed">
                            Mengunggah dokumen scan ijazah asli atau legalisir dalam format PDF atau JPG beresolusi jelas untuk verifikasi akademik.
                        </p>
                    </div>
                </div>

                <!-- Item Syarat 4 -->
                <div class="flex items-start gap-4 p-5 rounded-2xl bg-gray-50/80 dark:bg-gray-950/40 border border-gray-100 dark:border-gray-800/80 transition-all hover:bg-gray-100/80 dark:hover:bg-gray-950/70">
                    <div class="flex-shrink-0 w-10 h-10 rounded-xl bg-amber-500/10 text-amber-600 dark:text-amber-400 flex items-center justify-center font-black text-xs font-mono border border-amber-500/20">
                        04
                    </div>
                    <div class="space-y-1">
                        <h4 class="text-sm font-extrabold text-gray-900 dark:text-white">Pas Foto Formal Berjas</h4>
                        <p class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed">
                            Mengunggah pas foto formal menggunakan setelan jas dan latar belakang rapi (standar pembuatan kartu anggota/sertifikat).
                        </p>
                    </div>
                </div>
            </div>

            <!-- Call to action di dalam card persyaratan -->
            <div class="pt-6 border-t border-gray-100 dark:border-gray-800 flex flex-col sm:flex-row items-center justify-between gap-4">
                <p class="text-xs text-gray-500 dark:text-gray-400 text-center sm:text-left">Semua berkas akan diverifikasi oleh tim panitia pusat setelah pendaftaran dikirim.</p>
                <a href="/sertifikasi/formulir" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-7 py-3.5 rounded-2xl bg-amber-500 hover:bg-amber-400 text-gray-950 font-extrabold text-xs uppercase tracking-wider text-center transition-all shadow-md hover:scale-105 active:scale-95">
                    <span>Lanjutkan ke Form Pendaftaran</span>
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                </a>
            </div>
        </div>

    </div>
</div>
@endsection