@extends('layouts.admin')

@section('content')
<div class="container mx-auto">
    {{-- Header Section --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8 gap-4">
        <div>
            <h2 class="text-3xl font-bold text-gray-850 tracking-tight">Tambah Pelatihan Baru</h2>
            <p class="text-sm text-gray-500 mt-1">Buat dan jadwalkan program pelatihan baru ke dalam sistem.</p>
        </div>
        <a href="{{ route('admin.pelatihan.index') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold text-sm transition duration-200">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Daftar
        </a>
    </div>

    {{-- Main Form Card --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 md:p-8 border-b border-gray-100 flex items-center gap-3 bg-gray-50/50">
            <div class="p-2.5 bg-indigo-50 rounded-xl text-indigo-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <h3 class="text-lg font-bold text-gray-800">Formulir Pelatihan</h3>
                <p class="text-xs text-gray-400">Pastikan semua kolom bertanda bintang (<span class="text-red-500">*</span>) terisi dengan benar.</p>
            </div>
        </div>

        <div class="p-6 md:p-8">
            <form action="{{ route('admin.pelatihan.store') }}" method="POST" enctype="multipart/form-data">
                {{-- Memanggil partial form yang sudah diperbarui dengan style Tailwind sebelumnya --}}
                @include('admin.pelatihan._form')
            </form>
        </div>
    </div>
</div>
@endsection