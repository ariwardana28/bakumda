@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 space-y-6">
    {{-- Header & Tombol Aksi --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Detail Materi</h1>
            <p class="text-xs text-gray-400 mt-0.5">Informasi lengkap mengenai status, dokumen, dan konten materi pembelajaran</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.pelatihan.materi.index', $materi->pelatihan_id) }}"
                class="px-4 py-2 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-600 font-semibold text-sm transition duration-200 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali
            </a>
            @can('materi-edit')
            <a href="{{ route('admin.pelatihan.materi.edit', ['pelatihan' => $materi->pelatihan_id, 'materi' => $materi->id]) }}"
                class="px-5 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-sm shadow-md shadow-indigo-100 transition duration-200 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit Materi
            </a>
            @endcan
        </div>
    </div>

    {{-- Kartu Konten Utama --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            {{-- Kolom Gambar Banner (Kiri) --}}
            <div class="lg:col-span-4">
                <div class="w-full h-64 lg:h-72 bg-gray-50 border border-gray-200 rounded-2xl overflow-hidden shadow-inner flex items-center justify-center relative group">
                    @if($materi->gambar)
                        <img src="{{ Storage::url($materi->gambar) }}" class="w-full h-full object-cover" alt="Gambar Materi">
                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition duration-200 flex items-center justify-center">
                            <a href="{{ Storage::url($materi->gambar) }}" target="_blank" class="px-3 py-1.5 bg-white/90 hover:bg-white text-gray-800 text-xs font-semibold rounded-lg shadow transition">
                                Lihat Gambar Penuh
                            </a>
                        </div>
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
                    <h2 class="text-xl md:text-2xl font-bold text-gray-800">{{ $materi->judul }}</h2>
                </div>

                <div class="border-t border-gray-100 pt-6">
                    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4 text-sm">
                        <div class="space-y-1">
                            <dt class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Status Materi</dt>
                            <dd>
                                <span class="px-3 py-1 text-xs font-semibold rounded-full inline-block
                                    @if($materi->status == 'published') bg-emerald-50 text-emerald-600 border border-emerald-100
                                    @else bg-gray-100 text-gray-600 border border-gray-200 @endif">
                                    {{ Str::title($materi->status) }}
                                </span>
                            </dd>
                        </div>

                        <div class="space-y-1">
                            <dt class="text-xs font-semibold text-gray-400 uppercase tracking-wider">File Dokumen</dt>
                            <dd class="text-gray-800 font-medium">
                                @if($materi->file)
                                    <a href="{{ Storage::url($materi->file) }}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-indigo-50 hover:bg-indigo-100 text-indigo-600 text-xs font-semibold transition duration-200">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                        </svg>
                                        Unduh / Lihat File
                                    </a>
                                @else
                                    <span class="text-gray-400 italic">Tidak ada file</span>
                                @endif
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>

        {{-- Bagian Deskripsi Lengkap --}}
        <div class="mt-8 pt-6 border-t border-gray-100 space-y-3">
            <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wider">Deskripsi Materi</h3>
            <div class="text-gray-600 text-sm leading-relaxed bg-gray-50/50 p-5 rounded-xl border border-gray-100 whitespace-pre-wrap">
                {!! nl2br(e($materi->deskripsi)) !!}
            </div>
        </div>
    </div>
</div>
@endsection