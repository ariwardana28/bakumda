@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-[#f8fafc] py-8 px-4 sm:px-6 lg:px-8" x-data="{ loading: false, error: false }">
        <div class="max-w-7xl mx-auto space-y-6">

            <!-- Header Halaman -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h1 class="text-xl sm:text-2xl font-bold text-[#1e293b] tracking-tight">Daftar Kerja Sama</h1>
                    <p class="text-sm text-[#64748b] mt-1">Kelola dokumen, mitra, dan status kerja sama instansi dengan
                        mudah.</p>
                </div>

                <!-- Tombol Tambah Kerja Sama -->
                <div>
                    <a href="{{ route('user-kerjasamas.create') }}"
                        class="inline-flex items-center justify-center px-4 py-2.5 rounded-xl bg-indigo-600 text-white text-sm font-semibold shadow-xs hover:bg-indigo-500 active:bg-indigo-700 transition duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Tambah Kerja Sama Baru
                    </a>
                </div>
            </div>

            <!-- Flash Message Success -->
            @if (session('success'))
                <div
                    class="p-4 rounded-2xl bg-emerald-50 border border-emerald-100 text-emerald-700 text-sm flex items-center justify-between shadow-xs">
                    <div class="flex items-center space-x-3">
                        <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-700 text-sm shadow-xs">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Filter & Search Bar -->
            <div
                class="bg-white rounded-2xl sm:rounded-3xl border border-[#e2e8f0] p-4 sm:p-5 shadow-xs flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="relative w-full md:w-96">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-[#64748b]">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </span>
                    <form action="{{ route('user-kerjasamas.index') }}" method="GET">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari judul atau nama mitra..."
                            class="w-full pl-10 pr-4 py-2.5 bg-[#f8fafc] border border-[#e2e8f0] rounded-xl text-sm text-[#1e293b] placeholder-[#64748b] focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition duration-200">
                    </form>
                </div>

                <div class="flex items-center self-start md:self-auto">
                    <div
                        class="px-4 py-2 bg-indigo-50/80 border border-indigo-100/60 rounded-xl text-indigo-700 text-xs sm:text-sm font-semibold tracking-wide">
                        Total Kerja Sama: <span
                            class="font-bold">{{ isset($kerjasamas) && method_exists($kerjasamas, 'total') ? $kerjasamas->total() : count($kerjasamas ?? []) }}</span>
                    </div>
                </div>
            </div>

            <!-- TABEL KONTAINER -->
            <div class="bg-white rounded-2xl sm:rounded-3xl border border-[#e2e8f0] shadow-xs overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr
                                class="border-b border-[#e2e8f0] bg-[#f8fafc]/50 text-[#64748b] font-semibold uppercase text-[11px] tracking-wider">
                                <th class="py-4 px-6 w-16">NO</th>
                                <th class="py-4 px-6">JUDUL & MITRA</th>
                                <th class="py-4 px-6">PERIODE</th>
                                <th class="py-4 px-6">STATUS</th>
                                <th class="py-4 px-6">DOKUMEN</th>
                                <th class="py-4 px-6 text-right">AKSI</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#f1f5f9] text-[#1e293b] text-sm font-medium">
                            @forelse($kerjasamas ?? [] as $index => $item)
                                @php
                                    $status = strtolower($item->status ?? 'pending');
                                    $canCancel = in_array($status, ['pending', 'aktif']);
                                @endphp
                                <tr class="hover:bg-[#f8fafc]/80 transition duration-200 group" x-data="{ openCancelModal: false }">
                                    <!-- NO -->
                                    <td class="py-4 px-6 text-[#64748b] text-xs">
                                        {{ method_exists($kerjasamas, 'firstItem') ? $kerjasamas->firstItem() + $index : $index + 1 }}
                                    </td>

                                    <!-- JUDUL & MITRA -->
                                    <td class="py-4 px-6">
                                        <div class="max-w-md">
                                            <a href="{{ route('user-kerjasamas.show', $item->id ?? 1) }}"
                                                class="font-semibold text-[#1e293b] group-hover:text-indigo-600 transition truncate block"
                                                title="{{ $item->judul ?? '' }}">
                                                {{ $item->judul ?? 'Judul Kerja Sama' }}
                                            </a>
                                            <span class="text-xs text-[#64748b] font-normal block mt-0.5">
                                                Mitra: <strong
                                                    class="text-[#1e293b]">{{ $item->mitra ?? 'Nama Mitra' }}</strong>
                                            </span>
                                        </div>
                                    </td>

                                    <!-- PERIODE -->
                                    <td class="py-4 px-6 text-[#64748b] text-xs whitespace-nowrap">
                                        <div class="flex flex-col">
                                            <span>Mulai:
                                                {{ isset($item->tanggal_mulai) ? \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M Y') : '-' }}</span>
                                            <span>Selesai:
                                                {{ isset($item->tanggal_selesai) ? \Carbon\Carbon::parse($item->tanggal_selesai)->format('d M Y') : '-' }}</span>
                                        </div>
                                    </td>

                                    <!-- STATUS -->
                                    <td class="py-4 px-6">
                                        @php
                                            $badgeStyle = match ($status) {
                                                'aktif' => 'bg-emerald-50 text-emerald-700 border-emerald-200/60',
                                                'pending' => 'bg-amber-50 text-amber-700 border-amber-200/60',
                                                'selesai' => 'bg-sky-50 text-sky-700 border-sky-200/60',
                                                'terminasi',
                                                'dibatalkan'
                                                    => 'bg-rose-50 text-rose-700 border-rose-200/60',
                                                default => 'bg-slate-50 text-slate-700 border-slate-200',
                                            };
                                        @endphp
                                        <span
                                            class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wide border {{ $badgeStyle }}">
                                            {{ ucfirst($status) }}
                                        </span>
                                    </td>

                                    <!-- FILE DOKUMEN -->
                                    <td class="py-4 px-6 text-xs whitespace-nowrap">
                                        @if (!empty($item->file_dokumen))
                                            <a href="{{ asset('storage/' . $item->file_dokumen) }}" target="_blank"
                                                class="inline-flex items-center text-indigo-600 hover:underline font-semibold">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                                Unduh Dokumen
                                            </a>
                                        @else
                                            <span class="text-slate-400 italic">Tidak ada file</span>
                                        @endif
                                    </td>

                                    <!-- AKSI -->
                                    <td class="py-4 px-6 text-right whitespace-nowrap">
                                        <div class="inline-flex items-center space-x-1.5">
                                            <!-- Tombol Show (Detail) -->
                                            <a href="{{ route('user-kerjasamas.show', $item->id ?? 1) }}"
                                                class="w-9 h-9 rounded-xl bg-sky-50 border border-sky-100 text-sky-600 flex items-center justify-center hover:bg-sky-100 transition duration-200"
                                                title="Lihat Detail">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>

                                            @if ($canCancel)
                                                <!-- Tombol Batal -->
                                                <button @click="openCancelModal = true" type="button"
                                                    class="w-9 h-9 rounded-xl bg-rose-50 border border-rose-100 text-rose-600 flex items-center justify-center hover:bg-rose-100 transition duration-200"
                                                    title="Batalkan Kerjasama">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                </button>

                                                <!-- Modal Konfirmasi Pembatalan -->
                                                <div x-show="openCancelModal" x-cloak
                                                    class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-xs">
                                                    <div class="bg-white rounded-3xl p-6 max-w-md w-full space-y-4 border border-[#e2e8f0] shadow-xl text-left"
                                                        @click.away="openCancelModal = false">
                                                        <div
                                                            class="w-10 h-10 rounded-2xl bg-rose-50 border border-rose-100 text-rose-600 flex items-center justify-center">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                                            </svg>
                                                        </div>
                                                        <div>
                                                            <h3 class="text-base font-bold text-[#1e293b]">Batalkan
                                                                Pengajuan Kerjasama?</h3>
                                                            <p class="text-xs text-[#64748b] mt-1">Tindakan ini akan
                                                                mengubah status kerjasama menjadi dibatalkan.</p>
                                                        </div>

                                                        <form action="{{ route('user-kerjasamas.cancel', $item->id) }}"
                                                            method="POST" class="space-y-4">
                                                            @csrf
                                                            @method('PATCH')
                                                            <div>
                                                                <label
                                                                    class="block text-xs font-semibold text-[#1e293b] mb-1">Alasan
                                                                    Pembatalan (Opsional)</label>
                                                                <textarea name="keterangan" rows="3" placeholder="Masukkan alasan pembatalan..."
                                                                    class="w-full p-3 bg-[#f8fafc] border border-[#e2e8f0] rounded-xl text-sm text-[#1e293b] focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600"></textarea>
                                                            </div>

                                                            <div class="flex items-center justify-end space-x-2 pt-2">
                                                                <button @click="openCancelModal = false" type="button"
                                                                    class="px-4 py-2 rounded-xl border border-[#e2e8f0] text-xs font-semibold text-[#64748b] hover:bg-slate-50 transition">
                                                                    Kembali
                                                                </button>
                                                                <button type="submit"
                                                                    class="px-4 py-2 rounded-xl bg-rose-600 text-white text-xs font-semibold hover:bg-rose-500 transition">
                                                                    Ya, Batalkan
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-12 px-6 text-center">
                                        <div class="flex flex-col items-center justify-center space-y-3">
                                            <div
                                                class="w-12 h-12 rounded-2xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                                </svg>
                                            </div>
                                            <div>
                                                <h3 class="text-sm font-semibold text-[#1e293b]">Belum ada data kerja sama.
                                                </h3>
                                                <p class="text-xs text-[#64748b] mt-0.5">Silakan tambahkan data kemitraan
                                                    baru.</p>
                                            </div>
                                            <a href="{{ route('user-kerjasamas.create') }}"
                                                class="inline-flex items-center px-4 py-2 rounded-xl bg-indigo-600 text-white text-xs font-semibold hover:bg-indigo-500 transition shadow-xs">
                                                Tambah Kerja Sama Baru
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
@endsection
