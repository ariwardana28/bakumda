@extends('layouts.app')

@section('title', 'Daftar Akun - BAKUMDA')

@section('content')
    <div class="w-full max-w-md mx-auto flex flex-col justify-center pb-12 2xl:hidden">
        <!-- Card Pembungkus Utama -->
        <div
            class="bg-white shadow-xl shadow-slate-900/10 border border-slate-100 rounded-[2.5rem] p-6 sm:p-8 space-y-6 w-full text-slate-900">

            <!-- Logo & Judul Sambutan -->
            <div class="text-center space-y-2">
                <div class="w-44 h-20 mx-auto flex items-center justify-center overflow-hidden">
                    <img src="{{ asset('log.png') }}" alt="Logo BAKUMDA" class="w-full h-full object-contain">
                </div>
                <div class="space-y-1">
                    <h1 class="text-xl sm:text-2xl font-black text-gray-900 tracking-tight">Bergabung Sekarang</h1>
                    <p class="text-xs sm:text-sm text-gray-500 font-medium">Lengkapi data diri Anda untuk membuat akun baru
                    </p>
                </div>
            </div>

            <!-- Notifikasi Error Validasi Laravel -->
            @if ($errors->any())
                <div
                    class="p-4 rounded-3xl bg-rose-50/80 border border-rose-200/80 text-rose-600 text-xs font-medium space-y-2 shadow-sm backdrop-blur-sm">
                    <div class="flex items-center gap-2 font-bold uppercase tracking-wider text-[10px]">
                        <i class="fa-solid fa-triangle-exclamation text-sm"></i>
                        <span>Mohon periksa kembali formulir Anda</span>
                    </div>
                    <ul class="list-disc list-inside space-y-1 pl-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form Register -->
            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                <!-- Name Input -->
                <div class="space-y-1.5">
                    <label class="block text-[11px] font-bold text-gray-700 uppercase tracking-wider">Nama Lengkap</label>
                    <div class="relative group">
                        <span
                            class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-blue-600 transition-colors">
                            <i class="fa-solid fa-user text-sm"></i>
                        </span>
                        <input type="text" name="name" value="{{ old('name') }}" required autofocus
                            autocomplete="name"
                            class="w-full pl-11 pr-4 py-3.5 text-xs sm:text-sm rounded-2xl bg-gray-50/80 border border-gray-200/80 focus:ring-4 focus:ring-blue-500/15 focus:border-blue-600 focus:bg-white outline-none transition-all duration-200 text-gray-900 font-semibold placeholder:text-gray-400 placeholder:font-normal @error('name') border-rose-500 bg-rose-50/30 focus:ring-rose-500/15 focus:border-rose-500 @enderror"
                            placeholder="Masukkan nama lengkap Anda">
                    </div>
                </div>

                <!-- Email Input -->
                <div class="space-y-1.5">
                    <label class="block text-[11px] font-bold text-gray-700 uppercase tracking-wider">Alamat Email</label>
                    <div class="relative group">
                        <span
                            class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-blue-600 transition-colors">
                            <i class="fa-solid fa-envelope text-sm"></i>
                        </span>
                        <input type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                            class="w-full pl-11 pr-4 py-3.5 text-xs sm:text-sm rounded-2xl bg-gray-50/80 border border-gray-200/80 focus:ring-4 focus:ring-blue-500/15 focus:border-blue-600 focus:bg-white outline-none transition-all duration-200 text-gray-900 font-semibold placeholder:text-gray-400 placeholder:font-normal @error('email') border-rose-500 bg-rose-50/30 focus:ring-rose-500/15 focus:border-rose-500 @enderror"
                            placeholder="nama@domain.com">
                    </div>
                </div>

                <!-- Password Input -->
                <div class="space-y-1.5" x-data="{ showPassword: false }">
                    <label class="block text-[11px] font-bold text-gray-700 uppercase tracking-wider">Kata Sandi</label>
                    <div class="relative group">
                        <span
                            class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-blue-600 transition-colors">
                            <i class="fa-solid fa-lock text-sm"></i>
                        </span>
                        <input :type="showPassword ? 'text' : 'password'" name="password" required
                            autocomplete="new-password"
                            class="w-full pl-11 pr-12 py-3.5 text-xs sm:text-sm rounded-2xl bg-gray-50/80 border border-gray-200/80 focus:ring-4 focus:ring-blue-500/15 focus:border-blue-600 focus:bg-white outline-none transition-all duration-200 text-gray-900 font-semibold placeholder:text-gray-400 placeholder:font-normal @error('password') border-rose-500 bg-rose-50/30 focus:ring-rose-500/15 focus:border-rose-500 @enderror"
                            placeholder="Minimal 8 karakter">
                        <button type="button" @click="showPassword = !showPassword"
                            class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-gray-600 focus:outline-none transition-colors">
                            <i class="fa-solid text-sm" :class="showPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                        </button>
                    </div>
                </div>

                <!-- Confirm Password Input -->
                <div class="space-y-1.5" x-data="{ showConfirmPassword: false }">
                    <label class="block text-[11px] font-bold text-gray-700 uppercase tracking-wider">Konfirmasi Kata
                        Sandi</label>
                    <div class="relative group">
                        <span
                            class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-blue-600 transition-colors">
                            <i class="fa-solid fa-lock text-sm"></i>
                        </span>
                        <input :type="showConfirmPassword ? 'text' : 'password'" name="password_confirmation" required
                            autocomplete="new-password"
                            class="w-full pl-11 pr-12 py-3.5 text-xs sm:text-sm rounded-2xl bg-gray-50/80 border border-gray-200/80 focus:ring-4 focus:ring-blue-500/15 focus:border-blue-600 focus:bg-white outline-none transition-all duration-200 text-gray-900 font-semibold placeholder:text-gray-400 placeholder:font-normal @error('password_confirmation') border-rose-500 bg-rose-50/30 focus:ring-rose-500/15 focus:border-rose-500 @enderror"
                            placeholder="Ulangi kata sandi">
                        <button type="button" @click="showConfirmPassword = !showConfirmPassword"
                            class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-gray-600 focus:outline-none transition-colors">
                            <i class="fa-solid text-sm" :class="showConfirmPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                        </button>
                    </div>
                </div>

                <!-- Tombol Aksi Register & Redirect Login -->
                <div class="pt-4 space-y-3">
                    <button type="submit"
                        class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-extrabold py-4 px-6 rounded-2xl shadow-xl shadow-blue-600/25 active:scale-[0.99] transition-all duration-200 flex items-center justify-center gap-2.5 text-xs tracking-wider uppercase">
                        <span>Daftar Akun Baru</span>
                        <i class="fa-solid fa-arrow-right text-xs"></i>
                    </button>

                    <div class="relative flex py-1 items-center">
                        <div class="flex-grow border-t border-gray-100"></div>
                        <span
                            class="flex-shrink mx-4 text-gray-400 text-[10px] font-bold uppercase tracking-widest">Atau</span>
                        <div class="flex-grow border-t border-gray-100"></div>
                    </div>

                    <a href="{{ route('login') }}"
                        class="w-full bg-gray-50 hover:bg-gray-100 text-gray-700 border border-gray-200/80 font-bold py-3.5 px-6 rounded-2xl shadow-sm hover:shadow transition-all duration-200 flex items-center justify-center gap-2 text-xs tracking-wider uppercase">
                        <i class="fa-solid fa-right-to-bracket text-blue-600"></i>
                        <span>Sudah punya akun? Masuk</span>
                    </a>
                </div>
            </form>

        </div>
    </div>

    <div class="flex-1 items-center justify-center p-8 bg-slate-950 overflow-y-auto hidden 2xl:flex">
        <div class="w-full max-w-md my-auto">
            <!-- Card Pembungkus Utama (Desktop Mode) -->
            <div
                class="bg-slate-900 border border-slate-800 shadow-2xl rounded-[2.5rem] p-8 space-y-6 w-full text-slate-100">

                <!-- Logo & Judul Sambutan -->
                <div class="text-center space-y-2">
                    <div
                        class="relative w-16 h-16 rounded-3xl border-2 border-blue-500/30 p-1.5 flex items-center justify-center bg-gradient-to-tr from-blue-500/10 to-indigo-500/10 mx-auto shadow-lg shadow-blue-500/10">
                        <div
                            class="w-full h-full rounded-2xl bg-slate-950 flex items-center justify-center overflow-hidden shadow-inner p-1">
                            <img src="{{ asset('bakumda.png') }}" alt="Logo BAKUMDA" class="w-full h-full object-contain">
                        </div>
                    </div>
                    <div class="space-y-1">
                        <h1 class="text-xl sm:text-2xl font-black text-white tracking-tight">Bergabung Sekarang</h1>
                        <p class="text-xs sm:text-sm text-slate-400 font-medium">Lengkapi data diri Anda untuk membuat akun
                            baru</p>
                    </div>
                </div>

                <!-- Notifikasi Error Validasi Laravel -->
                @if ($errors->any())
                    <div
                        class="p-4 rounded-3xl bg-rose-950/50 border border-rose-800/80 text-rose-300 text-xs font-medium space-y-2 shadow-sm backdrop-blur-sm">
                        <div class="flex items-center gap-2 font-bold uppercase tracking-wider text-[10px]">
                            <i class="fa-solid fa-triangle-exclamation text-sm"></i>
                            <span>Mohon periksa kembali formulir Anda</span>
                        </div>
                        <ul class="list-disc list-inside space-y-1 pl-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Form Register -->
                <form method="POST" action="{{ route('register') }}" class="space-y-4">
                    @csrf

                    <!-- Name Input -->
                    <div class="space-y-1.5">
                        <label class="block text-[11px] font-bold text-slate-300 uppercase tracking-wider">Nama
                            Lengkap</label>
                        <div class="relative group">
                            <span
                                class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-500 group-focus-within:text-blue-500 transition-colors">
                                <i class="fa-solid fa-user text-sm"></i>
                            </span>
                            <input type="text" name="name" value="{{ old('name') }}" required autofocus
                                autocomplete="name"
                                class="w-full pl-11 pr-4 py-3.5 text-xs sm:text-sm rounded-2xl bg-slate-800 border border-slate-700 focus:ring-4 focus:ring-blue-500/15 focus:border-blue-500 focus:bg-slate-900 outline-none transition-all duration-200 text-white font-semibold placeholder:text-slate-500 placeholder:font-normal @error('name') border-rose-500 bg-rose-950/30 focus:ring-rose-500/15 focus:border-rose-500 @enderror"
                                placeholder="Masukkan nama lengkap Anda">
                        </div>
                    </div>

                    <!-- Email Input -->
                    <div class="space-y-1.5">
                        <label class="block text-[11px] font-bold text-slate-300 uppercase tracking-wider">Alamat
                            Email</label>
                        <div class="relative group">
                            <span
                                class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-500 group-focus-within:text-blue-500 transition-colors">
                                <i class="fa-solid fa-envelope text-sm"></i>
                            </span>
                            <input type="email" name="email" value="{{ old('email') }}" required
                                autocomplete="username"
                                class="w-full pl-11 pr-4 py-3.5 text-xs sm:text-sm rounded-2xl bg-slate-800 border border-slate-700 focus:ring-4 focus:ring-blue-500/15 focus:border-blue-500 focus:bg-slate-900 outline-none transition-all duration-200 text-white font-semibold placeholder:text-slate-500 placeholder:font-normal @error('email') border-rose-500 bg-rose-950/30 focus:ring-rose-500/15 focus:border-rose-500 @enderror"
                                placeholder="nama@domain.com">
                        </div>
                    </div>

                    <!-- Password Input -->
                    <div class="space-y-1.5" x-data="{ showPassword: false }">
                        <label class="block text-[11px] font-bold text-slate-300 uppercase tracking-wider">Kata
                            Sandi</label>
                        <div class="relative group">
                            <span
                                class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-500 group-focus-within:text-blue-500 transition-colors">
                                <i class="fa-solid fa-lock text-sm"></i>
                            </span>
                            <input :type="showPassword ? 'text' : 'password'" name="password" required
                                autocomplete="new-password"
                                class="w-full pl-11 pr-12 py-3.5 text-xs sm:text-sm rounded-2xl bg-slate-800 border border-slate-700 focus:ring-4 focus:ring-blue-500/15 focus:border-blue-500 focus:bg-slate-900 outline-none transition-all duration-200 text-white font-semibold placeholder:text-slate-500 placeholder:font-normal @error('password') border-rose-500 bg-rose-950/30 focus:ring-rose-500/15 focus:border-rose-500 @enderror"
                                placeholder="Minimal 8 karakter">
                            <button type="button" @click="showPassword = !showPassword"
                                class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-slate-200 focus:outline-none transition-colors">
                                <i class="fa-solid text-sm" :class="showPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Confirm Password Input -->
                    <div class="space-y-1.5" x-data="{ showConfirmPassword: false }">
                        <label class="block text-[11px] font-bold text-slate-300 uppercase tracking-wider">Konfirmasi Kata
                            Sandi</label>
                        <div class="relative group">
                            <span
                                class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-500 group-focus-within:text-blue-500 transition-colors">
                                <i class="fa-solid fa-lock text-sm"></i>
                            </span>
                            <input :type="showConfirmPassword ? 'text' : 'password'" name="password_confirmation" required
                                autocomplete="new-password"
                                class="w-full pl-11 pr-12 py-3.5 text-xs sm:text-sm rounded-2xl bg-slate-800 border border-slate-700 focus:ring-4 focus:ring-blue-500/15 focus:border-blue-500 focus:bg-slate-900 outline-none transition-all duration-200 text-white font-semibold placeholder:text-slate-500 placeholder:font-normal @error('password_confirmation') border-rose-500 bg-rose-950/30 focus:ring-rose-500/15 focus:border-rose-500 @enderror"
                                placeholder="Ulangi kata sandi">
                            <button type="button" @click="showConfirmPassword = !showConfirmPassword"
                                class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-slate-200 focus:outline-none transition-colors">
                                <i class="fa-solid text-sm" :class="showConfirmPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Tombol Aksi Register & Redirect Login -->
                    <div class="pt-4 space-y-3">
                        <button type="submit"
                            class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-extrabold py-4 px-6 rounded-2xl shadow-xl shadow-blue-600/25 active:scale-[0.99] transition-all duration-200 flex items-center justify-center gap-2.5 text-xs tracking-wider uppercase">
                            <span>Daftar Akun Baru</span>
                            <i class="fa-solid fa-arrow-right text-xs"></i>
                        </button>

                        <div class="relative flex py-1 items-center">
                            <div class="flex-grow border-t border-slate-800"></div>
                            <span
                                class="flex-shrink mx-4 text-slate-500 text-[10px] font-bold uppercase tracking-widest">Atau</span>
                            <div class="flex-grow border-t border-slate-800"></div>
                        </div>

                        <a href="{{ route('login') }}"
                            class="w-full bg-slate-800 hover:bg-slate-700 text-slate-200 border border-slate-700 font-bold py-3.5 px-6 rounded-2xl shadow-sm hover:shadow transition-all duration-200 flex items-center justify-center gap-2 text-xs tracking-wider uppercase">
                            <i class="fa-solid fa-right-to-bracket text-blue-500"></i>
                            <span>Sudah punya akun? Masuk</span>
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>

@endsection
