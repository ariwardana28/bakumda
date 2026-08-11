<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Dashboard IMI Mobilitas</title>
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
                <a href="{{ route('login') }}" class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-700 hover:bg-gray-200 transition">
                    <i class="fa-solid fa-arrow-left text-sm"></i>
                </a>
                <span class="text-xs font-bold uppercase tracking-wider text-gray-500">Pendaftaran Akun</span>
                <div class="w-10"></div>
            </div>

            <!-- Konten Utama Halaman Register -->
            <div class="px-6 py-6 flex-1 flex flex-col justify-center overflow-y-auto no-scrollbar space-y-5">
                
                <!-- Logo & Judul Sambutan -->
                <div class="text-center space-y-1.5">
                    <div class="w-14 h-14 rounded-2xl border-2 border-orange-500 p-1 flex items-center justify-center bg-orange-50 mx-auto shadow-sm">
                        <img src="{{ asset('bakumda.png') }}" alt="Logo" class="w-full h-full rounded-xl object-cover">
                    </div>
                    <h1 class="text-lg font-black text-gray-900 tracking-tight">Buat Akun Baru</h1>
                    <p class="text-xs text-gray-500">Lengkapi data diri Anda untuk bergabung</p>
                </div>

                <!-- Notifikasi Error Validasi Laravel -->
                @if($errors->any())
                    <div class="p-3 rounded-2xl bg-rose-50 border border-rose-200 text-rose-600 text-xs font-medium space-y-1">
                        <ul class="list-disc list-inside space-y-0.5">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Form Register -->
                <form method="POST" action="{{ route('register') }}" class="space-y-3.5">
                    @csrf

                    <!-- Name Input -->
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1 uppercase tracking-wider">Nama Lengkap</label>
                        <div class="relative">
                            <i class="fa-solid fa-user absolute left-4 top-3.5 text-gray-400 text-sm"></i>
                            <input type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                                class="w-full pl-11 pr-4 py-3 text-xs rounded-2xl bg-gray-50 border border-gray-200 focus:ring-2 focus:ring-orange-500 focus:bg-white outline-none transition text-gray-900 font-medium @error('name') border-rose-500 bg-rose-50/30 @enderror" 
                                placeholder="Nama lengkap Anda">
                        </div>
                    </div>

                    <!-- Email Input -->
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1 uppercase tracking-wider">Alamat Email</label>
                        <div class="relative">
                            <i class="fa-solid fa-envelope absolute left-4 top-3.5 text-gray-400 text-sm"></i>
                            <input type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                                class="w-full pl-11 pr-4 py-3 text-xs rounded-2xl bg-gray-50 border border-gray-200 focus:ring-2 focus:ring-orange-500 focus:bg-white outline-none transition text-gray-900 font-medium @error('email') border-rose-500 bg-rose-50/30 @enderror" 
                                placeholder="nama@domain.com">
                        </div>
                    </div>

                    <!-- Password Input -->
                    <div x-data="{ showPassword: false }">
                        <label class="block text-xs font-bold text-gray-700 mb-1 uppercase tracking-wider">Kata Sandi</label>
                        <div class="relative">
                            <i class="fa-solid fa-lock absolute left-4 top-3.5 text-gray-400 text-sm"></i>
                            <input :type="showPassword ? 'text' : 'password'" name="password" required autocomplete="new-password"
                                class="w-full pl-11 pr-12 py-3 text-xs rounded-2xl bg-gray-50 border border-gray-200 focus:ring-2 focus:ring-orange-500 focus:bg-white outline-none transition text-gray-900 font-medium @error('password') border-rose-500 bg-rose-50/30 @enderror" 
                                placeholder="••••••••">
                            <button type="button" @click="showPassword = !showPassword" class="absolute right-4 top-3.5 text-gray-400 hover:text-gray-600 focus:outline-none transition">
                                <i class="fa-solid text-sm" :class="showPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Confirm Password Input -->
                    <div x-data="{ showConfirmPassword: false }">
                        <label class="block text-xs font-bold text-gray-700 mb-1 uppercase tracking-wider">Konfirmasi Kata Sandi</label>
                        <div class="relative">
                            <i class="fa-solid fa-lock absolute left-4 top-3.5 text-gray-400 text-sm"></i>
                            <input :type="showConfirmPassword ? 'text' : 'password'" name="password_confirmation" required autocomplete="new-password"
                                class="w-full pl-11 pr-12 py-3 text-xs rounded-2xl bg-gray-50 border border-gray-200 focus:ring-2 focus:ring-orange-500 focus:bg-white outline-none transition text-gray-900 font-medium @error('password_confirmation') border-rose-500 bg-rose-50/30 @enderror" 
                                placeholder="••••••••">
                            <button type="button" @click="showConfirmPassword = !showConfirmPassword" class="absolute right-4 top-3.5 text-gray-400 hover:text-gray-600 focus:outline-none transition">
                                <i class="fa-solid text-sm" :class="showConfirmPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Tombol Aksi Register & Redirect Login -->
                    <div class="pt-3 space-y-2.5">
                        <button type="submit" class="w-full bg-orange-500 hover:bg-orange-600 text-white font-bold py-3.5 px-4 rounded-2xl shadow-lg shadow-orange-500/30 transition duration-200 flex items-center justify-center gap-2 text-xs tracking-wider uppercase">
                            <span>Daftar Akun</span>
                            <i class="fa-solid fa-user-plus"></i>
                        </button>

                        <a href="{{ route('login') }}" class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-3 px-4 rounded-2xl transition duration-200 flex items-center justify-center gap-2 text-xs tracking-wider uppercase">
                            <span>Sudah punya akun? Login</span>
                        </a>
                    </div>
                </form>

            </div>

            <!-- Bottom Navigation Bar -->
            <div
                class="w-full h-20 bg-white border-t border-gray-100 shadow-[0_-5px_20px_-5px_rgba(0,0,0,0.05)] sm:rounded-b-[45px] flex justify-center items-center">
                <div class="flex justify-around items-center w-full max-w-xs px-2">
                    <a href="{{ route('welcome') }}" class="flex flex-col items-center space-y-1 text-gray-400 hover:text-orange-500 transition">
                        <i class="fa-solid fa-house text-lg"></i>
                        <span class="text-[10px] font-bold">Beranda</span>
                    </a>
                    <button onclick="handleProtectedAction('{{ route('user-pelatihan.index') }}')" class="flex flex-col items-center space-y-1 text-gray-400 hover:text-orange-500 transition">
                        <i class="fa-solid fa-layer-group text-lg"></i>
                        <span class="text-[10px] font-bold">Layanan</span>
                    </button>
                    <button onclick="handleProtectedAction('{{ route('user-pelatihan.show', 1) }}')"
                        class="w-14 h-14 rounded-full bg-orange-500 text-white flex items-center justify-center -mt-6 shadow-lg shadow-orange-500/40 border-4 border-white">
                        <i class="fa-solid fa-file-pen text-xl"></i>
                    </button>
                    <button onclick="handleProtectedAction('#')" class="flex flex-col items-center space-y-1 text-gray-400 hover:text-orange-500 transition">
                        <i class="fa-solid fa-clock-rotate-left text-lg"></i>
                        <span class="text-[10px] font-bold">Riwayat</span>
                    </button>
                    <button onclick="handleProtectedAction('{{ route('profile.show') }}')" class="flex flex-col items-center space-y-1 text-gray-400 hover:text-orange-500 transition">
                        <i class="fa-solid fa-user text-lg"></i>
                        <span class="text-[10px] font-bold">Profil</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Script Pendukung -->
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