@extends('layouts.app')

@section('content')
    <div class="space-y-6">
       
        @if (isset($isRegistered) && $isRegistered)
        @else
        @endif

        {{-- Anggota --}}
        <div class="px-5" id="member-card">
            @if (isset($isRegistered) && $isRegistered)
                <!-- Tampilan JIKA SUDAH TERDAFTAR -->
                <div
                    class="relative rounded-[2rem] p-5 bg-slate-900 border border-slate-800 shadow-2xl overflow-hidden text-white max-w-lg mx-auto">

                    {{-- Aksen Glow --}}
                    <div
                        class="absolute -top-12 -right-12 w-40 h-40 bg-orange-500/10 rounded-full blur-3xl pointer-events-none">
                    </div>

                    {{-- Bagian Atas --}}
                    <div class="flex items-center gap-3 mb-4 relative z-10">
                        <div
                            class="w-12 h-12 rounded-xl bg-gradient-to-tr from-orange-500 to-amber-500 flex items-center justify-center text-white font-black text-lg shrink-0 border border-white/10 shadow-lg overflow-hidden">
                            @if (isset($foto_anggota) && $foto_anggota)
                                <img src="{{ asset('storage/' . $foto_anggota) }}" alt="Foto"
                                    class="w-full h-full object-cover">
                            @else
                                <i class="fa-solid fa-user text-lg"></i>
                            @endif
                        </div>
                        <div class="leading-tight">
                            <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wide">Halo !</span>
                            <h3 class="font-black text-white text-sm uppercase tracking-tight truncate">
                                {{ $nama_anggota ?? 'JUNAEDI HASYIM, SH, MH.' }}
                            </h3>
                        </div>
                    </div>

                    {{-- Bagian Kotak Bawah (Compact) --}}
                    <div
                        class="bg-white/[0.03] border border-white/5 rounded-2xl p-4 relative z-10 flex items-center justify-between shadow-inner">

                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-1.5">
                                <span class="text-[9px] text-slate-400 font-bold uppercase tracking-wider">Masa
                                    Berlaku</span>
                                {{-- Status di samping Masa Berlaku --}}
                                <span
                                    class="px-2 py-0.5 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 font-bold text-[9px] uppercase rounded-full">
                                    {{ $status_anggota ?? 'Aktif' }}
                                </span>
                            </div>
                            <div class="font-mono font-bold text-amber-400 text-sm tracking-wider">
                                {{ $no_ktpa ?? '7371 2094 0000 3127' }}
                            </div>
                        </div>

                        {{-- Preview Kartu Mini --}}
                        <div
                            class="w-16 h-10 rounded-lg bg-gradient-to-br from-slate-800 to-slate-950 border border-slate-700 p-1 flex flex-col justify-between shrink-0 ml-3">
                            <div class="flex justify-between items-start">
                                <span class="text-[6px] text-slate-500 font-bold uppercase">ID</span>
                                <div class="w-1 h-1 rounded-full bg-orange-500"></div>
                            </div>
                            <div class="w-4 h-2 bg-amber-400/20 rounded-[1px] ml-auto"></div>
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
                            <h4 class="font-extrabold text-white text-lg tracking-tight">Pendaftaran Anggota
                            </h4>
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

        <div class="px-5 mb-6">
            <h3 class="text-base font-bold text-gray-900 mb-4">Layanan Lainnya</h3>
            <div class="grid grid-cols-4 gap-3 sm:gap-4">
                <a href="{{ route('user-pelatihan.index') }}" class="flex flex-col items-center cursor-pointer group">
                    <div
                        class="w-14 h-14 sm:w-16 sm:h-16 rounded-2xl bg-orange-100/70 border border-orange-200 flex items-center justify-center text-orange-500 shadow-sm group-hover:scale-105 transition">
                        <i class="fa-solid fa-graduation-cap text-xl sm:text-2xl"></i>
                    </div>
                    <span class="text-[11px] sm:text-xs font-semibold text-gray-700 mt-2 text-center">Pelatihan</span>
                </a>
                <a href="{{ route('sertifikat.index') }}" class="flex flex-col items-center cursor-pointer group">
                    <div
                        class="w-14 h-14 sm:w-16 sm:h-16 rounded-2xl bg-orange-100/70 border border-orange-200 flex items-center justify-center text-orange-500 shadow-sm group-hover:scale-105 transition">
                        <i class="fa-solid fa-award text-xl sm:text-2xl"></i>
                    </div>
                    <span class="text-[11px] sm:text-xs font-semibold text-gray-700 mt-2 text-center">Sertifikat</span>
                </a>
                <a href="#" class="flex flex-col items-center cursor-pointer group">
                    <div
                        class="w-14 h-14 sm:w-16 sm:h-16 rounded-2xl bg-orange-100/70 border border-orange-200 flex items-center justify-center text-orange-500 shadow-sm group-hover:scale-105 transition">
                        <i class="fa-solid fa-newspaper text-xl sm:text-2xl"></i>
                    </div>
                    <span class="text-[11px] sm:text-xs font-semibold text-gray-700 mt-2 text-center">Artikel</span>
                </a>
                {{-- E-Organisasi --}}
                <div onclick="showServiceMessage('E-Organisasi')" class="flex flex-col items-center cursor-pointer group">
                    <div
                        class="w-14 h-14 sm:w-16 sm:h-16 rounded-2xl bg-orange-100/70 border border-orange-200 flex items-center justify-center text-orange-500 shadow-sm group-hover:scale-105 transition">
                        <i class="fa-solid fa-sitemap text-xl sm:text-2xl"></i>
                    </div>
                    <span class="text-[11px] sm:text-xs font-semibold text-gray-700 mt-2 text-center">E-Organisasi</span>
                </div>

                {{-- Struktur --}}
                <div onclick="showServiceMessage('Struktur')" class="flex flex-col items-center cursor-pointer group">
                    <div
                        class="w-14 h-14 sm:w-16 sm:h-16 rounded-2xl bg-orange-100/70 border border-orange-200 flex items-center justify-center text-orange-500 shadow-sm group-hover:scale-105 transition">
                        <i class="fa-solid fa-users-rectangle text-xl sm:text-2xl"></i>
                    </div>
                    <span class="text-[11px] sm:text-xs font-semibold text-gray-700 mt-2 text-center">Struktur</span>
                </div>

                {{-- Marchaindise --}}
                <div onclick="showServiceMessage('Marchaindise')" class="flex flex-col items-center cursor-pointer group">
                    <div
                        class="w-14 h-14 sm:w-16 sm:h-16 rounded-2xl bg-orange-100/70 border border-orange-200 flex items-center justify-center text-orange-500 shadow-sm group-hover:scale-105 transition">
                        <i class="fa-solid fa-shirt text-xl sm:text-2xl"></i>
                    </div>
                    <span class="text-[11px] sm:text-xs font-semibold text-gray-700 mt-2 text-center">Marchaindise</span>
                </div>

                {{-- E-Recruitment --}}
                <div onclick="showServiceMessage('E-Recruitment')"
                    class="flex flex-col items-center cursor-pointer group">
                    <div
                        class="w-14 h-14 sm:w-16 sm:h-16 rounded-2xl bg-orange-100/70 border border-orange-200 flex items-center justify-center text-orange-500 shadow-sm group-hover:scale-105 transition">
                        <i class="fa-solid fa-user-plus text-xl sm:text-2xl"></i>
                    </div>
                    <span class="text-[11px] sm:text-xs font-semibold text-gray-700 mt-2 text-center">Referral</span>
                </div>
                <div onclick="showServiceMessage('Semua Menu')" class="flex flex-col items-center cursor-pointer group">
                    <div
                        class="w-14 h-14 sm:w-16 sm:h-16 rounded-2xl bg-orange-500 border border-orange-600 flex items-center justify-center text-white shadow-md group-hover:scale-105 transition">
                        <i class="fa-solid fa-grip text-xl sm:text-2xl"></i>
                    </div>
                    <span class="text-[11px] sm:text-xs font-semibold text-gray-700 mt-2 text-center">Lainnya</span>
                </div>
            </div>
        </div>

         {{-- PELATIHAN --}}
        <div class="mt-4">
            <div id="cardSlider"
                class="flex overflow-x-auto space-x-4 px-5 no-scrollbar scroll-smooth snap-x snap-mandatory">
                @forelse ($pelatihans as $pelatihan)
                    <!-- Card Pelatihan Dinamis -->
                    <div
                        class="snap-start min-w-[280px] w-[82%] sm:w-[300px] flex-shrink-0 bg-gradient-to-br from-cyan-400 to-blue-600 rounded-3xl p-5 text-white shadow-lg relative overflow-hidden flex flex-col justify-between h-[190px]    ">
                        <div class="absolute -right-8 -bottom-8 w-32 h-32 bg-white/5 rounded-full pointer-events-none">
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
                    <div class="absolute -right-8 -bottom-8 w-32 h-32 bg-orange-500/5 rounded-full pointer-events-none">
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
                <div class="absolute bottom-3 left-0 right-0 flex justify-center space-x-1.5 z-20 pointer-events-none">
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
@endsection
