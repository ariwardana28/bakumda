@extends('layouts.admin')

@section('content')
<div class="container mx-auto space-y-6">
    {{-- Navigasi Kembali & Header --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-2">
                <a href="{{ route('admin.materi.soal.index', $materi->id) }}" 
                   class="inline-flex items-center gap-1.5 text-xs font-semibold text-indigo-600 hover:text-indigo-800 bg-indigo-50 hover:bg-indigo-100 px-3 py-1.5 rounded-lg transition duration-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali ke Daftar Soal
                </a>
            </div>
            <h2 class="text-2xl md:text-3xl font-bold text-gray-800 tracking-tight">Tambah Soal Baru</h2>
            <p class="text-sm text-gray-500 mt-1">Materi: <span class="font-semibold text-gray-700">{{ $materi->judul }}</span></p>
        </div>
    </div>

    {{-- Main Form Card --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
        <form action="{{ route('admin.materi.soal.store', $materi->id) }}" method="POST">
            @csrf
            <div class="space-y-6">
                {{-- Pertanyaan Soal --}}
                <div>
                    <label for="soal" class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2">
                        Pertanyaan Soal <span class="text-red-500">*</span>
                    </label>
                    <textarea 
                        id="soal" 
                        name="soal" 
                        rows="4" 
                        class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 outline-none resize-none @error('soal') border-red-500 bg-red-50/50 @enderror" 
                        placeholder="Tuliskan isi pertanyaan atau soal di sini..." 
                        required>{{ old('soal') }}</textarea>
                    @error('soal')
                        <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Pilihan Jawaban --}}
                <div class="space-y-4 pt-2 border-t border-gray-100">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-indigo-50 rounded-xl text-indigo-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-800">Opsi Pilihan Jawaban</h3>
                            <p class="text-xs text-gray-400">Masukkan pilihan teks dan pilih salah satu radio button sebagai kunci jawaban benar.</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-3 pt-2">
                        @foreach (['A', 'B', 'C', 'D', 'E'] as $key => $option)
                            <div class="flex items-center gap-3 p-3 bg-gray-50/70 border border-gray-200 rounded-xl hover:border-indigo-300 transition duration-200">
                                <div class="flex items-center h-5">
                                    <input 
                                        type="radio" 
                                        id="jawaban_benar_{{ $key }}" 
                                        name="jawaban_benar" 
                                        value="{{ $key }}" 
                                        class="w-4 h-4 text-indigo-600 border-gray-300 focus:ring-indigo-500 cursor-pointer" 
                                        {{ old('jawaban_benar') == $key ? 'checked' : '' }} 
                                        required
                                        title="Tandai sebagai jawaban benar">
                                </div>
                                <label for="jawaban_benar_{{ $key }}" class="flex-shrink-0 w-6 h-6 rounded-lg bg-white border border-gray-200 flex items-center justify-center font-bold text-xs text-gray-700 shadow-xs cursor-pointer">
                                    {{ $option }}
                                </label>
                                <input 
                                    type="text" 
                                    name="jawaban[]" 
                                    class="w-full bg-transparent border-0 text-sm text-gray-800 focus:ring-0 focus:outline-none placeholder-gray-400" 
                                    placeholder="Tuliskan pilihan jawaban {{ $option }}..." 
                                    value="{{ old('jawaban.'.$key) }}" 
                                    required>
                            </div>
                        @endforeach
                    </div>
                    @error('jawaban_benar')
                        <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tombol Aksi --}}
                <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-100">
                    <a href="{{ route('admin.materi.soal.index', $materi->id) }}" 
                        class="px-6 py-3 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-600 font-semibold text-sm transition duration-200">
                        Batal
                    </a>
                    <button type="submit" 
                        class="px-8 py-3 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-sm shadow-lg shadow-indigo-200 transition duration-200 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Simpan Soal
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection