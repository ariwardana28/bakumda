@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-[#f8fafc] py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto space-y-6">

        <!-- 1. Header & Deskripsi Halaman + Tombol Tambah -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-xl sm:text-2xl font-bold text-[#1e293b] tracking-tight">Manajemen Data</h1>
                <p class="text-sm text-[#64748b] mt-1">Kelola dan pantau seluruh informasi data secara berkala melalui halaman ini.</p>
            </div>
            
            <!-- Tombol Tambah Data -->
            <div>
                @if(Route::has(request()->route()->getPrefix() . '.create'))
                    <a href="{{ route(request()->route()->getPrefix() . '.create') }}" 
                       class="inline-flex items-center justify-center px-4 py-2.5 rounded-xl bg-indigo-600 text-white text-sm font-semibold shadow-xs hover:bg-indigo-500 active:bg-indigo-700 transition duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Tambah Data
                    </a>
                @endif
            </div>
        </div>

        <!-- Notifikasi Flash Message -->
        @if(session('success'))
            <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-100 text-emerald-700 text-sm flex items-center shadow-xs">
                <svg class="w-5 h-5 mr-2 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- 2. Search & Summary Section -->
        <div class="bg-white rounded-2xl sm:rounded-3xl border border-[#e2e8f0] p-4 sm:p-5 shadow-xs flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            
            <!-- Search Input -->
            <div class="relative w-full md:w-96">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-[#64748b]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </span>
                <form action="" method="GET">
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}" 
                           placeholder="Cari data berdasarkan keyword..." 
                           class="w-full pl-10 pr-4 py-2.5 bg-[#f8fafc] border border-[#e2e8f0] rounded-xl text-sm text-[#1e293b] placeholder-[#64748b] focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition duration-200">
                </form>
            </div>

            <!-- Total Data Badge -->
            <div class="flex items-center self-start md:self-auto">
                @php 
                    $collection = $items ?? $payments ?? $kerjasamas ?? collect(); 
                @endphp
                <div class="px-4 py-2 bg-indigo-50/80 border border-indigo-100/60 rounded-xl text-indigo-700 text-xs sm:text-sm font-semibold tracking-wide">
                    Total Keseluruhan: <span class="font-bold">{{ method_exists($collection, 'total') ? $collection->total() : count($collection) }}</span> Data
                </div>
            </div>
        </div>

        <!-- 3 & 4. Data Table Container -->
        <div class="bg-white rounded-2xl sm:rounded-3xl border border-[#e2e8f0] shadow-xs overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-[#e2e8f0] bg-[#f8fafc]/50 text-[#64748b] font-semibold uppercase text-[11px] tracking-wider">
                            <th class="py-4 px-6">No</th>
                            <th class="py-4 px-6">Informasi Utama</th>
                            <th class="py-4 px-6">Detail / Atribut</th>
                            <th class="py-4 px-6">Status</th>
                            <th class="py-4 px-6">Tanggal</th>
                            <th class="py-4 px-6 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#f1f5f9] text-[#1e293b] text-sm font-medium">
                        @forelse ($collection as $index => $row)
                            <tr class="hover:bg-[#f8fafc]/80 transition duration-200 group">
                                
                                <!-- No Urut Paginasi -->
                                <td class="py-4 px-6 text-[#64748b] text-xs">
                                    {{ method_exists($collection, 'firstItem') ? $collection->firstItem() + $index : $index + 1 }}
                                </td>

                                <!-- Informasi Utama -->
                                <td class="py-4 px-6">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-9 h-9 rounded-xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-700 font-bold text-xs shrink-0">
                                            {{ strtoupper(substr($row->judul ?? $row->name ?? $row->mitra ?? 'D', 0, 2)) }}
                                        </div>
                                        <div>
                                            <div class="font-semibold text-[#1e293b] group-hover:text-indigo-600 transition">
                                                {{ $row->judul ?? $row->name ?? $row->mitra ?? '-' }}
                                            </div>
                                            <div class="text-xs text-[#64748b] mt-0.5">
                                                {{ $row->mitra ?? $row->email ?? $row->code ?? '' }}
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Detail / Atribut -->
                                <td class="py-4 px-6 text-[#64748b] text-xs">
                                    <div class="truncate max-w-xs">
                                        {{ $row->deskripsi ?? $row->account_number ?? $row->category ?? '-' }}
                                    </div>
                                    @if(isset($row->amount))
                                        <div class="font-semibold text-[#1e293b] mt-0.5">
                                            Rp {{ number_format($row->amount, 0, ',', '.') }}
                                        </div>
                                    @endif
                                </td>

                                <!-- Status Badge -->
                                <td class="py-4 px-6">
                                    @php
                                        $status = strtolower($row->status ?? 'aktif');
                                        $badgeColor = match($status) {
                                            'aktif', 'berhasil', 'paid', 'approved' => 'bg-emerald-50 text-emerald-700 border-emerald-200/60',
                                            'pending', 'processing' => 'bg-amber-50 text-amber-700 border-amber-200/60',
                                            default => 'bg-rose-50 text-rose-700 border-rose-200/60',
                                        };
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wide border {{ $badgeColor }}">
                                        {{ $row->status ?? 'Aktif' }}
                                    </span>
                                </td>

                                <!-- Tanggal -->
                                <td class="py-4 px-6 text-[#64748b] text-xs whitespace-nowrap">
                                    {{ optional($row->created_at)->format('d M Y, H:i') ?? ($row->tanggal_mulai ?? '-') }}
                                </td>

                                <!-- 5. Action Column -->
                                <td class="py-4 px-6 text-right whitespace-nowrap">
                                    <div class="inline-flex items-center space-x-1.5">
                                        
                                        <!-- Tombol Detail -->
                                        @if(Route::has(request()->route()->getPrefix() . '.show'))
                                            <a href="{{ route(request()->route()->getPrefix() . '.show', $row->id) }}" 
                                               class="p-2 rounded-xl text-[#64748b] hover:text-indigo-600 hover:bg-indigo-50 transition duration-200" title="Detail">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            </a>
                                        @endif

                                        <!-- Tombol Edit -->
                                        @if(Route::has(request()->route()->getPrefix() . '.edit'))
                                            <a href="{{ route(request()->route()->getPrefix() . '.edit', $row->id) }}" 
                                               class="p-2 rounded-xl text-[#64748b] hover:text-amber-600 hover:bg-amber-50 transition duration-200" title="Edit">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                            </a>
                                        @endif

                                        <!-- Tombol Delete -->
                                        @if(Route::has(request()->route()->getPrefix() . '.destroy'))
                                            <form action="{{ route(request()->route()->getPrefix() . '.destroy', $row->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-2 rounded-xl text-[#64748b] hover:text-rose-600 hover:bg-rose-50 transition duration-200" title="Hapus">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                </button>
                                            </form>
                                        @endif

                                    </div>
                                </td>

                            </tr>
                        @empty
                            <!-- 7. Empty State -->
                            <tr>
                                <td colspan="6" class="py-12 px-6 text-center">
                                    <div class="flex flex-col items-center justify-center space-y-3">
                                        <div class="w-12 h-12 rounded-2xl bg-slate-100 flex items-center justify-center text-[#64748b]">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                                        </div>
                                        <div class="text-sm font-semibold text-[#1e293b]">Belum ada data tersedia</div>
                                        <p class="text-xs text-[#64748b] max-w-sm">Data yang Anda cari atau tambahkan akan muncul di bagian ini secara otomatis.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- 9. Pagination Section -->
            @if(method_exists($collection, 'links') && $collection->hasPages())
                <div class="py-4 px-6 border-t border-[#e2e8f0] bg-white">
                    {{ $collection->links() }}
                </div>
            @endif
        </div>

    </div>
</div>
@endsection