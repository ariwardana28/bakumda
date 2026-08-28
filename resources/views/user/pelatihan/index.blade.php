@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 bg-slate-50/60 min-h-screen">

        {{-- Header Judul dengan Subtitle --}}
        <div class="text-center max-w-2xl mx-auto mb-10">
            <span
                class="text-xs font-bold uppercase tracking-wider text-sky-600 bg-sky-100/80 px-3 py-1 rounded-full mb-3 inline-block">
                E-Learning & Pelatihan
            </span>
            <h1 class="text-3xl md:text-4xl font-extrabold text-slate-900 tracking-tight mb-2">Course Catalog</h1>
            <p class="text-sm md:text-base text-slate-500">
                Tingkatkan skill dan keahlian profesional Anda melalui program pelatihan bersertifikat resmi.
            </p>
        </div>

        {{-- Kategori / Filter Bar (Modern Pill Style) --}}
        <div class="flex items-center justify-start md:justify-center gap-3 overflow-x-auto pb-4 mb-12 no-scrollbar">
            <a href="{{ route('user-pelatihan.index') }}"
                class="flex items-center gap-2 px-5 py-2.5 rounded-full text-xs font-bold transition-all duration-300 flex-shrink-0 {{ !request('pelatihan_jenis_id') ? 'bg-slate-900 text-white shadow-lg shadow-slate-900/20 scale-105' : 'bg-white border border-slate-200/80 text-slate-600 hover:border-slate-300 hover:bg-slate-100/60' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                </svg>
                <span>Semua Kategori</span>
            </a>

            @foreach ($jenisPelatihans as $jenis)
                @php
                    $isActive = request('pelatihan_jenis_id') == $jenis->id;
                @endphp
                <a href="{{ route('user-pelatihan.index', ['pelatihan_jenis_id' => $jenis->id]) }}"
                    class="flex items-center gap-2 px-5 py-2.5 rounded-full text-xs font-bold transition-all duration-300 flex-shrink-0 {{ $isActive ? 'bg-slate-900 text-white shadow-lg shadow-slate-900/20 scale-105' : 'bg-white border border-slate-200/80 text-slate-600 hover:border-slate-300 hover:bg-slate-100/60' }}">
                    <svg class="w-4 h-4 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5"></path>
                    </svg>
                    <span>{{ $jenis->nama }}</span>
                </a>
            @endforeach
        </div>

        @if (request('pelatihan_jenis_id'))
            {{-- ================================================================= --}}
            {{-- MODE FILTER: kategori spesifik dipilih -> tetap tampil per section --}}
            {{-- ================================================================= --}}
            @foreach ($jenisPelatihans as $jenis)
                @if ($jenis->id == request('pelatihan_jenis_id') && $jenis->pelatihans->count() > 0)
                    <div class="mb-16">
                        {{-- Section Header --}}
                        <div class="flex items-center justify-between mb-6 pb-3 border-b border-slate-200/60">
                            <div class="flex items-center gap-3">
                                <div class="p-2.5 bg-sky-500 text-white rounded-xl shadow-md shadow-sky-500/20">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <h2 class="text-xl font-extrabold text-slate-900 tracking-tight">{{ $jenis->nama }}</h2>
                                    <p class="text-xs text-slate-500">Jelajahi program pilihan di kategori ini</p>
                                </div>
                            </div>
                            <span
                                class="text-xs font-semibold px-3.5 py-1.5 bg-white border border-slate-200/80 rounded-full text-slate-600 shadow-sm">
                                {{ $jenis->pelatihans->count() }} Kursus Tersedia
                            </span>
                        </div>

                        {{-- Course Grid (3 Kolom) --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-7 mb-8">
                            @foreach ($jenis->pelatihans as $item)
                                @include('user.pelatihan._card', ['item' => $item])
                            @endforeach
                        </div>

                        {{-- Certificate Banner Footer --}}
                        <div
                            class="bg-gradient-to-r from-sky-900 to-slate-900 text-white rounded-3xl p-6 md:p-8 flex flex-col md:flex-row items-center justify-between shadow-xl gap-4">
                            <div class="flex items-center gap-4 text-center md:text-left">
                                <div
                                    class="p-3 bg-white/10 backdrop-blur-md text-sky-400 rounded-2xl border border-white/10 flex-shrink-0">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-bold text-base md:text-lg mb-1">Sertifikasi Resmi Kategori
                                        {{ $jenis->nama }}</h4>
                                    <p class="text-xs md:text-sm text-slate-300 font-medium">
                                        Selesaikan seluruh rangkaian kursus di kategori ini untuk mendapatkan e-sertifikat resmi
                                        tanpa biaya tambahan.
                                    </p>
                                </div>
                            </div>
                            <a href="#"
                                class="px-5 py-2.5 bg-white text-slate-900 hover:bg-sky-50 font-bold text-xs md:text-sm rounded-xl shadow-md transition-all whitespace-nowrap flex items-center gap-2">
                                <span>Pelajari Ketentuan</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </div>
                @endif
            @endforeach
        @else
            {{-- ================================================================= --}}
            {{-- MODE SEMUA KATEGORI: gabung semua pelatihan jadi 1 grid tanpa section --}}
            {{-- ================================================================= --}}
            @php
                $semuaPelatihan = $jenisPelatihans->flatMap(function ($jenis) {
                    return $jenis->pelatihans;
                });
            @endphp

            @if ($semuaPelatihan->count() > 0)
                <div class="mb-16">
                    <div class="flex items-center justify-between mb-6 pb-3 border-b border-slate-200/60">
                        <div class="flex items-center gap-3">
                            <div class="p-2.5 bg-sky-500 text-white rounded-xl shadow-md shadow-sky-500/20">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5"></path>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-xl font-extrabold text-slate-900 tracking-tight">Semua Pelatihan</h2>
                                <p class="text-xs text-slate-500">Seluruh program pelatihan yang tersedia</p>
                            </div>
                        </div>
                        <span
                            class="text-xs font-semibold px-3.5 py-1.5 bg-white border border-slate-200/80 rounded-full text-slate-600 shadow-sm">
                            {{ $semuaPelatihan->count() }} Kursus Tersedia
                        </span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-7 mb-8">
                        @foreach ($semuaPelatihan as $item)
                            @include('user.pelatihan._card', ['item' => $item])
                        @endforeach
                    </div>
                </div>
            @else
                <div class="text-center py-20 text-slate-400 italic">
                    Belum ada pelatihan yang tersedia saat ini.
                </div>
            @endif
        @endif

    </div>
@endsection