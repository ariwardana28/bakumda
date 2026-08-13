<!DOCTYPE html>
<html lang="id">

<head>
    <!-- Bagian HEAD tetap sama -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard - BAKUMDA')</title>
    <script>
        window.tailwind = window.tailwind || {};
        window.tailwind.config = {
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

        /* Hapus styling simulasi Android ring/radius karena akan menggunakan tampilan web responsif murni */
    </style>
    @stack('styles')
</head>

<!-- Gunakan padding murni untuk responsivitas, hapus items-center justify-start -->

<body class="min-h-screen text-gray-800 flex flex-col transition-all duration-300 bg-slate-50">

    <!-- Hapus appContainer dan pembagian androidView/desktopView. Gunakan struktur Flexbox untuk layout responsif. -->

    <!-- ================= 1. DESKTOP SIDEBAR & HEADER (Hanya tampil di layar sedang ke atas) ================= -->
    <div class="flex min-h-screen w-full">
        <!-- Sidebar Menu (Desktop) - Hanya tampil MD ke atas -->
        <aside
            class="hidden md:flex w-64 bg-slate-900 text-slate-300 flex-col justify-between border-r border-slate-800 shrink-0 fixed h-full left-0 top-0 z-40">
            <div>
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

                <nav class="p-4 space-y-1.5 text-sm font-semibold">
                    <!-- Link menu Navigasi... (sama seperti sebelumnya) -->
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

            <div class="p-4 border-t border-slate-800 bg-slate-950/40">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3 overflow-hidden">
                        <div
                            class="w-9 h-9 rounded-full bg-orange-500/20 text-orange-400 font-bold flex items-center justify-center shrink-0">
                            {{ substr(Auth::user()->name ?? 'G', 0, 1) }}
                        </div>
                        <div class="truncate">
                            <p class="text-xs font-bold text-white truncate">{{ Auth::user()->name ?? 'Guest' }}</p>
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

        <!-- ================= 2. MOBILE HEADER & BOTTOM NAVIGATION ================= -->
        <!-- Header Mobile - Hanya tampil MD ke bawah -->
        <header
            class="md:hidden fixed top-0 left-0 right-0 px-5 pt-4 pb-3 flex items-center justify-between bg-white shadow-sm z-40 border-b border-gray-100">
            <div class="flex items-center space-x-3">
                <img src="{{ asset('bakumda.png') }}" alt="Profile"
                    class="w-10 h-10 rounded-xl object-cover shadow-sm">
                <h1 class="text-base font-bold text-gray-900 tracking-tight">BAKUMDA</h1>
            </div>
            <div class="flex items-center space-x-2.5">
                <button onclick="showNotificationModal()"
                    class="relative w-9 h-9 rounded-full flex items-center justify-center text-orange-500 hover:bg-orange-50 transition">
                    <i class="fa-regular fa-bell text-lg"></i>
                    <span class="absolute top-2 right-2 w-2 h-2 bg-red-500 rounded-full ring-1 ring-white"></span>
                </button>
                <button onclick="showServiceMessage('Bantuan CS')"
                    class="w-9 h-9 rounded-full bg-orange-500 text-white flex items-center justify-center shadow-md hover:bg-orange-600 transition text-sm">
                    <i class="fa-solid fa-headset"></i>
                </button>
            </div>
        </header>

        <!-- BOTTOM NAVIGATION BAR (Mobile View) - Hanya tampil MD ke bawah -->
        <div
            class="md:hidden fixed bottom-0 left-0 right-0 h-16 bg-white shadow-[0_-5px_20px_-5px_rgba(0,0,0,0.05)] z-40 flex justify-center items-center border-t border-gray-100">
            <div class="flex justify-around items-center w-full max-w-md px-4">
                <a href="{{ route('user-anggota.index') }}"
                    class="flex flex-col items-center space-y-0.5 text-gray-400 hover:text-orange-500 transition">
                    <i class="fa-solid fa-id-card text-lg"></i>
                    <span class="text-[10px] font-bold">Kartu</span>
                </a>
                <a href="{{ route('sertifikat.cek.form') }}"
                    class="flex flex-col items-center space-y-0.5 text-gray-400 hover:text-orange-500 transition">
                    <i class="fa-solid fa-clipboard-check text-lg"></i>
                    <span class="text-[10px] font-bold">Cek Sertifikat</span>
                </a>
                <!-- Tombol Home Tengah (Mobile) -->
                <a href="{{ route('welcome') }}"
                    class="w-14 h-14 rounded-full bg-orange-500 text-white flex items-center justify-center -mt-7 shadow-lg shadow-orange-500/40 border-4 border-white">
                    <img src="{{ asset('cd.png') }}" alt="QR Code" class="w-7 h-7">
                </a>
                <a href="{{ route('kartu-anggota.cek.form') }}"
                    class="flex flex-col items-center space-y-0.5 text-gray-400 hover:text-orange-500 transition">
                    <i class="fa-solid fa-id-card-clip text-lg"></i>
                    <span class="text-[10px] font-bold">Cek Anggota</span>
                </a>
                <a href="{{ route('profile.show') }}"
                    class="flex flex-col items-center space-y-0.5 text-gray-400 hover:text-orange-500 transition">
                    <i class="fa-solid fa-user text-lg"></i>
                    <span class="text-[10px] font-bold">Profil</span>
                </a>
            </div>
        </div>

        <!-- ================= 3. KONTEN UTAMA RESPONSIF TUNGGAL ================= -->
        <!-- Dorong konten utama ke kanan (untuk desktop) dan beri ruang header/footer (untuk mobile) -->
        <main id="mainContentWrapper"
            class="flex-1 w-full md:pl-64 pt-16 pb-20 md:pt-0 md:pb-0 transition-all duration-300 bg-slate-50">

            <!-- Opsional: Tambahkan Header Web Desktop (khusus desktop) -->
            <header
                class="hidden md:flex bg-white border-b border-gray-200 px-8 py-5 items-center justify-between shrink-0 shadow-sm z-10 sticky top-0 left-64 right-0">
                <div>
                    <h1 class="text-base font-black text-gray-900 tracking-tight">Dashboard</h1>
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
                        <span class="absolute top-2 right-2 w-2 h-2 bg-red-500 rounded-full ring-2 ring-white"></span>
                    </button>
                </div>
            </header>

            <!-- AREA INI AKAN DIISI OLEH FORM ANDA -->
            <div class="px-4 py-6 md:px-8 md:py-10">
                @yield('content')
            </div>
        </main>
    </div>

    <!-- Hapus #sharedContentTemplate dan semua fungsi JavaScript terkait modeview checkScreenSize-->
    <!-- Hapus juga event listener window.resize -->

    <script>
        // Skrip Inisialisasi Dasar
        document.addEventListener("DOMContentLoaded", function() {
            // checkScreenSize(); // Tidak lagi dibutuhkan
            // window.addEventListener("resize", checkScreenSize); // Tidak lagi dibutuhkan
        });

        // Fungsi Global Tetap dipertahankan
        function showServiceMessage(msg) {
            alert(msg);
        }

        function showNotificationModal() {
            alert("Tidak ada notifikasi baru.");
        }
    </script>
    @stack('scripts')
</body>

</html>
