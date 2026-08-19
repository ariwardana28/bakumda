<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'BAKUMDA - Bantuan Hukum Daerah')</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Alpine.js CDN -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
    @stack('styles')
</head>

<body class="bg-slate-950 font-sans text-slate-100 antialiased min-h-screen flex flex-col">

    <!-- ================================================= -->
    <!-- VIEW 1: TAMPILAN ANDROID / MOBILE                 -->
    <!-- ================================================= -->
    <div id="view-android-container" class="w-full 2xl:hidden flex-1 flex flex-col relative bg-slate-900">

        <!-- Header Tetap (Sticky) -->
        <header
            class="sticky top-0 left-0 right-0 z-40 px-6 sm:px-12 pt-8 pb-4 bg-slate-900/80 backdrop-blur-md border-b border-slate-800/50">
            <div class="flex items-center justify-between relative z-10">
                <div class="flex items-center space-x-2.5">
                    <img src="{{ asset('log.png') }}" alt="Logo" class="h-10 sm:h-12 w-auto object-contain">
                </div>
                <div class="flex items-center space-x-3">
                    <div
                        class="flex items-center bg-slate-800/85 backdrop-blur-md border border-slate-700/60 rounded-full px-3.5 py-1.5 shadow-inner">
                        <i class="fa-solid fa-magnifying-glass text-xs text-slate-400 mr-2"></i>
                        <span class="text-xs text-slate-300 font-medium tracking-wide">Pencarian...</span>
                    </div>
                    <div class="relative">
                        <button
                            class="w-9 h-9 rounded-full bg-slate-800/80 border border-slate-700/60 flex items-center justify-center text-slate-300 hover:text-white transition">
                            <i class="fa-regular fa-bell text-sm"></i>
                        </button>
                        <span
                            class="absolute -top-0.5 -right-0.5 w-4 h-4 bg-amber-500 text-slate-950 font-extrabold text-[9px] flex items-center justify-center rounded-full shadow">8</span>
                    </div>
                </div>
            </div>
        </header>

        <!-- Konten Utama yang Bisa di-scroll -->
        <main class="flex-1 overflow-y-auto px-6 sm:px-12 pt-6 pb-28">


            <!-- Hero Banner & Membership Card Grid (Mobile) -->
            <div class="grid grid-cols-1 gap-3 md:gap-6 mb-4 md:mb-8 relative z-7">

                <!-- Hero Banner Slider -->
                <div id="banner-slider-container"
                    class="relative w-full overflow-hidden rounded-3xl shadow-xl border border-slate-800 mb-1 md:mb-4 z-10">
                    <!-- Slider Track -->
                    <div class="heroSlider flex transition-transform duration-700 ease-out w-full">
                        <!-- Slide 1 -->
                        <div class="slide-item min-w-full w-full relative overflow-hidden">
                            <img src="{{ asset('b1.jpeg') }}" alt="Banner 1" class="w-full h-auto object-contain">
                        </div>
                        <!-- Slide 2 -->
                        <div class="slide-item min-w-full w-full relative overflow-hidden">
                            <img src="{{ asset('b2.jpeg') }}" alt="Banner 2" class="w-full h-auto object-contain">
                        </div>
                        <div class="slide-item min-w-full w-full relative overflow-hidden">
                            <img src="{{ asset('b3.jpeg') }}" alt="Banner 3" class="w-full h-auto object-contain">
                        </div>
                        <div class="slide-item min-w-full w-full relative overflow-hidden">
                            <img src="{{ asset('b4.jpeg') }}" alt="Banner 4" class="w-full h-auto object-contain">
                        </div>
                    </div>

                    <!-- Indikator Dots -->
                    <div class="absolute bottom-3 right-4 z-30 flex space-x-1.5" id="slider-dots">
                        <button class="dot h-2 w-5 bg-white rounded-full transition-all duration-300"
                            data-index="0"></button>
                        <button class="dot h-2 w-2 bg-white/50 rounded-full transition-all duration-300"
                            data-index="1"></button>
                        <button class="dot h-2 w-2 bg-white/50 rounded-full transition-all duration-300"
                            data-index="2"></button>
                        <button class="dot h-2 w-2 bg-white/50 rounded-full transition-all duration-300"
                            data-index="3"></button>
                    </div>
                </div>

                <!-- Skrip JavaScript Slider Banner -->
                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        const container = document.getElementById("banner-slider-container");
                        if (!container) return;

                        const slider = container.querySelector(".heroSlider");
                        const slides = container.querySelectorAll(".slide-item");
                        const dots = container.querySelectorAll("#slider-dots .dot");
                        let currentIndex = 0;
                        const totalSlides = slides.length;
                        const intervalTime = 5000;

                        function updateSlider() {
                            slider.style.transform = `translateX(-${currentIndex * 100}%)`;
                            dots.forEach((dot, index) => {
                                if (index === currentIndex) {
                                    dot.classList.remove("w-2", "bg-white/50");
                                    dot.classList.add("w-5", "bg-white");
                                } else {
                                    dot.classList.remove("w-5", "bg-white");
                                    dot.classList.add("w-2", "bg-white/50");
                                }
                            });
                        }

                        function nextSlide() {
                            currentIndex = (currentIndex + 1) % totalSlides;
                            updateSlider();
                        }

                        let slideInterval = setInterval(nextSlide, intervalTime);

                        dots.forEach((dot, index) => {
                            dot.addEventListener("click", function() {
                                currentIndex = index;
                                updateSlider();
                                clearInterval(slideInterval);
                                slideInterval = setInterval(nextSlide, intervalTime);
                            });
                        });
                    });
                </script>

                <!-- KTA / Pendaftaran Anggota (Modern & Responsif) -->
                @if (isset($isRegistered) && $isRegistered)
                    <div class="relative group mt-1 md:mt-0">
                        <div
                            class="absolute -inset-1 bg-gradient-to-r from-blue-600 to-amber-500 rounded-2xl md:rounded-3xl blur opacity-25 group-hover:opacity-40 transition duration-500">
                        </div>

                        <div
                            class="relative bg-gradient-to-br from-slate-900 via-slate-900 to-slate-950 border border-slate-700/60 rounded-2xl md:rounded-3xl p-4 md:p-6 shadow-2xl flex items-center justify-between overflow-hidden">
                            <div
                                class="absolute top-0 right-0 -mt-4 -mr-4 w-32 h-32 bg-blue-500/10 rounded-full blur-2xl pointer-events-none">
                            </div>

                            <!-- Informasi Anggota -->
                            <div class="space-y-1.5 md:space-y-2 z-10">
                                <div class="flex items-center space-x-2 mb-1">
                                    <span
                                        class="text-[10px] md:text-xs font-bold text-slate-400 uppercase tracking-wider">
                                        KTA {{ $anggota->card->latestBerlaku->jabatan ?? 'Anggota' }}
                                    </span>
                                    <span
                                        class="px-2.5 py-0.5 bg-blue-500/15 border border-blue-500/30 text-blue-400 font-bold text-[9px] md:text-[10px] uppercase rounded-full shadow-sm">
                                        {{ $status_anggota ?? 'Aktif' }}
                                    </span>
                                </div>
                                <div
                                    class="font-mono font-black text-amber-400 text-sm md:text-xl tracking-widest drop-shadow">
                                    {{ $no_ktpa ?? '7371 2094 0000 3127' }}
                                </div>
                                <p
                                    class="text-xs md:text-sm text-slate-200 font-extrabold uppercase tracking-wide mt-1">
                                    {{ $nama_anggota ?? 'DR. H. ARIS M.' }}
                                </p>
                            </div>

                            <!-- Chip Kartu Digital -->
                            <div
                                class="w-16 h-12 md:w-20 md:h-14 rounded-xl bg-gradient-to-br from-slate-800 via-slate-900 to-slate-950 border border-slate-700/80 p-2 flex flex-col justify-between shrink-0 shadow-lg z-10">
                                <div class="flex justify-between items-start">
                                    <span
                                        class="text-[7px] md:text-[8px] text-slate-400 font-black tracking-wider">BAKUMDA</span>
                                    <div
                                        class="w-2 h-2 rounded-full bg-amber-400 shadow-[0_0_8px_rgba(251,191,36,0.8)]">
                                    </div>
                                </div>
                                <div
                                    class="w-6 md:w-7 h-3 md:h-3.5 bg-gradient-to-r from-amber-400/30 to-amber-200/40 border border-amber-400/40 rounded-[3px] ml-auto flex items-center justify-center">
                                    <div class="w-full h-[1px] bg-amber-400/50"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Tampilan Pendaftaran Anggota Baru -->
                    <a href="#"
                        class="mt-1 md:mt-0 bg-gradient-to-br from-blue-900 to-indigo-950 border border-blue-800/60 rounded-3xl p-5 md:p-6 shadow-xl flex flex-col justify-between transition-transform duration-300 hover:scale-[1.02] group">
                        <div class="flex items-center justify-between gap-4">
                            <div>
                                <div class="mb-2">
                                    <span class="text-xs font-bold text-yellow-300 uppercase tracking-wider">Anda Belum
                                        Terdaftar</span>
                                </div>
                                <h4
                                    class="font-black text-white text-base md:text-lg tracking-wide group-hover:text-blue-200 transition">
                                    Ajukan Diri Menjadi Anggota BAKUMDA
                                </h4>
                                <p class="text-xs sm:text-sm text-blue-200/80 font-medium mt-1">
                                    Proses Cepat & Mudah.
                                </p>
                            </div>
                            <!-- Kartu mini/chip di sebelah kanan, sejajar secara vertikal dengan teks/tombol -->
                            <div
                                class="w-24 h-16 md:w-28 md:h-20 rounded-2xl bg-gradient-to-br from-slate-800 via-slate-900 to-slate-950 border border-slate-700/80 p-3 flex flex-col justify-between shrink-0 shadow-lg z-10 my-auto">
                                <div class="flex justify-between items-start">
                                    <span
                                        class="text-[9px] md:text-[10px] text-slate-400 font-black tracking-wider">BAKUMDA</span>
                                    <div
                                        class="w-2.5 h-2.5 rounded-full bg-amber-400 shadow-[0_0_10px_rgba(251,191,36,0.9)]">
                                    </div>
                                </div>
                                <div
                                    class="w-8 md:w-10 h-4 md:h-5 bg-gradient-to-r from-amber-400/30 to-amber-200/40 border border-amber-400/40 rounded-[4px] ml-auto flex items-center justify-center">
                                    <div class="w-full h-[1.5px] bg-amber-400/50"></div>
                                </div>
                            </div>
                        </div>
                        <div
                            class="pt-4 mt-3 border-t border-blue-800/60 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
                            <span class="text-[11px] text-blue-300 font-medium">Pastikan Anda Telah Memiliki Sertifikat
                                DIKLATKUM
                                Sebagai Syarat Utama Untuk Bergabung</span>

                            <!-- Bungkus tombol berdampingan dengan style/warna berbeda -->
                            <div class="flex items-center gap-2 shrink-0">
                                <!-- Tombol Ikuti DIKLATKUM (Warna Biru/Indigo) + class menu-item-auth -->
                                <div
                                    class="menu-item-auth bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white font-bold text-xs px-4 py-2 rounded-full shadow transition cursor-pointer">
                                    IKUTI DIKLATKUM
                                </div>

                                <!-- Tombol Daftar Keanggotaan (Warna Kuning/Oranye, Teks Putih dengan garis pinggir hitam) + class menu-item-auth -->
                                <div
                                    class="menu-item-auth bg-gradient-to-r from-yellow-400 to-orange-500 hover:from-yellow-300 hover:to-orange-400 text-white font-bold text-xs px-4 py-2 rounded-full shadow transition cursor-pointer">
                                    DAFTAR KEANGGOTAAN
                                </div>
                            </div>
                        </div>
                    </a>
                @endif
            </div>
            <br>
            <!-- Container Putih Full ke Bawah (Menghilangkan flex-1 dan menambahkan min-h-screen/margin negatif bawah agar menyatu sampai bawah layar) -->
            <div
                class="bg-white text-slate-900 rounded-t-[2.5rem] -mt-4 pt-10 px-6 sm:px-12 shadow-2xl relative z-20 space-y-8 pb-16 min-h-screen">

                <!-- ========================================== -->
                <!-- MENU UTAMA (KONDISI MOBILE vs DESKTOP)     -->
                <!-- ========================================== -->
                <div>

                    <!-- Grid Menu: Tambahkan class 'menu-item-auth' ke setiap tag <a> menu -->
                    <h3 class="text-lg font-extrabold text-slate-900 leading-tight">Fitur Eksklusif</h3><br>
                    <div class="grid grid-cols-4 min-[1281px]:grid-cols-8 gap-y-6 gap-x-4">

                        <!-- Menu 1 -->
                        <a href="{{ route('user-pelatihan.index') }}"
                            class="menu-item-auth flex flex-col items-center cursor-pointer group">
                            <div
                                class="w-16 h-16 md:w-18 md:h-18 rounded-2xl bg-gradient-to-tr from-blue-700 to-indigo-600 flex items-center justify-center text-white shadow-md shadow-blue-500/20 group-hover:scale-105 transition">
                                <i
                                    class="fa-solid fa-graduation-cap max-[1280px]:block min-[1281px]:hidden text-2xl"></i>
                                <i
                                    class="fa-solid fa-graduation-cap hidden max-[1280px]:hidden min-[1281px]:block text-xl"></i>
                            </div>
                            <span
                                class="text-xs font-semibold text-slate-700 mt-2 text-center leading-tight">E-Pelatihan</span>
                        </a>

                        <!-- Menu 2 -->
                        <a href="{{ route('sertifikat.index') }}"
                            class="menu-item-auth flex flex-col items-center cursor-pointer group">
                            <div
                                class="w-16 h-16 md:w-18 md:h-18 rounded-2xl bg-gradient-to-tr from-blue-800 to-blue-600 flex items-center justify-center text-white shadow-md shadow-blue-500/20 group-hover:scale-105 transition">
                                <i class="fa-solid fa-certificate max-[1280px]:block min-[1281px]:hidden text-2xl"></i>
                                <i
                                    class="fa-solid fa-certificate hidden max-[1280px]:hidden min-[1281px]:block text-xl"></i>
                            </div>
                            <span
                                class="text-xs font-semibold text-slate-700 mt-2 text-center leading-tight">Sertifikat</span>
                        </a>

                        <!-- Menu 3 -->
                        <a href="{{ url('/surat') }}"
                            class="menu-item-auth flex flex-col items-center cursor-pointer group">
                            <div
                                class="w-16 h-16 md:w-18 md:h-18 rounded-2xl bg-gradient-to-tr from-slate-800 to-blue-900 flex items-center justify-center text-white shadow-md shadow-blue-500/20 group-hover:scale-105 transition">
                                <i
                                    class="fa-solid fa-scale-balanced max-[1280px]:block min-[1281px]:hidden text-2xl"></i>
                                <i
                                    class="fa-solid fa-scale-balanced hidden max-[1280px]:hidden min-[1281px]:block text-xl"></i>
                            </div>
                            <span
                                class="text-xs font-semibold text-slate-700 mt-2 text-center leading-tight">Legalku</span>
                        </a>

                        <!-- Menu 4 -->
                        <a href="#" class="menu-item-auth flex flex-col items-center cursor-pointer group">
                            <div
                                class="w-16 h-16 md:w-18 md:h-18 rounded-2xl bg-gradient-to-tr from-blue-600 to-cyan-700 flex items-center justify-center text-white shadow-md shadow-blue-500/20 group-hover:scale-105 transition">
                                <i class="fa-solid fa-lightbulb max-[1280px]:block min-[1281px]:hidden text-2xl"></i>
                                <i
                                    class="fa-solid fa-lightbulb hidden max-[1280px]:hidden min-[1281px]:block text-xl"></i>
                            </div>
                            <span
                                class="text-xs font-semibold text-slate-700 mt-2 text-center leading-tight">Inspirator</span>
                        </a>

                        <!-- Menu Artikel (Tanpa class menu-item-auth agar bisa diakses publik) -->
                        <a href="{{ route('user.artikel.index') ?? '#' }}"
                            class="flex flex-col items-center cursor-pointer group">
                            <div
                                class="w-16 h-16 md:w-18 md:h-18 rounded-2xl bg-gradient-to-tr from-blue-600 to-cyan-700 flex items-center justify-center text-white shadow-md shadow-blue-500/20 group-hover:scale-105 transition">
                                <i class="fa-solid fa-newspaper max-[1280px]:block min-[1281px]:hidden text-2xl"></i>
                                <i
                                    class="fa-solid fa-newspaper hidden max-[1280px]:hidden min-[1281px]:block text-xl"></i>
                            </div>
                            <span
                                class="text-xs font-semibold text-slate-700 mt-2 text-center leading-tight">Artikel</span>
                        </a>

                        <!-- Menu 5 -->
                        <a href="#" class="menu-item-auth flex flex-col items-center cursor-pointer group">
                            <div
                                class="w-16 h-16 md:w-18 md:h-18 rounded-2xl bg-gradient-to-tr from-amber-600 to-yellow-600 flex items-center justify-center text-white shadow-md shadow-amber-500/20 group-hover:scale-105 transition">
                                <i class="fa-solid fa-sitemap max-[1280px]:block min-[1281px]:hidden text-2xl"></i>
                                <i
                                    class="fa-solid fa-sitemap hidden max-[1280px]:hidden min-[1281px]:block text-xl"></i>
                            </div>
                            <span
                                class="text-xs font-semibold text-slate-700 mt-2 text-center leading-tight">Korwil</span>
                        </a>

                        <!-- Menu 6 -->
                        <a href="{{ url('/about') }}"
                            class="menu-item-auth flex flex-col items-center cursor-pointer group">
                            <div
                                class="w-16 h-16 md:w-18 md:h-18 rounded-2xl bg-gradient-to-tr from-blue-900 to-slate-900 flex items-center justify-center text-white shadow-md shadow-blue-500/20 group-hover:scale-105 transition">
                                <i
                                    class="fa-solid fa-network-wired max-[1280px]:block min-[1281px]:hidden text-2xl"></i>
                                <i
                                    class="fa-solid fa-network-wired hidden max-[1280px]:hidden min-[1281px]:block text-xl"></i>
                            </div>
                            <span
                                class="text-xs font-semibold text-slate-700 mt-2 text-center leading-tight">E-Organisasi</span>
                        </a>

                        <!-- Menu 7 -->
                        <a href="{{ route('merchandise.index') }}"
                            class="menu-item-auth flex flex-col items-center cursor-pointer group">
                            <div
                                class="w-16 h-16 md:w-18 md:h-18 rounded-2xl bg-gradient-to-tr from-red-600 to-rose-800 flex items-center justify-center text-white shadow-md shadow-red-500/20 group-hover:scale-105 transition">
                                <i class="fa-solid fa-handshake max-[1280px]:block min-[1281px]:hidden text-2xl"></i>
                                <i
                                    class="fa-solid fa-handshake hidden max-[1280px]:hidden min-[1281px]:block text-xl"></i>
                            </div>
                            <span class="text-xs font-semibold text-slate-700 mt-2 text-center leading-tight">Kerja
                                Sama</span>
                        </a>

                    </div>
                </div>

                <!-- Program Bantuan Hukum (Slider) -->
                <div id="slider-container-pelatihan" class="relative">
                    <br>
                    <br>
                    <div class="flex justify-between items-center mb-4">
                        <div>
                            <h3 class="text-lg font-extrabold text-slate-900 leading-tight">Program Pelatihan</h3>
                            <span class="text-xs text-slate-400 font-medium">Geser otomatis atau gunakan tombol</span>
                        </div>

                        <!-- Tombol Navigasi Manual -->
                        <div class="flex items-center space-x-2">
                            <button id="slide-left-btn"
                                class="w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-700 flex items-center justify-center transition shadow-sm">
                                <i class="fa-solid fa-chevron-left text-xs"></i>
                            </button>
                            <button id="slide-right-btn"
                                class="w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-700 flex items-center justify-center transition shadow-sm">
                                <i class="fa-solid fa-chevron-right text-xs"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Slider Container dengan Tambahan CSS Inline untuk Menyembunyikan Scrollbar secara Total -->
                    <div id="pelatihan-slider"
                        class="flex overflow-x-auto space-x-4 pb-4 -mx-4 sm:-mx-6 px-4 sm:px-6 snap-x snap-mandatory scroll-smooth"
                        style="scrollbar-width: none; -ms-overflow-style: none;">

                        <!-- CSS tambahan khusus untuk webkit (Chrome, Safari, Edge) agar scrollbar benar-benar hilang -->
                        <style>
                            #pelatihan-slider::-webkit-scrollbar {
                                display: none;
                            }
                        </style>

                        @foreach ($pelatihans as $index => $pelatihan)
                            @php
                                $bgGradient = match ($index % 3) {
                                    0 => 'from-blue-800 to-indigo-900',
                                    1 => 'from-slate-800 to-blue-900',
                                    default => 'from-slate-900 to-slate-800',
                                };
                            @endphp

                            <a href="{{ route('user-pelatihan.show', $pelatihan) }}"
                                class="menu-item-auth snap-start shrink-0 w-[280px] sm:w-[320px] bg-gradient-to-br {{ $bgGradient }} rounded-2xl p-6 text-white shadow-md flex flex-col justify-between h-[180px] transition-transform duration-300 hover:scale-105">
                                <div>
                                    <h4 class="font-black text-base tracking-wide">{{ $pelatihan->judul }}</h4>
                                    <div class="mt-2 text-xs opacity-90 space-y-1 font-medium">
                                        <p>• Mulai:
                                            {{ \Carbon\Carbon::parse($pelatihan->tanggal_mulai)->translatedFormat('d F Y') }}
                                        </p>
                                        <p class="text-sm font-extrabold text-amber-400 mt-1">
                                            Rp {{ number_format($pelatihan->harga, 0, ',', '.') }}
                                        </p>
                                    </div>
                                </div>
                                <div
                                    class="bg-white text-slate-900 font-bold text-xs px-4 py-2 rounded-full shadow w-max">
                                    Lihat Detail
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- Skrip JavaScript untuk Tombol Navigasi & Auto-Slide Pelatihan -->
                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        const slider = document.getElementById("pelatihan-slider");
                        const btnLeft = document.getElementById("slide-left-btn");
                        const btnRight = document.getElementById("slide-right-btn");

                        if (!slider) return;

                        const scrollAmount = 340; // Lebar card + gap (kira-kira 320px + 16px)

                        // Tombol Navigasi Manual
                        if (btnLeft) {
                            btnLeft.addEventListener("click", function() {
                                slider.scrollBy({
                                    left: -scrollAmount,
                                    behavior: 'smooth'
                                });
                            });
                        }

                        if (btnRight) {
                            btnRight.addEventListener("click", function() {
                                slider.scrollBy({
                                    left: scrollAmount,
                                    behavior: 'smooth'
                                });
                            });
                        }

                        // Fitur Auto-Slide
                        let autoSlideInterval = setInterval(function() {
                            if (slider.scrollLeft + slider.clientWidth >= slider.scrollWidth - 10) {
                                slider.scrollTo({
                                    left: 0,
                                    behavior: 'smooth'
                                });
                            } else {
                                slider.scrollBy({
                                    left: scrollAmount,
                                    behavior: 'smooth'
                                });
                            }
                        }, 4000); // Bergeser setiap 4 detik

                        // Hentikan auto-slide saat kursor berada di atas slider
                        slider.addEventListener("mouseenter", function() {
                            clearInterval(autoSlideInterval);
                        });

                        // Lanjutkan kembali auto-slide saat kursor keluar dari area slider
                        slider.addEventListener("mouseleave", function() {
                            autoSlideInterval = setInterval(function() {
                                if (slider.scrollLeft + slider.clientWidth >= slider.scrollWidth - 10) {
                                    slider.scrollTo({
                                        left: 0,
                                        behavior: 'smooth'
                                    });
                                } else {
                                    slider.scrollBy({
                                        left: scrollAmount,
                                        behavior: 'smooth'
                                    });
                                }
                            }, 4000);
                        });
                    });
                </script>

                <!-- Berita & Artikel Hukum -->
                <div class="space-y-4 pb-6">
                    <h3 class="text-lg font-extrabold text-slate-900">Artikel & Informasi Terbaru</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        @forelse ($artikels as $artikel)
                            <!-- Menghapus class 'menu-item-auth' pada card artikel -->
                            <a href="{{ route('artikel.show.public', $artikel) }}"
                                class="bg-slate-50 border border-slate-100 rounded-2xl p-4 flex items-center space-x-4 cursor-pointer hover:border-blue-200 hover:shadow-md transition-all duration-200 group">
                                <img src="{{ $artikel->gambar ? asset('storage/' . $artikel->gambar) : 'https://images.unsplash.com/photo-1589829545856-d10d557cf95f?w=200&auto=format&fit=crop&q=60' }}"
                                    alt="{{ $artikel->judul }}" class="w-20 h-20 rounded-xl object-cover shrink-0">
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs text-slate-400 font-medium">
                                        {{ \Carbon\Carbon::parse($artikel->tanggal)->diffForHumans() }} •
                                        {{ $artikel->kategori->nama ?? 'Umum' }}</p>
                                    <h4
                                        class="text-sm font-bold text-slate-900 truncate mt-1 group-hover:text-blue-600 transition-colors">
                                        {{ $artikel->judul }}</h4>
                                    <p class="text-xs text-slate-500 mt-1 line-clamp-2">
                                        {{ Str::limit(strip_tags($artikel->isi), 100) }}</p>
                                </div>
                            </a>
                        @empty
                            <div
                                class="md:col-span-2 text-center py-12 bg-slate-50 rounded-2xl border border-dashed border-slate-200">
                                <p class="text-sm text-slate-500 font-medium">Belum ada artikel yang dipublikasikan.
                                </p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- ========================================== -->
            <!-- MODAL LOGIN / AUTH POPUP                   -->
            <!-- ========================================== -->
            <div id="loginModal"
                class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/70 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-300">
                <div id="modalContent"
                    class="bg-white w-full max-w-md mx-4 rounded-3xl p-6 md:p-8 shadow-2xl transform scale-95 transition-transform duration-300 relative border border-slate-100">

                    <!-- Tombol Close (X) -->
                    <button id="closeModalBtn"
                        class="absolute top-5 right-5 w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 flex items-center justify-center transition">
                        <i class="fa-solid fa-xmark text-sm"></i>
                    </button>

                    <!-- Header Modal -->
                    <div class="text-center mb-6">
                        <div
                            class="w-14 h-14 bg-blue-50 text-blue-600 rounded-2xl mx-auto flex items-center justify-center text-2xl mb-3 shadow-inner">
                            <i class="fa-solid fa-lock"></i>
                        </div>
                        <h3 class="text-xl font-black text-slate-900">Login atau Daftar Sekarang</h3>
                        <p class="text-xs text-slate-500 mt-1">Silakan pilih opsi di bawah ini untuk mengakses menu
                            eksklusif
                            BAKUMDA.</p>
                    </div>

                    <!-- Tombol Navigasi ke Halaman Login & Register -->
                    <div class="space-y-3 pt-2">
                        <!-- Tombol ke Halaman Login -->
                        <a href="{{ route('login') }}"
                            class="w-full py-3.5 bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm rounded-xl shadow-lg shadow-blue-500/25 transition flex items-center justify-center space-x-2">
                            <i class="fa-solid fa-right-to-bracket"></i>
                            <span>Masuk / Login</span>
                        </a>

                        <!-- Tombol ke Halaman Register / Daftar -->
                        <a href="{{ route('register') }}"
                            class="w-full py-3.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-sm rounded-xl transition flex items-center justify-center space-x-2">
                            <i class="fa-solid fa-user-plus"></i>
                            <span>Daftar Akun Baru</span>
                        </a>
                    </div>

                    <!-- Footer Modal -->
                    <div class="mt-6 pt-5 border-t border-slate-100 text-center">
                        <p class="text-xs text-slate-500">Butuh bantuan akses?
                            <a href="#" class="text-blue-600 font-bold hover:underline">Hubungi Admin</a>
                        </p>
                    </div>
                </div>
            </div>


            <!-- ========================================== -->
            <!-- SCRIPT KONTROL MODAL                       -->
            <!-- ========================================== -->
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    const isUserLoggedIn = @json(auth()->check());

                    const modal = document.getElementById('loginModal');
                    const modalContent = document.getElementById('modalContent');
                    const closeModalBtn = document.getElementById('closeModalBtn');
                    const menuItems = document.querySelectorAll('.menu-item-auth');

                    function openModal() {
                        modal.classList.remove('opacity-0', 'pointer-events-none');
                        modalContent.classList.remove('scale-95');
                        modalContent.classList.add('scale-100');
                    }

                    function closeModal() {
                        modal.classList.add('opacity-0', 'pointer-events-none');
                        modalContent.classList.remove('scale-100');
                        modalContent.classList.add('scale-95');
                    }

                    menuItems.forEach(item => {
                        item.addEventListener('click', function(e) {
                            if (!isUserLoggedIn) {
                                e.preventDefault();
                                openModal();
                            }
                        });
                    });

                    closeModalBtn.addEventListener('click', closeModal);

                    modal.addEventListener('click', function(e) {
                        if (e.target === modal) {
                            closeModal();
                        }
                    });
                });
            </script>



        </main>

        <!-- Mobile Bottom Navigation Bar -->
        <div
            class="fixed bottom-0 left-0 right-0 bg-white border-t border-slate-100 px-6 py-2.5 flex items-center justify-around z-50 shadow-[0_-4px_20px_rgba(0,0,0,0.06)]">
            <!-- 1. Beranda -->
            <a href="{{ url('/') }}" class="flex flex-col items-center text-blue-700 py-1">
                <div class="w-9 h-9 rounded-full bg-blue-50 flex items-center justify-center"> {{-- @TODO: Ganti dengan route('dashboard') --}}
                    <i class="fa-solid fa-house text-base"></i>
                </div>
                <span class="text-[10px] font-bold mt-0.5">Beranda</span>
            </a>

            <!-- 2. Artikel -->
            <a href="" class="flex flex-col items-center text-slate-400 hover:text-blue-700 py-1 transition">
                <div class="w-9 h-9 rounded-full flex items-center justify-center">
                    <i class="fa-solid fa-newspaper text-base"></i>
                </div>
                <span class="text-[10px] font-medium mt-0.5">Artikel</span>
            </a>

            <!-- 3. QR (Scan) -->
            <div class="relative -top-5">
                <a href="{{ route('kartu-anggota.cek.form') }}"
                    class="w-14 h-14 rounded-full bg-gradient-to-tr from-red-700 to-rose-900 text-white flex items-center justify-center shadow-lg border-4 border-white transition-transform hover:scale-105">
                    <i class="fa-solid fa-qrcode text-xl"></i>
                </a>
            </div>

            <!-- 4. Kartu -->
            <a href="{{ route('user-anggota.index') }}"
                class="flex flex-col items-center text-slate-400 hover:text-blue-700 py-1 transition">
                <div class="w-9 h-9 rounded-full flex items-center justify-center">
                    <i class="fa-solid fa-id-card text-base"></i>
                </div>
                <span class="text-[10px] font-medium mt-0.5">Kartu</span>
            </a>

            <!-- 5. Profil --> {{-- @TODO: Ganti dengan route('profile.edit') --}}
            <a href="{{ route('profile.show') }}"
                class="flex flex-col items-center text-slate-400 hover:text-blue-700 py-1 transition">
                <div class="w-9 h-9 rounded-full flex items-center justify-center">
                    <i class="fa-solid fa-user text-base"></i>
                </div>
                <span class="text-[10px] font-medium mt-0.5">Profil</span>
            </a>
        </div>
    </div>

    <!-- ================================================= -->
    <!-- VIEW 2: DESKTOP MODE                              -->
    <!-- ================================================= -->
    <div id="view-desktop-container" x-data="{ sidebarOpen: false }"
        class="hidden 2xl:flex flex-1 flex-row h-screen overflow-hidden">

        <!-- Sidebar Navigation (Kiri) - Tetap diam / sticky -->
        <aside :class="sidebarOpen ? 'w-64' : 'w-20'"
            class="bg-slate-900 border-r border-slate-800 flex flex-col justify-between h-screen z-30 shadow-2xl shrink-0 transition-all duration-300">
            <div>
                <!-- Brand Header -->
                <div class="p-6 border-b border-slate-800 flex items-center space-x-3 overflow-hidden">
                    <div
                        class="w-10 h-10 rounded-xl bg-gradient-to-tr from-blue-700 to-amber-500 flex items-center justify-center text-white font-black text-lg shadow-lg shrink-0 overflow-hidden">
                        <img src="{{ asset('bakumda.png') }}" alt="Avatar" class="w-full h-full object-cover">
                    </div>
                    <div x-show="sidebarOpen" x-transition.opacity class="truncate">
                        <h1 class="font-extrabold text-white text-base tracking-wider">BAKUMDA</h1>
                        <p class="text-[10px] text-slate-400 font-medium">Bantuan Hukum Daerah</p>
                    </div>
                </div>

                <!-- Navigation Links -->
                <nav class="p-3 space-y-1.5 overflow-y-auto max-h-[calc(100vh-280px)]">
                    <a href="{{ url('/') }}"
                        class="flex items-center space-x-3 px-3.5 py-2.5 rounded-xl bg-blue-600 text-white font-bold text-sm shadow-md shadow-blue-600/20">
                        <i class="fa-solid fa-house w-5 text-center shrink-0 text-base"></i>
                        <span x-show="sidebarOpen" x-transition.opacity class="truncate">Beranda</span>
                    </a>
                    <a href=""
                        class="flex items-center space-x-3 px-3.5 py-2.5 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800/60 font-medium text-sm transition">
                        <i class="fa-solid fa-newspaper  w-5 text-center shrink-0 text-base"></i>
                        <span x-show="sidebarOpen" x-transition.opacity class="truncate">Artikel</span>
                    </a>
                    <a href="{{ route('kartu-anggota.cek.form') }}"
                        class="flex items-center space-x-3 px-3.5 py-2.5 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800/60 font-medium text-sm transition">
                        <i class="fa-solid fa-qrcode w-5 text-center shrink-0 text-base"></i>
                        <span x-show="sidebarOpen" x-transition.opacity class="truncate">Scan</span>
                    </a>
                    <a href="{{ route('user-anggota.index') }}"
                        class="flex items-center space-x-3 px-3.5 py-2.5 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800/60 font-medium text-sm transition">
                        <i class="fa-solid fa-id-card  w-5 text-center shrink-0 text-base"></i>
                        <span x-show="sidebarOpen" x-transition.opacity class="truncate">Kartu</span>
                    </a>
                    <a href="{{ route('profile.show') }}"
                        class="flex items-center space-x-3 px-3.5 py-2.5 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800/60 font-medium text-sm transition">
                        <i class="fa-solid fa-user-shield w-5 text-center shrink-0 text-base"></i>
                        <span x-show="sidebarOpen" x-transition.opacity class="truncate">Profile</span>
                    </a>
                </nav>
            </div>

            <!-- User Info & Logout Footer -->
            <div class="border-t border-slate-800 bg-slate-900/50 flex flex-col">

                <!-- Hidden Logout Form -->
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
                <!-- Tombol Logout -->
                <div class="px-3 pb-3">
                    <a href="#"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                        class="flex items-center space-x-3 px-3.5 py-2 rounded-xl text-red-400 hover:bg-red-500/10 font-medium text-sm transition">
                        <i class="fa-solid fa-right-from-bracket w-5 text-center shrink-0 text-base"></i>
                        <span x-show="sidebarOpen" x-transition.opacity class="truncate">Logout</span>
                    </a>
                </div>
                <!-- User Profile Info -->
                <div class="p-4 flex items-center space-x-3 overflow-hidden">
                    <div
                        class="w-9 h-9 rounded-full bg-slate-800 border border-slate-700 flex items-center justify-center text-amber-400 font-bold text-xs shrink-0">
                        AM</div>
                    <div x-show="sidebarOpen" x-transition.opacity class="overflow-hidden truncate">
                        <h4 class="text-xs font-bold text-white truncate">DR. H. ARIS M.</h4>
                        <p class="text-[10px] text-slate-400 truncate">Advokat / Konsultan</p>
                    </div>
                </div>

            </div>
        </aside>

        <!-- Main Desktop Content Area yang bisa discroll secara mandiri -->
        <div class="flex-1 flex flex-col min-w-0 h-screen overflow-y-auto">
            <!-- Top Bar - Sticky di bagian atas area konten -->
            <header
                class="bg-slate-900/80 backdrop-blur-md border-b border-slate-800 px-6 py-4 flex items-center justify-between sticky top-0 z-20">
                <div class="flex items-center space-x-4">
                    <!-- Tombol Burger Menu untuk Membuka/Menutup Sidebar -->
                    <button @click="sidebarOpen = !sidebarOpen"
                        class="w-10 h-10 rounded-full bg-slate-800 border border-slate-700 flex items-center justify-center text-slate-300 hover:text-white transition shadow-sm focus:outline-none">
                        <i class="fa-solid fa-bars text-sm"></i>
                    </button>

                </div>
                <div class="items-center space-x-4 hidden sm:flex">
                    <div class="relative w-72">
                        <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-3 text-xs text-slate-400"></i>
                        <input type="text" placeholder="Cari pasal, layanan, atau konsultasi..."
                            class="w-full bg-slate-800 border border-slate-700 text-xs text-white rounded-full pl-10 pr-4 py-2.5 focus:outline-none focus:border-blue-500 transition">
                    </div>
                    <div class="relative">
                        <button
                            class="w-10 h-10 rounded-full bg-slate-800 border border-slate-700 flex items-center justify-center text-slate-300 hover:text-white transition">
                            <i class="fa-regular fa-bell text-sm"></i>
                        </button>
                        <span
                            class="absolute top-1 right-1 w-4 h-4 bg-amber-500 text-slate-950 font-extrabold text-[9px] flex items-center justify-center rounded-full shadow">8</span>
                    </div>
                </div>
            </header>

            <!-- Desktop Content Slot -->
            <div class="flex-1">


                <!-- Hero Banner & Membership Card Grid (Mobile) -->
                <div class="grid grid-cols-1 gap-3 md:gap-6 mb-4 md:mb-8 relative z-7">

                    <!-- Hero Banner Slider -->
                    <div id="banner-slider-container"
                        class="relative w-full overflow-hidden rounded-3xl shadow-xl border border-slate-800 mb-1 md:mb-4 z-10">
                        <!-- Slider Track -->
                        <div class="heroSlider flex transition-transform duration-700 ease-out w-full">
                            <!-- Slide 1 -->
                            <div class="slide-item min-w-full w-full relative overflow-hidden">
                                <img src="{{ asset('b1.jpeg') }}" alt="Banner 1"
                                    class="w-full h-auto object-contain">
                            </div>
                            <!-- Slide 2 -->
                            <div class="slide-item min-w-full w-full relative overflow-hidden">
                                <img src="{{ asset('b2.jpeg') }}" alt="Banner 2"
                                    class="w-full h-auto object-contain">
                            </div>
                            <div class="slide-item min-w-full w-full relative overflow-hidden">
                                <img src="{{ asset('b3.jpeg') }}" alt="Banner 3"
                                    class="w-full h-auto object-contain">
                            </div>
                            <div class="slide-item min-w-full w-full relative overflow-hidden">
                                <img src="{{ asset('b4.jpeg') }}" alt="Banner 4"
                                    class="w-full h-auto object-contain">
                            </div>
                        </div>

                        <!-- Indikator Dots -->
                        <div class="absolute bottom-3 right-4 z-30 flex space-x-1.5" id="slider-dots">
                            <button class="dot h-2 w-5 bg-white rounded-full transition-all duration-300"
                                data-index="0"></button>
                            <button class="dot h-2 w-2 bg-white/50 rounded-full transition-all duration-300"
                                data-index="1"></button>
                            <button class="dot h-2 w-2 bg-white/50 rounded-full transition-all duration-300"
                                data-index="2"></button>
                            <button class="dot h-2 w-2 bg-white/50 rounded-full transition-all duration-300"
                                data-index="3"></button>
                        </div>
                    </div>

                    <!-- Skrip JavaScript Slider Banner -->
                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            const container = document.getElementById("banner-slider-container");
                            if (!container) return;

                            const slider = container.querySelector(".heroSlider");
                            const slides = container.querySelectorAll(".slide-item");
                            const dots = container.querySelectorAll("#slider-dots .dot");
                            let currentIndex = 0;
                            const totalSlides = slides.length;
                            const intervalTime = 5000;

                            function updateSlider() {
                                slider.style.transform = `translateX(-${currentIndex * 100}%)`;
                                dots.forEach((dot, index) => {
                                    if (index === currentIndex) {
                                        dot.classList.remove("w-2", "bg-white/50");
                                        dot.classList.add("w-5", "bg-white");
                                    } else {
                                        dot.classList.remove("w-5", "bg-white");
                                        dot.classList.add("w-2", "bg-white/50");
                                    }
                                });
                            }

                            function nextSlide() {
                                currentIndex = (currentIndex + 1) % totalSlides;
                                updateSlider();
                            }

                            let slideInterval = setInterval(nextSlide, intervalTime);

                            dots.forEach((dot, index) => {
                                dot.addEventListener("click", function() {
                                    currentIndex = index;
                                    updateSlider();
                                    clearInterval(slideInterval);
                                    slideInterval = setInterval(nextSlide, intervalTime);
                                });
                            });
                        });
                    </script>

                    <!-- KTA / Pendaftaran Anggota (Modern & Responsif) -->
                    @if (isset($isRegistered) && $isRegistered)
                        <div class="relative group mt-1 md:mt-0">
                            <div
                                class="absolute -inset-1 bg-gradient-to-r from-blue-600 to-amber-500 rounded-2xl md:rounded-3xl blur opacity-25 group-hover:opacity-40 transition duration-500">
                            </div>

                            <div
                                class="relative bg-gradient-to-br from-slate-900 via-slate-900 to-slate-950 border border-slate-700/60 rounded-2xl md:rounded-3xl p-4 md:p-6 shadow-2xl flex items-center justify-between overflow-hidden">
                                <div
                                    class="absolute top-0 right-0 -mt-4 -mr-4 w-32 h-32 bg-blue-500/10 rounded-full blur-2xl pointer-events-none">
                                </div>

                                <!-- Informasi Anggota -->
                                <div class="space-y-1.5 md:space-y-2 z-10">
                                    <div class="flex items-center space-x-2 mb-1">
                                        <span
                                            class="text-[10px] md:text-xs font-bold text-slate-400 uppercase tracking-wider">
                                            KTA {{ $anggota->card->latestBerlaku->jabatan ?? 'Anggota' }}
                                        </span>
                                        <span
                                            class="px-2.5 py-0.5 bg-blue-500/15 border border-blue-500/30 text-blue-400 font-bold text-[9px] md:text-[10px] uppercase rounded-full shadow-sm">
                                            {{ $status_anggota ?? 'Aktif' }}
                                        </span>
                                    </div>
                                    <div
                                        class="font-mono font-black text-amber-400 text-sm md:text-xl tracking-widest drop-shadow">
                                        {{ $no_ktpa ?? '7371 2094 0000 3127' }}
                                    </div>
                                    <p
                                        class="text-xs md:text-sm text-slate-200 font-extrabold uppercase tracking-wide mt-1">
                                        {{ $nama_anggota ?? 'DR. H. ARIS M.' }}
                                    </p>
                                </div>

                                <!-- Chip Kartu Digital -->
                                <div
                                    class="w-16 h-12 md:w-20 md:h-14 rounded-xl bg-gradient-to-br from-slate-800 via-slate-900 to-slate-950 border border-slate-700/80 p-2 flex flex-col justify-between shrink-0 shadow-lg z-10">
                                    <div class="flex justify-between items-start">
                                        <span
                                            class="text-[7px] md:text-[8px] text-slate-400 font-black tracking-wider">BAKUMDA</span>
                                        <div
                                            class="w-2 h-2 rounded-full bg-amber-400 shadow-[0_0_8px_rgba(251,191,36,0.8)]">
                                        </div>
                                    </div>
                                    <div
                                        class="w-6 md:w-7 h-3 md:h-3.5 bg-gradient-to-r from-amber-400/30 to-amber-200/40 border border-amber-400/40 rounded-[3px] ml-auto flex items-center justify-center">
                                        <div class="w-full h-[1px] bg-amber-400/50"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- Tampilan Pendaftaran Anggota Baru -->
                        <a href="#"
                            class="mt-1 md:mt-0 bg-gradient-to-br from-blue-900 to-indigo-950 border border-blue-800/60 rounded-3xl p-5 md:p-6 shadow-xl flex flex-col justify-between transition-transform duration-300 hover:scale-[1.02] group">
                            <div class="flex items-center justify-between gap-4">
                                <div>
                                    <div class="mb-2">
                                        <span class="text-xs font-bold text-yellow-300 uppercase tracking-wider">Anda
                                            Belum
                                            Terdaftar</span>
                                    </div>
                                    <h4
                                        class="font-black text-white text-base md:text-lg tracking-wide group-hover:text-blue-200 transition">
                                        Ajukan Diri Menjadi Anggota BAKUMDA
                                    </h4>
                                    <p class="text-xs sm:text-sm text-blue-200/80 font-medium mt-1">
                                        Proses Cepat & Mudah.
                                    </p>
                                </div>
                                <!-- Kartu mini/chip di sebelah kanan, sejajar secara vertikal dengan teks/tombol -->
                                <div
                                    class="w-24 h-16 md:w-28 md:h-20 rounded-2xl bg-gradient-to-br from-slate-800 via-slate-900 to-slate-950 border border-slate-700/80 p-3 flex flex-col justify-between shrink-0 shadow-lg z-10 my-auto">
                                    <div class="flex justify-between items-start">
                                        <span
                                            class="text-[9px] md:text-[10px] text-slate-400 font-black tracking-wider">BAKUMDA</span>
                                        <div
                                            class="w-2.5 h-2.5 rounded-full bg-amber-400 shadow-[0_0_10px_rgba(251,191,36,0.9)]">
                                        </div>
                                    </div>
                                    <div
                                        class="w-8 md:w-10 h-4 md:h-5 bg-gradient-to-r from-amber-400/30 to-amber-200/40 border border-amber-400/40 rounded-[4px] ml-auto flex items-center justify-center">
                                        <div class="w-full h-[1.5px] bg-amber-400/50"></div>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="pt-4 mt-3 border-t border-blue-800/60 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
                                <span class="text-[11px] text-blue-300 font-medium">Pastikan Anda Telah Memiliki
                                    Sertifikat DIKLATKUM
                                    Sebagai Syarat Utama Untuk Bergabung</span>

                                <!-- Bungkus tombol berdampingan dengan style/warna berbeda -->
                                <div class="flex items-center gap-2 shrink-0">
                                    <!-- Tombol Ikuti DIKLATKUM (Warna Biru/Indigo) + class menu-item-auth -->
                                    <div
                                        class="menu-item-auth bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white font-bold text-xs px-4 py-2 rounded-full shadow transition cursor-pointer">
                                        IKUTI DIKLATKUM
                                    </div>

                                    <!-- Tombol Daftar Keanggotaan (Warna Kuning/Oranye, Teks Putih dengan garis pinggir hitam) + class menu-item-auth -->
                                    <div
                                        class="menu-item-auth bg-gradient-to-r from-yellow-400 to-orange-500 hover:from-yellow-300 hover:to-orange-400 text-white font-bold text-xs px-4 py-2 rounded-full shadow transition cursor-pointer">
                                        DAFTAR KEANGGOTAAN
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endif
                </div>
                <br>
                <!-- Container Putih Full ke Bawah (Menghilangkan flex-1 dan menambahkan min-h-screen/margin negatif bawah agar menyatu sampai bawah layar) -->
                <div
                    class="bg-white text-slate-900 rounded-t-[2.5rem] -mt-4 pt-10 px-6 sm:px-12 shadow-2xl relative z-20 space-y-8 pb-16 min-h-screen">

                    <!-- ========================================== -->
                    <!-- MENU UTAMA (KONDISI MOBILE vs DESKTOP)     -->
                    <!-- ========================================== -->
                    <div>

                        <!-- Grid Menu: Tambahkan class 'menu-item-auth' ke setiap tag <a> menu -->
                        <h3 class="text-lg font-extrabold text-slate-900 leading-tight">Fitur Eksklusif</h3><br>
                        <div class="grid grid-cols-4 min-[1281px]:grid-cols-8 gap-y-6 gap-x-4">

                            <!-- Menu 1 -->
                            <a href="{{ route('user-pelatihan.index') }}"
                                class="menu-item-auth flex flex-col items-center cursor-pointer group">
                                <div
                                    class="w-16 h-16 md:w-18 md:h-18 rounded-2xl bg-gradient-to-tr from-blue-700 to-indigo-600 flex items-center justify-center text-white shadow-md shadow-blue-500/20 group-hover:scale-105 transition">
                                    <i
                                        class="fa-solid fa-graduation-cap max-[1280px]:block min-[1281px]:hidden text-2xl"></i>
                                    <i
                                        class="fa-solid fa-graduation-cap hidden max-[1280px]:hidden min-[1281px]:block text-xl"></i>
                                </div>
                                <span
                                    class="text-xs font-semibold text-slate-700 mt-2 text-center leading-tight">E-Pelatihan</span>
                            </a>

                            <!-- Menu 2 -->
                            <a href="{{ route('sertifikat.index') }}"
                                class="menu-item-auth flex flex-col items-center cursor-pointer group">
                                <div
                                    class="w-16 h-16 md:w-18 md:h-18 rounded-2xl bg-gradient-to-tr from-blue-800 to-blue-600 flex items-center justify-center text-white shadow-md shadow-blue-500/20 group-hover:scale-105 transition">
                                    <i
                                        class="fa-solid fa-certificate max-[1280px]:block min-[1281px]:hidden text-2xl"></i>
                                    <i
                                        class="fa-solid fa-certificate hidden max-[1280px]:hidden min-[1281px]:block text-xl"></i>
                                </div>
                                <span
                                    class="text-xs font-semibold text-slate-700 mt-2 text-center leading-tight">Sertifikat</span>
                            </a>

                            <!-- Menu 3 -->
                            <a href="{{ url('/surat') }}"
                                class="menu-item-auth flex flex-col items-center cursor-pointer group">
                                <div
                                    class="w-16 h-16 md:w-18 md:h-18 rounded-2xl bg-gradient-to-tr from-slate-800 to-blue-900 flex items-center justify-center text-white shadow-md shadow-blue-500/20 group-hover:scale-105 transition">
                                    <i
                                        class="fa-solid fa-scale-balanced max-[1280px]:block min-[1281px]:hidden text-2xl"></i>
                                    <i
                                        class="fa-solid fa-scale-balanced hidden max-[1280px]:hidden min-[1281px]:block text-xl"></i>
                                </div>
                                <span
                                    class="text-xs font-semibold text-slate-700 mt-2 text-center leading-tight">Legalku</span>
                            </a>

                            <!-- Menu 4 -->
                            <a href="#" class="menu-item-auth flex flex-col items-center cursor-pointer group">
                                <div
                                    class="w-16 h-16 md:w-18 md:h-18 rounded-2xl bg-gradient-to-tr from-blue-600 to-cyan-700 flex items-center justify-center text-white shadow-md shadow-blue-500/20 group-hover:scale-105 transition">
                                    <i
                                        class="fa-solid fa-lightbulb max-[1280px]:block min-[1281px]:hidden text-2xl"></i>
                                    <i
                                        class="fa-solid fa-lightbulb hidden max-[1280px]:hidden min-[1281px]:block text-xl"></i>
                                </div>
                                <span
                                    class="text-xs font-semibold text-slate-700 mt-2 text-center leading-tight">Inspirator</span>
                            </a>

                            <!-- Menu Artikel (Tanpa class menu-item-auth agar bisa diakses publik) -->
                            <a href="{{ route('user.artikel.index') ?? '#' }}"
                                class="flex flex-col items-center cursor-pointer group">
                                <div
                                    class="w-16 h-16 md:w-18 md:h-18 rounded-2xl bg-gradient-to-tr from-blue-600 to-cyan-700 flex items-center justify-center text-white shadow-md shadow-blue-500/20 group-hover:scale-105 transition">
                                    <i
                                        class="fa-solid fa-newspaper max-[1280px]:block min-[1281px]:hidden text-2xl"></i>
                                    <i
                                        class="fa-solid fa-newspaper hidden max-[1280px]:hidden min-[1281px]:block text-xl"></i>
                                </div>
                                <span
                                    class="text-xs font-semibold text-slate-700 mt-2 text-center leading-tight">Artikel</span>
                            </a>

                            <!-- Menu 5 -->
                            <a href="#" class="menu-item-auth flex flex-col items-center cursor-pointer group">
                                <div
                                    class="w-16 h-16 md:w-18 md:h-18 rounded-2xl bg-gradient-to-tr from-amber-600 to-yellow-600 flex items-center justify-center text-white shadow-md shadow-amber-500/20 group-hover:scale-105 transition">
                                    <i class="fa-solid fa-sitemap max-[1280px]:block min-[1281px]:hidden text-2xl"></i>
                                    <i
                                        class="fa-solid fa-sitemap hidden max-[1280px]:hidden min-[1281px]:block text-xl"></i>
                                </div>
                                <span
                                    class="text-xs font-semibold text-slate-700 mt-2 text-center leading-tight">Korwil</span>
                            </a>

                            <!-- Menu 6 -->
                            <a href="{{ url('/about') }}"
                                class="menu-item-auth flex flex-col items-center cursor-pointer group">
                                <div
                                    class="w-16 h-16 md:w-18 md:h-18 rounded-2xl bg-gradient-to-tr from-blue-900 to-slate-900 flex items-center justify-center text-white shadow-md shadow-blue-500/20 group-hover:scale-105 transition">
                                    <i
                                        class="fa-solid fa-network-wired max-[1280px]:block min-[1281px]:hidden text-2xl"></i>
                                    <i
                                        class="fa-solid fa-network-wired hidden max-[1280px]:hidden min-[1281px]:block text-xl"></i>
                                </div>
                                <span
                                    class="text-xs font-semibold text-slate-700 mt-2 text-center leading-tight">E-Organisasi</span>
                            </a>

                            <!-- Menu 7 -->
                            <a href="{{ route('merchandise.index') }}"
                                class="menu-item-auth flex flex-col items-center cursor-pointer group">
                                <div
                                    class="w-16 h-16 md:w-18 md:h-18 rounded-2xl bg-gradient-to-tr from-red-600 to-rose-800 flex items-center justify-center text-white shadow-md shadow-red-500/20 group-hover:scale-105 transition">
                                    <i
                                        class="fa-solid fa-handshake max-[1280px]:block min-[1281px]:hidden text-2xl"></i>
                                    <i
                                        class="fa-solid fa-handshake hidden max-[1280px]:hidden min-[1281px]:block text-xl"></i>
                                </div>
                                <span class="text-xs font-semibold text-slate-700 mt-2 text-center leading-tight">Kerja
                                    Sama</span>
                            </a>

                        </div>
                    </div>

                    <!-- Program Bantuan Hukum (Slider) -->
                    <div id="slider-container-pelatihan" class="relative">
                        <br>
                        <br>
                        <div class="flex justify-between items-center mb-4">
                            <div>
                                <h3 class="text-lg font-extrabold text-slate-900 leading-tight">Program Pelatihan</h3>
                                <span class="text-xs text-slate-400 font-medium">Geser otomatis atau gunakan
                                    tombol</span>
                            </div>

                            <!-- Tombol Navigasi Manual -->
                            <div class="flex items-center space-x-2">
                                <button id="slide-left-btn"
                                    class="w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-700 flex items-center justify-center transition shadow-sm">
                                    <i class="fa-solid fa-chevron-left text-xs"></i>
                                </button>
                                <button id="slide-right-btn"
                                    class="w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-700 flex items-center justify-center transition shadow-sm">
                                    <i class="fa-solid fa-chevron-right text-xs"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Slider Container dengan Tambahan CSS Inline untuk Menyembunyikan Scrollbar secara Total -->
                        <div id="pelatihan-slider"
                            class="flex overflow-x-auto space-x-4 pb-4 -mx-4 sm:-mx-6 px-4 sm:px-6 snap-x snap-mandatory scroll-smooth"
                            style="scrollbar-width: none; -ms-overflow-style: none;">

                            <!-- CSS tambahan khusus untuk webkit (Chrome, Safari, Edge) agar scrollbar benar-benar hilang -->
                            <style>
                                #pelatihan-slider::-webkit-scrollbar {
                                    display: none;
                                }
                            </style>

                            @foreach ($pelatihans as $index => $pelatihan)
                                @php
                                    $bgGradient = match ($index % 3) {
                                        0 => 'from-blue-800 to-indigo-900',
                                        1 => 'from-slate-800 to-blue-900',
                                        default => 'from-slate-900 to-slate-800',
                                    };
                                @endphp

                                <a href="{{ route('user-pelatihan.show', $pelatihan) }}"
                                    class="menu-item-auth snap-start shrink-0 w-[280px] sm:w-[320px] bg-gradient-to-br {{ $bgGradient }} rounded-2xl p-6 text-white shadow-md flex flex-col justify-between h-[180px] transition-transform duration-300 hover:scale-105">
                                    <div>
                                        <h4 class="font-black text-base tracking-wide">{{ $pelatihan->judul }}</h4>
                                        <div class="mt-2 text-xs opacity-90 space-y-1 font-medium">
                                            <p>• Mulai:
                                                {{ \Carbon\Carbon::parse($pelatihan->tanggal_mulai)->translatedFormat('d F Y') }}
                                            </p>
                                            <p class="text-sm font-extrabold text-amber-400 mt-1">
                                                Rp {{ number_format($pelatihan->harga, 0, ',', '.') }}
                                            </p>
                                        </div>
                                    </div>
                                    <div
                                        class="bg-white text-slate-900 font-bold text-xs px-4 py-2 rounded-full shadow w-max">
                                        Lihat Detail
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- Skrip JavaScript untuk Tombol Navigasi & Auto-Slide Pelatihan -->
                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            const slider = document.getElementById("pelatihan-slider");
                            const btnLeft = document.getElementById("slide-left-btn");
                            const btnRight = document.getElementById("slide-right-btn");

                            if (!slider) return;

                            const scrollAmount = 340; // Lebar card + gap (kira-kira 320px + 16px)

                            // Tombol Navigasi Manual
                            if (btnLeft) {
                                btnLeft.addEventListener("click", function() {
                                    slider.scrollBy({
                                        left: -scrollAmount,
                                        behavior: 'smooth'
                                    });
                                });
                            }

                            if (btnRight) {
                                btnRight.addEventListener("click", function() {
                                    slider.scrollBy({
                                        left: scrollAmount,
                                        behavior: 'smooth'
                                    });
                                });
                            }

                            // Fitur Auto-Slide
                            let autoSlideInterval = setInterval(function() {
                                if (slider.scrollLeft + slider.clientWidth >= slider.scrollWidth - 10) {
                                    slider.scrollTo({
                                        left: 0,
                                        behavior: 'smooth'
                                    });
                                } else {
                                    slider.scrollBy({
                                        left: scrollAmount,
                                        behavior: 'smooth'
                                    });
                                }
                            }, 4000); // Bergeser setiap 4 detik

                            // Hentikan auto-slide saat kursor berada di atas slider
                            slider.addEventListener("mouseenter", function() {
                                clearInterval(autoSlideInterval);
                            });

                            // Lanjutkan kembali auto-slide saat kursor keluar dari area slider
                            slider.addEventListener("mouseleave", function() {
                                autoSlideInterval = setInterval(function() {
                                    if (slider.scrollLeft + slider.clientWidth >= slider.scrollWidth - 10) {
                                        slider.scrollTo({
                                            left: 0,
                                            behavior: 'smooth'
                                        });
                                    } else {
                                        slider.scrollBy({
                                            left: scrollAmount,
                                            behavior: 'smooth'
                                        });
                                    }
                                }, 4000);
                            });
                        });
                    </script>

                    <!-- Berita & Artikel Hukum -->
                    <div class="space-y-4 pb-6">
                        <h3 class="text-lg font-extrabold text-slate-900">Artikel & Informasi Terbaru</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            @forelse ($artikels as $artikel)
                                <!-- Menghapus class 'menu-item-auth' pada card artikel -->
                                <a href="{{ route('artikel.show.public', $artikel) }}"
                                    class="bg-slate-50 border border-slate-100 rounded-2xl p-4 flex items-center space-x-4 cursor-pointer hover:border-blue-200 hover:shadow-md transition-all duration-200 group">
                                    <img src="{{ $artikel->gambar ? asset('storage/' . $artikel->gambar) : 'https://images.unsplash.com/photo-1589829545856-d10d557cf95f?w=200&auto=format&fit=crop&q=60' }}"
                                        alt="{{ $artikel->judul }}"
                                        class="w-20 h-20 rounded-xl object-cover shrink-0">
                                    <div class="flex-1 min-w-0">
                                        <p class="text-xs text-slate-400 font-medium">
                                            {{ \Carbon\Carbon::parse($artikel->tanggal)->diffForHumans() }} •
                                            {{ $artikel->kategori->nama ?? 'Umum' }}</p>
                                        <h4
                                            class="text-sm font-bold text-slate-900 truncate mt-1 group-hover:text-blue-600 transition-colors">
                                            {{ $artikel->judul }}</h4>
                                        <p class="text-xs text-slate-500 mt-1 line-clamp-2">
                                            {{ Str::limit(strip_tags($artikel->isi), 100) }}</p>
                                    </div>
                                </a>
                            @empty
                                <div
                                    class="md:col-span-2 text-center py-12 bg-slate-50 rounded-2xl border border-dashed border-slate-200">
                                    <p class="text-sm text-slate-500 font-medium">Belum ada artikel yang
                                        dipublikasikan.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- ========================================== -->
                <!-- MODAL LOGIN / AUTH POPUP                   -->
                <!-- ========================================== -->
                <div id="loginModal"
                    class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/70 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-300">
                    <div id="modalContent"
                        class="bg-white w-full max-w-md mx-4 rounded-3xl p-6 md:p-8 shadow-2xl transform scale-95 transition-transform duration-300 relative border border-slate-100">

                        <!-- Tombol Close (X) -->
                        <button id="closeModalBtn"
                            class="absolute top-5 right-5 w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 flex items-center justify-center transition">
                            <i class="fa-solid fa-xmark text-sm"></i>
                        </button>

                        <!-- Header Modal -->
                        <div class="text-center mb-6">
                            <div
                                class="w-14 h-14 bg-blue-50 text-blue-600 rounded-2xl mx-auto flex items-center justify-center text-2xl mb-3 shadow-inner">
                                <i class="fa-solid fa-lock"></i>
                            </div>
                            <h3 class="text-xl font-black text-slate-900">Login atau Daftar Sekarang</h3>
                            <p class="text-xs text-slate-500 mt-1">Silakan pilih opsi di bawah ini untuk mengakses menu
                                eksklusif
                                BAKUMDA.</p>
                        </div>

                        <!-- Tombol Navigasi ke Halaman Login & Register -->
                        <div class="space-y-3 pt-2">
                            <!-- Tombol ke Halaman Login -->
                            <a href="{{ route('login') }}"
                                class="w-full py-3.5 bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm rounded-xl shadow-lg shadow-blue-500/25 transition flex items-center justify-center space-x-2">
                                <i class="fa-solid fa-right-to-bracket"></i>
                                <span>Masuk / Login</span>
                            </a>

                            <!-- Tombol ke Halaman Register / Daftar -->
                            <a href="{{ route('register') }}"
                                class="w-full py-3.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-sm rounded-xl transition flex items-center justify-center space-x-2">
                                <i class="fa-solid fa-user-plus"></i>
                                <span>Daftar Akun Baru</span>
                            </a>
                        </div>

                        <!-- Footer Modal -->
                        <div class="mt-6 pt-5 border-t border-slate-100 text-center">
                            <p class="text-xs text-slate-500">Butuh bantuan akses?
                                <a href="#" class="text-blue-600 font-bold hover:underline">Hubungi Admin</a>
                            </p>
                        </div>
                    </div>
                </div>


                <!-- ========================================== -->
                <!-- SCRIPT KONTROL MODAL                       -->
                <!-- ========================================== -->
                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        const isUserLoggedIn = @json(auth()->check());

                        const modal = document.getElementById('loginModal');
                        const modalContent = document.getElementById('modalContent');
                        const closeModalBtn = document.getElementById('closeModalBtn');
                        const menuItems = document.querySelectorAll('.menu-item-auth');

                        function openModal() {
                            modal.classList.remove('opacity-0', 'pointer-events-none');
                            modalContent.classList.remove('scale-95');
                            modalContent.classList.add('scale-100');
                        }

                        function closeModal() {
                            modal.classList.add('opacity-0', 'pointer-events-none');
                            modalContent.classList.remove('scale-100');
                            modalContent.classList.add('scale-95');
                        }

                        menuItems.forEach(item => {
                            item.addEventListener('click', function(e) {
                                if (!isUserLoggedIn) {
                                    e.preventDefault();
                                    openModal();
                                }
                            });
                        });

                        closeModalBtn.addEventListener('click', closeModal);

                        modal.addEventListener('click', function(e) {
                            if (e.target === modal) {
                                closeModal();
                            }
                        });
                    });
                </script>


            </div>
        </div>
    </div>

    <script>
        function showAlert(msg) {
            alert(msg);
        }
    </script>
    @stack('scripts')
</body>

</html>
