@extends('layouts.app')

@section('title', 'Hasil Verifikasi Sertifikat')

@section('content')
    @php
        // Ambil data penting dari relasi
        $pelatihan = optional(optional(optional($sertifikat->nilai)->first())->pelatihanAnggota)->pelatihan;
        $peserta = optional(optional(optional($sertifikat->nilai)->first())->pelatihanAnggota)->user;
        $tanggalTerbit = optional($sertifikat->nilai->first())->created_at;
    @endphp

    <div class="max-w-3xl mx-auto py-10">
        <div
            class="bg-white/80 dark:bg-slate-900/80 backdrop-blur-2xl rounded-3xl shadow-xl shadow-slate-200/50 dark:shadow-none border border-slate-200/80 dark:border-slate-800 p-8 sm:p-12 text-center space-y-6">

            {{-- Header dengan Ikon Centang --}}
            <div class="relative w-20 h-20 mx-auto flex items-center justify-center">
                <div class="absolute inset-0 rounded-2xl bg-emerald-500/20 blur-xl animate-pulse"></div>
                <div
                    class="relative w-20 h-20 rounded-2xl bg-gradient-to-br from-emerald-500 to-green-600 text-white flex items-center justify-center text-3xl shadow-lg shadow-emerald-500/30">
                    <i class="fa-solid fa-check-circle"></i>
                </div>
            </div>

            {{-- Judul dan Sub-judul --}}
            <div class="space-y-2">
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-white tracking-tight">
                    Sertifikat Terverifikasi
                </h1>
                <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 leading-relaxed max-w-md mx-auto">
                    Dokumen ini dinyatakan <span class="font-bold text-emerald-600 dark:text-emerald-400">ASLI</span> dan
                    diterbitkan secara resmi oleh sistem kami.
                </p>
            </div>

            {{-- Detail Sertifikat --}}
            <div
                class="pt-6 text-left text-xs sm:text-sm space-y-3 border-t border-slate-200/80 dark:border-slate-800">
                <div
                    class="flex justify-between items-center p-3 rounded-xl bg-slate-50/70 dark:bg-slate-800/40 border border-slate-100 dark:border-slate-800">
                    <span class="text-slate-500 dark:text-slate-400 font-medium">Nomor Sertifikat</span>
                    <span
                        class="font-bold text-slate-800 dark:text-slate-200 font-mono tracking-wider">{{ $sertifikat->no_sertifikat }}</span>
                </div>
                <div
                    class="flex justify-between items-center p-3 rounded-xl bg-slate-50/70 dark:bg-slate-800/40 border border-slate-100 dark:border-slate-800">
                    <span class="text-slate-500 dark:text-slate-400 font-medium">Nama Peserta</span>
                    <span
                        class="font-bold text-slate-800 dark:text-slate-200 uppercase">{{ $peserta->name ?? 'Nama Tidak Ditemukan' }}</span>
                </div>
                <div
                    class="flex justify-between items-center p-3 rounded-xl bg-slate-50/70 dark:bg-slate-800/40 border border-slate-100 dark:border-slate-800">
                    <span class="text-slate-500 dark:text-slate-400 font-medium">Nama Pelatihan</span>
                    <span
                        class="font-bold text-slate-800 dark:text-slate-200 text-right">{{ $pelatihan->judul ?? 'Nama Pelatihan Tidak Ditemukan' }}</span>
                </div>
                <div
                    class="flex justify-between items-center p-3 rounded-xl bg-slate-50/70 dark:bg-slate-800/40 border border-slate-100 dark:border-slate-800">
                    <span class="text-slate-500 dark:text-slate-400 font-medium">Tanggal Terbit</span>
                    <span class="font-bold text-slate-800 dark:text-slate-200">
                        {{ $tanggalTerbit ? $tanggalTerbit->translatedFormat('d F Y') : 'Tidak Diketahui' }}
                    </span>
                </div>
            </div>

            {{-- Tombol Kembali --}}
            <div class="pt-6">
                <a href="{{ route('kartu-anggota.cek.form') }}"
                    class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 font-bold text-xs shadow-sm transition-all duration-200">
                    <i class="fa-solid fa-arrow-left"></i>
                    <span>Cek Sertifikat Lain</span>
                </a>
            </div>

        </div>
    </div>
@endsection