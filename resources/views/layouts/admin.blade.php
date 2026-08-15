<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{
    darkMode: localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches),
    sidebarOpen: true,
    mobileSidebarOpen: false,
    notificationsOpen: false,
    userMenuOpen: false
}" :class="{ 'dark': darkMode }"
    x-init="$watch('darkMode', val => localStorage.setItem('theme', val ? 'dark' : 'light'))">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>BAKUMDA - @yield('title', config('app.name', 'Dashboard'))</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300..800;1,300..800&display=swap"
        rel="stylesheet">

    <!-- CDN Tailwind CSS & AlpineJS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#f0f6ff',
                            100: '#e0eef9',
                            400: '#38bdf8',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                        }
                    }
                }
            }
        }
    </script>
    <!-- Alpine.js Collapse Plugin + Core -->
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    <style>
        /* Custom scrollbar yang lebih minimalis & halus */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: rgba(148, 163, 184, 0.2);
            border-radius: 9999px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: rgba(148, 163, 184, 0.4);
        }
    </style>

    @stack('styles')
</head>

<body
    class="font-sans antialiased bg-slate-50 text-slate-900 dark:bg-[#030712] dark:text-slate-100 transition-colors duration-300 selection:bg-brand-500 selection:text-white">

    <!-- Ubah min-h-screen menjadi h-screen dan overflow-hidden agar layar terkunci tanpa scroll body utama -->
    <div class="h-screen flex flex-col md:flex-row overflow-hidden">

        <!-- Overlay untuk Mobile Sidebar -->
        <div x-show="mobileSidebarOpen" x-transition:enter="transition-opacity ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-in duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" @click="mobileSidebarOpen = false"
            class="fixed inset-0 z-40 bg-slate-950/60 backdrop-blur-sm md:hidden" style="display: none;"></div>

        <!-- Sidebar Navigation -->
        <aside
            class="flex-shrink-0 h-full overflow-y-auto fixed inset-y-0 left-0 z-50 flex flex-col transition-all duration-300 ease-in-out bg-white/80 dark:bg-[#0b0f19]/90 backdrop-blur-xl border-r border-slate-200/80 dark:border-slate-800/80 shadow-xl md:shadow-none md:static md:translate-x-0"
            :class="{
                'translate-x-0': mobileSidebarOpen,
                '-translate-x-full': !mobileSidebarOpen,
                'w-72': sidebarOpen,
                'w-20': !sidebarOpen
            }">

            <!-- Sidebar Header / Logo -->
            <div
                class="h-20 flex items-center justify-between px-6 border-b border-slate-100 dark:border-slate-800/60 flex-shrink-0">
                <a href="{{ url('/') }}" class="flex items-center gap-3.5 overflow-hidden group">
                    <div
                        class="flex items-center justify-center min-w-[40px] h-[40px] rounded-xl bg-brand-500/10 dark:bg-brand-500/20 text-brand-600 dark:text-brand-400 group-hover:scale-105 transition-transform">
                        <img src="{{ asset('bakumda.png') }}" alt="Logo Maharadja"
                            class="w-9 h-9 object-contain rounded-lg">
                    </div>
                    <div x-show="sidebarOpen" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                        class="flex flex-col whitespace-nowrap">
                        <span class="font-bold text-sm tracking-tight text-slate-900 dark:text-white">
                            BAKUMDA
                        </span>
                        <span
                            class="text-[10px] font-semibold uppercase tracking-widest text-brand-600 dark:text-brand-400">Workspace</span>
                    </div>
                </a>
                <button @click="sidebarOpen = !sidebarOpen"
                    class="hidden md:flex items-center justify-center text-slate-400 hover:text-slate-600 dark:hover:text-white w-7 h-7 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800/60 transition-colors">
                    <i class="fa-solid text-xs transition-transform duration-300"
                        :class="sidebarOpen ? 'fa-chevron-left' : 'fa-chevron-right'"></i>
                </button>
            </div>

            <!-- Navigation Links -->
            <div class="flex-1 overflow-y-auto px-4 py-6 space-y-1.5">

                <!-- Group Title -->
                <p x-show="sidebarOpen"
                    class="px-3 text-[10px] font-bold uppercase tracking-widest text-slate-400 dark:text-slate-500 mb-3">
                    Menu Utama</p>

                <!-- Dashboard Link -->
                @php $isDashboardActive = request()->is('dashboard') || request()->routeIs('dashboard'); @endphp
                <a href="/dashboard"
                    class="flex items-center gap-3.5 px-3.5 py-3 rounded-xl transition-all duration-200 group relative {{ $isDashboardActive ? 'font-semibold text-brand-600 bg-brand-50/80 dark:bg-brand-500/15 dark:text-brand-400 shadow-sm' : 'font-medium text-slate-600 hover:text-slate-900 hover:bg-slate-100/60 dark:text-slate-400 dark:hover:text-slate-100 dark:hover:bg-slate-800/40' }}">
                    <div class="absolute left-0 w-1 h-5 bg-brand-600 dark:bg-brand-400 rounded-r-full"
                        x-show="sidebarOpen && {{ $isDashboardActive ? 'true' : 'false' }}"></div>
                    <i
                        class="fa-solid fa-chart-pie text-sm w-5 text-center transition-transform group-hover:scale-110"></i>
                    <span x-show="sidebarOpen" class="whitespace-nowrap text-xs tracking-wide">Dashboard</span>
                </a>

                @can('anggota-view')
                    <!-- Data Anggota -->
                    @php $isAnggotaActive = request()->routeIs('admin.anggota.*'); @endphp
                    <a href="{{ route('admin.anggota.index') }}"
                        class="flex items-center gap-3.5 px-3.5 py-3 rounded-xl transition-all duration-200 group relative {{ $isAnggotaActive ? 'font-semibold text-brand-600 bg-brand-50/80 dark:bg-brand-500/15 dark:text-brand-400 shadow-sm' : 'font-medium text-slate-600 hover:text-slate-900 hover:bg-slate-100/60 dark:text-slate-400 dark:hover:text-slate-100 dark:hover:bg-slate-800/40' }}">
                        <div class="absolute left-0 w-1 h-5 bg-brand-600 dark:bg-brand-400 rounded-r-full"
                            x-show="sidebarOpen && {{ $isAnggotaActive ? 'true' : 'false' }}"></div>
                        <i class="fa-solid fa-users text-sm w-5 text-center transition-transform group-hover:scale-110"></i>
                        <span x-show="sidebarOpen" class="whitespace-nowrap text-xs tracking-wide">Data Anggota</span>
                    </a>
                @endcan

                @can('kartu-anggota-view')
                    <!-- Kartu Anggota -->
                    @php $isKartuActive = request()->routeIs('admin.anggota-card.*'); @endphp
                    <a href="{{ route('admin.anggota-card.index') }}"
                        class="flex items-center gap-3.5 px-3.5 py-3 rounded-xl transition-all duration-200 group relative {{ $isKartuActive ? 'font-semibold text-brand-600 bg-brand-50/80 dark:bg-brand-500/15 dark:text-brand-400 shadow-sm' : 'font-medium text-slate-600 hover:text-slate-900 hover:bg-slate-100/60 dark:text-slate-400 dark:hover:text-slate-100 dark:hover:bg-slate-800/40' }}">
                        <div class="absolute left-0 w-1 h-5 bg-brand-600 dark:bg-brand-400 rounded-r-full"
                            x-show="sidebarOpen && {{ $isKartuActive ? 'true' : 'false' }}"></div>
                        <i
                            class="fa-solid fa-address-card text-sm w-5 text-center transition-transform group-hover:scale-110"></i>
                        <span x-show="sidebarOpen" class="whitespace-nowrap text-xs tracking-wide">Kartu Anggota</span>
                    </a>
                @endcan

                @can('pelatihan-view')
                    <!-- Pelatihan -->
                    @php $isPelatihanActive = request()->routeIs('admin.pelatihan.*'); @endphp
                    <a href="{{ route('admin.pelatihan.index') }}"
                        class="flex items-center gap-3.5 px-3.5 py-3 rounded-xl transition-all duration-200 group relative {{ $isPelatihanActive ? 'font-semibold text-brand-600 bg-brand-50/80 dark:bg-brand-500/15 dark:text-brand-400 shadow-sm' : 'font-medium text-slate-600 hover:text-slate-900 hover:bg-slate-100/60 dark:text-slate-400 dark:hover:text-slate-100 dark:hover:bg-slate-800/40' }}">
                        <div class="absolute left-0 w-1 h-5 bg-brand-600 dark:bg-brand-400 rounded-r-full"
                            x-show="sidebarOpen && {{ $isPelatihanActive ? 'true' : 'false' }}"></div>
                        <i
                            class="fa-solid fa-chalkboard-user text-sm w-5 text-center transition-transform group-hover:scale-110"></i>
                        <span x-show="sidebarOpen" class="whitespace-nowrap text-xs tracking-wide">Manajemen
                            Pelatihan</span>
                    </a>
                @endcan

                @can('pelatihan-anggota-view')
                    <!-- Verifikasi Pembayaran -->
                    @php $isPelatihanAnggotaActive = request()->routeIs('admin.pelatihan-anggota.*'); @endphp
                    <a href="{{ route('admin.pelatihan-anggota.index') }}"
                        class="flex items-center gap-3.5 px-3.5 py-3 rounded-xl transition-all duration-200 group relative {{ $isPelatihanAnggotaActive ? 'font-semibold text-brand-600 bg-brand-50/80 dark:bg-brand-500/15 dark:text-brand-400 shadow-sm' : 'font-medium text-slate-600 hover:text-slate-900 hover:bg-slate-100/60 dark:text-slate-400 dark:hover:text-slate-100 dark:hover:bg-slate-800/40' }}">
                        <div class="absolute left-0 w-1 h-5 bg-brand-600 dark:bg-brand-400 rounded-r-full"
                            x-show="sidebarOpen && {{ $isPelatihanAnggotaActive ? 'true' : 'false' }}"></div>
                        <i
                            class="fa-solid fa-money-check-dollar text-sm w-5 text-center transition-transform group-hover:scale-110"></i>
                        <span x-show="sidebarOpen" class="whitespace-nowrap text-xs tracking-wide">Verifikasi
                            Pembayaran</span>
                    </a>
                @endcan

                @can('produk-view')
                    <!-- Produk -->
                    @php $isProdukActive = request()->routeIs('admin.produk.*'); @endphp
                    <a href="{{ route('admin.produk.index') }}"
                        class="flex items-center gap-3.5 px-3.5 py-3 rounded-xl transition-all duration-200 group relative {{ $isProdukActive ? 'font-semibold text-brand-600 bg-brand-50/80 dark:bg-brand-500/15 dark:text-brand-400 shadow-sm' : 'font-medium text-slate-600 hover:text-slate-900 hover:bg-slate-100/60 dark:text-slate-400 dark:hover:text-slate-100 dark:hover:bg-slate-800/40' }}">
                        <div class="absolute left-0 w-1 h-5 bg-brand-600 dark:bg-brand-400 rounded-r-full"
                            x-show="sidebarOpen && {{ $isProdukActive ? 'true' : 'false' }}"></div>
                        <i
                            class="fa-solid fa-store text-sm w-5 text-center transition-transform group-hover:scale-110"></i>
                        <span x-show="sidebarOpen" class="whitespace-nowrap text-xs tracking-wide">Manajemen Produk</span>
                    </a>
                @endcan

                @can('surat-view')
                    <!-- Surat -->
                    @php $isSuratActive = request()->is('admin/surat*'); @endphp
                    <a href="/admin/surat"
                        class="flex items-center gap-3.5 px-3.5 py-3 rounded-xl transition-all duration-200 group relative {{ $isSuratActive ? 'font-semibold text-brand-600 bg-brand-50/80 dark:bg-brand-500/15 dark:text-brand-400 shadow-sm' : 'font-medium text-slate-600 hover:text-slate-900 hover:bg-slate-100/60 dark:text-slate-400 dark:hover:text-slate-100 dark:hover:bg-slate-800/40' }}">
                        <div class="absolute left-0 w-1 h-5 bg-brand-600 dark:bg-brand-400 rounded-r-full"
                            x-show="sidebarOpen && {{ $isSuratActive ? 'true' : 'false' }}"></div>
                        <i
                            class="fa-solid fa-envelope-open-text text-sm w-5 text-center transition-transform group-hover:scale-110"></i>
                        <span x-show="sidebarOpen" class="whitespace-nowrap text-xs tracking-wide">Manajemen Surat</span>
                    </a>
                @endcan

                @can('pelatihan-pembayaran-view')
                    <!-- Pelatihan Payment -->
                    @php $isPelatihanPaymentActive = request()->routeIs('pelatihan-anggota.*'); @endphp
                    <a href="{{ route('admin.pelatihan-anggota.index') }}"
                        class="flex items-center gap-3.5 px-3.5 py-3 rounded-xl transition-all duration-200 group relative {{ $isPelatihanPaymentActive ? 'font-semibold text-brand-600 bg-brand-50/80 dark:bg-brand-500/15 dark:text-brand-400 shadow-sm' : 'font-medium text-slate-600 hover:text-slate-900 hover:bg-slate-100/60 dark:text-slate-400 dark:hover:text-slate-100 dark:hover:bg-slate-800/40' }}">
                        <div class="absolute left-0 w-1 h-5 bg-brand-600 dark:bg-brand-400 rounded-r-full"
                            x-show="sidebarOpen && {{ $isPelatihanPaymentActive ? 'true' : 'false' }}"></div>
                        <i
                            class="fa-solid fa-file-invoice-dollar text-sm w-5 text-center transition-transform group-hover:scale-110"></i>
                        <span x-show="sidebarOpen" class="whitespace-nowrap text-xs tracking-wide">Pelatihan Payment</span>
                    </a>
                @endcan

                @can('user-pelatihan-view')
                    <!-- Pelatihan Saya (User) -->
                    @php $isUserPelatihanActive = request()->routeIs('user-pelatihan.*'); @endphp
                    <a href="{{ route('user-pelatihan.index') }}"
                        class="flex items-center gap-3.5 px-3.5 py-3 rounded-xl transition-all duration-200 group relative {{ $isUserPelatihanActive ? 'font-semibold text-brand-600 bg-brand-50/80 dark:bg-brand-500/15 dark:text-brand-400 shadow-sm' : 'font-medium text-slate-600 hover:text-slate-900 hover:bg-slate-100/60 dark:text-slate-400 dark:hover:text-slate-100 dark:hover:bg-slate-800/40' }}">
                        <div class="absolute left-0 w-1 h-5 bg-brand-600 dark:bg-brand-400 rounded-r-full"
                            x-show="sidebarOpen && {{ $isUserPelatihanActive ? 'true' : 'false' }}"></div>
                        <i
                            class="fa-solid fa-book-open-reader text-sm w-5 text-center transition-transform group-hover:scale-110"></i>
                        <span x-show="sidebarOpen" class="whitespace-nowrap text-xs tracking-wide">Pelatihan</span>
                    </a>
                @endcan

                @can('keanggotaan-view')
                    <!-- Keanggotaan Saya (User) -->
                    @php $isUserAnggotaActive = request()->routeIs('user-anggota.*'); @endphp
                    <a href="{{ route('user-anggota.index') }}"
                        class="flex items-center gap-3.5 px-3.5 py-3 rounded-xl transition-all duration-200 group relative {{ $isUserAnggotaActive ? 'font-semibold text-brand-600 bg-brand-50/80 dark:bg-brand-500/15 dark:text-brand-400 shadow-sm' : 'font-medium text-slate-600 hover:text-slate-900 hover:bg-slate-100/60 dark:text-slate-400 dark:hover:text-slate-100 dark:hover:bg-slate-800/40' }}">
                        <div class="absolute left-0 w-1 h-5 bg-brand-600 dark:bg-brand-400 rounded-r-full"
                            x-show="sidebarOpen && {{ $isUserAnggotaActive ? 'true' : 'false' }}"></div>
                        <i
                            class="fa-solid fa-id-badge text-sm w-5 text-center transition-transform group-hover:scale-110"></i>
                        <span x-show="sidebarOpen" class="whitespace-nowrap text-xs tracking-wide">Kartu
                            Keanggotaan</span>
                    </a>
                @endcan

                <!-- Sertifikasi -->
                @can('sertifikat-view')
                    @php $isSertifikasiActive = request()->is('pelatihan-sertifikat*'); @endphp
                    <a href="{{ route('sertifikat.index') }}"
                        class="flex items-center gap-3.5 px-3.5 py-3 rounded-xl transition-all duration-200 group relative {{ $isSertifikasiActive ? 'font-semibold text-brand-600 bg-brand-50/80 dark:bg-brand-500/15 dark:text-brand-400 shadow-sm' : 'font-medium text-slate-600 hover:text-slate-900 hover:bg-slate-100/60 dark:text-slate-400 dark:hover:text-slate-100 dark:hover:bg-slate-800/40' }}">
                        <div class="absolute left-0 w-1 h-5 bg-brand-600 dark:bg-brand-400 rounded-r-full"
                            x-show="sidebarOpen && {{ $isSertifikasiActive ? 'true' : 'false' }}"></div>
                        <i
                            class="fa-solid fa-award text-sm w-5 text-center transition-transform group-hover:scale-110"></i>
                        <span x-show="sidebarOpen" class="whitespace-nowrap text-xs tracking-wide">Sertifikasi</span>
                    </a>
                @endcan

                {{-- <div class="pt-4"></div>
                <p x-show="sidebarOpen"
                    class="px-3 text-[10px] font-bold uppercase tracking-widest text-slate-400 dark:text-slate-500 mb-3">
                    Pengaturan Sistem</p> --}}

                <!-- Dropdown Manajemen User -->
                @canany(['user-view', 'role-view'])
                    @php $isUserManagementActive = request()->routeIs('admin.users.*') || request()->routeIs('admin.role.*'); @endphp
                    <div x-data="{ userManagementOpen: {{ $isUserManagementActive ? 'true' : 'false' }} }">
                        <button @click="userManagementOpen = !userManagementOpen"
                            class="w-full flex items-center justify-between gap-3.5 px-3.5 py-3 rounded-xl transition-all duration-200 group {{ $isUserManagementActive ? 'font-semibold text-brand-600 bg-brand-50/50 dark:bg-brand-500/10 dark:text-brand-400' : 'font-medium text-slate-600 hover:text-slate-900 hover:bg-slate-100/60 dark:text-slate-400 dark:hover:text-slate-100 dark:hover:bg-slate-800/40' }}">
                            <div class="flex items-center gap-3.5">
                                <i
                                    class="fa-solid fa-users-gear text-sm w-5 text-center transition-transform group-hover:scale-110"></i>
                                <span x-show="sidebarOpen" class="whitespace-nowrap text-xs tracking-wide">Manajemen
                                    User</span>
                            </div>
                            <i x-show="sidebarOpen"
                                class="fa-solid fa-chevron-down text-[10px] text-slate-400 transition-transform duration-200"
                                :class="{ 'rotate-180': userManagementOpen }"></i>
                        </button>

                        <div x-show="userManagementOpen" x-collapse class="pt-1.5 pl-4 space-y-1">
                            @can('user-view')
                                @php $isDaftarUserActive = request()->routeIs('admin.users.*'); @endphp
                                <a href="{{ route('admin.users.index') }}"
                                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-xs transition-colors {{ $isDaftarUserActive ? 'font-bold text-brand-600 bg-brand-50/80 dark:bg-brand-500/20 dark:text-brand-400' : 'font-medium text-slate-500 hover:text-slate-900 hover:bg-slate-100/60 dark:text-slate-400 dark:hover:text-slate-200 dark:hover:bg-slate-800/40' }}">
                                    <i class="fa-solid fa-user-group w-4 text-center"></i>
                                    <span x-show="sidebarOpen" class="whitespace-nowrap">Daftar User</span>
                                </a>
                            @endcan

                            @can('role-view')
                                @php $isRoleActive = request()->routeIs('admin.role.*'); @endphp
                                <a href="{{ route('admin.role.index') }}"
                                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-xs transition-colors {{ $isRoleActive ? 'font-bold text-brand-600 bg-brand-50/80 dark:bg-brand-500/20 dark:text-brand-400' : 'font-medium text-slate-500 hover:text-slate-900 hover:bg-slate-100/60 dark:text-slate-400 dark:hover:text-slate-200 dark:hover:bg-slate-800/40' }}">
                                    <i class="fa-solid fa-shield-halved w-4 text-center"></i>
                                    <span x-show="sidebarOpen" class="whitespace-nowrap">Role & Permission</span>
                                </a>
                            @endcan
                        </div>
                    </div>
                @endcanany

                @php $isPengaturanActive = request()->is('pengaturan*'); @endphp
                {{-- <a href="#"
                    class="flex items-center gap-3.5 px-3.5 py-3 rounded-xl transition-all duration-200 group relative {{ $isPengaturanActive ? 'font-semibold text-brand-600 bg-brand-50/80 dark:bg-brand-500/15 dark:text-brand-400 shadow-sm' : 'font-medium text-slate-600 hover:text-slate-900 hover:bg-slate-100/60 dark:text-slate-400 dark:hover:text-slate-100 dark:hover:bg-slate-800/40' }}">
                    <div class="absolute left-0 w-1 h-5 bg-brand-600 dark:bg-brand-400 rounded-r-full"
                        x-show="sidebarOpen && {{ $isPengaturanActive ? 'true' : 'false' }}"></div>
                    <i
                        class="fa-solid fa-sliders text-sm w-5 text-center transition-transform group-hover:scale-110"></i>
                    <span x-show="sidebarOpen" class="whitespace-nowrap text-xs tracking-wide">Pengaturan</span>
                </a> --}}
            </div>

            <!-- Sidebar Footer -->
            <div class="p-4 border-t border-slate-100 dark:border-slate-800/60 flex-shrink-0">
                <div
                    class="px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-900/50 border border-slate-200/60 dark:border-slate-800 transition-all">
                    <div class="flex items-center gap-3.5">
                        <i
                            class="fa-regular fa-envelope text-sm w-5 text-center text-slate-400 dark:text-slate-500 shrink-0"></i>
                        <span x-show="sidebarOpen"
                            class="whitespace-nowrap text-xs tracking-wide text-slate-600 dark:text-slate-300 truncate"
                            title="{{ Auth::user()->email ?? 'email@domain.com' }}">
                            {{ Auth::user()->email ?? 'email@domain.com' }}
                        </span>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Wrapper -->
        <div class="flex-1 flex flex-col min-w-0 h-full overflow-hidden">

            <!-- Top Navbar -->
            <header
                class="h-20 bg-white/70 dark:bg-[#0b0f19]/70 backdrop-blur-xl border-b border-slate-200/80 dark:border-slate-800/80 flex items-center justify-between px-6 lg:px-8 flex-shrink-0 transition-colors z-30">

                <!-- Left Section: Mobile Toggle & Search -->
                <div class="flex items-center gap-4">
                    <button @click="mobileSidebarOpen = !mobileSidebarOpen"
                        class="md:hidden text-slate-600 dark:text-slate-300 p-2 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800/60 transition-colors">
                        <i class="fa-solid fa-bars text-base"></i>
                    </button>

                    <div class="relative hidden sm:block w-72 lg:w-80">
                        <i
                            class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                        <input type="text" placeholder="Cari menu, data, atau laporan..."
                            class="w-full pl-10 pr-4 py-2 text-xs rounded-xl bg-slate-100/60 dark:bg-slate-900/60 text-slate-800 dark:text-slate-100 border border-slate-200/60 dark:border-slate-800 focus:border-brand-500 focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-brand-500/20 outline-none transition-all">
                    </div>
                </div>

                <!-- Right Section: Actions & Avatar -->
                <div class="flex items-center gap-3">

                    <!-- Dark Mode Toggle -->
                    <button @click="darkMode = !darkMode"
                        class="p-2.5 text-slate-600 dark:text-slate-300 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800/65 transition-all duration-200 border border-slate-200/60 dark:border-slate-800"
                        title="Ganti Tema">
                        <i class="fa-solid text-xs" :class="darkMode ? 'fa-sun text-amber-400' : 'fa-moon'"></i>
                    </button>

                    <!-- Notifications Dropdown (Updated with Dynamic Data) -->
                    <div class="relative" @click.outside="notificationsOpen = false">
                        <button @click="notificationsOpen = !notificationsOpen"
                            class="relative p-2.5 text-slate-600 dark:text-slate-300 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800/65 transition-colors border border-slate-200/60 dark:border-slate-800">
                            <i class="fa-regular fa-bell text-xs"></i>
                            @php
                                $unreadNotifCount = Auth::user()
                                    ? \App\Models\Notification::where('user_id', Auth::id())
                                        ->whereNull('read_at')
                                        ->count()
                                    : 0;
                            @endphp
                            @if ($unreadNotifCount > 0)
                                <span
                                    class="absolute top-2 right-2 w-2 h-2 bg-rose-500 rounded-full ring-2 ring-white dark:ring-slate-950 animate-pulse"></span>
                            @endif
                        </button>

                        <div x-show="notificationsOpen" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                            x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                            class="absolute right-0 mt-3 w-80 bg-white dark:bg-[#111827] rounded-2xl shadow-xl border border-slate-200/80 dark:border-slate-800 py-3 z-50 overflow-hidden"
                            style="display: none;">

                            <div
                                class="px-4 py-2 border-b border-slate-100 dark:border-slate-800 flex justify-between items-center">
                                <h3
                                    class="font-bold text-[11px] uppercase tracking-wider text-slate-700 dark:text-slate-200">
                                    Notifikasi
                                </h3>
                                @if ($unreadNotifCount > 0)
                                    <form action="{{ route('notifications.readAll') ?? '#' }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="text-[11px] text-brand-600 dark:text-brand-400 font-semibold hover:underline cursor-pointer bg-transparent border-0 p-0">
                                            Tandai dibaca
                                        </button>
                                    </form>
                                @endif
                            </div>

                            <div class="max-h-72 overflow-y-auto divide-y divide-slate-100 dark:divide-slate-800/50">
                                @php
                                    $notifications = Auth::user()
                                        ? \App\Models\Notification::where('user_id', Auth::id())
                                            ->latest()
                                            ->take(5)
                                            ->get()
                                        : collect();
                                @endphp

                                @forelse($notifications as $notification)
                                    <a href="{{ route('notifications.read', $notification->id) }}"
                                        class="flex gap-3 px-4 py-3 hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors {{ is_null($notification->read_at) ? 'bg-brand-50/30 dark:bg-brand-500/5' : '' }}">
                                        <div
                                            class="w-8 h-8 rounded-xl bg-brand-50 text-brand-600 dark:bg-brand-500/20 dark:text-brand-400 flex items-center justify-center shrink-0">
                                            <i class="fa-solid fa-circle-info text-xs"></i>
                                        </div>
                                        <div class="text-xs flex-1">
                                            <p class="font-semibold text-slate-800 dark:text-slate-200">
                                                {{ $notification->title ?? 'Notifikasi Baru' }}
                                            </p>
                                            <p
                                                class="text-slate-500 dark:text-slate-400 mt-0.5 text-[11px] leading-relaxed">
                                                {{ $notification->message ?? '' }}
                                            </p>
                                            <p class="text-slate-400 mt-1 text-[10px]">
                                                {{ $notification->created_at->diffForHumans() }}
                                            </p>
                                        </div>
                                    </a>
                                @empty
                                    <div class="px-4 py-6 text-center text-xs text-slate-400 dark:text-slate-500">
                                        <i class="fa-regular fa-bell-slash text-base mb-1 block"></i>
                                        Belum ada notifikasi
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <div class="h-5 w-px bg-slate-200 dark:bg-slate-800 mx-1"></div>

                    <!-- User Profile Dropdown -->
                    <div class="relative" @click.outside="userMenuOpen = false">
                        @php
                            $fotoAnggota = optional(Auth::user()->anggota)->foto;
                            $defaultAvatar =
                                'https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=256&auto=format&fit=crop';
                            $avatarUrl = $fotoAnggota ? asset('storage/' . $fotoAnggota) : $defaultAvatar;
                        @endphp
                        <button @click="userMenuOpen = !userMenuOpen"
                            class="flex items-center gap-2.5 p-1.5 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800/65 transition-colors border border-slate-200/60 dark:border-slate-800">
                            <div class="relative">
                                <img class="w-8 h-8 rounded-lg object-cover ring-2 ring-brand-500/20"
                                    src="{{ $avatarUrl }}" alt="Avatar Pengguna">
                                <span
                                    class="absolute bottom-0 right-0 w-2 h-2 bg-emerald-500 rounded-full ring-2 ring-white dark:ring-slate-950"></span>
                            </div>
                            <div class="hidden md:block text-left pr-1">
                                <p class="text-xs font-bold text-slate-800 dark:text-slate-100 leading-tight">
                                    {{ Auth::user()->name ?? 'Administrator' }}</p>
                                <p class="text-[10px] font-medium text-slate-500 dark:text-slate-400 mt-0.5">
                                    @php
                                        $user = Auth::user();
                                        $roles = $user ? $user->getRoleNames() : collect();
                                    @endphp

                                    @if ($roles->contains('anggota'))
                                        @php
                                            $sudahMendaftarAnggota =
                                                optional($user->anggota)->status_keanggotaan === 'aktif' ||
                                                (method_exists($user, 'isAnggotaResmi') && $user->isAnggotaResmi());
                                            $sudahIkutPelatihan = method_exists($user, 'pelatihans')
                                                ? $user->pelatihans()->count() > 0
                                                : false;
                                        @endphp

                                        @if ($sudahMendaftarAnggota)
                                            Anggota
                                        @elseif($sudahIkutPelatihan)
                                            Calon Anggota
                                        @else
                                            Calon Peserta
                                        @endif
                                    @else
                                        {{ $roles->implode(', ') ?: 'User' }}
                                    @endif
                                </p>
                            </div>
                            <i class="fa-solid fa-chevron-down text-[10px] text-slate-400 hidden md:block px-1"></i>
                        </button>

                        <div x-show="userMenuOpen" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                            x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                            class="absolute right-0 mt-3 w-52 bg-white dark:bg-[#111827] rounded-2xl shadow-xl border border-slate-200/80 dark:border-slate-800 py-2 z-50 overflow-hidden"
                            style="display: none;">
                            <div class="px-4 py-2 border-b border-slate-100 dark:border-slate-800 md:hidden">
                                <p class="text-xs font-bold text-slate-800 dark:text-slate-100">
                                    {{ Auth::user()->name ?? 'Administrator' }}</p>
                                <p class="text-[10px] text-slate-400">{{ Auth::user()->email ?? 'admin@domain.com' }}
                                </p>
                            </div>
                            <a href="{{ route('profile.edit') }}"
                                class="flex items-center gap-3 px-4 py-2 text-xs font-medium text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                                <i class="fa-regular fa-user text-slate-400 w-4"></i> Profil Saya
                            </a>
                            <div class="my-1 border-t border-slate-100 dark:border-slate-800"></div>
                            <form method="POST" action="{{ route('logout') ?? '#' }}">
                                @csrf
                                <button type="submit"
                                    class="w-full flex items-center gap-3 px-4 py-2 text-xs font-semibold text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-950/40 transition-colors">
                                    <i class="fa-solid fa-arrow-right-from-bracket w-4"></i> Keluar
                                </button>
                            </form>
                        </div>
                    </div>

                </div>
            </header>
            <!-- Scrollable Content Area -->
            <div class="flex-1 overflow-y-auto flex flex-col justify-between">

                <main class="p-6 lg:p-8 custom-scrollbar">

                    <!-- Page Header -->
                    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <h1 class="text-xl sm:text-2xl font-bold text-slate-900 dark:text-white tracking-tight">
                                @yield('page-title')
                            </h1>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                                @yield('page-subtitle')
                            </p>
                        </div>
                        <div>
                            @yield('page-actions')
                        </div>
                    </div>

                    <!-- Main Section Blade Yield -->
                    @hasSection('content')
                        @yield('content')
                    @else
                        <!-- Fallback / Preview Content Mockup -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

                            <div
                                class="bg-white dark:bg-[#111827]/80 backdrop-blur-xl p-6 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-sm flex items-center justify-between group hover:border-brand-500/50 transition-all">
                                <div>
                                    <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Total
                                        Pendapatan</p>
                                    <p class="text-xl font-bold mt-1 text-slate-800 dark:text-slate-100">Rp 45.250.000
                                    </p>
                                    <span
                                        class="text-[11px] font-semibold text-emerald-500 flex items-center gap-1 mt-2">
                                        <i class="fa-solid fa-arrow-trend-up"></i> +12.5% bulan ini
                                    </span>
                                </div>
                                <div
                                    class="w-12 h-12 rounded-2xl bg-brand-500/10 text-brand-600 dark:text-brand-400 flex items-center justify-center group-hover:scale-110 transition-transform">
                                    <i class="fa-solid fa-wallet text-lg"></i>
                                </div>
                            </div>

                            <div
                                class="bg-white dark:bg-[#111827]/80 backdrop-blur-xl p-6 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-sm flex items-center justify-between group hover:border-brand-500/50 transition-all">
                                <div>
                                    <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Total
                                        Anggota Aktif</p>
                                    <p class="text-xl font-bold mt-1 text-slate-800 dark:text-slate-100">1,248 Orang
                                    </p>
                                    <span
                                        class="text-[11px] font-semibold text-emerald-500 flex items-center gap-1 mt-2">
                                        <i class="fa-solid fa-arrow-trend-up"></i> +48 anggota baru
                                    </span>
                                </div>
                                <div
                                    class="w-12 h-12 rounded-2xl bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 flex items-center justify-center group-hover:scale-110 transition-transform">
                                    <i class="fa-solid fa-users text-lg"></i>
                                </div>
                            </div>

                            <div
                                class="bg-white dark:bg-[#111827]/80 backdrop-blur-xl p-6 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-sm flex items-center justify-between group hover:border-brand-500/50 transition-all">
                                <div>
                                    <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Pelatihan
                                        Berjalan</p>
                                    <p class="text-xl font-bold mt-1 text-slate-800 dark:text-slate-100">12 Agenda</p>
                                    <span
                                        class="text-[11px] font-semibold text-amber-500 flex items-center gap-1 mt-2">
                                        <i class="fa-solid fa-clock"></i> Sedang berlangsung
                                    </span>
                                </div>
                                <div
                                    class="w-12 h-12 rounded-2xl bg-amber-500/10 text-amber-600 dark:text-amber-400 flex items-center justify-center group-hover:scale-110 transition-transform">
                                    <i class="fa-solid fa-chalkboard-user text-lg"></i>
                                </div>
                            </div>

                        </div>

                        <div
                            class="bg-white dark:bg-[#111827]/80 backdrop-blur-xl p-6 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-sm">
                            <h3 class="font-bold text-sm text-slate-800 dark:text-slate-200 mb-4">Aktivitas & Ringkasan
                                Sistem</h3>
                            <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">
                                Selamat datang di Panel Workspace BAKUMDA. Gunakan menu navigasi di sebelah kiri untuk
                                mengelola data anggota, kartu identitas, manajemen pelatihan, serta pengaturan hak akses
                                peran pengguna sistem secara terpadu.
                            </p>
                        </div>
                    @endif

                </main>

                <!-- Footer -->
                <footer
                    class="px-6 lg:px-8 py-4 border-t border-slate-200/80 dark:border-slate-800/80 bg-white/40 dark:bg-[#0b0f19]/40 backdrop-blur-md flex flex-col sm:flex-row items-center justify-between text-[11px] text-slate-400 dark:text-slate-500">
                    <p>&copy; {{ date('Y') }} BAKUMDA Workspace. All rights reserved.</p>
                    <p class="mt-1 sm:mt-0 font-medium text-slate-500 dark:text-slate-400">Version 1.0.0-PRO</p>
                </footer>

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
                if (btnDesktop && btnMobile) {
                    btnDesktop.className = "px-3 py-1.5 text-xs font-bold rounded-xl bg-orange-500 text-white transition";
                    btnMobile.className =
                        "px-3 py-1.5 text-xs font-bold rounded-xl bg-gray-100 text-gray-600 hover:bg-gray-200 transition";
                }
            } else {
                desktopView.classList.add('hidden');
                androidView.classList.remove('hidden');
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
