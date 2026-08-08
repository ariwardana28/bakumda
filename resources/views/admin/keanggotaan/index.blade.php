    @extends('layouts.app')

    @section('title', 'Status Keanggotaan')

    @section('content')
        <div class="max-w-6xl mx-auto space-y-8">

            {{-- TAMPILAN 1: JIKA USER SUDAH DAFTAR / SEDANG DIPROSES --}}
            @if (isset($anggota) && $anggota)
                @php
                    $anggota->load('pendingEditRequest', 'card.latestBerlaku', 'card.berlakuHistory');
                    $pendingEditRequest = $anggota->pendingEditRequest;
                    $anggotaCard = $anggota->card;
                    $latestStatusRecord = $anggota->latest_status;

                    $currentStatus = $latestStatusRecord
                        ? strtolower($latestStatusRecord->status)
                        : strtolower($anggota->status ?? 'proses');

                    $isExpired = false;
                    if ($anggotaCard && $anggotaCard->latestBerlaku && $anggotaCard->latestBerlaku->berlaku) {
                        if (\Carbon\Carbon::parse($anggotaCard->latestBerlaku->berlaku)->isPast()) {
                            $isExpired = true;
                            if ($currentStatus === 'aktif') {
                                $currentStatus = 'non-aktif';
                            }
                        }
                    }

                    $catatanAdmin = $latestStatusRecord
                        ? $latestStatusRecord->keterangan
                        : $anggota->catatan_admin ?? '';
                @endphp
                <div x-data="{
                    showEditModal: false,
                    showCancelModal: false,
                    showCancelRequestModal: false
                }">

                    {{-- KONDISI KHUSUS: JIKA STATUS AKTIF / APPROVED DAN ADA CARD (MENYERupai TAMPILAN ADMIN DETAIL KARTU) --}}
                    @if ($currentStatus === 'aktif' && isset($anggota->card))
                        <div class="space-y-6" x-data="{ zoomCard: false }">

                            @if (session('success'))
                                <div
                                    class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 dark:bg-emerald-900/30 dark:border-emerald-800 dark:text-emerald-400 text-xs font-medium">
                                    {{ session('success') }}
                                </div>
                            @endif

                            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6" x-data="{ isFlipped: false }">

                                <!-- KIRI: PREVIEW KARTU FISIK -->
                                <div class="lg:col-span-1">
                                    <div
                                        class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm text-center space-y-4">

                                        <div class="flex items-center justify-between">
                                            <h3 class="text-xs uppercase tracking-wider font-semibold text-gray-400">
                                                Preview Kartu Anggota
                                            </h3>
                                            <span
                                                class="text-[10px] font-semibold px-2 py-0.5 rounded-full bg-indigo-50 dark:bg-indigo-950/50 text-indigo-600 dark:text-indigo-400 border border-indigo-100 dark:border-indigo-900/50"
                                                x-text="isFlipped ? 'Sisi Belakang' : 'Sisi Depan'"></span>
                                        </div>

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

                                        <!-- Wrapper Utama dengan Efek Perspektif -->
                                        <div class="relative w-[280px] h-[480px] mx-auto perspective-1000">

                                            <!-- Kartu Flipper (Kontainer yang Berputar) -->
                                            <div class="relative w-full h-full duration-700 transform-style-3d transition-transform"
                                                :class="{ 'rotate-y-180': isFlipped }">

                                                <!-- ============================================== -->
                                                <!-- KONTAINER 1: SISI DEPAN KARTU -->
                                                <!-- ============================================== -->
                                                <div
                                                    class="absolute inset-0 w-full h-full rounded-2xl shadow-lg border bg-white backface-hidden overflow-hidden transform-style-3d">
                                                    <img src="{{ asset('background.png') }}"
                                                        class="absolute inset-0 w-full h-full object-cover">

                                                    <div class="relative z-10 w-full h-full">
                                                        <!-- Foto -->
                                                        <div
                                                            class="absolute top-[201px] left-[50px] w-[95px] h-[129px] overflow-hidden rounded-sm flex items-center justify-center bg-black">
                                                            @if (optional($anggotaCard->anggota)->foto)
                                                                <img src="{{ asset('storage/' . optional($anggotaCard->anggota)->foto) }}"
                                                                    class="w-full h-full object-cover">
                                                            @else
                                                                <div
                                                                    class="flex flex-col items-center justify-center text-gray-300">
                                                                    <i class="fa-solid fa-user text-3xl"></i>
                                                                    <span class="text-[8px] mt-1">No Foto</span>
                                                                </div>
                                                            @endif
                                                        </div>

                                                        <!-- QR Code + NIA -->
                                                        <div
                                                            class="absolute top-[205px] left-[152px] w-[80px] flex flex-col items-center">
                                                            <div
                                                                class="w-[78px] h-[78px] bg-white p-1 flex items-center justify-center">
                                                                @if ($anggotaCard->qr_code)
                                                                    <img src="{{ asset('storage/' . $anggotaCard->qr_code) }}"
                                                                        class="w-full h-full object-contain">
                                                                @else
                                                                    <div
                                                                        class="text-[8px] text-gray-400 text-center leading-tight">
                                                                        Belum<br>Terbit</div>
                                                                @endif
                                                            </div>
                                                            @if ($anggotaCard->card_id)
                                                                <span
                                                                    class="text-[8px] font-bold text-gray-900 font-sans tracking-tight mt-1 whitespace-nowrap">
                                                                    {{ $anggotaCard->card_id }}
                                                                </span>
                                                            @endif
                                                        </div>

                                                        <!-- Nama & Jabatan -->
                                                        <div class="absolute top-[342px] inset-x-0 px-4 text-center">
                                                            <h2
                                                                class="text-[11px] font-extrabold text-gray-900 uppercase tracking-tight leading-snug">
                                                                {{ optional($anggotaCard->anggota)->nama }}
                                                            </h2>
                                                            @if (!empty(optional($anggotaCard->latestBerlaku)->jabatan))
                                                                <p
                                                                    class="text-[9.5px] font-bold text-gray-800 uppercase tracking-wider mt-0.5">
                                                                    {{ optional($anggotaCard->latestBerlaku)->jabatan }}
                                                                </p>
                                                            @endif
                                                        </div>

                                                        <!-- Masa Berlaku -->
                                                        @if (!empty(optional($anggotaCard->latestBerlaku)->berlaku))
                                                            <div class="absolute bottom-[20px] left-[18px]">
                                                                <p class="text-[8px] font-bold text-gray-900 font-sans">
                                                                    Berlaku s/d
                                                                    {{ \Carbon\Carbon::parse(optional($anggotaCard->latestBerlaku)->berlaku)->translatedFormat('d F Y') }}
                                                                </p>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>

                                                <!-- ============================================== -->
                                                <!-- KONTAINER 2: SISI BELAKANG KARTU -->
                                                <!-- ============================================== -->
                                                <div
                                                    class="absolute inset-0 w-full h-full rounded-2xl shadow-lg border bg-white backface-hidden rotate-y-180 overflow-hidden transform-style-3d">
                                                    <img src="{{ asset('belakang.png') }}"
                                                        class="absolute inset-0 w-full h-full object-cover">

                                                    <div class="relative z-10 w-full h-full">
                                                        <!-- NIK -->
                                                        <div class="absolute top-[100px] left-[30px] pr-4 text-left">
                                                            <p class="text-[7px] font-semibold text-gray-600 uppercase">
                                                            </p>
                                                            <p
                                                                class="text-[9px] font-bold text-gray-900 font-sans tracking-wide">
                                                                {{-- {{ optional($anggotaCard->anggota)->no_ktp ?? '-' }} --}}
                                                            </p>
                                                        </div>

                                                        <!-- Tempat, Tanggal Lahir -->
                                                        <div class="absolute top-[130px] left-[30px] pr-4 text-left">
                                                            <p class="text-[7px] font-semibold text-gray-600 uppercase">
                                                                {{-- Tempat, Tanggal Lahir</p> --}}
                                                            <p
                                                                class="text-[9px] font-bold text-gray-900 font-sans tracking-wide">
                                                                {{-- {{ optional($anggotaCard->anggota)->tempat_lahir }},
                                                                {{ optional($anggotaCard->anggota)->tanggal_lahir ? \Carbon\Carbon::parse(optional($anggotaCard->anggota)->tanggal_lahir)->translatedFormat('d F Y') : '' }} --}}
                                                            </p>
                                                        </div>

                                                        <!-- Alamat -->
                                                        <div
                                                            class="absolute top-[160px] left-[30px] right-[30px] text-left">
                                                            <p class="text-[7px] font-semibold text-gray-600 uppercase">
                                                                {{-- Alamat</p> --}}
                                                            <p
                                                                class="text-[9px] font-bold text-gray-900 font-sans tracking-wide leading-snug">
                                                                {{-- {{ optional($anggotaCard->anggota)->alamat ?? '-' }} --}}
                                                            </p>
                                                        </div>

                                                        <!-- Diterbitkan -->
                                                        <div class="absolute top-[215px] left-[30px] pr-4 text-left">
                                                            <p class="text-[7px] font-semibold text-gray-600 uppercase">
                                                                {{-- Diterbitkan</p> --}}
                                                            <p
                                                                class="text-[9px] font-bold text-gray-900 font-sans tracking-wide">
                                                                {{-- {{ optional($anggotaCard->latestBerlaku)->diterbitkan ? \Carbon\Carbon::parse(optional($anggotaCard->latestBerlaku)->diterbitkan)->translatedFormat('d F Y') : '-' }} --}}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>

                                        <!-- Tombol Aksi -->
                                        <div class="pt-2 flex flex-col gap-2">
                                            <button type="button" @click="isFlipped = !isFlipped"
                                                class="w-full px-3 py-2 text-xs font-semibold rounded-xl bg-indigo-50 text-indigo-600 hover:bg-indigo-100 border border-indigo-100 transition flex items-center justify-center gap-1.5 shadow-sm">
                                                <i class="fa-solid fa-rotate transition-transform duration-500"
                                                    :class="{ 'rotate-180': isFlipped }"></i>
                                                <span
                                                    x-text="isFlipped ? 'Lihat Sisi Depan Kartu' : 'Putar ke Sisi Belakang'"></span>
                                            </button>

                                            <div class="flex flex-col sm:flex-row gap-2 justify-center">
                                                <button type="button" @click="zoomCard = true"
                                                    class="px-3 py-2 text-xs font-semibold rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 transition flex items-center justify-center gap-1.5">
                                                    <i class="fa-solid fa-magnifying-glass-plus"></i>
                                                    <span>Perbesar Kartu</span>
                                                </button>

                                                <a href="{{ route('admin.anggota-card.download', $anggotaCard->id) }}"
                                                    target="_blank"
                                                    class="px-3 py-2 text-xs font-semibold rounded-xl bg-brand-600 hover:bg-brand-700 text-white transition flex items-center justify-center gap-1.5 shadow-sm">
                                                    <i class="fa-solid fa-download"></i>
                                                    <span>Unduh Kartu</span>
                                                </a>
                                            </div>
                                        </div>

                                        <p class="text-[11px] text-gray-400 mt-1">Tampilan presisi kartu anggota fisik
                                            BAKUMDA.</p>
                                    </div>
                                </div>

                                <!-- KANAN: INFORMASI LENGKAP KARTU -->
                                <div class="hidden lg:block lg:col-span-2 space-y-6" x-data="{ showHistory: false }">
                                    <div
                                        class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm space-y-4">
                                        <div
                                            class="flex items-center justify-between border-b border-gray-100 dark:border-gray-700 pb-3">
                                            <h3
                                                class="text-sm font-bold text-gray-900 dark:text-gray-100 flex items-center gap-2">
                                                <i class="fa-solid fa-circle-check text-emerald-500"></i>
                                                <span>Informasi Lengkap Kartu Anggota (Aktif)</span>
                                            </h3>
                                            <span
                                                class="px-2.5 py-1 text-[10px] font-semibold bg-emerald-50 text-emerald-600 rounded-full border border-emerald-200">
                                                Status: Aktif / Terbit
                                            </span>
                                        </div>

                                        <!-- Tombol & Konten Riwayat Masa Berlaku -->
                                        <div>
                                            <button type="button" @click="showHistory = !showHistory"
                                                class="w-full flex items-center justify-between text-left px-4 py-3 rounded-xl bg-gray-50 dark:bg-gray-700/30 hover:bg-gray-100 dark:hover:bg-gray-700/50 transition duration-200">
                                                <div class="flex items-center gap-2">
                                                    <i class="fa-solid fa-history text-gray-400 text-xs"></i>
                                                    <span class="text-xs font-bold text-gray-800 dark:text-gray-200">Riwayat
                                                        Masa Berlaku Kartu</span>
                                                </div>
                                                <i class="fa-solid fa-chevron-down text-gray-400 text-xs transition-transform"
                                                    :class="{ 'rotate-180': showHistory }"></i>
                                            </button>

                                            <div x-show="showHistory" x-collapse style="display: none;">
                                                <div class="mt-2 space-y-2 max-h-48 overflow-y-auto pr-2 pl-1">
                                                    @forelse ($anggotaCard->berlakuHistory->sortByDesc('diterbitkan') as $riwayat)
                                                        <div
                                                            class="flex items-start justify-between text-xs p-3 rounded-xl bg-gray-100 dark:bg-gray-900/30">
                                                            <div class="space-y-0.5">
                                                                <p class="font-bold text-gray-900 dark:text-white">
                                                                    {{ $riwayat->jabatan }}</p>
                                                                <p class="text-gray-500 dark:text-gray-400">Diterbitkan:
                                                                    {{ \Carbon\Carbon::parse($riwayat->diterbitkan)->translatedFormat('d F Y') }}
                                                                </p>
                                                            </div>
                                                            <div class="text-right shrink-0 ml-4">
                                                                <p class="font-semibold text-gray-800 dark:text-gray-200">
                                                                    Berlaku s/d:
                                                                    {{ \Carbon\Carbon::parse($riwayat->berlaku)->translatedFormat('d F Y') }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    @empty
                                                        <p class="text-xs text-center text-gray-400 py-4">Belum ada riwayat.
                                                        </p>
                                                    @endforelse
                                                </div>
                                            </div>
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
                                                    class="font-semibold text-gray-800 dark:text-gray-200">{{ optional($anggotaCard->latestBerlaku)->jabatan ?? '-' }}</span>
                                            </div>

                                            <div class="bg-gray-50 dark:bg-gray-700/30 p-3 rounded-xl">
                                                <span class="block text-gray-400 mb-0.5">NIK / No. Identitas</span>
                                                <span
                                                    class="font-semibold text-gray-800 dark:text-gray-200">{{ $anggotaCard->anggota->no_ktp ?? '-' }}</span>
                                            </div>

                                            <div class="bg-gray-50 dark:bg-gray-700/30 p-3 rounded-xl">
                                                <span class="block text-gray-400 mb-0.5">Tanggal Diterbitkan</span>
                                                <span class="font-semibold text-gray-800 dark:text-gray-200">
                                                    {{ optional($anggotaCard->latestBerlaku)->diterbitkan ? \Carbon\Carbon::parse(optional($anggotaCard->latestBerlaku)->diterbitkan)->translatedFormat('d F Y') : '-' }}
                                                </span>
                                            </div>

                                            <div class="bg-gray-50 dark:bg-gray-700/30 p-3 rounded-xl">
                                                <span class="block text-gray-400 mb-0.5">Masa Berlaku Kartu</span>
                                                <span class="font-semibold text-gray-800 dark:text-gray-200">
                                                    {{ optional($anggotaCard->latestBerlaku)->berlaku ? \Carbon\Carbon::parse(optional($anggotaCard->latestBerlaku)->berlaku)->translatedFormat('d F Y') : '-' }}
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

                                        <!-- Tombol Aksi Edit -->
                                        <div class="flex justify-end pt-4 border-t border-gray-100 dark:border-gray-700">
                                            @if (isset($pendingEditRequest) && $pendingEditRequest->latestStatus->status === 'approved')
                                                <a href="{{ route('user-anggota.edit', $anggota->id) }}"
                                                    class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-xs font-semibold rounded-xl transition flex items-center gap-2">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                    <span>Lanjutkan Perubahan Data</span>
                                                </a>
                                            @elseif ($pendingEditRequest && $pendingEditRequest->latestStatus->status === 'proses')
                                                <button type="button" @click="showCancelRequestModal = true"
                                                    class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white text-xs font-semibold rounded-xl transition flex items-center gap-2">
                                                    <i class="fa-solid fa-hourglass-half"></i>
                                                    <span>Lihat & Batalkan Permintaan</span>
                                                </button>
                                            @else
                                                <button type="button" @click="showEditModal = true"
                                                    class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-xs font-semibold rounded-xl transition flex items-center gap-2">
                                                    <i class="fa-solid fa-paper-plane"></i>
                                                    <span>Ajukan Perubahan Data</span>
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <!-- MODAL PERBESAR (ZOOM) KARTU ANGGOTA -->
                            <div x-show="zoomCard" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;"
                                x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
                                x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
                                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

                                <!-- Backdrop dengan Efek Blur dan Transisi Gelap -->
                                <div class="fixed inset-0 bg-gray-950/80 backdrop-blur-md transition-opacity"
                                    @click="zoomCard = false"></div>

                                <!-- Container Modal -->
                                <div class="flex items-center justify-center min-h-screen p-4 sm:p-6">
                                    <div class="relative bg-white/90 dark:bg-gray-800/90 backdrop-blur-2xl rounded-3xl p-6 sm:p-8 shadow-2xl shadow-black/20 border border-gray-100 dark:border-gray-700/80 z-10 max-w-md w-full flex flex-col items-center transform transition-all"
                                        x-transition:enter="transition ease-out duration-300 transform"
                                        x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                                        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                        x-transition:leave="transition ease-in duration-200 transform"
                                        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                                        x-transition:leave-end="opacity-0 scale-95 translate-y-4">

                                        <!-- Header Modal -->
                                        <div
                                            class="flex justify-between items-center w-full mb-2 border-b border-gray-100 dark:border-gray-700/60 pb-3">
                                            <div class="flex items-center gap-2.5">
                                                <div
                                                    class="w-7 h-7 rounded-xl bg-indigo-50 dark:bg-indigo-950/50 flex items-center justify-center text-indigo-600 dark:text-indigo-400">
                                                    <i class="fa-solid fa-id-card text-xs"></i>
                                                </div>
                                                <h3
                                                    class="text-xs font-bold uppercase tracking-wider text-gray-900 dark:text-white">
                                                    Detail Kartu Anggota
                                                </h3>
                                            </div>
                                            <button @click="zoomCard = false"
                                                class="w-8 h-8 rounded-xl bg-gray-100 dark:bg-gray-700/60 text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 flex items-center justify-center transition-all">
                                                <i class="fa-solid fa-xmark text-sm"></i>
                                            </button>
                                        </div>

                                        <!-- KARTU UKURAN DIPERBESAR (SCALE) DENGAN EFEK BAYANGAN PREMIUM -->
                                        <div
                                            class="relative w-[280px] h-[480px] rounded-2xl overflow-hidden shadow-2xl shadow-gray-400/30 dark:shadow-black/60 border border-gray-200/60 dark:border-gray-700 transform scale-105 sm:scale-110 my-6 bg-white transition-transform duration-300">

                                            <!-- Layer 1: Background Template -->
                                            <img src="{{ asset('background.png') }}"
                                                class="absolute inset-0 w-full h-full object-cover z-0"
                                                alt="Background ID Card">

                                            <!-- Layer 2: Konten Kartu -->
                                            <div class="relative z-10 w-full h-full">

                                                <!-- 1. Pas Foto -->
                                                <div
                                                    class="absolute top-[201px] left-[50px] w-[95px] h-[129px] overflow-hidden rounded-sm flex items-center justify-center bg-gray-900 shadow-inner">
                                                    @if ($anggotaCard->anggota->foto ?? false)
                                                        <img src="{{ asset('storage/' . $anggotaCard->anggota->foto) }}"
                                                            class="w-full h-full object-cover">
                                                    @else
                                                        <div
                                                            class="flex flex-col items-center justify-center text-gray-400">
                                                            <i class="fa-solid fa-user text-3xl"></i>
                                                            <span class="text-[8px] mt-1 font-medium">No Foto</span>
                                                        </div>
                                                    @endif
                                                </div>

                                                <!-- 2. QR Code + NIA -->
                                                <div
                                                    class="absolute top-[205px] left-[152px] w-[80px] flex flex-col items-center">
                                                    <div
                                                        class="w-[78px] h-[78px] bg-white p-1.5 rounded-lg shadow-sm border border-gray-100 flex items-center justify-center">
                                                        @if ($anggotaCard->qr_code)
                                                            <img src="{{ asset('storage/' . $anggotaCard->qr_code) }}"
                                                                class="w-full h-full object-contain">
                                                        @else
                                                            <div
                                                                class="text-[8px] text-gray-400 text-center leading-tight font-medium">
                                                                Belum<br>Terbit
                                                            </div>
                                                        @endif
                                                    </div>

                                                    @if ($anggotaCard->card_id)
                                                        <span
                                                            class="text-[8px] font-bold text-gray-900 font-mono tracking-tight mt-1.5 whitespace-nowrap bg-white/90 backdrop-blur-sm px-1.5 py-0.5 rounded shadow-sm">
                                                            {{ $anggotaCard->card_id }}
                                                        </span>
                                                    @endif
                                                </div>

                                                <!-- 3. Nama & Jabatan -->
                                                <div class="absolute top-[342px] inset-x-0 px-4 text-center">
                                                    <h2
                                                        class="text-[11px] font-extrabold text-gray-900 uppercase tracking-tight leading-snug truncate drop-shadow-sm">
                                                        {{ $anggotaCard->anggota->nama ?? '' }}
                                                    </h2>

                                                    @if (!empty(optional($anggotaCard->latestBerlaku)->jabatan))
                                                        <p
                                                            class="text-[9.5px] font-bold text-gray-800 uppercase tracking-wider mt-0.5 truncate">
                                                            {{ optional($anggotaCard->latestBerlaku)->jabatan }}
                                                        </p>
                                                    @endif
                                                </div>

                                                <!-- 4. Masa Berlaku -->
                                                @if (!empty(optional($anggotaCard->latestBerlaku)->berlaku))
                                                    <div class="absolute bottom-[20px] left-[18px]">
                                                        <p
                                                            class="text-[8px] font-bold text-gray-900 font-sans tracking-wide">
                                                            Berlaku s/d
                                                            {{ \Carbon\Carbon::parse(optional($anggotaCard->latestBerlaku)->berlaku)->translatedFormat('d F Y') }}
                                                        </p>
                                                    </div>
                                                @endif

                                            </div>
                                        </div>

                                        <!-- Footer Tombol Aksi -->
                                        <div class="pt-2 flex items-center justify-end w-full gap-3">
                                            <a href="{{ route('admin.anggota-card.download', $anggotaCard->id) }}"
                                                target="_blank"
                                                class="px-4 py-2.5 text-xs font-semibold rounded-xl bg-indigo-600 hover:bg-indigo-700 active:scale-95 text-white transition-all duration-200 flex items-center justify-center gap-2 shadow-md shadow-indigo-500/25">
                                                <i class="fa-solid fa-download"></i>
                                                <span>Unduh Kartu</span>
                                            </a>
                                            <button type="button" @click="zoomCard = false"
                                                class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700/80 dark:hover:bg-gray-700 active:scale-95 text-gray-700 dark:text-gray-200 text-xs font-semibold rounded-xl transition-all duration-200 shadow-sm">
                                                Tutup
                                            </button>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>

                        {{-- KONDISI STATUS LAINNYA (PENDING, APPROVED, REJECTED) --}}
                    @else
                        <div
                            class="bg-white dark:bg-slate-900 rounded-3xl p-6 sm:p-10 border border-slate-200/80 dark:border-slate-800 shadow-xl text-center space-y-6 relative overflow-hidden">

                            <!-- Background Ambient Glow Accent -->
                            <div
                                class="absolute -top-24 left-1/2 -translate-x-1/2 w-96 h-96 bg-indigo-500/5 dark:bg-indigo-500/10 rounded-full blur-3xl pointer-events-none">
                            </div>

                            <!-- Icon Status Dynamic with Modern Glow Effect -->
                            <div class="relative w-20 h-20 mx-auto flex items-center justify-center">
                                @if ($currentStatus === 'approved')
                                    <div class="absolute inset-0 rounded-2xl bg-blue-500/20 blur-xl animate-pulse"></div>
                                    <div
                                        class="relative w-20 h-20 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 text-white flex items-center justify-center text-3xl shadow-lg shadow-blue-500/30">
                                        <i class="fa-solid fa-circle-chevron-right"></i>
                                    </div>
                                @elseif(in_array($currentStatus, ['rejected', 'ditolak']))
                                    <div class="absolute inset-0 rounded-2xl bg-rose-500/20 blur-xl animate-pulse"></div>
                                    <div
                                        class="relative w-20 h-20 rounded-2xl bg-gradient-to-br from-rose-500 to-red-600 text-white flex items-center justify-center text-3xl shadow-lg shadow-rose-500/30">
                                        <i class="fa-solid fa-circle-xmark"></i>
                                    </div>
                                @elseif($currentStatus === 'menunggu pembayaran')
                                    <div class="absolute inset-0 rounded-2xl bg-cyan-500/20 blur-xl animate-pulse"></div>
                                    <div
                                        class="relative w-20 h-20 rounded-2xl bg-gradient-to-br from-cyan-500 to-teal-600 text-white flex items-center justify-center text-3xl shadow-lg shadow-cyan-500/30">
                                        <i class="fa-solid fa-wallet"></i>
                                    </div>
                                @elseif($currentStatus === 'pembayaran diproses')
                                    <div class="absolute inset-0 rounded-2xl bg-indigo-500/20 blur-xl animate-pulse"></div>
                                    <div
                                        class="relative w-20 h-20 rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 text-white flex items-center justify-center text-3xl shadow-lg shadow-indigo-500/30">
                                        <i class="fa-solid fa-receipt"></i>
                                    </div>
                                @elseif($currentStatus === 'non-aktif')
                                    <div class="absolute inset-0 rounded-2xl bg-slate-500/10 blur-xl"></div>
                                    <div
                                        class="relative w-20 h-20 rounded-2xl bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 flex items-center justify-center text-3xl shadow-inner border border-slate-200 dark:border-slate-700">
                                        <i class="fa-solid fa-calendar-xmark"></i>
                                    </div>
                                @else
                                    <div class="absolute inset-0 rounded-2xl bg-amber-500/20 blur-xl animate-pulse"></div>
                                    <div
                                        class="relative w-20 h-20 rounded-2xl bg-gradient-to-br from-amber-500 to-orange-600 text-white flex items-center justify-center text-3xl shadow-lg shadow-amber-500/30 animate-pulse">
                                        <i class="fa-solid fa-clock"></i>
                                    </div>
                                @endif
                            </div>

                            <!-- Status Header & Typography -->
                            <div class="max-w-lg mx-auto space-y-3 relative z-10">
                                <span
                                    class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-[11px] font-bold uppercase tracking-wider shadow-sm
            @if ($currentStatus === 'menunggu pembayaran') bg-cyan-50 text-cyan-700 dark:bg-cyan-500/10 dark:text-cyan-400 border border-cyan-200/60 dark:border-cyan-800/60
            @elseif ($currentStatus === 'pembayaran diproses') bg-indigo-50 text-indigo-700 dark:bg-indigo-500/10 dark:text-indigo-400 border border-indigo-200/60 dark:border-indigo-800/60
            @elseif ($currentStatus === 'approved') bg-blue-50 text-blue-700 dark:bg-blue-500/10 dark:text-blue-400 border border-blue-200/60 dark:border-blue-800/60
            @elseif(in_array($currentStatus, ['rejected', 'ditolak'])) bg-rose-50 text-rose-700 dark:bg-rose-500/10 dark:text-rose-400 border border-rose-200/60 dark:border-rose-800/60
            @elseif($currentStatus === 'non-aktif') bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-400 border border-slate-200 dark:border-slate-700
            @else bg-amber-50 text-amber-700 dark:bg-amber-500/10 dark:text-amber-400 border border-amber-200/60 dark:border-amber-800/60 @endif">
                                    <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                    Status: {{ ucfirst($currentStatus) }}
                                </span>

                                <h2
                                    class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white tracking-tight leading-snug">
                                    @if ($currentStatus === 'approved')
                                        Verifikasi Berkas Selesai, Menunggu Penerbitan KTA
                                    @elseif(in_array($currentStatus, ['rejected', 'ditolak']))
                                        Pendaftaran Anggota Ditolak
                                    @elseif($currentStatus === 'menunggu pembayaran')
                                        Pendaftaran Disetujui, Menunggu Pembayaran
                                    @elseif($currentStatus === 'pembayaran diproses')
                                        Pembayaran Terkirim, Menunggu Konfirmasi
                                    @elseif($currentStatus === 'non-aktif')
                                        Masa Berlaku Kartu Anggota Habis
                                    @else
                                        Formulir Terkirim, Verifikasi Berkas Pending
                                    @endif
                                </h2>

                                <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 leading-relaxed px-4">
                                    @if ($currentStatus === 'approved')
                                        Berkas Anda telah disetujui oleh verifikator. Saat ini proses penerbitan Kartu Tanda
                                        Anggota (KTA) sedang dipersiapkan.
                                    @elseif(in_array($currentStatus, ['rejected', 'ditolak']))
                                        Mohon maaf, permohonan pendaftaran Anda belum dapat disetujui. <span
                                            class="font-semibold text-rose-600 dark:text-rose-400">{{ $catatanAdmin }}</span>
                                    @elseif($currentStatus === 'menunggu pembayaran')
                                        Selamat, data Anda telah disetujui. Silakan lakukan pembayaran biaya keanggotaan
                                        untuk melanjutkan proses penerbitan kartu.
                                    @elseif($currentStatus === 'pembayaran diproses')
                                        Terima kasih, bukti pembayaran Anda telah kami terima. Admin akan segera melakukan
                                        verifikasi dan menerbitkan kartu Anda.
                                    @elseif($currentStatus === 'non-aktif')
                                        Masa berlaku kartu tanda anggota Anda telah berakhir. Silakan ajukan perpanjangan
                                        untuk mengaktifkan kembali status keanggotaan Anda.
                                    @else
                                        Formulir pendaftaran Anda berhasil terkirim. Tim verifikator BAKUMDA sedang
                                        menjadwalkan pemeriksaan berkas Anda.
                                    @endif
                                </p>
                            </div>

                            <!-- Instruksi Pembayaran (Jika Menunggu Pembayaran) -->
                            @if ($currentStatus === 'menunggu pembayaran')
                                <div
                                    class="max-w-xl mx-auto p-5 sm:p-6 rounded-2xl bg-slate-50/80 dark:bg-slate-800/40 text-xs text-left space-y-4 border border-slate-200/80 dark:border-slate-800 backdrop-blur-sm">
                                    <div class="space-y-2">
                                        <h4
                                            class="font-bold text-slate-800 dark:text-slate-200 flex items-center gap-2 text-sm">
                                            <span
                                                class="w-6 h-6 rounded-lg bg-cyan-100 dark:bg-cyan-500/20 text-cyan-600 dark:text-cyan-400 flex items-center justify-center text-xs">
                                                <i class="fa-solid fa-info"></i>
                                            </span>
                                            Instruksi Pembayaran
                                        </h4>
                                        <p class="text-slate-500 dark:text-slate-400 leading-relaxed">
                                            Silakan transfer biaya pendaftaran sebesar <strong
                                                class="text-slate-800 dark:text-slate-100 font-bold bg-cyan-50 dark:bg-cyan-500/10 px-1.5 py-0.5 rounded text-cyan-600 dark:text-cyan-400">Rp
                                                150.000,-</strong> ke nomor rekening resmi berikut:
                                        </p>
                                        <div
                                            class="mt-3 p-4 rounded-xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 flex items-center justify-between shadow-xs">
                                            <div>
                                                <p
                                                    class="font-mono text-sm font-bold text-slate-900 dark:text-white tracking-wider">
                                                    <span
                                                        class="text-cyan-600 dark:text-cyan-400 font-sans uppercase text-[11px] font-semibold mr-1 bg-cyan-50 dark:bg-cyan-500/10 px-2 py-0.5 rounded-md">BCA</span>
                                                    1234-5678-9012
                                                </p>
                                                <p class="text-[11px] text-slate-400 mt-1 font-medium">a.n. Bendahara
                                                    BAKUMDA</p>
                                            </div>
                                        </div>
                                    </div>

                                    <form action="{{ route('user-anggota.pembayaran.upload', $anggota->id) }}"
                                        method="POST" enctype="multipart/form-data" class="space-y-3 pt-2">
                                        @csrf
                                        <div>
                                            <label
                                                class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                                                Upload Bukti Pembayaran <span class="text-rose-500">*</span>
                                            </label>
                                            <input type="file" name="bukti_pembayaran" required accept="image/*,.pdf"
                                                class="text-xs text-slate-500 w-full file:mr-3 file:py-2 file:px-3.5 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-cyan-50 file:text-cyan-700 dark:file:bg-cyan-500/10 dark:file:text-cyan-400 hover:file:bg-cyan-100 transition-all border border-slate-200 dark:border-slate-700 rounded-xl bg-white dark:bg-slate-900 p-1 cursor-pointer">
                                            @error('bukti_pembayaran')
                                                <span
                                                    class="text-[10px] text-rose-500 mt-1 block font-medium">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="text-right pt-2">
                                            <button type="submit"
                                                class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl bg-cyan-600 hover:bg-cyan-500 text-white font-bold text-xs shadow-lg shadow-cyan-600/20 transition-all duration-200 hover:scale-[1.02]">
                                                <i class="fa-solid fa-paper-plane"></i>
                                                <span>Konfirmasi Pembayaran</span>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            @endif

                            <!-- Rangkuman Detail Pendaftaran -->
                            <div
                                class="max-w-xl mx-auto p-4 sm:p-5 rounded-2xl bg-slate-50/70 dark:bg-slate-800/40 text-xs text-left space-y-3 border border-slate-200/80 dark:border-slate-800">
                                <div
                                    class="flex justify-between items-center py-1.5 border-b border-slate-200/60 dark:border-slate-700/50">
                                    <span class="text-slate-400 dark:text-slate-500 font-medium">Nama Pendaftar</span>
                                    <span
                                        class="font-bold text-slate-800 dark:text-slate-200 uppercase tracking-tight">{{ $anggota->nama }}</span>
                                </div>
                                <div
                                    class="flex justify-between items-center py-1.5 border-b border-slate-200/60 dark:border-slate-700/50">
                                    <span class="text-slate-400 dark:text-slate-500 font-medium">NIK / KTP</span>
                                    <span
                                        class="font-bold text-slate-800 dark:text-slate-200 font-mono tracking-wider">{{ $anggota->no_ktp }}</span>
                                </div>
                                <div class="flex justify-between items-center py-1.5">
                                    <span class="text-slate-400 dark:text-slate-500 font-medium">Tanggal Pengajuan</span>
                                    <span class="font-bold text-slate-800 dark:text-slate-200">
                                        {{ $anggota->created_at ? $anggota->created_at->translatedFormat('d F Y (H:i)') : '-' }}
                                    </span>
                                </div>
                            </div>

                            <!-- Tombol Tindakan / Aksi Status Khusus -->
                            @if (in_array($currentStatus, ['rejected', 'ditolak', 'non-aktif', 'proses']))
                                <div class="pt-2 flex justify-center">
                                    @if (in_array($currentStatus, ['rejected', 'ditolak']) && !$pendingEditRequest)
                                        <button type="button" @click="showEditModal = true"
                                            class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-orange-600 hover:bg-orange-500 text-white font-bold text-xs shadow-lg shadow-orange-600/20 transition-all duration-200 hover:scale-[1.02]">
                                            <i class="fa-solid fa-paper-plane"></i>
                                            <span>Ajukan Ulang Pendaftaran</span>
                                        </button>
                                    @elseif ($currentStatus === 'non-aktif')
                                        <a href="{{ route('user-anggota.edit', $anggota->id) }}"
                                            class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-orange-600 hover:bg-orange-500 text-white font-bold text-xs shadow-lg shadow-orange-600/20 transition-all duration-200 hover:scale-[1.02]">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                            <span>Ajukan Perpanjangan Kartu</span>
                                        </a>
                                    @elseif ($pendingEditRequest && optional($pendingEditRequest->latestStatus)->status === 'proses')
                                        <button type="button" @click="showCancelRequestModal = true"
                                            class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-slate-600 hover:bg-slate-500 text-white font-bold text-xs shadow-md transition-all hover:scale-[1.02]">
                                            <i class="fa-solid fa-hourglass-half"></i>
                                            <span>Lihat & Batalkan Permintaan</span>
                                        </button>
                                    @elseif ($currentStatus === 'proses')
                                        <a href="{{ route('user-anggota.edit', $anggota->id) }}"
                                            class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs shadow-lg shadow-emerald-600/20 transition-all hover:scale-[1.02]">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                            <span>Lanjutkan Perbarui Pendaftaran</span>
                                        </a>
                                    @endif
                                </div>
                            @endif

                        </div>
                    @endif

                    <!-- MODAL KONFIRMASI EDIT DATA -->
                    <div x-show="showEditModal" x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                        class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">

                        <div class="fixed inset-0 bg-black/40 backdrop-blur-sm transition-opacity"
                            @click="showEditModal = false">
                        </div>

                        <div class="flex items-center justify-center min-h-screen p-4">
                            <div
                                class="relative bg-white dark:bg-gray-800 rounded-2xl max-w-md w-full p-6 shadow-2xl z-10 border border-gray-100 dark:border-gray-700">

                                <div class="flex justify-between items-center mb-5">
                                    <h3 class="text-base font-bold text-gray-900 dark:text-white">
                                        Ajukan Perubahan Data
                                    </h3>
                                    <button @click="showEditModal = false"
                                        class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>

                                <form action="{{ route('user-anggota.request-edit', $anggota) }}" method="POST">
                                    @csrf
                                    <div class="space-y-4">
                                        <p class="text-xs text-gray-600 dark:text-gray-400">
                                            @if ($currentStatus === 'aktif')
                                                Data kartu Anda sudah <span
                                                    class="font-bold text-emerald-600">AKTIF</span>. Untuk mengubahnya,
                                                kirim permintaan kepada admin dengan menyertakan alasan yang jelas.
                                            @elseif ($currentStatus === 'non-aktif')
                                                Masa berlaku kartu Anda sudah <span
                                                    class="font-bold text-rose-600">HABIS</span>. Untuk memperpanjang,
                                                kirim permintaan kepada admin dengan menyertakan alasan yang jelas.
                                            @else
                                                Pendaftaran Anda sebelumnya <span
                                                    class="font-bold text-rose-600">DITOLAK</span>. Kirim permintaan untuk
                                                membuka kembali formulir pendaftaran Anda.
                                            @endif
                                        </p>
                                        <div>
                                            <label
                                                class="block text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider mb-1.5 required">
                                                Alasan Perubahan Data
                                            </label>
                                            <textarea name="keterangan" rows="3" required
                                                placeholder="Contoh: Ada kesalahan penulisan nama, ingin mengganti foto, dll."
                                                class="w-full rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-900 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition resize-none"></textarea>
                                        </div>
                                    </div>

                                    <div class="flex justify-end gap-3 mt-6">
                                        <button type="button" @click="showEditModal = false"
                                            class="px-5 py-2.5 text-xs font-semibold text-gray-600 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 rounded-xl hover:bg-gray-200 dark:hover:bg-gray-600 transition duration-200">
                                            Batal
                                        </button>
                                        <button type="submit"
                                            class="px-5 py-2.5 text-xs font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl shadow-md shadow-indigo-200 dark:shadow-none transition duration-200">
                                            Kirim Permintaan
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- MODAL LIHAT STATUS & BATALKAN PENDAFTARAN -->
                    <div x-show="showCancelModal" x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                        class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">

                        <div class="fixed inset-0 bg-black/40 backdrop-blur-sm transition-opacity"
                            @click="showCancelModal = false">
                        </div>

                        <div class="flex items-center justify-center min-h-screen p-4">
                            <div
                                class="relative bg-white dark:bg-gray-800 rounded-2xl max-w-md w-full p-6 shadow-2xl z-10 border border-gray-100 dark:border-gray-700">

                                <div class="flex justify-between items-center mb-5">
                                    <h3 class="text-base font-bold text-gray-900 dark:text-white">
                                        Status Pendaftaran Anda
                                    </h3>
                                    <button @click="showCancelModal = false"
                                        class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>

                                <div class="space-y-4">
                                    <div
                                        class="p-4 rounded-xl bg-slate-50 dark:bg-slate-700/50 border border-slate-200 dark:border-slate-700 text-xs">
                                        <p class="font-semibold text-slate-800 dark:text-slate-200 mb-1">Status Saat Ini:
                                            <span
                                                class="uppercase font-bold text-amber-600 dark:text-amber-400">{{ $currentStatus }}</span>
                                        </p>
                                        <p class="text-slate-600 dark:text-slate-400">
                                            Pendaftaran Anda sedang dalam proses verifikasi oleh Admin. Silakan tunggu atau
                                            batalkan pendaftaran untuk mengubah data.
                                        </p>
                                    </div>
                                    <div
                                        class="p-4 rounded-xl bg-slate-50 dark:bg-slate-700/50 border border-slate-200 dark:border-slate-700 text-xs">
                                        <p class="font-semibold text-slate-800 dark:text-slate-200 mb-1">Keterangan dari
                                            Admin:</p>
                                        <p class="text-slate-600 dark:text-slate-400 italic">
                                            "{{ $catatanAdmin ?: 'Belum ada catatan.' }}"
                                        </p>
                                    </div>
                                    <p class="text-xs text-gray-600 dark:text-gray-400">
                                        Jika Anda ingin membatalkan pendaftaran ini untuk melakukan perubahan besar atau
                                        alasan lain, Anda dapat menggunakan tombol di bawah.
                                    </p>
                                </div>

                                <div class="flex justify-between items-center gap-3 mt-6">
                                    <button type="button"
                                        class="px-5 py-2.5 text-xs font-semibold text-white bg-rose-600 hover:bg-rose-700 rounded-xl shadow-md shadow-rose-200 dark:shadow-none transition duration-200"
                                        onclick="if(confirm('Apakah Anda yakin ingin membatalkan pendaftaran ini? Tindakan ini tidak dapat diurungkan.')) { document.getElementById('cancel-form').submit(); }">
                                        Batalkan Pendaftaran
                                    </button>
                                    <button type="button" @click="showCancelModal = false"
                                        class="px-5 py-2.5 text-xs font-semibold text-gray-600 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 rounded-xl hover:bg-gray-200 dark:hover:bg-gray-600 transition duration-200">
                                        Tutup
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if ($pendingEditRequest)
                        <!-- MODAL LIHAT & BATALKAN PERMINTAAN EDIT -->
                        <div x-show="showCancelRequestModal" x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-200"
                            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                            class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">

                            <div class="fixed inset-0 bg-black/40 backdrop-blur-sm transition-opacity"
                                @click="showCancelRequestModal = false">
                            </div>

                            <div class="flex items-center justify-center min-h-screen p-4">
                                <div
                                    class="relative bg-white dark:bg-gray-800 rounded-2xl max-w-md w-full p-6 shadow-2xl z-10 border border-gray-100 dark:border-gray-700">

                                    <div class="flex justify-between items-center mb-5">
                                        <h3 class="text-base font-bold text-gray-900 dark:text-white">
                                            Status Permintaan Perubahan Data
                                        </h3>
                                        <button @click="showCancelRequestModal = false"
                                            class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                    </div>

                                    <div class="space-y-4">
                                        <div
                                            class="p-4 rounded-xl bg-slate-50 dark:bg-slate-700/50 border border-slate-200 dark:border-slate-700 text-xs">
                                            <p class="font-semibold text-slate-800 dark:text-slate-200 mb-1">Status Saat
                                                Ini: <span
                                                    class="uppercase font-bold text-amber-600 dark:text-amber-400">{{ $pendingEditRequest->latestStatus->status }}</span>
                                            </p>
                                            <p class="text-slate-600 dark:text-slate-400">
                                                Pendaftaran Anda sedang dalam proses verifikasi oleh Admin. Silakan tunggu
                                                atau batalkan pendaftaran untuk mengubah data.
                                            </p>
                                        </div>
                                        <div
                                            class="p-4 rounded-xl bg-slate-50 dark:bg-slate-700/50 border border-slate-200 dark:border-slate-700 text-xs">
                                            <p class="font-semibold text-slate-800 dark:text-slate-200 mb-1">Alasan
                                                Pengajuan Anda:</p>
                                            <p class="text-slate-600 dark:text-slate-400 italic">
                                                "{{ $pendingEditRequest->keterangan }}"
                                            </p>
                                        </div>
                                        <p class="text-xs text-gray-600 dark:text-gray-400">
                                            Jika Anda ingin membatalkan permintaan ini, Anda dapat menggunakan tombol di
                                            bawah.
                                        </p>
                                    </div>

                                    <div class="flex justify-between items-center gap-3 mt-6">
                                        <button type="button"
                                            class="px-5 py-2.5 text-xs font-semibold text-white bg-rose-600 hover:bg-rose-700 rounded-xl shadow-md shadow-rose-200 dark:shadow-none transition duration-200"
                                            onclick="if(confirm('Apakah Anda yakin ingin membatalkan permintaan perubahan data ini?')) { document.getElementById('cancel-request-form').submit(); }">
                                            Batalkan Permintaan
                                        </button>
                                        <button type="button" @click="showCancelRequestModal = false"
                                            class="px-5 py-2.5 text-xs font-semibold text-gray-600 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 rounded-xl hover:bg-gray-200 dark:hover:bg-gray-600 transition duration-200">
                                            Tutup
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <form id="cancel-request-form"
                            action="{{ route('user-anggota.request-edit.destroy', $pendingEditRequest->id) }}"
                            method="POST" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    @endif
                </div>
                {{-- TAMPILAN 2: JIKA USER BELUM MENDAFTAR (LANDING PAGE REGISTRASI) --}}
            @else
                <div class="px-3 md:px-8 py-4 md:py-6 space-y-6 md:space-y-8 max-w-7xl mx-auto">

                    <!-- Hero Section Banner -->
                    <div
                        class="relative overflow-hidden rounded-2xl md:rounded-3xl bg-gradient-to-br from-slate-900 via-indigo-950 to-slate-900 p-6 sm:p-10 md:p-12 text-white shadow-xl md:shadow-2xl border border-slate-800/80 group">
                        <!-- Efek Backdrop Glow & Pattern Dekoratif -->
                        <div
                            class="absolute -right-20 -top-20 w-64 md:w-96 h-64 md:h-96 bg-orange-500/15 rounded-full blur-3xl pointer-events-none transition-all duration-700 group-hover:scale-125">
                        </div>
                        <div
                            class="absolute -left-20 -bottom-20 w-60 md:w-80 h-60 md:h-80 bg-indigo-500/10 rounded-full blur-3xl pointer-events-none">
                        </div>

                        <div class="relative z-10 max-w-2xl space-y-4 md:space-y-5">
                            <span
                                class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-orange-500/20 border border-orange-500/30 text-orange-300 text-[10px] md:text-xs font-semibold tracking-wide uppercase shadow-inner backdrop-blur-md">
                                <i class="fa-solid fa-shield-halved text-orange-400"></i> Keanggotaan Resmi BAKUMDA
                            </span>

                            <h1
                                class="text-2xl sm:text-3xl md:text-5xl font-extrabold leading-[1.2] md:leading-[1.15] tracking-tight text-white">
                                Bergabunglah Bersama Jaringan Masyarakat <span
                                    class="text-transparent bg-clip-text bg-gradient-to-r from-orange-400 to-indigo-300">Hukum
                                    Indonesia</span>
                            </h1>

                            <p class="text-xs sm:text-sm md:text-base text-slate-300 leading-relaxed font-normal">
                                BAKUMDA membuka kesempatan bagi praktisi hukum, akademisi, dan profesional untuk
                                berkontribusi secara nyata dalam memberikan pendampingan hukum dan pengabdian masyarakat.
                            </p>

                            <div class="pt-2 md:pt-3 flex flex-wrap items-center gap-3">
                                <a href="{{ route('user-anggota.create') }}"
                                    class="inline-flex items-center gap-2 px-5 md:px-7 py-3 md:py-3.5 rounded-xl md:rounded-2xl bg-orange-600 hover:bg-orange-500 text-white font-bold text-xs shadow-lg shadow-orange-600/30 transition-all duration-300 hover:scale-[1.03] active:scale-95">
                                    <span>Mulai Pendaftaran Sekarang</span>
                                    <i
                                        class="fa-solid fa-arrow-right text-xs transition-transform duration-300 group-hover:translate-x-1"></i>
                                </a>
                                <a href="#persyaratan"
                                    class="inline-flex items-center gap-2 px-5 md:px-6 py-3 md:py-3.5 rounded-xl md:rounded-2xl bg-slate-800/80 hover:bg-slate-800 text-slate-300 hover:text-white font-semibold text-xs border border-slate-700/80 backdrop-blur-sm transition-all duration-200">
                                    <span>Lihat Persyaratan</span>
                                </a>
                            </div>
                        </div>

                        <!-- Ikon Transparan Besar di Sudut Kanan (Desktop Only) -->
                        <div
                            class="absolute right-6 -bottom-6 opacity-10 hidden lg:block pointer-events-none transition-transform duration-500 group-hover:scale-110">
                            <i class="fa-solid fa-scale-balanced text-[180px]"></i>
                        </div>
                    </div>

                    <!-- Keuntungan / Why Join Us Section -->
                    <div class="space-y-4 md:space-y-6">
                        <div class="text-center max-w-xl mx-auto space-y-1">
                            <h2 class="text-lg sm:text-xl md:text-2xl font-extrabold text-slate-900 tracking-tight">
                                Manfaat & Fasilitas Keanggotaan
                            </h2>
                            <p class="text-xs sm:text-sm text-slate-500">
                                Akses berbagai benefit eksklusif setelah resmi terdaftar sebagai anggota.
                            </p>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 md:gap-6">
                            <!-- Card 1 -->
                            <div
                                class="group p-5 md:p-7 rounded-2xl md:rounded-3xl bg-white border border-slate-200/80 shadow-sm hover:shadow-xl hover:border-orange-500/30 transition-all duration-300 flex flex-col justify-between hover:-translate-y-1">
                                <div class="space-y-3 md:space-y-4">
                                    <div
                                        class="w-12 h-12 md:w-14 md:h-14 rounded-xl md:rounded-2xl bg-orange-50 text-orange-600 flex items-center justify-center text-lg md:text-xl font-bold transition-transform duration-300 group-hover:scale-110 shadow-sm">
                                        <i class="fa-solid fa-id-card"></i>
                                    </div>
                                    <h3 class="font-extrabold text-sm sm:text-base text-slate-900">Kartu Anggota Resmi
                                        (NIA)</h3>
                                    <p class="text-xs text-slate-500 leading-relaxed">
                                        Mendapatkan Nomor Induk Anggota (NIA) resmi serta Kartu Keanggotaan fisik/digital
                                        yang terverifikasi.
                                    </p>
                                </div>
                            </div>

                            <!-- Card 2 -->
                            <div
                                class="group p-5 md:p-7 rounded-2xl md:rounded-3xl bg-white border border-slate-200/80 shadow-sm hover:shadow-xl hover:border-indigo-500/30 transition-all duration-300 flex flex-col justify-between hover:-translate-y-1">
                                <div class="space-y-3 md:space-y-4">
                                    <div
                                        class="w-12 h-12 md:w-14 md:h-14 rounded-xl md:rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-lg md:text-xl font-bold transition-transform duration-300 group-hover:scale-110 shadow-sm">
                                        <i class="fa-solid fa-network-wired"></i>
                                    </div>
                                    <h3 class="font-extrabold text-sm sm:text-base text-slate-900">Jaringan Advokasi Luas
                                    </h3>
                                    <p class="text-xs text-slate-500 leading-relaxed">
                                        Koneksi langsung dengan jejaring advokat, konsultan hukum, serta mitra strategis di
                                        berbagai daerah.
                                    </p>
                                </div>
                            </div>

                            <!-- Card 3 -->
                            <div
                                class="group p-5 md:p-7 rounded-2xl md:rounded-3xl bg-white border border-slate-200/80 shadow-sm hover:shadow-xl hover:border-purple-500/30 transition-all duration-300 flex flex-col justify-between hover:-translate-y-1">
                                <div class="space-y-3 md:space-y-4">
                                    <div
                                        class="w-12 h-12 md:w-14 md:h-14 rounded-xl md:rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center text-lg md:text-xl font-bold transition-transform duration-300 group-hover:scale-110 shadow-sm">
                                        <i class="fa-solid fa-gavel"></i>
                                    </div>
                                    <h3 class="font-extrabold text-sm sm:text-base text-slate-900">Pendampingan & Pelatihan
                                    </h3>
                                    <p class="text-xs text-slate-500 leading-relaxed">
                                        Akses mengikuti bimtek, workshop advokasi, serta keterlibatan dalam penanganan kasus
                                        daerah.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Alur Pendaftaran Section -->
                    <div
                        class="p-5 sm:p-8 md:p-10 rounded-2xl md:rounded-3xl bg-white border border-slate-200/80 shadow-sm space-y-5 md:space-y-6">
                        <div class="space-y-1">
                            <h2
                                class="text-xs sm:text-sm md:text-base font-extrabold text-slate-900 uppercase tracking-wider">
                                Alur Tahapan Pendaftaran
                            </h2>
                            <p class="text-xs sm:text-sm text-slate-500">
                                5 langkah mudah untuk menyelesaikan proses registrasi keanggotaan.
                            </p>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3.5 relative">
                            <div
                                class="p-4 rounded-xl bg-slate-50 border border-slate-100 space-y-2 transition-all hover:bg-slate-100/80">
                                <span
                                    class="inline-block px-2 py-0.5 rounded bg-orange-500/10 text-[11px] font-black text-orange-600 font-mono">01</span>
                                <h4 class="font-extrabold text-xs sm:text-sm text-slate-900">Isi Formulir Online</h4>
                                <p class="text-[11px] sm:text-xs text-slate-500 leading-relaxed">Melengkapi identitas diri
                                    dan informasi domisili secara valid.</p>
                            </div>

                            <div
                                class="p-4 rounded-xl bg-slate-50 border border-slate-100 space-y-2 transition-all hover:bg-slate-100/80">
                                <span
                                    class="inline-block px-2 py-0.5 rounded bg-orange-500/10 text-[11px] font-black text-orange-600 font-mono">02</span>
                                <h4 class="font-extrabold text-xs sm:text-sm text-slate-900">Upload Dokumen</h4>
                                <p class="text-[11px] sm:text-xs text-slate-500 leading-relaxed">Mengunggah scan KTP dan
                                    pas foto terbaru ukuran 3x4.</p>
                            </div>

                            <div
                                class="p-4 rounded-xl bg-slate-50 border border-slate-100 space-y-2 transition-all hover:bg-slate-100/80">
                                <span
                                    class="inline-block px-2 py-0.5 rounded bg-orange-500/10 text-[11px] font-black text-orange-600 font-mono">03</span>
                                <h4 class="font-extrabold text-xs sm:text-sm text-slate-900">Ikuti Pelatihan</h4>
                                <p class="text-[11px] sm:text-xs text-slate-500 leading-relaxed">Wajib mengikuti program
                                    pelatihan yang telah ditentukan.</p>
                            </div>

                            <div
                                class="p-4 rounded-xl bg-slate-50 border border-slate-100 space-y-2 transition-all hover:bg-slate-100/80">
                                <span
                                    class="inline-block px-2 py-0.5 rounded bg-orange-500/10 text-[11px] font-black text-orange-600 font-mono">04</span>
                                <h4 class="font-extrabold text-xs sm:text-sm text-slate-900">Verifikasi Pengurus</h4>
                                <p class="text-[11px] sm:text-xs text-slate-500 leading-relaxed">Tim pengurus akan
                                    memvalidasi kelengkapan berkas Anda.</p>
                            </div>

                            <div
                                class="p-4 rounded-xl bg-slate-50 border border-slate-100 space-y-2 transition-all hover:bg-slate-100/80">
                                <span
                                    class="inline-block px-2 py-0.5 rounded bg-orange-500/10 text-[11px] font-black text-orange-600 font-mono">05</span>
                                <h4 class="font-extrabold text-xs sm:text-sm text-slate-900">Penerbitan KTA</h4>
                                <p class="text-[11px] sm:text-xs text-slate-500 leading-relaxed">Menerima NIA dan Kartu
                                    Tanda Anggota (KTA) BAKUMDA.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Persyaratan & Checklist Section -->
                    <div id="persyaratan"
                        class="p-5 sm:p-8 md:p-10 rounded-2xl md:rounded-3xl bg-white border border-slate-200/80 shadow-sm space-y-4 md:space-y-5">
                        <div class="space-y-1">
                            <h2
                                class="text-xs sm:text-sm md:text-base font-extrabold text-slate-900 uppercase tracking-wider">
                                Dokumen Persyaratan
                            </h2>
                            <p class="text-xs sm:text-sm text-slate-500">
                                Pastikan Anda telah menyiapkan dokumen digital berikut sebelum melanjutkan ke formulir:
                            </p>
                        </div>

                        <ul class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-1 text-xs sm:text-sm text-slate-700">
                            <li class="flex items-center gap-3 p-3 rounded-xl bg-slate-50 border border-slate-100">
                                <i class="fa-solid fa-circle-check text-emerald-500 text-base shrink-0"></i>
                                <span class="font-medium">Kartu Tanda Penduduk (KTP) asli / Scan berwarna</span>
                            </li>
                            <li class="flex items-center gap-3 p-3 rounded-xl bg-slate-50 border border-slate-100">
                                <i class="fa-solid fa-circle-check text-emerald-500 text-base shrink-0"></i>
                                <span class="font-medium">Pas foto formal terbaru latar merah/biru</span>
                            </li>
                            <li class="flex items-center gap-3 p-3 rounded-xl bg-slate-50 border border-slate-100">
                                <i class="fa-solid fa-circle-check text-emerald-500 text-base shrink-0"></i>
                                <span class="font-medium">Alamat e-mail & Nomor WhatsApp aktif</span>
                            </li>
                            <li class="flex items-center gap-3 p-3 rounded-xl bg-slate-50 border border-slate-100">
                                <i class="fa-solid fa-circle-check text-emerald-500 text-base shrink-0"></i>
                                <span class="font-medium">Daftar riwayat hidup singkat / CV (Opsional)</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Bottom Action Card -->
                    <div
                        class="relative overflow-hidden p-6 sm:p-8 rounded-2xl md:rounded-3xl bg-gradient-to-r from-orange-600 via-indigo-600 to-orange-700 text-white shadow-xl flex flex-col sm:flex-row items-center justify-between gap-5">
                        <!-- Dekorasi Background Tipis -->
                        <div
                            class="absolute -right-10 -top-10 w-40 h-40 bg-white/10 rounded-full blur-2xl pointer-events-none">
                        </div>

                        <div class="space-y-1 text-center sm:text-left z-10">
                            <h3 class="text-base sm:text-lg font-extrabold">Sudah Siap Bergabung?</h3>
                            <p class="text-xs sm:text-sm text-white/80">Proses pengisian formulir hanya membutuhkan waktu
                                sekitar 3–5 menit.</p>
                        </div>

                        <a href="{{ route('user-anggota.create') }}"
                            class="z-10 shrink-0 inline-flex items-center gap-2 px-6 py-3.5 rounded-xl bg-white text-orange-700 hover:bg-slate-100 font-extrabold text-xs shadow-lg transition-all duration-300 hover:scale-105 active:scale-95">
                            <span>Lanjut ke Formulir</span>
                            <i class="fa-solid fa-arrow-right text-xs"></i>
                        </a>
                    </div>
                </div>
            @endif

        </div>
    @endsection
