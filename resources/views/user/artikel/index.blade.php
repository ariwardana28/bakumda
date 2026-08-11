@extends('layouts.app')

@section('content')
    <div class="">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Notifikasi Sukses -->
            @if (session('success'))
                <div class="p-4 rounded-xl bg-emerald-50 dark:bg-emerald-900/30 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-400 text-xs font-semibold shadow-xs flex items-center gap-2.5">
                    <i class="fa-solid fa-circle-check text-sm text-emerald-500"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <!-- Main Card Container -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100 dark:border-gray-700">
                <div class="p-6 sm:p-8 space-y-6 text-gray-900 dark:text-gray-100">

                    <!-- Header Aksi & Tombol Tambah -->
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <h3 class="text-sm font-bold text-gray-900 dark:text-white">Daftar Artikel Anda</h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Kelola, sunting, atau publikasikan artikel baru dengan mudah.</p>
                        </div>
                        <a href="{{ route('user.artikel.create') }}" class="inline-flex items-center justify-center px-4 py-2.5 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-xl font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 gap-2 shadow-sm">
                            <i class="fa-solid fa-plus text-xs"></i>
                            <span>{{ __('Tambah Artikel Baru') }}</span>
                        </a>
                    </div>

                    <!-- Tabel Data Modern -->
                    <div class="overflow-x-auto rounded-xl border border-gray-200 dark:border-gray-700">
                        <table class="w-full text-xs text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-[10px] font-bold text-gray-700 dark:text-gray-300 uppercase bg-gray-50 dark:bg-gray-700/50 border-b border-gray-200 dark:border-gray-700 tracking-wider">
                                <tr>
                                    <th scope="col" class="px-6 py-4 w-16 text-center">No</th>
                                    <th scope="col" class="px-6 py-4">Judul Artikel</th>
                                    <th scope="col" class="px-6 py-4">Status</th>
                                    <th scope="col" class="px-6 py-4">Tanggal Dibuat</th>
                                    <th scope="col" class="px-6 py-4 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700 bg-white dark:bg-gray-800">
                                @forelse ($artikels as $artikel)
                                <tr class="hover:bg-gray-50/70 dark:hover:bg-gray-700/30 transition duration-150">
                                    <td class="px-6 py-4 text-center font-semibold text-gray-400 dark:text-gray-500">
                                        {{ $loop->iteration + $artikels->firstItem() - 1 }}
                                    </td>
                                    <th scope="row" class="px-6 py-4 font-bold text-gray-900 dark:text-white max-w-xs truncate">
                                        {{ $artikel->judul }}
                                    </th>
                                    <td class="px-6 py-4">
                                        @if($artikel->status == 'published')
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-[10px] font-semibold rounded-full bg-emerald-100 dark:bg-emerald-950/50 text-emerald-800 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                                {{ ucfirst($artikel->status) }}
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-[10px] font-semibold rounded-full bg-amber-100 dark:bg-amber-950/50 text-amber-800 dark:text-amber-400 border border-amber-200 dark:border-amber-800">
                                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                                {{ ucfirst($artikel->status) }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 font-medium text-gray-600 dark:text-gray-300">
                                        {{ $artikel->created_at->translatedFormat('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4 text-right space-x-3 whitespace-nowrap">
                                        <a href="{{ route('user.artikel.show', $artikel->slug) }}" class="inline-flex items-center gap-1 font-semibold text-blue-600 dark:text-blue-400 hover:underline">
                                            <i class="fa-solid fa-eye text-xs"></i>
                                            <span>Lihat</span>
                                        </a>
                                        <a href="{{ route('user.artikel.edit', $artikel) }}" class="inline-flex items-center gap-1 font-semibold text-indigo-600 dark:text-indigo-400 hover:underline">
                                            <i class="fa-solid fa-pen-to-square text-xs"></i>
                                            <span>Edit</span>
                                        </a>
                                        <form action="{{ route('user.artikel.destroy', $artikel) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus artikel ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center gap-1 font-semibold text-rose-600 dark:text-rose-400 hover:underline">
                                                <i class="fa-solid fa-trash-can text-xs"></i>
                                                <span>Hapus</span>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-gray-400 dark:text-gray-500 space-y-2">
                                        <div class="w-12 h-12 rounded-xl bg-gray-100 dark:bg-gray-700/50 flex items-center justify-center mx-auto text-gray-400">
                                            <i class="fa-solid fa-folder-open text-xl"></i>
                                        </div>
                                        <p class="font-semibold text-xs">Belum ada artikel yang tersedia.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if ($artikels->hasPages())
                        <div class="pt-2">
                            {{ $artikels->links() }}
                        </div>
                    @endif

                </div>
            </div>

        </div>
    </div>
@endsection