<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - BAKUMDA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
</head>

<body class="min-h-screen text-gray-800 flex flex-col items-center justify-start p-0 md:p-6 transition-all duration-300">

    <div id="appContainer" class="w-full flex flex-col items-center justify-center">

        <!-- ================= ANDROID MOBILE APP VIEW CONTAINER ================= -->
        <div id="androidView"
            class="w-full sm:max-w-[412px] bg-white min-h-screen sm:min-h-[860px] sm:rounded-[45px] sm:ring-[12px] sm:ring-slate-800 sm:shadow-2xl relative flex flex-col justify-between overflow-hidden transition-all duration-300">

            <!-- Mobile Status Bar (Android Simulation) -->
            <div
                class="w-full bg-white pt-3 px-6 sm:flex hidden justify-between items-center text-xs font-semibold text-gray-800">
                <span>13.26</span>
                <div class="flex items-center space-x-1.5 text-xs">
                    <i class="fa-solid fa-signal"></i>
                    <i class="fa-solid fa-wifi"></i>
                    <span class="font-bold text-[10px] px-1 bg-gray-200 rounded">4G</span>
                    <span class="bg-gray-800 text-white px-1 rounded text-[10px]">64</span>
                </div>
            </div>

            <!-- Header Navigasi Atas -->
            <div class="px-6 pt-4 pb-3 flex items-center justify-between bg-white border-b border-gray-100">
                <a href="{{ route('welcome') }}" class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-700 hover:bg-gray-200 transition">
                    <i class="fa-solid fa-arrow-left text-sm"></i>
                </a>
                <span class="text-xs font-bold uppercase tracking-wider text-gray-500">Autentikasi Akun</span>
                <div class="w-10"></div> <!-- Spacer untuk menyeimbangkan header -->
            </div>

            <!-- Konten Utama Halaman Login -->
            <div class="px-6 py-6 flex-1 flex flex-col justify-center overflow-y-auto no-scrollbar space-y-6">
                
                <!-- Logo & Judul Sambutan -->
                <div class="text-center space-y-2">
                    <div class="w-16 h-16 rounded-2xl border-2 border-orange-500 p-1 flex items-center justify-center bg-orange-50 mx-auto shadow-sm">
                        <img src="{{ asset('bakumda.png') }}" alt="Logo" class="w-full h-full rounded-xl object-cover">
                    </div>
                    <h1 class="text-xl font-black text-gray-900 tracking-tight">Selamat Datang Kembali</h1>
                    <p class="text-xs text-gray-500">Masuk untuk mengakses layanan & fitur IMI Mobilitas</p>
                </div>

                <!-- Notifikasi Error Validasi Laravel -->
                @if($errors->any())
                    <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-600 text-xs font-medium space-y-1 shadow-xs">
                        <ul class="list-disc list-inside space-y-0.5">
                            @foreach($errors->all() as $error)
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
                            <button type="button" @click="showPassword = !showPassword" class="absolute right-4 top-3.5 text-gray-400 hover:text-gray-600 focus:outline-none transition">
                                <i class="fa-solid text-sm" :class="showPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center pt-1">
                        <input type="checkbox" name="remember" id="remember" class="w-4 h-4 rounded border-gray-300 text-orange-500 focus:ring-orange-500 cursor-pointer">
                        <label for="remember" class="ml-2.5 text-xs font-bold text-gray-600 cursor-pointer">Ingat saya di perangkat ini</label>
                    </div>

                    <!-- Tombol Submit Login & Register -->
                    <div class="pt-2 space-y-2.5">
                        <button type="submit" class="w-full bg-orange-500 hover:bg-orange-600 text-white font-bold py-3.5 px-4 rounded-2xl shadow-lg shadow-orange-500/30 transition duration-200 flex items-center justify-center gap-2 text-xs tracking-wider uppercase">
                            <span>Login</span>
                            <i class="fa-solid fa-arrow-right-long"></i>
                        </button>

                        <a href="{{ route('register') }}" class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-3.5 px-4 rounded-2xl transition duration-200 flex items-center justify-center gap-2 text-xs tracking-wider uppercase">
                            <i class="fa-solid fa-user-plus text-orange-500"></i>
                            <span>Register Akun Baru</span>
                        </a>
                    </div>
                </form>

            </div>

            <!-- Bottom Navigation Bar (Konsisten dengan halaman lain) -->
            <div
                class="w-full h-20 bg-white border-t border-gray-100 shadow-[0_-5px_20px_-5px_rgba(0,0,0,0.05)] sm:rounded-b-[45px] flex justify-center items-center">
                <div class="flex justify-around items-center w-full max-w-xs px-2">
                    <!-- Home -->
                    <a href="{{ route('welcome') }}" class="flex flex-col items-center space-y-1 text-gray-400 hover:text-orange-500 transition">
                        <i class="fa-solid fa-house text-lg"></i>
                        <span class="text-[10px] font-bold">Beranda</span>
                    </a>
                    <!-- Layanan -->
                    <button onclick="handleProtectedAction('{{ route('user-pelatihan.index') }}')" class="flex flex-col items-center space-y-1 text-gray-400 hover:text-orange-500 transition">
                        <i class="fa-solid fa-layer-group text-lg"></i>
                        <span class="text-[10px] font-bold">Layanan</span>
                    </button>
                    <!-- Pendaftaran -->
                    <button onclick="handleProtectedAction('{{ route('user-pelatihan.show', 1) }}')"
                        class="w-14 h-14 rounded-full bg-orange-500 text-white flex items-center justify-center -mt-6 shadow-lg shadow-orange-500/40 border-4 border-white">
                        <i class="fa-solid fa-file-pen text-xl"></i>
                    </button>
                    <!-- Riwayat -->
                    <button onclick="handleProtectedAction('#')" class="flex flex-col items-center space-y-1 text-gray-400 hover:text-orange-500 transition">
                        <i class="fa-solid fa-clock-rotate-left text-lg"></i>
                        <span class="text-[10px] font-bold">Riwayat</span>
                    </button>
                    <!-- Profil -->
                    <button onclick="handleProtectedAction('{{ route('profile.show') }}')" class="flex flex-col items-center space-y-1 text-gray-400 hover:text-orange-500 transition">
                        <i class="fa-solid fa-user text-lg"></i>
                        <span class="text-[10px] font-bold">Profil</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Script Pendukung (Jika diperlukan fungsi tambahan) -->
    <script>
        const isAuthenticated = @json(Auth::check());

        function handleProtectedAction(targetUrl) {
            if (!isAuthenticated) {
                window.location.href = "{{ route('login') }}";
            } else {
                window.location.href = targetUrl;
            }
        }
    </script>
</body>
</html>