@extends('layouts.app')

@section('content')
    <style>
        @layer utilities {
            .full-bleed {
                position: absolute;
                left: 50%;
                right: auto;
                width: 100vw;
                transform: translateX(-50%);
            }
        }
    </style>

    {{-- 🌟 TAMBAHAN: Alpine Store global untuk state modal pendaftaran.
         Dipakai supaya tombol "Daftar Sekarang" di section manapun (meski beda x-data scope)
         tetap bisa membuka modal yang sama. --}}
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('daftarModal', {
                show: @json($errors->has('referral_code')),
                step: @json($errors->has('referral_code') ? 2 : 1),
                open() {
                    this.show = true;
                    this.step = 1;
                },
                close() {
                    this.show = false;
                    this.step = 1;
                },
            });
        });
    </script>

    <section class="relative isolate bg-slate-50 font-sans text-slate-800 antialiased min-h-screen pb-24 lg:pb-12"
        x-data="{ referralCode: '', isVerified: false }">

        {{-- BACKGROUND HERO LAYER --}}
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-screen h-[480px] sm:h-[520px] lg:h-[560px] bg-cover bg-center bg-no-repeat z-0"
            style="background-image: url('https://images.unsplash.com/photo-1552664730-d307ca884978?q=80&w=800&auto=format&fit=crop');">
            <div class="absolute inset-0 bg-gradient-to-r from-slate-950/90 via-slate-900/80 to-slate-900/50"></div>
        </div>


        {{-- CONTAINER UTAMA --}}
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8 sm:pt-12 space-y-16">

            {{-- PARENT GRID CONTAINER UTAMA (Kiri & Kanan Sticky Card) --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">

                {{-- KOLOM KIRI (Konten Utama, Hero Card, & Materi) --}}
                <div class="lg:col-span-2 space-y-12">

                    {{-- Hero Left Card --}}
                    <div
                        class="bg-slate-900/75 backdrop-blur-md border border-white/10 rounded-3xl p-8 sm:p-10 shadow-2xl space-y-6 text-white">
                        <a href="{{ url()->previous() }}"
                            class="inline-flex items-center gap-2 text-xs font-semibold tracking-wider text-slate-300 uppercase hover:text-white transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                            Semua Pelatihan
                        </a>

                        <h1 class="text-3xl sm:text-5xl font-extrabold tracking-tight leading-tight">
                            {{ $pelatihan->judul }}
                        </h1>

                        <div class="flex items-center gap-2">
                            <div class="flex text-amber-400">
                                @for ($i = 0; $i < 5; $i++)
                                    <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                @endfor
                            </div>
                            <span class="text-sm font-bold">4.7</span>
                            <span class="text-xs text-slate-300">(Rating Pelatihan)</span>
                        </div>

                        <p class="text-slate-200 text-sm sm:text-base leading-relaxed">
                            {{ $pelatihan->deskripsi }}
                        </p>
                    </div>

                    {{-- Section: Apa yang Akan Dipelajari --}}
                    <div class="space-y-6 pt-4">
                        <h2 class="text-3xl font-extrabold text-slate-900">Apa yang Akan Anda Pelajari</h2>
                        <p class="text-slate-600 leading-relaxed text-sm sm:text-base">
                            Program pelatihan ini dirancang secara terstruktur untuk membantu Anda menguasai kompetensi
                            praktis dan pemahaman mendalam secara bertahap.
                        </p>

                        <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm space-y-4">
                            <div
                                class="inline-block px-3 py-1 bg-slate-100 text-slate-600 rounded-full text-xs font-bold uppercase tracking-wider">
                                Core Skills
                            </div>

                            <div class="space-y-3">
                                <div class="flex items-start gap-3">
                                    <svg class="w-5 h-5 text-sky-500 shrink-0 mt-0.5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span class="text-sm font-medium text-slate-700">Pemahaman konsep dasar dan pilar utama
                                        kompetensi industri.</span>
                                </div>
                                <div class="flex items-start gap-3">
                                    <svg class="w-5 h-5 text-sky-500 shrink-0 mt-0.5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span class="text-sm font-medium text-slate-700">Penerapan studi kasus nyata dan
                                        eksekusi alur kerja profesional.</span>
                                </div>
                                <div class="flex items-start gap-3">
                                    <svg class="w-5 h-5 text-sky-500 shrink-0 mt-0.5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span class="text-sm font-medium text-slate-700">Evaluasi terarah melalui tugas
                                        praktikum langsung.</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Section: Manfaat Mengikuti Pelatihan Ini --}}
                    <div class="space-y-6 pt-4">
                        <h2 class="text-3xl font-extrabold text-slate-900">Manfaat Mengikuti Pelatihan Ini</h2>
                        <p class="text-slate-600 leading-relaxed text-sm sm:text-base">
                            Investasikan waktu Anda untuk mendapatkan nilai tambah nyata yang dapat mengakselerasi karier
                            dan keahlian Anda.
                        </p>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm space-y-3">
                                <div
                                    class="w-10 h-10 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center font-bold">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                </div>
                                <h3 class="font-bold text-slate-900 text-base">Sertifikat Resmi Kelulusan</h3>
                                <p class="text-slate-600 text-xs sm:text-sm leading-relaxed">
                                    Dapatkan sertifikat resmi berstandar industri untuk melengkapi portofolio dan profil
                                    profesional Anda.
                                </p>
                            </div>

                            <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm space-y-3">
                                <div
                                    class="w-10 h-10 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center font-bold">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <h3 class="font-bold text-slate-900 text-base">Keahlian Siap Kerja</h3>
                                <p class="text-slate-600 text-xs sm:text-sm leading-relaxed">
                                    Kurikulum berbasis praktik langsung memastikan Anda dapat mengaplikasikan ilmu ke dunia
                                    kerja nyata secara instan.
                                </p>
                            </div>

                            <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm space-y-3">
                                <div
                                    class="w-10 h-10 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center font-bold">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </div>
                                <h3 class="font-bold text-slate-900 text-base">Networking Eksklusif</h3>
                                <p class="text-slate-600 text-xs sm:text-sm leading-relaxed">
                                    Terhubung langsung dengan sesama profesional, praktisi industri, dan instruktur
                                    berpengalaman di bidangnya.
                                </p>
                            </div>

                            <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm space-y-3">
                                <div
                                    class="w-10 h-10 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center font-bold">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 10V3L4 14h7v7l9-11h-7z" />
                                    </svg>
                                </div>
                                <h3 class="font-bold text-slate-900 text-base">Akses Materi Selamanya</h3>
                                <p class="text-slate-600 text-xs sm:text-sm leading-relaxed">
                                    Nikmati fleksibilitas belajar mandiri dengan akses tak terbatas ke seluruh rekaman modul
                                    dan materi pembelajaran.
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Section: Modul & Materi Pelatihan --}}
                    <div class="space-y-6 pt-4">
                        <h2 class="text-2xl font-bold text-slate-900">Modul & Materi Pelatihan</h2>
                        <div class="space-y-3">
                            @forelse($pelatihan->materi as $index => $materi)
                                <div x-data="{ open: false }"
                                    class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
                                    <button @click="open = !open"
                                        class="w-full flex items-center justify-between p-5 text-left hover:bg-slate-50 transition">
                                        <div class="flex items-center gap-4">
                                            <span
                                                class="w-8 h-8 rounded-xl bg-sky-50 text-sky-600 font-bold text-xs flex items-center justify-center shrink-0">
                                                {{ sprintf('%02d', $index + 1) }}
                                            </span>
                                            <h3 class="font-semibold text-slate-800 text-sm sm:text-base">
                                                {{ $materi->judul }}
                                            </h3>
                                        </div>
                                        <svg class="w-4 h-4 text-slate-400 transform transition-transform duration-200 shrink-0"
                                            :class="{ 'rotate-180': open }" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </button>

                                    <div x-show="open" x-transition
                                        class="px-5 pb-5 pt-1 border-t border-slate-100 space-y-3">
                                        <p class="text-slate-600 text-xs sm:text-sm leading-relaxed">
                                            {{ $materi->deskripsi ?? 'Tidak ada deskripsi rinci untuk modul ini.' }}
                                        </p>

                                        @if ($materi->file)
                                            @php
                                                $userStatus = strtolower(
                                                    $pelatihan->userPendaftaran->latestStatus ??
                                                        ($pelatihan->userPendaftaran->status ?? ''),
                                                );
                                                $isAccepted = in_array($userStatus, ['diterima', 'approved']);
                                            @endphp

                                            @if ($isAccepted)
                                                <div class="pt-2">
                                                    <a href="{{ Storage::url($materi->file) }}" target="_blank"
                                                        class="inline-flex items-center gap-2 text-xs font-semibold text-sky-600 hover:text-sky-700 bg-sky-50 hover:bg-sky-100 px-3.5 py-2 rounded-xl transition">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                        </svg>
                                                        Unduh Berkas Modul
                                                    </a>
                                                </div>
                                            @else
                                                <div
                                                    class="text-xs text-slate-400 italic bg-slate-50 p-3 rounded-xl border border-slate-100 flex items-center gap-2">
                                                    <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                                    </svg>
                                                    Berkas modul dapat diunduh setelah pendaftaran Anda disetujui.
                                                </div>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-8 bg-white rounded-2xl border border-slate-200">
                                    <p class="text-slate-500 text-xs sm:text-sm italic">Belum ada modul materi yang
                                        ditambahkan.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    {{-- Section: FAQ --}}
                    <div class="space-y-6 pt-4">
                        <h2 class="text-3xl font-extrabold text-slate-900">Pertanyaan yang Sering Diajukan (FAQ)</h2>
                        <div class="space-y-3">
                            <div x-data="{ openFaq: false }"
                                class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
                                <button @click="openFaq = !openFaq"
                                    class="w-full flex items-center justify-between p-5 text-left hover:bg-slate-50 transition">
                                    <h3 class="font-semibold text-slate-800 text-sm sm:text-base">Apakah pemula bisa
                                        mengikuti pelatihan ini?</h3>
                                    <svg class="w-4 h-4 text-slate-400 transform transition-transform duration-200 shrink-0"
                                        :class="{ 'rotate-180': openFaq }" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                                <div x-show="openFaq" x-transition
                                    class="px-5 pb-5 pt-1 text-slate-600 text-xs sm:text-sm leading-relaxed border-t border-slate-100">
                                    Ya, tentu saja! Pelatihan ini dirancang mulai dari tingkat dasar hingga mahir dengan
                                    panduan langkah demi langkah.
                                </div>
                            </div>

                            <div x-data="{ openFaq: false }"
                                class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
                                <button @click="openFaq = !openFaq"
                                    class="w-full flex items-center justify-between p-5 text-left hover:bg-slate-50 transition">
                                    <h3 class="font-semibold text-slate-800 text-sm sm:text-base">Bagaimana cara
                                        mendapatkan sertifikat?</h3>
                                    <svg class="w-4 h-4 text-slate-400 transform transition-transform duration-200 shrink-0"
                                        :class="{ 'rotate-180': openFaq }" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                                <div x-show="openFaq" x-transition
                                    class="px-5 pb-5 pt-1 text-slate-600 text-xs sm:text-sm leading-relaxed border-t border-slate-100">
                                    Sertifikat resmi akan otomatis diterbitkan dan dapat diunduh setelah Anda menyelesaikan
                                    seluruh materi dan modul pelatihan.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- KOLOM KANAN (STICKY CARD) --}}
                <div class="lg:col-span-1 w-full lg:sticky lg:top-24 z-20 self-start">
                    <div
                        class="bg-white rounded-3xl shadow-2xl border border-slate-100 overflow-hidden max-h-[calc(100vh-7rem)] overflow-y-auto">

                        {{-- Gambar Card --}}
                        <div class="relative h-48 sm:h-56 overflow-hidden shrink-0">
                            <img src="{{ $pelatihan->gambar ? Storage::url($pelatihan->gambar) : 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?q=80&w=800' }}"
                                alt="{{ $pelatihan->judul }}" class="w-full h-full object-cover">
                        </div>

                        {{-- Isi Card Informasi --}}
                        <div class="p-6 space-y-6">

                            {{-- Harga --}}
                            <div class="flex items-baseline gap-3">
                                <span class="text-2xl sm:text-3xl font-extrabold text-slate-900">
                                    {{ $pelatihan->harga > 0 ? 'Rp ' . number_format($pelatihan->harga, 0, ',', '.') : 'Gratis' }}
                                </span>
                            </div>

                            {{-- Tombol Pendaftaran --}}
                            <div>
                                @if ($pelatihan->userPendaftaran)
                                    @php
                                        $status = strtolower(
                                            $pelatihan->userPendaftaran->latestStatus ??
                                                ($pelatihan->userPendaftaran->status ?? 'terdaftar'),
                                        );
                                    @endphp
                                    <div
                                        class="w-full py-3 px-4 bg-sky-50 text-sky-700 border border-sky-200 rounded-xl font-bold text-center text-sm flex items-center justify-center gap-2">
                                        <span class="w-2 h-2 rounded-full bg-sky-500"></span>
                                        Status: {{ ucfirst($status) }}
                                    </div>
                                @else
                                    @if ($pelatihan->kuota > 0)
                                        {{-- 🌟 DIUBAH: sekarang memicu Alpine.store global, bukan variabel lokal --}}
                                        <button @click="$store.daftarModal.open()"
                                            class="w-full flex items-center justify-center gap-2 py-3.5 px-4 bg-sky-500 hover:bg-sky-600 active:bg-sky-700 text-white font-bold rounded-xl shadow-lg shadow-sky-500/30 transition text-sm">
                                            <span>Daftar Sekarang</span>
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                            </svg>
                                        </button>
                                    @else
                                        <button disabled
                                            class="w-full py-3.5 px-4 bg-slate-200 text-slate-500 font-bold rounded-xl cursor-not-allowed text-sm">
                                            Kuota Penuh
                                        </button>
                                    @endif
                                @endif
                            </div>

                            <div class="text-center text-[11px] text-slate-400">
                                Pembayaran Aman • Akses Sekali Bayar • Pendaftaran Langsung
                            </div>

                            {{-- Info Detail Ringkas --}}
                            <div class="grid grid-cols-2 gap-4 text-xs text-slate-700 pt-2 border-t border-slate-100">
                                <div class="flex items-start gap-2.5">
                                    <div class="p-2 bg-sky-50 text-sky-600 rounded-xl shrink-0">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <span class="font-bold block text-slate-900">Jadwal</span>
                                        <span
                                            class="text-slate-500">{{ \Carbon\Carbon::parse($pelatihan->tanggal_mulai)->format('d M Y') }}</span>
                                    </div>
                                </div>

                                <div class="flex items-start gap-2.5">
                                    <div class="p-2 bg-sky-50 text-sky-600 rounded-xl shrink-0">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <span class="font-bold block text-slate-900">Sertifikat</span>
                                        <span class="text-slate-500">Termasuk</span>
                                    </div>
                                </div>

                                <div class="flex items-start gap-2.5">
                                    <div class="p-2 bg-sky-50 text-sky-600 rounded-xl shrink-0">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <span class="font-bold block text-slate-900">Lokasi</span>
                                        <span class="text-slate-500">Online</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </section>

    {{-- ========================================================== --}}
    {{-- SEPARATE SECTION: CERTIFICATE (A certificate you can actually use) --}}
    {{-- ========================================================== --}}

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

    <br>

    <!-- Section Baru: Short Course Process & Pricing CTA (Cozy & Modern Version) -->
   <section class="relative isolate left-1/2 -translate-x-1/2 w-screen font-sans antialiased overflow-hidden">

    <!-- Bagian 1: Timeline / Proses Singkat Kursus -->
    <div
        class="bg-gradient-to-b from-slate-50 via-blue-50/20 to-white py-20 px-4 sm:px-6 lg:px-8 text-center relative">

        <!-- Ornamen Background Blur Lembut (Aesthetic Glow) -->
        <div
            class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-blue-400/10 rounded-full blur-3xl pointer-events-none">
        </div>

        <div class="relative z-10 max-w-5xl mx-auto">
            <!-- Badge -->
            <div
                class="inline-flex items-center space-x-2 mb-4 px-4 py-1.5 rounded-full bg-blue-50 border border-blue-100 text-blue-600 font-bold text-[11px] tracking-wider uppercase shadow-sm">
                <span class="w-2 h-2 rounded-full bg-blue-500 animate-pulse"></span>
                <span>Short Course, Fast Results</span>
            </div>

            <!-- Judul Utama -->
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black text-slate-900 tracking-tight mb-16">
                From start to certificate <br class="hidden sm:inline"><span
                    class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600">in about 3
                    hours</span>
            </h2>

            <!-- Grid / Timeline Items dengan Style Card Modern -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 relative text-left">

                <!-- Step 1: Start -->
                <div
                    class="group p-6 rounded-3xl bg-white border border-slate-100 shadow-xl shadow-slate-100/80 hover:shadow-2xl hover:shadow-blue-500/10 hover:border-blue-100 transition-all duration-300 flex flex-col justify-between relative">
                    <div>
                        <div
                            class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center shadow-inner mb-5 group-hover:bg-blue-600 group-hover:text-white transition-all duration-300">
                            <i class="fa-solid fa-cart-shopping text-base"></i>
                        </div>
                        <span class="text-[11px] font-extrabold text-blue-600 uppercase tracking-widest block mb-1">01
                            / Start</span>
                        <h4 class="text-base font-bold text-slate-900 mb-2 leading-snug">Enroll & start instantly</h4>
                        <p class="text-xs text-slate-500 leading-relaxed font-normal">Checkout takes a minute — chapter
                            one opens right away.</p>
                    </div>
                </div>

                <!-- Step 2: 3 Hours -->
                <div
                    class="group p-6 rounded-3xl bg-white border border-slate-100 shadow-xl shadow-slate-100/80 hover:shadow-2xl hover:shadow-blue-500/10 hover:border-blue-100 transition-all duration-300 flex flex-col justify-between relative">
                    <div>
                        <div
                            class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center shadow-inner mb-5 group-hover:bg-blue-600 group-hover:text-white transition-all duration-300">
                            <i class="fa-solid fa-book-open text-base"></i>
                        </div>
                        <span class="text-[11px] font-extrabold text-blue-600 uppercase tracking-widest block mb-1">02
                            / Learn</span>
                        <h4 class="text-base font-bold text-slate-900 mb-2 leading-snug">Read or listen to content</h4>
                        <p class="text-xs text-slate-500 leading-relaxed font-normal">Compact topics and real case
                            studies, at your own pace.</p>
                    </div>
                </div>

                <!-- Step 3: The Quiz -->
                <div
                    class="group p-6 rounded-3xl bg-white border border-slate-100 shadow-xl shadow-slate-100/80 hover:shadow-2xl hover:shadow-blue-500/10 hover:border-blue-100 transition-all duration-300 flex flex-col justify-between relative">
                    <div>
                        <div
                            class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center shadow-inner mb-5 group-hover:bg-blue-600 group-hover:text-white transition-all duration-300">
                            <i class="fa-solid fa-file-lines text-base"></i>
                        </div>
                        <span class="text-[11px] font-extrabold text-blue-600 uppercase tracking-widest block mb-1">03
                            / Practice</span>
                        <h4 class="text-base font-bold text-slate-900 mb-2 leading-snug">Take the course quiz</h4>
                        <p class="text-xs text-slate-500 leading-relaxed font-normal">Multiple choice, free retakes,
                            and completely zero time limit.</p>
                    </div>
                </div>

                <!-- Step 4: Finish -->
                <div
                    class="group p-6 rounded-3xl bg-white border border-slate-100 shadow-xl shadow-slate-100/80 hover:shadow-2xl hover:shadow-blue-500/10 hover:border-blue-100 transition-all duration-300 flex flex-col justify-between relative">
                    <div>
                        <div
                            class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center shadow-inner mb-5 group-hover:bg-blue-600 group-hover:text-white transition-all duration-300">
                            <i class="fa-solid fa-award text-base"></i>
                        </div>
                        <span class="text-[11px] font-extrabold text-blue-600 uppercase tracking-widest block mb-1">04
                            / Success</span>
                        <h4 class="text-base font-bold text-slate-900 mb-2 leading-snug">Certificate in hand</h4>
                        <p class="text-xs text-slate-500 leading-relaxed font-normal">Issued instantly — ready to add
                            right to your CV and LinkedIn.</p>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Bagian 2: Pricing & CTA dengan Background Gambar Asli (Card Dibuat Lebih Kecil & Kompak) -->
    <div
        class="relative w-full py-24 px-4 sm:px-6 lg:px-8 bg-slate-900 overflow-hidden flex items-center justify-center">

        <!-- Background Image Asli -->
        <div class="absolute inset-0 bg-cover bg-center opacity-85 scale-105 transform"
            style="background-image: url('https://images.unsplash.com/photo-1519501025264-65ba15a82390?q=80&w=1920&auto=format&fit=crop');">
        </div>

        <!-- Overlay Putih Transparan Tipis -->
        <div class="absolute inset-0 bg-white/40 backdrop-blur-[1px]"></div>

        <div class="absolute -top-40 -right-40 w-96 h-96 bg-blue-400/20 rounded-full blur-[120px] pointer-events-none">
        </div>
        <div
            class="absolute -bottom-40 -left-40 w-96 h-96 bg-sky-400/10 rounded-full blur-[120px] pointer-events-none">
        </div>

        <!-- Card Container (Diubah max-w-xl jadi max-w-md & p-8/sm:p-12 jadi p-6/sm:p-8 agar lebih kecil) -->
        <div
            class="relative z-10 max-w-md w-full mx-auto p-6 sm:p-8 rounded-3xl bg-white/90 backdrop-blur-2xl border border-white shadow-[0_20px_50px_-15px_rgba(0,0,0,0.15)] text-center text-slate-900">

            <!-- Badge kecil di dalam card -->
            <div
                class="inline-flex items-center space-x-1.5 mb-4 px-3 py-1 rounded-full bg-blue-50 border border-blue-100 text-blue-600 font-bold text-[10px] tracking-widest uppercase">
                <i class="fa-solid fa-graduation-cap text-blue-600 text-xs"></i>
                <span>Strategy and Operations</span>
            </div>

            <!-- Judul CTA -->
            <h3 class="text-2xl sm:text-3xl font-black tracking-tight mb-3 leading-tight text-slate-900">
                Start now and get certified today
            </h3>

            <p class="text-xs text-slate-600 mb-6 max-w-xs mx-auto font-medium">
                Tingkatkan keahlian profesional Anda dengan materi komprehensif yang dirancang khusus untuk hasil cepat.
            </p>

            <!-- Harga & Diskon -->
            <div
                class="inline-flex items-center justify-center space-x-3 mb-6 px-5 py-2.5 rounded-2xl bg-slate-50 border border-slate-200/80 shadow-inner">
                <span class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight">
                    {{ $pelatihan->harga > 0 ? 'Rp ' . number_format($pelatihan->harga, 0, ',', '.') : 'Gratis' }}</span>
            </div>

            <!-- Tombol Aksi -->
            <div>
                {{-- 🌟 DIUBAH: pakai $store.daftarModal.open() + @click.prevent supaya href="#" tidak scroll ke atas --}}
                <a href="#" @click.prevent="$store.daftarModal.open()"
                    class="w-full inline-flex items-center justify-center px-8 py-3.5 rounded-xl bg-gradient-to-r from-blue-600 via-blue-500 to-indigo-600 text-white font-bold text-xs sm:text-sm shadow-lg shadow-blue-500/25 hover:shadow-blue-500/40 hover:scale-[1.02] active:scale-[0.98] transition-all duration-300 group">
                    <span>Daftar Sekarang</span>
                    <i class="fa-solid fa-arrow-right ml-2 text-xs transition-transform group-hover:translate-x-1"></i>
                </a>
            </div>

        </div>
    </div>

</section>
    <section
        class="w-full font-sans antialiased py-20 px-4 sm:px-6 lg:px-8 bg-gradient-to-b from-slate-50 to-white text-center">
        <div class="max-w-7xl mx-auto">

            <!-- Badge Atas -->
            <div
                class="inline-flex items-center space-x-2 mb-4 px-4 py-1.5 rounded-full bg-blue-50 border border-blue-100 text-blue-600 font-bold text-[11px] tracking-wider uppercase shadow-sm">
                <span>Keep Learning</span>
            </div>

            <!-- Judul Utama -->
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black text-slate-900 tracking-tight mb-12">
                Pelatihan Lainnya
            </h2>

            <!-- Grid Container Card Kursus Dinamis dari Database -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 text-left mb-12">

                {{-- Pastikan Anda mengirim variabel tambahan seperti $pelatihanLainnya dari Controller, atau mengambil data dari relasi/database --}}
                @foreach ($pelatihanLainnya ?? [] as $item)
                    <div
                        class="group bg-white rounded-3xl border border-slate-100 shadow-xl shadow-slate-100/80 hover:shadow-2xl hover:shadow-blue-500/10 hover:border-blue-100 transition-all duration-300 flex flex-col justify-between overflow-hidden">
                        <div>
                            <!-- Wrapper Gambar -->
                            <div class="relative h-48 w-full overflow-hidden bg-slate-100">
                                <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->judul }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">

                                <!-- Status Badge (opsional jika ingin menampilkan status dari fillable) -->
                                <div
                                    class="absolute top-3 left-3 bg-white/90 backdrop-blur-md px-2.5 py-1 rounded-full shadow-sm text-[10px] font-extrabold text-blue-600 uppercase tracking-wider">
                                    {{ $item->status ?? 'Active' }}
                                </div>

                                <!-- Rating Dummy / Lokasi -->
                                <div
                                    class="absolute top-3 right-3 bg-white/90 backdrop-blur-md px-2.5 py-1 rounded-full shadow-sm flex items-center space-x-1 text-xs font-bold text-slate-800">
                                    <i class="fa-solid fa-location-dot text-blue-500 text-[10px]"></i>
                                    <span class="truncate max-w-[100px]">{{ $item->lokasi }}</span>
                                </div>
                            </div>

                            <!-- Konten Card (Menggunakan kolom judul & deskripsi) -->
                            <div class="p-5">
                                <h4
                                    class="text-base font-bold text-slate-900 mb-2 leading-snug group-hover:text-blue-600 transition-colors line-clamp-1">
                                    {{ $item->judul }}
                                </h4>

                                <p class="text-xs text-slate-500 mb-4 line-clamp-2 leading-relaxed">
                                    {{ $item->deskripsi }}
                                </p>

                                <!-- Fitur Singkat (Kuota & Tanggal Mulai) -->
                                <div class="space-y-1.5 text-xs text-slate-500 mb-4 border-t border-slate-100 pt-3">
                                    <div class="flex items-center space-x-1.5">
                                        <i class="fa-solid fa-users text-blue-600 text-[10px]"></i>
                                        <span>Kuota: <strong>{{ $item->kuota }} peserta</strong></span>
                                    </div>
                                    <div class="flex items-center space-x-1.5">
                                        <i class="fa-regular fa-calendar text-blue-600 text-[10px]"></i>
                                        <span>Mulai:
                                            {{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M Y') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Bagian Harga & Tombol Detail -->
                        <div
                            class="px-5 pb-5 pt-3 border-t border-dashed border-slate-100 flex items-center justify-between">
                            <div>
                                <span
                                    class="text-[10px] text-slate-400 block uppercase font-bold tracking-wider">Harga</span>
                                <span class="text-lg font-black text-slate-900">
                                    Rp {{ number_format($item->harga, 0, ',', '.') }}
                                </span>
                            </div>

                            <a href="{{ route('user-pelatihan.show', $item->id) }}"
                                class="px-3 py-1.5 rounded-xl bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white font-bold text-xs transition-all duration-300">
                                Detail
                            </a>
                        </div>
                    </div>
                @endforeach

            </div>

            <!-- Tombol "See all courses" di Bawah -->
            <div>
                <a href="{{ route('user-pelatihan.index') }}"
                    class="inline-flex items-center justify-center px-8 py-3.5 rounded-full bg-gradient-to-r from-sky-400 via-blue-500 to-blue-600 text-white font-bold text-xs sm:text-sm shadow-lg shadow-blue-500/25 hover:shadow-blue-500/40 hover:scale-105 active:scale-95 transition-all duration-300 group">
                    <span>See all courses</span>
                    <i class="fa-solid fa-arrow-right ml-2 text-xs transition-transform group-hover:translate-x-1"></i>
                </a>
            </div>

        </div>
    </section>

    {{-- 🌟 TAMBAHAN: Modal Pendaftaran Pelatihan (2 step: ringkasan -> kode referral).
         Diletakkan di luar semua <section> di atas dan pakai Alpine.store global,
         supaya bisa dipicu dari tombol manapun di halaman ini. --}}
    <div x-data="{}" x-show="$store.daftarModal.show" x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 backdrop-blur-sm"
        style="display: none;">

        <div @click.away="$store.daftarModal.close()"
            class="bg-white rounded-3xl shadow-2xl w-full max-w-lg mx-4 transform transition-all"
            x-show="$store.daftarModal.show" x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">

            <form action="{{ route('user-pelatihan.store', $pelatihan) }}" method="POST">
                @csrf
                {{-- Step 1: Informasi --}}
                <div x-show="$store.daftarModal.step === 1" class="p-6 md:p-8">
                    <h3 class="text-xl font-bold text-gray-900">Ringkasan Pelatihan</h3>
                    <p class="text-sm text-gray-500 mt-1">Anda akan mendaftar untuk program pelatihan
                        berikut:</p>

                    <div class="mt-6 space-y-4 border-t border-b border-gray-100 py-5">
                        <div class="flex items-start gap-4">
                            <img src="{{ asset('storage/' . $pelatihan->gambar) }}" alt=""
                                class="w-20 h-20 object-cover rounded-xl flex-shrink-0">
                            <div>
                                <h4 class="font-bold text-gray-800 line-clamp-1">{{ $pelatihan->judul }}
                                </h4>
                                <p class="text-xs text-gray-500 mt-1">Anda akan mempelajari materi berikut:
                                </p>
                                <ul class="mt-2 space-y-1.5 text-xs text-gray-600">
                                    @forelse ($pelatihan->materi as $materi)
                                        <li class="flex items-center gap-2">
                                            <svg class="w-3.5 h-3.5 text-blue-500 flex-shrink-0"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2.5"
                                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z">
                                                </path>
                                            </svg>
                                            <span class="line-clamp-1">{{ $materi->judul }}</span>
                                        </li>
                                    @empty
                                        <li class="text-gray-400 italic">
                                            Materi belum tersedia.
                                        </li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-500">Biaya Investasi</span>
                            <span
                                class="font-bold text-gray-900">{{ $pelatihan->harga == 0 ? 'Gratis' : 'Rp ' . number_format($pelatihan->harga, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end gap-3">
                        <button type="button" @click="$store.daftarModal.close()"
                            class="px-6 py-2.5 text-sm font-semibold text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl">
                            Batal
                        </button>
                        <button type="button" @click="$store.daftarModal.step = 2"
                            class="px-6 py-2.5 text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-xl">
                            Lanjutkan
                        </button>
                    </div>
                </div>

                {{-- Step 2: Kode Referral & Submit --}}
                <div x-show="$store.daftarModal.step === 2" class="p-6 md:p-8" style="display: none;">
                    <h3 class="text-xl font-bold text-gray-900">Kode Referral (Opsional)</h3>
                    <p class="text-sm text-gray-500 mt-1">Jika Anda memiliki kode referral, silakan
                        masukkan di bawah ini.</p>

                    <div class="mt-6">
                        <label for="referral_code" class="text-sm font-medium text-gray-700">Kode
                            Referral</label>
                        <input type="text" name="referral_code" id="referral_code"
                            value="{{ old('referral_code') }}"
                            class="mt-1 block w-full px-4 py-3 border {{ $errors->has('referral_code') ? 'border-red-400 focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:ring-blue-500 focus:border-blue-500' }} rounded-xl shadow-sm sm:text-sm"
                            placeholder="Contoh: REF123XYZ">
                        @error('referral_code')
                            <div class="mt-2 flex items-start gap-2 bg-red-50 border border-red-200 text-red-700 text-xs rounded-xl p-3">
                                <svg class="w-4 h-4 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                <span>{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    <div class="mt-8 flex justify-between items-center">
                        <button type="button" @click="$store.daftarModal.step = 1"
                            class="text-sm font-semibold text-blue-600 hover:text-blue-800">
                            &larr; Kembali
                        </button>
                        <div class="flex gap-3">
                            <button type="submit"
                                class="px-6 py-2.5 text-sm font-bold text-blue-600 bg-blue-100 hover:bg-blue-200 rounded-xl">
                                Lewati & Daftar
                            </button>
                            <button type="submit"
                                class="px-6 py-2.5 text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-xl">
                                Daftar Sekarang
                            </button>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
@endsection
