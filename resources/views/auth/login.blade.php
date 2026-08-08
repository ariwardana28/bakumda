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
<body class="bg-gray-50 dark:bg-gray-900 font-sans antialiased flex items-center justify-center min-h-screen p-4">

    <div class="w-full max-w-md">
        <!-- Logo -->
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-brand-600 rounded-2xl flex items-center justify-center mx-auto text-white text-2xl shadow-lg shadow-brand-500/30 mb-4">
                <i class="fa-solid fa-bolt"></i>
            </div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Selamat Datang</h2>
            <p class="text-gray-500 dark:text-gray-400 mt-2">Silakan masuk ke akun admin Anda</p>
        </div>

        <!-- Login Card -->
        <div class="bg-white dark:bg-gray-800 p-8 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700">
            
            <!-- Error Messages -->
            @if($errors->any())
                <div class="mb-6 p-4 rounded-xl bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 text-red-600 dark:text-red-400 text-sm">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Input -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Alamat Email</label>
                    <div class="relative">
                        <i class="fa-solid fa-envelope absolute left-4 top-3.5 text-gray-400"></i>
                        <input type="email" name="email" value="{{ old('email') }}" required autofocus 
                            class="w-full pl-11 pr-4 py-3 rounded-xl bg-gray-50 dark:bg-gray-700/50 border border-gray-200 dark:border-gray-600 focus:ring-2 focus:ring-brand-500 outline-none transition @error('email') border-red-500 @enderror" 
                            placeholder="admin@domain.com">
                    </div>
                </div>

                <!-- Password Input -->
                <div class="mb-6">
                    <div class="flex justify-between items-center mb-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Kata Sandi</label>
                        <a href="{{ route('password.request') ?? '#' }}" class="text-xs text-brand-600 hover:underline">Lupa sandi?</a>
                    </div>
                    <div class="relative">
                        <i class="fa-solid fa-lock absolute left-4 top-3.5 text-gray-400"></i>
                        <input type="password" name="password" required 
                            class="w-full pl-11 pr-4 py-3 rounded-xl bg-gray-50 dark:bg-gray-700/50 border border-gray-200 dark:border-gray-600 focus:ring-2 focus:ring-brand-500 outline-none transition @error('password') border-red-500 @enderror" 
                            placeholder="••••••••">
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="flex items-center mb-6">
                    <input type="checkbox" name="remember" id="remember" class="w-4 h-4 rounded border-gray-300 text-brand-600 focus:ring-brand-500">
                    <label for="remember" class="ml-2 text-sm text-gray-600 dark:text-gray-400">Ingat saya</label>
                </div>

                <!-- Login Button -->
                <button type="submit" class="w-full bg-brand-600 hover:bg-brand-700 text-white font-semibold py-3 rounded-xl transition duration-200 flex items-center justify-center gap-2">
                    <span>Masuk ke Dashboard</span>
                    <i class="fa-solid fa-arrow-right-long"></i>
                </button>
            </form>
        </div>

        <!-- Footer -->
        <p class="text-center text-gray-400 dark:text-gray-600 text-xs mt-8">
            &copy; {{ date('Y') }} AdminPanel. All rights reserved.
        </p>
    </div>

</body>
</html>