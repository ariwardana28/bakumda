@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#f8fafc] py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto space-y-6">

        <!-- Header Halaman -->
        <div class="bg-white rounded-2xl sm:rounded-3xl border border-[#e2e8f0] p-6 sm:p-8 shadow-xs">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700 tracking-wide border border-indigo-100/60 mb-2">
                Modul Kerja Sama
            </span>
            <h1 class="text-xl sm:text-2xl font-bold text-[#1e293b] tracking-tight">
                {{ isset($kerjasama) ? 'Ubah Kerja Sama' : 'Tambah Kerja Sama Baru' }}
            </h1>
            <p class="text-sm text-[#64748b] mt-1">
                Lengkapi informasi detail mitra dan berkas dokumen kerja sama.
            </p>
        </div>

        <!-- Tampilkan Error Validasi jika ada -->
        @if ($errors->any())
            <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-700 text-xs shadow-xs">
                <span class="font-bold block mb-1">Terjadi kesalahan pengisian form:</span>
                <ul class="list-disc pl-4 space-y-0.5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form Utama (Tanpa Alpine.js submitting) -->
        <form action="{{ isset($kerjasama) ? route('user-kerjasamas.update', $kerjasama->id) : route('user-kerjasamas.store') }}" 
              method="POST" 
              enctype="multipart/form-data" 
              class="space-y-6">
            @csrf
            @if(isset($kerjasama))
                @method('PUT')
            @endif

            <div class="bg-white rounded-2xl sm:rounded-3xl border border-[#e2e8f0] p-6 sm:p-8 shadow-xs space-y-6">
                
                <!-- Judul -->
                <div class="space-y-1.5">
                    <label for="judul" class="block text-xs font-semibold text-[#1e293b] uppercase tracking-wider">
                        JUDUL KERJA SAMA <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" 
                           id="judul" 
                           name="judul" 
                           value="{{ old('judul', $kerjasama->judul ?? '') }}" 
                           placeholder="Contoh: MoU Pengembangan Sistem Akademik..." 
                           class="w-full px-4 py-2.5 bg-[#f8fafc] border border-[#e2e8f0] rounded-xl text-sm text-[#1e293b] focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition" 
                           required>
                </div>

                <!-- Mitra -->
                <div class="space-y-1.5">
                    <label for="mitra" class="block text-xs font-semibold text-[#1e293b] uppercase tracking-wider">
                        NAMA MITRA <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" 
                           id="mitra" 
                           name="mitra" 
                           value="{{ old('mitra', $kerjasama->mitra ?? '') }}" 
                           placeholder="Contoh: PT Teknologi Nusantara / Universitas Terkait" 
                           class="w-full px-4 py-2.5 bg-[#f8fafc] border border-[#e2e8f0] rounded-xl text-sm text-[#1e293b] focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition" 
                           required>
                </div>

                <!-- Tanggal Mulai & Selesai -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1.5">
                        <label for="tanggal_mulai" class="block text-xs font-semibold text-[#1e293b] uppercase tracking-wider">
                            TANGGAL MULAI <span class="text-rose-500">*</span>
                        </label>
                        <input type="date" 
                               id="tanggal_mulai" 
                               name="tanggal_mulai" 
                               value="{{ old('tanggal_mulai', isset($kerjasama->tanggal_mulai) ? \Carbon\Carbon::parse($kerjasama->tanggal_mulai)->format('Y-m-d') : '') }}" 
                               class="w-full px-4 py-2.5 bg-[#f8fafc] border border-[#e2e8f0] rounded-xl text-sm text-[#1e293b] focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition" 
                               required>
                    </div>
                    <div class="space-y-1.5">
                        <label for="tanggal_selesai" class="block text-xs font-semibold text-[#1e293b] uppercase tracking-wider">
                            TANGGAL SELESAI <span class="text-rose-500">*</span>
                        </label>
                        <input type="date" 
                               id="tanggal_selesai" 
                               name="tanggal_selesai" 
                               value="{{ old('tanggal_selesai', isset($kerjasama->tanggal_selesai) ? \Carbon\Carbon::parse($kerjasama->tanggal_selesai)->format('Y-m-d') : '') }}" 
                               class="w-full px-4 py-2.5 bg-[#f8fafc] border border-[#e2e8f0] rounded-xl text-sm text-[#1e293b] focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition" 
                               required>
                    </div>
                </div>

                <!-- Status -->
                <input type="hidden" name="status" value="pending">
                
                <!-- Deskripsi -->
                <div class="space-y-1.5">
                    <label for="deskripsi" class="block text-xs font-semibold text-[#1e293b] uppercase tracking-wider">
                        DESKRIPSI Kerja Sama
                    </label>
                    <textarea id="deskripsi" 
                              name="deskripsi" 
                              rows="4" 
                              placeholder="Tulis ringkasan atau ruang lingkup kerja sama..." 
                              class="w-full px-4 py-2.5 bg-[#f8fafc] border border-[#e2e8f0] rounded-xl text-sm text-[#1e293b] focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition">{{ old('deskripsi', $kerjasama->deskripsi ?? '') }}</textarea>
                </div>

                <!-- File Dokumen -->
                <div class="space-y-1.5">
                    <label for="file_dokumen" class="block text-xs font-semibold text-[#1e293b] uppercase tracking-wider">
                        FILE DOKUMEN (PDF / DOC / DOCX)
                    </label>
                    <input type="file" 
                           id="file_dokumen" 
                           name="file_dokumen" 
                           accept=".pdf,.doc,.docx"
                           class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition">
                    @if(isset($kerjasama->file_dokumen) && $kerjasama->file_dokumen)
                        <p class="text-xs text-slate-500 mt-1">File saat ini: <a href="{{ asset('storage/' . $kerjasama->file_dokumen) }}" target="_blank" class="text-indigo-600 underline">Lihat Dokumen</a></p>
                    @endif
                </div>

            </div>

            <!-- Action Buttons (Tanpa script penahan tombol) -->
            <div class="flex items-center justify-end space-x-3 pt-2">
                <a href="{{ route('user-kerjasamas.index') }}" 
                   class="px-5 py-2.5 rounded-xl border border-[#e2e8f0] bg-white text-[#64748b] hover:bg-slate-50 text-sm font-semibold transition">
                    Batal
                </a>
                <button type="submit" 
                        class="px-6 py-2.5 rounded-xl bg-indigo-600 text-white text-sm font-semibold hover:bg-indigo-500 transition shadow-xs">
                    Simpan Kerja Sama
                </button>
            </div>

        </form>

    </div>
</div>
@endsection