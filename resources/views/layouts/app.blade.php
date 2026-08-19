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

<body class="bg-white font-sans text-slate-800 antialiased min-h-screen flex flex-col">

    <!-- ================================================= -->
    <!-- VIEW 1: TAMPILAN ANDROID / MOBILE                 -->
    <!-- ================================================= -->
    <div id="view-android-container" class="w-full 2xl:hidden flex-1 flex flex-col relative bg-white">

        <!-- Header Tetap (Sticky) -->
        <header
            class="sticky top-0 left-0 right-0 z-40 px-6 sm:px-12 pt-8 pb-4 bg-slate-900/95 backdrop-blur-md border-b border-white/5">
            {{-- class="sticky top-0 left-0 right-0 z-40 px-6 sm:px-12 pt-8 pb-4 bg-slate-900/80 backdrop-blur-md border-b border-slate-800/50"> --}}
            <div class="flex items-center justify-between relative z-10">
                <div class="flex items-center space-x-2.5">
                    <img src="{{ asset('log.png') }}" alt="Logo" class="h-10 sm:h-12 w-auto object-contain">
                </div>
                <div class="flex items-center space-x-3">
                    <div
                        class="flex items-center bg-[#0a1226]/90 backdrop-blur-md border border-blue-950/60 rounded-full px-3.5 py-1.5 shadow-inner">
                        <i class="fa-solid fa-magnifying-glass text-xs text-blue-300/60 mr-2"></i>
                        <span class="text-xs text-blue-200/80 font-medium tracking-wide">Pencarian...</span>
                    </div>
                    <div class="relative">
                        <button
                            class="w-9 h-9 rounded-full bg-[#0a1226]/90 border border-blue-950/60 flex items-center justify-center text-blue-200 hover:text-white transition">
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
            @yield('content')
        </main>

        <!-- Mobile Bottom Navigation Bar -->
        <div
            class="fixed bottom-0 left-0 right-0 bg-white border-t border-slate-200 px-6 py-2.5 flex items-center justify-around z-50 shadow-[0_-4px_20px_rgba(0,0,0,0.06)]">
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
            class="bg-white border-r border-slate-200 flex flex-col justify-between h-screen z-30 shadow-sm shrink-0 transition-all duration-300">
            <div>
                <!-- Brand Header -->
                <div class="p-6 border-b border-slate-100 flex items-center space-x-3 overflow-hidden">
                    <div
                        class="w-10 h-10 rounded-xl bg-gradient-to-tr from-blue-700 to-amber-500 flex items-center justify-center text-white font-black text-lg shadow-md shrink-0 overflow-hidden">
                        <img src="{{ asset('bakumda.png') }}" alt="Avatar" class="w-full h-full object-cover">
                    </div>
                    <div x-show="sidebarOpen" x-transition.opacity class="truncate">
                        <h1 class="font-extrabold text-slate-900 text-base tracking-wider">BAKUMDA</h1>
                        <p class="text-[10px] text-slate-500 font-medium">Bantuan Hukum Daerah</p>
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
                        class="flex items-center space-x-3 px-3.5 py-2.5 rounded-xl text-slate-600 hover:text-slate-900 hover:bg-slate-100 font-medium text-sm transition">
                        <i class="fa-solid fa-newspaper  w-5 text-center shrink-0 text-base"></i>
                        <span x-show="sidebarOpen" x-transition.opacity class="truncate">Artikel</span>
                    </a>
                    <a href="{{ route('kartu-anggota.cek.form') }}"
                        class="flex items-center space-x-3 px-3.5 py-2.5 rounded-xl text-slate-600 hover:text-slate-900 hover:bg-slate-100 font-medium text-sm transition">
                        <i class="fa-solid fa-qrcode w-5 text-center shrink-0 text-base"></i>
                        <span x-show="sidebarOpen" x-transition.opacity class="truncate">Scan</span>
                    </a>
                    <a href="{{ route('user-anggota.index') }}"
                        class="flex items-center space-x-3 px-3.5 py-2.5 rounded-xl text-slate-600 hover:text-slate-900 hover:bg-slate-100 font-medium text-sm transition">
                        <i class="fa-solid fa-id-card  w-5 text-center shrink-0 text-base"></i>
                        <span x-show="sidebarOpen" x-transition.opacity class="truncate">Kartu</span>
                    </a>
                    <a href="{{ route('profile.show') }}"
                        class="flex items-center space-x-3 px-3.5 py-2.5 rounded-xl text-slate-600 hover:text-slate-900 hover:bg-slate-100 font-medium text-sm transition">
                        <i class="fa-solid fa-user-shield w-5 text-center shrink-0 text-base"></i>
                        <span x-show="sidebarOpen" x-transition.opacity class="truncate">Profile</span>
                    </a>
                </nav>
            </div>

            <!-- User Info & Logout Footer -->
            <div class="border-t border-slate-100 bg-slate-50/50 flex flex-col">

                <!-- Hidden Logout Form -->
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
                <!-- Tombol Logout -->
                <div class="px-3 pb-3 pt-3">
                    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                        class="flex items-center space-x-3 px-3.5 py-2 rounded-xl text-red-600 hover:bg-red-50 font-medium text-sm transition">
                        <i class="fa-solid fa-right-from-bracket w-5 text-center shrink-0 text-base"></i>
                        <span x-show="sidebarOpen" x-transition.opacity class="truncate">Logout</span>
                    </a>
                </div>
                <!-- User Profile Info -->
                <div class="p-4 border-t border-slate-100 flex items-center space-x-3 overflow-hidden">
                    <div
                        class="w-9 h-9 rounded-full bg-slate-200 border border-slate-300 flex items-center justify-center text-amber-700 font-bold text-xs shrink-0">
                        AM</div>
                    <div x-show="sidebarOpen" x-transition.opacity class="overflow-hidden truncate">
                        <h4 class="text-xs font-bold text-slate-900 truncate">DR. H. ARIS M.</h4>
                        <p class="text-[10px] text-slate-500 truncate">Advokat / Konsultan</p>
                    </div>
                </div>

            </div>
        </aside>

        <!-- Main Desktop Content Area yang bisa discroll secara mandiri -->
        <div class="flex-1 flex flex-col min-w-0 h-screen overflow-y-auto bg-slate-50/30">
            <!-- Top Bar - Sticky di bagian atas area konten -->
            <header
                class="bg-white/90 backdrop-blur-md border-b border-slate-200 px-6 py-4 flex items-center justify-between sticky top-0 z-20">
                <div class="flex items-center space-x-4">
                    <!-- Tombol Burger Menu untuk Membuka/Menutup Sidebar -->
                    <button @click="sidebarOpen = !sidebarOpen"
                        class="w-10 h-10 rounded-full bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-600 hover:text-slate-900 transition shadow-sm focus:outline-none">
                        <i class="fa-solid fa-bars text-sm"></i>
                    </button>

                </div>
                <div class="items-center space-x-4 hidden sm:flex">
                    <div class="relative w-72">
                        <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-3 text-xs text-slate-400"></i>
                        <input type="text" placeholder="Cari pasal, layanan, atau konsultasi..."
                            class="w-full bg-slate-100 border border-slate-200 text-xs text-slate-800 rounded-full pl-10 pr-4 py-2.5 focus:outline-none focus:border-blue-500 transition">
                    </div>
                    <div class="relative">
                        <button
                            class="w-10 h-10 rounded-full bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-600 hover:text-slate-900 transition">
                            <i class="fa-regular fa-bell text-sm"></i>
                        </button>
                        <span
                            class="absolute top-1 right-1 w-4 h-4 bg-amber-500 text-white font-extrabold text-[9px] flex items-center justify-center rounded-full shadow">8</span>
                    </div>
                </div>
            </header>

            <!-- Desktop Content Slot -->
            <div class="flex-1">
                @yield('content')
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
