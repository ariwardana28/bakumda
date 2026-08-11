<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard - BAKUMDA')</title>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            200: '#bfdbfe',
                            300: '#93c5fd',
                            400: '#60a5fa',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e40af',
                            900: '#1e3a8a',
                        },
                    },
                },
            },
        };
    </script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- FontAwesome Icons -->

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
    @stack('styles')
</head>

<body class="min-h-screen text-gray-800 flex flex-col items-center justify-start p-0 md:p-6 transition-all duration-300">

    <div id="appContainer" class="w-full flex flex-col items-center justify-center">

        {{-- <div id="viewSwitcherBar" class="hidden md:flex items-center justify-center gap-2 w-full max-w-[1440px] px-4 py-3 bg-white/95 border-b border-gray-200 shadow-sm sticky top-0 z-40">
            <button id="btnMobile" onclick="setMode('mobile')"
                class="px-3 py-1.5 text-xs font-bold rounded-xl bg-gray-100 text-gray-600 hover:bg-gray-200 transition">
                Mode Mobile
            </button>
            <button id="btnDesktop" onclick="setMode('desktop')"
                class="px-3 py-1.5 text-xs font-bold rounded-xl bg-gray-100 text-gray-600 hover:bg-gray-200 transition">
                Mode Desktop
            </button>
        </div> --}}

        <!-- ================= 1. ANDROID MOBILE APP VIEW CONTAINER ================= -->
        <div id="androidView"
            class="w-full sm:max-w-[412px] bg-white min-h-screen sm:min-h-[860px] sm:max-h-[90vh] sm:rounded-[45px] sm:ring-[12px] sm:ring-slate-800 sm:shadow-2xl relative flex flex-col justify-between overflow-hidden transition-all duration-300 hidden">

            <!-- Mobile Status Bar (Android Simulation) -->
            <div
                class="w-full bg-white pt-3 px-6 flex justify-between items-center text-xs font-semibold text-gray-800 shrink-0 hidden sm:flex">
                <span>13.26</span>
                <div class="flex items-center space-x-1.5 text-xs">
                    <i class="fa-solid fa-signal"></i>
                    <i class="fa-solid fa-wifi"></i>
                    <span class="font-bold text-[10px] px-1 bg-gray-200 rounded">4G</span>
                    <span class="bg-gray-800 text-white px-1 rounded text-[10px]">64</span>
                </div>
            </div>

            <!-- Header Profile Section (Mobile) -->
            <div
                class="fixed top-0 left-0 right-0 px-5 pt-4 pb-2 flex items-center justify-between bg-white shadow-sm z-30">
                <div class="flex items-center space-x-3">
                    <div
                        class="w-12 h-12 rounded-xl p-0.5 flex items-center justify-center text-gray-700 overflow-hidden shadow-sm">
                        <img src="{{ asset('bakumda.png') }}" alt="Profile"
                            class="w-full h-full rounded-lg object-cover">
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 font-medium"></p>
                        <h1 class="text-lg font-bold text-gray-900 tracking-tight">BAKUMDA
                        </h1>
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

            <!-- MAIN CONTENT AREA (Mobile) -->
            <div id="androidContentSlot" class="flex-1 overflow-y-auto no-scrollbar pb-28 pt-24">
                @yield('content')
            </div>

            <!-- BOTTOM NAVIGATION BAR (Mobile View) -->
            <!-- Bottom Navigation Bar -->
            <div
                class="fixed bottom-0 left-0 right-0 h-24 bg-white shadow-[0_-5px_20px_-5px_rgba(0,0,0,0.05)] z-30 sm:max-w-[412px] sm:mx-auto sm:rounded-b-[45px] flex justify-center items-start pt-3">
                <div class="flex justify-around items-start w-full max-w-xs">

                    <!-- Tombol Kartu -->
                    <a href="{{ route('user-anggota.index') }}"
                        class="flex flex-col items-center space-y-1 text-gray-400 hover:text-orange-500 transition">
                        <i class="fa-solid fa-id-card text-xl"></i>
                        <span class="text-[10px] font-bold">Kartu</span>
                    </a>
                    <!-- Tombol Pendaftaran (sebelumnya Beranda) -->
                    <a href="{{ route('sertifikat.cek.form') }}"
                        class="flex flex-col items-center space-y-1 text-gray-400 hover:text-orange-500 transition">
                        <i class="fa-solid fa-clipboard-check text-xl"></i>
                        <span class="text-[10px] font-bold">Cek Sertifikat</span>
                    </a>
                    <!-- Tombol Beranda (Tengah) -->
                    <a href="{{ route('welcome') }}"
                        class="w-16 h-16 rounded-full bg-orange-500 text-white flex items-center justify-center -mt-8 shadow-lg shadow-orange-500/40 border-4 border-white">
                        <i class="fa-solid fa-house text-2xl"></i>
                    </a>
                    <!-- Tombol Cek Kartu -->
                    <a href="{{ route('kartu-anggota.cek.form') }}"
                        class="flex flex-col items-center space-y-1 text-gray-400 hover:text-orange-500 transition">
                        <i class="fa-solid fa-id-card-clip text-xl"></i>
                        <span class="text-[10px] font-bold">Cek Anggota</span>
                    </a>
                    <!-- Tombol Profil -->
                    <a href="{{ route('profile.show') }}"
                        class="flex flex-col items-center space-y-1 text-gray-400 hover:text-orange-500 transition">
                        <i class="fa-solid fa-user text-xl"></i>
                        <span class="text-[10px] font-bold">Profil</span>
                    </a>
                </div>
            </div>
            <div
                class="absolute bottom-1 left-1/2 -translate-x-1/2 w-32 h-1 bg-gray-800 rounded-full z-30 pointer-events-none hidden sm:block">
            </div>
        </div>

        <!-- ================= 2. FULL DESKTOP WEB DASHBOARD VIEW WITH SIDEBAR ================= -->
        <div id="desktopView"
            class="w-full max-w-[1440px] bg-white rounded-3xl shadow-xl flex overflow-hidden min-h-[90vh] border border-gray-200 hidden">

            <!-- Sidebar Menu (Desktop) -->
            <aside
                class="w-64 bg-slate-900 text-slate-300 flex flex-col justify-between border-r border-slate-800 shrink-0">
                <div>
                    <!-- Sidebar Brand / Logo -->
                    <div class="p-6 flex items-center space-x-3 border-b border-slate-800">
                        <div
                            class="w-10 h-10 rounded-xl border-2 border-orange-500 p-0.5 flex items-center justify-center bg-orange-100 text-gray-700 overflow-hidden shadow-md">
                            <img src="{{ asset('bakumda.png') }}" alt="Profile"
                                class="w-full h-full rounded-lg object-cover">
                        </div>
                        <div>
                            <h2 class="text-sm font-black text-white tracking-wide">BAKUMDA</h2>
                            <span class="text-[10px] text-orange-400 font-extrabold uppercase tracking-widest">Web
                                Portal</span>
                        </div>
                    </div>

                    <!-- Sidebar Navigation Links -->
                    <nav class="p-4 space-y-1.5 text-sm font-semibold">
                        <a href="{{ url('/') }}"
                            class="flex items-center space-x-3 px-4 py-3 rounded-xl bg-orange-500 text-white shadow-lg shadow-orange-500/20 transition">
                            <i class="fa-solid fa-house w-5 text-center"></i>
                            <span>Beranda</span>
                        </a>
                        <a href="{{ route('user-pelatihan.index') }}"
                            class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-slate-800 text-slate-300 hover:text-white transition">
                            <i class="fa-solid fa-graduation-cap w-5 text-center"></i>
                            <span>Pelatihan</span>
                        </a>
                        <a href="{{ route('user-anggota.index') }}"
                            class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-slate-800 text-slate-300 hover:text-white transition">
                            <i class="fa-solid fa-id-card w-5 text-center"></i>
                            <span>Kartu Anggota</span>
                        </a>
                        <a href="{{ route('sertifikat.index') }}"
                            class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-slate-800 text-slate-300 hover:text-white transition">
                            <i class="fa-solid fa-award w-5 text-center"></i>
                            <span>Sertifikat</span>
                        </a>
                        <a href="#" onclick="showServiceMessage('Menu Artikel & Berita')"
                            class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-slate-800 text-slate-300 hover:text-white transition">
                            <i class="fa-solid fa-newspaper w-5 text-center"></i>
                            <span>Artikel</span>
                        </a>
                        <a href="#" onclick="showServiceMessage('Menu Kalender Event')"
                            class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-slate-800 text-slate-300 hover:text-white transition">
                            <i class="fa-regular fa-calendar-days w-5 text-center"></i>
                            <span>Kalender Event</span>
                        </a>
                    </nav>
                </div>

                <!-- Sidebar Footer User Profile Card -->
                <div class="p-4 border-t border-slate-800 bg-slate-950/40">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3 overflow-hidden">
                            <div
                                class="w-9 h-9 rounded-full bg-orange-500/20 text-orange-400 font-bold flex items-center justify-center shrink-0">
                                {{ substr(Auth::user()->name ?? 'G', 0, 1) }}
                            </div>
                            <div class="truncate">
                                <p class="text-xs font-bold text-white truncate">{{ Auth::user()->name ?? 'Guest' }}
                                </p>
                                <p class="text-[10px] text-slate-400 truncate">Member Aktif</p>
                            </div>
                        </div>
                        <button onclick="showServiceMessage('Pengaturan Akun')"
                            class="text-slate-400 hover:text-white transition p-1">
                            <i class="fa-solid fa-gear text-sm"></i>
                        </button>
                    </div>
                </div>
            </aside>

            <!-- Main Content Area with Header (Desktop) -->
            <div class="flex-1 flex flex-col min-w-0 overflow-hidden bg-gray-50">
                <!-- Desktop Topbar -->
                <header
                    class="bg-white border-b border-gray-200 px-8 py-4 flex items-center justify-between shrink-0 shadow-sm z-10">
                    <div>
                        <h1 class="text-lg font-black text-gray-900 tracking-tight">Dashboard Administrator & Member
                        </h1>
                        <p class="text-xs text-gray-500">Kelola aktivitas dan program pelatihan Anda di sini.</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="relative">
                            <input type="text" placeholder="Cari data..."
                                class="bg-gray-100 text-xs text-gray-800 placeholder-gray-400 px-3.5 py-2 pl-9 rounded-xl border border-gray-200 focus:outline-none focus:border-orange-500 w-64 transition">
                            <i class="fa-solid fa-magnifying-glass absolute left-3 top-2.5 text-gray-400 text-xs"></i>
                        </div>
                        <button onclick="showNotificationModal()"
                            class="relative w-9 h-9 rounded-xl bg-gray-100 hover:bg-gray-200 text-orange-600 flex items-center justify-center transition shrink-0">
                            <i class="fa-regular fa-bell text-sm"></i>
                            <span
                                class="absolute top-2 right-2 w-2 h-2 bg-red-500 rounded-full ring-2 ring-white"></span>
                        </button>
                    </div>
                </header>

                <!-- Scrollable Content Body -->
                <main id="desktopContentSlot" class="flex-1 overflow-y-auto p-8">
                    @yield('content')
                </main>
            </div>
        </div>

    </div>

    <script>
        // Fungsi deteksi otomatis berdasarkan lebar layar saat halaman dimuat
        document.addEventListener("DOMContentLoaded", function() {
            checkScreenSize();
            window.addEventListener("resize", checkScreenSize);
        });

        function checkScreenSize() {
            // Jika lebar layar kurang dari 768px (Mobile/Android), aktifkan tampilan mobile. Jika lebih, desktop.
            if (window.innerWidth < 768) {
                setMode('mobile');
            } else {
                setMode('desktop');
            }
        }

        function setMode(mode) {
            const desktopView = document.getElementById('desktopView');
            const androidView = document.getElementById('androidView');
            const btnDesktop = document.getElementById('btnDesktop');
            const btnMobile = document.getElementById('btnMobile');

            if (mode === 'desktop') {
                desktopView.classList.remove('hidden');
                androidView.classList.add('hidden');
                moveSharedContentTo('desktopContentSlot', sharedContent);
                if (btnDesktop && btnMobile) {
                    btnDesktop.className = "px-3 py-1.5 text-xs font-bold rounded-xl bg-orange-500 text-white transition";
                    btnMobile.className =
                        "px-3 py-1.5 text-xs font-bold rounded-xl bg-gray-100 text-gray-600 hover:bg-gray-200 transition";
                }
            } else {
                desktopView.classList.add('hidden');
                androidView.classList.remove('hidden');
                moveSharedContentTo('androidContentSlot', sharedContent);
                if (btnDesktop && btnMobile) {
                    btnMobile.className = "px-3 py-1.5 text-xs font-bold rounded-xl bg-orange-500 text-white transition";
                    btnDesktop.className =
                        "px-3 py-1.5 text-xs font-bold rounded-xl bg-gray-100 text-gray-600 hover:bg-gray-200 transition";
                }
            }
        }

        function showServiceMessage(msg) {
            alert(msg);
        }

        function showNotificationModal() {
            alert("Tidak ada notifikasi baru.");
        }
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @stack('scripts')
</body>

</html>
