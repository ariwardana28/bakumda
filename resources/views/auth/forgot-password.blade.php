@extends('layouts.app')

@section('content')
<div class="w-full flex justify-center items-start pt-6 sm:pt-10 pb-12 px-4">
    {{-- Card Wrapper Lupa Password --}}
    <div class="w-full max-w-md bg-white rounded-3xl border border-slate-200/80 shadow-xl shadow-slate-200/50 p-6 sm:p-8 relative overflow-hidden">
        
        {{-- Decorative Ambient Blur --}}
        <div class="absolute -top-12 -right-12 w-40 h-40 bg-sky-400/10 rounded-full blur-2xl pointer-events-none"></div>
        <div class="absolute -bottom-12 -left-12 w-40 h-40 bg-indigo-400/10 rounded-full blur-2xl pointer-events-none"></div>

        <div class="relative space-y-6">
            {{-- Header & Ikon --}}
            <div class="text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-tr from-sky-500 to-indigo-600 rounded-3xl text-white shadow-lg shadow-sky-500/30 mb-4 transform -rotate-2 hover:rotate-0 transition-transform duration-300">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 0121 9z"></path>
                    </svg>
                </div>
                <h2 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">Lupa Kata Sandi?</h2>
                <p class="mt-2 text-xs sm:text-sm text-slate-500 leading-relaxed max-w-xs mx-auto">
                    {{ __('Masukkan alamat email Anda dan kami akan mengirimkan tautan untuk mengatur ulang kata sandi Anda.') }}
                </p>
            </div>

            {{-- Status Pesan Berhasil --}}
            <x-auth-session-status class="mb-4 text-xs sm:text-sm" :status="session('status')" />

            {{-- Form Lupa Password --}}
            <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
                @csrf

                {{-- Input Email --}}
                <div>
                    <x-input-label for="email" :value="__('Alamat Email')" class="text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5" />
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                            </svg>
                        </div>
                        <x-text-input id="email" 
                            class="block w-full pl-10 pr-4 py-3 rounded-2xl border-slate-200 focus:border-sky-500 focus:ring-sky-500 text-xs sm:text-sm shadow-sm placeholder:text-slate-400" 
                            type="email" 
                            name="email" 
                            :value="old('email')" 
                            placeholder="nama@email.com"
                            required 
                            autofocus />
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs" />
                </div>

                {{-- Tombol Aksi --}}
                <div class="pt-2">
                    <button type="submit" 
                        class="w-full inline-flex items-center justify-center gap-2 px-5 py-3 rounded-2xl bg-slate-900 hover:bg-sky-600 text-white font-bold text-xs sm:text-sm transition-all duration-300 shadow-md shadow-slate-900/10 hover:shadow-sky-500/25 active:scale-[0.99]">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 002-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <span>{{ __('Kirim Tautan Reset Password') }}</span>
                    </button>
                </div>
            </form>

            {{-- Navigasi Kembali ke Login --}}
            <div class="text-center pt-4 border-t border-slate-100">
                <a href="{{ route('login') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-500 hover:text-sky-600 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    <span>{{ __('Kembali ke Halaman Masuk') }}</span>
                </a>
            </div>
        </div>

    </div>
</div>
@endsection