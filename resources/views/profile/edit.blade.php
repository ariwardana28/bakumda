@extends('layouts.admin')

@section('content')
    <div class="space-y-8 max-w-5xl mx-auto pb-10">
        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white/80 dark:bg-slate-900/80 backdrop-blur-xl p-6 sm:p-8 rounded-3xl border border-slate-100 dark:border-slate-800 shadow-xl shadow-slate-100/70 dark:shadow-slate-950/40">
            <div class="space-y-1">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-blue-50 dark:bg-blue-950/50 text-blue-600 dark:text-blue-400 text-xs font-bold uppercase tracking-wider border border-blue-100 dark:border-blue-900 shadow-sm">
                    <span class="w-2 h-2 rounded-full bg-blue-600 animate-pulse"></span>
                    Pengaturan Akun
                </span>
                <h1 class="text-xl sm:text-2xl font-black text-slate-900 dark:text-slate-100 tracking-tight">Profil Pengguna</h1>
                <p class="text-sm text-slate-500 dark:text-slate-400 font-medium">Kelola informasi profil, keamanan sandi, dan preferensi akun Anda secara aman.</p>
            </div>
        </div>

        <!-- Form Update Profile Information -->
        <div class="bg-white/90 dark:bg-slate-900/90 backdrop-blur-xl rounded-3xl p-6 sm:p-8 shadow-xl shadow-slate-100/70 dark:shadow-slate-950/40 border border-slate-100 dark:border-slate-800 transition-all">
            @include('profile.partials.update-profile-information-form')
        </div>

        <!-- Form Update Password -->
        <div class="bg-white/90 dark:bg-slate-900/90 backdrop-blur-xl rounded-3xl p-6 sm:p-8 shadow-xl shadow-slate-100/70 dark:shadow-slate-950/40 border border-slate-100 dark:border-slate-800 transition-all">
            @include('profile.partials.update-password-form')
        </div>

        <!-- Form Delete User -->
        <div class="bg-white/90 dark:bg-slate-900/90 backdrop-blur-xl rounded-3xl p-6 sm:p-8 shadow-xl shadow-slate-100/70 dark:shadow-slate-950/40 border border-slate-100 dark:border-slate-800 transition-all">
            @include('profile.partials.delete-user-form')
        </div>
    </div>
@endsection