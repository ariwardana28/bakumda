@extends('layouts.admin')

@section('title', 'Manajemen Korwil')
@section('page-subtitle', 'Kelola data Koordinator Wilayah yang aktif.')

@section('content')

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl lg:text-3xl font-bold text-slate-800 dark:text-slate-100">Manajemen Koordinator Wilayah</h1>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Kelola semua data Koordinator Wilayah yang aktif.</p>
        </div>
        <div class="flex items-center gap-2">
            {{-- @can('korwil-create') --}}
            <a href="{{ route('admin.korwil.create') }}"
                class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg bg-indigo-600 text-white font-semibold text-sm hover:bg-indigo-700 transition-all duration-200 shadow-sm hover:shadow-md">
                <i class="fa-solid fa-plus text-xs"></i>
                <span>Tambah Data</span>
            </a>
            {{-- @endcan --}}
        </div>
    </div>

    {{-- Session Message --}}
    @if (session('success'))
        <div class="mb-4 px-4 py-3 rounded-lg text-sm bg-emerald-50 text-emerald-600 border border-emerald-200" role="alert">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="mb-4 px-4 py-3 rounded-lg text-sm bg-red-50 text-red-600 border border-red-200" role="alert">
            {{ session('error') }}
        </div>
    @endif

    {{-- Main Content --}}
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700/80">
        <div class="px-6 py-5 border-b border-slate-100 dark:border-slate-700">
            <h3 class="text-base font-semibold text-slate-800 dark:text-slate-100">Daftar Anggota Berlaku</h3>
        </div>
        <div class="relative overflow-x-auto">
            <table class="w-full text-sm text-left text-slate-500 dark:text-slate-400">
                <thead class="text-xs text-slate-700 uppercase bg-slate-50 dark:bg-slate-700 dark:text-slate-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">No</th>
                        <th scope="col" class="px-6 py-3">Anggota</th>
                        <th scope="col" class="px-6 py-3">Jabatan</th>
                        <th scope="col" class="px-6 py-3">Status Kartu</th>
                        <th scope="col" class="px-6 py-3">Diterbitkan</th>
                        <th scope="col" class="px-6 py-3">Berlaku</th>
                        <th scope="col" class="px-6 py-3">Keterangan</th>
                        <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($korwils as $korwil)
                        <tr class="bg-white border-b dark:bg-slate-800 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-600">
                            <td class="px-6 py-4">{{ $loop->iteration + ($korwils->currentPage() - 1) * $korwils->perPage() }}</td>
                            <td class="px-6 py-4">
                                <span class="font-semibold text-slate-900 dark:text-white">{{ $korwil->anggotaCard->anggota->nama ?? 'N/A' }}</span>
                                <span class="block text-xs text-slate-500">{{ $korwil->anggotaCard->card_id ?? 'No. Kartu tidak ada' }}</span>
                            </td>
                            <td class="px-6 py-4">{{ $korwil->jabatan ?? '-' }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 text-xs font-medium rounded-full 
                                    {{ strtolower($korwil->status_kartu) == 'aktif' ? 'bg-emerald-50 text-emerald-600 dark:bg-emerald-950/50 dark:text-emerald-400' : 'bg-slate-100 text-slate-600 dark:bg-slate-700 dark:text-slate-300' }}">
                                    {{ $korwil->status_kartu }}
                                </span>
                            </td>
                            <td class="px-6 py-4">{{ $korwil->diterbitkan ? $korwil->diterbitkan->format('d M Y') : '-' }}</td>
                            <td class="px-6 py-4">{{ $korwil->berlaku ? $korwil->berlaku->format('d M Y') : '-' }}</td>
                            <td class="px-6 py-4">{{ $korwil->keterangan ?? '-' }}</td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    {{-- @can('korwil-edit') --}}
                                    <a href="{{ route('admin.korwil.edit', $korwil->id) }}"
                                        class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-amber-50 dark:bg-amber-950/50 text-amber-600 dark:text-amber-400 hover:bg-amber-100 dark:hover:bg-amber-950 transition-all"
                                        title="Edit">
                                        <i class="fa-solid fa-pencil text-xs"></i>
                                    </a>
                                    {{-- @endcan --}}
                                    {{-- @can('korwil-delete') --}}
                                    <form action="{{ route('admin.korwil.destroy', $korwil->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-red-50 dark:bg-red-950/50 text-red-600 dark:text-red-400 hover:bg-red-100 dark:hover:bg-red-950 transition-all"
                                            title="Hapus">
                                            <i class="fa-solid fa-trash-alt text-xs"></i>
                                        </button>
                                    </form>
                                    {{-- @endcan --}}
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-4 text-center text-slate-500 dark:text-slate-400">Tidak ada data.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($korwils->hasPages())
            <div class="px-6 py-4">
                {{ $korwils->links() }}
            </div>
        @endif
    </div>

@endsection