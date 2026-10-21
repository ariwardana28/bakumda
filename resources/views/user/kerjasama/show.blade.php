@extends('layouts.app')

@section('content')
    @php
        // Ambil status terakhir dari relasi kerjasama_status, fallback ke 'pending' jika belum ada
        $latestStatusRecord = $kerjasama->latestStatus;
        $status = strtolower($latestStatusRecord ? $latestStatusRecord->status : 'pending');

        $badgeColor = match ($status) {
            'aktif' => 'bg-emerald-50 text-emerald-700 border-emerald-200/60',
            'pending' => 'bg-amber-50 text-amber-700 border-amber-200/60',
            'selesai' => 'bg-sky-50 text-sky-700 border-sky-200/60',
            'terminasi', 'dibatalkan' => 'bg-rose-50 text-rose-700 border-rose-200/60',
            default => 'bg-slate-50 text-slate-700 border-slate-200',
        };

        $mulai = $kerjasama->tanggal_mulai ? \Carbon\Carbon::parse($kerjasama->tanggal_mulai) : null;
        $selesai = $kerjasama->tanggal_selesai ? \Carbon\Carbon::parse($kerjasama->tanggal_selesai) : null;

        // Durasi kerjasama (dalam hari)
        $durasi = $mulai && $selesai ? $mulai->diffInDays($selesai) : null;

        // Sisa hari sampai berakhir (hanya relevan jika belum lewat)
        $sisaHari = $selesai && $selesai->isFuture() ? (int) now()->startOfDay()->diffInDays($selesai) : null;

        $ext = $kerjasama->file_dokumen ? strtolower(pathinfo($kerjasama->file_dokumen, PATHINFO_EXTENSION)) : null;

        // Cek PKS pada tabel kerjasama_dokumen
        $hasPks = $kerjasama->dokumens->isNotEmpty();
        $latestPks = $kerjasama->dokumens->last();

        $showPksSection = in_array($status, ['pending', 'aktif', 'selesai']);
        $canUploadPks = in_array($status, ['pending', 'aktif']);
        $pksBag = 'pks_' . Str::slug($kerjasama->judul);

        // Modal otomatis terbuka lagi jika validasi gagal
        $reopenModal = $errors->has('keterangan') || $errors->has('status') || $errors->hasBag($pksBag);
        $oldAction = old('status') === 'aktif' ? 'aktif' : 'ditolak';
    @endphp

    <div class="min-h-screen bg-[#f8fafc] py-6 px-4 sm:px-6 lg:px-8" x-data="{
        modal: {{ $reopenModal ? 'true' : 'false' }},
        action: '{{ $oldAction }}',
        submitting: false,
        openCancelModal: false,
        openPksModal: {{ $errors->hasBag($pksBag) ? 'true' : 'false' }},
        openModal() {
            this.submitting = false;
            this.modal = true;
        }
    }"
        @keydown.escape.window="modal = false; openCancelModal = false; openPksModal = false">
        <div class="max-w-4xl mx-auto space-y-6">

            <!-- Header + Aksi -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <a href="{{ route('user-kerjasamas.index') }}"
                        class="inline-flex items-center text-xs font-semibold text-[#64748b] hover:text-indigo-600 transition">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                        Kembali ke daftar
                    </a>
                    <h1 class="text-xl sm:text-2xl font-bold text-[#1e293b] tracking-tight mt-2">Detail Kerjasama</h1>
                    <p class="text-sm text-[#64748b] mt-1">Tinjau informasi kerjasama atau kelola dokumen PKS.</p>
                </div>

                <!-- Tombol Aksi (PKS & Pembatalan) -->
                <div class="flex items-center gap-3">
                    @if ($showPksSection)
                        <button @click="openPksModal = true" type="button"
                            class="inline-flex items-center justify-center px-4 py-2.5 rounded-xl bg-indigo-600 text-white text-sm font-semibold hover:bg-indigo-500 transition duration-200 shadow-xs">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Dokumen PKS
                        </button>
                    @endif

                    @if (in_array($status, ['pending']))
                        <button @click="openCancelModal = true" type="button"
                            class="inline-flex items-center justify-center px-4 py-2.5 rounded-xl bg-rose-50 border border-rose-200 text-rose-700 text-sm font-semibold hover:bg-rose-100 transition duration-200">
                            <svg class="w-4 h-4 mr-2 text-rose-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Batalkan Kerjasama
                        </button>
                    @endif
                </div>
            </div>

            <!-- Flash Message -->
            @if (session('success'))
                <div
                    class="p-4 rounded-2xl bg-emerald-50 border border-emerald-100 text-emerald-700 text-sm flex items-center shadow-xs">
                    <svg class="w-5 h-5 mr-2 text-emerald-500 shrink-0" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-700 text-sm shadow-xs">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Keterangan Ditolak / Dibatalkan -->
            @if ($status === 'ditolak' || $status === 'dibatalkan')
                <div class="p-5 rounded-2xl bg-rose-50 border border-rose-200 shadow-xs">
                    <div class="flex items-start gap-3">
                        <div
                            class="w-9 h-9 rounded-xl bg-white border border-rose-200 text-rose-600 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z" />
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <p class="text-xs font-bold uppercase tracking-wider text-rose-700">Pengajuan
                                {{ ucfirst($status) }}</p>
                            <p class="text-sm text-rose-800 mt-1.5 leading-relaxed whitespace-pre-line">
                                {{ optional($latestStatusRecord)->keterangan ?: 'Tidak ada keterangan pembatalan/penolakan.' }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Kartu Utama -->
            <div class="bg-white rounded-2xl sm:rounded-3xl border border-[#e2e8f0] shadow-xs overflow-hidden">

                <!-- Judul & Status -->
                <div class="p-6 sm:p-8 border-b border-[#e2e8f0]">
                    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                        <div class="flex items-start gap-4 min-w-0">
                            <div
                                class="w-12 h-12 rounded-2xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-700 font-bold text-sm shrink-0">
                                {{ strtoupper(substr($kerjasama->judul ?? 'K', 0, 2)) }}
                            </div>
                            <div class="min-w-0">
                                <h2 class="text-lg sm:text-xl font-bold text-[#1e293b] leading-snug break-words">
                                    {{ $kerjasama->judul }}
                                </h2>
                                <p class="text-sm text-[#64748b] mt-1">
                                    Mitra: <span class="font-semibold text-[#1e293b]">{{ $kerjasama->mitra }}</span>
                                </p>
                            </div>
                        </div>

                        <span
                            class="inline-flex items-center self-start px-3 py-1.5 rounded-full text-[11px] font-bold uppercase tracking-wide border {{ $badgeColor }}">
                            {{ ucfirst($status) }}
                        </span>
                    </div>
                </div>

                <!-- Informasi Tambahan: Biaya Pelatihan & Ringkasan Tanggal -->
                <div
                    class="grid grid-cols-1 sm:grid-cols-4 divide-y sm:divide-y-0 sm:divide-x divide-[#e2e8f0] border-b border-[#e2e8f0]">
                    <div class="p-5 sm:p-6">
                        <p class="text-[11px] font-semibold uppercase tracking-wider text-[#64748b]">Biaya Pelatihan</p>
                        <p class="text-sm font-bold text-indigo-600 mt-1.5">
                            Rp {{ number_format($kerjasama->biaya_pelatihan ?? 0, 0, ',', '.') }}
                        </p>
                    </div>
                    <div class="p-5 sm:p-6">
                        <p class="text-[11px] font-semibold uppercase tracking-wider text-[#64748b]">Tanggal Mulai</p>
                        <p class="text-sm font-bold text-[#1e293b] mt-1.5">
                            {{ $mulai ? $mulai->translatedFormat('d F Y') : '-' }}
                        </p>
                    </div>
                    <div class="p-5 sm:p-6">
                        <p class="text-[11px] font-semibold uppercase tracking-wider text-[#64748b]">Tanggal Selesai</p>
                        <p class="text-sm font-bold text-[#1e293b] mt-1.5">
                            {{ $selesai ? $selesai->translatedFormat('d F Y') : '-' }}
                        </p>
                    </div>
                    <div class="p-5 sm:p-6">
                        <p class="text-[11px] font-semibold uppercase tracking-wider text-[#64748b]">Durasi</p>
                        <p class="text-sm font-bold text-[#1e293b] mt-1.5">
                            {{ !is_null($durasi) ? $durasi . ' hari' : '-' }}
                        </p>
                        @if (!is_null($sisaHari) && $status === 'aktif')
                            <p class="text-xs text-emerald-600 font-semibold mt-0.5">Sisa {{ $sisaHari }} hari</p>
                        @endif
                    </div>
                </div>

                <!-- Deskripsi -->
                <div class="p-6 sm:p-8 border-b border-[#e2e8f0]">
                    <h3 class="text-[11px] font-semibold uppercase tracking-wider text-[#64748b] mb-2">Deskripsi</h3>
                    @if ($kerjasama->deskripsi)
                        <p class="text-sm text-[#1e293b] leading-relaxed whitespace-pre-line">{{ $kerjasama->deskripsi }}
                        </p>
                    @else
                        <p class="text-sm text-[#64748b] italic">Tidak ada deskripsi.</p>
                    @endif
                </div>

                <!-- Dokumen Pendukung -->
                <div class="p-6 sm:p-8 border-b border-[#e2e8f0]">
                    <h3 class="text-[11px] font-semibold uppercase tracking-wider text-[#64748b] mb-3">Dokumen Kerjasama
                    </h3>

                    @if ($kerjasama->file_dokumen)
                        <div
                            class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 p-4 rounded-2xl bg-[#f8fafc] border border-[#e2e8f0]">
                            <div class="flex items-center gap-3 min-w-0">
                                <div
                                    class="w-10 h-10 rounded-xl bg-rose-50 border border-rose-100 text-rose-600 flex items-center justify-center text-[10px] font-bold uppercase shrink-0">
                                    {{ $ext ?: 'file' }}
                                </div>
                                <div class="min-w-0">
                                    <p class="text-sm font-semibold text-[#1e293b] truncate">
                                        {{ basename($kerjasama->file_dokumen) }}
                                    </p>
                                    <p class="text-xs text-[#64748b]">Berkas dokumen kerjasama</p>
                                </div>
                            </div>

                            <div class="flex items-center gap-2">
                                <a href="{{ asset('storage/' . $kerjasama->file_dokumen) }}" target="_blank"
                                    class="inline-flex items-center px-3.5 py-2 rounded-xl bg-white border border-[#e2e8f0] text-xs font-semibold text-[#1e293b] hover:bg-slate-50 transition">
                                    Buka
                                </a>
                                <a href="{{ asset('storage/' . $kerjasama->file_dokumen) }}" download
                                    class="inline-flex items-center px-3.5 py-2 rounded-xl bg-indigo-600 text-xs font-semibold text-white hover:bg-indigo-500 transition">
                                    Unduh
                                </a>
                            </div>
                        </div>

                        @if ($ext === 'pdf')
                            <div class="mt-4 rounded-2xl overflow-hidden border border-[#e2e8f0]">
                                <iframe src="{{ asset('storage/' . $kerjasama->file_dokumen) }}" class="w-full h-[480px]"
                                    title="Pratinjau dokumen"></iframe>
                            </div>
                        @endif
                    @else
                        <div
                            class="p-4 rounded-2xl bg-[#f8fafc] border border-dashed border-[#e2e8f0] text-sm text-[#64748b] italic">
                            Belum ada dokumen yang diunggah.
                        </div>
                    @endif
                </div>

                <!-- Bagian Status PKS Terunggah di Halaman Utama -->
                <div class="p-6 sm:p-8 border-b border-[#e2e8f0] bg-slate-50/50">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <h3 class="text-xs font-bold uppercase tracking-wider text-[#64748b]">Status Berkas PKS</h3>
                            @if ($hasPks)
                                <p class="text-sm font-semibold text-emerald-600 mt-1 flex items-center gap-1.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    Dokumen PKS bertanda tangan sudah diunggah
                                </p>
                            @else
                                <p class="text-sm font-medium text-amber-600 mt-1">
                                    Dokumen PKS bertanda tangan belum diunggah. Silakan klik tombol "Dokumen PKS" di atas
                                    untuk mengunduh dan mengunggahnya.
                                </p>
                            @endif
                        </div>

                        @if ($hasPks)
                            <div class="flex items-center gap-2">
                                <a href="{{ Storage::url($latestPks->dokumen) }}" target="_blank" rel="noopener"
                                    class="inline-flex items-center px-3.5 py-2 rounded-xl bg-white border border-[#e2e8f0] text-xs font-semibold text-[#1e293b] hover:bg-slate-50 transition">
                                    Lihat PKS
                                </a>
                                <a href="{{ Storage::url($latestPks->dokumen) }}" download
                                    class="inline-flex items-center px-3.5 py-2 rounded-xl bg-emerald-600 text-xs font-semibold text-white hover:bg-emerald-500 transition">
                                    Unduh PKS
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Meta -->
                <div
                    class="px-6 sm:px-8 py-4 bg-[#f8fafc]/60 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-1 text-xs text-[#64748b]">
                    <span>Dibuat: {{ optional($kerjasama->created_at)->format('d M Y, H:i') ?? '-' }}</span>
                    <span>Diperbarui: {{ optional($kerjasama->updated_at)->format('d M Y, H:i') ?? '-' }}</span>
                </div>
            </div>

            <!-- ===================== MODAL PKS (UNDUH & UNGGAH) ===================== -->
            @if ($showPksSection)
                <div x-show="openPksModal" x-cloak style="display: none;" @keydown.escape.window="openPksModal = false"
                    class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-xs overflow-y-auto"
                    x-data="{ submitting: false }">
                    <div class="bg-white rounded-3xl p-6 max-w-lg w-full space-y-5 border border-[#e2e8f0] shadow-xl text-left max-h-[90vh] overflow-y-auto my-auto"
                        @click.away="openPksModal = false">

                        <!-- Header Modal -->
                        <div class="flex items-start justify-between gap-3">
                            <div class="flex items-start gap-3 min-w-0">
                                <div
                                    class="w-10 h-10 rounded-2xl bg-indigo-50 border border-indigo-100 text-indigo-600 flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <h3 class="text-base font-bold text-[#1e293b] leading-snug">
                                        Surat Perjanjian Kerja Sama (PKS)
                                    </h3>
                                    <p class="text-xs text-[#64748b] mt-0.5 break-words">
                                        {{ $kerjasama->judul }}
                                    </p>
                                </div>
                            </div>
                            <button @click="openPksModal = false" type="button"
                                class="text-slate-400 hover:text-slate-600 transition shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <!-- Langkah 1: Unduh PKS -->
                        <div class="p-4 rounded-2xl bg-[#f8fafc] border border-[#e2e8f0] space-y-3">
                            <div class="flex items-start gap-3">
                                <span
                                    class="w-6 h-6 rounded-full bg-indigo-600 text-white text-xs font-bold flex items-center justify-center shrink-0">1</span>
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm font-semibold text-[#1e293b]">Unduh PKS</p>
                                    <p class="text-xs text-[#64748b] mt-0.5 leading-relaxed break-words">
                                        Unduh surat perjanjian yang sudah terisi otomatis, cetak, bubuhkan tanda tangan dan
                                        matrai.
                                    </p>
                                </div>
                            </div>
                            <div class="flex flex-wrap gap-2 pl-9">
                                <a href="{{ route('user-kerjasamas.pks', ['id' => $kerjasama->id, 'unduh' => 1]) }}"
                                    target="_blank" rel="noopener"
                                    class="inline-flex items-center px-3.5 py-2 rounded-xl bg-indigo-600 text-white text-xs font-semibold hover:bg-indigo-500 transition">
                                    Unduh PKS
                                </a>
                                <a href="{{ route('user-kerjasamas.pks', $kerjasama->id) }}" target="_blank"
                                    rel="noopener"
                                    class="inline-flex items-center px-3.5 py-2 rounded-xl bg-white border border-[#e2e8f0] text-xs font-semibold text-[#1e293b] hover:bg-slate-50 transition">
                                    Pratinjau
                                </a>
                            </div>
                        </div>

                        <!-- Langkah 2: Unggah PKS bertanda tangan -->
                        <!-- Langkah 2: Unggah PKS bertanda tangan -->
                        <div class="p-4 rounded-2xl bg-[#f8fafc] border border-[#e2e8f0] space-y-3">
                            <div class="flex items-start gap-3">
                                <span
                                    class="w-6 h-6 rounded-full bg-indigo-600 text-white text-xs font-bold flex items-center justify-center shrink-0">2</span>
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm font-semibold text-[#1e293b]">Berkas PKS Bertanda Tangan</p>
                                    <p class="text-xs text-[#64748b] mt-0.5 leading-relaxed break-words">
                                        {{ $hasPks ? 'PKS telah berhasil diunggah.' : 'Pindai/foto PKS yang sudah ditandatangani, simpan sebagai PDF (maks. 5 MB).' }}
                                    </p>
                                </div>
                            </div>

                            <div class="pl-9 space-y-3">
                                @if ($hasPks)
                                    {{-- HANYA TAMPILKAN KOMPONEN INI JIKA SUDAH DIUNGGAH --}}
                                    <div
                                        class="flex items-center justify-between gap-3 p-3.5 rounded-2xl bg-emerald-50 border border-emerald-100/80 shadow-2xs">
                                        <div class="min-w-0 flex-1">
                                            <p class="text-xs font-bold text-emerald-800">
                                                PKS sudah diunggah
                                            </p>
                                            @if ($latestPks && $latestPks->created_at)
                                                <p class="text-[11px] font-medium text-emerald-600/90 mt-0.5">
                                                    {{ \Carbon\Carbon::parse($latestPks->created_at)->format('d M Y, H:i') }}
                                                </p>
                                            @endif
                                        </div>
                                        <div class="flex items-center gap-2 shrink-0">
                                            <a href="{{ Storage::url($latestPks->dokumen) }}" target="_blank"
                                                rel="noopener"
                                                class="px-3.5 py-1.5 rounded-xl bg-white border border-emerald-200 text-xs font-semibold text-emerald-700 hover:bg-emerald-100/50 transition duration-200 shadow-2xs">
                                                Lihat
                                            </a>
                                            <a href="{{ Storage::url($latestPks->dokumen) }}" download
                                                class="px-3.5 py-1.5 rounded-xl bg-emerald-600 text-xs font-semibold text-white hover:bg-emerald-500 transition duration-200 shadow-2xs">
                                                Unduh
                                            </a>
                                        </div>
                                    </div>
                                @else
                                    {{-- TAMPILKAN FORM UNGGAH HANYA JIKA BELUM DIUNGGAH --}}
                                    @if ($canUploadPks)
                                        <form action="{{ route('user-kerjasamas.pks.upload', $kerjasama->id) }}"
                                            method="POST" enctype="multipart/form-data" class="space-y-3"
                                            @submit="if (submitting) { $event.preventDefault(); return; } submitting = true;">
                                            @csrf

                                            <div class="space-y-2">
                                                <input type="file" name="file_pks" accept="application/pdf,.pdf"
                                                    required
                                                    class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-3.5 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition">
                                                @if ($errors->hasBag($pksBag))
                                                    <p class="mt-1.5 text-xs font-medium text-rose-600 break-words">
                                                        {{ $errors->getBag($pksBag)->first('file_pks') }}
                                                    </p>
                                                @endif
                                            </div>

                                            <button type="submit" :disabled="submitting"
                                                class="inline-flex items-center px-4 py-2 rounded-xl bg-indigo-600 text-white text-xs font-semibold hover:bg-indigo-500 disabled:opacity-60 disabled:cursor-not-allowed transition">
                                                <span x-text="submitting ? 'Mengunggah...' : 'Unggah PKS'"></span>
                                            </button>
                                        </form>
                                    @else
                                        <p class="text-xs text-[#64748b] italic">
                                            Unggah PKS tidak tersedia untuk status {{ $status }}.
                                        </p>
                                    @endif
                                @endif
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
            @endif

            <!-- Modal Konfirmasi Pembatalan -->
            <div x-show="openCancelModal" x-cloak
                class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-xs">
                <div class="bg-white rounded-3xl p-6 max-w-md w-full space-y-4 border border-[#e2e8f0] shadow-xl text-left"
                    @click.away="openCancelModal = false">
                    <div
                        class="w-10 h-10 rounded-2xl bg-rose-50 border border-rose-100 text-rose-600 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-[#1e293b]">Batalkan Pengajuan Kerjasama?</h3>
                        <p class="text-xs text-[#64748b] mt-1">Tindakan ini akan mengubah status kerjasama menjadi
                            dibatalkan.</p>
                    </div>

                    <!-- Form Pembatalan -->
                    <form action="{{ route('user-kerjasamas.cancel', $kerjasama->id) }}" method="POST"
                        class="space-y-4">
                        @csrf
                        @method('PATCH')
                        <div>
                            <label class="block text-xs font-semibold text-[#1e293b] mb-1">Alasan Pembatalan
                                (Opsional)</label>
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

        </div>
    </div>
@endsection
