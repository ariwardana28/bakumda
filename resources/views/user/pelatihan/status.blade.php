@extends('layouts.admin') {{-- Sesuaikan dengan layout utama Anda --}}

@section('content')
    @php
        $status = $pendaftaran->latestStatus->status ?? 'Tidak Diketahui';
        $keterangan = $pendaftaran->latestStatus->keterangan ?? 'Status pendaftaran tidak ditemukan.';
        
        $config = [
            'Menunggu Pembayaran' => [
                'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
                'color' => 'blue',
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
                'color' => 'green',
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
            'color' => 'gray',
            'title' => 'Status Tidak Diketahui',
            'message' => $keterangan,
        ];
    @endphp

    <div class="min-h-[80vh] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full bg-white rounded-3xl shadow-sm border border-gray-100 p-8 text-center">

            {{-- Ilustrasi / Icon --}}
            <div
                class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-{{ $currentConfig['color'] }}-50 border border-{{ $currentConfig['color'] }}-100 mb-6 relative">
                @if (isset($currentConfig['animate']))
                    <div
                        class="absolute inset-0 rounded-full border-4 border-{{ $currentConfig['color'] }}-200 border-t-{{ $currentConfig['color'] }}-600 animate-spin">
                    </div>
                @endif
                <svg class="h-8 w-8 text-{{ $currentConfig['color'] }}-600" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="{{ $currentConfig['icon'] }}" />
                </svg>
            </div>

            {{-- Badge Status --}}
            <span
                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-{{ $currentConfig['color'] }}-100 text-{{ $currentConfig['color'] }}-800 mb-4">
                {{ $status }}
            </span>

            {{-- Judul & Keterangan --}}
            <h2 class="text-2xl font-bold text-gray-800 mb-2">{{ $currentConfig['title'] }}</h2>
            <p class="text-sm text-gray-500 mb-8 leading-relaxed">
                {{ $currentConfig['message'] }}
            </p>

            {{-- Kotak Detail Informasi Transaksi (Opsional) --}}
            <div class="bg-gray-50 rounded-2xl p-4 mb-8 text-left border border-gray-100 space-y-2">
                <div class="flex justify-between text-xs">
                    <span class="text-gray-400">No. Pendaftaran:</span>
                    <span class="font-medium text-gray-700">#{{ str_pad($pendaftaran->id, 6, '0', STR_PAD_LEFT) }}</span>
                </div>
                <div class="flex justify-between text-xs">
                    <span class="text-gray-400">Pelatihan:</span>
                    <span class="font-medium text-gray-700 truncate">{{ $pendaftaran->pelatihan->judul }}</span>
                </div>
                <div class="flex justify-between text-xs">
                    <span class="text-gray-400">Tanggal Daftar:</span>
                    <span class="font-medium text-gray-700">{{ $pendaftaran->created_at->format('d M Y, H:i') }}</span>
                </div>
            </div>

            {{-- Tombol Aksi --}}
            <div class="space-y-3">
                @if ($status === 'Menunggu Pembayaran')
                    <a href="{{ route('user-pelatihan.payment', $pendaftaran->id) }}"
                        class="w-full block py-3 px-4 bg-indigo-600 hover:bg-indigo-700 text-white font-medium text-sm rounded-xl transition shadow-sm">
                        Lanjutkan Pembayaran
                    </a>
                @elseif ($status === 'Pembayaran Ditolak')
                    <a href="{{ route('user-pelatihan.payment', $pendaftaran->id) }}"
                        class="w-full block py-3 px-4 bg-red-600 hover:bg-red-700 text-white font-medium text-sm rounded-xl transition shadow-sm">
                        Unggah Ulang Bukti Pembayaran
                    </a>
                @endif

                <a href="{{ route('user-pelatihan.index') }}"
                    class="w-full block py-3 px-4 bg-gray-50 hover:bg-gray-100 text-gray-700 font-medium text-sm rounded-xl transition border border-gray-200">
                    Kembali ke Daftar Pelatihan
                </a>
            </div>

        </div>
    </div>
@endsection