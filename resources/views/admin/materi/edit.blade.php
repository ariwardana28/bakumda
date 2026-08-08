@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-4xl">
    {{-- Header Section --}}
    <div class="mb-8">
        <nav class="text-sm font-medium text-gray-500 mb-2">
            <ol class="list-none p-0 inline-flex items-center space-x-2">
                <li><a href="{{ route('admin.pelatihan.index') }}" class="hover:text-indigo-600 transition">Manajemen Pelatihan</a></li>
                <li><a href="{{ route('admin.pelatihan.materi.index', $materi->pelatihan_id) }}" class="hover:text-indigo-600 transition">Materi: {{ Str::limit($materi->pelatihan->judul, 25) }}</a></li>
                <li><span class="text-gray-300">/</span></li>
                <li class="text-gray-800 font-semibold">Edit Materi</li>
            </ol>
        </nav>
        <h2 class="text-3xl font-bold text-gray-800 tracking-tight">Edit Materi</h2>
        <p class="text-sm text-gray-500 mt-1">Perbarui informasi atau file modul pembelajaran melalui formulir di bawah ini.</p>
    </div>

    {{-- Form Card --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 sm:p-8 border-b border-gray-100 flex items-center gap-3">
            <div class="p-2 bg-indigo-50 rounded-xl text-indigo-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
            </div>
            <div>
                <h3 class="text-lg font-bold text-gray-800">Formulir Edit Materi</h3>
                <p class="text-xs text-gray-400">Pastikan data yang diubah sudah benar</p>
            </div>
        </div>

        <div class="p-6 sm:p-8">
            <form action="{{ route('admin.pelatihan.materi.update', ['pelatihan' => $materi->pelatihan_id, 'materi' => $materi->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                {{-- Include Form Partial --}}
                <div class="space-y-6">
                    @include('admin.materi._form', ['materi' => $materi, 'pelatihan' => $materi->pelatihan])
                </div>

                {{-- Action Buttons --}}
                <div class="flex items-center justify-end gap-3 pt-6 mt-8 border-t border-gray-100">
                    <a href="{{ route('admin.pelatihan.materi.index', $materi->pelatihan_id) }}" class="px-5 py-2.5 rounded-xl border border-gray-200 text-gray-600 hover:bg-gray-50 font-semibold text-sm transition duration-200">
                        Batal
                    </a>
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-sm shadow-lg shadow-indigo-200 transition duration-200">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection