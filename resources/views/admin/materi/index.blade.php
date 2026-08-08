@extends('layouts.admin')

@section('content')
    <div class="container mx-auto">
        {{-- Tombol Kembali ke Daftar Pelatihan --}}
        <div class="mb-6">
            <a href="{{ route('admin.pelatihan.index') }}"
                class="inline-flex items-center gap-2.5 px-4 py-2 rounded-xl text-sm font-semibold text-slate-600 hover:text-indigo-600 bg-white hover:bg-indigo-50/50 border border-slate-200/80 shadow-sm transition-all duration-200 group">
                <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali ke Daftar Pelatihan
            </a>
        </div>

        {{-- Header Section --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8 gap-4">
            <div class="flex-1">
                @if (isset($pelatihan))
                    <h2 class="text-3xl font-bold text-gray-800 tracking-tight">Materi untuk: {{ $pelatihan->judul }}</h2>
                @else
                    <h2 class="text-3xl font-bold text-gray-800 tracking-tight">Manajemen Materi</h2>
                @endif
                <p class="text-sm text-gray-500 mt-1">Kelola daftar modul, kurikulum, dan status publikasi materi pembelajaran.</p>
            </div>
            <div class="flex items-center gap-3">
                @if (isset($pelatihan))
                    @can('materi-create')
                        <a href="{{ route('admin.pelatihan.materi.create', $pelatihan->id) }}"
                            class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-sm shadow-lg shadow-indigo-200 transition duration-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Tambah Materi
                        </a>
                    @endcan
                @endif
            </div>
        </div>

        {{-- Main Card --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            {{-- Card Header / Toolbar --}}
            <div class="p-6 border-b border-gray-100 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-indigo-50 rounded-xl text-indigo-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">Daftar Materi</h3>
                        <p class="text-xs text-gray-400">Total keseluruhan data materi aktif</p>
                    </div>
                </div>

                {{-- Search Form --}}
                @php
                    $searchUrl = isset($pelatihan)
                        ? route('admin.pelatihan.materi.index', $pelatihan->id)
                        : route('admin.materi.index');
                @endphp
                <form action="{{ $searchUrl }}" method="GET" class="w-full md:w-72">
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </span>
                        <input type="text" name="search"
                            class="w-full pl-10 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 outline-none"
                            placeholder="Cari judul materi..." value="{{ request('search') }}">
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
                            <th class="py-4 px-6">Judul</th>
                            <th class="py-4 px-6">Status</th>
                            <th class="py-4 px-6 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm text-gray-600">
                        @forelse ($materis as $materi)
                            <tr class="hover:bg-gray-50/50 transition duration-150">
                                <td class="py-4 px-6 font-medium text-gray-400">
                                    {{ $loop->iteration + $materis->firstItem() - 1 }}
                                </td>
                                <td class="py-4 px-6 font-semibold text-gray-800">
                                    {{ $materi->judul }}
                                </td>
                                <td class="py-4 px-6 whitespace-nowrap">
                                    @php
                                        $status = strtolower($materi->status);
                                        $badgeColor =
                                            $status == 'published'
                                                ? 'bg-green-50 text-green-600 border-green-100'
                                                : 'bg-gray-50 text-gray-600 border-gray-200';
                                    @endphp
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold border {{ $badgeColor }}">
                                        {{ Str::title($materi->status) }}
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-center whitespace-nowrap">
                                    <div class="inline-flex items-center justify-center gap-1.5">
                                        <a href="{{ route('admin.materi.soal.index', $materi->id) }}"
                                            class="p-2 bg-gray-100 text-gray-500 hover:bg-indigo-50 hover:text-indigo-600 rounded-lg transition text-xs font-semibold flex items-center gap-2"
                                            title="Kelola Soal untuk materi ini">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            Kelola Soal
                                        </a>
                                        @can('materi-view')
                                            <a href="{{ route('admin.pelatihan.materi.show', ['pelatihan' => $materi->pelatihan_id, 'materi' => $materi->id]) }}"
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

                                        @can('materi-edit')
                                            <a href="{{ route('admin.pelatihan.materi.edit', ['pelatihan' => $materi->pelatihan_id, 'materi' => $materi->id]) }}"
                                                class="p-2 bg-amber-50 text-amber-600 hover:bg-amber-100 rounded-lg transition"
                                                title="Edit">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                    </path>
                                                </svg>
                                            </a>
                                        @endcan

                                        @can('materi-delete')
                                            <form
                                                action="{{ route('admin.pelatihan.materi.destroy', ['pelatihan' => $materi->pelatihan_id, 'materi' => $materi->id]) }}"
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
                                <td colspan="4" class="py-12 text-center">
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
                                        <p class="text-sm font-semibold text-gray-600">Tidak ada data materi.</p>
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
            @if (isset($materis) && method_exists($materis, 'hasPages') && $materis->hasPages())
                <div class="p-6 border-t border-gray-100">
                    {{ $materis->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection