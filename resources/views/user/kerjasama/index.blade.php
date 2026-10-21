@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-[#f8fafc] py-8 px-4 sm:px-6 lg:px-8" 
         x-data="{ 
             loading: false, 
             error: false, 
             openGuideModal: false,
             openPksModal: false,
             activeModalId: null,
             activeModalTitle: '',
             activePksUrl: '',
             activeUploadRoute: '',
             activeCanUpload: false,
             activeHasPks: false,
             activeLatestPksDate: '',
             activePksFileUrl: ''
         }">
        <div class="max-w-7xl mx-auto space-y-6">

            <!-- Header Halaman -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h1 class="text-xl sm:text-2xl font-bold text-[#1e293b] tracking-tight">Daftar Kerja Sama</h1>
                    <p class="text-sm text-[#64748b] mt-1">Kelola dokumen, mitra, dan status kerja sama instansi dengan mudah.</p>
                </div>

                <div class="flex items-center gap-3">
                    <button @click="openGuideModal = true" type="button"
                        class="inline-flex items-center justify-center px-4 py-2.5 rounded-xl bg-white border border-[#e2e8f0] text-slate-700 text-sm font-semibold shadow-xs hover:bg-slate-50 transition duration-200">
                        <svg class="w-4 h-4 mr-2 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Panduan Penggunaan
                    </button>

                    <a href="{{ route('user-kerjasamas.create') }}"
                        class="inline-flex items-center justify-center px-4 py-2.5 rounded-xl bg-indigo-600 text-white text-sm font-semibold shadow-xs hover:bg-indigo-500 transition duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Tambah Kerja Sama Baru
                    </a>
                </div>
            </div>

            <!-- Flash Message Success -->
            @if (session('success'))
                <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-100 text-emerald-700 text-sm flex items-center justify-between shadow-xs">
                    <div class="flex items-center space-x-3">
                        <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
            <div class="bg-white rounded-2xl sm:rounded-3xl border border-[#e2e8f0] p-4 sm:p-5 shadow-xs flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="relative w-full md:w-96">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-[#64748b]">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </span>
                    <form action="{{ route('user-kerjasamas.index') }}" method="GET">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari judul atau nama mitra..."
                            class="w-full pl-10 pr-4 py-2.5 bg-[#f8fafc] border border-[#e2e8f0] rounded-xl text-sm text-[#1e293b] placeholder-[#64748b] focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition duration-200">
                    </form>
                </div>

                <div class="flex items-center self-start md:self-auto">
                    <div class="px-4 py-2 bg-indigo-50/80 border border-indigo-100/60 rounded-xl text-indigo-700 text-xs sm:text-sm font-semibold tracking-wide">
                        Total Kerja Sama: <span class="font-bold">{{ isset($kerjasamas) && method_exists($kerjasamas, 'total') ? $kerjasamas->total() : count($kerjasamas ?? []) }}</span>
                    </div>
                </div>
            </div>

            <!-- TABEL KONTAINER -->
            <div class="bg-white rounded-2xl sm:rounded-3xl border border-[#e2e8f0] shadow-xs overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-[#e2e8f0] bg-[#f8fafc]/50 text-[#64748b] font-semibold uppercase text-[11px] tracking-wider">
                                <th class="py-4 px-6 w-16">NO</th>
                                <th class="py-4 px-6">JUDUL & MITRA</th>
                                <th class="py-4 px-6">STATUS</th>
                                <th class="py-4 px-6 text-right">AKSI</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#f1f5f9] text-[#1e293b] text-sm font-medium">
                            @forelse($kerjasamas ?? [] as $index => $item)
                                @php
                                    $status = strtolower($item->latestStatus->status ?? 'pending');
                                    $canCancel = $status === 'pending';
                                    $showPks = in_array($status, ['pending', 'aktif', 'selesai']);
                                    $canUploadPks = in_array($status, ['pending', 'aktif']);
                                    
                                    $hasPks = $item->dokumens->isNotEmpty();
                                    $latestPks = $item->dokumens->last();
                                    $pksUrl = $hasPks ? Storage::url($latestPks->dokumen) : '';
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
                                                Mitra: <strong class="text-[#1e293b]">{{ $item->mitra ?? 'Nama Mitra' }}</strong>
                                            </span>
                                        </div>
                                    </td>

                                    <!-- STATUS -->
                                    <td class="py-4 px-6">
                                        @php
                                            $badgeStyle = match ($status) {
                                                'aktif' => 'bg-emerald-50 text-emerald-700 border-emerald-200/60',
                                                'pending' => 'bg-amber-50 text-amber-700 border-amber-200/60',
                                                'selesai' => 'bg-sky-50 text-sky-700 border-sky-200/60',
                                                'terminasi', 'dibatalkan', 'ditolak' => 'bg-rose-50 text-rose-700 border-rose-200/60',
                                                default => 'bg-slate-50 text-slate-700 border-slate-200',
                                            };
                                        @endphp
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wide border {{ $badgeStyle }}">
                                            {{ ucfirst($status) }}
                                        </span>

                                        @if ($hasPks)
                                            <span class="mt-1.5 flex items-center gap-1 text-[10px] font-semibold text-emerald-600">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                                                </svg>
                                                PKS terunggah
                                            </span>
                                        @elseif ($showPks)
                                            <span class="mt-1.5 block text-[10px] font-medium text-amber-600">
                                                PKS belum diunggah
                                            </span>
                                        @endif
                                    </td>

                                    <!-- AKSI -->
                                    <td class="py-4 px-6 text-right whitespace-nowrap">
                                        <div class="inline-flex items-center space-x-1.5">
                                            <!-- Tombol Show (Detail) -->
                                            <a href="{{ route('user-kerjasamas.show', $item->id ?? 1) }}"
                                                class="w-9 h-9 rounded-xl bg-sky-50 border border-sky-100 text-sky-600 flex items-center justify-center hover:bg-sky-100 transition duration-200"
                                                title="Lihat Detail">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>

                                            @if ($showPks)
                                                <!-- Tombol Modal PKS (Selalu membuka modal universal agar user bisa unduh/lihat/unggah) -->
                                                <button @click="
                                                    activeModalId = '{{ $item->id }}';
                                                    activeModalTitle = '{{ addslashes($item->judul) }}';
                                                    activePksUrl = '{{ route('user-kerjasamas.pks', $item->id) }}';
                                                    activeUploadRoute = '{{ route('user-kerjasamas.pks.upload', $item->id) }}';
                                                    activeCanUpload = {{ $canUploadPks ? 'true' : 'false' }};
                                                    activeHasPks = {{ $hasPks ? 'true' : 'false' }};
                                                    activeLatestPksDate = '{{ $latestPks && $latestPks->created_at ? \Carbon\Carbon::parse($latestPks->created_at)->format('d M Y, H:i') : '' }}';
                                                    activePksFileUrl = '{{ $pksUrl }}';
                                                    openPksModal = true;
                                                " type="button"
                                                    class="w-9 h-9 rounded-xl {{ $hasPks ? 'bg-emerald-50 border border-emerald-100 text-emerald-600 hover:bg-emerald-100' : 'bg-indigo-50 border border-indigo-100 text-indigo-600 hover:bg-indigo-100' }} flex items-center justify-center transition duration-200"
                                                    title="Dokumen PKS">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                    </svg>
                                                </button>
                                            @endif

                                            @if ($canCancel)
                                                <button @click="openCancelModal = true" type="button"
                                                    class="w-9 h-9 rounded-xl bg-rose-50 border border-rose-100 text-rose-600 flex items-center justify-center hover:bg-rose-100 transition duration-200"
                                                    title="Batalkan Kerjasama">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                </button>

                                                <!-- Modal Pembatalan -->
                                                <div x-show="openCancelModal" x-cloak style="display: none;"
                                                    class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-xs">
                                                    <div class="bg-white rounded-3xl p-6 max-w-md w-full space-y-4 border border-[#e2e8f0] shadow-xl text-left"
                                                        @click.away="openCancelModal = false">
                                                        <div class="w-10 h-10 rounded-2xl bg-rose-50 border border-rose-100 text-rose-600 flex items-center justify-center">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                                            </svg>
                                                        </div>
                                                        <div>
                                                            <h3 class="text-base font-bold text-[#1e293b]">Batalkan Pengajuan Kerjasama?</h3>
                                                            <p class="text-xs text-[#64748b] mt-1">Tindakan ini akan mengubah status pengajuan menjadi dibatalkan.</p>
                                                        </div>
                                                        <form action="{{ route('user-kerjasamas.cancel', $item->id) }}" method="POST" class="space-y-3">
                                                            @csrf
                                                            <textarea name="keterangan" placeholder="Alasan pembatalan (opsional)..."
                                                                class="w-full p-3 text-xs bg-[#f8fafc] border border-[#e2e8f0] rounded-xl focus:ring-2 focus:ring-rose-500/20 focus:border-rose-600 outline-none resize-none" rows="3"></textarea>
                                                            <div class="flex items-center justify-end gap-2 pt-2">
                                                                <button @click="openCancelModal = false" type="button"
                                                                    class="px-4 py-2 rounded-xl border border-[#e2e8f0] text-xs font-semibold text-[#64748b] hover:bg-slate-50 transition">
                                                                    Tutup
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
                                    <td colspan="4" class="py-8 text-center text-sm text-[#64748b]">
                                        Belum ada data kerja sama.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- ========================================================== -->
        <!-- MODAL UNIVERSAL PKS DI LUAR TABEL -->
        <!-- ========================================================== -->
        <div x-show="openPksModal" x-cloak style="display: none;"
            @keydown.escape.window="openPksModal = false"
            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-xs overflow-y-auto"
            x-data="{ submitting: false }">
            <div class="bg-white rounded-3xl p-6 max-w-lg w-full space-y-5 border border-[#e2e8f0] shadow-xl text-left max-h-[90vh] overflow-y-auto my-auto"
                @click.away="openPksModal = false">

                <!-- Header Modal -->
                <div class="flex items-start justify-between gap-3">
                    <div class="flex items-start gap-3 min-w-0">
                        <div class="w-10 h-10 rounded-2xl bg-indigo-50 border border-indigo-100 text-indigo-600 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <div class="min-w-0 flex-1">
                            <h3 class="text-base font-bold text-[#1e293b] leading-snug">
                                Surat Perjanjian Kerja Sama (PKS)
                            </h3>
                            <p class="text-xs text-[#64748b] mt-0.5 break-words" x-text="activeModalTitle"></p>
                        </div>
                    </div>
                    <button @click="openPksModal = false" type="button" class="text-slate-400 hover:text-slate-600 transition shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Langkah 1: Unduh PKS -->
                <div class="p-4 rounded-2xl bg-[#f8fafc] border border-[#e2e8f0] space-y-3">
                    <div class="flex items-start gap-3">
                        <span class="w-6 h-6 rounded-full bg-indigo-600 text-white text-xs font-bold flex items-center justify-center shrink-0">1</span>
                        <div class="min-w-0 flex-1">
                            <p class="text-sm font-semibold text-[#1e293b]">Unduh PKS</p>
                            <p class="text-xs text-[#64748b] mt-0.5 leading-relaxed break-words">
                                Unduh surat perjanjian yang sudah terisi otomatis, cetak, bubuhkan tanda tangan dan matrai.
                            </p>
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-2 pl-9">
                        <template x-if="activePksUrl">
                            <a :href="activePksUrl + '?unduh=1'"
                                target="_blank" rel="noopener"
                                class="inline-flex items-center px-3.5 py-2 rounded-xl bg-indigo-600 text-white text-xs font-semibold hover:bg-indigo-500 transition">
                                Unduh PKS
                            </a>
                        </template>
                        <template x-if="activePksUrl">
                            <a :href="activePksUrl"
                                target="_blank" rel="noopener"
                                class="inline-flex items-center px-3.5 py-2 rounded-xl bg-white border border-[#e2e8f0] text-xs font-semibold text-[#1e293b] hover:bg-slate-50 transition">
                                Pratinjau
                            </a>
                        </template>
                    </div>
                </div>

                <!-- Langkah 2: Berkas PKS / Unggah PKS bertanda tangan -->
                <div class="p-4 rounded-2xl bg-[#f8fafc] border border-[#e2e8f0] space-y-3">
                    <div class="flex items-start gap-3">
                        <span class="w-6 h-6 rounded-full bg-indigo-600 text-white text-xs font-bold flex items-center justify-center shrink-0">2</span>
                        <div class="min-w-0 flex-1">
                            <p class="text-sm font-semibold text-[#1e293b]">Berkas PKS Bertanda Tangan</p>
                            <p class="text-xs text-[#64748b] mt-0.5 leading-relaxed break-words" x-text="activeHasPks ? 'PKS telah berhasil diunggah.' : 'Pindai/foto PKS yang sudah ditandatangani, simpan sebagai PDF (maks. 5 MB).'"></p>
                        </div>
                    </div>

                    <div class="pl-9 space-y-3">
                        <!-- TAMPILKAN KOMPONEN HIJAU JIKA SUDAH DIUNGGAH -->
                        <template x-if="activeHasPks">
                            <div class="flex items-center justify-between gap-3 p-3.5 rounded-2xl bg-emerald-50 border border-emerald-100/80 shadow-2xs">
                                <div class="min-w-0 flex-1">
                                    <p class="text-xs font-bold text-emerald-800">
                                        PKS sudah diunggah
                                    </p>
                                    <p class="text-[11px] font-medium text-emerald-600/90 mt-0.5" x-text="activeLatestPksDate"></p>
                                </div>
                                <div class="flex items-center gap-2 shrink-0">
                                    <a :href="activePksFileUrl" target="_blank" rel="noopener"
                                        class="px-3.5 py-1.5 rounded-xl bg-white border border-emerald-200 text-xs font-semibold text-emerald-700 hover:bg-emerald-100/50 transition duration-200 shadow-2xs">
                                        Lihat
                                    </a>
                                    <a :href="activePksFileUrl" download
                                        class="px-3.5 py-1.5 rounded-xl bg-emerald-600 text-xs font-semibold text-white hover:bg-emerald-500 transition duration-200 shadow-2xs">
                                        Unduh
                                    </a>
                                </div>
                            </div>
                        </template>

                        <!-- TAMPILKAN FORM UNGGAH JIKA BELUM DIUNGGAH -->
                        <template x-if="!activeHasPks">
                            <div>
                                <template x-if="activeCanUpload">
                                    <form :action="activeUploadRoute"
                                        method="POST" enctype="multipart/form-data"
                                        class="space-y-3"
                                        @submit="if (submitting) { $event.preventDefault(); return; } submitting = true;">
                                        @csrf

                                        <div class="space-y-2">
                                            <input type="file" name="file_pks"
                                                accept="application/pdf,.pdf" required
                                                class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-3.5 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition">
                                        </div>

                                        <button type="submit" :disabled="submitting"
                                            class="inline-flex items-center px-4 py-2 rounded-xl bg-indigo-600 text-white text-xs font-semibold hover:bg-indigo-500 disabled:opacity-60 disabled:cursor-not-allowed transition">
                                            <span x-text="submitting ? 'Mengunggah...' : 'Unggah PKS'"></span>
                                        </button>
                                    </form>
                                </template>
                                <template x-if="!activeCanUpload">
                                    <p class="text-xs text-[#64748b] italic">
                                        Unggah PKS tidak tersedia untuk status saat ini.
                                    </p>
                                </template>
                            </div>
                        </template>
                    </div>
                </div>

                <div class="flex justify-end pt-2">
                    <button @click="openPksModal = false" type="button"
                        class="px-4 py-2 rounded-xl border border-[#e2e8f0] text-xs font-semibold text-[#64748b] hover:bg-slate-50 transition">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection