@extends('layouts.app') {{-- Sesuaikan dengan layout utama Anda --}}

@section('content')
    @php
        $status = $pendaftaran->latestStatus->status ?? 'Tidak Diketahui';
        $keterangan = $pendaftaran->latestStatus->keterangan ?? 'Status pendaftaran tidak ditemukan.';
        
        $config = [
            'Menunggu Pembayaran' => [
                'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
                'color' => 'orange',
                'title' => 'Menunggu Pembayaran',
                'message' => 'Pendaftaran Anda berhasil. Silakan selesaikan pembayaran untuk melanjutkan ke tahap verifikasi.',
            ],
            'Pembayaran Diproses' => [
                'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z',
                'color' => 'amber',
                'title' => 'Pembayaran Sedang Diproses',
                'message' => 'Terima kasih, bukti pembayaran Anda telah kami terima dan sedang dalam proses verifikasi oleh admin. Mohon tunggu konfirmasi selanjutnya.',
                'animate' => true,
            ],
            'Pembayaran Ditolak' => [
                'icon' => 'M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636',
                'color' => 'red',
                'title' => 'Pembayaran Ditolak',
                'message' => $keterangan,
            ],
            'Aktif' => [
                'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
                'color' => 'emerald',
                'title' => 'Pendaftaran Berhasil!',
                'message' => 'Selamat! Pendaftaran Anda untuk pelatihan "' . $pendaftaran->pelatihan->judul . '" telah dikonfirmasi dan aktif.',
            ],
            'Ditolak' => [
                'icon' => 'M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636',
                'color' => 'red',
                'title' => 'Pendaftaran Ditolak',
                'message' => $keterangan,
            ],
        ];
        
        $currentConfig = $config[$status] ?? [
            'icon' => 'M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.79 4 4s-1.79 4-4 4c-1.742 0-3.223-.835-3.772-2M12 12h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
            'color' => 'slate',
            'title' => 'Status Tidak Diketahui',
            'message' => $keterangan,
        ];
    @endphp

    <div class="container mx-auto px-4 sm:px-6 py-8 sm:py-12 max-w-2xl relative space-y-6">

        {{-- Latar Belakang Dekoratif Glow Abstrak --}}
        <div class="absolute top-10 left-1/4 w-72 h-72 sm:w-96 sm:h-96 bg-orange-500/10 dark:bg-orange-500/5 rounded-full blur-3xl pointer-events-none -z-10"></div>
        <div class="absolute top-40 right-10 w-64 h-64 sm:w-80 sm:h-80 bg-orange-600/10 dark:bg-orange-600/5 rounded-full blur-3xl pointer-events-none -z-10"></div>

        {{-- Kartu Konten Utama --}}
        <div class="bg-white/80 dark:bg-slate-900/80 backdrop-blur-2xl rounded-[2rem] shadow-xl shadow-slate-200/50 dark:shadow-none border border-slate-200/80 dark:border-slate-800 p-6 sm:p-10 text-center relative overflow-hidden">
            
            {{-- Aksen Garis Atas Kartu --}}
            <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-orange-500 to-amber-500"></div>

            {{-- Ilustrasi / Icon dengan Efek Glassmorphism & Pulse --}}
            <div class="mx-auto flex items-center justify-center h-20 w-20 sm:h-24 sm:w-24 rounded-3xl bg-{{ $currentConfig['color'] }}-500/10 border border-{{ $currentConfig['color'] }}-500/20 mb-6 relative shadow-inner">
                @if (isset($currentConfig['animate']))
                    <div class="absolute inset-0 rounded-3xl border-2 border-{{ $currentConfig['color'] }}-500 border-t-transparent animate-spin"></div>
                @endif
                <svg class="h-9 w-9 sm:h-10 sm:w-10 text-{{ $currentConfig['color'] }}-600 dark:text-{{ $currentConfig['color'] }}-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $currentConfig['icon'] }}" />
                </svg>
            </div>

            {{-- Badge Status --}}
            <div class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-xs font-extrabold uppercase tracking-wider bg-{{ $currentConfig['color'] }}-500/10 text-{{ $currentConfig['color'] }}-600 dark:text-{{ $currentConfig['color'] }}-400 border border-{{ $currentConfig['color'] }}-500/20 mb-4">
                <span class="w-2 h-2 rounded-full bg-{{ $currentConfig['color'] }}-500 animate-pulse"></span>
                {{ $status }}
            </div>

            {{-- Judul & Keterangan --}}
            <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight mb-3">
                {{ $currentConfig['title'] }}
            </h2>
            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mb-8 leading-relaxed max-w-md mx-auto">
                {{ $currentConfig['message'] }}
            </p>

            {{-- Kotak Detail Informasi Transaksi --}}
            <div class="bg-slate-50/80 dark:bg-slate-800/40 rounded-2xl p-5 mb-8 text-left border border-slate-200/60 dark:border-slate-800 space-y-3 shadow-inner">
                <div class="flex justify-between items-center text-xs">
                    <span class="text-slate-400 font-bold uppercase tracking-wider text-[10px]">No. Pendaftaran:</span>
                    <span class="font-mono font-bold text-slate-800 dark:text-slate-200">#{{ str_pad($pendaftaran->id, 6, '0', STR_PAD_LEFT) }}</span>
                </div>
                <div class="flex justify-between items-center text-xs border-t border-slate-100 dark:border-slate-800/80 pt-2.5">
                    <span class="text-slate-400 font-bold uppercase tracking-wider text-[10px]">Pelatihan:</span>
                    <span class="font-bold text-slate-800 dark:text-slate-200 text-right truncate max-w-[200px] sm:max-w-xs">{{ $pendaftaran->pelatihan->judul }}</span>
                </div>
                <div class="flex justify-between items-center text-xs border-t border-slate-100 dark:border-slate-800/80 pt-2.5">
                    <span class="text-slate-400 font-bold uppercase tracking-wider text-[10px]">Tanggal Daftar:</span>
                    <span class="font-semibold text-slate-700 dark:text-slate-300">{{ $pendaftaran->created_at->format('d M Y, H:i') }}</span>
                </div>
            </div>

            {{-- Tombol Aksi --}}
            <div class="space-y-3">
                @if ($status === 'Menunggu Pembayaran')
                    <a href="{{ route('user-pelatihan.payment', $pendaftaran->id) }}"
                        class="w-full flex items-center justify-center gap-2 py-3.5 px-5 bg-orange-500 hover:bg-orange-600 text-white font-bold text-xs sm:text-sm rounded-xl shadow-lg shadow-orange-500/25 transition-all duration-200 hover:scale-[1.02]">
                        <span>Lanjutkan Pembayaran</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </a>
                @elseif ($status === 'Pembayaran Ditolak')
                    <a href="{{ route('user-pelatihan.payment', $pendaftaran->id) }}"
                        class="w-full flex items-center justify-center gap-2 py-3.5 px-5 bg-red-600 hover:bg-red-700 text-white font-bold text-xs sm:text-sm rounded-xl shadow-lg shadow-red-500/25 transition-all duration-200 hover:scale-[1.02]">
                        <span>Unggah Ulang Bukti Pembayaran</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                    </a>
                @endif

                <a href="{{ route('user-pelatihan.index') }}"
                    class="w-full flex items-center justify-center gap-2 py-3.5 px-5 bg-white dark:bg-slate-800 hover:bg-slate-50 dark:hover:bg-slate-750 text-slate-700 dark:text-slate-200 font-bold text-xs sm:text-sm rounded-xl border border-slate-200 dark:border-slate-800 transition-all shadow-xs">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                    <span>Kembali ke Daftar Pelatihan</span>
                </a>
            </div>

        </div>
    </div>
@endsection