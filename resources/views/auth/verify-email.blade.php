@extends('layouts.app')

@section('content')
<div class="w-full flex justify-center items-start pt-6 sm:pt-10 pb-12 px-4">
    {{-- Main Verification Card --}}
    <div class="w-full max-w-md bg-white rounded-3xl border border-slate-200/80 shadow-xl shadow-slate-200/50 p-6 sm:p-8 relative overflow-hidden">
        
        {{-- Decorative Blur Gradient Background --}}
        <div class="absolute -top-12 -right-12 w-40 h-40 bg-sky-400/10 rounded-full blur-2xl pointer-events-none"></div>
        <div class="absolute -bottom-12 -left-12 w-40 h-40 bg-indigo-400/10 rounded-full blur-2xl pointer-events-none"></div>

        {{-- Icon Header --}}
        <div class="flex justify-center mb-5">
            <div class="relative">
                <div class="w-16 h-16 sm:w-20 sm:h-20 bg-gradient-to-tr from-sky-500 to-indigo-600 rounded-3xl flex items-center justify-center text-white shadow-lg shadow-sky-500/30">
                    <i class="fa-regular fa-envelope-open text-2xl sm:text-3xl"></i>
                </div>
                <div class="absolute -bottom-1 -right-1 bg-amber-400 text-slate-900 w-6 h-6 sm:w-7 sm:h-7 rounded-full flex items-center justify-center text-xs font-black shadow-md border-2 border-white">
                    <i class="fa-solid fa-exclamation"></i>
                </div>
            </div>
        </div>

        {{-- Title & Description --}}
        <div class="text-center mb-6">
            <h2 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight mb-2">Verifikasi Email Anda</h2>
            <p class="text-xs sm:text-sm text-slate-500 leading-relaxed">
                Terima kasih telah mendaftar! Sebelum memulai, silakan periksa kotak masuk email Anda dan klik tautan konfirmasi yang telah kami kirimkan.
            </p>
        </div>

        {{-- Status Alert (Notifikasi Kirim Ulang) --}}
        @if (session('status') == 'verification-link-sent')
            <div class="flex items-start gap-3 rounded-2xl bg-emerald-50/90 p-3.5 mb-5 text-xs sm:text-sm font-medium text-emerald-800 border border-emerald-200/70 shadow-sm">
                <div class="p-1 bg-emerald-500 text-white rounded-lg shrink-0 mt-0.5">
                    <i class="fa-solid fa-check text-xs"></i>
                </div>
                <span class="leading-relaxed">Tautan verifikasi baru telah berhasil dikirim ke alamat email Anda.</span>
            </div>
        @endif

        {{-- Action Buttons --}}
        <div class="space-y-3">
            <form method="POST" action="{{ route('verification.send') }}" class="w-full">
                @csrf
                <button type="submit" 
                    class="w-full inline-flex items-center justify-center gap-2 px-5 py-3 rounded-2xl bg-slate-900 hover:bg-sky-600 text-white font-bold text-xs sm:text-sm transition-all duration-300 shadow-md shadow-slate-900/10 hover:shadow-sky-500/25 hover:scale-[1.01] active:scale-[0.99]">
                    <i class="fa-solid fa-paper-plane text-xs"></i>
                    <span>Kirim Ulang Email Verifikasi</span>
                </button>
            </form>

            <a href="https://mail.google.com" target="_blank" rel="noopener"
                class="w-full inline-flex items-center justify-center gap-2 px-5 py-3 rounded-2xl bg-slate-50 hover:bg-slate-100 border border-slate-200/80 text-slate-700 font-bold text-xs sm:text-sm transition-all duration-200">
                <i class="fa-brands fa-google text-red-500"></i>
                <span>Buka Gmail</span>
            </a>
        </div>

        {{-- Footer / Logout Option --}}
        <div class="mt-6 pt-5 border-t border-slate-100 flex items-center justify-between text-xs">
            <span class="text-slate-400 font-medium">Salah alamat email?</span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="font-bold text-slate-600 hover:text-red-600 transition-colors inline-flex items-center gap-1.5 py-1 px-2.5 rounded-lg hover:bg-red-50">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <span>Log Out</span>
                </button>
            </form>
        </div>

    </div>
</div>
@endsection