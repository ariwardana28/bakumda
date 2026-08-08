<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard IMI Mobilitas - Auto Responsive</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f0f2f5;
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
<body class="min-h-screen text-gray-800 flex flex-col items-center justify-start p-0 md:p-6">


    <!-- MAIN CONTAINER -->
    <div id="appContainer" class="w-full flex justify-center items-center transition-all duration-300">

        <!-- ================= ANDROID MOBILE APP VIEW ================= -->
        <div id="androidView" class="w-full max-w-md bg-white min-h-screen md:min-h-[840px] md:rounded-[40px] md:border-[10px] md:border-gray-900 relative shadow-2xl flex flex-col justify-between pb-24 overflow-hidden">
            
            <!-- Mobile Status Bar (Android Simulation) -->
            <div class="w-full bg-white pt-3 px-6 flex justify-between items-center text-xs font-semibold text-gray-800 md:hidden">
                <span>13.26</span>
                <div class="flex items-center space-x-1.5 text-xs">
                    <i class="fa-solid fa-signal"></i>
                    <i class="fa-solid fa-wifi"></i>
                    <span class="font-bold text-[10px] px-1 bg-gray-200 rounded">4G</span>
                    <span class="bg-gray-800 text-white px-1 rounded text-[10px]">64</span>
                </div>
            </div>

            <div class="px-5 pt-4 pb-2 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 rounded-full border-2 border-orange-500 p-0.5 flex items-center justify-center bg-orange-100 text-gray-700 overflow-hidden shadow-sm">
                        <img src="https://placehold.co/100x100/orange/white?text=User" alt="Profile" class="w-full h-full rounded-full object-cover">
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 font-medium">Halo</p>
                        <h1 class="text-lg font-bold text-gray-900 tracking-tight">Selamat Datang !</h1>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <button onclick="showNotificationModal()" class="relative w-10 h-10 rounded-full flex items-center justify-center text-orange-500 hover:bg-orange-50 transition">
                        <i class="fa-regular fa-bell text-xl"></i>
                        <span class="absolute top-2 right-2 w-2 h-2 bg-red-500 rounded-full ring-2 ring-white"></span>
                    </button>
                    <button onclick="showServiceMessage('Bantuan CS')" class="w-10 h-10 rounded-full bg-orange-500 text-white flex items-center justify-center shadow-md hover:bg-orange-600 transition">
                        <i class="fa-solid fa-headset text-lg"></i>
                    </button>
                </div>
            </div>

            <div class="mt-4">
                <div id="cardSlider" class="flex overflow-x-auto space-x-4 px-5 no-scrollbar scroll-smooth">
                    <!-- Card 1: IMI Mobilitas -->
                    <div class="min-w-[280px] w-[82%] sm:w-[300px] flex-shrink-0 bg-gradient-to-br from-cyan-400 to-blue-600 rounded-3xl p-5 text-white shadow-lg relative overflow-hidden flex flex-col justify-between h-[190px]">
                        <div class="absolute -right-8 -bottom-8 w-32 h-32 bg-white/10 rounded-full pointer-events-none"></div>
                        <div>
                            <h2 class="text-xl font-black tracking-wide">IMI MOBILITAS</h2>
                            <div class="mt-2 text-xs opacity-90 space-y-0.5 font-medium">
                                <p class="font-semibold text-white/90">• Biaya Keanggotaan</p>
                                <p class="text-lg font-extrabold text-white">Rp 50,000<span class="text-xs font-normal">,-/Tahun</span></p>
                                <p>• Mendapatkan kartu digital</p>
                                <p>• Tidak dapat membuat KIS & TKT</p>
                                <p>• Mendapatkan Asuransi kecelakaan diri</p>
                            </div>
                        </div>
                        <div>
                            <button onclick="openModal('IMI Mobilitas', 'Rp 50.000/Tahun')" class="bg-white text-blue-600 hover:bg-blue-50 font-bold text-xs px-4 py-2 rounded-full shadow transition">
                                Daftar disini
                            </button>
                        </div>
                    </div>

                    <!-- Card 2: IMI PRO -->
                    <div class="min-w-[280px] w-[82%] sm:w-[300px] flex-shrink-0 bg-gradient-to-br from-gray-900 to-zinc-800 rounded-3xl p-5 text-white shadow-lg relative overflow-hidden flex flex-col justify-between h-[190px]">
                        <div class="absolute -right-8 -bottom-8 w-32 h-32 bg-white/5 rounded-full pointer-events-none"></div>
                        <div>
                            <h2 class="text-xl font-black tracking-wide">IMI PRO</h2>
                            <div class="mt-2 text-xs opacity-90 space-y-0.5 font-medium">
                                <p class="font-semibold text-gray-300">• Biaya Keanggotaan</p>
                                <p class="text-lg font-extrabold text-white">Rp 150,000<span class="text-xs font-normal">,-/Tahun</span></p>
                                <p>• Mendapatkan kartu fisik & digital</p>
                                <p>• Dapat membuat KIS & TKT</p>
                                <p>• Mendapatkan Asuransi lengkap</p>
                            </div>
                        </div>
                        <div>
                            <button onclick="openModal('IMI PRO', 'Rp 150.000/Tahun')" class="bg-white text-gray-900 hover:bg-gray-100 font-bold text-xs px-4 py-2 rounded-full shadow transition">
                                Daftar disini
                            </button>
                        </div>
                    </div>

                    <!-- Card 3: IMI VIP -->
                    <div class="min-w-[280px] w-[82%] sm:w-[300px] flex-shrink-0 bg-gradient-to-br from-amber-500 to-amber-700 rounded-3xl p-5 text-white shadow-lg relative overflow-hidden flex flex-col justify-between h-[190px]">
                        <div class="absolute -right-8 -bottom-8 w-32 h-32 bg-white/10 rounded-full pointer-events-none"></div>
                        <div>
                            <h2 class="text-xl font-black tracking-wide">IMI VIP</h2>
                            <div class="mt-2 text-xs opacity-90 space-y-0.5 font-medium">
                                <p class="font-semibold text-amber-100">• Biaya Keanggotaan</p>
                                <p class="text-lg font-extrabold text-white">Rp 500,000<span class="text-xs font-normal">,-/Tahun</span></p>
                                <p>• Mendapatkan fasilitas eksklusif</p>
                                <p>• Akses VIP Event & Sirkuit</p>
                                <p>• Asuransi VIP Premium</p>
                            </div>
                        </div>
                        <div>
                            <button onclick="openModal('IMI VIP', 'Rp 500.000/Tahun')" class="bg-white text-amber-700 hover:bg-amber-50 font-bold text-xs px-4 py-2 rounded-full shadow transition">
                                Daftar disini
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Dots Indicator -->
                <div class="flex justify-center items-center space-x-1.5 mt-3" id="dotIndicators">
                    <span onclick="scrollToCard(0)" class="w-5 h-2 bg-orange-500 rounded-full cursor-pointer transition-all duration-300 dot"></span>
                    <span onclick="scrollToCard(1)" class="w-2 h-2 bg-gray-300 rounded-full cursor-pointer transition-all duration-300 dot"></span>
                    <span onclick="scrollToCard(2)" class="w-2 h-2 bg-gray-300 rounded-full cursor-pointer transition-all duration-300 dot"></span>
                </div>
            </div>

            <div class="mt-5 px-5">
                <h3 class="text-base font-bold text-gray-900 mb-3">Fitur Khusus</h3>
                <div class="bg-amber-100/70 rounded-3xl p-4 relative flex items-center justify-between shadow-sm border border-amber-200/50">
                    <div class="w-7/12">
                        <span class="text-xs font-bold text-amber-800 bg-amber-200 px-2 py-0.5 rounded-md inline-block mb-1">Gaspol!</span>
                        <h4 class="font-extrabold text-gray-900 text-sm leading-snug">Perlindungan Asuransi Perjalanan</h4>
                        <button onclick="showServiceMessage('Asuransi Perjalanan')" class="mt-3 bg-white text-gray-700 text-xs font-bold px-3.5 py-1.5 rounded-full shadow-sm hover:bg-gray-50 transition border border-gray-200">
                            Belum aktif
                        </button>
                    </div>
                    <div class="w-5/12 flex justify-center items-center relative">
                        <div class="relative w-28 h-24 flex items-center justify-center">
                            <div class="absolute text-amber-400 font-bold text-2xl -top-2 left-2 animate-bounce">⚡</div>
                            <div class="absolute text-red-500 font-bold text-lg top-4 right-1">!</div>
                            <img src="https://placehold.co/140x100/ffeeba/333?text=Crash+Help" alt="Insurance Illustration" class="w-full h-auto object-contain drop-shadow-md rounded-xl">
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-5 px-5 mb-6">
                <h3 class="text-base font-bold text-gray-900 mb-4">Layanan Lainnya</h3>
                <div class="grid grid-cols-4 gap-3 sm:gap-4">
                    <div onclick="showServiceMessage('Mitra')" class="flex flex-col items-center cursor-pointer group">
                        <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-2xl bg-orange-100/70 border border-orange-200 flex items-center justify-center text-orange-500 shadow-sm group-hover:scale-105 transition">
                            <i class="fa-solid fa-handshake text-xl sm:text-2xl"></i>
                        </div>
                        <span class="text-[11px] sm:text-xs font-semibold text-gray-700 mt-2 text-center">Mitra</span>
                    </div>
                    <div onclick="showServiceMessage('Merchandise')" class="flex flex-col items-center cursor-pointer group">
                        <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-2xl bg-orange-100/70 border border-orange-200 flex items-center justify-center text-orange-500 shadow-sm group-hover:scale-105 transition">
                            <i class="fa-solid fa-shirt text-xl sm:text-2xl"></i>
                        </div>
                        <span class="text-[11px] sm:text-xs font-semibold text-gray-700 mt-2 text-center">Merchandise</span>
                    </div>
                    <div onclick="showServiceMessage('Store')" class="flex flex-col items-center cursor-pointer group">
                        <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-2xl bg-orange-100/70 border border-orange-200 flex items-center justify-center text-orange-500 shadow-sm group-hover:scale-105 transition">
                            <i class="fa-solid fa-store text-xl sm:text-2xl"></i>
                        </div>
                        <span class="text-[11px] sm:text-xs font-semibold text-gray-700 mt-2 text-center">Store</span>
                    </div>
                    <div onclick="showServiceMessage('P1')" class="flex flex-col items-center cursor-pointer group">
                        <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-2xl bg-orange-100/70 border border-orange-200 flex items-center justify-center text-orange-500 shadow-sm group-hover:scale-105 transition">
                            <i class="fa-solid fa-flag-checkered text-xl sm:text-2xl"></i>
                        </div>
                        <span class="text-[11px] sm:text-xs font-semibold text-gray-700 mt-2 text-center">P1</span>
                    </div>
                    <div onclick="showServiceMessage('Audio / Podcast')" class="flex flex-col items-center cursor-pointer group">
                        <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-2xl bg-orange-100/70 border border-orange-200 flex items-center justify-center text-orange-500 shadow-sm group-hover:scale-105 transition">
                            <i class="fa-solid fa-microphone text-xl sm:text-2xl"></i>
                        </div>
                        <span class="text-[11px] sm:text-xs font-semibold text-gray-700 mt-2 text-center">Podcast</span>
                    </div>
                    <div onclick="showServiceMessage('Kalender Event')" class="flex flex-col items-center cursor-pointer group">
                        <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-2xl bg-orange-100/70 border border-orange-200 flex items-center justify-center text-orange-500 shadow-sm group-hover:scale-105 transition">
                            <i class="fa-regular fa-calendar-days text-xl sm:text-2xl"></i>
                        </div>
                        <span class="text-[11px] sm:text-xs font-semibold text-gray-700 mt-2 text-center">Kalender</span>
                    </div>
                    <div onclick="showServiceMessage('IMI TV / Streaming')" class="flex flex-col items-center cursor-pointer group">
                        <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-2xl bg-orange-100/70 border border-orange-200 flex items-center justify-center text-orange-500 shadow-sm group-hover:scale-105 transition">
                            <i class="fa-solid fa-tv text-xl sm:text-2xl"></i>
                        </div>
                        <span class="text-[11px] sm:text-xs font-semibold text-gray-700 mt-2 text-center">IMI TV</span>
                    </div>
                    <div onclick="showServiceMessage('Semua Menu')" class="flex flex-col items-center cursor-pointer group">
                        <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-2xl bg-orange-500 border border-orange-600 flex items-center justify-center text-white shadow-md group-hover:scale-105 transition">
                            <i class="fa-solid fa-grip text-xl sm:text-2xl"></i>
                        </div>
                        <span class="text-[11px] sm:text-xs font-semibold text-gray-700 mt-2 text-center">Lainnya</span>
                    </div>
                </div>
            </div>

            <!-- BOTTOM NAVIGATION BAR (Mobile View) -->
            <div class="absolute bottom-0 left-0 w-full bg-white border-t border-gray-100 py-3 px-6 flex justify-around items-center z-20 shadow-lg">
                <button onclick="switchTab(this, 'Beranda')" class="flex flex-col items-center text-orange-500 transition active-tab">
                    <div class="bg-orange-500 text-white px-4 py-1.5 rounded-full flex items-center space-x-1.5 shadow-sm">
                        <i class="fa-solid fa-house text-sm"></i>
                        <span class="text-xs font-bold">Beranda</span>
                    </div>
                </button>
                <button onclick="switchTab(this, 'Explore')" class="flex flex-col items-center text-gray-400 hover:text-gray-600 transition p-2">
                    <i class="fa-solid fa-globe text-xl"></i>
                </button>
                <button onclick="switchTab(this, 'Community')" class="flex flex-col items-center text-gray-400 hover:text-gray-600 transition p-2">
                    <i class="fa-solid fa-user-group text-xl"></i>
                </button>
                <button onclick="switchTab(this, 'Profile')" class="flex flex-col items-center text-gray-400 hover:text-gray-600 transition p-2">
                    <i class="fa-regular fa-folder text-xl"></i>
                </button>
            </div>
            
            <div class="absolute bottom-1 left-1/2 -translate-x-1/2 w-32 h-1 bg-gray-800 rounded-full z-30 pointer-events-none md:block hidden"></div>
        </div>

        <!-- ================= DESKTOP WEB DASHBOARD VIEW ================= -->
        <div id="webDashboardView" class="w-full max-w-6xl bg-white rounded-3xl shadow-xl hidden flex-col overflow-hidden min-h-[840px] border border-gray-200">
            <!-- Web Header Topbar -->
            <div class="bg-gradient-to-r from-gray-900 to-zinc-800 text-white px-8 py-6 flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                <div class="flex items-center space-x-4">
                    <div class="w-14 h-14 rounded-2xl border-2 border-orange-500 p-1 flex items-center justify-center bg-orange-100 text-gray-700 overflow-hidden shadow-md">
                        <img src="https://placehold.co/100x100/orange/white?text=Admin" alt="Profile" class="w-full h-full rounded-xl object-cover">
                    </div>
                    <div>
                        <div class="flex items-center space-x-2">
                            <span class="bg-orange-500 text-white text-[10px] font-bold px-2 py-0.5 rounded uppercase tracking-wider">Web Portal</span>
                            <span class="text-xs text-gray-300">IMI Mobilitas Pusat</span>
                        </div>
                        <h1 class="text-2xl font-black tracking-tight mt-0.5">Dashboard Administrator & Member</h1>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <div class="relative">
                        <input type="text" placeholder="Cari layanan atau member..." class="bg-gray-800 text-sm text-white placeholder-gray-400 px-4 py-2 pl-10 rounded-xl border border-gray-700 focus:outline-none focus:border-orange-500 w-64">
                        <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-3 text-gray-400 text-xs"></i>
                    </div>
                    <button onclick="showNotificationModal()" class="w-10 h-10 rounded-xl bg-gray-800 hover:bg-gray-700 text-orange-400 flex items-center justify-center transition border border-gray-700">
                        <i class="fa-regular fa-bell text-lg"></i>
                    </button>
                    <button onclick="showServiceMessage('Pengaturan Akun')" class="w-10 h-10 rounded-xl bg-orange-500 hover:bg-orange-600 text-white flex items-center justify-center transition shadow-md">
                        <i class="fa-solid fa-gear"></i>
                    </button>
                </div>
            </div>

            <!-- Web Dashboard Content Body -->
            <div class="p-8 space-y-8 bg-gray-50 flex-1">
                <!-- Top Row: Stats & Quick Overview -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
                        <div>
                            <p class="text-xs text-gray-500 font-semibold uppercase">Total Keanggotaan</p>
                            <h3 class="text-2xl font-extrabold text-gray-900 mt-1">24,592</h3>
                            <span class="text-xs text-emerald-600 font-bold mt-1 inline-block"><i class="fa-solid fa-arrow-trend-up"></i> +12% bulan ini</span>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl">
                            <i class="fa-solid fa-users"></i>
                        </div>
                    </div>
                    <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
                        <div>
                            <p class="text-xs text-gray-500 font-semibold uppercase">Kartu Digital Aktif</p>
                            <h3 class="text-2xl font-extrabold text-gray-900 mt-1">19,840</h3>
                            <span class="text-xs text-emerald-600 font-bold mt-1 inline-block"><i class="fa-solid fa-circle-check"></i> 94% Valid</span>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-orange-50 text-orange-600 flex items-center justify-center text-xl">
                            <i class="fa-solid fa-id-card"></i>
                        </div>
                    </div>
                    <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
                        <div>
                            <p class="text-xs text-gray-500 font-semibold uppercase">Event & Kalender</p>
                            <h3 class="text-2xl font-extrabold text-gray-900 mt-1">14 Event</h3>
                            <span class="text-xs text-amber-600 font-bold mt-1 inline-block"><i class="fa-solid fa-calendar-day"></i> Segera Berlangsung</span>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl">
                            <i class="fa-solid fa-flag-checkered"></i>
                        </div>
                    </div>
                    <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
                        <div>
                            <p class="text-xs text-gray-500 font-semibold uppercase">Asuransi Perjalanan</p>
                            <h3 class="text-2xl font-extrabold text-gray-900 mt-1">Gaspol Active</h3>
                            <span class="text-xs text-blue-600 font-bold mt-1 inline-block"><i class="fa-solid fa-shield-halved"></i> Terproteksi</span>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-xl">
                            <i class="fa-solid fa-bolt"></i>
                        </div>
                    </div>
                </div>

                <!-- Middle Section: Membership Tier Grid for Web -->
                <div>
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Pilihan Paket Keanggotaan IMI Mobilitas</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Web Card 1 -->
                        <div class="bg-gradient-to-br from-cyan-400 to-blue-600 rounded-3xl p-6 text-white shadow-md relative overflow-hidden flex flex-col justify-between h-[220px]">
                            <div class="absolute -right-8 -bottom-8 w-36 h-36 bg-white/10 rounded-full pointer-events-none"></div>
                            <div>
                                <h2 class="text-2xl font-black tracking-wide">IMI MOBILITAS</h2>
                                <div class="mt-3 text-xs opacity-90 space-y-1 font-medium">
                                    <p class="font-semibold text-white/90">• Biaya Keanggotaan: <span class="text-base font-extrabold text-white">Rp 50,000/Tahun</span></p>
                                    <p>• Mendapatkan kartu digital resmi</p>
                                    <p>• Mendapatkan Asuransi kecelakaan diri</p>
                                </div>
                            </div>
                            <div>
                                <button onclick="openModal('IMI Mobilitas', 'Rp 50.000/Tahun')" class="bg-white text-blue-600 hover:bg-blue-50 font-bold text-xs px-5 py-2.5 rounded-full shadow transition">
                                    Daftar Paket Ini
                                </button>
                            </div>
                        </div>

                        <!-- Web Card 2 -->
                        <div class="bg-gradient-to-br from-gray-900 to-zinc-800 rounded-3xl p-6 text-white shadow-md relative overflow-hidden flex flex-col justify-between h-[220px]">
                            <div class="absolute -right-8 -bottom-8 w-36 h-36 bg-white/5 rounded-full pointer-events-none"></div>
                            <div>
                                <h2 class="text-2xl font-black tracking-wide">IMI PRO</h2>
                                <div class="mt-3 text-xs opacity-90 space-y-1 font-medium">
                                    <p class="font-semibold text-gray-300">• Biaya Keanggotaan: <span class="text-base font-extrabold text-white">Rp 150,000/Tahun</span></p>
                                    <p>• Kartu fisik & digital lengkap</p>
                                    <p>• Akses pembuatan KIS & TKT</p>
                                </div>
                            </div>
                            <div>
                                <button onclick="openModal('IMI PRO', 'Rp 150.000/Tahun')" class="bg-white text-gray-900 hover:bg-gray-100 font-bold text-xs px-5 py-2.5 rounded-full shadow transition">
                                    Daftar Paket Ini
                                </button>
                            </div>
                        </div>

                        <!-- Web Card 3 -->
                        <div class="bg-gradient-to-br from-amber-500 to-amber-700 rounded-3xl p-6 text-white shadow-md relative overflow-hidden flex flex-col justify-between h-[220px]">
                            <div class="absolute -right-8 -bottom-8 w-36 h-36 bg-white/10 rounded-full pointer-events-none"></div>
                            <div>
                                <h2 class="text-2xl font-black tracking-wide">IMI VIP</h2>
                                <div class="mt-3 text-xs opacity-90 space-y-1 font-medium">
                                    <p class="font-semibold text-amber-100">• Biaya Keanggotaan: <span class="text-base font-extrabold text-white">Rp 500,000/Tahun</span></p>
                                    <p>• Fasilitas eksklusif & Akses VIP Circuit</p>
                                    <p>• Asuransi VIP Premium komprehensif</p>
                                </div>
                            </div>
                            <div>
                                <button onclick="openModal('IMI VIP', 'Rp 500.000/Tahun')" class="bg-white text-amber-700 hover:bg-amber-50 font-bold text-xs px-5 py-2.5 rounded-full shadow transition">
                                    Daftar Paket Ini
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bottom Services Web Grid -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <h3 class="text-base font-bold text-gray-900 mb-4">Layanan & Fitur Web IMI Mobilitas</h3>
                    <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-8 gap-4">
                        <div onclick="showServiceMessage('Mitra')" class="flex flex-col items-center cursor-pointer group p-3 rounded-xl hover:bg-orange-50 transition">
                            <div class="w-12 h-12 rounded-xl bg-orange-100 text-orange-500 flex items-center justify-center text-xl shadow-sm">
                                <i class="fa-solid fa-handshake"></i>
                            </div>
                            <span class="text-xs font-semibold text-gray-700 mt-2 text-center">Mitra</span>
                        </div>
                        <div onclick="showServiceMessage('Merchandise')" class="flex flex-col items-center cursor-pointer group p-3 rounded-xl hover:bg-orange-50 transition">
                            <div class="w-12 h-12 rounded-xl bg-orange-100 text-orange-500 flex items-center justify-center text-xl shadow-sm">
                                <i class="fa-solid fa-shirt"></i>
                            </div>
                            <span class="text-xs font-semibold text-gray-700 mt-2 text-center">Merchandise</span>
                        </div>
                        <div onclick="showServiceMessage('Store')" class="flex flex-col items-center cursor-pointer group p-3 rounded-xl hover:bg-orange-50 transition">
                            <div class="w-12 h-12 rounded-xl bg-orange-100 text-orange-500 flex items-center justify-center text-xl shadow-sm">
                                <i class="fa-solid fa-store"></i>
                            </div>
                            <span class="text-xs font-semibold text-gray-700 mt-2 text-center">Store</span>
                        </div>
                        <div onclick="showServiceMessage('P1')" class="flex flex-col items-center cursor-pointer group p-3 rounded-xl hover:bg-orange-50 transition">
                            <div class="w-12 h-12 rounded-xl bg-orange-100 text-orange-500 flex items-center justify-center text-xl shadow-sm">
                                <i class="fa-solid fa-flag-checkered"></i>
                            </div>
                            <span class="text-xs font-semibold text-gray-700 mt-2 text-center">P1</span>
                        </div>
                        <div onclick="showServiceMessage('Audio / Podcast')" class="flex flex-col items-center cursor-pointer group p-3 rounded-xl hover:bg-orange-50 transition">
                            <div class="w-12 h-12 rounded-xl bg-orange-100 text-orange-500 flex items-center justify-center text-xl shadow-sm">
                                <i class="fa-solid fa-microphone"></i>
                            </div>
                            <span class="text-xs font-semibold text-gray-700 mt-2 text-center">Podcast</span>
                        </div>
                        <div onclick="showServiceMessage('Kalender Event')" class="flex flex-col items-center cursor-pointer group p-3 rounded-xl hover:bg-orange-50 transition">
                            <div class="w-12 h-12 rounded-xl bg-orange-100 text-orange-500 flex items-center justify-center text-xl shadow-sm">
                                <i class="fa-regular fa-calendar-days"></i>
                            </div>
                            <span class="text-xs font-semibold text-gray-700 mt-2 text-center">Kalender</span>
                        </div>
                        <div onclick="showServiceMessage('IMI TV / Streaming')" class="flex flex-col items-center cursor-pointer group p-3 rounded-xl hover:bg-orange-50 transition">
                            <div class="w-12 h-12 rounded-xl bg-orange-100 text-orange-500 flex items-center justify-center text-xl shadow-sm">
                                <i class="fa-solid fa-tv"></i>
                            </div>
                            <span class="text-xs font-semibold text-gray-700 mt-2 text-center">IMI TV</span>
                        </div>
                        <div onclick="showServiceMessage('Semua Menu')" class="flex flex-col items-center cursor-pointer group p-3 rounded-xl hover:bg-orange-50 transition">
                            <div class="w-12 h-12 rounded-xl bg-orange-500 text-white flex items-center justify-center text-xl shadow-md">
                                <i class="fa-solid fa-grip"></i>
                            </div>
                            <span class="text-xs font-semibold text-gray-700 mt-2 text-center">Lainnya</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- NOTIFICATION / MODAL DIALOG -->
    <div id="customModal" class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center px-4 hidden opacity-0 transition-opacity duration-300">
        <div class="bg-white rounded-3xl p-6 max-w-sm w-full shadow-2xl transform scale-95 transition-transform duration-300" id="modalContent">
            <div class="text-center">
                <div class="w-14 h-14 bg-orange-100 text-orange-500 rounded-full flex items-center justify-center mx-auto mb-3 text-2xl">
                    <i class="fa-solid fa-id-card"></i>
                </div>
                <h3 id="modalTitle" class="text-lg font-bold text-gray-900">Pendaftaran Keanggotaan</h3>
                <p id="modalDesc" class="text-sm text-gray-500 mt-1">Anda akan mendaftar keanggotaan paket ini.</p>
            </div>
            <div class="mt-6 flex space-x-3">
                <button onclick="closeModal()" class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-2.5 rounded-xl text-sm transition">Tutup</button>
                <button onclick="confirmAction()" class="flex-1 bg-orange-500 hover:bg-orange-600 text-white font-bold py-2.5 rounded-xl text-sm shadow-md transition">Lanjutkan</button>
            </div>
        </div>
    </div>

    <script>
        // Automatic Viewport Detection on load and resize
        function detectViewportAndSwitch() {
            const width = window.innerWidth;
            const androidView = document.getElementById('androidView');
            const webDashboardView = document.getElementById('webDashboardView');
            const currentModeText = document.getElementById('currentModeText');
            const badgeMode = document.getElementById('badgeMode');

            // Breakpoint at 768px (Tablet / Laptop boundary)
            if (width < 768) {
                // Mobile Viewport -> Show Android App Frame
                androidView.classList.remove('hidden');
                webDashboardView.classList.add('hidden');
                currentModeText.innerText = `Layar HP terdeteksi (${width}px): Mengaktifkan Tampilan Aplikasi Android`;
                badgeMode.innerText = "Mode Mobile App";
            } else {
                // Desktop / Laptop Viewport -> Show Web Dashboard View
                androidView.classList.add('hidden');
                webDashboardView.classList.remove('hidden');
                webDashboardView.classList.add('flex');
                currentModeText.innerText = `Layar Desktop/Laptop terdeteksi (${width}px): Mengaktifkan Tampilan Dashboard Web Full-Width`;
                badgeMode.innerText = "Mode Web Dashboard";
            }
        }

        // Run on load
        window.addEventListener('load', detectViewportAndSwitch);
        // Run on window resize dynamically
        window.addEventListener('resize', detectViewportAndSwitch);

        // Mobile slider dots
        const slider = document.getElementById('cardSlider');
        const dots = document.querySelectorAll('.dot');

        if (slider) {
            slider.addEventListener('scroll', () => {
                const scrollLeft = slider.scrollLeft;
                const cardWidth = slider.clientWidth * 0.82;
                const index = Math.round(scrollLeft / cardWidth);
                
                dots.forEach((dot, i) => {
                    if (i === index) {
                        dot.classList.remove('w-2', 'bg-gray-300');
                        dot.classList.add('w-5', 'bg-orange-500');
                    } else {
                        dot.classList.remove('w-5', 'bg-orange-500');
                        dot.classList.add('w-2', 'bg-gray-300');
                    }
                });
            });
        }

        function scrollToCard(index) {
            const cardWidth = slider.clientWidth * 0.82;
            slider.scrollTo({
                left: cardWidth * index,
                behavior: 'smooth'
            });
        }

        // Modal interactions
        const modal = document.getElementById('customModal');
        const modalContent = document.getElementById('modalContent');
        const modalTitle = document.getElementById('modalTitle');
        const modalDesc = document.getElementById('modalDesc');

        function openModal(packageName, price) {
            modalTitle.innerText = `Pendaftaran ${packageName}`;
            modalDesc.innerText = `Biaya keanggotaan sebesar ${price}. Lanjutkan proses pendaftaran kartu digital IMI?`;
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
            modalDesc.innerText = `Fitur ${serviceName} akan segera tersedia untuk Anda gunakan.`;
            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                modalContent.classList.remove('scale-95');
                modalContent.classList.add('scale-100');
            }, 10);
        }

        function showNotificationModal() {
            modalTitle.innerText = "Notifikasi Terbaru";
            modalDesc.innerText = "Tidak ada pemberitahuan baru saat ini. Pastikan keanggotaan Anda aktif.";
            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                modalContent.classList.remove('scale-95');
                modalContent.classList.add('scale-100');
            }, 10);
        }

        function confirmAction() {
            closeModal();
            alertCustom("Berhasil! Silakan lengkapi data diri Anda untuk penerbitan kartu.");
        }

        function alertCustom(message) {
            modalTitle.innerText = "Informasi Sistem";
            modalDesc.innerText = message;
            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                modalContent.classList.remove('scale-100');
                modalContent.classList.add('scale-100');
            }, 10);
        }

        function switchTab(button, tabName) {
            const navButtons = document.querySelectorAll('#androidView div.absolute.bottom-0 button');
            navButtons.forEach(btn => {
                const icon = btn.querySelector('i').outerHTML;
                btn.innerHTML = icon;
                btn.className = "flex flex-col items-center text-gray-400 hover:text-gray-600 transition p-2";
            });

            const iconHTML = button.querySelector('i').outerHTML;
            button.innerHTML = `
                <div class="bg-orange-500 text-white px-4 py-1.5 rounded-full flex items-center space-x-1.5 shadow-sm">
                    ${iconHTML}
                    <span class="text-xs font-bold">${tabName}</span>
                </div>
            `;
            button.className = "flex flex-col items-center text-orange-500 transition active-tab";
        }
    </script>
</body>
</html>