<!DOCTYPE html>
<html lang="id" x-data="{ darkMode: localStorage.getItem('theme') === 'dark' }" :class="{ 'dark': darkMode }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - {{ config('app.name', 'AdminPanel') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: { extend: { colors: { brand: { 500: '#3b82f6', 600: '#2563eb' } } } }
        }
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>
<body class="bg-slate-50 dark:bg-slate-950 font-sans antialiased flex items-center justify-center min-h-screen p-4">

    <div class="w-full max-w-md">
        <!-- Logo -->
        <div class="text-center mb-8">
            <div class="relative w-16 h-16 mx-auto flex items-center justify-center mb-4">
                <div class="absolute inset-0 rounded-2xl bg-brand-500/20 blur-xl animate-pulse"></div>
                <div class="relative w-16 h-16 bg-gradient-to-br from-brand-500 to-brand-600 rounded-2xl flex items-center justify-center text-white text-2xl shadow-xl shadow-brand-500/30">
                    <i class="fa-solid fa-bolt"></i>
                </div>
            </div>
            <h2 class="text-2xl font-black text-slate-900 dark:text-white tracking-tight">Selamat Datang</h2>
            <p class="text-slate-500 dark:text-slate-400 text-sm mt-1.5">Silakan masuk ke akun admin Anda</p>
        </div>

        <!-- Login Card -->
        <div class="bg-white dark:bg-slate-900 p-8 rounded-3xl shadow-xl border border-slate-200/80 dark:border-slate-800 relative overflow-hidden">
            
            <!-- Background Ambient Accent -->
            <div class="absolute -top-24 left-1/2 -translate-x-1/2 w-64 h-64 bg-brand-500/5 dark:bg-brand-500/10 rounded-full blur-3xl pointer-events-none"></div>

            <!-- Error Messages -->
            @if($errors->any())
                <div class="mb-6 p-4 rounded-2xl bg-rose-50 dark:bg-rose-900/30 border border-rose-200 dark:border-rose-800/60 text-rose-600 dark:text-rose-400 text-xs font-medium space-y-1">
                    <ul class="list-disc list-inside space-y-0.5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <!-- Email Input -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5 uppercase tracking-wider">Alamat Email</label>
                    <div class="relative">
                        <i class="fa-solid fa-envelope absolute left-4 top-3.5 text-slate-400 text-sm"></i>
                        <input type="email" name="email" value="{{ old('email') }}" required autofocus 
                            class="w-full pl-11 pr-4 py-3 text-sm rounded-xl bg-slate-50/80 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700/80 focus:ring-2 focus:ring-brand-500 focus:bg-white dark:focus:bg-slate-900 outline-none transition text-slate-900 dark:text-white @error('email') border-rose-500 @enderror" 
                            placeholder="admin@domain.com">
                    </div>
                </div>

                <!-- Password Input dengan Toggle Show/Hide -->
                <div x-data="{ showPassword: false }">
                    <div class="flex justify-between items-center mb-1.5">
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider">Kata Sandi</label>
                        <a href="{{ route('password.request') ?? '#' }}" class="text-xs font-semibold text-brand-600 dark:text-brand-400 hover:underline">Lupa sandi?</a>
                    </div>
                    <div class="relative">
                        <i class="fa-solid fa-lock absolute left-4 top-3.5 text-slate-400 text-sm"></i>
                        <input :type="showPassword ? 'text' : 'password'" name="password" required 
                            class="w-full pl-11 pr-12 py-3 text-sm rounded-xl bg-slate-50/80 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700/80 focus:ring-2 focus:ring-brand-500 focus:bg-white dark:focus:bg-slate-900 outline-none transition text-slate-900 dark:text-white @error('password') border-rose-500 @enderror" 
                            placeholder="••••••••">
                        <button type="button" @click="showPassword = !showPassword" class="absolute right-4 top-3.5 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 focus:outline-none transition">
                            <i class="fa-solid" :class="showPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                        </button>
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="flex items-center pt-1">
                    <input type="checkbox" name="remember" id="remember" class="w-4 h-4 rounded border-slate-300 dark:border-slate-700 text-brand-600 focus:ring-brand-500 dark:bg-slate-800 cursor-pointer">
                    <label for="remember" class="ml-2.5 text-xs font-medium text-slate-600 dark:text-slate-400 cursor-pointer">Ingat saya</label>
                </div>

                <!-- Login Button -->
                <div class="pt-2">
                    <button type="submit" class="w-full bg-brand-600 hover:bg-brand-500 text-white font-bold py-3 px-4 rounded-xl shadow-lg shadow-brand-600/30 transition duration-200 flex items-center justify-center gap-2 text-xs tracking-wide uppercase hover:scale-[1.02]">
                        <span>Masuk ke Dashboard</span>
                        <i class="fa-solid fa-arrow-right-long"></i>
                    </button>
                </div>
            </form>
        </div>

        <!-- Footer -->
        <p class="text-center text-slate-400 dark:text-slate-600 text-xs mt-8 font-medium">
            &copy; {{ date('Y') }} AdminPanel. All rights reserved.
        </p>
    </div>

</body>
</html>