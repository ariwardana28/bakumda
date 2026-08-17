@extends('layouts.app')

@section('content')
    <div class="px-3 md:px-8 py-6 md:py-10 space-y-6 md:space-y-10 max-w-7xl mx-auto">

        {{-- Hero Banner Section: Modern Glassmorphism & Glow --}}
        <div
            class="relative bg-gradient-to-br from-slate-950 via-slate-900 to-indigo-950 rounded-2xl md:rounded-[2.55rem] p-6 sm:p-8 md:p-12 overflow-hidden shadow-2xl text-white border border-white/10">

            {{-- Background Grid & Glow Effects --}}
            <div
                class="absolute inset-0 bg-[linear-gradient(to_right,#ffffff05_1px,transparent_1px),linear-gradient(to_bottom,#ffffff05_1px,transparent_1px)] bg-[size:2rem_2rem] pointer-events-none">
            </div>
            <div
                class="absolute -right-20 -top-20 w-60 h-60 md:w-80 md:h-80 bg-cyan-500/20 rounded-full blur-3xl pointer-events-none">
            </div>
            <div
                class="absolute -left-20 -bottom-20 w-60 h-60 md:w-80 md:h-80 bg-indigo-600/20 rounded-full blur-3xl pointer-events-none">
            </div>

            <div class="relative z-10 max-w-3xl">
                {{-- Badge Kategori --}}
                <div
                    class="inline-flex items-center gap-2 mb-3 md:mb-5 px-3.5 py-1.5 bg-white/10 border border-white/15 rounded-full text-cyan-300 text-[11px] md:text-xs font-bold uppercase tracking-wider backdrop-blur-xl shadow-inner">
                    <span class="w-2 h-2 rounded-full bg-cyan-400 animate-pulse"></span>
                    Pengembangan Kompetensi & Hukum
                </div>

                <h1 class="text-2xl sm:text-3xl md:text-5xl font-black tracking-tight mb-3 md:mb-4 leading-tight">
                    Jelajahi Program <span
                        class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 via-blue-400 to-indigo-300">Pelatihan
                        Terbaik</span>
                </h1>

                <p class="text-slate-300 text-xs sm:text-sm md:text-base leading-relaxed mb-6 md:mb-8 font-normal">
                    Tingkatkan kapabilitas profesional, kuasai keahlian hukum secara mendalam, dan perbanyak wawasan
                    strategis melalui kurikulum bersertifikat kami.
                </p>

                {{-- Search Bar Modern --}}
                <form action="{{ route('user-pelatihan.index') }}" method="GET"
                    class="relative flex items-center shadow-2xl rounded-2xl overflow-hidden bg-white/10 border border-white/20 backdrop-blur-xl max-w-xl transition-all focus-within:border-cyan-400/50 focus-within:ring-4 focus-within:ring-cyan-500/10">
                    <span class="pl-4 text-cyan-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari topik pelatihan atau kata kunci..."
                        class="w-full py-3.5 px-3 text-xs md:text-sm text-white placeholder-slate-400 focus:outline-none bg-transparent font-medium">
                    <button type="submit"
                        class="bg-gradient-to-r from-cyan-500 to-blue-600 hover:from-cyan-400 hover:to-blue-500 text-slate-950 font-extrabold px-5 md:px-7 py-3.5 text-xs md:text-sm transition-all shadow-md">
                        Cari
                    </button>
                </form>
            </div>
        </div>

        {{-- Filter Bar / Header Bagian Daftar --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-2 border-b border-white/10 pb-4">
            <div>
                <h2 class="text-xl md:text-2xl font-black text-white tracking-tight">Daftar Pelatihan Aktif</h2>
                <p class="text-xs md:text-sm text-slate-400 mt-1">Pilih pelatihan yang sesuai dengan jadwal dan kebutuhan
                    pengembangan profesional Anda.</p>
            </div>
        </div>

        {{-- Grid Card Pelatihan: Modern Clean Design --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 md:gap-8 pb-12">
            @forelse($pelatihans as $item)
                <div
                    class="bg-white rounded-2xl md:rounded-3xl shadow-sm hover:shadow-2xl border border-slate-200/70 overflow-hidden flex flex-col justify-between transition-all duration-300 group hover:-translate-y-1">

                    <div>
                        {{-- Container Gambar dengan Efek Zoom --}}
                        <div class="relative h-44 sm:h-48 md:h-52 w-full bg-slate-100 overflow-hidden">
                            @if ($item->gambar)
                                <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->judul }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out">
                            @else
                                <div
                                    class="flex flex-col items-center justify-center h-full text-slate-400 space-y-2 bg-gradient-to-br from-slate-50 to-slate-100">
                                    <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span class="text-xs text-slate-400 font-medium">Tanpa Gambar</span>
                                </div>
                            @endif

                            {{-- Badge Status Floating di atas Gambar --}}
                            <div class="absolute top-3 left-3">
                                <span
                                    class="text-[10px] md:text-xs font-bold uppercase tracking-wider text-cyan-700 bg-cyan-50/90 backdrop-blur-md px-3 py-1 rounded-full shadow-sm border border-cyan-200/50">
                                    Pelatihan
                                </span>
                            </div>
                        </div>

                        {{-- Konten Utama Card --}}
                        <div class="p-4 md:p-6">
                            <h3
                                class="text-base md:text-lg font-bold text-slate-900 mb-2 line-clamp-1 group-hover:text-cyan-600 transition-colors">
                                {{ $item->judul }}
                            </h3>
                            <p class="text-slate-600 text-xs md:text-sm mb-4 line-clamp-2 leading-relaxed">
                                {{ $item->deskripsi }}
                            </p>

                            {{-- Informasi Detail (Tanggal, Biaya, & Kuota) dengan Tema Warna Baru --}}
                            <div class="space-y-2 pt-4 border-t border-slate-100 text-xs md:text-sm text-slate-600">
                                {{-- Tanggal --}}
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-7 h-7 rounded-lg bg-cyan-50 flex items-center justify-center text-cyan-600 shrink-0 shadow-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <span class="font-medium text-slate-700">
                                        {{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M Y') }}
                                    </span>
                                </div>

                                {{-- Biaya --}}
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-7 h-7 rounded-lg bg-emerald-50 flex items-center justify-center text-emerald-600 shrink-0 shadow-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <span class="font-medium text-slate-700">
                                        Biaya: <strong
                                            class="{{ $item->harga == 0 ? 'text-emerald-600 font-extrabold' : 'text-slate-900 font-bold' }}">
                                            {{ $item->harga == 0 ? 'Gratis' : 'Rp ' . number_format($item->harga, 0, ',', '.') }}
                                        </strong>
                                    </span>
                                </div>

                                {{-- Kuota --}}
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-7 h-7 rounded-lg bg-indigo-50 flex items-center justify-center text-indigo-600 shrink-0 shadow-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                    </div>
                                    <span class="font-medium text-slate-700">Kuota: <strong
                                            class="text-slate-900">{{ $item->kuota }}</strong> Peserta</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="p-4 md:p-6 pt-0">
                        @php
                            $pendaftaran = $item->userPendaftaran;
                            $status =
                                $pendaftaran && $pendaftaran->latestStatus
                                    ? strtolower($pendaftaran->latestStatus->status)
                                    : null;
                        @endphp

                        @if ($item->status == 'akan datang')
                            <a href="{{ route('user-pelatihan.show', $item) }}"
                                class="flex items-center justify-center w-full bg-amber-500 hover:bg-amber-600 text-white font-bold text-xs md:text-sm py-3 px-4 rounded-xl transition-all shadow-md shadow-amber-500/20">
                                <span>Coming Soon</span>
                            </a>
                        @elseif (!$pendaftaran)
                            <a href="{{ route('user-pelatihan.show', $item) }}"
                                class="flex items-center justify-center w-full bg-gradient-to-r from-cyan-600 to-blue-600 hover:from-cyan-500 hover:to-blue-500 text-white font-bold text-xs md:text-sm py-3 px-4 rounded-xl transition-all shadow-md shadow-cyan-600/20">
                                <span>Lihat Sekarang</span>
                            </a>
                        @elseif ($status == 'menunggu pembayaran')
                            <a href="{{ route('user-pelatihan.payment', $pendaftaran->id) }}"
                                class="flex items-center justify-center w-full bg-amber-600 hover:bg-amber-700 text-white font-bold text-xs md:text-sm py-3 px-4 rounded-xl transition-all shadow-md shadow-amber-600/20">
                                <span>Lanjutkan Pembayaran</span>
                            </a>
                        @elseif ($status == 'pembayaran disetujui')
                            <a href="{{ route('user-materi.index', $item) }}"
                                class="flex items-center justify-center w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs md:text-sm py-3 px-4 rounded-xl transition-all shadow-md shadow-emerald-600/20">
                                <span>Akses Materi Pelatihan</span>
                            </a>
                        @else
                            <a href="{{ route('user-pelatihan.status', $pendaftaran->id) }}"
                                class="flex items-center justify-center w-full bg-slate-700 hover:bg-slate-800 text-white font-bold text-xs md:text-sm py-3 px-4 rounded-xl transition-all shadow-md">
                                <span>Lihat Status Pendaftaran</span>
                            </a>
                        @endif
                    </div>
                </div>
            @empty
                <div
                    class="col-span-full text-center py-16 md:py-20 bg-white rounded-3xl border border-dashed border-slate-300 shadow-sm">
                    <div
                        class="w-16 h-16 md:w-20 md:h-20 bg-cyan-50 text-cyan-600 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-cyan-100 shadow-inner">
                        <svg class="w-8 h-8 md:w-10 md:h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                    </div>
                    <h3 class="text-base md:text-lg font-bold text-slate-800">Belum Ada Pelatihan Tersedia</h3>
                    <p class="text-slate-500 text-xs md:text-sm mt-1 max-w-sm mx-auto">Silakan cek kembali secara berkala
                        untuk menemukan program pelatihan terbaru kami.</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection
