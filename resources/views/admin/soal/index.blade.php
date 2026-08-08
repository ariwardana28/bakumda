@extends('layouts.admin')

@section('content')
    <div class="container mx-auto space-y-6">
        {{-- Header & Breadcrumb / Navigasi Kembali --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <a href="{{ route('admin.pelatihan.materi.index', $materi->pelatihan_id) }}" 
                       class="inline-flex items-center gap-1.5 text-xs font-semibold text-indigo-600 hover:text-indigo-800 bg-indigo-50 hover:bg-indigo-100 px-3 py-1.5 rounded-lg transition duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali ke Daftar Materi
                    </a>
                </div>
                <h2 class="text-2xl md:text-3xl font-bold text-gray-800 tracking-tight">Soal Evaluasi: {{ $materi->judul }}</h2>
                <p class="text-sm text-gray-500 mt-1">Kelola daftar pertanyaan pilihan ganda dan kunci jawaban untuk materi ini.</p>
            </div>
            
            <a href="{{ route('admin.materi.soal.create', $materi->id) }}"
                class="inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-sm shadow-lg shadow-indigo-200 transition duration-200 whitespace-nowrap">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Soal Baru
            </a>
        </div>

        {{-- Main Card --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-bold text-gray-800">Daftar Pertanyaan</h3>
                    <p class="text-xs text-gray-400 mt-0.5">Total: {{ $soalList->total() ?? count($soalList) }} soal tersedia</p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/70 border-b border-gray-100 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            <th class="py-4 px-6 w-16 text-center">No</th>
                            <th class="py-4 px-6">Pertanyaan & Pilihan Jawaban</th>
                            <th class="py-4 px-6 text-center w-32">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm text-gray-600">
                        @forelse ($soalList as $soal)
                            <tr class="hover:bg-gray-50/50 transition duration-150 align-top">
                                <td class="py-5 px-6 font-semibold text-gray-400 text-center">
                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-xl bg-gray-100 text-gray-600 text-xs font-bold">
                                        {{ $loop->iteration + $soalList->firstItem() - 1 }}
                                    </span>
                                </td>
                                <td class="py-5 px-6 space-y-3">
                                    <div class="font-bold text-gray-800 text-base leading-relaxed">
                                        {{ $soal->soal }}
                                    </div>
                                    
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 pt-1">
                                        @foreach ($soal->jawaban as $jawaban)
                                            <div class="flex items-start gap-2.5 p-2.5 rounded-xl border {{ $jawaban->status == 1 ? 'border-emerald-200 bg-emerald-50/60 text-emerald-900 font-medium' : 'border-gray-100 bg-gray-50/50 text-gray-600' }}">
                                                <span class="flex-shrink-0 w-5 h-5 rounded-full flex items-center justify-center text-xs font-bold {{ $jawaban->status == 1 ? 'bg-emerald-600 text-white' : 'bg-gray-200 text-gray-600' }}">
                                                    {{ strtoupper(chr(97 + $loop->index)) }}
                                                </span>
                                                <span class="text-xs leading-relaxed flex-1">{{ $jawaban->jawaban }}</span>
                                                @if ($jawaban->status == 1)
                                                    <span class="flex-shrink-0 text-emerald-600" title="Kunci Jawaban">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                        </svg>
                                                    </span>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="py-5 px-6 text-center whitespace-nowrap">
                                    <div class="inline-flex items-center justify-center gap-1.5">
                                        <a href="{{ route('admin.materi.soal.edit', ['materi' => $materi->id, 'soal' => $soal->id]) }}"
                                            class="p-2.5 bg-amber-50 text-amber-600 hover:bg-amber-100 rounded-xl transition duration-200"
                                            title="Edit Soal">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                </path>
                                            </svg>
                                        </a>
                                        <form
                                            action="{{ route('admin.materi.soal.destroy', ['materi' => $materi->id, 'soal' => $soal->id]) }}"
                                            method="POST" class="inline-block"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus soal ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="p-2.5 bg-red-50 text-red-600 hover:bg-red-100 rounded-xl transition duration-200"
                                                title="Hapus Soal">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                    </path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="py-16 text-center">
                                    <div class="flex flex-col items-center justify-center space-y-3">
                                        <div class="w-12 h-12 rounded-full bg-gray-50 flex items-center justify-center text-gray-400">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        <p class="text-sm font-semibold text-gray-600">Belum ada soal untuk materi ini.</p>
                                        <p class="text-xs text-gray-400">Silakan tambahkan soal evaluasi agar peserta dapat menguji pemahaman.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($soalList->hasPages())
                <div class="p-6 border-t border-gray-100 bg-gray-50/35">
                    {{ $soalList->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection