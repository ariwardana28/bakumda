@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('page-title', 'Dashboard Administrator')

@section('page-subtitle')
    Halo, <span class="font-semibold text-brand-600 dark:text-brand-400">{{ Auth::user()->name ?? 'Admin' }}</span>! Berikut ringkasan statistik sistem dan aktivitas keanggotaan terbaru Anda hari ini.
@endsection

@section('page-actions')
    <div class="flex flex-wrap items-center gap-2.5">
        {{-- <a href="#" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 hover:bg-slate-50 dark:hover:bg-slate-800 text-slate-700 dark:text-slate-200 font-medium text-xs shadow-sm transition-all duration-200 hover:-translate-y-0.5">
            <i class="fa-solid fa-file-excel text-xs text-emerald-600"></i>
            <span>Export Data</span>
        </a> --}}
        <a href="#" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-gradient-to-r from-brand-600 to-indigo-600 hover:from-brand-700 hover:to-indigo-700 text-white font-medium text-xs shadow-md shadow-brand-500/20 transition-all duration-200 hover:-translate-y-0.5">
            <i class="fa-solid fa-clock text-xs"></i>
           <span>{{ now()->format('d M Y') }}</span>
        </a>
    </div>
@endsection

@section('content')
<div class="space-y-6">

    <!-- Admin Banner dengan Elemen Visual Modern -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-slate-900 via-brand-950 to-indigo-950 p-6 sm:p-8 text-white shadow-xl border border-slate-800/50">
        <div class="relative z-10 max-w-2xl">
            <span class="inline-flex items-center gap-1.5 px-3.5 py-1 rounded-full bg-white/10 backdrop-blur-md text-[11px] font-semibold tracking-wide uppercase mb-3 text-brand-300 border border-white/10">
                <i class="fa-solid fa-shield-halved text-brand-400"></i> Panel Kontrol Utama
            </span>
            <h2 class="text-xl sm:text-2xl font-extrabold tracking-tight leading-tight text-white">
                Sistem Manajemen Keanggotaan Aktif
            </h2>
            <p class="text-xs sm:text-sm text-slate-300 mt-2 leading-relaxed font-normal">
                Kelola data anggota, verifikasi dokumen permohonan kartu, serta pantau status pencetakan fisik secara terpusat dari panel administrator ini.
            </p>
        </div>
        <!-- Ornamen Background Glow -->
        <div class="absolute -right-10 -bottom-10 w-72 h-72 bg-brand-500/15 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute right-20 -top-20 w-48 h-48 bg-indigo-500/10 rounded-full blur-2xl pointer-events-none"></div>
    </div>

    <!-- Quick Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
        
        <!-- Stat 1: Total Anggota -->
        <div class="group relative p-5 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800/80 shadow-sm hover:shadow-md transition-all duration-300">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500">Total Anggota</span>
                <div class="w-10 h-10 rounded-2xl bg-brand-50 text-brand-600 dark:bg-brand-500/10 dark:text-brand-400 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <i class="fa-solid fa-users text-sm"></i>
                </div>
            </div>
            <div class="mt-4">
                <h3 class="text-2xl font-extrabold text-slate-800 dark:text-slate-100 tracking-tight">{{ number_format($totalAnggota) }}</h3>
                <p class="text-[11px] text-emerald-600 dark:text-emerald-400 font-semibold mt-1.5 flex items-center gap-1">
                    <span class="inline-flex items-center justify-center w-4 h-4 rounded-full bg-emerald-50 dark:bg-emerald-500/20"><i class="fa-solid fa-arrow-trend-up text-[9px]"></i></span> +12% bulan ini
                </p>
            </div>
        </div>

        <!-- Stat 2: Pending Verifikasi -->
        <div class="group relative p-5 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800/80 shadow-sm hover:shadow-md transition-all duration-300">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500">Perlu Verifikasi</span>
                <div class="w-10 h-10 rounded-2xl bg-amber-50 text-amber-600 dark:bg-amber-500/10 dark:text-amber-400 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <i class="fa-solid fa-user-clock text-sm"></i>
                </div>
            </div>
            <div class="mt-4">
                <h3 class="text-2xl font-extrabold text-slate-800 dark:text-slate-100 tracking-tight">{{ $pendingVerifikasi }}</h3>
                <p class="text-[11px] text-amber-500 font-semibold mt-1.5 flex items-center gap-1">
                    <span class="inline-flex items-center justify-center w-4 h-4 rounded-full bg-amber-50 dark:bg-amber-500/20"><i class="fa-solid fa-circle-exclamation text-[9px]"></i></span> Menunggu tindakan
                </p>
            </div>
        </div>

        <!-- Stat 3: Status Aktif -->
        <div class="group relative p-5 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800/80 shadow-sm hover:shadow-md transition-all duration-300">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500">Status Aktif</span>
                <div class="w-10 h-10 rounded-2xl bg-purple-50 text-purple-600 dark:bg-purple-500/10 dark:text-purple-400 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <i class="fa-solid fa-user-check text-sm"></i>
                </div>
            </div>
            <div class="mt-4">
                <h3 class="text-2xl font-extrabold text-slate-800 dark:text-slate-100 tracking-tight">{{ number_format($anggotaAktif) }}</h3>
                <p class="text-[11px] text-purple-600 dark:text-purple-400 font-semibold mt-1.5 flex items-center gap-1">
                    <span class="inline-flex items-center justify-center w-4 h-4 rounded-full bg-purple-50 dark:bg-purple-500/20"><i class="fa-solid fa-check text-[9px]"></i></span> Anggota berstatus aktif
                </p>
            </div>
        </div>

        <!-- Stat 4: Aktivitas Hari Ini -->
        <div class="group relative p-5 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800/80 shadow-sm hover:shadow-md transition-all duration-300">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500">Pengajuan Hari Ini</span>
                <div class="w-10 h-10 rounded-2xl bg-emerald-50 text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-400 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <i class="fa-solid fa-calendar-day text-sm"></i>
                </div>
            </div>
            <div class="mt-4">
                <h3 class="text-2xl font-extrabold text-slate-800 dark:text-slate-100 tracking-tight">{{ $totalPengajuanHariIni }}</h3>
                <p class="text-[11px] text-emerald-600 dark:text-emerald-400 font-semibold mt-1.5 flex items-center gap-1">
                    <span class="inline-flex items-center justify-center w-4 h-4 rounded-full bg-emerald-50 dark:bg-emerald-500/20"><i class="fa-solid fa-plus text-[9px]"></i></span> Data baru masuk
                </p>
            </div>
        </div>

    </div>

    <!-- Main Section: Tabel Anggota Terbaru & Quick Management -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Table List (2 Cols) -->
        <div class="lg:col-span-2 p-6 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800/80 shadow-sm flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-5">
                    <div>
                        <h3 class="text-sm font-extrabold text-slate-900 dark:text-white uppercase tracking-wider">
                            Permohonan Anggota Terbaru
                        </h3>
                        <p class="text-xs text-slate-400 mt-0.5">Daftar antrean verifikasi registrasi anggota baru</p>
                    </div>
                    <a href="{{ route('admin.anggota.index') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-brand-600 dark:text-brand-400 hover:text-brand-700 bg-brand-50 dark:bg-brand-500/10 px-3 py-1.5 rounded-xl transition-colors">
                        <span>Kelola Semua</span>
                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-slate-100 dark:border-slate-800 text-[11px] uppercase tracking-wider text-slate-400 font-semibold">
                                <th class="py-3 px-3">Nama Anggota</th>
                                <th class="py-3 px-3">ID / No. Anggota</th>
                                <th class="py-3 px-3">Status</th>
                                <th class="py-3 px-3 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100/80 dark:divide-slate-800/60 text-xs">
                            @forelse ($permohonanTerbaru as $permohonan)
                                <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors">
                                    <td class="py-3.5 px-3">
                                        <div class="font-semibold text-slate-800 dark:text-slate-200">
                                            {{ $permohonan->nama ?? 'N/A' }}
                                        </div>
                                        <div class="text-[11px] font-normal text-slate-400 mt-0.5">{{ $permohonan->email ?? '-' }}</div>
                                    </td>
                                    <td class="py-3.5 px-3 font-medium text-slate-600 dark:text-slate-300">
                                        {{ $permohonan->card->nomor_anggota ?? 'Belum Ada' }}
                                    </td>
                                    <td class="py-3.5 px-3">
                                        @if (optional($permohonan->card->latestStatus)->status == 'proses')
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-amber-50 text-amber-600 dark:bg-amber-500/10 dark:text-amber-400 font-bold text-[11px] border border-amber-200/50 dark:border-amber-500/20">
                                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span> Proses
                                            </span>
                                        @elseif (optional($permohonan->card->latestStatus)->status == 'aktif')
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-400 font-bold text-[11px] border border-emerald-200/50 dark:border-emerald-500/20">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Aktif
                                            </span>
                                        @else
                                            <span class="text-slate-400 italic text-[11px]">Tidak diketahui</span>
                                        @endif
                                    </td>
                                    <td class="py-3.5 px-3 text-right">
                                        @if (optional($permohonan->card->latestStatus)->status == 'proses')
                                            <a href="{{ route('admin.anggota.show', $permohonan->id) }}" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-xl bg-brand-50 text-brand-600 dark:bg-brand-500/10 dark:text-brand-400 font-bold hover:bg-brand-100 dark:hover:bg-brand-500/20 transition-all shadow-2xs">
                                                <span>Tinjau</span>
                                            </a>
                                        @else
                                            <a href="{{ route('admin.anggota.show', $permohonan->id) }}" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-xl bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-300 font-bold hover:bg-slate-200 dark:hover:bg-slate-700 transition-all shadow-2xs">
                                                <span>Detail</span>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-8 px-3 text-center text-slate-400 dark:text-slate-500">
                                        <div class="flex flex-col items-center justify-center space-y-2">
                                            <div class="w-10 h-10 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-400">
                                                <i class="fa-solid fa-folder-open"></i>
                                            </div>
                                            <p class="text-xs">Tidak ada permohonan anggota terbaru saat ini.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Right Side: Shortcut / Aksi Cepat Admin (1 Col) -->
        <div class="space-y-6">
            <div class="p-6 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800/80 shadow-sm">
                <h3 class="text-sm font-extrabold text-slate-900 dark:text-white uppercase tracking-wider mb-4">
                    Aksi Cepat Admin
                </h3>
                <div class="space-y-3">
                    <a href="#" class="group flex items-center justify-between p-3.5 rounded-2xl bg-slate-50/80 hover:bg-brand-50/60 dark:bg-slate-800/40 dark:hover:bg-slate-800/80 border border-slate-100 dark:border-slate-800/80 transition-all duration-200 text-xs font-semibold text-slate-700 dark:text-slate-200">
                        <span class="flex items-center gap-3">
                            <span class="w-8 h-8 rounded-xl bg-brand-50 text-brand-600 dark:bg-brand-500/10 dark:text-brand-400 flex items-center justify-center group-hover:scale-105 transition-transform">
                                <i class="fa-solid fa-check-to-slot text-xs"></i>
                            </span>
                            <span>Verifikasi Masal Kartu</span>
                        </span>
                        <i class="fa-solid fa-chevron-right text-[10px] text-slate-400 group-hover:translate-x-0.5 transition-transform"></i>
                    </a>

                    <a href="#" class="group flex items-center justify-between p-3.5 rounded-2xl bg-slate-50/80 hover:bg-purple-50/60 dark:bg-slate-800/40 dark:hover:bg-slate-800/80 border border-slate-100 dark:border-slate-800/80 transition-all duration-200 text-xs font-semibold text-slate-700 dark:text-slate-200">
                        <span class="flex items-center gap-3">
                            <span class="w-8 h-8 rounded-xl bg-purple-50 text-purple-600 dark:bg-purple-500/10 dark:text-purple-400 flex items-center justify-center group-hover:scale-105 transition-transform">
                                <i class="fa-solid fa-print text-xs"></i>
                            </span>
                            <span>Antrean Cetak Fisik</span>
                        </span>
                        <i class="fa-solid fa-chevron-right text-[10px] text-slate-400 group-hover:translate-x-0.5 transition-transform"></i>
                    </a>

                    <a href="#" class="group flex items-center justify-between p-3.5 rounded-2xl bg-slate-50/80 hover:bg-amber-50/60 dark:bg-slate-800/40 dark:hover:bg-slate-800/80 border border-slate-100 dark:border-slate-800/80 transition-all duration-200 text-xs font-semibold text-slate-700 dark:text-slate-200">
                        <span class="flex items-center gap-3">
                            <span class="w-8 h-8 rounded-xl bg-amber-50 text-amber-600 dark:bg-amber-500/10 dark:text-amber-400 flex items-center justify-center group-hover:scale-105 transition-transform">
                                <i class="fa-solid fa-bullhorn text-xs"></i>
                            </span>
                            <span>Kirim Pengumuman</span>
                        </span>
                        <i class="fa-solid fa-chevron-right text-[10px] text-slate-400 group-hover:translate-x-0.5 transition-transform"></i>
                    </a>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection