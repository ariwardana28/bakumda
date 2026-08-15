<!DOCTYPE html>
<html lang="id">

<head>
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
    </style>
    @stack('styles')
</head>

<body class="min-h-screen text-gray-800 flex flex-col transition-all duration-300 bg-slate-50"
    x-data="{ sidebarOpen: false }">

    <div class="flex min-h-screen w-full">
        <!-- Sidebar (Hanya tampil di layar besar/desktop, lg dan ke atas) -->
        <aside :class="sidebarOpen ? '2xl:w-64' : '2xl:w-20'"
            class="hidden 2xl:flex bg-slate-900 text-slate-300 flex-col justify-between border-r border-slate-800 shrink-0 fixed h-full left-0 top-0 z-40 transition-all duration-300">
            <div>
                <div class="p-4 xl:p-5 flex items-center space-x-3 border-b border-slate-800 h-[85px]"
                    :class="sidebarOpen ? 'justify-start' : 'justify-center'">
                    <div
                        class="w-10 h-10 rounded-xl border-2 border-orange-500 p-0.5 flex items-center justify-center bg-orange-100 text-gray-700 overflow-hidden shadow-md shrink-0 transition-all">
                        <img src="{{ asset('bakumda.png') }}" alt="Profile"
                            class="w-full h-full rounded-lg object-cover">
                    </div>
                    <div class="overflow-hidden" x-show="sidebarOpen" x-transition>
                        <h2 class="text-sm font-black text-white tracking-wide truncate">BAKUMDA</h2>
                        <span class="text-[10px] text-orange-400 font-extrabold uppercase tracking-widest">Web
                            Portal</span>
                    </div>
                </div>

                <nav class="p-3 xl:p-4 space-y-1.5 text-sm font-semibold">
                    <a href="{{ url('/') }}"
                        class="flex items-center space-x-3 px-4 py-3 rounded-xl bg-orange-500 text-white shadow-lg shadow-orange-500/20 transition"
                        :class="sidebarOpen ? 'justify-start' : 'justify-center'" title="Beranda">
                        <i class="fa-solid fa-house w-5 text-center"></i>
                        <span x-show="sidebarOpen">Beranda</span>
                    </a>
                    <a href="{{ route('user-pelatihan.index') }}"
                        class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-slate-800 text-slate-300 hover:text-white transition"
                        :class="sidebarOpen ? 'justify-start' : 'justify-center'" title="Pelatihan">
                        <i class="fa-solid fa-graduation-cap w-5 text-center"></i>
                        <span x-show="sidebarOpen">Pelatihan</span>
                    </a>
                    <a href="{{ route('user-anggota.index') }}"
                        class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-slate-800 text-slate-300 hover:text-white transition"
                        :class="sidebarOpen ? 'justify-start' : 'justify-center'" title="Kartu Anggota">
                        <i class="fa-solid fa-id-card w-5 text-center"></i>
                        <span x-show="sidebarOpen">Kartu Anggota</span>
                    </a>
                    <a href="{{ route('sertifikat.index') }}"
                        class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-slate-800 text-slate-300 hover:text-white transition"
                        :class="sidebarOpen ? 'justify-start' : 'justify-center'" title="Sertifikat">
                        <i class="fa-solid fa-award w-5 text-center"></i>
                        <span x-show="sidebarOpen">Sertifikat</span>
                    </a>
                    <a href="#" onclick="showServiceMessage('Menu Artikel & Berita')"
                        class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-slate-800 text-slate-300 hover:text-white transition"
                        :class="sidebarOpen ? 'justify-start' : 'justify-center'" title="Artikel">
                        <i class="fa-solid fa-newspaper w-5 text-center"></i>
                        <span x-show="sidebarOpen">Artikel</span>
                    </a>
                    <a href="#" onclick="showServiceMessage('Menu Kalender Event')"
                        class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-slate-800 text-slate-300 hover:text-white transition"
                        :class="sidebarOpen ? 'justify-start' : 'justify-center'" title="Kalender Event">
                        <i class="fa-regular fa-calendar-days w-5 text-center"></i>
                        <span x-show="sidebarOpen">Kalender Event</span>
                    </a>
                </nav>
            </div>

            <div class="p-3 xl:p-4 border-t border-slate-800 bg-slate-950/40">
                <div class="flex items-center" :class="sidebarOpen ? 'justify-between' : 'justify-center'">
                    <div class="flex items-center space-x-3 overflow-hidden">
                        <div
                            class="w-9 h-9 rounded-full bg-orange-500/20 text-orange-400 font-bold flex items-center justify-center shrink-0">
                            {{ substr(Auth::user()->name ?? 'G', 0, 1) }}
                        </div>
                        <div class="truncate" x-show="sidebarOpen" x-transition.opacity>
                            <p class="text-xs font-bold text-white truncate">{{ Auth::user()->name ?? 'Guest' }}</p>
                            <p class="text-[10px] text-slate-400 truncate">Member Aktif</p>
                        </div>
                    </div>
                    <button onclick="showServiceMessage('Pengaturan Akun')"
                        class="text-slate-400 hover:text-white transition p-1" title="Pengaturan">
                        <i class="fa-solid fa-gear text-sm"></i>
                    </button>
                </div>
                <button @click="sidebarOpen = !sidebarOpen"
                    class="w-full mt-4 flex items-center text-slate-400 hover:text-white py-2 px-3 rounded-lg hover:bg-slate-800 transition-colors"
                    :class="sidebarOpen ? 'justify-between' : 'justify-center'">
                    <span class="text-xs font-semibold" x-show="sidebarOpen" x-transition.opacity>Tutup Menu</span>
                    <i class="fa-solid" :class="sidebarOpen ? 'fa-chevron-left' : 'fa-chevron-right'"></i>
                </button>
            </div>
        </aside>

        <!-- Header Mobile & Tablet (Tampil di layar kecil hingga lg) -->
        <header
            class="2xl:hidden fixed top-0 left-0 right-0 px-5 pt-4 pb-3 flex items-center justify-between bg-white shadow-sm z-40 border-b border-gray-100">
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

        <!-- Bottom Navigation Bar (Tampil di layar kecil hingga lg) -->
        <div
            class="2xl:hidden fixed bottom-0 left-0 right-0 h-16 bg-white shadow-[0_-5px_20px_-5px_rgba(0,0,0,0.05)] z-40 flex justify-center items-center border-t border-gray-100">
            <div class="flex justify-around items-center w-full max-w-md px-4">
                <a href="{{ url('/') }}"
                    class="flex flex-col items-center space-y-0.5 text-gray-400 hover:text-orange-500 transition">
                    <i class="fa-solid fa-house text-lg"></i>
                    <span class="text-[10px] font-bold">Beranda</span>
                </a>
                <a href="{{ route('kartu-anggota.cek.form') }}"
                    class="flex flex-col items-center space-y-0.5 text-gray-400 hover:text-orange-500 transition">
                    <i class="fa-solid fa-id-card-clip text-lg"></i>
                    <span class="text-[10px] font-bold">Artikel</span>
                </a>
                <a href="{{ route('kartu-anggota.cek.form') }}"
                    class="w-14 h-14 rounded-full bg-orange-500 text-white flex items-center justify-center -mt-7 shadow-lg shadow-orange-500/40 border-4 border-white">
                    <img src="{{ asset('cd.png') }}" alt="QR Code" class="w-7 h-7">
                </a>
                <a href="{{ route('user-anggota.index') }}"
                    class="flex flex-col items-center space-y-0.5 text-gray-400 hover:text-orange-500 transition">
                    <i class="fa-solid fa-id-card text-lg"></i>
                    <span class="text-[10px] font-bold">Kartu</span>
                </a>
                <a href="{{ route('profile.show') }}"
                    class="flex flex-col items-center space-y-0.5 text-gray-400 hover:text-orange-500 transition">
                    <i class="fa-solid fa-user text-lg"></i>
                    <span class="text-[10px] font-bold">Profil</span>
                </a>
            </div>
        </div>

        <!-- Konten Utama (Responsif menyesuaikan sidebar dan navigasi) -->
        <main id="mainContentWrapper" :class="sidebarOpen ? '2xl:pl-64' : '2xl:pl-20'"
            class="flex-1 w-full pt-16 pb-20 2xl:pt-0 2xl:pb-0 transition-all duration-300 bg-slate-50 flex flex-col min-h-screen">

            <!-- Desktop & Tablet Header Top Bar -->
            <header
                class="hidden 2xl:flex bg-white border-b border-gray-200 px-8 py-5 items-center justify-between shrink-0 shadow-sm z-10 sticky top-0">
                <div class="flex items-center gap-4">
                    <button @click="sidebarOpen = !sidebarOpen"
                        class="w-9 h-9 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-600 flex items-center justify-center transition shrink-0" title="Toggle Sidebar">
                        <i class="fa-solid fa-bars text-sm"></i>
                    </button>
                    <h1 class="text-base font-black text-gray-900 tracking-tight">@yield('title', 'Dashboard')</h1>
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

            <!-- Bagian Konten Isi (Dibatasi max-w agar optimal di layar hingga 13 inch) -->
            <div class="px-4 py-6 md:px-8 md:py-10 max-w-7xl mx-auto w-full flex-1">
                @yield('content')
            </div>
        </main>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {});

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
