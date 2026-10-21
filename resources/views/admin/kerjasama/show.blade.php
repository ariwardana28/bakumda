@extends('layouts.admin')

@section('content')
    @php
        // Mengambil status terakhir dari relasi kerjasama_status, jika null default ke 'pending'
        $latestStatusRecord = $kerjasama->latestStatus;
        $status = strtolower($latestStatusRecord ? $latestStatusRecord->status : 'pending');

        $badgeColor = match ($status) {
            'aktif' => 'bg-emerald-50 text-emerald-700 border-emerald-200/60',
            'pending' => 'bg-amber-50 text-amber-700 border-amber-200/60',
            'selesai' => 'bg-sky-50 text-sky-700 border-sky-200/60',
            default => 'bg-rose-50 text-rose-700 border-rose-200/60',
        };

        $mulai = $kerjasama->tanggal_mulai ? \Carbon\Carbon::parse($kerjasama->tanggal_mulai) : null;
        $selesai = $kerjasama->tanggal_selesai ? \Carbon\Carbon::parse($kerjasama->tanggal_selesai) : null;

        // Durasi kerjasama (dalam hari)
        $durasi = $mulai && $selesai ? $mulai->diffInDays($selesai) : null;

        // Sisa hari sampai berakhir (hanya relevan jika belum lewat)
        $sisaHari = $selesai && $selesai->isFuture() ? (int) now()->startOfDay()->diffInDays($selesai) : null;

        $ext = $kerjasama->file_dokumen ? strtolower(pathinfo($kerjasama->file_dokumen, PATHINFO_EXTENSION)) : null;

        // Cek dokumen PKS yang diunggah user
        $hasPks = $kerjasama->dokumens->isNotEmpty();
        $latestPks = $kerjasama->dokumens->last();

        // Modal otomatis terbuka lagi jika validasi gagal
        $reopenModal = $errors->has('keterangan') || $errors->has('status');
        $oldAction = old('status') === 'aktif' ? 'aktif' : 'dibatalkan';
    @endphp

    <div class="min-h-screen bg-[#f8fafc] py-6 px-4 sm:px-6 lg:px-8"
        x-data="{
            modal: {{ $reopenModal ? 'true' : 'false' }},
            action: '{{ $oldAction }}',
            submitting: false,
            openModal() {
                this.submitting = false;
                this.modal = true;
            }
        }"
        @keydown.escape.window="modal = false">
        <div class="max-w-4xl mx-auto space-y-6">

            <!-- Header + Aksi -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <a href="{{ route('admin.kerjasama.index') }}"
                        class="inline-flex items-center text-xs font-semibold text-[#64748b] hover:text-indigo-600 transition">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                        Kembali ke daftar
                    </a>
                    <h1 class="text-xl sm:text-2xl font-bold text-[#1e293b] tracking-tight mt-2">Detail Kerjasama</h1>
                    <p class="text-sm text-[#64748b] mt-1">Tinjau informasi kerjasama, lalu setujui atau tolak pengajuan.</p>
                </div>

                <!-- Tombol Aksi Kanan Atas -->
                <div class="flex items-center gap-2">
                    {{-- TOMBOL DOKUMEN PKS: HANYA MUNCUL JIKA STATUS SUDAH 'selesai' --}}
                    @if ($status === 'selesai' && $hasPks)
                        <a href="{{ Storage::url($latestPks->dokumen) }}" target="_blank" rel="noopener"
                            class="inline-flex items-center justify-center px-4 py-2.5 rounded-xl bg-emerald-600 text-white text-sm font-semibold shadow-xs hover:bg-emerald-500 transition duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Dokumen PKS
                        </a>
                    @endif

                    {{-- TOMBOL AKSI KONFIRMASI (hanya muncul saat status masih pending) --}}
                    @if ($status === 'pending')
                        <button type="button" @click="openModal()"
                            class="inline-flex items-center justify-center px-4 py-2.5 rounded-xl bg-indigo-600 text-white text-sm font-semibold shadow-xs hover:bg-indigo-500 active:bg-indigo-700 transition duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012-2m-6 9l2 2 4-4" />
                            </svg>
                            Tinjau Pengajuan
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
            @if ($status === 'dibatalkan' || $status === 'ditolak')
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
                            <p class="text-xs font-bold uppercase tracking-wider text-rose-700">Pengajuan Ditolak</p>
                            <p class="text-sm text-rose-800 mt-1.5 leading-relaxed whitespace-pre-line">
                                {{ optional($latestStatusRecord)->keterangan ?: 'Tidak ada keterangan penolakan.' }}</p>
                            @if (optional($latestStatusRecord)->created_at)
                                <p class="text-xs text-rose-600/80 mt-2">
                                    Ditolak pada
                                    {{ \Carbon\Carbon::parse($latestStatusRecord->created_at)->format('d M Y, H:i') }}
                                </p>
                            @endif
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
                <div class="grid grid-cols-1 sm:grid-cols-4 divide-y sm:divide-y-0 sm:divide-x divide-[#e2e8f0] border-b border-[#e2e8f0]">
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

                <!-- Dokumen -->
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

                        {{-- Pratinjau PDF langsung di halaman --}}
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

                {{-- INFORMASI / SECTION DOKUMEN PKS (Hanya muncul jika status sudah selesai) --}}
                @if ($status === 'selesai')
                    <div class="p-6 sm:p-8 border-b border-[#e2e8f0] bg-emerald-50/40">
                        <h3 class="text-[11px] font-semibold uppercase tracking-wider text-emerald-800 mb-3">Dokumen PKS Bertanda Tangan</h3>
                        @if ($hasPks)
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 p-4 rounded-2xl bg-white border border-emerald-200">
                                <div class="flex items-center gap-3 min-w-0">
                                    <div class="w-10 h-10 rounded-xl bg-emerald-50 border border-emerald-100 text-emerald-600 flex items-center justify-center text-[10px] font-bold uppercase shrink-0">
                                        PDF
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-sm font-semibold text-[#1e293b] truncate">
                                            {{ basename($latestPks->dokumen) }}
                                        </p>
                                        <p class="text-xs text-emerald-700">Diunggah pada {{ \Carbon\Carbon::parse($latestPks->created_at)->format('d M Y, H:i') }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2">
                                    <a href="{{ Storage::url($latestPks->dokumen) }}" target="_blank" rel="noopener"
                                        class="inline-flex items-center px-3.5 py-2 rounded-xl bg-white border border-[#e2e8f0] text-xs font-semibold text-[#1e293b] hover:bg-slate-50 transition">
                                        Lihat
                                    </a>
                                    <a href="{{ Storage::url($latestPks->dokumen) }}" download
                                        class="inline-flex items-center px-3.5 py-2 rounded-xl bg-emerald-600 text-xs font-semibold text-white hover:bg-emerald-500 transition">
                                        Unduh
                                    </a>
                                </div>
                            </div>
                        @else
                            <p class="text-xs text-amber-700 italic">Kerjasama berstatus selesai, namun pengguna belum mengunggah berkas PKS bertanda tangan.</p>
                        @endif
                    </div>
                @endif

                <!-- Meta -->
                <div
                    class="px-6 sm:px-8 py-4 bg-[#f8fafc]/60 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-1 text-xs text-[#64748b]">
                    <span>Dibuat: {{ optional($kerjasama->created_at)->format('d M Y, H:i') ?? '-' }}</span>
                    <span>Diperbarui: {{ optional($kerjasama->updated_at)->format('d M Y, H:i') ?? '-' }}</span>
                </div>
            </div>

        </div>

        {{-- ================================================== --}}
        {{-- MODAL TINDAK LANJUT (berisi pilihan Setujui & Tolak) --}}
        {{-- ================================================== --}}
        @if ($status === 'pending')
            <div x-show="modal" x-cloak style="display: none;"
                x-transition:enter="ease-out duration-200" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-150"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                class="fixed inset-0 z-[99999] flex items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4">

                <div @click.away="modal = false"
                    class="bg-white rounded-3xl shadow-2xl w-full max-w-md p-6 sm:p-7 space-y-5">

                    <!-- Header modal -->
                    <div class="flex items-start justify-between gap-3">
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0 border"
                                :class="action === 'aktif'
                                    ?
                                    'bg-emerald-50 text-emerald-600 border-emerald-100' :
                                    'bg-rose-50 text-rose-600 border-rose-100'">
                                <svg x-show="action === 'aktif'" class="w-5 h-5" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                <svg x-show="action === 'dibatalkan'" class="w-5 h-5" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-base font-bold text-[#1e293b]"
                                    x-text="action === 'aktif' ? 'Setujui Pengajuan' : 'Tolak Pengajuan'"></h3>
                                <p class="text-xs text-[#64748b] mt-1"
                                    x-text="action === 'aktif'
                                        ? 'Pengajuan akan diaktifkan dan kerjasama dinyatakan berjalan.'
                                        : 'Tuliskan keterangan penolakan agar dapat dilihat oleh pengaju.'">
                                </p>
                            </div>
                        </div>
                        <button type="button" @click="modal = false"
                            class="w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 flex items-center justify-center shrink-0">
                            &times;
                        </button>
                    </div>

                    <!-- Pilihan keputusan di dalam modal (Setujui / Tolak) -->
                    <div class="grid grid-cols-2 gap-1 p-1 rounded-xl bg-slate-100">
                        <button type="button" @click="action = 'aktif'"
                            class="py-2 rounded-lg text-xs font-bold transition"
                            :class="action === 'aktif' ? 'bg-white text-emerald-700 shadow-sm' : 'text-[#64748b]'">
                            Setujui
                        </button>
                        <button type="button" @click="action = 'dibatalkan'"
                            class="py-2 rounded-lg text-xs font-bold transition"
                            :class="action === 'dibatalkan' ? 'bg-white text-rose-700 shadow-sm' : 'text-[#64748b]'">
                            Tolak
                        </button>
                    </div>

                    <!-- Form tunggal -->
                    <form action="{{ route('admin.kerjasama.status', $kerjasama->id) }}" method="POST"
                        class="space-y-4"
                        @submit="if (submitting) { $event.preventDefault(); return; } submitting = true;">
                        @csrf
                        @method('PATCH')

                        <input type="hidden" name="status" :value="action">

                        <!-- Keterangan: hanya saat Tolak/Dibatalkan -->
                        <div x-show="action === 'dibatalkan'" class="space-y-1.5">
                            <label for="keterangan"
                                class="block text-xs font-semibold text-[#1e293b] uppercase tracking-wider">
                                Keterangan Penolakan <span class="text-rose-500">*</span>
                            </label>
                            <textarea id="keterangan" name="keterangan" rows="4" minlength="10" maxlength="1000"
                                :required="action === 'dibatalkan'" :disabled="action !== 'dibatalkan'"
                                placeholder="Contoh: Dokumen belum lengkap, mohon lampirkan MoU yang sudah ditandatangani..."
                                class="w-full px-4 py-2.5 bg-[#f8fafc] border rounded-xl text-sm text-[#1e293b] focus:outline-none focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500 transition {{ $errors->has('keterangan') ? 'border-rose-400' : 'border-[#e2e8f0]' }}">{{ old('keterangan') }}</textarea>
                            @error('keterangan')
                                <p class="text-xs text-rose-600 font-medium">{{ $message }}</p>
                            @enderror
                            <p class="text-[11px] text-[#64748b]">Minimal 10 karakter.</p>
                        </div>

                        <!-- Konfirmasi saat Setujui -->
                        <div x-show="action === 'aktif'"
                            class="p-3.5 rounded-xl bg-emerald-50 border border-emerald-100 text-xs text-emerald-800 leading-relaxed">
                            Anda akan menyetujui kerjasama <span class="font-bold">{{ $kerjasama->judul }}</span>
                            dengan mitra <span class="font-bold">{{ $kerjasama->mitra }}</span>.
                        </div>

                        <div class="flex items-center justify-end gap-2 pt-1">
                            <button type="button" @click="modal = false"
                                class="px-4 py-2.5 rounded-xl border border-[#e2e8f0] bg-white text-[#64748b] hover:bg-slate-50 text-sm font-semibold transition">
                                Batal
                            </button>
                            <button type="submit" :disabled="submitting"
                                class="px-5 py-2.5 rounded-xl text-white text-sm font-semibold disabled:opacity-60 disabled:cursor-not-allowed transition"
                                :class="action === 'aktif' ? 'bg-emerald-600 hover:bg-emerald-500' :
                                    'bg-rose-600 hover:bg-rose-500'">
                                <span
                                    x-text="submitting ? 'Memproses...' : (action === 'aktif' ? 'Ya, Setujui' : 'Tolak Pengajuan')"></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @endif
    </div>
@endsection