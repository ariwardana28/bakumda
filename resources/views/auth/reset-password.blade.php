@extends('layouts.app')

@section('content')
    <div class="w-full flex justify-center items-start pt-6 sm:pt-10 pb-12 px-4">
        {{-- Card Wrapper Reset Password --}}
        <div
            class="w-full max-w-md bg-white rounded-3xl border border-slate-200/80 shadow-xl shadow-slate-200/50 p-6 sm:p-8 relative overflow-hidden">

            {{-- Decorative Glow Background Effect --}}
            <div class="absolute -top-12 -right-12 w-40 h-40 bg-sky-400/10 rounded-full blur-2xl pointer-events-none"></div>
            <div class="absolute -bottom-12 -left-12 w-40 h-40 bg-indigo-400/10 rounded-full blur-2xl pointer-events-none">
            </div>

            <div class="relative space-y-6">
                {{-- Header & Icon --}}
                <div class="text-center">
                    <div
                        class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-tr from-sky-500 to-indigo-600 rounded-3xl text-white shadow-lg shadow-sky-500/30 mb-4 transform -rotate-2 hover:rotate-0 transition-transform duration-300">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                            </path>
                        </svg>
                    </div>
                    <h2 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">Atur Ulang Kata Sandi</h2>
                    <p class="mt-2 text-xs sm:text-sm text-slate-500 leading-relaxed max-w-xs mx-auto">
                        {{ __('Silakan buat kata sandi baru yang kuat untuk keamanan akun Anda.') }}
                    </p>
                </div>

                {{-- Form Reset Password --}}
                <form method="POST" action="{{ route('password.store') }}" class="space-y-4" x-data="{ showPass: false, showConfirmPass: false }">
                    @csrf

                    {{-- Password Reset Token --}}
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    {{-- Email Address --}}
                    <div>
                        <x-input-label for="email" :value="__('Alamat Email')"
                            class="text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5" />
                        <div class="relative">
                            <div
                                class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207">
                                    </path>
                                </svg>
                            </div>
                            <x-text-input id="email"
                                class="block w-full pl-10 pr-4 py-3 rounded-2xl border-slate-200 focus:border-sky-500 focus:ring-sky-500 text-xs sm:text-sm shadow-sm placeholder:text-slate-400 bg-slate-50/50"
                                type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username"
                                placeholder="nama@email.com" />
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs" />
                    </div>

                    {{-- New Password --}}
                    <div>
                        <x-input-label for="password" :value="__('Kata Sandi Baru')"
                            class="text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5" />
                        <div class="relative">
                            <div
                                class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                    </path>
                                </svg>
                            </div>
                            <x-text-input id="password"
                                class="block w-full pl-10 pr-12 py-3 rounded-2xl border-slate-200 focus:border-sky-500 focus:ring-sky-500 text-xs sm:text-sm shadow-sm placeholder:text-slate-400"
                                ::type="showPass ? 'text' : 'password'" name="password" required autocomplete="new-password"
                                placeholder="••••••••" />

                            {{-- Toggle Pass Button --}}
                            <button type="button" @click="showPass = !showPass"
                                class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none">
                                <svg x-show="!showPass" class="w-5 h-5" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                    </path>
                                </svg>
                                <svg x-show="showPass" class="w-5 h-5" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" style="display: none;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858-5.908a10.025 10.025 0 013.28-.588c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m-1.803-1.803a3 3 0 00-4.243-4.243m4.243 4.243L3 3l18 18">
                                    </path>
                                </svg>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs" />
                    </div>

                    {{-- Confirm Password --}}
                    <div>
                        <x-input-label for="password_confirmation" :value="__('Konfirmasi Kata Sandi Baru')"
                            class="text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5" />
                        <div class="relative">
                            <div
                                class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                    </path>
                                </svg>
                            </div>
                            <x-text-input id="password_confirmation"
                                class="block w-full pl-10 pr-12 py-3 rounded-2xl border-slate-200 focus:border-sky-500 focus:ring-sky-500 text-xs sm:text-sm shadow-sm placeholder:text-slate-400"
                                ::type="showConfirmPass ? 'text' : 'password'" name="password_confirmation" required autocomplete="new-password"
                                placeholder="••••••••" />

                            {{-- Toggle Confirm Pass Button --}}
                            <button type="button" @click="showConfirmPass = !showConfirmPass"
                                class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none">
                                <svg x-show="!showConfirmPass" class="w-5 h-5" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                    </path>
                                </svg>
                                <svg x-show="showConfirmPass" class="w-5 h-5" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" style="display: none;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858-5.908a10.025 10.025 0 013.28-.588c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m-1.803-1.803a3 3 0 00-4.243-4.243m4.243 4.243L3 3l18 18">
                                    </path>
                                </svg>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-xs" />
                    </div>

                    {{-- Action Button --}}
                    <div class="pt-2">
                        <button type="submit"
                            class="w-full inline-flex items-center justify-center gap-2 px-5 py-3 rounded-2xl bg-slate-900 hover:bg-sky-600 text-white font-bold text-xs sm:text-sm transition-all duration-300 shadow-md shadow-slate-900/10 hover:shadow-sky-500/25 active:scale-[0.99]">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                </path>
                            </svg>
                            <span>{{ __('Simpan Kata Sandi Baru') }}</span>
                        </button>
                    </div>
                </form>

                {{-- Footer / Login Option --}}
                <div class="text-center pt-4 border-t border-slate-100">
                    <a href="{{ route('login') }}"
                        class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-500 hover:text-sky-600 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        <span>{{ __('Kembali ke Halaman Masuk') }}</span>
                    </a>
                </div>
            </div>

        </div>
    </div>
@endsection
