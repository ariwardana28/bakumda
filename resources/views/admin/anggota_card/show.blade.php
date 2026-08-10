@php
    // 1. Ambil relasi status dengan aman
    $statusRelation = $anggotaCard->statuses ?? null;

    // 2. Ambil record status terakhir
    if ($statusRelation instanceof \Illuminate\Support\Collection) {
        $latestStatusObj = $statusRelation->last();
    } elseif (is_object($statusRelation)) {
        // Jika relasinya hasOne / belongsTo
        $latestStatusObj = $statusRelation;
    } else {
        $latestStatusObj = null;
    }

    // 3. Ambil string status & keterangan (dengan fallback ke 'proses')
    $rawStatus = $latestStatusObj->status ?? 'proses';
    $status = strtolower($rawStatus);
    $statusKeterangan = $latestStatusObj->keterangan ?? '';

    // Ambil data berlaku terakhir
    $latestBerlaku = $anggotaCard->latestBerlaku;

@endphp

@extends('layouts.admin')

@section('title', 'Detail Kartu Anggota')

@section('content')

    {{-- ========================================================================= --}}
    {{-- KONDISI 1: STATUS PROSES / PENDING / UNKNOWN                             --}}
    {{-- ========================================================================= --}}
    @if (in_array($status, ['proses', 'pending', '']))



        <div class="container mx-auto px-4 py-8 max-w-7xl" x-data="{ showModal: false, showPakta: false, paktaUrl: '' }">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <!-- KOLOM KIRI: Detail Anggota -->
                <div class="lg:col-span-2">
                    <div
                        class="bg-white dark:bg-gray-800/90 backdrop-blur-xl shadow-sm hover:shadow-md transition-all duration-300 rounded-2xl overflow-hidden border border-gray-100 dark:border-gray-700/60">

                        <!-- Header Card -->
                        <div
                            class="px-6 py-5 bg-gradient-to-r from-gray-50/50 to-white dark:from-gray-800/50 dark:to-gray-800 border-b border-gray-100 dark:border-gray-700/60 flex justify-between items-center">
                            <div>
                                <h3 class="text-lg font-bold text-gray-800 dark:text-white tracking-tight">
                                    Detail Informasi Anggota
                                </h3>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                    Ringkasan biodata diri & dokumen anggota.
                                </p>
                            </div>
                            <a href="{{ route('admin.anggota.index') }}"
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold text-indigo-600 bg-indigo-50 hover:bg-indigo-100 dark:bg-indigo-950/50 dark:text-indigo-400 dark:hover:bg-indigo-900/50 transition-all duration-200">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                </svg>
                                Kembali
                            </a>
                        </div>

                        <!-- Body Card (Grid Data) -->
                        <div class="p-6 md:p-8">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">

                                <!-- Nama Lengkap -->
                                <div
                                    class="bg-gray-50/70 dark:bg-gray-700/20 p-4 rounded-xl border border-gray-100/80 dark:border-gray-700/30">
                                    <span
                                        class="block text-[11px] font-semibold text-gray-400 uppercase tracking-wider mb-1">Nama
                                        Lengkap</span>
                                    <span
                                        class="font-bold text-gray-800 dark:text-gray-100">{{ $anggotaCard->Anggota->nama ?? '-' }}</span>
                                </div>

                                <!-- No. KTP -->
                                <div
                                    class="bg-gray-50/70 dark:bg-gray-700/20 p-4 rounded-xl border border-gray-100/80 dark:border-gray-700/30">
                                    <span
                                        class="block text-[11px] font-semibold text-gray-400 uppercase tracking-wider mb-1">No.
                                        KTP</span>
                                    <span
                                        class="font-semibold text-gray-800 dark:text-gray-100 tracking-wide">{{ $anggotaCard->Anggota->no_ktp ?? '-' }}</span>
                                </div>

                                <!-- Email -->
                                <div
                                    class="bg-gray-50/70 dark:bg-gray-700/20 p-4 rounded-xl border border-gray-100/80 dark:border-gray-700/30">
                                    <span
                                        class="block text-[11px] font-semibold text-gray-400 uppercase tracking-wider mb-1">Email</span>
                                    <span
                                        class="font-medium text-gray-800 dark:text-gray-100 break-all">{{ $anggotaCard->Anggota->email ?? '-' }}</span>
                                </div>

                                <!-- No. HP -->
                                <div
                                    class="bg-gray-50/70 dark:bg-gray-700/20 p-4 rounded-xl border border-gray-100/80 dark:border-gray-700/30">
                                    <span
                                        class="block text-[11px] font-semibold text-gray-400 uppercase tracking-wider mb-1">No.
                                        HP</span>
                                    <span
                                        class="font-medium text-gray-800 dark:text-gray-100">{{ $anggotaCard->Anggota->no_hp ?? '-' }}</span>
                                </div>

                                <!-- Jenis Kelamin -->
                                <div
                                    class="bg-gray-50/70 dark:bg-gray-700/20 p-4 rounded-xl border border-gray-100/80 dark:border-gray-700/30">
                                    <span
                                        class="block text-[11px] font-semibold text-gray-400 uppercase tracking-wider mb-1">Jenis
                                        Kelamin</span>
                                    <span
                                        class="font-medium text-gray-800 dark:text-gray-100 capitalize">{{ $anggotaCard->Anggota->jenis_kelamin ?? '-' }}</span>
                                </div>

                                <!-- Tempat, Tanggal Lahir -->
                                <div
                                    class="bg-gray-50/70 dark:bg-gray-700/20 p-4 rounded-xl border border-gray-100/80 dark:border-gray-700/30">
                                    <span
                                        class="block text-[11px] font-semibold text-gray-400 uppercase tracking-wider mb-1">Tempat,
                                        Tanggal Lahir</span>
                                    <span class="font-medium text-gray-800 dark:text-gray-100">
                                        {{ $anggotaCard->Anggota->tempat_lahir ?? '-' }},
                                        {{ isset($anggotaCard->Anggota->tanggal_lahir) ? \Carbon\Carbon::parse($anggotaCard->Anggota->tanggal_lahir)->translatedFormat('d F Y') : '-' }}
                                    </span>
                                </div>

                                <!-- Agama -->
                                <div
                                    class="bg-gray-50/70 dark:bg-gray-700/20 p-4 rounded-xl border border-gray-100/80 dark:border-gray-700/30">
                                    <span
                                        class="block text-[11px] font-semibold text-gray-400 uppercase tracking-wider mb-1">Agama</span>
                                    <span
                                        class="font-medium text-gray-800 dark:text-gray-100 capitalize">{{ $anggotaCard->Anggota->agama ?? '-' }}</span>
                                </div>

                                <!-- Status Perkawinan -->
                                <div
                                    class="bg-gray-50/70 dark:bg-gray-700/20 p-4 rounded-xl border border-gray-100/80 dark:border-gray-700/30">
                                    <span
                                        class="block text-[11px] font-semibold text-gray-400 uppercase tracking-wider mb-1">Status
                                        Perkawinan</span>
                                    <span
                                        class="font-medium text-gray-800 dark:text-gray-100 capitalize">{{ $anggotaCard->Anggota->status_perkawinan ?? '-' }}</span>
                                </div>

                                <!-- Pekerjaan -->
                                <div
                                    class="bg-gray-50/70 dark:bg-gray-700/20 p-4 rounded-xl border border-gray-100/80 dark:border-gray-700/30">
                                    <span
                                        class="block text-[11px] font-semibold text-gray-400 uppercase tracking-wider mb-1">Pekerjaan</span>
                                    <span
                                        class="font-medium text-gray-800 dark:text-gray-100 capitalize">{{ $anggotaCard->Anggota->pekerjaan ?? '-' }}</span>
                                </div>

                                <!-- Kewarganegaraan -->
                                <div
                                    class="bg-gray-50/70 dark:bg-gray-700/20 p-4 rounded-xl border border-gray-100/80 dark:border-gray-700/30">
                                    <span
                                        class="block text-[11px] font-semibold text-gray-400 uppercase tracking-wider mb-1">Kewarganegaraan</span>
                                    <span
                                        class="font-medium text-gray-800 dark:text-gray-100 uppercase">{{ $anggotaCard->Anggota->kewarganegaraan ?? '-' }}</span>
                                </div>

                                <!-- Alamat -->
                                <div
                                    class="sm:col-span-2 bg-gray-50/70 dark:bg-gray-700/20 p-4 rounded-xl border border-gray-100/80 dark:border-gray-700/30">
                                    <span
                                        class="block text-[11px] font-semibold text-gray-400 uppercase tracking-wider mb-1">Alamat
                                        Lengkap</span>
                                    <span
                                        class="font-medium text-gray-800 dark:text-gray-100 leading-relaxed">{{ $anggotaCard->Anggota->alamat ?? '-' }}</span>
                                </div>

                                <!-- Keterangan -->
                                <div
                                    class="sm:col-span-2 bg-gray-50/70 dark:bg-gray-700/20 p-4 rounded-xl border border-gray-100/80 dark:border-gray-700/30">
                                    <span
                                        class="block text-[11px] font-semibold text-gray-400 uppercase tracking-wider mb-1">Keterangan
                                        Anggota</span>
                                    <span
                                        class="font-medium text-gray-800 dark:text-gray-100 leading-relaxed">{{ $anggotaCard->Anggota->keterangan ?? '-' }}</span>
                                </div>

                                <!-- Foto KTP -->
                                <div
                                    class="sm:col-span-1 bg-gray-50/70 dark:bg-gray-700/20 p-4 rounded-xl border border-gray-100/80 dark:border-gray-700/30">
                                    <span
                                        class="block text-[11px] font-semibold text-gray-400 uppercase tracking-wider mb-2">Foto
                                        KTP</span>
                                    @if ($anggotaCard->Anggota->foto_ktp ?? false)
                                        <a href="{{ asset('storage/' . $anggotaCard->Anggota->foto_ktp) }}" target="_blank"
                                            class="group relative block overflow-hidden rounded-xl border border-gray-200 dark:border-gray-600">
                                            <img src="{{ asset('storage/' . $anggotaCard->Anggota->foto_ktp) }}"
                                                alt="Foto KTP"
                                                class="h-28 w-full object-cover group-hover:scale-105 transition duration-300">
                                            <div
                                                class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center text-white text-xs font-semibold">
                                                Lihat KTP
                                            </div>
                                        </a>
                                    @else
                                        <span class="text-xs text-gray-400 italic">Tidak ada foto KTP</span>
                                    @endif
                                </div>

                                <!-- Pakta Integritas (Updated with Modal View) -->
                                <div
                                    class="sm:col-span-1 bg-gray-50/70 dark:bg-gray-700/20 p-4 rounded-xl border border-gray-100/80 dark:border-gray-700/30 flex flex-col justify-between">
                                    <div>
                                        <span
                                            class="block text-[11px] font-semibold text-gray-400 uppercase tracking-wider mb-2">Pakta
                                            Integritas</span>

                                        @if (($anggotaCard->Anggota->pakta_integritas ?? '') === 'approve')
                                            <div
                                                class="flex items-center gap-2 text-emerald-600 dark:text-emerald-400 mt-2">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                <span class="text-xs font-semibold">Disetujui (Approved)</span>
                                            </div>
                                            <!-- Tombol pemicu modal syarat & ketentuan yang disetujui -->
                                            <button @click="showPakta = true"
                                                class="mt-3 inline-flex items-center justify-center gap-1.5 w-full py-2 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-300 rounded-lg text-xs font-semibold transition duration-200">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                    </path>
                                                </svg>
                                                Lihat Pakta Integritas
                                            </button>
                                        @elseif (!empty($anggotaCard->Anggota->pakta_integritas))
                                            <div class="flex items-center gap-2 text-indigo-600 dark:text-indigo-400 mt-2">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                    </path>
                                                </svg>
                                                <span class="text-xs font-semibold">Dokumen Tersedia</span>
                                            </div>
                                            <a href="{{ asset('storage/' . $anggotaCard->Anggota->pakta_integritas) }}"
                                                target="_blank"
                                                class="mt-3 inline-flex items-center justify-center gap-1.5 w-full py-2 bg-indigo-50 hover:bg-indigo-100 text-indigo-600 dark:bg-indigo-950/40 dark:text-indigo-300 rounded-lg text-xs font-semibold transition duration-200">
                                                Buka Dokumen
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14">
                                                    </path>
                                                </svg>
                                            </a>
                                        @else
                                            <span class="text-xs text-gray-400 italic">Belum disetujui</span>
                                        @endif
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <!-- KOLOM KANAN: Foto Profil & Verifikasi Status -->
                <div class="lg:col-span-1 space-y-6">

                    <!-- Card Foto Profil -->
                    <div
                        class="bg-white dark:bg-gray-800/90 backdrop-blur-xl shadow-sm rounded-2xl p-6 border border-gray-100 dark:border-gray-700/60 flex flex-col items-center text-center">
                        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">
                            Foto Profil Anggota
                        </h3>

                        <div
                            class="w-28 h-28 rounded-2xl bg-gray-50 dark:bg-gray-700/50 border-2 border-indigo-100 dark:border-gray-600 flex items-center justify-center overflow-hidden shadow-sm hover:shadow-md transition duration-300 mb-3">
                            @if ($anggotaCard->Anggota->foto ?? false)
                                <img src="{{ asset('storage/' . $anggotaCard->Anggota->foto) }}"
                                    alt="Foto {{ $anggotaCard->Anggota->nama }}" class="w-full h-full object-cover">
                            @else
                                <div class="flex flex-col items-center justify-center text-gray-400">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                            @endif
                        </div>

                        <h4 class="font-bold text-gray-800 dark:text-gray-100 text-sm">
                            {{ $anggotaCard->Anggota->nama ?? 'Tanpa Nama' }}
                        </h4>
                        <p class="text-xs text-gray-400 mt-0.5">
                            {{ $anggotaCard->Anggota->pekerjaan ?? 'Anggota' }}
                        </p>
                    </div>

                    <!-- Card Aksi Verifikasi -->
                    <div
                        class="bg-white dark:bg-gray-800/90 backdrop-blur-xl shadow-sm rounded-2xl p-6 border border-gray-100 dark:border-gray-700/60">
                        <h3 class="text-sm font-bold text-gray-800 dark:text-white mb-3">Verifikasi Status</h3>

                        <div
                            class="p-3 bg-gray-50 dark:bg-gray-700/30 rounded-xl border border-gray-100 dark:border-gray-700/40 flex items-center justify-between mb-5">
                            <span class="text-xs font-semibold text-gray-500 dark:text-gray-400">Status Saat Ini</span>

                            @php
                                $statusClass = match (strtolower($rawStatus ?? '')) {
                                    'approved',
                                    'diterima'
                                        => 'bg-emerald-50 text-emerald-700 border-emerald-200 dark:bg-emerald-950/50 dark:text-emerald-400 dark:border-emerald-800',
                                    'rejected',
                                    'ditolak'
                                        => 'bg-rose-50 text-rose-700 border-rose-200 dark:bg-rose-950/50 dark:text-rose-400 dark:border-rose-800',
                                    default
                                        => 'bg-amber-50 text-amber-700 border-amber-200 dark:bg-amber-950/50 dark:text-amber-400 dark:border-amber-800',
                                };
                            @endphp

                            <span
                                class="font-bold uppercase px-2.5 py-1 rounded-lg text-[11px] border {{ $statusClass }}">
                                {{ $rawStatus }}
                            </span>
                        </div>

                        <button @click="showModal = true"
                            class="w-full py-2.5 px-4 bg-indigo-600 hover:bg-indigo-700 active:scale-[0.98] text-white text-xs font-semibold rounded-xl shadow-md shadow-indigo-200 dark:shadow-none focus:outline-none transition duration-200 flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Verifikasi Pengajuan
                        </button>
                    </div>
                </div>

            </div>

            <!-- MODAL VIEW: ISI PAKTA INTEGRITAS YANG DISETUJUI -->
            <div x-show="showPakta" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95" class="fixed inset-0 z-50 overflow-y-auto"
                style="display: none;">

                <div class="fixed inset-0 bg-black/50 backdrop-blur-sm transition-opacity" @click="showPakta = false">
                </div>

                <div class="flex items-center justify-center min-h-screen p-4">
                    <div
                        class="relative bg-white dark:bg-gray-900 rounded-2xl max-w-lg w-full p-6 shadow-2xl z-10 border border-gray-100 dark:border-gray-800 space-y-4">

                        <div class="flex items-center justify-between pb-3 border-b border-gray-100 dark:border-gray-800">
                            <h3
                                class="font-extrabold text-sm text-gray-900 dark:text-white uppercase tracking-wider flex items-center gap-2">
                                <i class="fa-solid fa-file-shield text-indigo-500"></i> Pakta Integritas (Telah Disetujui)
                            </h3>
                            <button @click="showPakta = false"
                                class="text-gray-400 hover:text-gray-600 dark:hover:text-white">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>

                        <div class="space-y-3">
                            <div
                                class="p-3 bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-900 text-emerald-800 dark:text-emerald-300 text-xs rounded-xl flex items-center gap-2">
                                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Dokumen ini telah dibaca dan disetujui secara elektronik oleh
                                    <strong>{{ $anggotaCard->Anggota->nama ?? 'Anggota' }}</strong> pada saat
                                    pendaftaran.</span>
                            </div>

                            <div
                                class="h-48 overflow-y-auto p-3.5 text-xs text-gray-600 dark:text-gray-300 bg-gray-50 dark:bg-gray-800/60 rounded-xl border border-gray-200 dark:border-gray-700 space-y-2 leading-relaxed">
                                <p class="font-semibold text-gray-900 dark:text-white">Dengan mengajukan permohonan
                                    keanggotaan BAKUMDA, Anda menyatakan dan menyetujui hal-hal berikut:</p>
                                <p>1. Seluruh data identitas dan berkas dokumen yang dilampirkan adalah benar, sah, dan
                                    dapat dipertanggungjawabkan secara hukum.</p>
                                <p>2. Bersedia mematuhi Anggaran Dasar, Anggaran Rumah Tangga (AD/ART), serta seluruh
                                    peraturan yang berlaku di lingkungan Badan Advokasi & Konsultasi Hukum Daerah (BAKUMDA).
                                </p>
                                <p>3. Menjunjung tinggi kode etik profesi, integritas, serta menjaga nama baik organisasi
                                    dalam menjalankan fungsi advokasi dan pengabdian masyarakat.</p>
                                <p>4. Pihak BAKUMDA berhak menolak atau mencabut keanggotaan apabila ditemukan pelanggaran
                                    terhadap ketentuan yang berlaku.</p>
                            </div>
                        </div>

                        <div class="flex items-center justify-end pt-2 border-t border-gray-100 dark:border-gray-800">
                            <button type="button" @click="showPakta = false"
                                class="px-5 py-2 rounded-xl bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 font-semibold text-xs hover:bg-gray-200 transition">
                                Tutup
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- MODAL VERIFIKASI MODERN -->
            <div x-show="showModal" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95" class="fixed inset-0 z-50 overflow-y-auto"
                style="display: none;">

                <div class="fixed inset-0 bg-black/40 backdrop-blur-sm transition-opacity" @click="showModal = false">
                </div>

                <div class="flex items-center justify-center min-h-screen p-4">
                    <div
                        class="relative bg-white dark:bg-gray-800 rounded-2xl max-w-md w-full p-6 shadow-2xl z-10 border border-gray-100 dark:border-gray-700">

                        <div class="flex justify-between items-center mb-5">
                            <h3 class="text-base font-bold text-gray-900 dark:text-white">
                                Verifikasi Status Pengajuan
                            </h3>
                            <button @click="showModal = false"
                                class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>

                        <form action="{{ route('admin.anggota-card.status', $anggotaCard->id) }}" method="POST">
                            @csrf
                            <div class="space-y-4">
                                <div>
                                    <label
                                        class="block text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider mb-1.5">Pilih
                                        Status</label>
                                    <select name="status" required
                                        class="w-full rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-900 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                                        <option value="approved">Diterima (Approved)</option>
                                        <option value="rejected">Ditolak (Rejected)</option>
                                    </select>
                                </div>

                                <div>
                                    <label
                                        class="block text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider mb-1.5">Keterangan
                                        / Alasan</label>
                                    <textarea name="keterangan" rows="3" placeholder="Masukkan keterangan tambahan jika ditolak atau disetujui..."
                                        class="w-full rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-900 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition resize-none">{{ old('keterangan', $statusKeterangan ?? '') }}</textarea>
                                </div>
                            </div>

                            <div class="flex justify-end gap-3 mt-6">
                                <button type="button" @click="showModal = false"
                                    class="px-5 py-2.5 text-xs font-semibold text-gray-600 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 rounded-xl hover:bg-gray-200 dark:hover:bg-gray-600 transition duration-200">
                                    Batal
                                </button>
                                <button type="submit"
                                    class="px-5 py-2.5 text-xs font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl shadow-md shadow-indigo-200 dark:shadow-none transition duration-200">
                                    Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- ========================================================================= --}}
        {{-- KONDISI 1.5: STATUS MENUNGGU PEMBAYARAN / PEMBAYARAN DIPROSES          --}}
        {{-- ========================================================================= --}}
    @elseif(in_array($status, ['menunggu pembayaran', 'pembayaran diproses']))
        <div class="container mx-auto px-4 py-8 max-w-7xl" x-data="{ showModal: false, paymentProofUrl: '' }">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <!-- KOLOM KIRI: Detail Anggota -->
                <div class="lg:col-span-2">
                    <div
                        class="bg-white dark:bg-gray-800/90 backdrop-blur-xl shadow-sm hover:shadow-md transition-all duration-300 rounded-2xl overflow-hidden border border-gray-100 dark:border-gray-700/60">

                        <!-- Header Card -->
                        <div
                            class="px-6 py-5 bg-gradient-to-r from-gray-50/50 to-white dark:from-gray-800/50 dark:to-gray-800 border-b border-gray-100 dark:border-gray-700/60 flex justify-between items-center">
                            <div>
                                <h3 class="text-lg font-bold text-gray-800 dark:text-white tracking-tight">
                                    Detail Informasi Anggota
                                </h3>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                    Ringkasan biodata diri & dokumen anggota.
                                </p>
                            </div>
                            <a href="{{ route('admin.anggota.index') }}"
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold text-indigo-600 bg-indigo-50 hover:bg-indigo-100 dark:bg-indigo-950/50 dark:text-indigo-400 dark:hover:bg-indigo-900/50 transition-all duration-200">
                                <i class="fa-solid fa-arrow-left"></i>
                                Kembali
                            </a>
                        </div>

                        <!-- Body Card (Grid Data) -->
                        <div class="p-6 md:p-8">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                                <!-- Nama Lengkap -->
                                <div
                                    class="bg-gray-50/70 dark:bg-gray-700/20 p-4 rounded-xl border border-gray-100/80 dark:border-gray-700/30">
                                    <span
                                        class="block text-[11px] font-semibold text-gray-400 uppercase tracking-wider mb-1">Nama
                                        Lengkap</span>
                                    <span
                                        class="font-bold text-gray-800 dark:text-gray-100">{{ $anggotaCard->Anggota->nama ?? '-' }}</span>
                                </div>

                                <!-- No. KTP -->
                                <div
                                    class="bg-gray-50/70 dark:bg-gray-700/20 p-4 rounded-xl border border-gray-100/80 dark:border-gray-700/30">
                                    <span
                                        class="block text-[11px] font-semibold text-gray-400 uppercase tracking-wider mb-1">No.
                                        KTP</span>
                                    <span
                                        class="font-semibold text-gray-800 dark:text-gray-100 tracking-wide">{{ $anggotaCard->Anggota->no_ktp ?? '-' }}</span>
                                </div>

                                <!-- Email -->
                                <div
                                    class="bg-gray-50/70 dark:bg-gray-700/20 p-4 rounded-xl border border-gray-100/80 dark:border-gray-700/30">
                                    <span
                                        class="block text-[11px] font-semibold text-gray-400 uppercase tracking-wider mb-1">Email</span>
                                    <span
                                        class="font-medium text-gray-800 dark:text-gray-100 break-all">{{ $anggotaCard->Anggota->email ?? '-' }}</span>
                                </div>

                                <!-- No. HP -->
                                <div
                                    class="bg-gray-50/70 dark:bg-gray-700/20 p-4 rounded-xl border border-gray-100/80 dark:border-gray-700/30">
                                    <span
                                        class="block text-[11px] font-semibold text-gray-400 uppercase tracking-wider mb-1">No.
                                        HP</span>
                                    <span
                                        class="font-medium text-gray-800 dark:text-gray-100">{{ $anggotaCard->Anggota->no_hp ?? '-' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- KOLOM KANAN: Verifikasi Pembayaran -->
                <div class="lg:col-span-1 space-y-6">

                    <!-- Card Aksi Verifikasi -->
                    <div
                        class="bg-white dark:bg-gray-800/90 backdrop-blur-xl shadow-sm rounded-2xl p-6 border border-gray-100 dark:border-gray-700/60">
                        <h3 class="text-sm font-bold text-gray-800 dark:text-white mb-3">Verifikasi Pembayaran</h3>

                        <div
                            class="p-3 bg-gray-50 dark:bg-gray-700/30 rounded-xl border border-gray-100 dark:border-gray-700/40 flex items-center justify-between mb-5">
                            <span class="text-xs font-semibold text-gray-500 dark:text-gray-400">Status Saat Ini</span>

                            @php
                                $statusClass = match ($status) {
                                    'pembayaran diproses'
                                        => 'bg-indigo-50 text-indigo-700 border-indigo-200 dark:bg-indigo-950/50 dark:text-indigo-400 dark:border-indigo-800',
                                    default
                                        => 'bg-cyan-50 text-cyan-700 border-cyan-200 dark:bg-cyan-950/50 dark:text-cyan-400 dark:border-cyan-800',
                                };
                            @endphp

                            <span
                                class="font-bold uppercase px-2.5 py-1 rounded-lg text-[11px] border {{ $statusClass }}">
                                {{ $rawStatus }}
                            </span>
                        </div>

                        @if ($status === 'pembayaran diproses')
                            @php
                                // Ambil data pembayaran terakhir yang statusnya 'diproses' untuk kartu ini.
                                $pembayaran = \App\Models\AnggotaPembayaran::where('anggota_card_id', $anggotaCard->id)
                                    ->where('status', 'diproses')
                                    ->latest()
                                    ->first();
                                $path = $pembayaran ? $pembayaran->bukti_pembayaran : null;
                            @endphp

                            @if ($path)
                                <div class="mb-5">
                                    <button type="button"
                                        @click="showModal = true; paymentProofUrl = '{{ asset('storage/' . $path) }}'"
                                        class="w-full group relative block overflow-hidden rounded-xl border border-gray-200 dark:border-gray-600">
                                        <img src="{{ asset('storage/' . $path) }}" alt="Bukti Pembayaran"
                                            class="h-40 w-full object-cover group-hover:scale-105 transition duration-300">
                                        <div
                                            class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center text-white text-xs font-semibold">
                                            <i class="fa-solid fa-magnifying-glass-plus mr-2"></i> Lihat Bukti
                                        </div>
                                    </button>
                                </div>

                                <form action="{{ route('admin.anggota-card.status', $anggotaCard->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="status" value="pembayaran_diterima">
                                    <div class="mb-4">
                                        <label
                                            class="block text-xs font-semibold text-gray-600 dark:text-gray-400 mb-1.5">Catatan
                                            (Opsional)</label>
                                        <textarea name="keterangan" rows="2" placeholder="Contoh: Pembayaran diterima, kartu akan segera diterbitkan."
                                            class="w-full rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-900 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition resize-none"></textarea>
                                    </div>
                                    <button type="submit"
                                        class="w-full py-2.5 px-4 bg-emerald-600 hover:bg-emerald-700 active:scale-[0.98] text-white text-xs font-semibold rounded-xl shadow-md shadow-emerald-200 dark:shadow-none focus:outline-none transition duration-200 flex items-center justify-center gap-2">
                                        <i class="fa-solid fa-circle-check"></i>
                                        Konfirmasi Pembayaran & Terbitkan Kartu
                                    </button>
                                </form>
                            @else
                                <div
                                    class="p-4 text-center text-xs text-rose-700 bg-rose-50 border border-rose-200 rounded-xl">
                                    Tidak dapat menemukan path bukti pembayaran.
                                </div>
                            @endif
                        @else
                            <div
                                class="p-4 text-center text-xs text-cyan-700 bg-cyan-50 border border-cyan-200 rounded-xl">
                                Menunggu anggota untuk mengunggah bukti pembayaran.
                            </div>
                        @endif
                    </div>
                </div>

            </div>

            <!-- MODAL LIHAT BUKTI PEMBAYARAN -->
            <div x-show="showModal" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95" class="fixed inset-0 z-50 overflow-y-auto"
                style="display: none;">

                <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity" @click="showModal = false">
                </div>

                <div class="flex items-center justify-center min-h-screen p-4">
                    <div
                        class="relative bg-white dark:bg-gray-800 rounded-2xl max-w-lg w-full p-4 shadow-2xl z-10 border border-gray-100 dark:border-gray-700">

                        <div class="flex justify-between items-center mb-3 px-2">
                            <h3 class="text-sm font-bold text-gray-900 dark:text-white">
                                Bukti Pembayaran
                            </h3>
                            <button @click="showModal = false"
                                class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 dark:bg-gray-700">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </div>

                        <div class="p-2 rounded-lg bg-gray-100 dark:bg-gray-900">
                            <img :src="paymentProofUrl" alt="Bukti Pembayaran"
                                class="max-w-full max-h-[80vh] rounded-md mx-auto">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ========================================================================= --}}
        {{-- KONDISI 2: STATUS APPROVE / APPROVED                                     --}}
        {{-- ========================================================================= --}}
    @elseif(in_array($status, ['approve', 'approved']))
        <div class="space-y-6">

            @if (session('success'))
                <div
                    class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 dark:bg-emerald-900/30 dark:border-emerald-800 dark:text-emerald-400 text-xs font-medium">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <!-- KIRI: KARTU & FOTO ANGGOTA -->
                <div class="lg:col-span-1">
                    <div
                        class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm text-center space-y-4">
                        <h3 class="text-xs uppercase tracking-wider font-semibold text-gray-400">Kartu Anggota</h3>

                        <!-- Pas Foto -->
                        <div
                            class="w-32 h-40 mx-auto rounded-xl overflow-hidden bg-gray-100 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 shadow-sm">
                            @if ($anggotaCard->anggota->foto ?? false)
                                <img src="{{ asset('storage/' . $anggotaCard->anggota->foto) }}"
                                    class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center text-gray-400">
                                    <i class="fa-solid fa-user text-3xl mb-1"></i>
                                    <span class="text-[10px]">No Photo</span>
                                </div>
                            @endif
                        </div>

                        <div>
                            <h2 class="text-base font-bold text-gray-900 dark:text-gray-100">
                                {{ $anggotaCard->anggota->nama ?? '-' }}
                            </h2>
                            <p class="text-xs text-gray-500 mt-0.5">
                                No. ID: <span
                                    class="font-mono font-semibold text-brand-600">{{ $anggotaCard->card_id ?? 'Belum Diterbitkan' }}</span>
                            </p>
                            @if (optional($latestBerlaku)->jabatan)
                                <p class="text-xs font-medium text-gray-700 dark:text-gray-300 mt-1">
                                    Jabatan: <span class="text-brand-500">{{ $latestBerlaku->jabatan }}</span>
                                </p>
                            @endif
                        </div>

                        @if ($anggotaCard->qr_code)
                            <div class="pt-4 border-t border-gray-100 dark:border-gray-700 flex flex-col items-center">
                                <img src="{{ asset('storage/' . $anggotaCard->qr_code) }}"
                                    class="w-24 h-24 border p-1.5 rounded-lg bg-white shadow-sm">
                                <span class="text-[10px] text-gray-400 mt-1">Scan QR Code Verifikasi</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- KANAN: FORM INPUT DATA PENERBITAN KARTU -->
                <div class="lg:col-span-2 space-y-6">
                    <div
                        class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm space-y-4">
                        <div class="flex items-center justify-between border-b border-gray-100 dark:border-gray-700 pb-3">
                            <h3 class="text-sm font-bold text-gray-900 dark:text-gray-100 flex items-center gap-2">
                                <i class="fa-solid fa-id-card-clip text-brand-500"></i>
                                <span>Input Data Penerbitan Kartu</span>
                            </h3>
                            <span
                                class="px-2.5 py-1 text-[10px] font-semibold bg-emerald-50 text-emerald-600 rounded-full border border-emerald-200">
                                Status: Approved
                            </span>
                        </div>

                        <form action="{{ route('admin.anggota-card.simpan-kartu', $anggotaCard->id) }}" method="POST"
                            class="space-y-4">
                            @csrf

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Input Jabatan -->
                                <div class="md:col-span-2">
                                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Jabatan
                                        Anggota</label> {{-- Default jabatan menjadi 'Anggota' --}}
                                    <input type="text" name="jabatan"
                                        value="{{ old('jabatan', optional($latestBerlaku)->jabatan ?? 'Anggota') }}"
                                        required placeholder="Contoh: Advokat / Paralegal / Anggota"
                                        class="w-full text-xs rounded-xl bg-gray-50 dark:bg-gray-700/50 text-gray-800 dark:text-gray-100 border border-gray-200 dark:border-gray-600 focus:ring-2 focus:ring-brand-500 outline-none px-3 py-2">
                                </div>

                                <!-- Input Tanggal Diterbitkan -->
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Tanggal
                                        Diterbitkan</label>
                                    <input type="date" name="diterbitkan"
                                        value="{{ old('diterbitkan', optional(optional($latestBerlaku)->diterbitkan)->format('Y-m-d') ?? now()->format('Y-m-d')) }}"
                                        required
                                        class="w-full text-xs rounded-xl bg-gray-50 dark:bg-gray-700/50 text-gray-800 dark:text-gray-100 border border-gray-200 dark:border-gray-600 focus:ring-2 focus:ring-brand-500 outline-none px-3 py-2">
                                </div>

                                <!-- Input Masa Berakhir -->
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Berakhir
                                        Kartu</label>
                                    <input type="date" name="berlaku"
                                        value="{{ old('berlaku', optional(optional($latestBerlaku)->berlaku)->format('Y-m-d') ?? now()->addYears(5)->format('Y-m-d')) }}"
                                        required
                                        class="w-full text-xs rounded-xl bg-gray-50 dark:bg-gray-700/50 text-gray-800 dark:text-gray-100 border border-gray-200 dark:border-gray-600 focus:ring-2 focus:ring-brand-500 outline-none px-3 py-2">
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Catatan
                                    Tambahan (Opsional)</label>
                                <textarea name="keterangan" rows="2" placeholder="Tuliskan catatan opsional..."
                                    class="w-full text-xs rounded-xl bg-gray-50 dark:bg-gray-700/50 text-gray-800 dark:text-gray-100 border border-gray-200 dark:border-gray-600 focus:ring-2 focus:ring-brand-500 outline-none px-3 py-2">{{ old('keterangan', optional($latestBerlaku)->keterangan) }}</textarea>
                            </div>

                            <div class="flex justify-end pt-2">
                                <button type="submit"
                                    class="px-5 py-2.5 bg-brand-600 hover:bg-brand-700 text-white text-xs font-semibold rounded-xl transition shadow-sm flex items-center gap-2">
                                    <i class="fa-solid fa-qrcode"></i>
                                    <span>Terbitkan Kartu & QR Code</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>


        {{-- ========================================================================= --}}
        {{-- KONDISI 3: STATUS ACTIVE / DITERBITKAN                                   --}}
        {{-- ========================================================================= --}}
    @elseif(in_array($status, ['aktif', 'active', 'diterbitkan']))
        <div class="space-y-6" x-data="{ zoomCard: false }">

            @if (session('success'))
                <div
                    class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 dark:bg-emerald-900/30 dark:border-emerald-800 dark:text-emerald-400 text-xs font-medium">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6" x-data="{ isFlipped: false }">

                <!-- KIRI: PREVIEW KARTU FISIK & AKSI -->
                <div class="lg:col-span-1">
                    <div
                        class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm text-center space-y-4">
                        <h3 class="text-xs uppercase tracking-wider font-semibold text-gray-400">Preview Kartu Anggota</h3>

                        <!-- CONTAINER KARTU FISIK -->
                        <style>
                            .perspective-1000 {
                                perspective: 1000px;
                            }

                            .transform-style-3d {
                                transform-style: preserve-3d;
                            }

                            .backface-hidden {
                                backface-visibility: hidden;
                                -webkit-backface-visibility: hidden;
                            }

                            .rotate-y-180 {
                                transform: rotateY(180deg);
                            }
                        </style>
                        <div class="relative w-[280px] h-[480px] mx-auto perspective-1000">
                            <div class="relative w-full h-full duration-700 transform-style-3d transition-transform"
                                :class="{ 'rotate-y-180': isFlipped }">

                                <!-- SISI DEPAN KARTU -->
                                <div
                                    class="absolute inset-0 w-full h-full rounded-2xl shadow-lg border bg-white backface-hidden overflow-hidden transform-style-3d">
                                    <img src="{{ asset('background.png') }}"
                                        class="absolute inset-0 w-full h-full object-cover">
                                    <div class="relative z-10 w-full h-full">
                                        <div
                                            class="absolute top-[201px] left-[50px] w-[95px] h-[129px] overflow-hidden rounded-sm flex items-center justify-center bg-black">
                                            @if ($anggotaCard->anggota->foto ?? false)
                                                <img src="{{ asset('storage/' . $anggotaCard->anggota->foto) }}"
                                                    class="w-full h-full object-contain">
                                            @else
                                                <div class="flex flex-col items-center justify-center text-gray-300">
                                                    <i class="fa-solid fa-user text-3xl"></i>
                                                    <span class="text-[8px] mt-1">No Foto</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="absolute top-[205px] left-[152px] w-[80px] flex flex-col items-center">
                                            <div class="w-[78px] h-[78px] bg-white p-1 flex items-center justify-center">
                                                @if ($anggotaCard->qr_code)
                                                    <img src="{{ asset('storage/' . $anggotaCard->qr_code) }}"
                                                        class="w-full h-full object-contain">
                                                @else
                                                    <div class="text-[8px] text-gray-400 text-center leading-tight">
                                                        Belum<br>Terbit
                                                    </div>
                                                @endif
                                            </div>
                                            @if ($anggotaCard->card_id)
                                                <span
                                                    class="text-[8px] font-bold text-gray-900 font-sans tracking-tight mt-1 whitespace-nowrap">
                                                    NIA. {{ $anggotaCard->card_id }}
                                                </span>
                                            @endif
                                        </div>
                                        <div class="absolute top-[342px] inset-x-0 px-4 text-center">
                                            <h2
                                                class="text-[11px] font-extrabold text-gray-900 uppercase tracking-tight leading-snug">
                                                {{ $anggotaCard->anggota->nama ?? '' }}
                                            </h2>
                                            @if (!empty(optional($latestBerlaku)->jabatan))
                                                <p
                                                    class="text-[9.5px] font-bold text-gray-800 uppercase tracking-wider mt-0.5">
                                                    {{ $latestBerlaku->jabatan }}
                                                </p>
                                            @endif
                                        </div>
                                        @if (!empty(optional($latestBerlaku)->berlaku))
                                            <div class="absolute bottom-[20px] left-[18px]">
                                                <p class="text-[8px] font-bold text-gray-900 font-sans">
                                                    Berlaku s/d
                                                    {{ \Carbon\Carbon::parse($latestBerlaku->berlaku)->translatedFormat('d F Y') }}
                                                </p>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- SISI BELAKANG KARTU -->
                                <div
                                    class="absolute inset-0 w-full h-full rounded-2xl shadow-lg border bg-white backface-hidden rotate-y-180 overflow-hidden transform-style-3d">
                                    <img src="{{ asset('belakang.png') }}"
                                        class="absolute inset-0 w-full h-full object-cover">
                                </div>
                            </div>
                        </div>

                        <!-- TOMBOL UNDUH DAN PERBESAR KARTU -->
                        <div class="pt-2 flex flex-col gap-2">
                            <button type="button" @click="isFlipped = !isFlipped"
                                class="w-full px-3 py-2 text-xs font-semibold rounded-xl bg-indigo-50 text-indigo-600 hover:bg-indigo-100 border border-indigo-100 transition flex items-center justify-center gap-1.5 shadow-sm">
                                <i class="fa-solid fa-rotate transition-transform duration-500"
                                    :class="{ 'rotate-180': isFlipped }"></i>
                                <span x-text="isFlipped ? 'Lihat Sisi Depan Kartu' : 'Putar ke Sisi Belakang'"></span>
                            </button>

                            <!-- Tombol Perbesar -->
                            <div class="flex flex-col sm:flex-row gap-2 justify-center">
                                <button type="button" @click="zoomCard = true"
                                    class="px-3 py-2 text-xs font-semibold rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 transition flex items-center justify-center gap-1.5">
                                    <i class="fa-solid fa-magnifying-glass-plus"></i>
                                    <span>Perbesar Kartu</span>
                                </button>

                                <!-- Tombol Unduh Kartu -->
                                <a href="{{ route('admin.anggota-card.download', $anggotaCard->id) }}" target="_blank"
                                    class="px-3 py-2 text-xs font-semibold rounded-xl bg-brand-600 hover:bg-brand-700 text-white transition flex items-center justify-center gap-1.5 shadow-sm">
                                    <i class="fa-solid fa-download"></i>
                                    <span>Unduh Kartu</span>
                                </a>
                            </div>
                        </div>

                        <p class="text-[11px] text-gray-400 mt-1">Tampilan presisi kartu anggota fisik BAKUMDA.</p>
                    </div>
                </div>

                <!-- KANAN: INFORMASI LENGKAP KARTU -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden"
                        x-data="{ showRequestModal: false, showHistoryModal: false }">

                        <!-- CARD HEADER -->
                        <div
                            class="px-6 py-4 bg-gray-50/70 dark:bg-gray-700/40 border-b border-gray-100 dark:border-gray-700 flex flex-wrap items-center justify-between gap-3">
                            <h3 class="text-sm font-extrabold text-gray-900 dark:text-white uppercase tracking-wider">
                                Kartu Anggota
                            </h3>
                            {{-- <button type="button" @click="showRequestModal = true"
                                class="px-3.5 py-1.5 bg-amber-500 hover:bg-amber-600 text-white text-xs font-semibold rounded-xl transition flex items-center gap-1.5 shadow-sm">
                                <i class="fa-solid fa-pen-to-square"></i>
                                <span>Ubah Data Kartu</span>
                            </button> --}}
                        </div>

                        <div class="p-6 space-y-4">
                            <!-- TOMBOL & RIWAYAT MASA BERLAKU -->
                            @if ($anggotaCard->berlakuHistory->count() > 1)
                                <div
                                    class="mb-4 flex items-center justify-between bg-gray-50 dark:bg-gray-700/30 p-3 rounded-xl border border-gray-100 dark:border-gray-700">
                                    <div>
                                        <h4
                                            class="text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                            Riwayat Masa Berlaku
                                        </h4>
                                        <p class="text-[11px] text-gray-400 mt-0.5">Terdapat
                                            {{ $anggotaCard->berlakuHistory->count() }} catatan riwayat masa berlaku kartu.
                                        </p>
                                    </div>
                                    <button type="button" @click="showHistoryModal = true"
                                        class="px-3 py-1.5 text-xs font-semibold rounded-xl bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 transition flex items-center gap-1.5">
                                        <i class="fa-solid fa-clock-rotate-left"></i>
                                        <span>Lihat Riwayat</span>
                                    </button>
                                </div>

                                <!-- MODAL RIWAYAT MASA BERLAKU -->
                                <div x-show="showHistoryModal" class="fixed inset-0 z-50 overflow-y-auto"
                                    style="display: none;">
                                    <div class="fixed inset-0 bg-black/40 backdrop-blur-sm"
                                        @click="showHistoryModal = false"></div>
                                    <div class="flex items-center justify-center min-h-screen p-4">
                                        <div
                                            class="relative bg-white dark:bg-gray-800 rounded-2xl max-w-lg w-full p-6 shadow-2xl z-10 space-y-4">
                                            <div
                                                class="flex items-center justify-between border-b border-gray-100 dark:border-gray-700 pb-3">
                                                <h3
                                                    class="text-sm font-bold text-gray-900 dark:text-white flex items-center gap-2">
                                                    <i class="fa-solid fa-clock-rotate-left text-brand-600"></i>
                                                    <span>Riwayat Masa Berlaku Kartu</span>
                                                </h3>
                                                <button @click="showHistoryModal = false"
                                                    class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                                                    <i class="fa-solid fa-xmark text-lg"></i>
                                                </button>
                                            </div>

                                            <div class="space-y-2 text-xs max-h-[60vh] overflow-y-auto pr-1">
                                                @foreach ($anggotaCard->berlakuHistory->sortByDesc('id') as $history)
                                                    <div
                                                        class="p-3 rounded-xl {{ $loop->first ? 'bg-emerald-50/60 dark:bg-emerald-900/20 border-emerald-200 dark:border-emerald-800/30' : 'bg-gray-50 dark:bg-gray-700/20 border-gray-100 dark:border-gray-700/30' }} border flex items-center justify-between">
                                                        <div class="flex items-center gap-3">
                                                            <span
                                                                class="font-bold {{ $loop->first ? 'text-emerald-700 dark:text-emerald-400' : 'text-gray-600 dark:text-gray-400' }}">
                                                                {{ \Carbon\Carbon::parse($history->berlaku)->translatedFormat('d F Y') }}
                                                            </span>
                                                            @if ($history->status_kartu === 'Perpanjangan')
                                                                <span
                                                                    class="px-2 py-0.5 text-[9px] font-semibold rounded-full bg-blue-100 text-blue-700 dark:bg-blue-900/50 dark:text-blue-400">
                                                                    Perpanjangan
                                                                </span>
                                                            @elseif($loop->first)
                                                                <span
                                                                    class="px-2 py-0.5 text-[9px] font-semibold rounded-full bg-emerald-100 text-emerald-700 dark:bg-emerald-900/50 dark:text-emerald-400">
                                                                    Aktif
                                                                </span>
                                                            @endif
                                                        </div>
                                                        <span class="text-gray-400 dark:text-gray-500 text-[10px]">
                                                            Diterbitkan:
                                                            {{ \Carbon\Carbon::parse($history->diterbitkan)->translatedFormat('d M Y') }}
                                                        </span>
                                                    </div>
                                                @endforeach
                                            </div>

                                            <div class="flex justify-end pt-2">
                                                <button type="button" @click="showHistoryModal = false"
                                                    class="px-4 py-2 text-xs font-semibold bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 rounded-xl">
                                                    Tutup
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif


                            <div
                                class="flex items-center justify-between border-b border-gray-100 dark:border-gray-700 pb-3">
                                <h3 class="text-sm font-bold text-gray-900 dark:text-gray-100 flex items-center gap-2">
                                    <i class="fa-solid fa-circle-check text-emerald-500"></i>
                                    <span>Informasi Lengkap Kartu Anggota (Aktif)</span>
                                </h3>
                                <span
                                    class="px-2.5 py-1 text-[10px] font-semibold bg-emerald-50 text-emerald-600 rounded-full border border-emerald-200">
                                    Status: Aktif / Terbit
                                </span>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
                                <div class="bg-gray-50 dark:bg-gray-700/30 p-3 rounded-xl">
                                    <span class="block text-gray-400 mb-0.5">Nama Lengkap</span>
                                    <span
                                        class="font-bold text-gray-900 dark:text-white uppercase">{{ $anggotaCard->anggota->nama ?? '-' }}</span>
                                </div>

                                <div class="bg-gray-50 dark:bg-gray-700/30 p-3 rounded-xl">
                                    <span class="block text-gray-400 mb-0.5">Nomor Induk Anggota (NIA)</span>
                                    <span
                                        class="font-bold text-indigo-600 dark:text-indigo-400">{{ $anggotaCard->card_id ?? '-' }}</span>
                                </div>

                                <div class="bg-gray-50 dark:bg-gray-700/30 p-3 rounded-xl">
                                    <span class="block text-gray-400 mb-0.5">Jabatan</span>
                                    <span
                                        class="font-semibold text-gray-800 dark:text-gray-200">{{ optional($latestBerlaku)->jabatan ?? '-' }}</span>
                                </div>

                                <div class="bg-gray-50 dark:bg-gray-700/30 p-3 rounded-xl">
                                    <span class="block text-gray-400 mb-0.5">NIK / No. Identitas</span>
                                    <span
                                        class="font-semibold text-gray-800 dark:text-gray-200">{{ $anggotaCard->anggota->no_ktp ?? '-' }}</span>
                                </div>

                                <div class="bg-gray-50 dark:bg-gray-700/30 p-3 rounded-xl">
                                    <span class="block text-gray-400 mb-0.5">Tanggal Diterbitkan</span>
                                    <span class="font-semibold text-gray-800 dark:text-gray-200">
                                        {{ optional(optional($latestBerlaku)->diterbitkan)->translatedFormat('d F Y') ?? '-' }}
                                    </span>
                                </div>

                                <div class="bg-gray-50 dark:bg-gray-700/30 p-3 rounded-xl">
                                    <span class="block text-gray-400 mb-0.5">Masa Berlaku Kartu</span>
                                    <span class="font-semibold text-gray-800 dark:text-gray-200">
                                        {{ optional(optional($latestBerlaku)->berlaku)->translatedFormat('d F Y') ?? '-' }}
                                    </span>
                                </div>

                                <div class="bg-gray-50 dark:bg-gray-700/30 p-3 rounded-xl">
                                    <span class="block text-gray-400 mb-0.5">Email</span>
                                    <span
                                        class="font-semibold text-gray-800 dark:text-gray-200">{{ $anggotaCard->anggota->email ?? '-' }}</span>
                                </div>

                                <div class="bg-gray-50 dark:bg-gray-700/30 p-3 rounded-xl">
                                    <span class="block text-gray-400 mb-0.5">Nomor HP / WhatsApp</span>
                                    <span
                                        class="font-semibold text-gray-800 dark:text-gray-200">{{ $anggotaCard->anggota->no_hp ?? '-' }}</span>
                                </div>

                                <div class="md:col-span-2 bg-gray-50 dark:bg-gray-700/30 p-3 rounded-xl">
                                    <span class="block text-gray-400 mb-0.5">Alamat Lengkap</span>
                                    <span
                                        class="font-semibold text-gray-800 dark:text-gray-200">{{ $anggotaCard->anggota->alamat ?? '-' }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Konfirmasi Ubah Data oleh Admin -->
                        <div x-show="showRequestModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
                            <div class="fixed inset-0 bg-black/40 backdrop-blur-sm" @click="showRequestModal = false">
                            </div>
                            <div class="flex items-center justify-center min-h-screen p-4">
                                <div
                                    class="relative bg-white dark:bg-gray-800 rounded-2xl max-w-md w-full p-6 shadow-2xl z-10">
                                    <h3 class="text-base font-bold text-gray-900 dark:text-white mb-2">Konfirmasi Ubah Data
                                    </h3>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-4">
                                        Tindakan ini akan mengubah status kartu kembali ke "Approved" agar Anda dapat
                                        menginput ulang informasi kartu.
                                    </p>
                                    <form action="{{ route('admin.anggota-card.status', $anggotaCard->id) }}"
                                        method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="approved">
                                        <div>
                                            <label
                                                class="block text-xs font-semibold text-gray-600 dark:text-gray-400 mb-1">Alasan
                                                Perubahan (Wajib)</label>
                                            <textarea name="keterangan" rows="3" required
                                                placeholder="Contoh: Perpanjangan masa berlaku, koreksi jabatan, dll."
                                                class="w-full text-xs rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-900 focus:ring-2 focus:ring-amber-500"></textarea>
                                        </div>
                                        <div class="flex justify-end gap-3 mt-5">
                                            <button type="button" @click="showRequestModal = false"
                                                class="px-4 py-2 text-xs font-semibold bg-gray-100 dark:bg-gray-700 rounded-xl">Batal</button>
                                            <button type="submit"
                                                class="px-4 py-2 text-xs font-semibold text-white bg-amber-500 hover:bg-amber-600 rounded-xl">Lanjutkan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- PANEL PERMINTAAN PERUBAHAN DATA (JIKA ADA) -->
                    @if ($pendingEditRequest)
                        <div class="bg-amber-50 dark:bg-amber-950/40 p-6 rounded-2xl border border-amber-200 dark:border-amber-800/60 shadow-sm space-y-4"
                            x-data="{ showProcessModal: false }">
                            <div class="flex items-center justify-between">
                                <h3 class="text-sm font-bold text-amber-800 dark:text-amber-300 flex items-center gap-2">
                                    <i class="fa-solid fa-triangle-exclamation animate-pulse"></i>
                                    <span>Permintaan Perubahan Data</span>
                                </h3>
                                <span
                                    class="px-2.5 py-1 text-[10px] font-semibold bg-amber-100 text-amber-700 rounded-full border border-amber-200">
                                    Status: Pending
                                </span>
                            </div>
                            <div class="text-xs text-amber-700 dark:text-amber-400 space-y-2">
                                <p>Anggota <strong
                                        class="text-amber-800 dark:text-amber-200">{{ $anggotaCard->anggota->nama }}</strong>
                                    mengajukan permintaan untuk mengubah data pendaftarannya.</p>
                                <blockquote class="border-l-2 border-amber-400/50 pl-3 italic">
                                    "{{ $pendingEditRequest->alasan_pengajuan }}"</blockquote>
                            </div>
                            <div class="flex justify-end pt-2">
                                <button @click="showProcessModal = true"
                                    class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-xs font-semibold rounded-xl transition flex items-center gap-1.5">
                                    <i class="fa-solid fa-gears"></i>
                                    <span>Proses Permintaan</span>
                                </button>
                            </div>

                            <!-- Modal Proses Permintaan -->
                            <div x-show="showProcessModal" class="fixed inset-0 z-50 overflow-y-auto"
                                style="display: none;">
                                <div class="fixed inset-0 bg-black/40 backdrop-blur-sm" @click="showProcessModal = false">
                                </div>
                                <div class="flex items-center justify-center min-h-screen p-4">
                                    <div
                                        class="relative bg-white dark:bg-gray-800 rounded-2xl max-w-md w-full p-6 shadow-2xl z-10">
                                        <h3 class="text-base font-bold text-gray-900 dark:text-white mb-4">Proses
                                            Permintaan Perubahan Data</h3>
                                        <form
                                            action="{{ route('admin.anggota-card.process-edit-request', $anggotaCard->id) }}"
                                            method="POST">
                                            @csrf
                                            <input type="hidden" name="request_id"
                                                value="{{ $pendingEditRequest->id }}">
                                            <div class="space-y-4">
                                                <div>
                                                    <label
                                                        class="block text-xs font-semibold text-gray-600 dark:text-gray-400 mb-1">Tindakan</label>
                                                    <select name="action"
                                                        class="w-full text-xs rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-900 focus:ring-2 focus:ring-indigo-500">
                                                        <option value="approve">Setujui (Izinkan Anggota Edit Data)
                                                        </option>
                                                        <option value="reject">Tolak Permintaan</option>
                                                    </select>
                                                </div>
                                                <div>
                                                    <label
                                                        class="block text-xs font-semibold text-gray-600 dark:text-gray-400 mb-1">Catatan
                                                        untuk Anggota (Opsional)</label>
                                                    <textarea name="catatan_admin" rows="3" placeholder="Tulis catatan jika permintaan ditolak..."
                                                        class="w-full text-xs rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-900 focus:ring-2 focus:ring-indigo-500"></textarea>
                                                </div>
                                            </div>
                                            <div class="flex justify-end gap-3 mt-5">
                                                <button type="button" @click="showProcessModal = false"
                                                    class="px-4 py-2 text-xs font-semibold bg-gray-100 dark:bg-gray-700 rounded-xl">Batal</button>
                                                <button type="submit"
                                                    class="px-4 py-2 text-xs font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl">Simpan
                                                    Tindakan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

            </div>

            <!-- MODAL PERBESAR (ZOOM) KARTU ANGGOTA -->
            <div x-show="zoomCard" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
                <div class="fixed inset-0 bg-black/75 backdrop-blur-sm transition-opacity" @click="zoomCard = false">
                </div>
                <div class="flex items-center justify-center min-h-screen p-4">
                    <div
                        class="relative bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-2xl z-10 max-w-lg w-full flex flex-col items-center">
                        <div class="flex justify-between items-center w-full mb-4">
                            <h3 class="text-sm font-bold text-gray-900 dark:text-white">Detail Kartu Anggota</h3>
                            <button @click="zoomCard = false"
                                class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                                <i class="fa-solid fa-xmark text-lg"></i>
                            </button>
                        </div>

                        <!-- KARTU UKURAN DIPERBESAR (SCALE 1.35x) -->
                        <div
                            class="relative w-[280px] h-[480px] rounded-2xl overflow-hidden shadow-xl border border-gray-300 transform scale-110 sm:scale-125 my-8">
                            <img src="{{ asset('background.png') }}"
                                class="absolute inset-0 w-full h-full object-cover z-0" alt="Background ID Card">
                            <div class="relative z-10 w-full h-full">
                                <div
                                    class="absolute top-[201px] left-[50px] w-[95px] h-[129px] overflow-hidden rounded-sm flex items-center justify-center bg-black">
                                    @if ($anggotaCard->anggota->foto ?? false)
                                        <img src="{{ asset('storage/' . $anggotaCard->anggota->foto) }}"
                                            class="w-full h-full object-contain">
                                    @else
                                        <div class="flex flex-col items-center justify-center text-gray-300">
                                            <i class="fa-solid fa-user text-3xl"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="absolute top-[205px] left-[152px] w-[80px] flex flex-col items-center">
                                    <div class="w-[78px] h-[78px] bg-white p-1 flex items-center justify-center">
                                        @if ($anggotaCard->qr_code)
                                            <img src="{{ asset('storage/' . $anggotaCard->qr_code) }}"
                                                class="w-full h-full object-contain">
                                        @endif
                                    </div>
                                    @if ($anggotaCard->card_id)
                                        <span
                                            class="text-[8px] font-bold text-gray-900 font-sans tracking-tight mt-1 whitespace-nowrap">
                                            NIA. {{ $anggotaCard->card_id }}
                                        </span>
                                    @endif
                                </div>
                                <div class="absolute top-[342px] inset-x-0 px-4 text-center">
                                    <h2
                                        class="text-[11px] font-extrabold text-gray-900 uppercase tracking-tight leading-snug">
                                        {{ $anggotaCard->anggota->nama ?? '' }}
                                    </h2>
                                    @if (!empty($anggotaCard->jabatan))
                                        <p class="text-[9.5px] font-bold text-gray-800 uppercase tracking-wider mt-0.5">
                                            {{ optional($latestBerlaku)->jabatan }}
                                        </p>
                                    @endif
                                </div>
                                @if (!empty(optional($latestBerlaku)->berlaku))
                                    <div class="absolute bottom-[20px] left-[18px]">
                                        <p class="text-[8px] font-bold text-gray-900 font-sans">
                                            Berlaku s/d
                                            {{ \Carbon\Carbon::parse($latestBerlaku->berlaku)->translatedFormat('d F Y') }}
                                        </p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end w-full">
                            <button type="button" @click="zoomCard = false"
                                class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 text-xs font-semibold rounded-xl">
                                Tutup
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        {{-- ========================================================================= --}}
        {{-- KONDISI 3: STATUS DITOLAK / REJECTED                                     --}}
        {{-- ========================================================================= --}}
    @elseif(in_array($status, ['ditolak', 'rejected']))
        <div class="container mx-auto px-4 py-8 max-w-7xl" x-data="{ showModal: false }">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <!-- KOLOM KIRI: Detail Informasi Anggota & Alasan Penolakan -->
                <div class="lg:col-span-2 space-y-6">

                    <!-- Banner Peringatan Ditolak -->
                    <div
                        class="p-4 rounded-2xl bg-rose-50 dark:bg-rose-950/40 border border-rose-200 dark:border-rose-800/60 flex items-start gap-4">
                        <div
                            class="p-2.5 bg-rose-100 dark:bg-rose-900/50 text-rose-600 dark:text-rose-400 rounded-xl shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-rose-800 dark:text-rose-300">Pengajuan Anggota Ditolak</h4>
                            <p class="text-xs text-rose-600 dark:text-rose-400 mt-1">
                                Pengajuan kartu untuk anggota ini telah ditolak. Silakan periksa alasan penolakan di bawah
                                ini atau perbarui status jika diperlukan.
                            </p>
                            @if (!empty($statusKeterangan))
                                <div
                                    class="mt-3 p-3 bg-white/80 dark:bg-gray-800/80 rounded-xl border border-rose-200/60 dark:border-rose-900/40 text-xs text-gray-700 dark:text-gray-300">
                                    <span class="font-semibold text-rose-600 dark:text-rose-400">Alasan/Keterangan:</span>
                                    {{ $statusKeterangan }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Card Detail Biodata -->
                    <div
                        class="bg-white dark:bg-gray-800/90 backdrop-blur-xl shadow-sm rounded-2xl overflow-hidden border border-gray-100 dark:border-gray-700/60">

                        <!-- Header Card -->
                        <div
                            class="px-6 py-5 bg-gradient-to-r from-gray-50/50 to-white dark:from-gray-800/50 dark:to-gray-800 border-b border-gray-100 dark:border-gray-700/60 flex justify-between items-center">
                            <div>
                                <h3 class="text-lg font-bold text-gray-800 dark:text-white tracking-tight">
                                    Detail Informasi Anggota
                                </h3>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                    Ringkasan biodata diri & dokumen yang diajukan.
                                </p>
                            </div>
                            <a href="{{ route('admin.anggota.index') }}"
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold text-indigo-600 bg-indigo-50 hover:bg-indigo-100 dark:bg-indigo-950/50 dark:text-indigo-400 dark:hover:bg-indigo-900/50 transition-all duration-200">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                </svg>
                                Kembali
                            </a>
                        </div>

                        <!-- Body Card (Grid Data) -->
                        <div class="p-6 md:p-8">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">

                                <!-- Nama Lengkap -->
                                <div
                                    class="bg-gray-50/70 dark:bg-gray-700/20 p-4 rounded-xl border border-gray-100/80 dark:border-gray-700/30">
                                    <span
                                        class="block text-[11px] font-semibold text-gray-400 uppercase tracking-wider mb-1">Nama
                                        Lengkap</span>
                                    <span
                                        class="font-bold text-gray-800 dark:text-gray-100">{{ $anggotaCard->Anggota->nama ?? '-' }}</span>
                                </div>

                                <!-- No. KTP / NIK -->
                                <div
                                    class="bg-gray-50/70 dark:bg-gray-700/20 p-4 rounded-xl border border-gray-100/80 dark:border-gray-700/30">
                                    <span
                                        class="block text-[11px] font-semibold text-gray-400 uppercase tracking-wider mb-1">No.
                                        KTP / NIK</span>
                                    <span
                                        class="font-semibold text-gray-800 dark:text-gray-100 tracking-wide">{{ $anggotaCard->Anggota->no_ktp ?? '-' }}</span>
                                </div>

                                <!-- Email -->
                                <div
                                    class="bg-gray-50/70 dark:bg-gray-700/20 p-4 rounded-xl border border-gray-100/80 dark:border-gray-700/30">
                                    <span
                                        class="block text-[11px] font-semibold text-gray-400 uppercase tracking-wider mb-1">Email</span>
                                    <span
                                        class="font-medium text-gray-800 dark:text-gray-100 break-all">{{ $anggotaCard->Anggota->email ?? '-' }}</span>
                                </div>

                                <!-- No. HP -->
                                <div
                                    class="bg-gray-50/70 dark:bg-gray-700/20 p-4 rounded-xl border border-gray-100/80 dark:border-gray-700/30">
                                    <span
                                        class="block text-[11px] font-semibold text-gray-400 uppercase tracking-wider mb-1">No.
                                        HP / WhatsApp</span>
                                    <span
                                        class="font-medium text-gray-800 dark:text-gray-100">{{ $anggotaCard->Anggota->no_hp ?? '-' }}</span>
                                </div>

                                <!-- Alamat Lengkap -->
                                <div
                                    class="sm:col-span-2 bg-gray-50/70 dark:bg-gray-700/20 p-4 rounded-xl border border-gray-100/80 dark:border-gray-700/30">
                                    <span
                                        class="block text-[11px] font-semibold text-gray-400 uppercase tracking-wider mb-1">Alamat
                                        Lengkap</span>
                                    <span
                                        class="font-medium text-gray-800 dark:text-gray-100 leading-relaxed">{{ $anggotaCard->Anggota->alamat ?? '-' }}</span>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <!-- KOLOM KANAN: Foto Profil & Aksi Ubah Status -->
                <div class="lg:col-span-1 space-y-6">

                    <!-- Card Foto Profil (Grayscale Accent untuk Status Ditolak) -->
                    <div
                        class="bg-white dark:bg-gray-800/90 backdrop-blur-xl shadow-sm rounded-2xl p-6 border border-gray-100 dark:border-gray-700/60 flex flex-col items-center text-center">
                        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">
                            Foto Profil Anggota
                        </h3>

                        <div
                            class="w-28 h-28 rounded-2xl bg-gray-50 dark:bg-gray-700/50 border-2 border-rose-200 dark:border-rose-900/50 flex items-center justify-center overflow-hidden shadow-sm mb-3 relative">
                            @if ($anggotaCard->Anggota->foto ?? false)
                                <img src="{{ asset('storage/' . $anggotaCard->Anggota->foto) }}"
                                    alt="Foto {{ $anggotaCard->Anggota->nama }}"
                                    class="w-full h-full object-cover grayscale opacity-80">
                            @else
                                <div class="flex flex-col items-center justify-center text-gray-400">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                            @endif
                        </div>

                        <h4 class="font-bold text-gray-800 dark:text-gray-100 text-sm">
                            {{ $anggotaCard->Anggota->nama ?? 'Tanpa Nama' }}
                        </h4>
                        <p class="text-xs text-gray-400 mt-0.5">
                            {{ $anggotaCard->Anggota->pekerjaan ?? 'Anggota' }}
                        </p>
                    </div>

                    <!-- Card Aksi Verifikasi Ulang -->
                    <div
                        class="bg-white dark:bg-gray-800/90 backdrop-blur-xl shadow-sm rounded-2xl p-6 border border-gray-100 dark:border-gray-700/60">
                        <h3 class="text-sm font-bold text-gray-800 dark:text-white mb-3">Status Pengajuan</h3>

                        <div
                            class="p-3 bg-rose-50/50 dark:bg-rose-950/20 rounded-xl border border-rose-100 dark:border-rose-900/40 flex items-center justify-between mb-5">
                            <span class="text-xs font-semibold text-gray-500 dark:text-gray-400">Status Saat Ini</span>
                            <span
                                class="font-bold uppercase px-2.5 py-1 rounded-lg text-[11px] border bg-rose-50 text-rose-700 border-rose-200 dark:bg-rose-950/50 dark:text-rose-400 dark:border-rose-800">
                                Ditolak
                            </span>
                        </div>

                        <button @click="showModal = true"
                            class="w-full py-2.5 px-4 bg-gray-800 hover:bg-gray-900 dark:bg-gray-700 dark:hover:bg-gray-600 active:scale-[0.98] text-white text-xs font-semibold rounded-xl shadow-md focus:outline-none transition duration-200 flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                </path>
                            </svg>
                            Ubah Verifikasi Status
                        </button>
                    </div>

                </div>
            </div>

            <!-- MODAL VERIFIKASI / UBAH STATUS -->
            <div x-show="showModal" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95" class="fixed inset-0 z-50 overflow-y-auto"
                style="display: none;">

                <div class="fixed inset-0 bg-black/40 backdrop-blur-sm transition-opacity" @click="showModal = false">
                </div>

                <div class="flex items-center justify-center min-h-screen p-4">
                    <div
                        class="relative bg-white dark:bg-gray-800 rounded-2xl max-w-md w-full p-6 shadow-2xl z-10 border border-gray-100 dark:border-gray-700">

                        <div class="flex justify-between items-center mb-5">
                            <h3 class="text-base font-bold text-gray-900 dark:text-white">
                                Ubah Status Pengajuan
                            </h3>
                            <button @click="showModal = false"
                                class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>

                        <form action="{{ route('admin.anggota-card.status', $anggotaCard->id) }}" method="POST">
                            @csrf
                            <div class="space-y-4">
                                <div>
                                    <label
                                        class="block text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider mb-1.5">
                                        Pilih Status Baru
                                    </label>
                                    <select name="status" required
                                        class="w-full rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-900 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                                        <option value="approved">Diterima (Approved)</option>
                                        <option value="rejected" selected>Ditolak (Rejected)</option>
                                        <option value="proses">Proses Kembali (Pending)</option>
                                    </select>
                                </div>

                                <div>
                                    <label
                                        class="block text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider mb-1.5">
                                        Keterangan / Alasan
                                    </label>
                                    <textarea name="keterangan" rows="3" placeholder="Masukkan keterangan tambahan jika mengubah status..."
                                        class="w-full rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-900 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition resize-none">{{ old('keterangan', $statusKeterangan) }}</textarea>
                                </div>
                            </div>

                            <div class="flex justify-end gap-3 mt-6">
                                <button type="button" @click="showModal = false"
                                    class="px-5 py-2.5 text-xs font-semibold text-gray-600 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 rounded-xl hover:bg-gray-200 dark:hover:bg-gray-600 transition duration-200">
                                    Batal
                                </button>
                                <button type="submit"
                                    class="px-5 py-2.5 text-xs font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl shadow-md transition duration-200">
                                    Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif


@endsection
