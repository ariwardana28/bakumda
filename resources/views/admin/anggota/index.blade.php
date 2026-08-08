@extends('layouts.admin')

@section('title', 'Daftar Anggota')
@section('page-subtitle', 'Kelola semua informasi data anggota terdaftar dalam sistem.')

@section('page-actions')
    @can('anggota-create')
        {{-- <a href="{{ route('admin.anggota.create') }}"
            class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-brand-600 hover:bg-brand-700 text-white font-semibold text-sm shadow-md shadow-brand-500/20 active:scale-[0.98] transition-all duration-200">
            <i class="fa-solid fa-plus text-xs"></i>
            <span>Tambah Anggota</span>
        </a> --}}
    @endcan
@endsection

@section('content')
    <div class="space-y-6">

        <!-- Section Filter & Pencarian -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700/80 p-4 shadow-sm">
            <form method="GET" action="{{ route('admin.anggota.index') }}"
                class="flex flex-col sm:flex-row items-center justify-between gap-4">
                
                <!-- Search Bar & Reset Filter -->
                <div class="flex items-center gap-2 w-full sm:w-auto">
                    <div class="relative w-full sm:w-80">
                        <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari nama, email, atau no. HP..."
                            class="w-full pl-10 pr-4 py-2 text-sm rounded-xl bg-gray-50 dark:bg-gray-700/50 border border-gray-200 dark:border-gray-600 text-gray-800 dark:text-gray-100 focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 outline-none transition-all">
                    </div>

                    @if(request('search'))
                        <a href="{{ route('admin.anggota.index') }}" 
                            class="px-3 py-2 text-xs font-medium rounded-xl bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-600 dark:text-gray-300 transition-colors"
                            title="Reset Pencarian">
                            <i class="fa-solid fa-rotate-left"></i>
                        </a>
                    @endif
                </div>

                <!-- Total Counter Badge -->
                <div class="w-full sm:w-auto flex items-center justify-end gap-2 text-xs text-gray-500 dark:text-gray-400 font-medium">
                    <span>Total Keseluruhan:</span>
                    <span class="px-2.5 py-1 rounded-lg bg-brand-50 dark:bg-brand-950/50 text-brand-600 dark:text-brand-400 font-bold border border-brand-100 dark:border-brand-900/50">
                        {{ method_exists($anggotas, 'total') ? $anggotas->total() : count($anggotas) }} Anggota
                    </span>
                </div>
            </form>
        </div>

        <!-- Alert Notifikasi Sukses -->
        @if (session('success'))
            <div x-data="{ show: true }" x-show="show" x-transition
                class="p-4 rounded-2xl bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200/80 dark:border-emerald-800/80 text-emerald-800 dark:text-emerald-300 flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-xl bg-emerald-100 dark:bg-emerald-900/50 flex items-center justify-center text-emerald-600 dark:text-emerald-400 shrink-0">
                        <i class="fa-solid fa-circle-check text-base"></i>
                    </div>
                    <span class="text-sm font-medium">{{ session('success') }}</span>
                </div>
                <button @click="show = false"
                    class="text-emerald-600 dark:text-emerald-400 hover:opacity-75 p-1 transition-opacity">
                    <i class="fa-solid fa-xmark text-base"></i>
                </button>
            </div>
        @endif

        <!-- Tabel Data Anggota -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700/80 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-gray-100 dark:border-gray-700/80 bg-gray-50/75 dark:bg-gray-800/75 text-[11px] font-bold uppercase tracking-wider text-gray-400 dark:text-gray-400">
                            <th class="px-6 py-4">Anggota</th>
                            <th class="px-6 py-4">Email</th>
                            <th class="px-6 py-4">No. HP</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700/60 text-sm">
                        @forelse ($anggotas as $anggota)
                            <tr class="hover:bg-gray-50/60 dark:hover:bg-gray-700/30 transition-colors group">

                                <!-- Kolom Nama + Avatar Inisial -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-brand-50 dark:bg-brand-900/30 text-brand-600 dark:text-brand-400 flex items-center justify-center font-bold text-sm shrink-0 border border-brand-100 dark:border-brand-800/50 shadow-sm">
                                            {{ strtoupper(substr($anggota->nama, 0, 2)) }}
                                        </div>
                                        <div>
                                            <p class="font-semibold text-gray-900 dark:text-gray-100 group-hover:text-brand-600 dark:group-hover:text-brand-400 transition-colors">
                                                {{ $anggota->nama }}
                                            </p>
                                            <p class="text-xs text-gray-400 dark:text-gray-500 font-mono">ID: #{{ $anggota->id }}</p>
                                        </div>
                                    </div>
                                </td>

                                <!-- Kolom Email -->
                                <td class="px-6 py-4 whitespace-nowrap text-gray-600 dark:text-gray-300">
                                    @if ($anggota->email)
                                        <div class="flex items-center gap-2">
                                            <i class="fa-regular fa-envelope text-gray-400 text-xs"></i>
                                            <span>{{ $anggota->email }}</span>
                                        </div>
                                    @else
                                        <span class="text-gray-400 dark:text-gray-600 italic text-xs">- Tidak ada -</span>
                                    @endif
                                </td>

                                <!-- Kolom No HP -->
                                <td class="px-6 py-4 whitespace-nowrap text-gray-600 dark:text-gray-300">
                                    @if ($anggota->no_hp)
                                        <div class="flex items-center gap-2">
                                            <i class="fa-solid fa-phone text-gray-400 text-xs"></i>
                                            <span>{{ $anggota->no_hp }}</span>
                                        </div>
                                    @else
                                        <span class="text-gray-400 dark:text-gray-600 italic text-xs">- Tidak ada -</span>
                                    @endif
                                </td>

                                <!-- Kolom Aksi -->
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <div class="flex items-center justify-end gap-1.5">
                                        <!-- Tombol Edit -->
                                        @can('anggota-edit')
                                            <a href="{{ route('admin.anggota.edit', $anggota) }}"
                                                class="p-2 rounded-xl text-gray-500 hover:text-brand-600 hover:bg-brand-50 dark:text-gray-400 dark:hover:text-brand-400 dark:hover:bg-brand-950/40 transition-all"
                                                title="Ubah Data">
                                                <i class="fa-solid fa-pen-to-square text-sm"></i>
                                            </a>
                                        @endcan

                                        <!-- Tombol Hapus -->
                                        <form action="{{ route('admin.anggota.destroy', $anggota) }}" method="POST"
                                            class="inline-block"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus {{ $anggota->nama }}?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="p-2 rounded-xl text-gray-500 hover:text-rose-600 hover:bg-rose-50 dark:text-gray-400 dark:hover:text-rose-400 dark:hover:bg-rose-950/40 transition-all"
                                                title="Hapus Data">
                                                <i class="fa-solid fa-trash-can text-sm"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <!-- Empty State jika data kosong -->
                            <tr>
                                <td colspan="4" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center justify-center max-w-sm mx-auto">
                                        <div class="w-16 h-16 rounded-2xl bg-gray-50 dark:bg-gray-700/50 flex items-center justify-center text-gray-400 dark:text-gray-500 mb-4 border border-gray-100 dark:border-gray-700">
                                            <i class="fa-solid fa-users-slash text-2xl"></i>
                                        </div>
                                        <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100">Belum Ada Anggota</h3>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 mb-5">Data anggota belum tersedia atau kata kunci pencarian Anda tidak ditemukan.</p>
                                        
                                        @if(request('search'))
                                            <a href="{{ route('admin.anggota.index') }}"
                                                class="px-4 py-2 text-xs font-semibold rounded-xl bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 transition-colors">
                                                Reset Pencarian
                                            </a>
                                        @else
                                            <a href="{{ route('admin.anggota.create') }}"
                                                class="px-4 py-2 text-xs font-semibold rounded-xl bg-brand-600 text-white hover:bg-brand-700 shadow-sm transition-colors">
                                                + Tambah Anggota Pertama
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Footer Pagination -->
            @if (method_exists($anggotas, 'hasPages') && $anggotas->hasPages())
                <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700/80 bg-gray-50/50 dark:bg-gray-800/50">
                    {{ $anggotas->links() }}
                </div>
            @endif
        </div>

    </div>
@endsection