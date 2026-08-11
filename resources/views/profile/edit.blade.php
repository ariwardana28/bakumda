@extends('layouts.app')

@section('title', 'Edit Profil Anggota')

@section('content')
    <div class="max-w-4xl mx-auto py-8 px-4 space-y-6">
        
        {{-- Header Halaman & Tombol Kembali --}}
        <div class="bg-white border border-slate-200 p-6 rounded-3xl shadow-sm flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-orange-100 border border-orange-200 flex items-center justify-center text-orange-600 shadow-sm shrink-0">
                    <i class="fa-solid fa-user-pen text-xl"></i>
                </div>
                <div>
                    <h1 class="font-black text-xl text-slate-900 tracking-tight">
                        Edit Profil Anggota
                    </h1>
                    <p class="text-xs text-slate-500 mt-0.5">
                        Perbarui informasi akun, data diri anggota, dan kata sandi Anda.
                    </p>
                </div>
            </div>

            {{-- Tombol Kembali ke Halaman Profil --}}
            <a href="{{ route('profile.show') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs uppercase tracking-wider transition border border-slate-200 shrink-0">
                <i class="fa-solid fa-arrow-left text-orange-500"></i>
                <span>Kembali ke Profil</span>
            </a>
        </div>

        {{-- Alert Notifikasi Status (Opsional) --}}
        @if (session('status') === 'profile-updated')
            <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-semibold flex items-center gap-3 shadow-sm">
                <div class="w-7 h-7 rounded-xl bg-emerald-100 flex items-center justify-center shrink-0">
                    <i class="fa-solid fa-check text-emerald-600"></i>
                </div>
                <span>Profil berhasil diperbarui.</span>
            </div>
        @endif

        {{-- Form Update Informasi Profil & Data Anggota --}}
        <div class="p-6 sm:p-8 bg-white border border-slate-200 shadow-xl rounded-[2rem]">
            <div class="max-w-2xl">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        {{-- Form Update Password --}}
        <div class="p-6 sm:p-8 bg-white border border-slate-200 shadow-xl rounded-[2rem]">
            <div class="max-w-2xl">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        {{-- Form Hapus Akun --}}
        <div class="p-6 sm:p-8 bg-white border border-slate-200 shadow-xl rounded-[2rem]">
            <div class="max-w-2xl">
                @include('profile.partials.delete-user-form')
            </div>
        </div>

    </div>
@endsection