@extends('layouts.admin')

@section('content')
<div class="container  ">
    {{-- Header Section --}}
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-gray-800 tracking-tight">Tambah Materi Baru</h2>
        <p class="text-sm text-gray-500 mt-1">Silakan isi formulir di bawah ini untuk menambahkan modul atau materi pembelajaran baru.</p>
    </div>

    {{-- Form Card --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 sm:p-8 border-b border-gray-100 flex items-center gap-3">
            <div class="p-2 bg-indigo-50 rounded-xl text-indigo-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
            </div>
            <div>
                <h3 class="text-lg font-bold text-gray-800">Formulir Materi</h3>
                <p class="text-xs text-gray-400">Pastikan semua informasi wajib terisi dengan benar</p>
            </div>
        </div>

        <div class="p-6 sm:p-8">
            <form action="{{ route('admin.pelatihan.materi.store', $pelatihan->id) }}" method="POST" enctype="multipart/form-data" novalidate>
                @csrf
                
                {{-- Include Form Partial --}}
                <div class="space-y-1">
                    @include('admin.materi._form', ['materi' => null])
                </div>

                {{-- Action Buttons --}}
                <div class="flex items-center justify-end gap-3 pt-6 mt-8 border-t border-gray-100">
                    @php
                        $cancelUrl = isset($pelatihan) ? route('admin.pelatihan.materi.index', $pelatihan->id) : route('admin.materi.index');
                    @endphp
                    @php $cancelUrl = route('admin.pelatihan.materi.index', $pelatihan->id); @endphp
                    <a href="{{ $cancelUrl }}" class="px-5 py-2.5 rounded-xl border border-gray-200 text-gray-600 hover:bg-gray-50 font-semibold text-sm transition duration-200">
                        Batal
                    </a>
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-sm shadow-lg shadow-indigo-200 transition duration-200">
                        Simpan Materi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection