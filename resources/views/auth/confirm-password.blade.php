@extends('layouts.app')

@section('content')
<div class="w-full flex justify-center items-start pt-6 sm:pt-10 pb-12 px-4">
    {{-- Card Wrapper Konfirmasi Password --}}
    <div class="w-full max-w-md bg-white rounded-3xl border border-slate-200/80 shadow-xl shadow-slate-200/50 p-6 sm:p-8 relative overflow-hidden">
        
        {{-- Decorative Glow Background Effect --}}
        <div class="absolute -top-12 -right-12 w-40 h-40 bg-sky-400/10 rounded-full blur-2xl pointer-events-none"></div>
        <div class="absolute -bottom-12 -left-12 w-40 h-40 bg-indigo-400/10 rounded-full blur-2xl pointer-events-none"></div>

        <div class="relative space-y-6">
            {{-- Header & Security Shield Icon --}}
            <div class="text-center">
                <div class="relative inline-block mb-4">
                    <div class="w-16 h-16 bg-gradient-to-tr from-sky-500 to-indigo-600 rounded-3xl flex items-center justify-center text-white shadow-lg shadow-sky-500/30 transform -rotate-3 hover:rotate-0 transition-transform duration-300">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    <div class="absolute -bottom-1 -right-1 bg-amber-400 text-slate-900 w-6 h-6 rounded-full flex items-center justify-center text-[10px] font-black shadow-md border-2 border-white">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01"></path>
                        </svg>
                    </div>
                </div>

                <h2 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">Konfirmasi Kata Sandi</h2>
                <p class="mt-2 text-xs sm:text-sm text-slate-500 leading-relaxed max-w-xs mx-auto font-normal">
                    {{ __('Ini adalah area aman aplikasi. Silakan konfirmasi kata sandi Anda sebelum melanjutkan.') }}
                </p>
            </div>

            {{-- Form Konfirmasi Password dengan Alpine.js untuk Toggle Visibility --}}
            <form method="POST" action="{{ route('password.confirm') }}" class="space-y-4" x-data="{ showPassword: false }">
                @csrf

                {{-- Input Field Password --}}
                <div>
                    <x-input-label for="password" :value="__('Kata Sandi')" class="text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5" />
                    
                    <div class="relative">
                        {{-- Lock Icon Left --}}
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>

                        {{-- Input --}}
                        <x-text-input id="password" 
                            class="block w-full pl-10 pr-12 py-3 rounded-2xl border-slate-200/90 focus:border-sky-500 focus:ring-sky-500 text-xs sm:text-sm shadow-sm placeholder:text-slate-400 transition-all duration-200" 
                            ::type="showPassword ? 'text' : 'password'" 
                            name="password" 
                            placeholder="••••••••"
                            required 
                            autocomplete="current-password" 
                            autofocus />

                        {{-- Toggle Show/Hide Eye Button --}}
                        <button type="button" 
                            @click="showPassword = !showPassword" 
                            class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none transition-colors">
                            <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            <svg x-show="showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858-5.908a10.025 10.025 0 013.28-.588c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m-1.803-1.803a3 3 0 00-4.243-4.243m4.243 4.243L3 3l18 18"></path>
                            </svg>
                        </button>
                    </div>

                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs" />
                </div>

                {{-- Action Button --}}
                <div class="pt-2">
                    <button type="submit" 
                        class="w-full inline-flex items-center justify-center gap-2 px-5 py-3 rounded-2xl bg-slate-900 hover:bg-sky-600 text-white font-bold text-xs sm:text-sm transition-all duration-300 shadow-md shadow-slate-900/10 hover:shadow-sky-500/25 active:scale-[0.99]">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>{{ __('Konfirmasi Kata Sandi') }}</span>
                    </button>
                </div>
            </form>

            {{-- Footer / Navigasi Pembatalan --}}
            <div class="text-center pt-4 border-t border-slate-100">
                <a href="{{ url()->previous() }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-500 hover:text-sky-600 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    <span>{{ __('Kembali ke Halaman Sebelumnya') }}</span>
                </a>
            </div>
        </div>

    </div>
</div>
@endsection