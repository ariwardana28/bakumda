@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
    <div class="max-w-xl mx-auto py-8 px-4 space-y-6">

        {{-- Kartu Utama Profil --}}
        <div class="bg-white border border-slate-200 rounded-3xl shadow-xl overflow-hidden relative">
            
            {{-- Header Background Banner dengan Aksen Gradasi --}}
            <div class="h-32 bg-gradient-to-r from-orange-500 to-amber-500 relative">
                <div class="absolute inset-0 bg-[radial-gradient(#ffffff_1px,transparent_1px)] [background-size:12px_12px] opacity-15"></div>
            </div>

            {{-- Informasi Profil Pengguna --}}
            <div class="px-6 pb-8 pt-0 relative flex flex-col items-center text-center">
                
                {{-- Foto Profil --}}
                <div class="-mt-16 mb-4 relative">
                    <div class="w-32 h-32 rounded-full border-4 border-white shadow-md bg-slate-100 overflow-hidden flex items-center justify-center">
                        @if (Auth::user()->anggota && Auth::user()->anggota->foto)
                            <img src="{{ asset('storage/' . Auth::user()->anggota->foto) }}" alt="Foto Profil" class="w-full h-full object-cover">
                        @else
                            <div class="flex flex-col items-center justify-center text-slate-400">
                                <i class="fa-solid fa-user text-4xl"></i>
                            </div>
                        @endif
                    </div>
                    <span class="absolute bottom-1 right-2 w-6 h-6 bg-emerald-500 border-2 border-white rounded-full flex items-center justify-center text-white text-[10px]" title="Aktif">
                        <i class="fa-solid fa-check"></i>
                    </span>
                </div>

                {{-- Nama & Data Umum --}}
                <h1 class="text-xl font-black text-slate-900 tracking-tight">
                    {{ Auth::user()->anggota->nama ?? Auth::user()->name }}
                </h1>
                <p class="text-xs font-semibold text-orange-600 mt-0.5">
                    {{ Auth::user()->anggota->jenis_kelamin ?? 'Anggota / Pengguna' }}
                </p>
                <p class="text-xs text-slate-400 mt-1">
                    {{ Auth::user()->email }}
                </p>

                {{-- INFORMASI ORGANISASI: AD/ART & STRUKTUR ORGANISASI --}}
                <div class="w-full mt-6 pt-6 border-t border-slate-100 text-left space-y-3">
                    <h3 class="text-xs font-black uppercase tracking-wider text-slate-400">Informasi Organisasi</h3>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        {{-- Tombol/Menu AD/ART --}}
                        <a href="#" class="p-4 rounded-2xl bg-orange-50/50 hover:bg-orange-50 border border-orange-200/60 transition flex items-center justify-between group">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-orange-500 text-white flex items-center justify-center text-sm shadow-sm">
                                    <i class="fa-solid fa-book-bookmark"></i>
                                </div>
                                <div>
                                    <h4 class="text-xs font-bold text-slate-900 group-hover:text-orange-600 transition">AD / ART</h4>
                                    <span class="text-[10px] text-slate-500">Anggaran Dasar & Rumah Tangga</span>
                                </div>
                            </div>
                            <i class="fa-solid fa-chevron-right text-xs text-slate-400 group-hover:translate-x-1 transition-transform"></i>
                        </a>

                        {{-- Tombol/Menu Struktur Organisasi --}}
                        <a href="#" class="p-4 rounded-2xl bg-orange-50/50 hover:bg-orange-50 border border-orange-200/60 transition flex items-center justify-between group">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-orange-500 text-white flex items-center justify-center text-sm shadow-sm">
                                    <i class="fa-solid fa-sitemap"></i>
                                </div>
                                <div>
                                    <h4 class="text-xs font-bold text-slate-900 group-hover:text-orange-600 transition">Struktur Organisasi</h4>
                                    <span class="text-[10px] text-slate-500">Bagan & Kepengurusan</span>
                                </div>
                            </div>
                            <i class="fa-solid fa-chevron-right text-xs text-slate-400 group-hover:translate-x-1 transition-transform"></i>
                        </a>
                    </div>
                </div>

                {{-- Tombol Aksi Profil --}}
                <div class="w-full mt-6 pt-6 border-t border-slate-100 flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('profile.edit') }}" 
                       class="flex-1 py-3 px-4 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs uppercase tracking-wider transition flex items-center justify-center gap-2 border border-slate-200">
                        <i class="fa-solid fa-user-pen text-orange-500"></i>
                        <span>Edit Profil</span>
                    </a>

                    <form action="{{ route('logout') }}" method="POST" class="flex-1">
                        @csrf
                        <button type="submit" 
                            class="w-full py-3 px-4 rounded-2xl bg-rose-50 hover:bg-rose-100 text-rose-600 font-bold text-xs uppercase tracking-wider transition flex items-center justify-center gap-2 border border-rose-200">
                            <i class="fa-solid fa-right-from-bracket"></i>
                            <span>Keluar Akun</span>
                        </button>
                    </form>
                </div>

            </div>
        </div>

    </div>
@endsection