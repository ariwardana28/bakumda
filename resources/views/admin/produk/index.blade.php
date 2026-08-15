@extends('layouts.admin')

@section('title', 'Manajemen Produk')

@section('content')
<div class="container">
    {{-- Header Section --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8 gap-4">
        <div>
            <h2 class="text-3xl font-bold text-gray-800 tracking-tight">Manajemen Produk</h2>
            <p class="text-sm text-gray-500 mt-1">Kelola daftar produk, kategori, status ketersediaan, dan informasi lainnya.</p>
        </div>
        @can('produk-create')
            <a href="{{ route('admin.produk.create') }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm shadow-lg shadow-blue-200 transition duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Produk
            </a>
        @endcan
    </div>

    {{-- Session Alert --}}
    @if(session('success'))
        <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 p-4 mb-6 rounded-xl shadow-sm flex items-center justify-between" role="alert">
            <p class="text-sm font-medium">{{ session('success') }}</p>
        </div>
    @endif

    {{-- Main Card --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        {{-- Card Header / Toolbar --}}
        <div class="p-6 border-b border-gray-100 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-blue-50 rounded-xl text-blue-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m0 0l8 4m-8-4v10l8 4m0-10l8 4m-8-4v10l8-4m0-10l-8-4m8 4v10"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-800">Daftar Produk</h3>
                    <p class="text-xs text-gray-400">Total keseluruhan data produk</p>
                </div>
            </div>

            {{-- Search Form --}}
            <form action="{{ route('admin.produk.index') }}" method="GET" class="w-full md:w-72">
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </span>
                    <input type="text" name="search" class="w-full pl-10 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 outline-none" placeholder="Cari nama produk..." value="{{ request('search') }}">
                </div>
            </form>
        </div>
        
        {{-- Table Section --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/70 border-b border-gray-100 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        <th class="py-4 px-6">No</th>
                        <th class="py-4 px-6">Nama Produk</th>
                        <th class="py-4 px-6">Kategori</th>
                        <th class="py-4 px-6">Status</th>
                        <th class="py-4 px-6 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm text-gray-600">
                    @forelse ($produks as $produk)
                    <tr class="hover:bg-gray-50/50 transition duration-150">
                        <td class="py-4 px-6 font-medium text-gray-400">
                            {{ $loop->iteration + $produks->firstItem() - 1 }}
                        </td>
                      
                        <td class="py-4 px-6 font-semibold text-gray-800">
                            {{ $produk->nama_produk }}
                        </td>
                        <td class="py-4 px-6">
                            <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-lg text-xs font-medium">
                                {{ $produk->kategori }}
                            </span>
                        </td>
                        <td class="py-4 px-6 whitespace-nowrap">
                            @php
                                $status = strtolower($produk->status);
                                $badgeColor = 'bg-blue-50 text-blue-600 border-blue-100';
                                if (in_array($status, ['tersedia', 'available'])) {
                                    $badgeColor = 'bg-emerald-50 text-emerald-600 border-emerald-100';
                                } elseif (in_array($status, ['habis', 'tidak tersedia', 'unavailable'])) {
                                    $badgeColor = 'bg-red-50 text-red-600 border-red-100';
                                } elseif (in_array($status, ['pre-order', 'preorder'])) {
                                    $badgeColor = 'bg-amber-50 text-amber-600 border-amber-100';
                                }
                            @endphp
                            <span class="px-3 py-1 rounded-full text-xs font-semibold border {{ $badgeColor }}">
                                {{ $produk->status }}
                            </span>
                        </td>
                        <td class="py-4 px-6 text-center whitespace-nowrap">
                            <div class="inline-flex items-center justify-center gap-1.5">
                                {{-- Tombol View --}}
                                @can('produk-view')
                                    <a href="{{ route('admin.produk.show', $produk->id) }}" class="p-2 bg-sky-50 text-sky-600 hover:bg-sky-100 rounded-lg transition" title="Detail">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </a>
                                @endcan

                                {{-- Tombol Edit --}}
                                @can('produk-edit')
                                    <a href="{{ route('admin.produk.edit', $produk) }}" class="p-2 bg-amber-50 text-amber-600 hover:bg-amber-100 rounded-lg transition" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>
                                @endcan

                                {{-- Tombol Hapus --}}
                                @can('produk-delete')
                                    <form action="{{ route('admin.produk.destroy', $produk) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 bg-red-50 text-red-600 hover:bg-red-100 rounded-lg transition" title="Hapus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-12 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <div class="w-12 h-12 bg-gray-50 text-gray-400 rounded-full flex items-center justify-center mb-3">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                    </svg>
                                </div>
                                <p class="text-sm font-semibold text-gray-600">Tidak ada data produk ditemukan.</p>
                                <p class="text-xs text-gray-400 mt-0.5">Coba ubah kata kunci pencarian atau tambahkan data baru.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination Footer --}}
        @if ($produks->hasPages())
            <div class="p-6 border-t border-gray-100">
                {{ $produks->links() }}
            </div>
        @endif
    </div>
</div>
@endsection