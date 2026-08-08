@extends('layouts.admin')

@section('content')
    <div class="container">
        {{-- Header Section --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8 gap-4">
            <div>
                <h2 class="text-3xl font-bold text-gray-800 tracking-tight">Manajemen Pelatihan</h2>
                <p class="text-sm text-gray-500 mt-1">Kelola daftar jadwal, informasi, dan status pelatihan yang tersedia.
                </p>
            </div>
            @can('pelatihan-create')
                <a href="{{ route('admin.pelatihan.create') }}"
                    class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-sm shadow-lg shadow-indigo-200 transition duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tambah Pelatihan
                </a>
            @endcan
        </div>

        {{-- Main Card --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            {{-- Card Header / Toolbar --}}
            <div class="p-6 border-b border-gray-100 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-indigo-50 rounded-xl text-indigo-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">Daftar Pelatihan</h3>
                        <p class="text-xs text-gray-400">Total keseluruhan data pelatihan aktif</p>
                    </div>
                </div>

                {{-- Search Form --}}
                <form action="{{ route('admin.pelatihan.index') }}" method="GET" class="w-full md:w-72">
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </span>
                        <input type="text" name="search"
                            class="w-full pl-10 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 outline-none"
                            placeholder="Cari judul pelatihan..." value="{{ request('search') }}">
                    </div>
                </form>
            </div>

            {{-- Table Section --}}
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr
                            class="bg-gray-50/70 border-b border-gray-100 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            <th class="py-4 px-6">No</th>
                            <th class="py-4 px-6">Judul Pelatihan</th>
                            <th class="py-4 px-6">Tanggal Mulai</th>
                            <th class="py-4 px-6">Status</th>
                            <th class="py-4 px-6 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm text-gray-600">
                        @forelse ($pelatihans as $pelatihan)
                            <tr class="hover:bg-gray-50/50 transition duration-150">
                                <td class="py-4 px-6 font-medium text-gray-400">
                                    {{ $loop->iteration + $pelatihans->firstItem() - 1 }}
                                </td>
                                <td class="py-4 px-6 font-semibold text-gray-800">
                                    {{ $pelatihan->judul }}
                                </td>
                                <td class="py-4 px-6 whitespace-nowrap">
                                    <div class="flex items-center gap-1.5 text-gray-600">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        {{ $pelatihan->tanggal_mulai->format('d M Y, H:i') }}
                                    </div>
                                </td>

                                <td class="py-4 px-6 whitespace-nowrap">
                                    @php
                                        $status = strtolower($pelatihan->status);
                                        $badgeColor = 'bg-blue-50 text-blue-600 border-blue-100';
                                        if (in_array($status, ['selesai', 'completed'])) {
                                            $badgeColor = 'bg-green-50 text-green-600 border-green-100';
                                        }
                                        if (in_array($status, ['batal', 'cancelled'])) {
                                            $badgeColor = 'bg-red-50 text-red-600 border-red-100';
                                        }
                                    @endphp
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold border {{ $badgeColor }}">
                                        {{ Str::title($pelatihan->status) }}
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-center whitespace-nowrap">
                                    <div class="inline-flex items-center justify-center gap-1.5">
                                        <a href="{{ route('admin.pelatihan.materi.index', $pelatihan->id) }}"
                                            class="p-2 bg-gray-100 text-gray-500 hover:bg-indigo-50 hover:text-indigo-600 rounded-lg transition text-xs font-semibold flex items-center gap-2"
                                            title="Kelola Materi untuk pelatihan ini">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                            Kelola Materi
                                        </a>
                                        
                                        @can('pelatihan-view')
                                            <a href="{{ route('admin.pelatihan.show', $pelatihan->id) }}"
                                                class="p-2 bg-sky-50 text-sky-600 hover:bg-sky-100 rounded-lg transition"
                                                title="Detail">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                    </path>
                                                </svg>
                                            </a>
                                        @endcan

                                        @can('pelatihan-edit')
                                            <a href="{{ route('admin.pelatihan.edit', $pelatihan->id) }}"
                                                class="p-2 bg-amber-50 text-amber-600 hover:bg-amber-100 rounded-lg transition"
                                                title="Edit">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                    </path>
                                                </svg>
                                            </a>
                                        @endcan

                                        {{-- Tombol Materi (Tampil di Samping Edit / Sebelum Hapus) --}}
                                        @can('pelatihan-edit')
                                        @endcan

                                        @can('pelatihan-delete')
                                            <form action="{{ route('admin.pelatihan.destroy', $pelatihan->id) }}"
                                                method="POST" class="inline-block"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="p-2 bg-red-50 text-red-600 hover:bg-red-100 rounded-lg transition"
                                                    title="Hapus">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                        </path>
                                                    </svg>
                                                </button>
                                            </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div
                                            class="w-12 h-12 bg-gray-50 text-gray-400 rounded-full flex items-center justify-center mb-3">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                                                </path>
                                            </svg>
                                        </div>
                                        <p class="text-sm font-semibold text-gray-600">Tidak ada data pelatihan ditemukan.
                                        </p>
                                        <p class="text-xs text-gray-400 mt-0.5">Coba ubah kata kunci pencarian atau
                                            tambahkan data baru.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination Footer --}}
            @if ($pelatihans->hasPages())
                <div class="p-6 border-t border-gray-100">
                    {{ $pelatihans->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
