@extends('layouts.app')

@section('content')
    <div class="relative min-h-screen bg-white py-10 overflow-hidden">
        {{-- Soft Glow Background Effect --}}
        <div
            class="absolute top-0 left-1/2 -translate-x-1/2 w-full max-w-7xl h-96 bg-gradient-to-b from-sky-50/60 via-indigo-50/30 to-transparent pointer-events-none -z-10 blur-3xl">
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Header Section --}}
            <div class="text-center max-w-3xl mx-auto mb-10">
                <span
                    class="inline-flex items-center gap-1.5 text-xs font-medium uppercase tracking-widest text-sky-700 bg-sky-50 border border-sky-200/80 px-4 py-1.5 rounded-full mb-4 shadow-sm">
                    <span class="w-2 h-2 rounded-full bg-sky-500 animate-pulse"></span>
                    E-Learning & Pusat Pelatihan
                </span>

                <h1 class="text-3xl sm:text-4xl md:text-5xl font-semibold text-slate-900 tracking-tight leading-tight mb-4">
                    Selamat Datang di <br class="hidden sm:inline" />
                    <span class="bg-clip-text text-transparent bg-gradient-to-r from-sky-600 via-indigo-600 to-slate-900">
                        BAKUMDA INSTITUTE
                    </span>
                </h1>

                <p class="text-base md:text-lg text-slate-600 font-normal leading-relaxed max-w-2xl mx-auto mb-8">
                    Tingkatkan skill dan keahlian profesional Anda melalui program pelatihan interaktif bersertifikat resmi.
                </p>
            </div>

            {{-- Filter Bar (Selalu Tampil Lengkap & Berada di Tengah) --}}
            <div class="sticky top-4 z-20 mb-12 flex justify-center">
                <div
                    class="inline-flex items-center gap-2 p-2 rounded-3xl border border-slate-200/80 bg-white shadow-xl shadow-slate-100/80 max-w-full overflow-x-auto no-scrollbar">

                    {{-- Tombol Semua Kategori --}}
                    <a href="{{ route('user-pelatihan.index') }}"
                        class="flex items-center gap-2.5 px-6 py-3 rounded-2xl text-xs font-bold transition-all duration-300 whitespace-nowrap {{ !request('pelatihan_jenis_id') ? 'bg-slate-900 text-white shadow-lg shadow-slate-900/20' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100/60' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16m-7 6h7"></path>
                        </svg>
                        <span>Semua Kategori</span>
                    </a>

                    {{-- Loop Semua Jenis Pelatihan (Tetap Muncul Apapun yang Dipilih) --}}
                    @foreach ($jenisPelatihans as $jenis)
                        @php
                            $isActive = request('pelatihan_jenis_id') == $jenis->id;
                        @endphp
                        <a href="{{ route('user-pelatihan.index', ['pelatihan_jenis_id' => $jenis->id]) }}"
                            class="flex items-center gap-2.5 px-6 py-3 rounded-2xl text-xs font-bold transition-all duration-300 whitespace-nowrap {{ $isActive ? 'bg-slate-900 text-white shadow-lg shadow-slate-900/20' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100/60' }}">
                            <svg class="w-4 h-4 {{ $isActive ? 'text-sky-400' : 'text-sky-500' }}" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5"></path>
                            </svg>
                            <span>{{ $jenis->nama }}</span>
                        </a>
                    @endforeach

                </div>
            </div>

            {{-- Main Content Display --}}
            @if (request('pelatihan_jenis_id'))
                {{-- MODE FILTER: Kategori Spesifik Dipilih --}}
                @php
                    $selectedJenis = $jenisPelatihans->firstWhere('id', request('pelatihan_jenis_id'));
                @endphp

                @if ($selectedJenis && $selectedJenis->pelatihans->count() > 0)
                    <div class="mb-16">
                        {{-- Section Header --}}
                        <div
                            class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8 pb-4 border-b border-slate-200/80">
                            <div class="flex items-center gap-3.5">
                                <div
                                    class="p-3 bg-gradient-to-tr from-sky-500 to-indigo-600 text-white rounded-2xl shadow-lg shadow-sky-500/25">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <h2 class="text-2xl font-black text-slate-900 tracking-tight">{{ $selectedJenis->nama }}
                                    </h2>
                                    <p class="text-xs text-slate-500 font-medium mt-0.5">Jelajahi program pelatihan
                                        terstruktur untuk kategori ini</p>
                                </div>
                            </div>

                            {{-- Form Pencarian dalam Kategori --}}
                            <form action="{{ route('user-pelatihan.katalog') }}" method="GET"
                                class="self-start sm:self-auto w-full sm:w-auto">
                                <input type="hidden" name="pelatihan_jenis_id" value="{{ $selectedJenis->id }}">
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                        <i class="fa-solid fa-magnifying-glass text-slate-400 text-xs"></i>
                                    </div>
                                    <input type="text" name="search" value="{{ request('search') }}"
                                        placeholder="Cari di kategori ini..."
                                        class="w-full sm:w-64 pl-9 pr-4 py-2 rounded-xl border border-slate-200/90 bg-slate-50 shadow-sm text-xs font-medium text-slate-700 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-sky-500/50 focus:border-sky-500 transition">
                                </div>
                            </form>
                        </div>

                        {{-- Grid Card --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-10">
                            @foreach ($selectedJenis->pelatihans as $item)
                                @include('user.pelatihan._card', ['item' => $item])
                            @endforeach
                        </div>

                        {{-- Certificate Banner --}}
                        <div class="relative overflow-hidden bg-slate-900 rounded-3xl p-8 md:p-10 text-white shadow-xl">
                            <div class="absolute -right-10 -bottom-10 w-60 h-60 bg-sky-500/20 rounded-full blur-3xl"></div>

                            <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-6">
                                <div class="flex items-center gap-5 text-center md:text-left">
                                    <div
                                        class="p-4 bg-white/10 backdrop-blur-xl text-sky-400 rounded-2xl border border-white/10 shrink-0 mx-auto md:mx-0">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="font-extrabold text-lg md:text-xl text-white mb-1">
                                            Sertifikasi Resmi Kategori {{ $selectedJenis->nama }}
                                        </h4>
                                        <p class="text-xs md:text-sm text-slate-300 max-w-xl font-medium leading-relaxed">
                                            Selesaikan seluruh materi di kategori ini dan dapatkan e-sertifikat kelulusan
                                            resmi tanpa biaya tambahan.
                                        </p>
                                    </div>
                                </div>
                                <a href="#"
                                    class="px-6 py-3 bg-white text-slate-900 hover:bg-sky-50 font-bold text-xs md:text-sm rounded-xl shadow-lg transition-all hover:scale-105 shrink-0 flex items-center gap-2">
                                    <span>Pelajari Ketentuan</span>
                                    <svg class="w-4 h-4 text-sky-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @else
                    {{-- Empty State untuk Kategori Terpilih --}}
                    <div
                        class="text-center py-20 bg-slate-50/50 rounded-3xl border border-slate-200/60 max-w-md mx-auto my-12">
                        <div
                            class="w-14 h-14 bg-sky-100 text-sky-600 rounded-2xl flex items-center justify-center mx-auto mb-3">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-base font-bold text-slate-800">Belum Ada Pelatihan</h3>
                        <p class="text-xs text-slate-500 mt-1">Belum ada program pelatihan di kategori ini.</p>
                    </div>
                @endif
            @else
                {{-- MODE SEMUA KATEGORI --}}
                @php
                    $semuaPelatihan = $jenisPelatihans->flatMap(function ($jenis) {
                        return $jenis->pelatihans;
                    });
                @endphp

                @if ($semuaPelatihan->count() > 0)
                    <div class="mb-16">
                        <div
                            class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8 pb-4 border-b border-slate-200/80">
                            <div class="flex items-center gap-3.5">
                                <div
                                    class="p-3 bg-gradient-to-tr from-sky-500 to-indigo-600 text-white rounded-2xl shadow-lg shadow-sky-500/25">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h2 class="text-2xl font-black text-slate-900 tracking-tight">Semua Pelatihan</h2>
                                    <p class="text-xs text-slate-500 font-medium mt-0.5">Seluruh program pelatihan yang
                                        tersedia di BAKUMDA INSTITUTE</p>
                                </div>
                            </div>

                            {{-- Form Pencarian (Mode Semua Kategori: tidak perlu hidden pelatihan_jenis_id) --}}
                            <form action="{{ route('user-pelatihan.katalog') }}" method="GET"
                                class="self-start sm:self-auto w-full sm:w-auto">
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                        <i class="fa-solid fa-magnifying-glass text-slate-400 text-xs"></i>
                                    </div>
                                    <input type="text" name="search" value="{{ request('search') }}"
                                        placeholder="Cari pelatihan..."
                                        class="w-full sm:w-64 pl-9 pr-4 py-2 rounded-xl border border-slate-200/90 bg-slate-50 shadow-sm text-xs font-medium text-slate-700 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-sky-500/50 focus:border-sky-500 transition">
                                </div>
                            </form>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-10">
                            @foreach ($semuaPelatihan as $item)
                                @include('user.pelatihan._card', ['item' => $item])
                            @endforeach
                        </div>
                    </div>
                @else
                    {{-- Empty State --}}
                    <div
                        class="text-center py-20 bg-slate-50/50 rounded-3xl border border-slate-200/60 max-w-md mx-auto my-12">
                        <div
                            class="w-14 h-14 bg-sky-100 text-sky-600 rounded-2xl flex items-center justify-center mx-auto mb-3">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-base font-bold text-slate-800">Belum Ada Pelatihan</h3>
                        <p class="text-xs text-slate-500 mt-1">Saat ini belum ada program pelatihan yang tersedia.</p>
                    </div>
                @endif
            @endif

        </div>
    </div>
@endsection