@extends('layouts.admin')

@section('content')
    <div class="min-h-screen bg-[#f8fafc] py-6 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto space-y-6">

            <!-- 1. Header & Deskripsi Halaman + Tombol Tambah -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h1 class="text-xl sm:text-2xl font-bold text-[#1e293b] tracking-tight">Manajemen Kerjasama</h1>
                    <p class="text-sm text-[#64748b] mt-1">Kelola dan pantau seluruh data kerjasama secara berkala melalui halaman ini.</p>
                </div>

                <!-- Tombol Tambah Data -->
                @can('kerjasama-create')
                    <div>
                        <a href="{{ route('admin.kerjasama.create') }}"
                            class="inline-flex items-center justify-center px-4 py-2.5 rounded-xl bg-indigo-600 text-white text-sm font-semibold shadow-xs hover:bg-indigo-500 active:bg-indigo-700 transition duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Tambah Data
                        </a>
                    </div>
                @endcan
            </div>

            <!-- Notifikasi Flash Message -->
            @if (session('success'))
                <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-100 text-emerald-700 text-sm flex items-center shadow-xs">
                    <svg class="w-5 h-5 mr-2 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <!-- Tab Filter Status (Pending, Disetujui, Ditolak, Semua) -->
            @php
                $currentStatus = request()->get('status', 'pending');
            @endphp
            <div class="flex items-center space-x-2 border-b border-[#e2e8f0] pb-3 overflow-x-auto">
                <a href="{{ route('admin.kerjasama.index', ['status' => 'pending', 'search' => request('search')]) }}"
                   class="px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-wider transition {{ $currentStatus === 'pending' ? 'bg-indigo-600 text-white shadow-sm' : 'bg-white text-[#64748b] border border-[#e2e8f0] hover:bg-slate-50' }}">
                   Pending 
                   @if(isset($counts['pending']))
                       <span class="ml-1.5 px-1.5 py-0.5 rounded-full text-[10px] {{ $currentStatus === 'pending' ? 'bg-indigo-700 text-white' : 'bg-slate-100 text-slate-600' }}">{{ $counts['pending'] }}</span>
                   @endif
                </a>

                <a href="{{ route('admin.kerjasama.index', ['status' => 'aktif', 'search' => request('search')]) }}"
                   class="px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-wider transition {{ $currentStatus === 'aktif' ? 'bg-indigo-600 text-white shadow-sm' : 'bg-white text-[#64748b] border border-[#e2e8f0] hover:bg-slate-50' }}">
                   Aktif
                   @if(isset($counts['aktif']))
                       <span class="ml-1.5 px-1.5 py-0.5 rounded-full text-[10px] {{ $currentStatus === 'aktif' ? 'bg-indigo-700 text-white' : 'bg-slate-100 text-slate-600' }}">{{ $counts['aktif'] }}</span>
                   @endif
                </a>

                <a href="{{ route('admin.kerjasama.index', ['status' => 'ditolak', 'search' => request('search')]) }}"
                   class="px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-wider transition {{ $currentStatus === 'ditolak' ? 'bg-indigo-600 text-white shadow-sm' : 'bg-white text-[#64748b] border border-[#e2e8f0] hover:bg-slate-50' }}">
                   Ditolak
                   @if(isset($counts['ditolak']))
                       <span class="ml-1.5 px-1.5 py-0.5 rounded-full text-[10px] {{ $currentStatus === 'ditolak' ? 'bg-indigo-700 text-white' : 'bg-slate-100 text-slate-600' }}">{{ $counts['ditolak'] }}</span>
                   @endif
                </a>

                <a href="{{ route('admin.kerjasama.index', ['status' => 'semua', 'search' => request('search')]) }}"
                   class="px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-wider transition {{ $currentStatus === 'semua' ? 'bg-indigo-600 text-white shadow-sm' : 'bg-white text-[#64748b] border border-[#e2e8f0] hover:bg-slate-50' }}">
                   Semua
                </a>
            </div>

            <!-- 2. Search & Summary Section -->
            <div class="bg-white rounded-2xl sm:rounded-3xl border border-[#e2e8f0] p-4 sm:p-5 shadow-xs flex flex-col md:flex-row md:items-center md:justify-between gap-4">

                <!-- Search Input -->
                <div class="relative w-full md:w-96">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-[#64748b]">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </span>
                    <form action="{{ route('admin.kerjasama.index') }}" method="GET">
                        <input type="hidden" name="status" value="{{ request('status', 'pending') }}">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari data berdasarkan keyword..."
                            class="w-full pl-10 pr-4 py-2.5 bg-[#f8fafc] border border-[#e2e8f0] rounded-xl text-sm text-[#1e293b] placeholder-[#64748b] focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition duration-200">
                    </form>
                </div>

                <!-- Total Data Badge -->
                <div class="flex items-center self-start md:self-auto">
                    <div class="px-4 py-2 bg-indigo-50/80 border border-indigo-100/60 rounded-xl text-indigo-700 text-xs sm:text-sm font-semibold tracking-wide">
                        Total Ditampilkan: <span class="font-bold">{{ $kerjasamas->total() }}</span> Data
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
                                <th class="py-4 px-6">Detail</th>
                                <th class="py-4 px-6">Status</th>
                                <th class="py-4 px-6">Tanggal</th>
                                <th class="py-4 px-6 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#f1f5f9] text-[#1e293b] text-sm font-medium">
                            @forelse ($kerjasamas as $index => $row)
                                <tr class="hover:bg-[#f8fafc]/80 transition duration-200 group">

                                    <!-- No Urut Paginasi -->
                                    <td class="py-4 px-6 text-[#64748b] text-xs">
                                        {{ $kerjasamas->firstItem() + $index }}
                                    </td>

                                    <!-- Informasi Utama -->
                                    <td class="py-4 px-6">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-9 h-9 rounded-xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-700 font-bold text-xs shrink-0">
                                                {{ strtoupper(substr($row->judul ?? 'D', 0, 2)) }}
                                            </div>
                                            <div>
                                                <div class="font-semibold text-[#1e293b] group-hover:text-indigo-600 transition">
                                                    {{ $row->judul }}
                                                </div>
                                                <div class="text-xs text-[#64748b] mt-0.5">
                                                    {{ $row->mitra }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Detail -->
                                    <td class="py-4 px-6 text-[#64748b] text-xs">
                                        <div class="truncate max-w-xs">
                                            {{ $row->deskripsi ?? '-' }}
                                        </div>
                                    </td>

                                    <!-- Status Badge -->
                                    <td class="py-4 px-6">
                                        @php
                                            $status = strtolower($row->status ?? 'pending');
                                            $badgeColor = match ($status) {
                                                'aktif' => 'bg-emerald-50 text-emerald-700 border-emerald-200/60',
                                                'pending' => 'bg-amber-50 text-amber-700 border-amber-200/60',
                                                'selesai' => 'bg-sky-50 text-sky-700 border-sky-200/60',
                                                default => 'bg-rose-50 text-rose-700 border-rose-200/60',
                                            };
                                        @endphp
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wide border {{ $badgeColor }}">
                                            {{ $row->status ?? 'Pending' }}
                                        </span>
                                    </td>

                                    <!-- Tanggal -->
                                    <td class="py-4 px-6 text-[#64748b] text-xs whitespace-nowrap">
                                        {{ optional($row->created_at)->format('d M Y, H:i') ?? '-' }}
                                    </td>

                                    <!-- 5. Action Column -->
                                    <td class="py-4 px-6 text-right whitespace-nowrap">
                                        <div class="inline-flex items-center space-x-1.5">

                                            <!-- Tombol Detail / Tinjau -->
                                            @can('kerjasama-view')
                                                <a href="{{ route('admin.kerjasama.show', $row->id) }}"
                                                    class="inline-flex items-center px-3 py-1.5 bg-indigo-50 text-indigo-600 hover:bg-indigo-100 rounded-lg text-xs font-semibold transition"
                                                    title="Detail">
                                                    Tinjau
                                                </a>
                                            @endcan

                                        </div>
                                    </td>

                                </tr>
                            @empty
                                <!-- 7. Empty State -->
                                <tr>
                                    <td colspan="6" class="py-12 px-6 text-center">
                                        <div class="flex flex-col items-center justify-center space-y-3">
                                            <div class="w-12 h-12 rounded-2xl bg-slate-100 flex items-center justify-center text-[#64748b]">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                                </svg>
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
                @if ($kerjasamas->hasPages())
                    <div class="py-4 px-6 border-t border-[#e2e8f0] bg-white">
                        {{ $kerjasamas->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
@endsection