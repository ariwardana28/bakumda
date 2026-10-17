<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="light">
    <title>@yield('title', 'BAKUMDA - Bantuan Hukum Daerah')</title>
    <!-- Tailwind CSS CDN -->
    <script>
        window.tailwind = window.tailwind || {};
        window.tailwind.config = { darkMode: 'class' };
    </script>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Alpine.js CDN -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        :root {
            color-scheme: only light;
        }

        [x-cloak] {
            display: none !important;
        }

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
    @php
        $cartItems = auth()->user()?->keranjang?->items()->with('produk')->get() ?? collect();
    @endphp
    <!-- ================================================= -->
    <!-- VIEW 1: TAMPILAN ANDROID / MOBILE                 -->
    <!-- ================================================= -->
    <div id="view-android-container" class="w-full 2xl:hidden flex-1 flex flex-col relative bg-slate-900">

        <!-- Header Tetap (Sticky) -->
        <header
            class="sticky top-0 left-0 right-0 z-40 px-6 sm:px-12 pt-8 pb-4 bg-slate-900/80 backdrop-blur-md border-b border-black shadow-[0_4px_25px_-2px_rgba(0,0,0,0.8)]">
            <div class="flex items-center justify-between relative z-10">
                <div class="flex items-center space-x-2.5">
                    <img src="{{ asset('log.png') }}" alt="Logo" class="h-10 sm:h-12 w-auto object-contain">
                </div>
                <div class="flex items-center space-x-3">
                    {{-- <div
                        class="flex items-center bg-white/10 backdrop-blur-md border border-white/10 rounded-full px-3.5 py-1.5 shadow-inner">
                        <i class="fa-solid fa-magnifying-glass text-xs text-blue-200 mr-2"></i>
                        <span class="text-xs text-blue-100 font-medium tracking-wide">Pencarian...</span>
                    </div> --}}
                    <div class="relative" x-data="{ cartOpen: false }" @click.away="cartOpen = false">
                        <button type="button" @click="cartOpen = !cartOpen"
                            class="w-9 h-9 rounded-full border flex items-center justify-center transition {{ request()->routeIs('user-pelatihan.show') || request()->routeIs('user-pelatihan.index') ? 'bg-slate-100 border-slate-300 text-slate-700 hover:bg-slate-200' : 'bg-[#0a1226]/90 border-blue-950/60 text-blue-200 hover:text-white' }}"
                            title="Keranjang">
                            <i class="fa-solid fa-cart-shopping text-sm"></i>
                            @if ($cartItems->sum('jumlah') > 0)
                                <span
                                    class="absolute -right-1 -top-1 flex h-4 min-w-4 items-center justify-center rounded-full bg-orange-500 px-1 text-[9px] font-black text-white shadow">{{ $cartItems->sum('jumlah') > 99 ? '99+' : $cartItems->sum('jumlah') }}</span>
                            @endif
                        </button>
                        @include('layouts.partials.cart-dropdown')
                    </div>
                    {{-- Tombol Notifikasi / Lonceng --}}
                    <div class="relative" x-data="{ notifOpen: false }" @click.away="notifOpen = false">
                        <button @click="notifOpen = !notifOpen"
                            class="w-9 h-9 rounded-full border flex items-center justify-center transition {{ request()->routeIs('user-pelatihan.show') || request()->routeIs('user-pelatihan.index') ? 'bg-slate-100 border-slate-300 text-slate-700 hover:bg-slate-200' : 'bg-[#0a1226]/90 border-blue-950/60 text-blue-200 hover:text-white' }}">
                            <i class="fa-regular fa-bell text-sm"></i>
                        </button>

                        @php
                            $notifCollection = $notifications ?? collect();
                            $unreadCount = $unreadNotificationsCount ?? $notifCollection->whereNull('read_at')->count();
                        @endphp

                        @if ($unreadCount > 0)
                            <span
                                class="absolute -top-0.5 -right-0.5 w-4 h-4 bg-amber-500 text-slate-950 font-extrabold text-[9px] flex items-center justify-center rounded-full shadow">
                                {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                            </span>
                        @endif

                        {{-- Dropdown Notifikasi --}}
                        <div x-show="notifOpen" x-transition:enter="ease-out duration-150"
                            x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
                            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                            x-transition:leave="ease-in duration-100" x-transition:leave-start="opacity-100 scale-100"
                            x-transition:leave-end="opacity-0 scale-95"
                            class="absolute right-0 mt-3 w-80 sm:w-96 bg-white rounded-2xl shadow-2xl border border-slate-200 overflow-hidden z-50"
                            style="display: none;">

                            {{-- Header Dropdown --}}
                            <div class="flex items-center justify-between px-4 py-3 border-b border-slate-100">
                                <h4 class="text-sm font-bold text-slate-900">Notifikasi</h4>
                                @if ($unreadCount > 0)
                                    <form action="{{ route('notifications.readAll') }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="text-[11px] font-semibold text-blue-600 hover:text-blue-700 transition">
                                            Tandai semua dibaca
                                        </button>
                                    </form>
                                @endif
                            </div>

                            {{-- List Notifikasi --}}
                            <div class="max-h-80 overflow-y-auto divide-y divide-slate-100">
                                @forelse ($notifCollection as $notif)
                                    <a href="{{ route('notifications.read', $notif->id) }}"
                                        class="flex items-start gap-3 px-4 py-3 hover:bg-slate-50 transition {{ is_null($notif->read_at) ? 'bg-blue-50/50' : '' }}">

                                        {{-- Icon sesuai tipe notifikasi --}}
                                        <div
                                            class="w-8 h-8 rounded-full flex items-center justify-center shrink-0
                                            {{ $notif->type === 'success'
                                                ? 'bg-emerald-100 text-emerald-600'
                                                : ($notif->type === 'error'
                                                    ? 'bg-red-100 text-red-600'
                                                    : ($notif->type === 'warning'
                                                        ? 'bg-amber-100 text-amber-600'
                                                        : 'bg-blue-100 text-blue-600')) }}">
                                            <i
                                                class="fa-solid
                                                {{ $notif->type === 'success'
                                                    ? 'fa-check'
                                                    : ($notif->type === 'error'
                                                        ? 'fa-triangle-exclamation'
                                                        : ($notif->type === 'warning'
                                                            ? 'fa-circle-exclamation'
                                                            : 'fa-bell')) }} text-xs"></i>
                                        </div>

                                        <div class="min-w-0 flex-1">
                                            <p class="text-xs font-bold text-slate-900 truncate">{{ $notif->title }}
                                            </p>
                                            <p class="text-[11px] text-slate-500 line-clamp-2 mt-0.5 leading-relaxed">
                                                {{ $notif->message }}</p>
                                            <span
                                                class="text-[10px] text-slate-400 mt-1 block">{{ $notif->created_at->diffForHumans() }}</span>
                                        </div>

                                        @if (is_null($notif->read_at))
                                            <span class="w-2 h-2 rounded-full bg-blue-500 mt-1.5 shrink-0"></span>
                                        @endif
                                    </a>
                                @empty
                                    <div class="px-4 py-10 text-center text-slate-400">
                                        <i class="fa-regular fa-bell-slash text-2xl mb-2 block"></i>
                                        <p class="text-xs">Belum ada notifikasi.</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </header>

        <!-- Konten Utama yang Bisa di-scroll -->
        <main class="flex-1 overflow-y-auto px-6 sm:px-12 pt-6 pb-28">


            <!-- ========================================== -->
            <!-- HERO BANNER & KTA / PENDAFTARAN            -->
            <!-- ========================================== -->
            <div class="grid grid-cols-1 gap-3 md:gap-6 mb-4 md:mb-8 relative z-7">

                <div id="banner-slider-container"
                    class="relative w-full overflow-hidden rounded-3xl shadow-xl border border-slate-800 mb-1 md:mb-4 z-10">

                    <div class="heroSlider flex transition-transform duration-700 ease-out w-full">
                        @forelse ($banners as $banner)
                            <div class="slide-item min-w-full w-full shrink-0 relative overflow-hidden">
                                @if ($banner->tautan)
                                    <a href="{{ $banner->tautan }}" class="block">
                                        <img src="{{ Storage::url($banner->gambar) }}" alt="{{ $banner->judul ?? 'Banner BAKUMDA' }}"
                                            class="w-full h-auto object-contain">
                                    </a>
                                @else
                                    <img src="{{ Storage::url($banner->gambar) }}" alt="{{ $banner->judul ?? 'Banner BAKUMDA' }}"
                                        class="w-full h-auto object-contain">
                                @endif
                            </div>
                        @empty
                            <div class="slide-item min-w-full w-full shrink-0 relative overflow-hidden">
                                <img src="{{ asset('b1.jpeg') }}" alt="Banner 1" class="w-full h-auto object-contain">
                            </div>
                            <div class="slide-item min-w-full w-full shrink-0 relative overflow-hidden">
                                <img src="{{ asset('b2.jpeg') }}" alt="Banner 2" class="w-full h-auto object-contain">
                            </div>
                            <div class="slide-item min-w-full w-full shrink-0 relative overflow-hidden">
                                <img src="{{ asset('b3.jpeg') }}" alt="Banner 3" class="w-full h-auto object-contain">
                            </div>
                            <div class="slide-item min-w-full w-full shrink-0 relative overflow-hidden">
                                <img src="{{ asset('b4.jpeg') }}" alt="Banner 4" class="w-full h-auto object-contain">
                            </div>
                        @endforelse
                    </div>

                    <div class="absolute bottom-3 right-4 z-30 flex space-x-1.5" id="slider-dots">
                        @if ($banners->isNotEmpty())
                            @foreach ($banners as $index => $banner)
                                <button class="dot h-2 {{ $index === 0 ? 'w-5 bg-white' : 'w-2 bg-white/50' }} rounded-full transition-all duration-300"
                                    data-index="{{ $index }}" aria-label="Banner {{ $index + 1 }}"></button>
                            @endforeach
                        @else
                            @foreach (range(0, 3) as $index)
                                <button class="dot h-2 {{ $index === 0 ? 'w-5 bg-white' : 'w-2 bg-white/50' }} rounded-full transition-all duration-300"
                                    data-index="{{ $index }}" aria-label="Banner {{ $index + 1 }}"></button>
                            @endforeach
                        @endif
                    </div>
                </div>

                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        const container = document.getElementById("banner-slider-container");
                        if (!container) return;

                        const slider = container.querySelector(".heroSlider");
                        const slides = container.querySelectorAll(".slide-item");
                        const dots = container.querySelectorAll("#slider-dots .dot");

                        if (slides.length === 0) return;

                        const totalSlides = slides.length;
                        let currentIndex = 0;
                        const intervalTime = 4000; // Durasi per slide (4 detik)
                        let isTransitioning = false;

                        // Clone slide 1 untuk dimasukkan ke ujung akhir (efek infinite loop)
                        const firstSlideClone = slides[0].cloneNode(true);
                        slider.appendChild(firstSlideClone);

                        function updateDots(activeIdx) {
                            const normalizedIndex = activeIdx % totalSlides;
                            dots.forEach((dot, index) => {
                                if (index === normalizedIndex) {
                                    dot.classList.remove("w-2", "bg-white/50");
                                    dot.classList.add("w-5", "bg-white");
                                } else {
                                    dot.classList.remove("w-5", "bg-white");
                                    dot.classList.add("w-2", "bg-white/50");
                                }
                            });
                        }

                        function goToSlide(index, animated = true) {
                            if (animated) {
                                slider.style.transition = "transform 700ms ease-out";
                            } else {
                                slider.style.transition = "none";
                            }
                            slider.style.transform = `translateX(-${index * 100}%)`;
                            updateDots(index);
                        }

                        function nextSlide() {
                            if (isTransitioning) return;
                            currentIndex++;
                            isTransitioning = true;
                            goToSlide(currentIndex, true);
                        }

                        // Handler saat transisi slide selesai
                        slider.addEventListener("transitionend", function() {
                            isTransitioning = false;
                            // Jika sudah sampai di slide clone (ujung akhir)
                            if (currentIndex === totalSlides) {
                                currentIndex = 0;
                                goToSlide(0, false); // Berpindah ke slide 0 secara instan tanpa efek rewind
                            }
                        });

                        let slideInterval = setInterval(nextSlide, intervalTime);

                        // Handler klik pada indikator dots
                        dots.forEach((dot) => {
                            dot.addEventListener("click", function() {
                                if (isTransitioning) return;
                                currentIndex = parseInt(this.getAttribute("data-index"));
                                goToSlide(currentIndex, true);

                                // Reset timer saat di-klik manual
                                clearInterval(slideInterval);
                                slideInterval = setInterval(nextSlide, intervalTime);
                            });
                        });

                        // Berhentikan slider sejenak saat kursor hover di atas banner
                        container.addEventListener("mouseenter", () => clearInterval(slideInterval));
                        container.addEventListener("mouseleave", () => {
                            clearInterval(slideInterval);
                            slideInterval = setInterval(nextSlide, intervalTime);
                        });
                    });
                </script>

                <!-- KTA / Pendaftaran Anggota (Modern & Responsif) -->
                @if (isset($isRegistered) && $isRegistered)
                    <div class="relative group mt-1 md:mt-0">
                        <div
                            class="absolute -inset-1 bg-gradient-to-r from-blue-900 to-indigo-950 rounded-2xl md:rounded-3xl blur opacity-25 group-hover:opacity-40 transition duration-500">
                        </div>

                        <div
                            class="relative bg-gradient-to-br from-blue-900 to-indigo-950 border border-blue-800/60 rounded-2xl md:rounded-3xl p-4 md:p-6 shadow-2xl flex items-center justify-between overflow-hidden">
                            <div
                                class="absolute top-0 right-0 -mt-4 -mr-4 w-32 h-32 bg-blue-500/10 rounded-full blur-2xl pointer-events-none">
                            </div>

                            <!-- Informasi Anggota -->
                            <div class="space-y-1.5 md:space-y-2 z-10">
                                <div class="flex items-center space-x-2 mb-1">

                                    <span
                                        class="text-[10px] md:text-xs font-bold text-amber-300 uppercase tracking-wider">
                                        Anda Telah Terdaftar
                                    </span>
                                </div>
                                <div
                                    class="font-mono font-black text-white text-sm md:text-xl tracking-widest drop-shadow">

                                    {{ $nama_anggota ?? 'DR. H. ARIS M.' }}
                                </div>
                                <p
                                    class="text-xs md:text-sm text-blue-200/80 font-extrabold uppercase tracking-wide mt-1">

                                    {{ $no_ktpa ?? '7371 2094 0000 3127' }}
                                </p>
                            </div>

                            <!-- Chip Kartu Digital -->
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
                    </div>
                @else
                    <!-- Tampilan Pendaftaran Anggota Baru -->
                    <div
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
                                <p class="text-[8px] md:text-xs text-blue-200/80 font-medium mt-1">
                                    Proses Cepat & Mudah.
                                </p>
                            </div>
                            <!-- Kartu mini/chip di sebelah kanan -->
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
                              <div class="flex items-start gap-2 max-w-sm">
                                <svg class="w-4 h-4 text-blue-400 shrink-0 mt-0.5" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <p class="text-[11px] md:text-xs text-slate-300 leading-relaxed">
                                    Pastikan Anda telah memiliki <span class="text-amber-400 font-semibold">Sertifikat
                                        DIKLATKUM</span> sebagai syarat utama keanggotaan.
                                </p>
                            </div>

                            <!-- Bungkus tombol berdampingan -->
                            <div class="flex items-center gap-2 shrink-0">
                                <!-- Tombol Ikuti DIKLATKUM -->
                                <a href="{{ route('user-pelatihan.index') }}"
                                    class="menu-item-auth bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white font-bold text-xs px-4 py-2 rounded-full shadow transition cursor-pointer inline-flex items-center justify-center">
                                    IKUTI DIKLATKUM
                                </a>

                                <!-- Tombol Daftar Keanggotaan (Diubah menjadi tag <a> yang valid) -->
                                <a href="{{ route('user-anggota.index') }}"
                                    class="menu-item-auth bg-gradient-to-r from-yellow-400 to-orange-500 hover:from-yellow-300 hover:to-orange-400 text-white font-bold text-xs px-4 py-2 rounded-full shadow transition cursor-pointer inline-flex items-center justify-center">
                                    DAFTAR KEANGGOTAAN
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <br>

            <div x-data="{ showAuthModal: false }"
                class="bg-white text-slate-900 rounded-t-[2.5rem] rounded-b-[2.5rem] -mt-4 pt-10 px-6 sm:px-12 shadow-2xl relative z-20 flex-1 space-y-8 pb-12">

                <!-- Modal Peringatan Akses -->
                <div x-show="showAuthModal" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                    x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    class="fixed inset-0 bg-black bg-opacity-60 z-[99] flex items-center justify-center p-4" x-cloak>
                    <div @click.away="showAuthModal = false" x-show="showAuthModal"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90"
                        class="bg-white rounded-2xl shadow-xl w-full max-w-md mx-auto p-6 text-center relative">

                        <!-- Tombol X di Kanan Atas -->
                        <button @click="showAuthModal = false"
                            class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 transition">
                            <i class="fa-solid fa-xmark text-lg"></i>
                        </button>

                        <div class="mx-auto w-16 h-16 rounded-full bg-red-100 flex items-center justify-center mb-4">
                            <i class="fa-solid fa-lock text-red-500 text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-slate-800">Akses Terbatas</h3>
                        <p class="text-slate-500 mt-2 mb-6">
                            Fitur ini hanya tersedia untuk anggota terverifikasi. Syarat menjadi anggota wajib mengikuti
                            <strong>DIKLATKUM</strong> terlebih dahulu. Silakan ikuti pelatihan atau daftar menjadi
                            anggota untuk menikmati semua fitur eksklusif.
                        </p>
                        <div class="flex flex-col sm:flex-row gap-3 justify-center">
                            <a href="{{ route('user-pelatihan.index') }}"
                                class="w-full bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold py-3 px-5 rounded-xl transition text-center flex items-center justify-center">
                                Ikuti DIKLATKUM
                            </a>
                            <a href="{{ route('user-anggota.index') }}"
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-5 rounded-xl shadow-lg shadow-blue-200 transition text-center flex items-center justify-center">
                                Daftar Anggota
                            </a>
                        </div>
                    </div>
                </div>

                <!-- ========================================== -->
                <!-- MENU UTAMA (KONDISI MOBILE vs DESKTOP)    -->
                <!-- ========================================== -->
                <div>
                    @php
                        $isMember = isset($isRegistered) && $isRegistered;
                        $authAction = $isMember ? '' : 'href="#" @click.prevent="showAuthModal = true"';
                    @endphp

                    <!-- Grid Menu: 4 Kolom untuk Mobile (<= 13 Inch), 8 Kolom untuk Desktop (> 13 Inch) -->
                    <h3 class="text-lg font-extrabold text-slate-900 leading-tight">Fitur Eksklusif</h3><br>
                    <div class="grid grid-cols-4 min-[1281px]:grid-cols-8 gap-y-6 gap-x-4">

                        <!-- Menu 1 (Mobile: Pelatihan, Desktop: Konsultasi) -->
                        <a href="{{ route('user-pelatihan.index') }}"
                            class="flex flex-col items-center cursor-pointer group">
                            <div
                                class="w-16 h-16 md:w-18 md:h-18 rounded-2xl bg-gradient-to-tr from-blue-700 to-indigo-600 flex items-center justify-center text-white shadow-md shadow-blue-500/20 group-hover:scale-105 transition">
                                <!-- Icon Mobile (<= 13 Inch) -->
                                <i
                                    class="fa-solid fa-graduation-cap max-[1280px]:block min-[1281px]:hidden text-2xl"></i>
                                <!-- Icon Desktop (> 13 Inch) -->
                                <i
                                    class="fa-solid fa-graduation-cap hidden max-[1280px]:hidden min-[1281px]:block text-xl"></i>
                            </div>
                            <span
                                class="text-xs font-semibold text-slate-700 mt-2 text-center leading-tight">Pelatihan</span>
                        </a>

                         <!-- Menu 4 (Mobile: Inspirator, Desktop: Paralegal) -->
                        <a {!! $isMember ? 'href="' . route('user-referral.index') . '"' : $authAction !!}
                            class="menu-item-auth flex flex-col items-center cursor-pointer group">
                            <div
                                class="w-16 h-16 md:w-18 md:h-18 rounded-2xl bg-gradient-to-tr from-blue-600 to-cyan-700 flex items-center justify-center text-white shadow-md shadow-blue-500/20 group-hover:scale-105 transition">
                                <i class="fa-solid fa-lightbulb max-[1280px]:block min-[1281px]:hidden text-2xl"></i>
                                <i
                                    class="fa-solid fa-lightbulb hidden max-[1280px]:hidden min-[1281px]:block text-xl"></i>
                            </div>
                            <span
                                class="text-xs font-semibold text-slate-700 mt-2 text-center leading-tight">Inspirator</span>
                        </a>

                        <!-- Menu 3 (Mobile: Legalku, Desktop: UU & Perda) -->
                        <a {!! $isMember ? 'href="' . url('/user-surat') . '"' : $authAction !!}
                            class="menu-item-auth flex flex-col items-center cursor-pointer group">
                            <div
                                class="w-16 h-16 md:w-18 md:h-18 rounded-2xl bg-gradient-to-tr from-slate-800 to-blue-900 flex items-center justify-center text-white shadow-md shadow-blue-500/20 group-hover:scale-105 transition">
                                <i
                                    class="fa-solid fa-scale-balanced max-[1280px]:block min-[1281px]:hidden text-2xl"></i>
                                <i
                                    class="fa-solid fa-scale-balanced hidden max-[1280px]:hidden min-[1281px]:block text-xl"></i>
                            </div>
                            <span
                                class="text-xs font-semibold text-slate-700 mt-2 text-center leading-tight">E-Dokumen</span>
                        </a>

                        <a href="{{ url('/ai-chat') }}" class="flex flex-col items-center cursor-pointer group">
                            <div
                                class="w-16 h-16 md:w-18 md:h-18 rounded-2xl bg-gradient-to-tr from-blue-600 to-cyan-700 flex items-center justify-center text-white shadow-md shadow-blue-500/20 group-hover:scale-105 transition">
                                <i class="fa-solid fa-robot max-[1280px]:block min-[1281px]:hidden text-2xl"></i>
                                <i class="fa-solid fa-robot hidden max-[1280px]:hidden min-[1281px]:block text-xl"></i>
                            </div>
                            <span class="text-xs font-semibold text-slate-700 mt-2 text-center leading-tight">Asisten
                                Legal</span>
                        </a>

                        <!-- Menu 5 (Mobile: Struktur, Desktop: Dokumen) -->
                        <a {!! $isMember ? 'href="' . route('korwil') . '"' : $authAction !!}
                            class="menu-item-auth flex flex-col items-center cursor-pointer group">
                            <div
                                class="w-16 h-16 md:w-18 md:h-18 rounded-2xl bg-gradient-to-tr from-amber-600 to-yellow-600 flex items-center justify-center text-white shadow-md shadow-amber-500/20 group-hover:scale-105 transition">
                                <i class="fa-solid fa-sitemap max-[1280px]:block min-[1281px]:hidden text-2xl"></i>
                                <i
                                    class="fa-solid fa-sitemap hidden max-[1280px]:hidden min-[1281px]:block text-xl"></i>
                            </div>
                            <span
                                class="text-xs font-semibold text-slate-700 mt-2 text-center leading-tight">Korwil</span>
                        </a>

                        <!-- Menu 6 (Mobile: E-Organisasi, Desktop: Mediator) -->
                        <a {!! $isMember ? 'href="' . url('/about') . '"' : $authAction !!}
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

                        <!-- Menu 2 (Mobile: Sertifikat, Desktop: Advokasi) -->
                        <a href="{{ route('artikel.index.public') }}"
                            class="flex flex-col items-center cursor-pointer group">
                            <div
                                class="w-16 h-16 md:w-18 md:h-18 rounded-2xl bg-gradient-to-tr from-blue-800 to-blue-600 flex items-center justify-center text-white shadow-md shadow-blue-500/20 group-hover:scale-105 transition">
                                <i class="fa-solid fa-newspaper max-[1280px]:block min-[1281px]:hidden text-2xl"></i>
                                <i
                                    class="fa-solid fa-newspaper hidden max-[1280px]:hidden min-[1281px]:block text-xl"></i>
                            </div>
                            <span
                                class="text-xs font-semibold text-slate-700 mt-2 text-center leading-tight">Artikel</span>
                        </a>

                        <!-- Menu 7 (Mobile: Merchandise, Desktop: Darurat) -->
                        <a {!! $isMember ? 'href="' . route('user-kerjasamas.index') . '"' : $authAction !!}
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
                 <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

                <div class="relative py-4 max-w-7xl mx-auto px-4">
                    <div class="mb-4">
                        <h3 class="text-lg font-extrabold text-slate-900 leading-tight">Program Pelatihan</h3>
                        <span class="text-xs text-slate-400 font-medium">Berjalan otomatis & berputar tanpa
                            henti</span>
                    </div>

                    <div class="swiper myPelatihanSwiper relative">
                        <div class="swiper-wrapper">
                            @foreach ($pelatihans as $index => $pelatihan)
                                @php
                                    $bgGradient = match ($index % 3) {
                                        0 => 'from-blue-800 to-indigo-900',
                                        1 => 'from-slate-800 to-blue-900',
                                        default => 'from-slate-900 to-slate-800',
                                    };
                                @endphp

                                <div class="swiper-slide">
                                    <a href="{{ route('user-pelatihan.show', $pelatihan) }}"
                                        class="block bg-gradient-to-br {{ $bgGradient }} rounded-2xl p-6 text-white shadow-md flex flex-col justify-between h-[180px] transition-transform duration-300 hover:scale-105">
                                        <div>
                                            <h4 class="font-black text-base tracking-wide line-clamp-1">
                                                {{ $pelatihan->judul }}</h4>
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
                                </div>
                            @endforeach
                        </div>

                        <div
                            class="swiper-button-next !w-9 !h-9 !bg-white/90 !text-slate-800 rounded-full shadow-md after:!text-xs">
                        </div>
                        <div
                            class="swiper-button-prev !w-9 !h-9 !bg-white/90 !text-slate-800 rounded-full shadow-md after:!text-xs">
                        </div>
                    </div>
                </div>

                <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        new Swiper(".myPelatihanSwiper", {
                            // Jumlah kartu yang tampil sesuai ukuran layar
                            slidesPerView: 1.2,
                            spaceBetween: 16,

                            // Loop tanpa batas (saat kartu terakhir lewat, lanjut ke kartu pertama tanpa melompat/mundur)
                            loop: true,

                            // Auto slide otomatis
                            autoplay: {
                                delay: 3000, // Durasi diam per kartu (3 detik)
                                disableOnInteraction: false, // Tetap auto-play meski disentuh/diklik
                                pauseOnMouseEnter: true, // Berhenti sejenak saat kursor di atas slider
                            },

                            // Kecepatan transisi pergeseran (mulus)
                            speed: 800,

                            // Tombol navigasi panah
                            navigation: {
                                nextEl: ".swiper-button-next",
                                prevEl: ".swiper-button-prev",
                            },

                            // Respon ukuran layar
                            breakpoints: {
                                640: {
                                    slidesPerView: 2.2,
                                    spaceBetween: 16,
                                },
                                1024: {
                                    slidesPerView: 3.2,
                                    spaceBetween: 20,
                                },
                                1280: {
                                    slidesPerView: 4,
                                    spaceBetween: 20,
                                }
                            }
                        });
                    });
                </script>


                <!-- Berita & Artikel Hukum -->
                <div class="space-y-4 pb-6">
                    <div class="flex items-center justify-between gap-4">
                        <h3 class="text-lg font-extrabold text-slate-900">Artikel & Informasi Terbaru</h3>
                        <a href="{{ route('artikel.index.public') }}"
                            class="inline-flex items-center gap-1.5 text-xs font-bold text-blue-600 hover:text-blue-700 transition-colors whitespace-nowrap">
                            <span>Lihat semua artikel</span>
                            <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </a>
                    </div>
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
            <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

            <!-- Script JavaScript untuk Slider Pelatihan -->
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    const slider = document.getElementById("pelatihan-slider");
                    const btnLeft = document.getElementById("slide-left-btn");
                    const btnRight = document.getElementById("slide-right-btn");
                    const container = document.getElementById("slider-container");

                    let autoSlideInterval;

                    function scrollNext() {
                        if (!slider) return;
                        if (slider.scrollLeft + slider.clientWidth >= slider.scrollWidth - 10) {
                            slider.scrollTo({
                                left: 0,
                                behavior: 'smooth'
                            });
                        } else {
                            slider.scrollBy({
                                left: 300,
                                behavior: 'smooth'
                            });
                        }
                    }

                    function scrollPrev() {
                        if (!slider) return;
                        slider.scrollBy({
                            left: -300,
                            behavior: 'smooth'
                        });
                    }

                    function startAutoplay() {
                        autoSlideInterval = setInterval(scrollNext, 3500);
                    }

                    function stopAutoplay() {
                        clearInterval(autoSlideInterval);
                    }

                    if (btnRight) btnRight.addEventListener("click", scrollNext);
                    if (btnLeft) btnLeft.addEventListener("click", scrollPrev);

                    if (container) {
                        container.addEventListener("mouseenter", stopAutoplay);
                        container.addEventListener("mouseleave", startAutoplay);
                    }

                    startAutoplay();
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
            <a href="{{ route('sertifikat.index') }}"
                class="flex flex-col items-center text-slate-400 hover:text-blue-700 py-1 transition">
                <div class="w-9 h-9 rounded-full flex items-center justify-center">
                    <i class="fa-solid fa-stamp text-base"></i>
                </div>
                <span class="text-[10px] font-medium mt-0.5">Sertifikat</span>
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
    <div id="view-desktop-container" x-data="{
        sidebarOpen: false,
        activeSlide: 0,
        totalSlides: 3,
        next() {
            this.activeSlide = (this.activeSlide + 1) % this.totalSlides;
        },
        prev() {
            this.activeSlide = (this.activeSlide - 1 + this.totalSlides) % this.totalSlides;
        }
    }"
        class="hidden 2xl:flex flex-1 flex-row h-screen overflow-hidden">

        <!-- Sidebar Navigation (Kiri) - Tampilan Admin -->
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
                        <p class="text-[10px] text-amber-400 font-medium">Admin Control Panel</p>
                    </div>
                </div>

                <!-- Navigation Links (Admin Menu) -->
                <nav class="p-3 space-y-1.5 overflow-y-auto max-h-[calc(100vh-280px)]">
                    <a href="{{ url('/') }}"
                        class="flex items-center space-x-3 px-3.5 py-2.5 rounded-xl bg-blue-600 text-white font-bold text-sm shadow-md shadow-blue-600/20">
                        <i class="fa-solid fa-house w-5 text-center shrink-0 text-base"></i>
                        <span x-show="sidebarOpen" x-transition.opacity class="truncate">Beranda</span>
                    </a>
                    <a href=""
                        class="flex items-center space-x-3 px-3.5 py-2.5 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800/60 font-medium text-sm transition">
                        <i class="fa-solid fa-newspaper w-5 text-center shrink-0 text-base"></i>
                        <span x-show="sidebarOpen" x-transition.opacity class="truncate">Artikel</span>
                    </a>
                    <a href="{{ route('kartu-anggota.cek.form') }}"
                        class="flex items-center space-x-3 px-3.5 py-2.5 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800/60 font-medium text-sm transition">
                        <i class="fa-solid fa-qrcode w-5 text-center shrink-0 text-base"></i>
                        <span x-show="sidebarOpen" x-transition.opacity class="truncate">Scan</span>
                    </a>
                    <a href="{{ route('user-anggota.index') }}"
                        class="flex items-center space-x-3 px-3.5 py-2.5 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800/60 font-medium text-sm transition">
                        <i class="fa-solid fa-id-card w-5 text-center shrink-0 text-base"></i>
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
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
                <div class="px-3 pb-3">
                    <a href="#"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                        class="flex items-center space-x-3 px-3.5 py-2 rounded-xl text-red-400 hover:bg-red-500/10 font-medium text-sm transition">
                        <i class="fa-solid fa-right-from-bracket w-5 text-center shrink-0 text-base"></i>
                        <span x-show="sidebarOpen" x-transition.opacity class="truncate">Logout</span>
                    </a>
                </div>
                <div class="p-4 flex items-center space-x-3 overflow-hidden border-t border-slate-800/60">
                    <div
                        class="w-9 h-9 rounded-full bg-blue-600/20 border border-blue-500/30 flex items-center justify-center text-blue-400 font-bold text-xs shrink-0">
                        AD</div>
                    <div x-show="sidebarOpen" x-transition.opacity class="overflow-hidden truncate">
                        <h4 class="text-xs font-bold text-white truncate">{{ Auth::user()->name }}</h4>
                        <p class="text-[10px] text-amber-400 truncate">Anggota</p>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Desktop Content Area (Dashboard Admin) -->
        <div class="flex-1 flex flex-col min-w-0 h-screen overflow-y-auto bg-slate-950">
            <!-- Top Bar Admin -->
            <header
                class="bg-slate-900/80 backdrop-blur-md border-b border-slate-800 px-6 py-4 flex items-center justify-between sticky top-0 z-20">
                <div class="flex items-center space-x-4">
                    <button @click="sidebarOpen = !sidebarOpen"
                        class="w-10 h-10 rounded-full bg-slate-800 border border-slate-700 flex items-center justify-center text-slate-300 hover:text-white transition shadow-sm focus:outline-none">
                        <i class="fa-solid fa-bars text-sm"></i>
                    </button>
                    <div>
                        <h2 class="text-sm font-extrabold text-white">Dashboard Overview</h2>
                        <p class="text-[11px] text-slate-400">Selamat datang kembali, Administrator.</p>
                    </div>
                </div>
                <div class="items-center space-x-4 hidden sm:flex">
                    <div class="relative w-72">
                        <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-3 text-xs text-slate-400"></i>
                        <input type="text" placeholder="Cari data anggota, nomor KTA..."
                            class="w-full bg-slate-800 border border-slate-700 text-xs text-white rounded-full pl-10 pr-4 py-2.5 focus:outline-none focus:border-blue-500 transition">
                    </div>
                    <div class="relative">
                        <button
                            class="w-10 h-10 rounded-full bg-slate-800 border border-slate-700 flex items-center justify-center text-slate-300 hover:text-white transition">
                            <i class="fa-regular fa-bell text-sm"></i>
                        </button>
                        <span
                            class="absolute top-1 right-1 w-4 h-4 bg-amber-500 text-slate-950 font-extrabold text-[9px] flex items-center justify-center rounded-full shadow">3</span>
                    </div>
                </div>
            </header>

            <!-- Admin Content Slot -->
            <div class="flex-1 p-6 md:p-8 space-y-6">

                <!-- 🌟 TAMBAHAN: Banner Informasi / Pengumuman -->
                <div
                    class="relative bg-gradient-to-r from-blue-900 via-indigo-900 to-slate-900 border border-blue-800/50 rounded-3xl p-6 md:p-8 shadow-2xl overflow-hidden flex flex-col md:flex-row items-center justify-between gap-6">
                    <div
                        class="absolute -right-10 -bottom-10 w-64 h-64 bg-blue-500/10 rounded-full blur-3xl pointer-events-none">
                    </div>
                    <div class="space-y-2 z-10 text-left">
                        <span
                            class="bg-amber-500/20 border border-amber-500/30 text-amber-400 text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-wider">Pengumuman
                            Terbaru</span>
                        <h3 class="text-xl md:text-2xl font-black text-white leading-tight">Pembaruan Sistem Kartu
                            Anggota & Pelatihan</h3>
                        <p class="text-xs md:text-sm text-slate-300 max-w-2xl leading-relaxed">
                            Kelola penerbitan KTA digital serta jadwalkan modul pelatihan hukum terbaru untuk anggota
                            langsung dari panel kontrol ini.
                        </p>
                    </div>
                    <div class="z-10 flex shrink-0 gap-3">
                        <a href="{{ route('user-anggota.index') }}"
                            class="px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-500 text-white font-bold text-xs shadow-lg shadow-blue-600/30 transition flex items-center gap-2">
                            <i class="fa-solid fa-id-card"></i> Kelola Kartu
                        </a>
                        <a href="{{ route('user-pelatihan.index') }}"
                            class="px-5 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 border border-slate-700 text-white font-bold text-xs transition flex items-center gap-2">
                            <i class="fa-solid fa-graduation-cap"></i> Data Pelatihan
                        </a>
                    </div>
                </div>

                <!-- 🌟 TAMBAHAN: Card Pelatihan Berbentuk Slide (Carousel) -->
                <!-- 🌟 PROGRAM PELATIHAN (SLIDER / CAROUSEL DINAMIS) -->
                <div id="slider-container-pelatihan" class="relative mt-8" x-data="{
                    scrollContainer: null,
                    init() {
                        this.scrollContainer = document.getElementById('pelatihan-slider-track');
                    },
                    scrollLeft() {
                        if (this.scrollContainer) {
                            this.scrollContainer.scrollBy({ left: -340, behavior: 'smooth' });
                        }
                    },
                    scrollRight() {
                        if (this.scrollContainer) {
                            this.scrollContainer.scrollBy({ left: 340, behavior: 'smooth' });
                        }
                    }
                }">

                    <div class="flex justify-between items-center mb-4">
                        <div>
                            <h3 class="text-lg font-extrabold text-white leading-tight">Program Pelatihan</h3>
                            <p class="text-xs text-slate-400 font-medium">Geser atau gunakan tombol navigasi untuk
                                melihat pilihan pelatihan.</p>
                        </div>

                        <!-- Tombol Navigasi Manual -->
                        <div class="flex items-center space-x-2">
                            <button @click="scrollLeft()"
                                class="w-9 h-9 rounded-xl bg-slate-900 border border-slate-800 hover:bg-slate-800 text-slate-300 hover:text-white flex items-center justify-center transition shadow-sm focus:outline-none">
                                <i class="fa-solid fa-chevron-left text-xs"></i>
                            </button>
                            <button @click="scrollRight()"
                                class="w-9 h-9 rounded-xl bg-slate-900 border border-slate-800 hover:bg-slate-800 text-slate-300 hover:text-white flex items-center justify-center transition shadow-sm focus:outline-none">
                                <i class="fa-solid fa-chevron-right text-xs"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Slider Container Track -->
                    <div id="pelatihan-slider-track"
                        class="flex overflow-x-auto space-x-4 pb-4 -mx-2 px-2 snap-x snap-mandatory scroll-smooth"
                        style="scrollbar-width: none; -ms-overflow-style: none;">

                        <!-- CSS untuk menyembunyikan scrollbar bawaan browser -->
                        <style>
                            #pelatihan-slider-track::-webkit-scrollbar {
                                display: none;
                            }
                        </style>

                        @if (isset($pelatihans) && $pelatihans->count() > 0)
                            @foreach ($pelatihans as $index => $pelatihan)
                                @php
                                    $bgGradient = match ($index % 3) {
                                        0 => 'from-blue-900/80 via-indigo-950 to-slate-900 border-blue-800/40',
                                        1 => 'from-slate-900 via-blue-950 to-slate-950 border-slate-800',
                                        default => 'from-slate-900 via-slate-900 to-slate-950 border-slate-800',
                                    };
                                @endphp

                                <a href="{{ route('user-pelatihan.show', $pelatihan) }}"
                                    class="menu-item-auth snap-start shrink-0 w-[280px] sm:w-[320px] bg-gradient-to-br {{ $bgGradient }} border rounded-2xl p-5 text-white shadow-xl flex flex-col justify-between h-[190px] transition-all duration-300 hover:scale-[1.02] hover:border-blue-500/50">
                                    <div>
                                        <div class="flex items-center justify-between mb-2">
                                            <span
                                                class="bg-blue-500/10 text-blue-400 border border-blue-500/20 text-[10px] font-bold px-2 py-0.5 rounded-md">
                                                Tersedia
                                            </span>
                                            <span class="text-xs font-extrabold text-amber-400">
                                                Rp {{ number_format($pelatihan->harga, 0, ',', '.') }}
                                            </span>
                                        </div>
                                        <h4
                                            class="font-bold text-sm tracking-wide text-white line-clamp-2 leading-snug">
                                            {{ $pelatihan->judul }}</h4>
                                        <div class="mt-2 text-[11px] text-slate-300 space-y-0.5 font-medium">
                                            <p class="flex items-center gap-1.5">
                                                <i class="fa-regular fa-calendar text-slate-400"></i> Mulai:
                                                <span
                                                    class="text-white">{{ \Carbon\Carbon::parse($pelatihan->tanggal_mulai)->translatedFormat('d M Y') }}</span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="pt-3 border-t border-slate-800/80 flex items-center justify-between">
                                        <span class="text-[11px] text-slate-400 font-medium">Lihat detail modul</span>
                                        <span
                                            class="bg-blue-600 hover:bg-blue-500 text-white font-bold text-xs px-3 py-1.5 rounded-xl shadow transition">
                                            Detail <i class="fa-solid fa-arrow-right ml-1 text-[10px]"></i>
                                        </span>
                                    </div>
                                </a>
                            @endforeach
                        @else
                            <div
                                class="w-full text-center py-10 bg-slate-900/50 border border-slate-800 rounded-2xl text-slate-400 text-xs">
                                <i class="fa-solid fa-folder-open text-2xl mb-2 block text-slate-600"><span>
                                        Belum ada program pelatihan yang tersedia saat ini.
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Bagian Fitur Eksklusif -->
                <div class="bg-slate-900 border border-slate-800 rounded-3xl p-6 shadow-xl mb-8">
                    <h3 class="text-lg font-extrabold text-white leading-tight mb-4">Fitur Eksklusif</h3>
                    <div class="grid grid-cols-4 min-[1281px]:grid-cols-8 gap-y-6 gap-x-4">

                        <!-- Menu 1 (Pelatihan) -->
                        <a href="{{ route('user-pelatihan.index') }}"
                            class="flex flex-col items-center cursor-pointer group">
                            <div
                                class="w-14 h-14 md:w-16 md:h-16 rounded-2xl bg-gradient-to-tr from-blue-700 to-indigo-600 flex items-center justify-center text-white shadow-md shadow-blue-500/20 group-hover:scale-105 transition">
                                <i class="fa-solid fa-graduation-cap text-xl md:text-2xl"></i>
                            </div>
                            <span
                                class="text-xs font-semibold text-slate-300 mt-2 text-center leading-tight">Pelatihan</span>
                        </a>

                        <!-- Menu 4 (Inspirator) -->
                        <a {!! $isMember ? 'href="' . route('user-referral.index') . '"' : $authAction !!}
                            class="menu-item-auth flex flex-col items-center cursor-pointer group">
                            <div
                                class="w-14 h-14 md:w-16 md:h-16 rounded-2xl bg-gradient-to-tr from-blue-600 to-cyan-700 flex items-center justify-center text-white shadow-md shadow-blue-500/20 group-hover:scale-105 transition">
                                <i class="fa-solid fa-lightbulb text-xl md:text-2xl"></i>
                            </div>
                            <span
                                class="text-xs font-semibold text-slate-300 mt-2 text-center leading-tight">Inspirator</span>
                        </a>

                        <!-- Menu Kartu Anggota (KTA) di Fitur Eksklusif -->
                        <a href="{{ route('user-anggota.index') }}"
                            class="flex flex-col items-center cursor-pointer group">
                            <div
                                class="w-14 h-14 md:w-16 md:h-16 rounded-2xl bg-gradient-to-tr from-amber-600 to-amber-500 flex items-center justify-center text-white shadow-md shadow-amber-500/20 group-hover:scale-105 transition">
                                <i class="fa-solid fa-id-card text-xl md:text-2xl"></i>
                            </div>
                            <span class="text-xs font-semibold text-slate-300 mt-2 text-center leading-tight">Kartu
                                Anggota</span>
                        </a>

                        <!-- Menu 3 (E-Dokumen) -->
                        <a {!! $isMember ? 'href="' . url('/user-surat') . '"' : $authAction !!}
                            class="menu-item-auth flex flex-col items-center cursor-pointer group">
                            <div
                                class="w-14 h-14 md:w-16 md:h-16 rounded-2xl bg-gradient-to-tr from-slate-800 to-blue-900 flex items-center justify-center text-white shadow-md shadow-blue-500/20 group-hover:scale-105 transition">
                                <i class="fa-solid fa-scale-balanced text-xl md:text-2xl"></i>
                            </div>
                            <span
                                class="text-xs font-semibold text-slate-300 mt-2 text-center leading-tight">E-Dokumen</span>
                        </a>

                        <!-- Menu 5 (Asisten Legal / AI Chat) -->
                        <a href="{{ url('/ai-chat') }}" class="flex flex-col items-center cursor-pointer group">
                            <div
                                class="w-14 h-14 md:w-16 md:h-16 rounded-2xl bg-gradient-to-tr from-blue-600 to-cyan-700 flex items-center justify-center text-white shadow-md shadow-blue-500/20 group-hover:scale-105 transition">
                                <i class="fa-solid fa-robot text-xl md:text-2xl"></i>
                            </div>
                            <span class="text-xs font-semibold text-slate-300 mt-2 text-center leading-tight">Asisten
                                Legal</span>
                        </a>

                        <!-- Menu 6 (Korwil) -->
                        <a {!! $isMember ? 'href="' . route('korwil') . '"' : $authAction !!}
                            class="menu-item-auth flex flex-col items-center cursor-pointer group">
                            <div
                                class="w-14 h-14 md:w-16 md:h-16 rounded-2xl bg-gradient-to-tr from-amber-600 to-yellow-600 flex items-center justify-center text-white shadow-md shadow-amber-500/20 group-hover:scale-105 transition">
                                <i class="fa-solid fa-sitemap text-xl md:text-2xl"></i>
                            </div>
                            <span
                                class="text-xs font-semibold text-slate-300 mt-2 text-center leading-tight">Korwil</span>
                        </a>

                        <!-- Menu 7 (E-Organisasi) -->
                        <a {!! $isMember ? 'href="' . url('/about') . '"' : $authAction !!}
                            class="menu-item-auth flex flex-col items-center cursor-pointer group">
                            <div
                                class="w-14 h-14 md:w-16 md:h-16 rounded-2xl bg-gradient-to-tr from-blue-900 to-slate-900 flex items-center justify-center text-white shadow-md shadow-blue-500/20 group-hover:scale-105 transition">
                                <i class="fa-solid fa-network-wired text-xl md:text-2xl"></i>
                            </div>
                            <span
                                class="text-xs font-semibold text-slate-300 mt-2 text-center leading-tight">E-Organisasi</span>
                        </a>

                         <!-- Menu 2 (Artikel) -->
                        <a href="{{ route('artikel.index.public') }}"
                            class="flex flex-col items-center cursor-pointer group">
                            <div
                                class="w-14 h-14 md:w-16 md:h-16 rounded-2xl bg-gradient-to-tr from-blue-800 to-blue-600 flex items-center justify-center text-white shadow-md shadow-blue-500/20 group-hover:scale-105 transition">
                                <i class="fa-solid fa-certificate text-xl md:text-2xl"></i>
                            </div>
                            <span
                                class="text-xs font-semibold text-slate-300 mt-2 text-center leading-tight">Artikel</span>
                        </a>

                        <!-- Menu 8 (Kerja Sama) -->
                        <a {!! $isMember ? 'href="' . route('user-kerjasamas.index') . '"' : $authAction !!}
                            class="menu-item-auth flex flex-col items-center cursor-pointer group">
                            <div
                                class="w-14 h-14 md:w-16 md:h-16 rounded-2xl bg-gradient-to-tr from-red-600 to-rose-800 flex items-center justify-center text-white shadow-md shadow-red-500/20 group-hover:scale-105 transition">
                                <i class="fa-solid fa-handshake text-xl md:text-2xl"></i>
                            </div>
                            <span class="text-xs font-semibold text-slate-300 mt-2 text-center leading-tight">Kerja
                                Sama</span>
                        </a>

                    </div>
                </div>
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
