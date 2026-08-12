<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - BAKUMDA</title>
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

<body class="min-h-screen text-gray-800 flex flex-col transition-all duration-300 bg-slate-50">

    <div class="flex min-h-screen w-full relative">

        <!-- ================= HEADER MOBILE ================= -->
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

        <!-- ================= BOTTOM NAVIGATION BAR (Mobile View) ================= -->
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
                    <i class="fa-solid fa-house text-xl"></i>
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

        <!-- ================= KONTEN UTAMA LOGIN ================= -->
        <main class="flex-1 w-full pt-20 pb-24 px-4 flex items-center justify-center">
            <div class="w-full max-w-md bg-white rounded-3xl shadow-lg border border-slate-100 p-6 md:p-8">

                <!-- Logo & Judul Sambutan -->
                <div class="text-center space-y-2 mb-6">
                    <div class="w-16 h-16 rounded-2xl border-2 border-orange-500 p-1 flex items-center justify-center bg-orange-50 mx-auto shadow-sm">
                        <img src="{{ asset('bakumda.png') }}" alt="Logo" class="w-full h-full rounded-xl object-cover">
                    </div>
                    <h1 class="text-xl font-black text-gray-900 tracking-tight">Selamat Datang Kembali</h1>
                    <p class="text-xs text-gray-500">Masuk untuk mengakses layanan & fitur BAKUMDA</p>
                </div>

                <!-- Notifikasi Error Validasi Laravel -->
                @if ($errors->any())
                    <div class="mb-5 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-600 text-xs font-medium space-y-1">
                        <ul class="list-disc list-inside space-y-0.5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Form Login -->
                <form method="POST" action="{{ route('login') }}" class="space-y-4">
                    @csrf

                    <!-- Email Input -->
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1.5 uppercase tracking-wider">Alamat Email</label>
                        <div class="relative">
                            <i class="fa-solid fa-envelope absolute left-4 top-3.5 text-gray-400 text-sm"></i>
                            <input type="email" name="email" value="{{ old('email') }}" required autofocus
                                class="w-full pl-11 pr-4 py-3 text-xs rounded-2xl bg-gray-50 border border-gray-200 focus:ring-2 focus:ring-orange-500 focus:bg-white outline-none transition text-gray-900 font-medium @error('email') border-rose-500 bg-rose-50/30 @enderror"
                                placeholder="nama@domain.com">
                        </div>
                    </div>

                    <!-- Password Input dengan Alpine.js Toggle Show/Hide -->
                    <div x-data="{ showPassword: false }">
                        <div class="flex justify-between items-center mb-1.5">
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Kata Sandi</label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-xs font-bold text-orange-600 hover:underline">Lupa sandi?</a>
                            @endif
                        </div>
                        <div class="relative">
                            <i class="fa-solid fa-lock absolute left-4 top-3.5 text-gray-400 text-sm"></i>
                            <input :type="showPassword ? 'text' : 'password'" name="password" required
                                class="w-full pl-11 pr-12 py-3 text-xs rounded-2xl bg-gray-50 border border-gray-200 focus:ring-2 focus:ring-orange-500 focus:bg-white outline-none transition text-gray-900 font-medium @error('password') border-rose-500 bg-rose-50/30 @enderror"
                                placeholder="••••••••">
                            <button type="button" @click="showPassword = !showPassword"
                                class="absolute right-4 top-3.5 text-gray-400 hover:text-gray-600 focus:outline-none transition">
                                <i class="fa-solid text-sm" :class="showPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center pt-1">
                        <input type="checkbox" name="remember" id="remember"
                            class="w-4 h-4 rounded border-gray-300 text-orange-500 focus:ring-orange-500 cursor-pointer">
                        <label for="remember" class="ml-2.5 text-xs font-bold text-gray-600 cursor-pointer">Ingat saya di perangkat ini</label>
                    </div>

                    <!-- Tombol Submit Login & Register -->
                    <div class="pt-2 space-y-2.5">
                        <button type="submit"
                            class="w-full bg-orange-500 hover:bg-orange-600 text-white font-bold py-3.5 px-4 rounded-2xl shadow-lg shadow-orange-500/30 transition duration-200 flex items-center justify-center gap-2 text-xs tracking-wider uppercase">
                            <span>Login</span>
                            <i class="fa-solid fa-arrow-right-long"></i>
                        </button>

                        <a href="{{ route('register') }}"
                            class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-3.5 px-4 rounded-2xl transition duration-200 flex items-center justify-center gap-2 text-xs tracking-wider uppercase">
                            <i class="fa-solid fa-user-plus text-orange-500"></i>
                            <span>Register Akun Baru</span>
                        </a>
                    </div>
                </form>

            </div>
        </main>
    </div>

    <script>
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