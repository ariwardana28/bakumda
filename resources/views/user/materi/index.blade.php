@extends('layouts.app')

@section('content')
    <div class="container mx-auto space-y-10 pb-12">

        {{-- Latar Belakang Dekoratif Glow Abstrak Nuansa Gold (#FFD700) --}}
        <div
            class="absolute top-12 left-1/4 w-80 h-80 sm:w-[32rem] sm:h-[32rem] bg-gradient-to-tr from-[#FFD700]/15 to-yellow-500/10 dark:from-[#FFD700]/10 dark:to-yellow-500/5 rounded-full blur-[140px] pointer-events-none -z-10">
        </div>
        <div
            class="absolute top-[38rem] right-5 w-72 h-72 sm:w-[28rem] sm:h-[28rem] bg-gradient-to-br from-yellow-600/15 to-[#FFD700]/10 dark:from-yellow-600/10 dark:to-[#FFD700]/5 rounded-full blur-[140px] pointer-events-none -z-10">
        </div>

        {{-- BREADCRUMB & HEADER NAVIGASI MODERN --}}
        <div class="flex items-center justify-between">
            <a href="javascript:history.back()"
                class="inline-flex items-center gap-2.5 px-4.5 py-2.5 bg-white/80 dark:bg-slate-900/80 backdrop-blur-xl border border-slate-200/80 dark:border-slate-800 rounded-2xl text-xs font-bold text-slate-600 dark:text-slate-300 hover:text-[#FFD700] dark:hover:text-[#FFD700] hover:border-[#FFD700]/40 transition-all duration-300 shadow-sm group">
                <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path>
                </svg>
                <span>Kembali</span>
            </a>

            <div class="flex items-center gap-2">
                <span
                    class="inline-flex items-center gap-2 px-3.5 py-1.5 bg-[#FFD700]/10 dark:bg-[#FFD700]/20 text-[#b39700] dark:text-[#FFD700] text-xs font-black uppercase tracking-widest rounded-full border border-[#FFD700]/30 shadow-sm">
                    <span class="w-2 h-2 rounded-full bg-[#FFD700] animate-ping"></span>
                    E-Learning Dashboard
                </span>
            </div>
        </div>

        {{-- HERO SECTION: INFORMASI UTAMA PELATIHAN --}}
        <div
            class="bg-white/90 dark:bg-slate-900/90 backdrop-blur-2xl rounded-[2.5rem] shadow-2xl shadow-slate-200/50 dark:shadow-black/50 border border-slate-200/80 dark:border-slate-800/80 overflow-hidden relative transition-all duration-500">
            @if ($pelatihan->gambar)
                <div class="w-full h-72 sm:h-[30rem] overflow-hidden bg-slate-950 relative group">
                    <img src="{{ asset('storage/' . $pelatihan->gambar) }}" alt="{{ $pelatihan->judul }}"
                        class="w-full h-full object-cover opacity-90 transition-transform duration-1000 group-hover:scale-105">

                    {{-- Overlay Gradients Premium --}}
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/60 to-transparent"></div>
                    <div
                        class="absolute inset-0 bg-gradient-to-tr from-yellow-950/50 via-transparent to-[#FFD700]/20 mix-blend-overlay">
                    </div>

                    {{-- Badge Status --}}
                    <div class="absolute top-6 right-6">
                        <span
                            class="inline-flex items-center gap-2 px-4 py-2 bg-slate-900/70 backdrop-blur-xl text-white text-xs font-black uppercase tracking-wider rounded-2xl shadow-xl border border-white/20">
                            <span
                                class="w-2.5 h-2.5 rounded-full bg-gradient-to-r from-[#FFD700] to-yellow-400 animate-pulse shadow-md shadow-[#FFD700]"></span>
                            {{ $pelatihan->status ?? 'Aktif' }}
                        </span>
                    </div>

                    {{-- Judul di dalam Banner --}}
                    <div class="absolute bottom-6 left-6 right-6 sm:bottom-10 sm:left-10 sm:right-10">
                        <span
                            class="inline-block text-xs font-black text-[#FFD700] uppercase tracking-[0.2em] mb-3 px-3.5 py-1.5 bg-slate-950/80 backdrop-blur-md rounded-xl border border-[#FFD700]/40 shadow-md">
                            Detail Program Pelatihan
                        </span>
                        <h1
                            class="text-2xl sm:text-4xl lg:text-5xl font-black text-white tracking-tight drop-shadow-md leading-tight">
                            {{ $pelatihan->judul }}
                        </h1>
                    </div>
                </div>
            @endif

            <div class="p-6 sm:p-12">
                @if (!$pelatihan->gambar)
                    <span
                        class="inline-block text-xs font-black text-[#b39700] dark:text-[#FFD700] uppercase tracking-[0.2em] mb-3 px-3.5 py-1.5 bg-[#FFD700]/10 rounded-xl border border-[#FFD700]/30 shadow-sm">
                        Detail Program Pelatihan
                    </span>
                    <h1
                        class="text-3xl sm:text-4xl lg:text-5xl font-black text-slate-900 dark:text-white tracking-tight mb-6 leading-tight">
                        {{ $pelatihan->judul }}
                    </h1>
                @endif

                {{-- GRID STATISTIK & INFORMASI PELATIHAN (Glass Stat Cards) --}}
                <div
                    class="grid grid-cols-2 lg:grid-cols-4 gap-4 py-6 my-6 border-y border-slate-100 dark:border-slate-800/80">

                    <div
                        class="flex items-center gap-4 p-4 sm:p-5 rounded-3xl bg-slate-50/80 dark:bg-slate-800/40 border border-slate-200/60 dark:border-slate-700/50 shadow-sm hover:border-[#FFD700]/60 transition-all duration-300 group">
                        <div
                            class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl bg-gradient-to-br from-[#FFD700]/20 to-yellow-500/20 text-[#b39700] dark:text-[#FFD700] flex items-center justify-center shrink-0 border border-[#FFD700]/40 shadow-inner group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                        <div class="overflow-hidden">
                            <p class="text-[10px] sm:text-xs text-slate-400 font-extrabold uppercase tracking-wider">Mulai
                            </p>
                            <p class="text-xs sm:text-sm font-black text-slate-800 dark:text-slate-100 truncate mt-0.5">
                                {{ $pelatihan->tanggal_mulai ? \Carbon\Carbon::parse($pelatihan->tanggal_mulai)->format('d M Y') : '-' }}
                            </p>
                        </div>
                    </div>

                    <div
                        class="flex items-center gap-4 p-4 sm:p-5 rounded-3xl bg-slate-50/80 dark:bg-slate-800/40 border border-slate-200/60 dark:border-slate-700/50 shadow-sm hover:border-[#FFD700]/60 transition-all duration-300 group">
                        <div
                            class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl bg-gradient-to-br from-[#FFD700]/20 to-yellow-500/20 text-[#b39700] dark:text-[#FFD700] flex items-center justify-center shrink-0 border border-[#FFD700]/40 shadow-inner group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <div class="overflow-hidden">
                            <p class="text-[10px] sm:text-xs text-slate-400 font-extrabold uppercase tracking-wider">Lokasi
                            </p>
                            <p class="text-xs sm:text-sm font-black text-slate-800 dark:text-slate-100 truncate mt-0.5">
                                {{ $pelatihan->lokasi ?? 'Online' }}
                            </p>
                        </div>
                    </div>

                    <div
                        class="flex items-center gap-4 p-4 sm:p-5 rounded-3xl bg-slate-50/80 dark:bg-slate-800/40 border border-slate-200/60 dark:border-slate-700/50 shadow-sm hover:border-[#FFD700]/60 transition-all duration-300 group">
                        <div
                            class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl bg-gradient-to-br from-[#FFD700]/20 to-yellow-500/20 text-[#b39700] dark:text-[#FFD700] flex items-center justify-center shrink-0 border border-[#FFD700]/40 shadow-inner group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                </path>
                            </svg>
                        </div>
                        <div class="overflow-hidden">
                            <p class="text-[10px] sm:text-xs text-slate-400 font-extrabold uppercase tracking-wider">Harga
                            </p>
                            <p class="text-xs sm:text-sm font-black text-slate-800 dark:text-slate-100 truncate mt-0.5">
                                {{ $pelatihan->harga > 0 ? 'Rp ' . number_format($pelatihan->harga, 0, ',', '.') : 'Gratis' }}
                            </p>
                        </div>
                    </div>

                    <div
                        class="flex items-center gap-4 p-4 sm:p-5 rounded-3xl bg-slate-50/80 dark:bg-slate-800/40 border border-slate-200/60 dark:border-slate-700/50 shadow-sm hover:border-[#FFD700]/60 transition-all duration-300 group">
                        <div
                            class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl bg-gradient-to-br from-[#FFD700]/20 to-yellow-500/20 text-[#b39700] dark:text-[#FFD700] flex items-center justify-center shrink-0 border border-[#FFD700]/40 shadow-inner group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                </path>
                            </svg>
                        </div>
                        <div class="overflow-hidden">
                            <p class="text-[10px] sm:text-xs text-slate-400 font-extrabold uppercase tracking-wider">Kuota
                            </p>
                            <p class="text-xs sm:text-sm font-black text-slate-800 dark:text-slate-100 truncate mt-0.5">
                                {{ $pelatihan->kuota ?? 'Tak terbatas' }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- DESKRIPSI PELATIHAN --}}
                <div class="space-y-4">
                    <h3
                        class="text-lg sm:text-xl font-black text-slate-900 dark:text-white tracking-tight flex items-center gap-2.5">
                        <span class="w-2.5 h-2.5 rounded-full bg-[#FFD700] shadow-sm shadow-[#FFD700]"></span>
                        Deskripsi Pelatihan
                    </h3>
                    <div
                        class="text-slate-600 dark:text-slate-300 leading-relaxed whitespace-pre-line text-sm sm:text-base font-normal bg-slate-50/80 dark:bg-slate-800/40 p-6 sm:p-8 rounded-3xl border border-slate-200/60 dark:border-slate-700/50 shadow-inner">
                        {{ $pelatihan->deskripsi }}
                    </div>
                </div>
            </div>
        </div>

        {{-- KOTAK TOMBOL CEK / CETAK SERTIFIKAT (MUNCUL JIKA SEMUA MATERI LULUS) --}}
        @if (isset($semuaMateriLulus) && $semuaMateriLulus)
            <div
                class="relative overflow-hidden bg-gradient-to-r from-slate-900 via-slate-950 to-slate-900 rounded-[2.5rem] p-8 sm:p-12 text-white shadow-2xl shadow-slate-950/40 flex flex-col sm:flex-row items-center justify-between gap-8 border border-[#FFD700]/40 z-10 animate-fade-in">
                <div
                    class="absolute -right-10 -bottom-10 w-80 h-80 bg-[#FFD700]/10 rounded-full blur-3xl pointer-events-none">
                </div>

                <div class="relative z-10 text-center sm:text-left space-y-3">
                    <div
                        class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-[#FFD700]/10 backdrop-blur-xl text-[#FFD700] text-xs font-black uppercase tracking-wider border border-[#FFD700]/30 shadow-lg">
                        <svg class="w-4 h-4 text-[#FFD700] animate-bounce" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                            </path>
                        </svg>
                        Kompetensi Pelatihan Selesai
                    </div>
                    <h3 class="text-2xl sm:text-4xl font-black tracking-tight drop-shadow-md text-white">Selamat! Sertifikat
                        Anda Siap</h3>
                    <p class="text-slate-300 text-sm sm:text-base max-w-xl leading-relaxed font-medium">
                        Anda telah berhasil menyelesaikan seluruh modul dan kuis pada pelatihan ini. Cek dan unduh
                        sertifikat kelulusan resmi Anda sekarang.
                    </p>
                </div>

                {{-- TOMBOL UTAMA CEK / CETAK SERTIFIKAT DENGAN WARNA GOLD --}}
                <a href="{{ route('user.sertifikat', $pelatihan->id) }}" target="_blank"
                    class="w-full sm:w-auto relative z-10 px-8 py-4.5 bg-gradient-to-r from-[#FFD700] to-yellow-500 hover:from-yellow-400 hover:to-yellow-600 text-slate-950 font-black text-sm rounded-2xl shadow-xl shadow-[#FFD700]/25 hover:shadow-[#FFD700]/40 hover:scale-105 active:scale-95 transition-all duration-300 shrink-0 flex items-center justify-center gap-3 group">
                    <div
                        class="w-8 h-8 rounded-xl bg-slate-950/10 flex items-center justify-center text-slate-950 group-hover:bg-slate-950 group-hover:text-[#FFD700] transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                    </div>
                    <span>Cek / Cetak Sertifikat</span>
                </a>
            </div>
        @endif

        {{-- DERETAN MATERI PELATIHAN --}}
        <div class="pt-4">
            <div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    {{-- Diubah menjadi warna putih terang --}}
                    <h2 class="text-2xl sm:text-3xl font-black text-white tracking-tight">Deretan Materi Pelatihan</h2>
                    {{-- Subteks diubah menjadi putih agak soft (slate-200) --}}
                    <p class="text-sm sm:text-base text-slate-200 font-medium mt-1">Silakan mulai perjalanan belajar Anda
                        secara berurutan.</p>
                </div>
                <span
                    class="px-5 py-2.5 bg-[#FFD700]/10 text-[#FFD700] font-black text-xs sm:text-sm rounded-2xl border border-[#FFD700]/30 self-start sm:self-auto backdrop-blur-xl shadow-sm">
                    ✨ {{ isset($pelatihan->materi) ? $pelatihan->materi->count() : 0 }} Modul Tersedia
                </span>
            </div>

            <div class="space-y-4">
                @forelse($pelatihan->materi as $index => $materi)
                    @php
                        $nilaiUser = $nilaiMateri[$materi->id] ?? null;
                    @endphp
                    <div
                        class="bg-white/90 dark:bg-slate-900/90 backdrop-blur-2xl rounded-3xl shadow-xl shadow-slate-200/50 dark:shadow-none border border-slate-200/80 dark:border-slate-800 hover:border-[#FFD700] dark:hover:border-[#FFD700]/80 transition-all duration-300 group relative overflow-hidden">

                        <div class="p-6 sm:p-8 flex flex-col sm:flex-row items-start sm:items-center gap-6">

                            {{-- Nomor Urut Premium --}}
                            <div
                                class="flex-shrink-0 w-14 h-14 sm:w-16 sm:h-16 flex items-center justify-center bg-slate-100 dark:bg-slate-800/80 text-slate-700 dark:text-slate-200 rounded-2xl font-black text-lg sm:text-xl shadow-inner group-hover:bg-gradient-to-br group-hover:from-[#FFD700] group-hover:to-yellow-500 group-hover:text-slate-950 transition-all duration-500 border border-slate-200/60 dark:border-slate-700/50">
                                {{ sprintf('%02d', $index + 1) }}
                            </div>

                            {{-- Konten Materi & Status Nilai Kuis --}}
                            <div class="flex-grow space-y-3 w-full sm:w-auto">
                                <div class="flex flex-wrap items-center gap-2.5">
                                    <span
                                        class="text-[11px] font-black uppercase tracking-wider text-[#b39700] dark:text-[#FFD700] bg-[#FFD700]/10 px-3 py-1 rounded-lg border border-[#FFD700]/30">
                                        Modul Pembelajaran
                                    </span>

                                    {{-- Badge Nilai Jika Sudah Mengerjakan Kuis --}}
                                    @if ($nilaiUser)
                                        @if ($nilaiUser->nilai_total_soal >= 75)
                                            <span
                                                class="inline-flex items-center gap-1.5 px-3.5 py-1 rounded-lg text-xs font-black bg-emerald-50 text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-400 border border-emerald-200/80 dark:border-emerald-900/60 shadow-sm">
                                                <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                                Nilai: {{ number_format($nilaiUser->nilai_total_soal, 2) }} (Lulus)
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center gap-1.5 px-3.5 py-1 rounded-lg text-xs font-black bg-amber-50 text-amber-700 dark:bg-amber-950/60 dark:text-amber-400 border border-amber-200/80 dark:border-amber-900/60 shadow-sm">
                                                <svg class="w-4 h-4 text-amber-600 dark:text-amber-400" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2.5"
                                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                                    </path>
                                                </svg>
                                                Nilai: {{ number_format($nilaiUser->nilai_total_soal, 2) }} (Remidi)
                                            </span>
                                        @endif
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg text-xs font-bold bg-slate-100 text-slate-500 dark:bg-slate-800 dark:text-slate-400 border border-slate-200 dark:border-slate-700">
                                            Belum Kuis
                                        </span>
                                    @endif
                                </div>

                                <h3
                                    class="text-lg sm:text-xl font-black text-slate-900 dark:text-white group-hover:text-[#b39700] dark:group-hover:text-[#FFD700] transition-colors">
                                    {{ $materi->judul }}
                                </h3>
                                <p
                                    class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 line-clamp-2 leading-relaxed font-medium">
                                    {{ $materi->deskripsi }}
                                </p>
                            </div>

                            {{-- Tombol Aksi Modul --}}
                            <div class="flex-shrink-0 self-stretch sm:self-center w-full sm:w-auto pt-3 sm:pt-0">
                                <a href="{{ route('user-materi.show', [$pelatihan->id, $materi->id]) }}"
                                    class="w-full sm:w-auto inline-flex items-center justify-center gap-2.5 px-7 py-4 bg-gradient-to-r from-[#FFD700] to-yellow-500 hover:from-yellow-400 hover:to-yellow-600 text-slate-950 font-black text-xs sm:text-sm rounded-2xl transition-all duration-300 shadow-lg shadow-[#FFD700]/20 hover:shadow-[#FFD700]/40 hover:scale-105 active:scale-95 group/btn">
                                    <span>{{ $nilaiUser ? 'Lihat Materi / Evaluasi' : 'Mulai Belajar' }}</span>
                                    <svg class="w-4 h-4 transition-transform group-hover/btn:translate-x-1" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                    </svg>
                                </a>
                            </div>

                        </div>
                    </div>
                @empty
                    <div
                        class="text-center py-20 sm:py-24 bg-white/90 dark:bg-slate-900/90 backdrop-blur-2xl rounded-3xl border border-dashed border-slate-300 dark:border-slate-700 shadow-sm">
                        <div
                            class="w-20 h-20 mx-auto mb-5 rounded-3xl bg-[#FFD700]/10 flex items-center justify-center text-[#b39700] dark:text-[#FFD700] border border-[#FFD700]/30 shadow-inner">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                </path>
                            </svg>
                        </div>
                        <p class="text-slate-500 dark:text-slate-400 font-bold text-base sm:text-lg">Belum ada materi yang
                            ditambahkan untuk pelatihan ini.</p>
                        <p class="text-slate-400 dark:text-slate-500 text-xs sm:text-sm mt-1">Silakan kembali lagi nanti
                            saat modul telah diperbarui.</p>
                    </div>
                @endforelse
            </div>
        </div>

    </div>
@endsection
