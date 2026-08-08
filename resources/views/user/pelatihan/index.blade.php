@extends('layouts.app')

@section('content')
    <div class="px-3 md:px-8 py-4 md:py-6 space-y-4 md:space-y-8 max-w-7xl mx-auto">

        {{-- Hero Banner Section dengan Ukuran Ringkas di Mobile & Elegan di Desktop --}}
        <div class="relative bg-gradient-to-br from-slate-950 via-indigo-950 to-slate-900 rounded-2xl md:rounded-[2rem] p-4 sm:p-6 md:p-10 overflow-hidden shadow-xl md:shadow-2xl text-white border border-white/10">

            {{-- Efek Ambient Glow dalam Banner --}}
            <div class="absolute -right-16 -top-16 w-48 h-48 md:w-64 md:h-64 bg-gradient-to-tr from-cyan-500/30 to-blue-600/30 rounded-full blur-2xl md:blur-3xl pointer-events-none"></div>
            <div class="absolute -left-16 -bottom-16 w-48 h-48 md:w-64 md:h-64 bg-gradient-to-tr from-purple-600/20 to-indigo-600/20 rounded-full blur-2xl md:blur-3xl pointer-events-none"></div>

            <div class="relative z-10 max-w-3xl">
                {{-- Badge Kategori Vibrant Glass --}}
                <div class="inline-flex items-center gap-1.5 md:gap-2 mb-2.5 md:mb-4 px-3 md:px-3.5 py-1 md:py-1.5 bg-gradient-to-r from-blue-500/20 to-cyan-500/20 border border-blue-400/30 rounded-full text-cyan-300 text-[10px] md:text-xs font-extrabold uppercase tracking-wider backdrop-blur-md">
                    <span class="w-2 h-2 md:w-2.5 md:h-2.5 rounded-full bg-cyan-400 animate-ping"></span>
                    Pengembangan Kompetensi & Hukum
                </div>

                <h1 class="text-xl sm:text-2xl md:text-4xl font-black tracking-tight mb-2 md:mb-3 leading-snug md:leading-tight">
                    Jelajahi Program <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 via-blue-400 to-indigo-300">Pelatihan Terbaik</span>
                </h1>

                <p class="text-gray-300 text-xs md:text-base leading-relaxed mb-4 md:mb-6">
                    Tingkatkan kapabilitas profesional, kuasai keahlian hukum secara mendalam, dan perbanyak wawasan strategis melalui kurikulum bersertifikat kami.
                </p>

                {{-- Search Bar Interaktif --}}
                <form action="{{ route('user-pelatihan.index') }}" method="GET"
                    class="relative flex items-center shadow-lg md:shadow-xl rounded-xl md:rounded-2xl overflow-hidden bg-white/10 border border-white/20 backdrop-blur-md max-w-xl">
                    <span class="pl-3 md:pl-4 text-cyan-300">
                        <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari topik pelatihan..."
                        class="w-full py-2.5 md:py-3.5 px-3 md:px-4 text-xs md:text-sm text-white placeholder-gray-300/70 focus:outline-none bg-transparent font-medium">
                    <button type="submit"
                        class="bg-cyan-500 hover:bg-cyan-400 text-slate-950 px-4 md:px-6 py-2.5 md:py-3.5 text-xs md:text-sm font-extrabold transition-all">
                        Cari
                    </button>
                </form>
            </div>
        </div>

        {{-- Filter Bar / Header Bagian Daftar --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-1 md:gap-2">
            <div>
                <h2 class="text-lg md:text-2xl font-black text-slate-900 tracking-tight">Daftar Pelatihan Aktif</h2>
                <p class="text-[11px] md:text-sm text-slate-500 mt-0.5">Pilih pelatihan yang sesuai dengan jadwal dan kebutuhan pengembangan profesional Anda.</p>
            </div>
        </div>

        {{-- Grid Card Pelatihan: Kompak di Mobile, Rapi & Luas di Desktop --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6 pb-12">
            @forelse($pelatihans as $item)
                <div class="bg-white rounded-xl md:rounded-2xl shadow-sm hover:shadow-xl border border-slate-200/80 overflow-hidden flex flex-col justify-between transition-all duration-300 group">

                    <div>
                        {{-- Container Gambar Responsif (Lebih pendek di mobile agar tidak terlalu memakan tempat) --}}
                        <div class="relative h-36 sm:h-44 md:h-48 w-full bg-slate-100 overflow-hidden">
                            @if ($item->gambar)
                                <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->judul }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="flex flex-col items-center justify-center h-full text-slate-400 space-y-1">
                                    <svg class="w-6 h-6 md:w-8 md:h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span class="text-[10px] md:text-xs text-slate-400 font-medium">Tanpa Gambar</span>
                                </div>
                            @endif
                        </div>

                        {{-- Konten Utama Card --}}
                        <div class="p-3.5 md:p-5">
                            <span class="text-[10px] md:text-[11px] font-bold uppercase tracking-wider text-blue-600 bg-blue-50 px-2 md:px-2.5 py-0.5 md:py-1 rounded-md mb-1.5 md:mb-2 inline-block">Pelatihan</span>

                            <h3 class="text-sm md:text-base font-bold text-slate-900 mb-1.5 md:mb-2 line-clamp-1 group-hover:text-blue-600 transition-colors">
                                {{ $item->judul }}
                            </h3>
                            <p class="text-slate-600 text-[11px] md:text-sm mb-3 md:mb-4 line-clamp-2 leading-relaxed">
                                {{ $item->deskripsi }}
                            </p>

                            {{-- Informasi Detail (Tanggal, Biaya, & Kuota) --}}
                            <div class="space-y-1.5 md:space-y-2 pt-3 md:pt-4 border-t border-slate-100 text-[11px] md:text-xs text-slate-600">
                                <div class="flex items-center gap-2 md:gap-2.5">
                                    <svg class="w-3.5 h-3.5 md:w-4 md:h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span class="font-medium text-slate-700">
                                        {{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M Y') }}
                                    </span>
                                </div>

                                <div class="flex items-center gap-2 md:gap-2.5">
                                    <svg class="w-3.5 h-3.5 md:w-4 md:h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="font-medium text-slate-700">
                                        Biaya: <strong class="{{ $item->harga == 0 ? 'text-emerald-600' : 'text-slate-900' }}">
                                            {{ $item->harga == 0 ? 'Gratis' : 'Rp ' . number_format($item->harga, 0, ',', '.') }}
                                        </strong>
                                    </span>
                                </div>

                                <div class="flex items-center gap-2 md:gap-2.5">
                                    <svg class="w-3.5 h-3.5 md:w-4 md:h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    <span class="font-medium text-slate-700">Kuota: <strong class="text-slate-900">{{ $item->kuota }}</strong> Peserta</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="p-3.5 md:p-5 pt-0">
                        @php
                            $pendaftaran = $item->userPendaftaran;
                            $status = $pendaftaran && $pendaftaran->latestStatus ? strtolower($pendaftaran->latestStatus->status) : null;
                        @endphp

                        @if (!$pendaftaran)
                            <a href="{{ route('user-pelatihan.daftar', $item) }}"
                                class="flex items-center justify-center w-full bg-slate-900 hover:bg-blue-600 text-white font-bold text-xs md:text-sm py-2.5 md:py-3 px-4 rounded-xl transition-all shadow-sm">
                                <span>Daftar Sekarang</span>
                            </a>
                        @elseif ($status == 'menunggu pembayaran')
                            <a href="{{ route('user-pelatihan.payment', $pendaftaran->id) }}"
                                class="flex items-center justify-center w-full bg-amber-600 hover:bg-amber-700 text-white font-bold text-xs md:text-sm py-2.5 md:py-3 px-4 rounded-xl transition-all shadow-sm">
                                <span>Lanjutkan Pembayaran</span>
                            </a>
                        @elseif ($status == 'pembayaran disetujui')
                            <a href="{{ route('user-materi.index', $item) }}"
                                class="flex items-center justify-center w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs md:text-sm py-2.5 md:py-3 px-4 rounded-xl transition-all shadow-sm">
                                <span>Akses Materi Pelatihan</span>
                            </a>
                        @else
                            <a href="{{ route('user-pelatihan.status', $pendaftaran->id) }}"
                                class="flex items-center justify-center w-full bg-slate-700 hover:bg-slate-800 text-white font-bold text-xs md:text-sm py-2.5 md:py-3 px-4 rounded-xl transition-all shadow-sm">
                                <span>Lihat Status Pendaftaran</span>
                            </a>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12 md:py-16 bg-white rounded-2xl border border-dashed border-slate-200 shadow-sm">
                    <div class="w-12 h-12 md:w-16 md:h-16 bg-slate-50 text-slate-400 rounded-2xl flex items-center justify-center mx-auto mb-3 md:mb-4">
                        <svg class="w-6 h-6 md:w-8 md:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                    </div>
                    <h3 class="text-sm md:text-base font-bold text-slate-800">Belum Ada Pelatihan Tersedia</h3>
                    <p class="text-slate-500 text-xs md:text-sm mt-1">Silakan cek kembali secara berkala untuk program pelatihan terbaru.</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection