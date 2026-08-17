@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8 max-w-7xl">

        {{-- Layout Utama 2 Kolom --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">

            {{-- KOLOM KIRI (Konten Utama Detail & Informasi) --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- Header Banner / Gambar Pelatihan with Overlay Gradient --}}
                <div class="relative rounded-3xl overflow-hidden bg-slate-900 shadow-2xl border border-gray-100 group">
                    <div class="relative h-72 md:h-[420px] w-full">
                        @if (isset($pelatihan->gambar) && $pelatihan->gambar)
                            <img src="{{ asset('storage/' . $pelatihan->gambar) }}"
                                alt="{{ $pelatihan->judul ?? 'Gambar Pelatihan' }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                        @else
                            <div
                                class="flex flex-col items-center justify-center h-full text-gray-400 space-y-3 bg-gradient-to-br from-slate-900 via-blue-950 to-indigo-950">
                                <div
                                    class="p-4 bg-blue-600/10 rounded-2xl border border-blue-500/20 text-blue-400 shadow-inner">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                    </svg>
                                </div>
                                <span class="text-sm font-medium text-gray-300 tracking-wide">Pusat Sertifikasi & Pelatihan
                                    Hukum</span>
                            </div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/60 via-transparent to-transparent">
                        </div>
                    </div>
                </div>

                {{-- Judul & Badge Kategori --}}
                <div class="bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-gray-100/80 space-y-4">
                    <div class="flex flex-wrap items-center gap-2.5">
                        <span
                            class="px-3.5 py-1.5 bg-blue-50 text-blue-700 border border-blue-100 rounded-full text-xs font-bold tracking-wide uppercase">
                            Sertifikasi Hukum
                        </span>
                        <span
                            class="px-3.5 py-1.5 {{ isset($pelatihan->harga) && $pelatihan->harga == 0 ? 'bg-emerald-50 text-emerald-700 border border-emerald-100' : 'bg-amber-50 text-amber-700 border border-amber-100' }} rounded-full text-xs font-bold tracking-wide">
                            {{ isset($pelatihan->harga) && $pelatihan->harga == 0 ? 'Gratis' : 'Berbayar' }}
                        </span>
                    </div>
                    <h1 class="text-2xl md:text-3xl lg:text-4xl font-extrabold tracking-tight text-gray-900 leading-snug">
                        {{ $pelatihan->judul ?? 'Pelatihan Dasar-Dasar Hukum & Kesadaran Masyarakat' }}
                    </h1>
                </div>

                {{-- Deskripsi Pelatihan --}}
                <div class="bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-gray-100/80">
                    <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-3">
                        <span class="w-1.5 h-6 bg-blue-600 rounded-full"></span>
                        Tentang Program Pelatihan
                    </h2>
                    <div class="text-gray-600 text-sm md:text-base leading-relaxed space-y-4">
                        <p>
                            {{ $pelatihan->deskripsi ?? 'Program pelatihan ini dirancang khusus untuk membekali peserta dengan pemahaman mendalam mengenai sistem hukum di Indonesia, kesadaran hukum masyarakat, serta praktik penerapan regulasi dalam kehidupan profesional maupun sosial.' }}
                        </p>
                        <p>
                            Peserta akan dibimbing langsung oleh praktisi hukum berpengalaman, akademisi, dan tenaga ahli di
                            bidangnya untuk memastikan materi yang disampaikan aplikatif dan relevan dengan dinamika hukum
                            saat ini.
                        </p>
                    </div>
                </div>

                {{-- Manfaat & Fasilitas Sertifikasi --}}
                <div class="bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-gray-100/80">
                    <h2 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-3">
                        <span class="w-1.5 h-6 bg-blue-600 rounded-full"></span>
                        Manfaat & Fasilitas Sertifikasi
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div
                            class="flex items-start gap-4 p-4 rounded-2xl bg-blue-50/40 border border-blue-100/60 transition-all hover:bg-blue-50/80">
                            <div class="p-2.5 bg-blue-600 text-white rounded-xl shadow-md shadow-blue-600/20">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900 text-sm">Sertifikat Resmi</h3>
                                <p class="text-xs text-gray-600 mt-1 leading-relaxed">Mendapatkan e-sertifikat kelulusan
                                    berstandar resmi yang diakui dalam portofolio keahlian.</p>
                            </div>
                        </div>

                        <div
                            class="flex items-start gap-4 p-4 rounded-2xl bg-emerald-50/40 border border-emerald-100/60 transition-all hover:bg-emerald-50/80">
                            <div class="p-2.5 bg-emerald-600 text-white rounded-xl shadow-md shadow-emerald-600/20">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900 text-sm">Modul & Materi Eksklusif</h3>
                                <p class="text-xs text-gray-600 mt-1 leading-relaxed">Akses penuh ke modul materi
                                    pembelajaran hukum, rekaman sesi, dan draf dokumen pendukung.</p>
                            </div>
                        </div>

                        <div
                            class="flex items-start gap-4 p-4 rounded-2xl bg-indigo-50/40 border border-indigo-100/60 transition-all hover:bg-indigo-50/80">
                            <div class="p-2.5 bg-indigo-600 text-white rounded-xl shadow-md shadow-indigo-600/20">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900 text-sm">Networking Profesional</h3>
                                <p class="text-xs text-gray-600 mt-1 leading-relaxed">Terhubung langsung dengan komunitas
                                    praktisi hukum, advokat, dan profesional lintas sektor.</p>
                            </div>
                        </div>

                        <div
                            class="flex items-start gap-4 p-4 rounded-2xl bg-amber-50/40 border border-amber-100/60 transition-all hover:bg-amber-50/80">
                            <div class="p-2.5 bg-amber-600 text-white rounded-xl shadow-md shadow-amber-600/20">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900 text-sm">Konsultasi Kasus & Tanya Jawab</h3>
                                <p class="text-xs text-gray-600 mt-1 leading-relaxed">Sesi interaktif live Q&A bersama
                                    narasumber ahli untuk membedah studi kasus nyata.</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Ketentuan Administrasi & Persyaratan Pendaftaran --}}
                <div class="bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-gray-100/80 space-y-8">
                    <div>
                        <h2 class="text-lg font-bold text-gray-900 mb-1.5 flex items-center gap-3">
                            <span class="w-1.5 h-6 bg-blue-600 rounded-full"></span>
                            Ketentuan Administrasi
                        </h2>
                        <p class="text-xs text-gray-500 mb-4">Harap membaca dan memperhatikan ketentuan administratif
                            berikut sebelum mendaftar:</p>
                        <ul class="space-y-3.5 text-sm text-gray-600">
                            <li class="flex items-start gap-3.5">
                                <span
                                    class="flex-shrink-0 w-6 h-6 bg-blue-50 text-blue-600 border border-blue-100 rounded-full flex items-center justify-center font-bold text-xs">1</span>
                                <span class="leading-relaxed">Peserta terdaftar wajib mengisi formulir pendaftaran dengan
                                    data diri yang valid sesuai kartu identitas (KTP/KTA).</span>
                            </li>
                            <li class="flex items-start gap-3.5">
                                <span
                                    class="flex-shrink-0 w-6 h-6 bg-blue-50 text-blue-600 border border-blue-100 rounded-full flex items-center justify-center font-bold text-xs">2</span>
                                <span class="leading-relaxed">Melakukan pelunasan biaya administrasi (jika pelatihan
                                    berbayar) dan mengunggah bukti transfer pada sistem paling lambat 1 hari sebelum acara
                                    dimulai.</span>
                            </li>
                            <li class="flex items-start gap-3.5">
                                <span
                                    class="flex-shrink-0 w-6 h-6 bg-blue-50 text-blue-600 border border-blue-100 rounded-full flex items-center justify-center font-bold text-xs">3</span>
                                <span class="leading-relaxed">Kehadiran peserta dalam sesi pelatihan online/offline minimal
                                    85% dari total durasi guna memenuhi syarat penerbitan sertifikat.</span>
                            </li>
                        </ul>
                    </div>

                    <hr class="border-gray-100">

                    <div>
                        <h3 class="text-base font-bold text-gray-900 mb-1.5 flex items-center gap-3">
                            <span class="w-1.5 h-5 bg-indigo-600 rounded-full"></span>
                            Persyaratan Pendaftaran Sertifikasi Hukum
                        </h3>
                        <p class="text-xs text-gray-500 mb-4">Dokumen dan persyaratan wajib yang harus disiapkan peserta:
                        </p>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm text-gray-700">
                            <div class="flex items-center gap-3 p-3.5 bg-gray-50/60 rounded-2xl border border-gray-100">
                                <div class="p-1.5 bg-blue-100 text-blue-600 rounded-lg">
                                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                <span class="font-medium text-xs">Scan / Foto KTP / Kartu Identitas Sah</span>
                            </div>
                            <div class="flex items-center gap-3 p-3.5 bg-gray-50/60 rounded-2xl border border-gray-100">
                                <div class="p-1.5 bg-blue-100 text-blue-600 rounded-lg">
                                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                <span class="font-medium text-xs">Pasfoto formal latar belakang bebas rapi</span>
                            </div>
                            <div class="flex items-center gap-3 p-3.5 bg-gray-50/60 rounded-2xl border border-gray-100">
                                <div class="p-1.5 bg-blue-100 text-blue-600 rounded-lg">
                                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                <span class="font-medium text-xs">Nomor WhatsApp aktif untuk grup koordinasi</span>
                            </div>
                            <div class="flex items-center gap-3 p-3.5 bg-gray-50/60 rounded-2xl border border-gray-100">
                                <div class="p-1.5 bg-blue-100 text-blue-600 rounded-lg">
                                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                <span class="font-medium text-xs">Alamat Email aktif untuk pengiriman e-sertifikat</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            {{-- KOLOM KANAN (Sidebar Ringkasan & Tombol Daftar) --}}
            <div class="lg:col-span-1">
                <div class="sticky top-8 bg-white rounded-3xl p-6 md:p-7 shadow-xl border border-gray-100 space-y-6">

                    {{-- Harga Pelatihan --}}
                    <div class="flex items-center justify-between pb-6 border-b border-gray-100">
                        <div>
                            <span class="text-xs text-gray-400 font-semibold uppercase tracking-wider">Investasi
                                Program</span>
                            <h3 class="text-2xl font-extrabold text-gray-900 mt-1">
                                {{ isset($pelatihan->harga) && $pelatihan->harga == 0 ? 'Gratis' : 'Rp ' . number_format($pelatihan->harga ?? 195000, 0, ',', '.') }}
                            </h3>
                        </div>
                        <span
                            class="px-3 py-1.5 bg-blue-50 text-blue-700 border border-blue-100 rounded-full text-xs font-bold tracking-wide">
                            {{ isset($pelatihan->harga) && $pelatihan->harga == 0 ? 'No Fee' : 'Tersertifikasi' }}
                        </span>
                    </div>

                    {{-- Detail Informasi Jadwal & Kuota --}}
                    <div class="space-y-4 text-sm text-gray-600 font-medium">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3 text-gray-500">
                                <div class="p-2 bg-blue-50 text-blue-600 rounded-xl">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <span>Tanggal Pelaksanaan</span>
                            </div>
                            <span class="text-gray-900 font-bold text-right">
                                {{ isset($pelatihan->tanggal_mulai) ? \Carbon\Carbon::parse($pelatihan->tanggal_mulai)->format('d M Y') : '15 Agt 2026' }}
                            </span>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3 text-gray-500">
                                <div class="p-2 bg-emerald-50 text-emerald-600 rounded-xl">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <span>Waktu Sesi</span>
                            </div>
                            <span class="text-gray-900 font-bold">09:00 - 15:00 WITA</span>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3 text-gray-500">
                                <div class="p-2 bg-amber-50 text-amber-600 rounded-xl">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </div>
                                <span>Sisa Kuota</span>
                            </div>
                            <span class="text-emerald-600 font-bold">{{ $pelatihan->kuota ?? '45' }} Peserta</span>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3 text-gray-500">
                                <div class="p-2 bg-indigo-50 text-indigo-600 rounded-xl">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <span>Status Pendaftaran</span>
                            </div>

                            {{-- Status Badge Dinamis --}}
                            @if (($pelatihan->status ?? '') == 'berlangsung')
                                <span
                                    class="px-3 py-1 bg-amber-50 text-amber-700 border border-amber-100 rounded-full text-xs font-bold">Coming
                                    Soon</span>
                            @elseif (($pelatihan->status ?? '') == 'selesai')
                                <span
                                    class="px-3 py-1 bg-gray-50 text-gray-600 border border-gray-100 rounded-full text-xs font-bold">Pelatihan
                                    Selesai</span>
                            @else
                                <span
                                    class="px-3 py-1 bg-emerald-50 text-emerald-700 border border-emerald-100 rounded-full text-xs font-bold">Dibuka</span>
                            @endif
                        </div>
                    </div>

                    {{-- Tombol Aksi Pendaftaran Dinamis --}}
                    <div class="pt-2 space-y-3">
                        @if (($pelatihan->status ?? '') == 'berlangsung')
                            <button type="button" disabled
                                class="w-full bg-gradient-to-r from-amber-500 to-orange-500 text-white font-bold py-4 px-4 rounded-2xl cursor-not-allowed shadow-lg shadow-amber-500/20 flex items-center justify-center gap-2 text-center text-sm">
                                <svg class="w-5 h-5 animate-pulse" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>Coming Soon</span>
                            </button>
                        @elseif (($pelatihan->status ?? '') == 'selesai')
                            <button type="button" disabled
                                class="w-full bg-gradient-to-r from-slate-600 to-gray-700 text-white font-bold py-4 px-4 rounded-2xl cursor-not-allowed shadow-lg shadow-gray-500/20 flex items-center justify-center gap-2 text-center text-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                <span>Pelatihan Selesai</span>
                            </button>
                        @else
                            <a href="{{ route('user-pelatihan.daftar', $pelatihan) }}"
                                class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold py-4 px-4 rounded-2xl transition-all shadow-xl shadow-blue-600/25 hover:shadow-blue-600/40 hover:-translate-y-0.5 flex items-center justify-center gap-2 text-center text-sm">
                                <span>Daftar Pelatihan Sekarang</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </a>
                        @endif

                        <a href="{{ url('/user-pelatihan') }}"
                            class="w-full bg-gray-50 hover:bg-gray-100 text-gray-700 font-semibold py-3 px-4 rounded-2xl transition-all text-center block text-sm border border-gray-200/60">
                            Kembali ke Daftar
                        </a>
                    </div>

                    {{-- Catatan Bantuan Admin --}}
                    <div class="p-4 bg-emerald-50/40 rounded-2xl border border-emerald-100/60 text-center space-y-2">
                        <p class="text-xs text-gray-600">Butuh bantuan pendaftaran atau konfirmasi pembayaran?</p>
                        <a href="https://wa.me/" target="_blank"
                            class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-700 hover:text-emerald-800 transition-colors">
                            <svg class="w-4 h-4 text-emerald-600" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.124-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z" />
                            </svg>
                            Hubungi Admin via WhatsApp
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection
