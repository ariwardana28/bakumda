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

        <!-- ================= ANDROID MOBILE APP VIEW CONTAINER ================= -->
        <div id="androidView"
            class="w-full sm:max-w-[412px] bg-white min-h-screen sm:min-h-[860px] sm:rounded-[45px] sm:ring-[12px] sm:ring-slate-800 sm:shadow-2xl relative flex flex-col justify-between pb-32 overflow-hidden transition-all duration-300">

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
            <div
                class="fixed top-0 left-0 right-0 px-5 pt-4 pb-2 flex items-center justify-between bg-white shadow-sm z-30 sm:max-w-[412px] sm:mx-auto">
                <div class="flex items-center space-x-3">
                    <div
                        class="w-12 h-12 rounded-full border-2 border-orange-500 p-0.5 flex items-center justify-center bg-orange-100 text-gray-700 overflow-hidden shadow-sm">
                        <img src="{{ asset('bakumda.png') }}" alt="Profile"
                            class="w-full h-full rounded-full object-cover">
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 font-medium">Halo</p>
                        <h1 class="text-lg font-bold text-gray-900 tracking-tight">
                            {{ Auth::user()->name ?? 'Selamat Datang !' }}</h1>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <button onclick="showNotificationModal()"
                        class="relative w-10 h-10 rounded-full flex items-center justify-center text-orange-500 hover:bg-orange-50 transition">
                        <i class="fa-regular fa-bell text-xl"></i>
                        <span class="absolute top-2 right-2 w-2 h-2 bg-red-500 rounded-full ring-2 ring-white"></span>
                    </button>
                    <button
                        class="w-10 h-10 rounded-full bg-orange-500 text-white flex items-center justify-center shadow-md hover:bg-orange-600 transition">
                        <i class="fa-solid fa-headset text-lg"></i>
                    </button>
                </div>
            </div>

            <div class="flex-1 overflow-y-auto no-scrollbar pt-24 pb-32">

                {{-- Anggota --}}
                <div class="mt-6 px-5" id="member-card">
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

                            <button onclick="handleProtectedAction('{{ route('user-pelatihan.show', 1) }}')"
                                class="w-full bg-white text-orange-600 hover:bg-gray-50 font-bold text-xs py-3 rounded-2xl shadow-lg transition-all duration-300 flex items-center justify-center space-x-2">
                                <span>Formulir Pendaftaran</span>
                                <i class="fa-solid fa-arrow-right text-[10px]"></i>
                            </button>
                        </div>
                    </div>
                </div>



                {{-- LAYANAN LAINNYA (Dilindungi dengan Cek Login via Modal) --}}
                <div class="mt-5 px-5 mb-6">
                    <h3 class="text-base font-bold text-gray-900 mb-4">Layanan Lainnya</h3>
                    <div class="grid grid-cols-4 gap-3 sm:gap-4">

                        <!-- Menu: Kartu -->
                        <div onclick="handleProtectedAction('{{ route('kartu-anggota.cek.form') }}')"
                            class="flex flex-col items-center cursor-pointer group">
                            <div
                                class="w-14 h-14 sm:w-16 sm:h-16 rounded-2xl bg-orange-100/70 border border-orange-200 flex items-center justify-center text-orange-500 shadow-sm group-hover:scale-105 transition">
                                <i class="fa-solid fa-id-card text-sm"></i>
                            </div>
                            <span
                                class="text-[11px] sm:text-xs font-semibold text-gray-700 mt-2 text-center">KARTU</span>
                        </div>

                        <!-- Menu: Pelatihan -->
                        <div onclick="handleProtectedAction('{{ route('user-pelatihan.index') }}')"
                            class="flex flex-col items-center cursor-pointer group">
                            <div
                                class="w-14 h-14 sm:w-16 sm:h-16 rounded-2xl bg-orange-100/70 border border-orange-200 flex items-center justify-center text-orange-500 shadow-sm group-hover:scale-105 transition">
                                <i class="fa-solid fa-graduation-cap text-xl sm:text-2xl"></i>
                            </div>
                            <span
                                class="text-[11px] sm:text-xs font-semibold text-gray-700 mt-2 text-center">Pelatihan</span>
                        </div>

                        <!-- Menu: Sertifikat -->
                        <div onclick="handleProtectedAction('{{ route('sertifikat.cek.form') }}')"
                            class="flex flex-col items-center cursor-pointer group">
                            <div
                                class="w-14 h-14 sm:w-16 sm:h-16 rounded-2xl bg-orange-100/70 border border-orange-200 flex items-center justify-center text-orange-500 shadow-sm group-hover:scale-105 transition">
                                <i class="fa-solid fa-award text-xl sm:text-2xl"></i>
                            </div>
                            <span
                                class="text-[11px] sm:text-xs font-semibold text-gray-700 mt-2 text-center">Sertifikat</span>
                        </div>

                        <!-- Menu: Artikel -->
                        <div onclick="handleProtectedAction('#')"
                            class="flex flex-col items-center cursor-pointer group">
                            <div
                                class="w-14 h-14 sm:w-16 sm:h-16 rounded-2xl bg-orange-100/70 border border-orange-200 flex items-center justify-center text-orange-500 shadow-sm group-hover:scale-105 transition">
                                <i class="fa-solid fa-newspaper text-xl sm:text-2xl"></i>
                            </div>
                            <span
                                class="text-[11px] sm:text-xs font-semibold text-gray-700 mt-2 text-center">Artikel</span>
                        </div>

                        <!-- Menu: Podcast -->
                        <div onclick="handleProtectedAction('#')"
                            class="flex flex-col items-center cursor-pointer group">
                            <div
                                class="w-14 h-14 sm:w-16 sm:h-16 rounded-2xl bg-orange-100/70 border border-orange-200 flex items-center justify-center text-orange-500 shadow-sm group-hover:scale-105 transition">
                                <i class="fa-solid fa-microphone text-xl sm:text-2xl"></i>
                            </div>
                            <span
                                class="text-[11px] sm:text-xs font-semibold text-gray-700 mt-2 text-center">Podcast</span>
                        </div>

                        <!-- Menu: Kalender -->
                        <div onclick="handleProtectedAction('#')"
                            class="flex flex-col items-center cursor-pointer group">
                            <div
                                class="w-14 h-14 sm:w-16 sm:h-16 rounded-2xl bg-orange-100/70 border border-orange-200 flex items-center justify-center text-orange-500 shadow-sm group-hover:scale-105 transition">
                                <i class="fa-regular fa-calendar-days text-xl sm:text-2xl"></i>
                            </div>
                            <span
                                class="text-[11px] sm:text-xs font-semibold text-gray-700 mt-2 text-center">Kalender</span>
                        </div>

                        <!-- Menu: IMI TV -->
                        <div onclick="handleProtectedAction('#')"
                            class="flex flex-col items-center cursor-pointer group">
                            <div
                                class="w-14 h-14 sm:w-16 sm:h-16 rounded-2xl bg-orange-100/70 border border-orange-200 flex items-center justify-center text-orange-500 shadow-sm group-hover:scale-105 transition">
                                <i class="fa-solid fa-tv text-xl sm:text-2xl"></i>
                            </div>
                            <span class="text-[11px] sm:text-xs font-semibold text-gray-700 mt-2 text-center">IMI
                                TV</span>
                        </div>

                        <!-- Menu: Lainnya -->
                        <div onclick="handleProtectedAction('#')"
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
                {{-- PELATIHAN --}}
                <div class="mt-4">
                    <div id="cardSlider"
                        class="flex overflow-x-auto space-x-4 px-5 no-scrollbar scroll-smooth snap-x snap-mandatory">
                        @forelse ($pelatihans as $pelatihan)
                            <div
                                class="snap-start min-w-[280px] w-[82%] sm:w-[300px] flex-shrink-0 bg-gradient-to-br from-cyan-400 to-blue-600 rounded-3xl p-5 text-white shadow-lg relative overflow-hidden flex flex-col justify-between h-[190px]">
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
                                    <button
                                        onclick="handleProtectedAction('{{ route('user-pelatihan.show', $pelatihan->id) }}')"
                                        class="bg-white text-gray-900 hover:bg-gray-100 font-bold text-xs px-4 py-2 rounded-full shadow transition">
                                        Lihat Detail
                                    </button>
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

                        <!-- Card Coming Soon Tambahan -->
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
                                <h2 class="text-base font-black tracking-wide text-gray-900 truncate">Pelatihan & Event
                                    Baru
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
                </div>

                <!-- Bagian Berita Tranding (Sesuai Screenshot) -->
                <div class="px-5">
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
                                <h4 class="text-xs font-bold text-gray-900 mt-1 line-clamp-2 leading-snug">Terima
                                    Pengurus
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
                                <h4 class="text-xs font-bold text-gray-900 mt-1 line-clamp-2 leading-snug">Kunjungi
                                    Bengkel
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
                <div class="px-5">
                    <div class="relative w-full overflow-hidden rounded-3xl shadow-xl shadow-orange-500/10">
                        <!-- Slider Container -->
                        <div id="adSlider"
                            class="flex transition-transform duration-500 ease-out snap-x snap-mandatory">

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

                <div class="px-5">
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
                                <h4 class="text-xs font-bold text-gray-900 mt-1 line-clamp-2 leading-snug">Terima
                                    Pengurus
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
                                <h4 class="text-xs font-bold text-gray-900 mt-1 line-clamp-2 leading-snug">Kunjungi
                                    Bengkel
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
            </div>

            <!-- Bottom Navigation Bar -->
            <div
                class="fixed bottom-0 left-0 right-0 h-24 bg-white shadow-[0_-5px_20px_-5px_rgba(0,0,0,0.05)] z-30 sm:max-w-[412px] sm:mx-auto sm:rounded-b-[45px] flex justify-center items-start pt-3">
                <div class="flex justify-around items-start w-full max-w-xs">

                    <!-- Tombol Kartu -->
                    <button onclick="handleProtectedAction('{{ route('user-pelatihan.index') }}')"
                        class="flex flex-col items-center space-y-1 text-gray-400 hover:text-orange-500 transition">
                        <i class="fa-solid fa-id-card text-xl"></i>
                        <span class="text-[10px] font-bold">Kartu</span>
                    </button>
                    <!-- Tombol Pendaftaran (sebelumnya Beranda) -->
                    <button onclick="handleProtectedAction('{{ route('user-pelatihan.show', 1) }}')"
                        class="flex flex-col items-center space-y-1 text-gray-400 hover:text-orange-500 transition">
                        <i class="fa-solid fa-clipboard-check text-xl"></i>
                        <span class="text-[10px] font-bold">Cek Sertifikat</span>
                    </button>
                    <!-- Tombol Beranda (Tengah) -->
                    <a href="{{ route('welcome') }}"
                        class="w-16 h-16 rounded-full bg-orange-500 text-white flex items-center justify-center -mt-8 shadow-lg shadow-orange-500/40 border-4 border-white">
                        <i class="fa-solid fa-house text-2xl"></i>
                    </a>
                    <!-- Tombol Cek Kartu -->
                    <button onclick="handleProtectedAction('#')"
                        class="flex flex-col items-center space-y-1 text-gray-400 hover:text-orange-500 transition">
                        <i class="fa-solid fa-id-card-clip text-xl"></i>
                        <span class="text-[10px] font-bold">Cek Anggota</span>
                    </button>
                    <!-- Tombol Profil -->
                    <button onclick="handleProtectedAction('{{ route('profile.show') }}')"
                        class="flex flex-col items-center space-y-1 text-gray-400 hover:text-orange-500 transition">
                        <i class="fa-solid fa-user text-xl"></i>
                        <span class="text-[10px] font-bold">Profil</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- ================= MODAL "ANDA HARUS LOGIN" ================= -->
    <div id="loginRequiredModal"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-300 p-4">
        <div id="loginModalContent"
            class="bg-white w-full max-w-sm rounded-[32px] p-6 shadow-2xl text-center transform scale-95 transition-all duration-300">
            <div
                class="w-16 h-16 bg-orange-100 text-orange-500 rounded-2xl flex items-center justify-center mx-auto mb-4 text-2xl shadow-inner">
                <i class="fa-solid fa-lock"></i>
            </div>
            <h3 class="text-lg font-black text-gray-900 mb-1">Autentikasi Diperlukan</h3>
            <p class="text-xs text-gray-500 mb-6 leading-relaxed">
                Anda harus login terlebih dahulu untuk mengakses layanan dan fitur eksklusif IMI Mobilitas.
            </p>
            <div class="space-y-2.5">
                <a href="{{ route('login') }}"
                    class="w-full py-3.5 bg-orange-500 hover:bg-orange-600 text-white font-bold text-xs uppercase tracking-wider rounded-2xl shadow-lg shadow-orange-500/20 transition block text-center">
                    Masuk / Login
                </a>
                <button onclick="closeLoginModal()"
                    class="w-full py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold text-xs uppercase tracking-wider rounded-2xl transition">
                    Nanti Saja
                </button>
            </div>
        </div>
    </div>

    <!-- Script JavaScript untuk Pengecekan Status Login & Modal Interaksi -->
    <script>
        // Variabel Status Login dari Backend Laravel (Blade)
        const isAuthenticated = @json(Auth::check());
        const loginUrl = "{{ route('login') }}";

        function showNotificationModal() {
            alert('Fitur notifikasi akan segera hadir!');
        }

        function showServiceMessage(serviceName) {
            alert('Anda mengklik layanan: ' + serviceName + '. Fitur ini akan segera hadir.');
        }

        function handleProtectedAction(targetUrl) {
            if (!isAuthenticated) {
                // Jika belum login, tampilkan modal peringatan
                openLoginModal();
            } else {
                // Jika sudah login, lanjutkan ke halaman tujuan
                window.location.href = targetUrl;
            }
        }

        function openLoginModal() {
            const modal = document.getElementById('loginRequiredModal');
            const content = document.getElementById('loginModalContent');

            modal.classList.remove('opacity-0', 'pointer-events-none');
            content.classList.remove('scale-95');
            content.classList.add('scale-100');
        }

        function closeLoginModal() {
            const modal = document.getElementById('loginRequiredModal');
            const content = document.getElementById('loginModalContent');

            modal.classList.add('opacity-0', 'pointer-events-none');
            content.classList.remove('scale-100');
            content.classList.add('scale-95');
        }

        // Tutup modal jika mengklik area luar kontainer modal
        window.addEventListener('click', function(e) {
            const modal = document.getElementById('loginRequiredModal');
            if (e.target === modal) {
                closeLoginModal();
            }
        });
    </script>
</body>

</html>
