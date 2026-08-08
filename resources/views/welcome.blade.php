<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard IMI Mobilitas - Auto Responsive</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f1f5f9;
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>

<body class="min-h-screen text-gray-800 flex flex-col items-center justify-start p-0 md:p-6 transition-all duration-300">

    <div id="appContainer" class="w-full flex flex-col items-center justify-center">

        {{-- <div id="viewSwitcherBar" class="hidden md:flex w-full max-w-[1140px] justify-center gap-3 px-4 py-3 bg-white/95 border-b border-gray-200 shadow-sm sticky top-0 z-40">
            <button id="btnMobileView" onclick="setViewMode('mobile')"
                class="px-4 py-1.5 text-xs font-bold rounded-full transition text-gray-600 hover:text-gray-900">
                Mode Mobile
            </button>
            <button id="btnDesktopView" onclick="setViewMode('desktop')"
                class="px-4 py-1.5 text-xs font-bold rounded-full transition text-gray-600 hover:text-gray-900">
                Mode Desktop
            </button>
        </div> --}}

        <!-- ================= ANDROID MOBILE APP VIEW CONTAINER ================= -->
        <div id="androidView"
            class="w-full sm:max-w-[412px] bg-white min-h-screen sm:min-h-[860px] sm:rounded-[45px] sm:ring-[12px] sm:ring-slate-800 sm:shadow-2xl relative flex flex-col justify-between pb-32 overflow-hidden transition-all duration-300 hidden">

            <!-- Mobile Status Bar (Android Simulation) -->
            <div
                class="w-full bg-white pt-3 px-6 flex justify-between items-center text-xs font-semibold text-gray-800 sm:flex hidden">
                <span>13.26</span>
                <div class="flex items-center space-x-1.5 text-xs">
                    <i class="fa-solid fa-signal"></i>
                    <i class="fa-solid fa-wifi"></i>
                    <span class="font-bold text-[10px] px-1 bg-gray-200 rounded">4G</span>
                    <span class="bg-gray-800 text-white px-1 rounded text-[10px]">64</span>
                </div>
            </div>

            <!-- Header Profile Section -->
            <div class="fixed top-0 left-0 right-0 px-5 pt-4 pb-2 flex items-center justify-between bg-white shadow-sm z-30">
                <div class="flex items-center space-x-3">
                    <div
                        class="w-12 h-12 rounded-full border-2 border-orange-500 p-0.5 flex items-center justify-center bg-orange-100 text-gray-700 overflow-hidden shadow-sm">
                        <img src="{{ asset('bakumda.png') }}" alt="Profile"
                            class="w-full h-full rounded-full object-cover">
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 font-medium">Halo</p>
                        <h1 class="text-lg font-bold text-gray-900 tracking-tight">{{ Auth::user()->name }}</h1>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <button onclick="showNotificationModal()"
                        class="relative w-10 h-10 rounded-full flex items-center justify-center text-orange-500 hover:bg-orange-50 transition">
                        <i class="fa-regular fa-bell text-xl"></i>
                        <span class="absolute top-2 right-2 w-2 h-2 bg-red-500 rounded-full ring-2 ring-white"></span>
                    </button>
                    <button onclick="showServiceMessage('Bantuan CS')"
                        class="w-10 h-10 rounded-full bg-orange-500 text-white flex items-center justify-center shadow-md hover:bg-orange-600 transition">
                        <i class="fa-solid fa-headset text-lg"></i>
                    </button>
                </div>
            </div>

            <div class="flex-1 overflow-y-auto no-scrollbar pt-24 pb-32">
                {{-- PELATIHAN --}}
            <div class="mt-4">
                <div id="cardSlider"
                    class="flex overflow-x-auto space-x-4 px-5 no-scrollbar scroll-smooth snap-x snap-mandatory">
                    @forelse ($pelatihans as $pelatihan)
                        <!-- Card Pelatihan Dinamis -->
                        <div
                            class="snap-start min-w-[280px] w-[82%] sm:w-[300px] flex-shrink-0 bg-gradient-to-br from-cyan-400 to-blue-600 rounded-3xl p-5 text-white shadow-lg relative overflow-hidden flex flex-col justify-between h-[190px]    ">
                            <div
                                class="absolute -right-8 -bottom-8 w-32 h-32 bg-white/5 rounded-full pointer-events-none">
                            </div>
                            <div class="z-10">
                                <h2 class="text-lg font-black tracking-wide truncate">{{ $pelatihan->judul }}</h2>
                                <div class="mt-2 text-xs opacity-90 space-y-0.5 font-medium">
                                    <p>• Kuota:
                                        {{ $pelatihan->kuota > 0 ? $pelatihan->kuota . ' Peserta' : 'Tidak Terbatas' }}
                                    </p>
                                    <p class="font-semibold text-gray-300">• Biaya Pelatihan</p>
                                    <p class="text-lg font-extrabold text-white">Rp
                                        {{ number_format($pelatihan->harga, 0, ',', '.') }}</p>
                                </div>
                            </div>
                            <div class="z-10">
                                <a href="{{ route('user-pelatihan.show', $pelatihan->id) }}"
                                    class="bg-white text-gray-900 hover:bg-gray-100 font-bold text-xs px-4 py-2 rounded-full shadow transition">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    @empty
                        <div
                            class="min-w-[280px] w-full flex-shrink-0 bg-gray-100 rounded-3xl p-5 text-gray-500 shadow-inner relative flex flex-col justify-center items-center h-[190px]">
                            <i class="fa-solid fa-book-open text-3xl mb-2"></i>
                            <p class="text-sm font-semibold">Belum ada pelatihan tersedia.</p>
                            <p class="text-xs">Silakan cek kembali nanti.</p>
                        </div>
                    @endforelse

                    <!-- Card Coming Soon Tambahan (Selalu Tampil di Akhir Slider) -->
                    <div
                        class="snap-start min-w-[280px] w-[82%] sm:w-[300px] flex-shrink-0 bg-gradient-to-br from-amber-500/10 to-orange-500/10 border-2 border-dashed border-orange-400/50 rounded-3xl p-5 text-gray-800 shadow-sm relative overflow-hidden flex flex-col justify-between h-[190px]">
                        <div
                            class="absolute -right-8 -bottom-8 w-32 h-32 bg-orange-500/5 rounded-full pointer-events-none">
                        </div>
                        <div class="z-10">
                            <div class="flex items-center space-x-2 mb-2">
                                <span
                                    class="px-2.5 py-0.5 bg-orange-500 text-white text-[10px] font-extrabold uppercase rounded-full tracking-wider shadow-sm">Segera
                                    Hadir</span>
                            </div>
                            <h2 class="text-base font-black tracking-wide text-gray-900 truncate">Pelatihan & Event Baru
                            </h2>
                            <p class="mt-1.5 text-xs text-gray-500 font-medium leading-relaxed">
                                Nantikan jadwal pelatihan berkendara dan agenda mobilitas seru berikutnya dari kami.
                            </p>
                        </div>
                        <div class="z-10 flex items-center space-x-2 text-xs font-bold text-orange-600">
                            <i class="fa-regular fa-clock"></i>
                            <span>Stay Tuned!</span>
                        </div>
                    </div>
                </div>

                <!-- Dots Indicator -->
                @if ($pelatihans->count() > 1)
                    <div class="flex justify-center items-center space-x-1.5 mt-3" id="dotIndicators">
                        @foreach ($pelatihans as $index => $pelatihan)
                            <span onclick="scrollToCard({{ $index }})"
                                class="w-2 h-2 bg-gray-300 rounded-full cursor-pointer transition-all duration-300 dot {{ $loop->first ? 'active-dot' : '' }}"></span>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Anggota --}}
            <div class="mt-6 px-5" id="member-card">
                @if (isset($isRegistered) && $isRegistered)
                    <!-- Tampilan JIKA SUDAH TERDAFTAR -->
                    <div
                        class="relative rounded-3xl p-6 bg-slate-900 border border-slate-700 shadow-2xl overflow-hidden">
                        <div class="absolute -top-10 -right-10 w-40 h-40 bg-blue-500/10 rounded-full blur-2xl"></div>

                        <div class="flex items-center space-x-3 mb-4 relative z-10">
                            <div
                                class="w-10 h-10 bg-blue-500/20 rounded-xl flex items-center justify-center text-blue-400">
                                <i class="fa-solid fa-id-card"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-white text-sm">Status Keanggotaan</h4>
                                <span
                                    class="text-[10px] uppercase tracking-widest text-emerald-400 font-bold px-2 py-0.5 bg-emerald-400/10 rounded-full inline-block mt-1">
                                    {{ $status_anggota ?? 'AKTIF' }}
                                </span>
                            </div>
                        </div>

                        <div class="space-y-3 relative z-10">
                            <div class="flex items-center justify-between p-3 rounded-2xl bg-white/5">
                                <span class="text-slate-400 text-xs">Nama Lengkap</span>
                                <span class="text-white font-semibold text-xs">{{ $nama_anggota ?? '-' }}</span>
                            </div>
                            <div class="flex items-center justify-between p-3 rounded-2xl bg-white/5">
                                <span class="text-slate-400 text-xs">No. KTPA</span>
                                <span class="text-blue-400 font-mono font-bold text-xs">{{ $no_ktpa ?? '-' }}</span>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Tampilan JIKA BELUM TERDAFTAR -->
                    <div
                        class="relative group rounded-3xl p-6 bg-gradient-to-r from-orange-500 to-amber-500 shadow-xl shadow-orange-500/20 overflow-hidden">
                        <div class="absolute -top-10 -right-10 w-40 h-40 bg-white/20 rounded-full blur-2xl"></div>

                        <div class="relative z-10">
                            <div class="flex items-center space-x-3 mb-3">
                                <div
                                    class="w-10 h-10 bg-white/20 backdrop-blur-md rounded-xl flex items-center justify-center text-white">
                                    <i class="fa-solid fa-file-pen text-xl"></i>
                                </div>
                                <h4 class="font-extrabold text-white text-lg tracking-tight">Pendaftaran Anggota</h4>
                            </div>
                            <p class="text-white/90 text-xs mb-5">Gabung dengan komunitas IMI Mobilitas dan nikmati
                                berbagai akses eksklusif.</p>

                            <a href="{{ route('user-pelatihan.show', 1) }}"
                                class="w-full bg-white text-orange-600 hover:bg-gray-50 font-bold text-xs py-3 rounded-2xl shadow-lg transition-all duration-300 flex items-center justify-center space-x-2 block text-center">
                                <span>Formulir Pendaftaran</span>
                                <i class="fa-solid fa-arrow-right text-[10px]"></i>
                            </a>
                        </div>
                    </div>
                @endif
            </div>

            <div class="mt-5 px-5 mb-6">
                <h3 class="text-base font-bold text-gray-900 mb-4">Layanan Lainnya</h3>
                <div class="grid grid-cols-4 gap-3 sm:gap-4">
                    <a href="{{ route('user-anggota.index') }}"
                        class="flex flex-col items-center cursor-pointer group">
                        <div
                            class="w-14 h-14 sm:w-16 sm:h-16 rounded-2xl bg-orange-100/70 border border-orange-200 flex items-center justify-center text-orange-500 shadow-sm group-hover:scale-105 transition">
                            <i class="fa-solid fa-id-card text-xl sm:text-2xl"></i>
                        </div>
                        <span class="text-[11px] sm:text-xs font-semibold text-gray-700 mt-2 text-center">KARTU</span>
                    </a>
                    <a href="{{ route('user-pelatihan.index') }}"
                        class="flex flex-col items-center cursor-pointer group">
                        <div
                            class="w-14 h-14 sm:w-16 sm:h-16 rounded-2xl bg-orange-100/70 border border-orange-200 flex items-center justify-center text-orange-500 shadow-sm group-hover:scale-105 transition">
                            <i class="fa-solid fa-graduation-cap text-xl sm:text-2xl"></i>
                        </div>
                        <span
                            class="text-[11px] sm:text-xs font-semibold text-gray-700 mt-2 text-center">Pelatihan</span>
                    </a>
                    <a href="{{ route('sertifikat.index') }}"
                        class="flex flex-col items-center cursor-pointer group">
                        <div
                            class="w-14 h-14 sm:w-16 sm:h-16 rounded-2xl bg-orange-100/70 border border-orange-200 flex items-center justify-center text-orange-500 shadow-sm group-hover:scale-105 transition">
                            <i class="fa-solid fa-award text-xl sm:text-2xl"></i>
                        </div>
                        <span
                            class="text-[11px] sm:text-xs font-semibold text-gray-700 mt-2 text-center">Sertifikat</span>
                    </a>
                    <a href="#" class="flex flex-col items-center cursor-pointer group">
                        <div
                            class="w-14 h-14 sm:w-16 sm:h-16 rounded-2xl bg-orange-100/70 border border-orange-200 flex items-center justify-center text-orange-500 shadow-sm group-hover:scale-105 transition">
                            <i class="fa-solid fa-newspaper text-xl sm:text-2xl"></i>
                        </div>
                        <span
                            class="text-[11px] sm:text-xs font-semibold text-gray-700 mt-2 text-center">Artikel</span>
                    </a>
                    <div onclick="showServiceMessage('Audio / Podcast')"
                        class="flex flex-col items-center cursor-pointer group">
                        <div
                            class="w-14 h-14 sm:w-16 sm:h-16 rounded-2xl bg-orange-100/70 border border-orange-200 flex items-center justify-center text-orange-500 shadow-sm group-hover:scale-105 transition">
                            <i class="fa-solid fa-microphone text-xl sm:text-2xl"></i>
                        </div>
                        <span
                            class="text-[11px] sm:text-xs font-semibold text-gray-700 mt-2 text-center">Podcast</span>
                    </div>
                    <div onclick="showServiceMessage('Kalender Event')"
                        class="flex flex-col items-center cursor-pointer group">
                        <div
                            class="w-14 h-14 sm:w-16 sm:h-16 rounded-2xl bg-orange-100/70 border border-orange-200 flex items-center justify-center text-orange-500 shadow-sm group-hover:scale-105 transition">
                            <i class="fa-regular fa-calendar-days text-xl sm:text-2xl"></i>
                        </div>
                        <span
                            class="text-[11px] sm:text-xs font-semibold text-gray-700 mt-2 text-center">Kalender</span>
                    </div>
                    <div onclick="showServiceMessage('IMI TV / Streaming')"
                        class="flex flex-col items-center cursor-pointer group">
                        <div
                            class="w-14 h-14 sm:w-16 sm:h-16 rounded-2xl bg-orange-100/70 border border-orange-200 flex items-center justify-center text-orange-500 shadow-sm group-hover:scale-105 transition">
                            <i class="fa-solid fa-tv text-xl sm:text-2xl"></i>
                        </div>
                        <span class="text-[11px] sm:text-xs font-semibold text-gray-700 mt-2 text-center">IMI TV</span>
                    </div>
                    <div onclick="showServiceMessage('Semua Menu')"
                        class="flex flex-col items-center cursor-pointer group">
                        <div
                            class="w-14 h-14 sm:w-16 sm:h-16 rounded-2xl bg-orange-500 border border-orange-600 flex items-center justify-center text-white shadow-md group-hover:scale-105 transition">
                            <i class="fa-solid fa-grip text-xl sm:text-2xl"></i>
                        </div>
                        <span
                            class="text-[11px] sm:text-xs font-semibold text-gray-700 mt-2 text-center">Lainnya</span>
                    </div>
                </div>
            </div>

            <!-- Bagian Berita Tranding (Sesuai Screenshot) -->
            <div class="mt-5 px-5">
                <div class="flex justify-between items-center mb-3">
                    <h3 class="text-base font-bold text-gray-900">Berita Tranding</h3>
                    <button onclick="showServiceMessage('Semua Berita')"
                        class="text-xs font-semibold text-orange-500 hover:underline">Lihat Semua</button>
                </div>
                <div class="space-y-3">
                    <!-- News Item 1 -->
                    <div class="bg-white rounded-3xl p-3.5 shadow-sm border border-gray-100 flex items-center space-x-3.5 cursor-pointer hover:bg-gray-50 transition"
                        onclick="showServiceMessage('Berita: Terima Pengurus Komunitas Jeep')">
                        <div class="w-24 h-20 rounded-2xl overflow-hidden shrink-0 bg-gray-200">
                            <img src="https://placehold.co/200x150/orange/white?text=Jeep" alt="Jeep"
                                class="w-full h-full object-cover">
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-[10px] text-gray-400 font-medium flex items-center space-x-1">
                                <i class="fa-regular fa-clock"></i>
                                <span>about a year ago • Admin g...</span>
                            </p>
                            <h4 class="text-xs font-bold text-gray-900 mt-1 line-clamp-2 leading-snug">Terima Pengurus
                                Komunitas Jeep</h4>
                            <span class="text-[11px] font-bold text-blue-600 mt-1 inline-block">Berita
                                Selengkapnya</span>
                        </div>
                    </div>

                    <!-- News Item 2 -->
                    <div class="bg-white rounded-3xl p-3.5 shadow-sm border border-gray-100 flex items-center space-x-3.5 cursor-pointer hover:bg-gray-50 transition"
                        onclick="showServiceMessage('Berita: Kunjungi Bengkel UKM di Bandung')">
                        <div class="w-24 h-20 rounded-2xl overflow-hidden shrink-0 bg-gray-200">
                            <img src="https://placehold.co/200x150/blue/white?text=UKM" alt="UKM"
                                class="w-full h-full object-cover">
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-[10px] text-gray-400 font-medium flex items-center space-x-1">
                                <i class="fa-regular fa-clock"></i>
                                <span>about a year ago • Admin g...</span>
                            </p>
                            <h4 class="text-xs font-bold text-gray-900 mt-1 line-clamp-2 leading-snug">Kunjungi Bengkel
                                UKM di Bandung, Dorong</h4>
                            <span class="text-[11px] font-bold text-blue-600 mt-1 inline-block">Berita
                                Selengkapnya</span>
                        </div>
                    </div>

                    <!-- News Item 3 -->
                    <div class="bg-white rounded-3xl p-3.5 shadow-sm border border-gray-100 flex items-center space-x-3.5 cursor-pointer hover:bg-gray-50 transition"
                        onclick="showServiceMessage('Berita: Ketua MPR RI Bamsoet Buka Ajang Balap Motor')">
                        <div class="w-24 h-20 rounded-2xl overflow-hidden shrink-0 bg-gray-200">
                            <img src="https://placehold.co/200x150/amber/white?text=Balap" alt="Balap"
                                class="w-full h-full object-cover">
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-[10px] text-gray-400 font-medium flex items-center space-x-1">
                                <i class="fa-regular fa-clock"></i>
                                <span>3 years ago • Admin</span>
                            </p>
                            <h4 class="text-xs font-bold text-gray-900 mt-1 line-clamp-2 leading-snug">Ketua MPR RI
                                Bamsoet Buka Ajang Balap Motor</h4>
                            <span class="text-[11px] font-bold text-blue-600 mt-1 inline-block">Berita
                                Selengkapnya</span>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Iklan Banner Carousel (Full Gambar) --}}
            <div class="mt-4 px-5">
                <div class="relative w-full overflow-hidden rounded-3xl shadow-xl shadow-orange-500/10">
                    <!-- Slider Container -->
                    <div id="adSlider" class="flex transition-transform duration-500 ease-out snap-x snap-mandatory">

                        <!-- Slide 1 -->
                        <div
                            class="min-w-full snap-start relative rounded-3xl overflow-hidden flex-shrink-0 aspect-[16/9] sm:aspect-[21/9]">
                            <a href="#" class="block w-full h-full">
                                <img src="https://images.unsplash.com/photo-1558981403-c5f9899a28bc?w=800&auto=format&fit=crop&q=60"
                                    alt="Iklan 1" class="w-full h-full object-cover">
                            </a>
                        </div>

                        <!-- Slide 2 -->
                        <div
                            class="min-w-full snap-start relative rounded-3xl overflow-hidden flex-shrink-0 aspect-[16/9] sm:aspect-[21/9]">
                            <a href="#" class="block w-full h-full">
                                <img src="https://images.unsplash.com/photo-1568605117036-5fe5e7bab0b7?w=800&auto=format&fit=crop&q=60"
                                    alt="Iklan 2" class="w-full h-full object-cover">
                            </a>
                        </div>

                        <!-- Slide 3 -->
                        <div
                            class="min-w-full snap-start relative rounded-3xl overflow-hidden flex-shrink-0 aspect-[16/9] sm:aspect-[21/9]">
                            <a href="{{ route('user-pelatihan.index') }}" class="block w-full h-full">
                                <img src="https://images.unsplash.com/photo-1503376780353-7e6692767b70?w=800&auto=format&fit=crop&q=60"
                                    alt="Iklan 3" class="w-full h-full object-cover">
                            </a>
                        </div>

                    </div>

                    <!-- Indikator Titik (Dots) untuk Slider -->
                    <div
                        class="absolute bottom-3 left-0 right-0 flex justify-center space-x-1.5 z-20 pointer-events-none">
                        <span class="ad-dot w-2 h-2 rounded-full bg-white/60 transition-all duration-300"></span>
                        <span class="ad-dot w-2 h-2 rounded-full bg-white/60 transition-all duration-300"></span>
                        <span class="ad-dot w-2 h-2 rounded-full bg-white/60 transition-all duration-300"></span>
                    </div>
                </div>
            </div>

            <script>
                // Skrip Pendukung untuk Auto Slide Banner Iklan
                document.addEventListener("DOMContentLoaded", function() {
                    const slider = document.getElementById('adSlider');
                    if (!slider) return;

                    const dots = document.querySelectorAll('.ad-dot');
                    const totalSlides = dots.length;
                    let currentSlide = 0;

                    function updateDots() {
                        dots.forEach((dot, index) => {
                            if (index === currentSlide) {
                                dot.classList.remove('bg-white/60', 'w-2');
                                dot.classList.add('bg-white', 'w-5');
                            } else {
                                dot.classList.remove('bg-white', 'w-5');
                                dot.classList.add('bg-white/60', 'w-2');
                            }
                        });
                    }

                    function nextSlide() {
                        currentSlide = (currentSlide + 1) % totalSlides;
                        slider.style.transform = `translateX(-${currentSlide * 100}%)`;
                        updateDots();
                    }

                    let slideInterval = setInterval(nextSlide, 4000);

                    slider.addEventListener('mouseenter', () => clearInterval(slideInterval));
                    slider.addEventListener('mouseleave', () => {
                        slideInterval = setInterval(nextSlide, 4000);
                    });

                    updateDots();
                });
            </script>

            <div class="mt-5 px-5">
                <div class="flex justify-between items-center mb-3">
                    <h3 class="text-base font-bold text-gray-900">Berita Terbaru</h3>
                    <button onclick="showServiceMessage('Semua Berita')"
                        class="text-xs font-semibold text-orange-500 hover:underline">Lihat Semua</button>
                </div>
                <div class="space-y-3">
                    <!-- News Item 1 -->
                    <div class="bg-white rounded-3xl p-3.5 shadow-sm border border-gray-100 flex items-center space-x-3.5 cursor-pointer hover:bg-gray-50 transition"
                        onclick="showServiceMessage('Berita: Terima Pengurus Komunitas Jeep')">
                        <div class="w-24 h-20 rounded-2xl overflow-hidden shrink-0 bg-gray-200">
                            <img src="https://placehold.co/200x150/orange/white?text=Jeep" alt="Jeep"
                                class="w-full h-full object-cover">
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-[10px] text-gray-400 font-medium flex items-center space-x-1">
                                <i class="fa-regular fa-clock"></i>
                                <span>about a year ago • Admin g...</span>
                            </p>
                            <h4 class="text-xs font-bold text-gray-900 mt-1 line-clamp-2 leading-snug">Terima Pengurus
                                Komunitas Jeep</h4>
                            <span class="text-[11px] font-bold text-blue-600 mt-1 inline-block">Berita
                                Selengkapnya</span>
                        </div>
                    </div>

                    <!-- News Item 2 -->
                    <div class="bg-white rounded-3xl p-3.5 shadow-sm border border-gray-100 flex items-center space-x-3.5 cursor-pointer hover:bg-gray-50 transition"
                        onclick="showServiceMessage('Berita: Kunjungi Bengkel UKM di Bandung')">
                        <div class="w-24 h-20 rounded-2xl overflow-hidden shrink-0 bg-gray-200">
                            <img src="https://placehold.co/200x150/blue/white?text=UKM" alt="UKM"
                                class="w-full h-full object-cover">
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-[10px] text-gray-400 font-medium flex items-center space-x-1">
                                <i class="fa-regular fa-clock"></i>
                                <span>about a year ago • Admin g...</span>
                            </p>
                            <h4 class="text-xs font-bold text-gray-900 mt-1 line-clamp-2 leading-snug">Kunjungi Bengkel
                                UKM di Bandung, Dorong</h4>
                            <span class="text-[11px] font-bold text-blue-600 mt-1 inline-block">Berita
                                Selengkapnya</span>
                        </div>
                    </div>

                    <!-- News Item 3 -->
                    <div class="bg-white rounded-3xl p-3.5 shadow-sm border border-gray-100 flex items-center space-x-3.5 cursor-pointer hover:bg-gray-50 transition"
                        onclick="showServiceMessage('Berita: Ketua MPR RI Bamsoet Buka Ajang Balap Motor')">
                        <div class="w-24 h-20 rounded-2xl overflow-hidden shrink-0 bg-gray-200">
                            <img src="https://placehold.co/200x150/amber/white?text=Balap" alt="Balap"
                                class="w-full h-full object-cover">
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-[10px] text-gray-400 font-medium flex items-center space-x-1">
                                <i class="fa-regular fa-clock"></i>
                                <span>3 years ago • Admin</span>
                            </p>
                            <h4 class="text-xs font-bold text-gray-900 mt-1 line-clamp-2 leading-snug">Ketua MPR RI
                                Bamsoet Buka Ajang Balap Motor</h4>
                            <span class="text-[11px] font-bold text-blue-600 mt-1 inline-block">Berita
                                Selengkapnya</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- BOTTOM NAVIGATION BAR (Mobile View) -->
            <div
                class="fixed bottom-0 left-0 right-0 w-full bg-white border-t border-gray-100 py-3 px-6 flex justify-around items-center z-30 shadow-lg">
                <button onclick="switchTab(this, 'Beranda')"
                    class="flex flex-col items-center text-orange-500 transition active-tab">
                    <div
                        class="bg-orange-500 text-white px-4 py-1.5 rounded-full flex items-center space-x-1.5 shadow-sm">
                        <i class="fa-solid fa-house text-sm"></i>
                        <span class="text-xs font-bold">Beranda</span>
                    </div>
                </button>
                <button onclick="switchTab(this, 'Explore')"
                    class="flex flex-col items-center text-gray-400 hover:text-gray-600 transition p-2">
                    <i class="fa-solid fa-globe text-xl"></i>
                </button>
                <button onclick="switchTab(this, 'Community')"
                    class="flex flex-col items-center text-gray-400 hover:text-gray-600 transition p-2">
                    <i class="fa-solid fa-user-group text-xl"></i>
                </button>
                <button onclick="switchTab(this, 'Profile')"
                    class="flex flex-col items-center text-gray-400 hover:text-gray-600 transition p-2">
                    <i class="fa-regular fa-folder text-xl"></i>
                </button>
            </div>

            <div
                class="absolute bottom-1 left-1/2 -translate-x-1/2 w-32 h-1 bg-gray-800 rounded-full z-30 pointer-events-none hidden sm:block">
            </div>
        </div>

        <!-- ================= FULL DESKTOP WEB DASHBOARD VIEW ================= -->
        <div id="webDashboardView"
            class="w-full max-w-full bg-white rounded-none md:rounded-3xl shadow-xl flex flex-col overflow-hidden min-h-screen md:min-h-[90vh] border-0 md:border border-gray-200">
            <!-- Web Header Topbar -->
            <div
                class="bg-gradient-to-r from-gray-900 to-zinc-800 text-white px-6 md:px-10 py-6 flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                <div class="flex items-center space-x-4">
                    <div
                        class="w-14 h-14 rounded-2xl border-2 border-orange-500 p-1 flex items-center justify-center bg-orange-100 text-gray-700 overflow-hidden shadow-md">
                        <img src="https://placehold.co/100x100/orange/white?text=Admin" alt="Profile"
                            class="w-full h-full rounded-xl object-cover">
                    </div>
                    <div>
                        <div class="flex items-center space-x-2">
                            <span
                                class="bg-orange-500 text-white text-[10px] font-bold px-2 py-0.5 rounded uppercase tracking-wider">Web
                                Full Portal</span>
                            <span class="text-xs text-gray-300">IMI Mobilitas Pusat</span>
                        </div>
                        <h1 class="text-2xl font-black tracking-tight mt-0.5">Dashboard Administrator & Member</h1>
                    </div>
                </div>
                <div class="flex items-center space-x-3 w-full md:w-auto justify-between md:justify-end">
                    <div class="relative flex-1 md:flex-initial">
                        <input type="text" placeholder="Cari layanan atau member..."
                            class="bg-gray-800 text-sm text-white placeholder-gray-400 px-4 py-2 pl-10 rounded-xl border border-gray-700 focus:outline-none focus:border-orange-500 w-full md:w-64">
                        <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-3 text-gray-400 text-xs"></i>
                    </div>
                    <button onclick="showNotificationModal()"
                        class="w-10 h-10 rounded-xl bg-gray-800 hover:bg-gray-700 text-orange-400 flex items-center justify-center transition border border-gray-700 shrink-0">
                        <i class="fa-regular fa-bell text-lg"></i>
                    </button>
                    <button onclick="showServiceMessage('Pengaturan Akun')"
                        class="w-10 h-10 rounded-xl bg-orange-500 hover:bg-orange-600 text-white flex items-center justify-center transition shadow-md shrink-0">
                        <i class="fa-solid fa-gear"></i>
                    </button>
                </div>
            </div>

            <!-- Web Dashboard Content Body -->
            <div class="p-4 md:p-8 space-y-6 md:space-y-8 bg-gray-50 flex-1">
                <!-- Top Row: Stats & Quick Overview -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div
                        class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
                        <div>
                            <p class="text-xs text-gray-500 font-semibold uppercase">Total Keanggotaan</p>
                            <h3 class="text-2xl font-extrabold text-gray-900 mt-1">24,592</h3>
                            <span class="text-xs text-emerald-600 font-bold mt-1 inline-block"><i
                                    class="fa-solid fa-arrow-trend-up"></i> +12% bulan ini</span>
                        </div>
                        <div
                            class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl">
                            <i class="fa-solid fa-users"></i>
                        </div>
                    </div>
                    <div
                        class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
                        <div>
                            <p class="text-xs text-gray-500 font-semibold uppercase">Kartu Digital Aktif</p>
                            <h3 class="text-2xl font-extrabold text-gray-900 mt-1">19,840</h3>
                            <span class="text-xs text-emerald-600 font-bold mt-1 inline-block"><i
                                    class="fa-solid fa-circle-check"></i> 94% Valid</span>
                        </div>
                        <div
                            class="w-12 h-12 rounded-xl bg-orange-50 text-orange-600 flex items-center justify-center text-xl">
                            <i class="fa-solid fa-id-card"></i>
                        </div>
                    </div>
                    <div
                        class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
                        <div>
                            <p class="text-xs text-gray-500 font-semibold uppercase">Event & Kalender</p>
                            <h3 class="text-2xl font-extrabold text-gray-900 mt-1">14 Event</h3>
                            <span class="text-xs text-amber-600 font-bold mt-1 inline-block"><i
                                    class="fa-solid fa-calendar-day"></i> Segera Berlangsung</span>
                        </div>
                        <div
                            class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl">
                            <i class="fa-solid fa-flag-checkered"></i>
                        </div>
                    </div>
                    <div
                        class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
                        <div>
                            <p class="text-xs text-gray-500 font-semibold uppercase">Asuransi Perjalanan</p>
                            <h3 class="text-2xl font-extrabold text-gray-900 mt-1">Gaspol Active</h3>
                            <span class="text-xs text-blue-600 font-bold mt-1 inline-block"><i
                                    class="fa-solid fa-shield-halved"></i> Terproteksi</span>
                        </div>
                        <div
                            class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-xl">
                            <i class="fa-solid fa-bolt"></i>
                        </div>
                    </div>
                </div>

                <!-- Middle Section: Membership Tier Grid for Web -->
                <div>
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Pilihan Pelatihan Tersedia</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @forelse ($pelatihans as $pelatihan)
                            <!-- Web Card Dinamis -->
                            <div
                                class="bg-gradient-to-br from-gray-900 to-zinc-800 rounded-3xl p-6 text-white shadow-md relative overflow-hidden flex flex-col justify-between min-h-[220px]">
                                <div
                                    class="absolute -right-8 -bottom-8 w-36 h-36 bg-white/5 rounded-full pointer-events-none">
                                </div>
                                <div class="relative z-10">
                                    <h2 class="text-2xl font-black tracking-wide truncate"
                                        title="{{ $pelatihan->judul }}">{{ $pelatihan->judul }}</h2>
                                    <div class="mt-3 text-xs opacity-90 space-y-1 font-medium">
                                        <p class="font-semibold text-gray-300">• Biaya Pelatihan: <span
                                                class="text-base font-extrabold text-white">Rp
                                                {{ number_format($pelatihan->harga, 0, ',', '.') }}</span></p>
                                        <p class="truncate">• Lokasi: {{ $pelatihan->lokasi }}</p>
                                        <p>• Kuota:
                                            {{ $pelatihan->kuota > 0 ? $pelatihan->kuota . ' Peserta' : 'Tidak Terbatas' }}
                                        </p>
                                    </div>
                                </div>
                                <div class="mt-4 relative z-10">
                                    <a href="{{ route('user-pelatihan.show', $pelatihan->id) }}"
                                        class="bg-white text-gray-900 hover:bg-gray-100 font-bold text-sm px-5 py-2.5 rounded-full shadow transition">
                                        Lihat Detail
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div
                                class="md:col-span-3 bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col items-center justify-center text-center min-h-[220px]">
                                <i class="fa-solid fa-book-open text-4xl text-gray-400 mb-3"></i>
                                <h3 class="text-lg font-bold text-gray-800">Belum Ada Pelatihan</h3>
                                <p class="text-sm text-gray-500 mt-1">Saat ini belum ada pelatihan yang tersedia.
                                    Silakan cek kembali nanti.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Bottom Services Web Grid -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <h3 class="text-base font-bold text-gray-900 mb-4">Layanan & Fitur Web IMI Mobilitas</h3>
                    <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-8 gap-4">
                        <div onclick="showServiceMessage('Mitra')"
                            class="flex flex-col items-center cursor-pointer group p-3 rounded-xl hover:bg-orange-50 transition">
                            <div
                                class="w-12 h-12 rounded-xl bg-orange-100 text-orange-500 flex items-center justify-center text-xl shadow-sm">
                                <i class="fa-solid fa-handshake"></i>
                            </div>
                            <span class="text-xs font-semibold text-gray-700 mt-2 text-center">Mitra</span>
                        </div>
                        <div onclick="showServiceMessage('Merchandise')"
                            class="flex flex-col items-center cursor-pointer group p-3 rounded-xl hover:bg-orange-50 transition">
                            <div
                                class="w-12 h-12 rounded-xl bg-orange-100 text-orange-500 flex items-center justify-center text-xl shadow-sm">
                                <i class="fa-solid fa-shirt"></i>
                            </div>
                            <span class="text-xs font-semibold text-gray-700 mt-2 text-center">Merchandise</span>
                        </div>
                        <div onclick="showServiceMessage('Store')"
                            class="flex flex-col items-center cursor-pointer group p-3 rounded-xl hover:bg-orange-50 transition">
                            <div
                                class="w-12 h-12 rounded-xl bg-orange-100 text-orange-500 flex items-center justify-center text-xl shadow-sm">
                                <i class="fa-solid fa-store"></i>
                            </div>
                            <span class="text-xs font-semibold text-gray-700 mt-2 text-center">Store</span>
                        </div>
                        <div onclick="showServiceMessage('P1')"
                            class="flex flex-col items-center cursor-pointer group p-3 rounded-xl hover:bg-orange-50 transition">
                            <div
                                class="w-12 h-12 rounded-xl bg-orange-100 text-orange-500 flex items-center justify-center text-xl shadow-sm">
                                <i class="fa-solid fa-flag-checkered"></i>
                            </div>
                            <span class="text-xs font-semibold text-gray-700 mt-2 text-center">P1</span>
                        </div>
                        <div onclick="showServiceMessage('Audio / Podcast')"
                            class="flex flex-col items-center cursor-pointer group p-3 rounded-xl hover:bg-orange-50 transition">
                            <div
                                class="w-12 h-12 rounded-xl bg-orange-100 text-orange-500 flex items-center justify-center text-xl shadow-sm">
                                <i class="fa-solid fa-microphone"></i>
                            </div>
                            <span class="text-xs font-semibold text-gray-700 mt-2 text-center">Podcast</span>
                        </div>
                        <div onclick="showServiceMessage('Kalender Event')"
                            class="flex flex-col items-center cursor-pointer group p-3 rounded-xl hover:bg-orange-50 transition">
                            <div
                                class="w-12 h-12 rounded-xl bg-orange-100 text-orange-500 flex items-center justify-center text-xl shadow-sm">
                                <i class="fa-regular fa-calendar-days"></i>
                            </div>
                            <span class="text-xs font-semibold text-gray-700 mt-2 text-center">Kalender</span>
                        </div>
                        <div onclick="showServiceMessage('IMI TV / Streaming')"
                            class="flex flex-col items-center cursor-pointer group p-3 rounded-xl hover:bg-orange-50 transition">
                            <div
                                class="w-12 h-12 rounded-xl bg-orange-100 text-orange-500 flex items-center justify-center text-xl shadow-sm">
                                <i class="fa-solid fa-tv"></i>
                            </div>
                            <span class="text-xs font-semibold text-gray-700 mt-2 text-center">IMI TV</span>
                        </div>
                        <div onclick="showServiceMessage('Semua Menu')"
                            class="flex flex-col items-center cursor-pointer group p-3 rounded-xl hover:bg-orange-50 transition">
                            <div
                                class="w-12 h-12 rounded-xl bg-orange-500 text-white flex items-center justify-center text-xl shadow-sm">
                                <i class="fa-solid fa-grip"></i>
                            </div>
                            <span class="text-xs font-bold text-orange-600 mt-2 text-center">Lainnya</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div id="customModal"
        class="fixed inset-0 bg-gray-900/60 z-50 flex items-center justify-center px-4 hidden opacity-0 transition-opacity duration-300">
        <div class="bg-white rounded-3xl p-6 max-w-xs w-full shadow-2xl transform scale-95 transition-transform duration-300"
            id="modalContent">
            <div class="text-center">
                <div
                    class="w-12 h-12 bg-orange-100 text-orange-500 rounded-2xl flex items-center justify-center mx-auto mb-3 text-xl shadow-sm">
                    <i class="fa-solid fa-id-card" id="modalIcon"></i>
                </div>
                <h3 id="modalTitle" class="text-base font-bold text-gray-900">Pendaftaran</h3>
                <p id="modalDesc" class="text-xs text-gray-500 mt-1.5">Detail informasi paket keanggotaan.</p>
            </div>
            <div class="mt-6 flex space-x-2">
                <button onclick="closeModal()"
                    class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-2.5 rounded-xl text-xs transition">Tutup</button>
                <button onclick="confirmAction()"
                    class="flex-1 bg-orange-500 hover:bg-orange-600 text-white font-bold py-2.5 rounded-xl text-xs shadow transition">Lanjutkan</button>
            </div>
        </div>
    </div>

    <script>
        const modal = document.getElementById('customModal');
        const modalContent = document.getElementById('modalContent');
        const modalTitle = document.getElementById('modalTitle');
        const modalDesc = document.getElementById('modalDesc');
        const cardSlider = document.getElementById('cardSlider');
        const dots = document.querySelectorAll('.dot');
        const androidView = document.getElementById('androidView');
        const webDashboardView = document.getElementById('webDashboardView');
        const btnMobileView = document.getElementById('btnMobileView');
        const btnDesktopView = document.getElementById('btnDesktopView');
        const viewSwitcherBar = document.getElementById('viewSwitcherBar');

        if (dots.length > 0) {
            dots[0].classList.replace('bg-gray-300', 'bg-orange-500');
            dots[0].classList.replace('w-2', 'w-5');
        }

        // Auto detect platform or screen size on load
        window.addEventListener('DOMContentLoaded', () => {
            const ua = navigator.userAgent || navigator.vendor || window.opera;
            // Deteksi Android Auto atau layar luas komputer/tablet
            const isAndroidAuto = /Android Auto/i.test(ua);
            const isWideScreen = window.innerWidth >= 1024;

            if (isAndroidAuto || isWideScreen) {
                // Otomatis langsung masuk ke Full Desktop & Full 1 Layar
                setViewMode('desktop');
            } else {
                setViewMode('mobile');
            }
        });

        function setViewMode(mode) {
            const btnDesktopView = document.getElementById('btnDesktopView');
            const btnMobileView = document.getElementById('btnMobileView');
            const viewSwitcherBar = document.getElementById('viewSwitcherBar');

            if (mode === 'mobile') {
                androidView.classList.remove('hidden');
                webDashboardView.classList.add('hidden');
                if (viewSwitcherBar) viewSwitcherBar.classList.remove('hidden');
                if (btnMobileView) {
                    btnMobileView.className =
                        "px-4 py-1.5 text-xs font-bold rounded-full transition bg-orange-500 text-white shadow";
                }
                if (btnDesktopView) {
                    btnDesktopView.className =
                        "px-4 py-1.5 text-xs font-bold rounded-full transition text-gray-600 hover:text-gray-900";
                }
            } else {
                androidView.classList.add('hidden');
                webDashboardView.classList.remove('hidden');
                if (viewSwitcherBar) viewSwitcherBar.classList.remove('hidden');
                if (btnDesktopView) {
                    btnDesktopView.className =
                        "px-4 py-1.5 text-xs font-bold rounded-full transition bg-orange-500 text-white shadow";
                }
                if (btnMobileView) {
                    btnMobileView.className =
                        "px-4 py-1.5 text-xs font-bold rounded-full transition text-gray-600 hover:text-gray-900";
                }
            }
        }

        // Card slider scroll observer for dot indicator
        if (cardSlider) {
            cardSlider.addEventListener('scroll', () => {
                const scrollLeft = cardSlider.scrollLeft;
                const cardWidth = cardSlider.querySelector('div').clientWidth + 16;
                const activeIndex = Math.round(scrollLeft / cardWidth);
                dots.forEach((dot, index) => {
                    if (index === activeIndex) {
                        dot.className =
                            "w-5 h-2 bg-orange-500 rounded-full cursor-pointer transition-all duration-300 dot";
                    } else {
                        dot.className =
                            "w-2 h-2 bg-gray-300 rounded-full cursor-pointer transition-all duration-300 dot";
                    }
                });
            });
        }

        function scrollToCard(index) {
            const cardWidth = cardSlider.querySelector('div').clientWidth + 16;
            cardSlider.scrollTo({
                left: cardWidth * index,
                behavior: 'smooth'
            });
        }

        function openModal(packageName, price) {
            modalTitle.innerText = `Pendaftaran ${packageName}`;
            modalDesc.innerText = `Biaya keanggotaan sebesar ${price}. Lanjutkan proses pendaftaran kartu resmi IMI?`;
            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                modalContent.classList.remove('scale-95');
                modalContent.classList.add('scale-100');
            }, 10);
        }

        function closeModal() {
            modal.classList.add('opacity-0');
            modalContent.classList.remove('scale-100');
            modalContent.classList.add('scale-95');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }

        function showServiceMessage(serviceName) {
            modalTitle.innerText = `Layanan ${serviceName}`;
            modalDesc.innerText = `Fitur atau layanan ${serviceName} akan segera tersedia untuk Anda gunakan.`;
            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                modalContent.classList.remove('scale-95');
                modalContent.classList.add('scale-100');
            }, 10);
        }

        function showNotificationModal() {
            modalTitle.innerText = "Notifikasi Terbaru";
            modalDesc.innerText = "Tidak ada pemberitahuan baru saat ini. Pastikan keanggotaan Anda selalu aktif.";
            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                modalContent.classList.remove('scale-95');
                modalContent.classList.add('scale-100');
            }, 10);
        }

        function confirmAction() {
            closeModal();
            showServiceMessage("Pendaftaran Berhasil");
        }

        function switchTab(btnElement, tabName) {
            const buttons = btnElement.parentElement.querySelectorAll('button');
            buttons.forEach(btn => {
                btn.className = "flex flex-col items-center text-gray-400 hover:text-gray-600 transition p-2";
                btn.innerHTML = btn.querySelector('i').outerHTML;
            });
            btnElement.className = "flex flex-col items-center text-orange-500 transition active-tab";
            let iconClass = "fa-solid fa-house text-sm";
            if (tabName === 'Explore') iconClass = "fa-solid fa-globe text-xl";
            if (tabName === 'Community') iconClass = "fa-solid fa-user-group text-xl";
            if (tabName === 'Profile') iconClass = "fa-regular fa-folder text-xl";

            btnElement.innerHTML = `
                <div class="bg-orange-500 text-white px-4 py-1.5 rounded-full flex items-center space-x-1.5 shadow-sm">
                    <i class="${iconClass}"></i>
                    <span class="text-xs font-bold">${tabName}</span>
                </div>
            `;
            if (tabName !== 'Beranda') {
                showServiceMessage(tabName);
            }
        }
    </script>
</body>

</html>
