@extends('layouts.admin')

@section('content')
    <div class="container mx-auto">

        {{-- Latar Belakang Dekoratif Glow Abstrak Multi-Warna (Menambah Kesan Hidup & Dinamis) --}}
        <div class="absolute top-20 left-10 w-96 h-96 bg-cyan-500/10 dark:bg-cyan-500/5 rounded-full blur-[120px] pointer-events-none -z-10">
        </div>
        <div
            class="absolute top-1/2 right-10 w-[500px] h-[500px] bg-blue-600/15 dark:bg-blue-600/10 rounded-full blur-[140px] pointer-events-none -z-10">
        </div>
        <div
            class="absolute bottom-20 left-1/3 w-96 h-96 bg-purple-600/10 dark:bg-purple-600/5 rounded-full blur-[130px] pointer-events-none -z-10">
        </div>

        {{-- Hero Banner Section dengan Glassmorphism & Gradasi Warna Vibrant --}}
        <div
            class="relative mb-14 bg-gradient-to-br from-slate-950 via-indigo-950 to-slate-900 rounded-[2.5rem] p-8 md:p-14 overflow-hidden shadow-2xl shadow-indigo-950/40 text-white border border-white/10">

            {{-- Efek Ambient Glow dalam Banner --}}
            <div
                class="absolute -right-20 -top-20 w-[420px] h-[420px] bg-gradient-to-tr from-cyan-500/30 to-blue-600/30 rounded-full blur-[90px] pointer-events-none animate-pulse">
            </div>
            <div
                class="absolute -left-20 -bottom-20 w-[420px] h-[420px] bg-gradient-to-tr from-purple-600/20 to-indigo-600/20 rounded-full blur-[90px] pointer-events-none">
            </div>

            {{-- Pola Dot Grid Halus --}}
            <div
                class="absolute inset-0 opacity-15 bg-[radial-gradient(#38bdf8_1.5px,transparent_1.5px)] [background-size:24px_24px] pointer-events-none">
            </div>

            <div class="relative z-10 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-10">
                <div class="max-w-2xl">
                    {{-- Badge Kategori Vibrant Glass --}}
                    <div
                        class="inline-flex items-center gap-2.5 mb-5 px-4.5 py-2 bg-gradient-to-r from-blue-500/20 via-indigo-500/20 to-cyan-500/20 border border-blue-400/30 rounded-full text-cyan-300 text-xs font-black uppercase tracking-wider backdrop-blur-2xl shadow-lg shadow-cyan-500/10">
                        <span class="w-2.5 h-2.5 rounded-full bg-cyan-400 animate-ping shadow-sm shadow-cyan-400"></span>
                        Pusat Pengembangan Kompetensi & Hukum
                    </div>

                    <h1 class="text-3xl md:text-5xl font-black tracking-tight mb-5 leading-[1.15]">
                        Jelajahi Program <span
                            class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 via-blue-400 to-indigo-300 drop-shadow-sm">Pelatihan
                            Terbaik</span>
                    </h1>

                    <p class="text-gray-300 text-base md:text-lg leading-relaxed mb-8 font-normal">
                        Tingkatkan kapabilitas profesional, kuasai keahlian hukum secara mendalam, dan perbanyak wawasan
                        strategis melalui kurikulum bersertifikat kami.
                    </p>

                    {{-- Search Bar Interaktif dengan Efek Glassmorphism Tinggi --}}
                    <div class="max-w-xl">
                        <form action="{{ route('user-pelatihan.index') }}" method="GET"
                            class="relative flex items-center shadow-2xl rounded-2xl overflow-hidden bg-white/10 border border-white/20 backdrop-blur-2xl focus-within:ring-2 focus-within:ring-cyan-400 focus-within:border-cyan-400 transition-all">
                            <span class="pl-5 text-cyan-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </span>
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Cari topik pelatihan, keahlian hukum, atau kata kunci..."
                                class="w-full py-4 px-4 text-sm md:text-base text-white placeholder-gray-300/70 focus:outline-none bg-transparent font-medium">
                            <button type="submit"
                                class="bg-gradient-to-r from-cyan-500 via-blue-600 to-indigo-600 hover:from-cyan-400 hover:to-indigo-500 text-white px-8 py-4 text-sm font-black transition-all shadow-lg shadow-blue-500/25 active:scale-95">
                                Cari
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Statistik Cepat dengan Efek Glassmorphism Vibrant --}}
                <div
                    class="hidden lg:flex flex-col gap-5 bg-white/[0.07] border border-white/15 backdrop-blur-2xl p-7 rounded-[2rem] min-w-[260px] shadow-2xl shadow-black/40">
                    <div>
                        <span class="text-xs text-cyan-300 uppercase tracking-widest font-extrabold">Total Pelatihan</span>
                        <h4 class="text-3xl font-black text-white mt-1">{{ isset($pelatihans) ? count($pelatihans) : 0 }}
                            <span class="text-sm font-medium text-gray-300">Program</span>
                        </h4>
                    </div>
                    <hr class="border-white/15">
                    <div>
                        <span class="text-xs text-cyan-300 uppercase tracking-widest font-extrabold">Status Akses</span>
                        <div class="flex items-center gap-2 mt-1.5 text-emerald-300 text-xs font-bold">
                            <span
                                class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-pulse shadow-sm shadow-emerald-400"></span>
                            Terbuka untuk Anggota
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Filter Bar / Header Bagian Daftar --}}
        <div class="flex items-center justify-between mb-8 flex-wrap gap-4 px-2">
            <div>
                <h2 class="text-2xl md:text-3xl font-black text-slate-900 dark:text-white tracking-tight">Daftar Pelatihan Aktif</h2>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Pilih pelatihan yang sesuai dengan jadwal dan kebutuhan pengembangan
                    profesional Anda.</p>
            </div>
        </div>

        {{-- Grid Card Pelatihan: Clean, Modern & Professional --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($pelatihans as $item)
                <div
                    class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm hover:shadow-xl dark:hover:shadow-indigo-950/40 border border-slate-200/80 dark:border-slate-800 overflow-hidden flex flex-col justify-between transition-all duration-300 group">

                    <div>
                        {{-- Container Gambar dengan Proporsi Clean --}}
                        <div class="relative h-48 w-full bg-slate-100 dark:bg-slate-800 overflow-hidden">
                            @if ($item->gambar)
                                <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->judul }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div
                                    class="flex flex-col items-center justify-center h-full text-slate-400 dark:text-slate-500 space-y-1 bg-slate-100 dark:bg-slate-800">
                                    <svg class="w-8 h-8 text-slate-300 dark:text-slate-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span class="text-xs text-slate-400 dark:text-slate-500 font-medium">Tanpa Gambar</span>
                                </div>
                            @endif
                        </div>

                        {{-- Konten Utama Card --}}
                        <div class="p-5">
                            <span
                                class="text-[11px] font-bold uppercase tracking-wider text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-950/50 px-2 py-0.5 rounded mb-2 inline-block">Pelatihan</span>

                            <h3
                                class="text-base font-bold text-slate-900 dark:text-white mb-2 line-clamp-1 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                                {{ $item->judul }}
                            </h3>
                            <p class="text-slate-600 dark:text-slate-300 text-xs md:text-sm mb-4 line-clamp-2 leading-relaxed">
                                {{ $item->deskripsi }}
                            </p>

                            {{-- Informasi Detail (Tanggal, Biaya, & Kuota) Clean List --}}
                            <div class="space-y-2 pt-4 border-t border-slate-100 dark:border-slate-800 text-xs text-slate-600 dark:text-slate-300">
                                {{-- Tanggal --}}
                                <div class="flex items-center gap-2.5">
                                    <svg class="w-4 h-4 text-slate-400 dark:text-slate-500 shrink-0" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span class="font-medium text-slate-700 dark:text-slate-300">
                                        {{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M Y') }}
                                    </span>
                                </div>

                                {{-- Biaya / Harga (Dipindah di bawah tanggal) --}}
                                <div class="flex items-center gap-2.5">
                                    <svg class="w-4 h-4 text-slate-400 dark:text-slate-500 shrink-0" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="font-medium text-slate-700 dark:text-slate-300">
                                        Biaya: <strong
                                            class="{{ $item->harga == 0 ? 'text-emerald-600 dark:text-emerald-400 font-bold' : 'text-slate-900 dark:text-white font-semibold' }}">
                                            {{ $item->harga == 0 ? 'Gratis' : 'Rp ' . number_format($item->harga, 0, ',', '.') }}
                                        </strong>
                                    </span>
                                </div>

                                {{-- Kuota --}}
                                <div class="flex items-center gap-2.5">
                                    <svg class="w-4 h-4 text-slate-400 dark:text-slate-500 shrink-0" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75"
                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    <span class="font-medium text-slate-700 dark:text-slate-300">Kuota: <strong
                                            class="text-slate-900 dark:text-white font-semibold">{{ $item->kuota }}</strong>
                                        Peserta</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Tombol Aksi yang Konsisten & Profesional --}}
                    <div class="p-5 pt-0">
                        @php
                            $pendaftaran = $item->userPendaftaran;
                            $status =
                                $pendaftaran && $pendaftaran->latestStatus
                                    ? strtolower($pendaftaran->latestStatus->status)
                                    : null;
                        @endphp

                        @if (!$pendaftaran)
                            <a href="{{ route('user-pelatihan.daftar', $item) }}"
                                class="flex items-center justify-center w-full bg-slate-900 hover:bg-blue-600 dark:bg-slate-800 dark:hover:bg-blue-600 text-white font-semibold text-xs md:text-sm py-3 px-4 rounded-xl transition-all duration-200 shadow-sm">
                                <span>Daftar Sekarang</span>
                            </a>
                        @elseif ($status == 'menunggu pembayaran')
                            <a href="{{ route('user-pelatihan.payment', $pendaftaran->id) }}"
                                class="flex items-center justify-center w-full bg-amber-600 hover:bg-amber-700 text-white font-semibold text-xs md:text-sm py-3 px-4 rounded-xl transition-all duration-200 shadow-sm">
                                <span>Lanjutkan Pembayaran</span>
                            </a>
                        @elseif ($status == 'pembayaran disetujui')
                            <a href="{{ route('user-materi.index', $item) }}"
                                class="flex items-center justify-center w-full bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-xs md:text-sm py-3 px-4 rounded-xl transition-all duration-200 shadow-sm">
                                <span>Akses Materi Pelatihan</span>
                            </a>
                        @else
                            <a href="{{ route('user-pelatihan.status', $pendaftaran->id) }}"
                                class="flex items-center justify-center w-full bg-slate-700 hover:bg-slate-800 dark:bg-slate-700 dark:hover:bg-slate-600 text-white font-semibold text-xs md:text-sm py-3 px-4 rounded-xl transition-all duration-200 shadow-sm">
                                <span>Lihat Status Pendaftaran</span>
                            </a>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-16 bg-white dark:bg-slate-900 rounded-2xl border border-dashed border-slate-200 dark:border-slate-800">
                    <div
                        class="w-16 h-16 bg-slate-50 dark:bg-slate-800 text-slate-400 dark:text-slate-500 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                    </div>
                    <h3 class="text-base font-bold text-slate-800 dark:text-white">Belum Ada Pelatihan Tersedia</h3>
                    <p class="text-slate-500 dark:text-slate-400 text-xs md:text-sm mt-1 max-w-sm mx-auto">Silakan cek kembali secara berkala
                        untuk program pelatihan terbaru.</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection