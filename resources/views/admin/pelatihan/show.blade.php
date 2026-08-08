@extends('layouts.admin') {{-- Sesuaikan dengan layout admin Anda --}}

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 space-y-6">
    {{-- Header & Tombol Aksi --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Detail Pelatihan</h1>
            <p class="text-xs text-gray-400 mt-0.5">Informasi lengkap mengenai jadwal, harga, dan kuota pelatihan</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.pelatihan.index') }}"
                class="px-4 py-2 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-600 font-semibold text-sm transition duration-200 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali
            </a>
            @can('pelatihan-edit')
            <a href="{{ route('admin.pelatihan.edit', $pelatihan->id) }}"
                class="px-5 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-sm shadow-md shadow-indigo-100 transition duration-200 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit Pelatihan
            </a>
            @endcan
        </div>
    </div>

    {{-- Kartu Konten Utama --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            {{-- Kolom Gambar Banner (Kiri) --}}
            <div class="lg:col-span-4">
                <div class="w-full h-64 lg:h-72 bg-gray-50 border border-gray-200 rounded-2xl overflow-hidden shadow-inner flex items-center justify-center">
                    @if($pelatihan->gambar)
                        <img src="{{ Storage::url($pelatihan->gambar) }}" class="w-full h-full object-cover" alt="Gambar Pelatihan">
                    @else
                        <div class="flex flex-col items-center text-center p-4 text-gray-400">
                            <svg class="w-12 h-12 mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span class="text-xs font-medium text-gray-400">Tidak ada gambar banner</span>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Kolom Detail Informasi (Kanan) --}}
            <div class="lg:col-span-8 space-y-6">
                <div>
                    <h2 class="text-xl md:text-2xl font-bold text-gray-800">{{ $pelatihan->judul }}</h2>
                </div>

                <div class="border-t border-gray-100 pt-6">
                    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4 text-sm">
                        <div class="space-y-1">
                            <dt class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Status Pelatihan</dt>
                            <dd>
                                <span class="px-3 py-1 text-xs font-semibold rounded-full inline-block
                                    @if($pelatihan->status == 'akan datang') bg-blue-50 text-blue-600 border border-blue-100
                                    @elseif($pelatihan->status == 'berlangsung') bg-amber-50 text-amber-600 border border-amber-100
                                    @elseif($pelatihan->status == 'selesai') bg-emerald-50 text-emerald-600 border border-emerald-100
                                    @else bg-red-50 text-red-600 border border-red-100 @endif">
                                    {{ Str::title($pelatihan->status) }}
                                </span>
                            </dd>
                        </div>

                        <div class="space-y-1">
                            <dt class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Harga Biaya</dt>
                            <dd class="text-gray-800 font-semibold text-base">
                                Rp {{ number_format($pelatihan->harga, 0, ',', '.') }}
                            </dd>
                        </div>

                        <div class="space-y-1 sm:col-span-2">
                            <dt class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Jadwal Pelaksanaan</dt>
                            <dd class="text-gray-700 font-medium flex items-center gap-2">
                                <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                {{ $pelatihan->tanggal_mulai->format('d M Y, H:i') }} s/d {{ $pelatihan->tanggal_selesai->format('d M Y, H:i') }}
                            </dd>
                        </div>

                        <div class="space-y-1">
                            <dt class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Kuota Peserta</dt>
                            <dd class="text-gray-700 font-medium">
                                {{ $pelatihan->kuota ? $pelatihan->kuota . ' Peserta' : 'Tidak terbatas' }}
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>

        {{-- Bagian Deskripsi Lengkap --}}
        <div class="mt-8 pt-6 border-t border-gray-100 space-y-3">
            <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wider">Deskripsi Lengkap</h3>
            <div class="text-gray-600 text-sm leading-relaxed bg-gray-50/50 p-5 rounded-xl border border-gray-100">
                {!! nl2br(e($pelatihan->deskripsi)) !!}
            </div>
        </div>
    </div>
</div>
@endsection