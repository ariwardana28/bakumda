@extends('layouts.app')

@section('content')
    {{-- HERO SECTION --}}
    <section
        class="relative w-full py-12 sm:py-16 flex items-center overflow-hidden p-4 sm:p-6 lg:p-8 bg-cover bg-center bg-no-repeat"
        style="background-image: url('https://www.ibm-institute.com/wp-content/uploads/2026/07/skyline-desktop-new.webp');">

        {{-- Dark Overlay --}}
        <div class="absolute inset-0 bg-slate-950/40"></div>

        {{-- Main Container --}}
        <div class="relative z-10 w-full max-w-6xl mx-auto">
            <div
                class="max-w-md p-6 sm:p-7 rounded-2xl bg-white/10 backdrop-blur-xl border border-white/20 shadow-xl text-white">

                <span class="text-[10px] sm:text-[11px] font-bold uppercase tracking-[0.18em] text-slate-200">
                    Online Courses & Certificates
                </span>

                <h1 class="mt-2.5 text-2xl sm:text-3xl font-extrabold leading-snug tracking-tight text-white">
                    Learn business skills in hours, not years.
                </h1>

                <p class="mt-2.5 text-xs sm:text-sm text-slate-200/90 leading-relaxed font-normal">
                    Choose from over 30 short, practical management courses. Start right away and earn your professional
                    certificate today.
                </p>

                <div class="mt-6 flex flex-wrap items-center gap-2.5">
                    <a href="#"
                        class="inline-flex items-center gap-1.5 px-4 py-2.5 bg-white text-slate-900 font-bold rounded-full text-xs hover:bg-slate-100 transition shadow-md">
                        <span>Explore all courses</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>

                    <a href="#"
                        class="inline-flex items-center gap-1.5 px-4 py-2.5 bg-white/10 hover:bg-white/20 text-white font-semibold rounded-full text-xs border border-white/30 backdrop-blur-md transition">
                        <span>How it works</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </a>
                </div>

                <div
                    class="mt-6 pt-4 border-t border-white/15 flex flex-wrap items-center gap-4 text-[11px] text-slate-200/90 font-medium">
                    <div class="flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <span>All levels welcome</span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M18.364 5.636a9 9 0 010 12.728m0 0l-2.829-2.829m2.829 2.829L21 21M15.536 8.464a5 5 0 010 7.072m0 0l-2.829-2.829" />
                        </svg>
                        <span>Self-paced</span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                        </svg>
                        <span>Certificate included</span>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- CATALOG SECTION --}}
    <section class="bg-slate-50 py-12">
        <div class="max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Section Title --}}
            <div class="text-center mb-8">
                <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">
                    Learn the skills that matter.
                </h2>
            </div>

            {{-- Grid Card Pelatihan --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-5 justify-center">
                @forelse($pelatihans as $pelatihan)
                    <div
                        class="bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition-all duration-200 overflow-hidden flex flex-col justify-between group">

                        <div>
                            {{-- Image & Badge Status/Rating --}}
                            <div class="relative h-44 w-full overflow-hidden bg-slate-100">
                                <img src="{{ $pelatihan->gambar ? asset('storage/' . $pelatihan->gambar) : 'https://via.placeholder.com/400x250' }}"
                                    alt="{{ $pelatihan->judul }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">

                                <div
                                    class="absolute top-3 right-3 bg-white/90 backdrop-blur-md px-2.5 py-1 rounded-full text-xs font-bold text-slate-700 shadow-sm flex items-center gap-1">
                                    <span>★</span> 4.8
                                </div>

                                @if ($pelatihan->status)
                                    <div
                                        class="absolute top-3 left-3 bg-sky-500 text-white px-2 py-0.5 rounded-md text-[10px] font-semibold uppercase tracking-wider">
                                        {{ $pelatihan->status }}
                                    </div>
                                @endif
                            </div>

                            {{-- Card Content --}}
                            <div class="p-4 text-center">
                                <h3 class="font-bold text-slate-900 text-base leading-snug line-clamp-2 min-h-[3rem]">
                                    {{ $pelatihan->judul }}
                                </h3>

                                {{-- Info Jenis & Lokasi --}}
                                <div class="mt-2 text-xs text-slate-500 flex items-center justify-center gap-2">
                                    <span class="truncate">{{ $pelatihan->jenisPelatihan->nama ?? 'Umum' }}</span>
                                    <span>•</span>
                                    <span class="truncate">{{ $pelatihan->lokasi }}</span>
                                </div>

                                {{-- Meta Info (Tanggal / Kuota) --}}
                                <div class="mt-3 flex items-center justify-center gap-3 text-xs text-slate-500">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ \Carbon\Carbon::parse($pelatihan->tanggal_mulai)->format('d M') }}
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z">
                                            </path>
                                        </svg>
                                        Sisa {{ $pelatihan->kuota }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- Card Footer --}}
                        <div class="px-4 pb-4 pt-2 border-t border-slate-50 flex items-center justify-between gap-2">
                            <a href="{{ route('user-pelatihan.show', $pelatihan->id) }}"
                                class="text-xs bg-sky-50 hover:bg-sky-100 text-sky-600 font-semibold px-3 py-1 rounded-md transition-colors flex items-center gap-1">
                                Show
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                    </path>
                                </svg>
                            </a>
                            <div class="text-right">
                                <span class="text-base font-extrabold text-slate-900">
                                    {{ $pelatihan->harga == 0 ? 'Gratis' : 'Rp ' . number_format($pelatihan->harga, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>

                    </div>
                @empty
                    <div class="col-span-full text-center py-12 text-slate-400">
                        Belum ada data pelatihan tersedia.
                    </div>
                @endforelse
            </div>

            {{-- Button Catalog --}}
            <div class="mt-10 text-center">
                <a href="{{route('user-pelatihan.katalog')}}"
                    class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-sky-400 to-sky-500 hover:from-sky-500 hover:to-sky-600 text-white font-medium text-sm rounded-full shadow-md shadow-sky-200 transition">
                    Browse the full catalog
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </a>
            </div>

        </div>
    </section>

    <section class="bg-slate-50/50 py-16 px-4 sm:px-6 lg:px-8 font-sans">
        <div class="max-w-4xl mx-auto">

            {{-- Header Section --}}
            <div class="text-center mb-16">
                <span
                    class="inline-block px-4 py-1.5 bg-sky-50 border border-sky-100 rounded-full text-[11px] font-bold text-sky-600 tracking-wider uppercase shadow-sm">
                    CARA KERJA
                </span>
                <h2 class="mt-4 text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
                    Dari ingin tahu hingga bersertifikat dalam tiga langkah.
                </h2>
            </div>

            {{-- Wrapper Timeline --}}
            <div class="relative max-w-2xl mx-auto">

                {{-- Langkah 1 --}}
                <div class="relative flex items-start gap-6 sm:gap-8 pb-12 group">
                    {{-- Garis Vertikal --}}
                    <div class="absolute left-6 top-12 bottom-0 w-0.5 bg-sky-300"></div>

                    {{-- Badge Nomor 1 (Putih -> Biru saat hover) --}}
                    <div
                        class="relative z-10 flex-shrink-0 w-12 h-12 rounded-2xl bg-white text-slate-700 font-bold text-lg flex items-center justify-center border border-slate-200 shadow-sm cursor-pointer transition-all duration-300 hover:bg-gradient-to-b hover:from-sky-400 hover:to-sky-500 hover:text-white hover:border-sky-400 hover:scale-105 hover:shadow-lg hover:shadow-sky-300/50">
                        01
                    </div>

                    {{-- Konten 1 --}}
                    <div class="pt-1.5">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                            </svg>
                            <h3 class="text-xl font-bold text-slate-900">Pilih kursus Anda</h3>
                        </div>
                        <p class="mt-2 text-sm text-slate-500 leading-relaxed">
                            Pilih keahlian tepat yang ingin Anda kembangkan. Tanpa persyaratan awal, tanpa menunggu.
                        </p>

                        {{-- Tag / Kapsul --}}
                        <div class="mt-4 flex flex-wrap gap-2">
                            <span
                                class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full bg-white border border-slate-200/80 text-xs font-medium text-slate-700 shadow-sm">
                                30+ keahlian bisnis
                                <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </span>
                            <span
                                class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full bg-white border border-slate-200/80 text-xs font-medium text-slate-700 shadow-sm">
                                Terbuka untuk siapa saja
                                <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </span>
                            <span
                                class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full bg-white border border-slate-200/80 text-xs font-medium text-slate-700 shadow-sm">
                                Fokus dunia nyata
                                <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Langkah 2 --}}
                <div class="relative flex items-start gap-6 sm:gap-8 pb-12 group">
                    {{-- Garis Vertikal --}}
                    <div class="absolute left-6 top-12 bottom-0 w-0.5 bg-sky-300"></div>

                    {{-- Badge Nomor 2 (Putih -> Biru saat hover) --}}
                    <div
                        class="relative z-10 flex-shrink-0 w-12 h-12 rounded-2xl bg-white text-slate-700 font-bold text-lg flex items-center justify-center border border-slate-200 shadow-sm cursor-pointer transition-all duration-300 hover:bg-gradient-to-b hover:from-sky-400 hover:to-sky-500 hover:text-white hover:border-sky-400 hover:scale-105 hover:shadow-lg hover:shadow-sky-300/50">
                        02
                    </div>

                    {{-- Konten 2 --}}
                    <div class="pt-1.5">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                            <h3 class="text-xl font-bold text-slate-900">Belajar sesuai kecepatan Anda</h3>
                        </div>
                        <p class="mt-2 text-sm text-slate-500 leading-relaxed">
                            Materi singkat dan terfokus yang dirancang agar sesuai di tengah kesibukan jadwal Anda.
                        </p>

                        {{-- Tag / Kapsul --}}
                        <div class="mt-4 flex flex-wrap gap-2">
                            <span
                                class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full bg-white border border-slate-200/80 text-xs font-medium text-slate-700 shadow-sm">
                                Mandiri
                                <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </span>
                            <span
                                class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full bg-white border border-slate-200/80 text-xs font-medium text-slate-700 shadow-sm">
                                Akses seumur hidup
                                <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </span>
                            <span
                                class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full bg-white border border-slate-200/80 text-xs font-medium text-slate-700 shadow-sm">
                                Hanya beberapa jam
                                <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Langkah 3 --}}
                <div class="relative flex items-start gap-6 sm:gap-8 group">
                    {{-- Titik Dekoratif Bawah --}}
                    <div class="absolute left-5 -top-3 w-2.5 h-2.5 rounded-full bg-sky-300 ring-4 ring-white z-20"></div>

                    {{-- Badge Nomor 3 (Putih -> Biru saat hover) --}}
                    <div
                        class="relative z-10 flex-shrink-0 w-12 h-12 rounded-2xl bg-white text-slate-700 font-bold text-lg flex items-center justify-center border border-slate-200 shadow-sm cursor-pointer transition-all duration-300 hover:bg-gradient-to-b hover:from-sky-400 hover:to-sky-500 hover:text-white hover:border-sky-400 hover:scale-105 hover:shadow-lg hover:shadow-sky-300/50">
                        03
                    </div>

                    {{-- Konten 3 --}}
                    <div class="pt-1.5">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                            </svg>
                            <h3 class="text-xl font-bold text-slate-900">Dapatkan sertifikat Anda</h3>
                        </div>
                        <p class="mt-2 text-sm text-slate-500 leading-relaxed">
                            Selesaikan pelatihan Anda dan sertifikat akan diterbitkan secara instan.
                        </p>

                        {{-- Tag / Kapsul --}}
                        <div class="mt-4 flex flex-wrap gap-2">
                            <span
                                class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full bg-white border border-slate-200/80 text-xs font-medium text-slate-700 shadow-sm">
                                Sertifikat instan
                                <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </span>
                            <span
                                class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full bg-white border border-slate-200/80 text-xs font-medium text-slate-700 shadow-sm">
                                Milik Anda selamanya
                                <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </span>
                            <span
                                class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full bg-white border border-slate-200/80 text-xs font-medium text-slate-700 shadow-sm">
                                Dapat diakumulasikan
                                <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>


    <section x-data="{ isVerified: false }"
        class="relative isolate left-1/2 -translate-x-1/2 w-screen overflow-x-hidden space-y-12 pt-16 border-t border-slate-200/80">

        {{-- WRAPPER KONTEN (biar tetap center & tidak ikut full-bleed) --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">

            <div class="text-center space-y-3 max-w-2xl mx-auto">
                <span
                    class="px-3.5 py-1 bg-sky-100 text-sky-700 font-bold rounded-full text-xs uppercase tracking-wider inline-block">
                    CERTIFICATE
                </span>
                <h2 class="text-3xl sm:text-5xl font-extrabold text-slate-900 tracking-tight">
                    A certificate you can actually use
                </h2>
                <p class="text-slate-600 text-sm sm:text-base">
                    Setiap kelulusan dirancang dengan kredensial digital terverifikasi yang dapat dibagikan langsung ke
                    platform profesional dan portofolio Anda.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
                {{-- Sisi Kiri: Gambar Sertifikat Interaktif --}}
                <div
                    class="relative bg-white p-6 sm:p-8 rounded-3xl shadow-xl border border-slate-200/80 overflow-hidden group">
                    <div class="relative border-4 border-slate-200 rounded-2xl p-6 sm:p-8 bg-slate-50 space-y-6">

                        {{-- Stempel Stamp "VERIFIED" yang muncul saat isVerified true --}}
                        <div x-show="isVerified" x-transition.scale
                            class="absolute top-8 right-8 z-20 border-4 border-emerald-600 text-emerald-600 px-4 py-1.5 rounded-xl font-black text-lg sm:text-xl tracking-widest transform rotate-[-12deg] bg-white/90 shadow-lg flex items-center gap-1.5">
                            <span>VERIFIED</span>
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                        </div>

                        <div class="flex items-center justify-between border-b border-slate-200 pb-4">
                            <div>
                                <h4 class="font-extrabold text-slate-900 text-sm sm:text-base">International Business
                                </h4>
                                <p class="text-xs text-slate-600 font-semibold">Management Institute</p>
                                <span class="text-[10px] text-slate-400">Berlin · Germany</span>
                            </div>
                            <div
                                class="w-12 h-12 bg-slate-900 rounded-lg flex items-center justify-center text-white font-bold text-xs">
                                IBMI
                            </div>
                        </div>

                        <div class="text-center py-4 space-y-1">
                            <p class="text-xs text-slate-500 italic">This certifies that</p>
                            <h3 class="text-xl sm:text-2xl font-black text-slate-900">David Fischer</h3>
                            <p class="text-xs text-slate-500">has successfully met the requirements for and was awarded
                                a certificate in</p>
                            <h4 class="text-lg font-bold text-slate-900 pt-1">Strategy and Operations</h4>
                        </div>

                        <div
                            class="flex items-end justify-between pt-4 border-t border-slate-200 text-[10px] text-slate-500">
                            <div>
                                <span class="block font-semibold">Certificate ID:</span>
                                <span class="font-mono text-sky-600 font-bold">IBMI-BM-8F3K2</span>
                            </div>
                            <div class="text-right">
                                <span class="block">Authorized Signature</span>
                                <span class="font-serif italic text-slate-800">David Fischer</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Sisi Kanan: Kotak Fitur & Widget Verifikasi --}}
                <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-xl border border-slate-200/80 space-y-6">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="flex items-start gap-3 p-3 bg-slate-50 rounded-2xl">
                            <div class="p-2 bg-sky-100 text-sky-600 rounded-xl shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                            <div>
                                <span class="font-bold text-sm block text-slate-900">Instant</span>
                                <span class="text-xs text-slate-500">as a digital PDF</span>
                            </div>
                        </div>

                        <div class="flex items-start gap-3 p-3 bg-slate-50 rounded-2xl">
                            <div class="p-2 bg-sky-100 text-sky-600 rounded-xl shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12z" />
                                </svg>
                            </div>
                            <div>
                                <span class="font-bold text-sm block text-slate-900">Included</span>
                                <span class="text-xs text-slate-500">no extra fees</span>
                            </div>
                        </div>

                        <div class="flex items-start gap-3 p-3 bg-slate-50 rounded-2xl">
                            <div class="p-2 bg-sky-100 text-sky-600 rounded-xl shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0 z" />
                                </svg>
                            </div>
                            <div>
                                <span class="font-bold text-sm block text-slate-900">Lifetime</span>
                                <span class="text-xs text-slate-500">no expiry</span>
                            </div>
                        </div>

                        <div class="flex items-start gap-3 p-3 bg-slate-50 rounded-2xl">
                            <div class="p-2 bg-sky-100 text-sky-600 rounded-xl shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                                </svg>
                            </div>
                            <div>
                                <span class="font-bold text-sm block text-slate-900">Shareable</span>
                                <span class="text-xs text-slate-500">LinkedIn & CV</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-slate-50 border border-slate-200/80 rounded-2xl p-4 space-y-4">
                        <div class="text-center">
                            <span
                                class="px-3 py-1 bg-white border border-slate-200 text-slate-600 text-[10px] font-bold uppercase tracking-wider rounded-full shadow-sm">
                                Demo Verification
                            </span>
                        </div>

                        <div class="flex items-center gap-2 bg-white border border-slate-300 rounded-xl p-1.5 shadow-sm">
                            <div class="pl-3 text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </div>
                            <input type="text" value="IBMI-BM-8F3K2" readonly
                                class="w-full bg-transparent text-xs sm:text-sm font-mono text-slate-700 focus:outline-none">

                            {{-- Button Verify --}}
                            <button @click="isVerified = !isVerified"
                                :class="isVerified ? 'bg-emerald-600 hover:bg-emerald-700' : 'bg-sky-500 hover:bg-sky-600'"
                                class="px-4 py-2 text-white font-bold rounded-lg text-xs transition shadow-md shrink-0 flex items-center gap-1.5">
                                <span x-text="isVerified ? 'Verified ✓' : 'Verify'">Verify</span>
                            </button>
                        </div>

                        <p class="text-center text-[11px] text-slate-400">
                            Check any real certificate ID on <a href="#"
                                class="text-sky-600 underline hover:text-sky-700">our verification page</a>.
                        </p>

                        {{-- Info Valid Certificate Detail yang Muncul saat Verified --}}
                        <div x-show="isVerified" x-transition
                            class="pt-3 border-t border-slate-200 text-center space-y-2">
                            <div
                                class="inline-flex items-center gap-1.5 text-emerald-600 text-xs font-bold bg-emerald-50 px-3 py-1 rounded-full">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                VALID CERTIFICATE
                            </div>
                            <h4 class="font-bold text-sm text-slate-900">Strategy and Operations</h4>
                            <p class="text-xs text-slate-500">Issued by IBMI Berlin to David Fischer · 15 July 2025</p>
                        </div>
                    </div>
                </div>
            </div>

        </div> {{-- /WRAPPER KONTEN --}}
        <br>
    </section>
@endsection
