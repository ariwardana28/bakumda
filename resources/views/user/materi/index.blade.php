@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 py-6 sm:py-10 max-w-5xl relative space-y-6">

        {{-- Latar Belakang Dekoratif Glow Abstrak --}}
        <div class="absolute top-10 left-1/4 w-72 h-72 sm:w-96 sm:h-96 bg-orange-500/10 dark:bg-orange-500/5 rounded-full blur-3xl pointer-events-none -z-10"></div>
        <div class="absolute top-64 right-10 w-64 h-64 sm:w-80 sm:h-80 bg-orange-600/10 dark:bg-orange-600/5 rounded-full blur-3xl pointer-events-none -z-10"></div>

        {{-- INFORMASI LENGKAP PELATIHAN --}}
        <div class="bg-white/80 dark:bg-slate-900/80 backdrop-blur-2xl rounded-[2.5rem] shadow-xl shadow-slate-200/50 dark:shadow-none border border-slate-200/80 dark:border-slate-800 overflow-hidden relative">
            @if($pelatihan->gambar)
                <div class="w-full h-64 sm:h-96 overflow-hidden bg-slate-900 relative group">
                    <img src="{{ asset('storage/' . $pelatihan->gambar) }}" alt="{{ $pelatihan->judul }}" class="w-full h-full object-cover opacity-90 transition-transform duration-700 group-hover:scale-105">
                    
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/40 to-transparent"></div>
                    <div class="absolute inset-0 bg-gradient-to-tr from-orange-950/30 via-transparent to-orange-900/20 mix-blend-overlay"></div>
                    
                    <div class="absolute top-4 sm:top-6 right-4 sm:right-6">
                        <span class="inline-flex items-center gap-2 px-3.5 py-1.5 bg-white/20 backdrop-blur-md text-white text-[11px] font-extrabold uppercase tracking-wider rounded-full shadow-lg border border-white/30">
                            <span class="w-2 h-2 rounded-full bg-gradient-to-r from-orange-400 to-amber-500 animate-pulse shadow-sm shadow-orange-400"></span>
                            {{ $pelatihan->status ?? 'Aktif' }}
                        </span>
                    </div>

                    <div class="absolute bottom-5 left-5 right-5 sm:bottom-8 sm:left-8 sm:right-8">
                        <span class="text-[11px] sm:text-xs font-bold text-orange-300 uppercase tracking-widest mb-1.5 sm:mb-2 block drop-shadow">Detail Program Pelatihan</span>
                        <h1 class="text-xl sm:text-3xl lg:text-4xl font-extrabold text-white tracking-tight drop-shadow-md leading-snug sm:leading-tight">
                            {{ $pelatihan->judul }}
                        </h1>
                    </div>
                </div>
            @endif

            <div class="p-5 sm:p-10">
                @if(!$pelatihan->gambar)
                    <span class="text-[11px] sm:text-xs font-bold text-orange-600 dark:text-orange-400 uppercase tracking-widest mb-2 block">Detail Program Pelatihan</span>
                    <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 dark:text-white tracking-tight mb-4 leading-snug">
                        {{ $pelatihan->judul }}
                    </h1>
                @endif

                {{-- Grid Informasi (Responsive untuk Mobile 2 Kolom & Desktop 4 Kolom) --}}
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 py-5 sm:py-6 my-4 sm:my-6 border-y border-slate-100 dark:border-slate-800">
                    
                    <div class="flex items-center gap-3 sm:gap-4 p-3.5 sm:p-4 rounded-2xl bg-slate-50/80 dark:bg-slate-800/40 border border-slate-200/60 dark:border-slate-800 shadow-inner">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-orange-500/10 text-orange-600 dark:text-orange-400 flex items-center justify-center shrink-0 border border-orange-500/20">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <div class="overflow-hidden">
                            <p class="text-[10px] sm:text-[11px] text-slate-400 font-bold uppercase tracking-wider">Mulai</p>
                            <p class="text-xs sm:text-sm font-bold text-slate-800 dark:text-slate-200 truncate">{{ $pelatihan->tanggal_mulai ? \Carbon\Carbon::parse($pelatihan->tanggal_mulai)->format('d M Y') : '-' }}</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 sm:gap-4 p-3.5 sm:p-4 rounded-2xl bg-slate-50/80 dark:bg-slate-800/40 border border-slate-200/60 dark:border-slate-800 shadow-inner">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-orange-500/10 text-orange-600 dark:text-orange-400 flex items-center justify-center shrink-0 border border-orange-500/20">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <div class="overflow-hidden">
                            <p class="text-[10px] sm:text-[11px] text-slate-400 font-bold uppercase tracking-wider">Lokasi</p>
                            <p class="text-xs sm:text-sm font-bold text-slate-800 dark:text-slate-200 truncate">{{ $pelatihan->lokasi ?? 'Online' }}</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 sm:gap-4 p-3.5 sm:p-4 rounded-2xl bg-slate-50/80 dark:bg-slate-800/40 border border-slate-200/60 dark:border-slate-800 shadow-inner">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-orange-500/10 text-orange-600 dark:text-orange-400 flex items-center justify-center shrink-0 border border-orange-500/20">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div class="overflow-hidden">
                            <p class="text-[10px] sm:text-[11px] text-slate-400 font-bold uppercase tracking-wider">Harga</p>
                            <p class="text-xs sm:text-sm font-bold text-slate-800 dark:text-slate-200 truncate">{{ $pelatihan->harga > 0 ? 'Rp ' . number_format($pelatihan->harga, 0, ',', '.') : 'Gratis' }}</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 sm:gap-4 p-3.5 sm:p-4 rounded-2xl bg-slate-50/80 dark:bg-slate-800/40 border border-slate-200/60 dark:border-slate-800 shadow-inner">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-orange-500/10 text-orange-600 dark:text-orange-400 flex items-center justify-center shrink-0 border border-orange-500/20">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                        <div class="overflow-hidden">
                            <p class="text-[10px] sm:text-[11px] text-slate-400 font-bold uppercase tracking-wider">Kuota</p>
                            <p class="text-xs sm:text-sm font-bold text-slate-800 dark:text-slate-200 truncate">{{ $pelatihan->kuota ?? 'Tak terbatas' }}</p>
                        </div>
                    </div>
                </div>

                <div class="space-y-3">
                    <h3 class="text-base sm:text-lg font-extrabold text-slate-900 dark:text-white tracking-tight">Deskripsi Pelatihan</h3>
                    <div class="text-slate-600 dark:text-slate-300 leading-relaxed whitespace-pre-line text-xs sm:text-sm font-normal bg-slate-50/80 dark:bg-slate-800/40 p-5 sm:p-6 rounded-2xl border border-slate-200/60 dark:border-slate-800 shadow-inner">
                        {{ $pelatihan->deskripsi }}
                    </div>
                </div>
            </div>
        </div>

        {{-- ========================================================== --}}
        {{-- KOTAK TOMBOL CETAK SERTIFIKAT (MUNCUL JIKA SEMUA MATERI LULUS) --}}
        {{-- ========================================================== --}}
        @if(isset($semuaMateriLulus) && $semuaMateriLulus)
            <div class="relative overflow-hidden bg-gradient-to-r from-orange-500 to-amber-500 rounded-[2.5rem] p-6 sm:p-10 text-white shadow-xl shadow-orange-500/20 flex flex-col sm:flex-row items-center justify-between gap-6 sm:gap-8 border border-orange-400/30 relative z-10">
                <div class="absolute -right-10 -bottom-10 w-72 h-72 bg-white/10 rounded-full blur-3xl pointer-events-none"></div>
                
                <div class="relative z-10 text-center sm:text-left">
                    <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/20 backdrop-blur-md text-white text-[11px] font-bold uppercase tracking-wider mb-3 border border-white/30 shadow-sm">
                        <svg class="w-4 h-4 text-amber-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                        Kompetensi Pelatihan Selesai
                    </div>
                    <h3 class="text-xl sm:text-3xl font-extrabold mb-2 tracking-tight">Selamat! Sertifikat Anda Siap</h3>
                    <p class="text-orange-50 text-xs sm:text-sm max-w-xl leading-relaxed">
                        Anda telah berhasil menyelesaikan seluruh modul dan kuis pada pelatihan ini. Unduh sertifikat kelulusan resmi Anda sekarang.
                    </p>
                </div>
                
                <a href="{{ route('user.sertifikat', $pelatihan->id) }}" target="_blank" class="w-full sm:w-auto relative z-10 px-7 py-3.5 bg-white text-orange-600 hover:text-orange-700 font-bold text-xs sm:text-sm rounded-2xl shadow-lg hover:scale-105 active:scale-95 transition-all duration-200 shrink-0 flex items-center justify-center gap-2.5">
                    <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span>Cetak Sertifikat</span>
                </a>
            </div>
        @endif
        {{-- ========================================================== --}}

        {{-- DERETAN MATERI PELATIHAN --}}
        <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-3 pt-4">
            <div>
                <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight">Deretan Materi Pelatihan</h2>
                <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400">Silakan mulai perjalanan belajar Anda secara berurutan.</p>
            </div>
            <span class="px-4 py-2 bg-orange-500/10 text-orange-600 dark:text-orange-400 font-bold text-xs rounded-xl border border-orange-500/20 self-start sm:self-auto backdrop-blur-md">
                ✨ {{ isset($pelatihan->materi) ? $pelatihan->materi->count() : 0 }} Modul Tersedia
            </span>
        </div>

        <div class="space-y-4">
            @forelse($pelatihan->materi as $index => $materi)
                @php
                    $nilaiUser = $nilaiMateri[$materi->id] ?? null;
                @endphp
                <div class="bg-white/80 dark:bg-slate-900/80 backdrop-blur-2xl rounded-3xl shadow-xl shadow-slate-200/50 dark:shadow-none border border-slate-200/80 dark:border-slate-800 hover:border-orange-300 dark:hover:border-orange-700 transition-all duration-300 group relative overflow-hidden">
                    
                    <div class="p-5 sm:p-7 flex flex-col sm:flex-row items-start sm:items-center gap-5 sm:gap-6">
                        
                        {{-- Nomor Urut --}}
                        <div class="flex-shrink-0 w-12 h-12 sm:w-14 sm:h-14 flex items-center justify-center bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-200 rounded-2xl font-black text-base sm:text-lg shadow-inner group-hover:bg-orange-500 group-hover:text-white transition-all duration-300">
                            {{ sprintf('%02d', $index + 1) }}
                        </div>

                        {{-- Konten Materi & Status Nilai Kuis --}}
                        <div class="flex-grow space-y-2 w-full sm:w-auto">
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="text-[10px] font-bold uppercase tracking-wider text-orange-600 dark:text-orange-400 bg-orange-500/10 px-2.5 py-0.5 rounded-md border border-orange-500/20">Modul Pembelajaran</span>
                                
                                {{-- Badge Nilai Jika Sudah Mengerjakan Kuis --}}
                                @if($nilaiUser)
                                    @if($nilaiUser->nilai_total_soal >= 75)
                                        <span class="inline-flex items-center gap-1.5 px-3 py-0.5 rounded-md text-[11px] font-bold bg-emerald-50 text-emerald-700 dark:bg-emerald-950/50 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-900/50 shadow-sm">
                                            <svg class="w-3.5 h-3.5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                            Nilai: {{ number_format($nilaiUser->nilai_total_soal, 2) }} (Lulus)
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-3 py-0.5 rounded-md text-[11px] font-bold bg-amber-50 text-amber-700 dark:bg-amber-950/50 dark:text-amber-400 border border-amber-200 dark:border-amber-900/50 shadow-sm">
                                            <svg class="w-3.5 h-3.5 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                            Nilai: {{ number_format($nilaiUser->nilai_total_soal, 2) }} (Remidi)
                                        </span>
                                    @endif
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-md text-[11px] font-semibold bg-slate-100 text-slate-500 dark:bg-slate-800 dark:text-slate-400 border border-slate-200 dark:border-slate-700">
                                        Belum Kuis
                                    </span>
                                @endif
                            </div>

                            <h3 class="text-base sm:text-lg font-bold text-slate-900 dark:text-white group-hover:text-orange-600 dark:group-hover:text-orange-400 transition-colors">{{ $materi->judul }}</h3>
                            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 line-clamp-2 leading-relaxed">
                                {{ $materi->deskripsi }}
                            </p>
                        </div>

                        {{-- Tombol Aksi --}}
                        <div class="flex-shrink-0 self-stretch sm:self-center w-full sm:w-auto pt-2 sm:pt-0">
                            <a href="{{ route('user-materi.show', [$pelatihan->id, $materi->id]) }}"
                                class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3.5 bg-orange-500 hover:bg-orange-600 text-white font-bold text-xs rounded-xl transition-all duration-200 shadow-md shadow-orange-500/25 hover:scale-[1.02] active:scale-95 group/btn">
                                <span>{{ $nilaiUser ? 'Lihat Materi / Evaluasi' : 'Mulai Belajar' }}</span>
                                <svg class="w-4 h-4 transition-transform group-hover/btn:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                </svg>
                            </a>
                        </div>

                    </div>
                </div>
            @empty
                <div class="text-center py-16 sm:py-20 bg-white/80 dark:bg-slate-900/80 backdrop-blur-2xl rounded-3xl border border-dashed border-slate-200 dark:border-slate-800 shadow-sm">
                    <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-orange-500/10 flex items-center justify-center text-orange-600 dark:text-orange-400 border border-orange-500/20">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    </div>
                    <p class="text-slate-500 dark:text-slate-400 font-medium text-sm sm:text-base">Belum ada materi yang ditambahkan untuk pelatihan ini.</p>
                </div>
            @endforelse
        </div>

    </div>
@endsection