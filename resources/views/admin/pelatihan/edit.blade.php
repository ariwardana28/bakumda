@extends('layouts.admin')

@section('content')
<div class="container mx-auto ">
    {{-- Header Section --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8 gap-4">
        <div>
            <h2 class="text-3xl font-bold text-gray-850 tracking-tight">Edit Pelatihan</h2>
            <p class="text-sm text-gray-500 mt-1">Perbarui informasi jadwal dan detail untuk program pelatihan ini.</p>
        </div>
        <a href="{{ route('admin.pelatihan.index') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold text-sm transition duration-200">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Daftar
        </a>
    </div>

    {{-- Main Form Card --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 md:p-8 border-b border-gray-100 flex items-center gap-3 bg-gray-50/50">
            <div class="p-2.5 bg-amber-50 rounded-xl text-amber-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
            </div>
            <div>
                <h3 class="text-lg font-bold text-gray-800">Formulir Edit Pelatihan</h3>
                <p class="text-xs text-gray-400">Sedang mengubah data untuk: <span class="font-semibold text-gray-600">{{ $pelatihan->judul }}</span></p>
            </div>
        </div>

        <div class="p-6 md:p-8">
            <form action="{{ route('admin.pelatihan.update', $pelatihan->id) }}" method="POST" enctype="multipart/form-data">
                @method('PUT')
                @include('admin.pelatihan._form', ['pelatihan' => $pelatihan])
            </form>
        </div>
    </div>
</div>
@endsection