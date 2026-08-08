@extends('layouts.admin')

@section('title', 'Dashboard Saya')

@section('page-title', 'Dashboard Anggota')

@section('page-subtitle')
    Selamat datang kembali, <span
        class="font-semibold text-brand-600 dark:text-brand-400">{{ Auth::user()->name ?? 'Anggota' }}</span>! Berikut
    ringkasan status keanggotaan dan aktivitas akun Anda.
@endsection

@php
    // $anggota is passed from DashboardController
    // Handle case where $anggota might be null (e.g., user has 'Anggota' role but no Anggota record yet)
    $anggotaInstance = $anggota ?? null;

    $anggotaCard = $anggotaInstance ? $anggotaInstance->card : null;
    $statusHistory = collect(); // Initialize as empty collection
    $latestStatusRecord = null;
    $latestBerlaku = null;

    if ($anggotaCard) {
        $anggotaCard->load('latestBerlaku');
        $latestBerlaku = $anggotaCard->latestBerlaku;
        // Fetch the last 3 statuses for history
        $statusHistory = \App\Models\AnggotaStatus::where('anggota_card_id', $anggotaCard->id)
            ->orderBy('id', 'desc')
            ->take(3)
            ->get();
        // The latest record is the first in the collection
        $latestStatusRecord = $statusHistory->first();
    }

    // Determine current status
    $currentStatus = 'belum mengajukan'; // Default if no Anggota record or card
    if ($anggotaInstance) {
        if ($latestStatusRecord) {
            $currentStatus = strtolower($latestStatusRecord->status);
        } elseif ($anggotaCard && $anggotaCard->status) {
            // Fallback to AnggotaCard status if no AnggotaStatus records
            $currentStatus = strtolower($anggotaCard->status);
        } else {
            // If Anggota record exists but no card or status, assume 'proses'
            $currentStatus = 'proses';
        }
    }

    $isAktif = $currentStatus === 'aktif' || $currentStatus === 'active';
    $isBelumMengajukan = $currentStatus === 'belum mengajukan';

    // Cek status cetak fisik kartu (assuming AnggotaCard has an 'is_printed' column)
    $isPrinted = $anggotaCard && ($anggotaCard->is_printed ?? false);

    // Contoh pengambilan data Sertifikasi (Sesuaikan dengan relasi/model Anda, misal: $anggotaInstance->sertifikasis)
    $sertifikasiCount = 0;
    if ($anggotaInstance && method_exists($anggotaInstance, 'sertifikasis')) {
        $sertifikasiCount = $anggotaInstance->sertifikasis()->count();
    }

    // Profile Completion Calculation based on Anggota model fields
    $completedFields = 0;
    $totalFields = 14; // Essential fields: nama, no_ktp, alamat, no_hp, email, jenis_kelamin, tempat_lahir, tanggal_lahir, agama, status_perkawinan, pekerjaan, kewarganegaraan, foto, foto_ktp

    if ($anggotaInstance) {
        if (!empty($anggotaInstance->nama)) {
            $completedFields++;
        }
        if (!empty($anggotaInstance->no_ktp)) {
            $completedFields++;
        }
        if (!empty($anggotaInstance->alamat)) {
            $completedFields++;
        }
        if (!empty($anggotaInstance->no_hp)) {
            $completedFields++;
        }
        if (!empty($anggotaInstance->email)) {
            $completedFields++;
        }
        if (!empty($anggotaInstance->jenis_kelamin)) {
            $completedFields++;
        }
        if (!empty($anggotaInstance->tempat_lahir)) {
            $completedFields++;
        }
        if (!empty($anggotaInstance->tanggal_lahir)) {
            $completedFields++;
        }
        if (!empty($anggotaInstance->agama)) {
            $completedFields++;
        }
        if (!empty($anggotaInstance->status_perkawinan)) {
            $completedFields++;
        }
        if (!empty($anggotaInstance->pekerjaan)) {
            $completedFields++;
        }
        if (!empty($anggotaInstance->kewarganegaraan)) {
            $completedFields++;
        }
        if (!empty($anggotaInstance->foto)) {
            $completedFields++;
        }
        if (!empty($anggotaInstance->foto_ktp)) {
            $completedFields++;
        }
    }

    $percentage = $totalFields > 0 ? intval(($completedFields / $totalFields) * 100) : 0;
@endphp

@section('page-actions')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 w-full">
        <!-- Indikator Waktu & Tanggal Real-Time Lokal -->
        <a href="#" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-gradient-to-r from-brand-600 to-indigo-600 hover:from-brand-700 hover:to-indigo-700 text-white font-medium text-xs shadow-md shadow-brand-500/20 transition-all duration-200 hover:-translate-y-0.5">
            <i class="fa-solid fa-clock text-xs"></i>
           <span>{{ now()->format('d M Y') }}</span>
        </a>
    </div>
    @push('scripts')
        <script>
            function updateClock() {
                const now = new Date();

                // Format tanggal dan waktu otomatis menyesuaikan lokasi/timezone perangkat user (Bahasa Indonesia)
                const options = {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric',

                    hour12: false
                };

                const timeString = now.toLocaleDateString('id-ID', options).replace(/\./g, ':');
                const clockElement = document.getElementById('realtime-clock');

                if (clockElement) {
                    clockElement.textContent = timeString;
                }
            }

            // Jalankan saat pertama kali dimuat
            updateClock();

            // Perbarui setiap 1 detik
            setInterval(updateClock, 1000);
        </script>
    @endpush
@endsection

@section('content')
    <div class="space-y-6">

        <!-- Welcome Modern Gradient Banner with Floating Elements -->
        <div
            class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-brand-600 via-indigo-600 to-purple-700 p-6 sm:p-8 text-white shadow-xl shadow-brand-500/10">
            <div class="relative z-10 max-w-2xl">
                <span
                    class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full bg-white/20 backdrop-blur-md text-xs font-semibold tracking-wide uppercase mb-4 shadow-inner">
                    @if ($isAktif)
                        <i class="fa-solid fa-circle-check text-emerald-300"></i> Keanggotaan Aktif
                    @elseif($isBelumMengajukan)
                        <i class="fa-solid fa-circle-question text-slate-200"></i> Belum Mengajukan
                    @else
                        <i class="fa-solid fa-clock text-amber-300"></i> Dalam Verifikasi Admin
                    @endif
                </span>
                <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight leading-tight">
                    Halo, {{ Auth::user()->name }}! 👋
                </h2>
                <p class="text-xs sm:text-sm text-white/90 mt-2.5 leading-relaxed">
                    @if ($isAktif)
                        Kartu anggota digital Anda aktif dan siap digunakan. Pastikan data diri dan informasi profil selalu
                        diperbarui untuk mendapatkan layanan terbaik.
                    @elseif($isBelumMengajukan)
                        Anda belum melakukan pengajuan kartu anggota. Silakan lengkapi profil terlebih dahulu lalu ajukan
                        permohonan keanggotaan Anda.
                    @else
                        Akun dan data diri Anda sedang dalam proses peninjauan oleh tim admin. Mohon menunggu hingga status
                        keanggotaan disetujui.
                    @endif
                </p>

                <div class="mt-6 flex flex-wrap gap-3">
                    <!-- Trigger Modal Panduan Layanan -->
                    <button type="button" onclick="openPanduanModal()"
                        class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white/10 hover:bg-white/25 backdrop-blur-md text-white font-semibold text-xs transition-all duration-200 border border-white/15 cursor-pointer">
                        <i class="fa-solid fa-circle-info"></i> Panduan Layanan
                    </button>
                </div>
            </div>
            <!-- Decorative Glow Blur & Pattern -->
            <div class="absolute -right-12 -bottom-12 w-72 h-72 bg-white/10 rounded-full blur-3xl pointer-events-none">
            </div>
            <div
                class="absolute right-12 top-1/2 -translate-y-1/2 hidden md:block opacity-15 transform rotate-12 scale-125 pointer-events-none">
                <i class="fa-solid fa-scale-balanced text-[180px]"></i>
            </div>
        </div>

        <!-- Quick Stats Cards Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">

            <!-- Stat Card 1: Status Akun -->
            <div
                class="p-5 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200/70 dark:border-slate-800 shadow-sm hover:shadow-md transition-all duration-200 group">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Status Akun</span>
                    <div
                        class="w-11 h-11 rounded-2xl {{ $isAktif ? 'bg-emerald-50 text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-400' : ($isBelumMengajukan ? 'bg-slate-100 text-slate-500 dark:bg-slate-800 dark:text-slate-400' : 'bg-amber-50 text-amber-600 dark:bg-amber-500/10 dark:text-amber-400') }} flex items-center justify-center transition-transform group-hover:scale-110">
                        <i
                            class="fa-solid {{ $isAktif ? 'fa-user-check' : ($isBelumMengajukan ? 'fa-circle-question' : 'fa-hourglass-half') }} text-base"></i>
                    </div>
                </div>
                <div class="mt-4">
                    <h3 class="text-xl font-extrabold text-slate-800 dark:text-slate-100 flex items-center gap-2">
                        {{ ucwords($currentStatus) }}
                        @if ($isAktif)
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                        @endif
                    </h3>
                    <p class="text-xs text-slate-400 font-medium mt-1.5 flex items-center gap-1.5">
                        <span>Masa berlaku:</span>
                        <span class="text-slate-700 dark:text-slate-200 font-semibold">
                            @if ($isAktif && $latestBerlaku)
                                {{ $latestBerlaku->berlaku->format('d M Y') }}
                            @elseif($isBelumMengajukan)
                                Belum ada pengajuan
                            @else
                                Menunggu Aktivasi
                            @endif
                        </span>
                    </p>
                </div>
            </div>

            <!-- Stat Card 2: ID Anggota -->
            <div
                class="p-5 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200/70 dark:border-slate-800 shadow-sm hover:shadow-md transition-all duration-200 group">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Nomor KTPA</span>
                    <div
                        class="w-11 h-11 rounded-2xl bg-brand-50 text-brand-600 dark:bg-brand-500/10 dark:text-brand-400 flex items-center justify-center transition-transform group-hover:scale-110">
                        <i class="fa-solid fa-hashtag text-base"></i>
                    </div>
                </div>
                <div class="mt-4">
                    <h3 class="text-xl font-extrabold text-slate-800 dark:text-slate-100 tracking-wide font-mono">
                        {{ $anggotaCard->card_id ?? 'Belum Tersedia' }}
                    </h3>
                    <p class="text-xs text-slate-400 font-medium mt-1.5">
                        Terdaftar sejak <span
                            class="text-slate-700 dark:text-slate-200 font-semibold">{{ $anggotaInstance ? $anggotaInstance->created_at->format('M Y') : '-' }}</span>
                    </p>
                </div>
            </div>

            <!-- Stat Card 3: Sertifikasi -->
            <div
                class="p-5 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200/70 dark:border-slate-800 shadow-sm hover:shadow-md transition-all duration-200 group">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Sertifikat</span>
                    <div
                        class="w-11 h-11 rounded-2xl bg-purple-50 text-purple-600 dark:bg-purple-500/10 dark:text-purple-400 flex items-center justify-center transition-transform group-hover:scale-110">
                        <i class="fa-solid fa-certificate text-base"></i>
                    </div>
                </div>
                <div class="mt-4">
                    @php
                        $user = Auth::user(); // Pastikan $user sudah terdefinisi
                        // Hitung jumlah sertifikat yang dimiliki user
                        $jumlahSertifikat = \App\Models\Sertifikat::whereHas('nilai', function ($query) use ($user) {
                            $query->whereHas('pelatihanAnggota', function ($subQuery) use ($user) {
                                $subQuery->where('users_id', $user->id);
                            });
                        })->count();
                        $displaySertifikat = $jumlahSertifikat;
                    @endphp

                    <h3 class="text-xl font-extrabold text-slate-800 dark:text-slate-100">
                        {{ $displaySertifikat }} <span class="text-xs font-medium text-slate-500">Sertifikat</span>
                    </h3>
                    <p class="text-xs text-purple-600 dark:text-purple-400 font-semibold mt-1.5 flex items-center gap-1">
                        <i class="fa-solid fa-circle-check text-[10px]"></i> Status kompetensi aktif
                    </p>
                </div>
            </div>

            <!-- Stat Card 4: Catatan Admin -->
            <div
                class="p-5 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200/70 dark:border-slate-800 shadow-sm hover:shadow-md transition-all duration-200 group">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Catatan Admin</span>
                    <div
                        class="w-11 h-11 rounded-2xl bg-amber-50 text-amber-600 dark:bg-amber-500/10 dark:text-amber-400 flex items-center justify-center transition-transform group-hover:scale-110">
                        <i class="fa-solid fa-note-sticky text-base"></i>
                    </div>
                </div>
                <div class="mt-4">
                    <h3 class="text-sm font-bold text-slate-800 dark:text-slate-100 line-clamp-1">
                        {{ $latestStatusRecord->keterangan ?? ($anggotaInstance->keterangan ?? 'Tidak ada catatan khusus') }}
                    </h3>
                    <p class="text-xs text-amber-500 dark:text-amber-400 font-semibold mt-1.5 flex items-center gap-1">
                        <i class="fa-solid fa-circle-info text-[10px]"></i> Pembaruan terakhir
                    </p>
                </div>
            </div>

        </div>

        <!-- Main Content Section -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- Left Side: Quick Actions & Riwayat (2 Cols) -->
            <div class="lg:col-span-2 space-y-6">

                <!-- Quick Actions Grid -->
                <div
                    class="p-6 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200/70 dark:border-slate-800 shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-xs font-extrabold text-slate-400 dark:text-slate-400 uppercase tracking-wider">
                            Akses Cepat Layanan
                        </h3>
                    </div>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3.5">

                        <!-- Menu 1: KTPA Digital -->
                        <a href="{{ $isAktif && $anggotaCard ? route('user-anggota.index', $anggotaCard->id) : '#' }}"
                            class="p-4 rounded-2xl bg-slate-50/80 hover:bg-brand-50/60 dark:bg-slate-800/40 dark:hover:bg-slate-800/80 border border-slate-100/80 dark:border-slate-800/80 text-center group transition-all duration-200">
                            <div
                                class="w-12 h-12 mx-auto rounded-2xl bg-brand-500/10 text-brand-600 dark:text-brand-400 flex items-center justify-center group-hover:scale-110 transition-transform shadow-sm">
                                <i class="fa-solid fa-address-card text-lg"></i>
                            </div>
                            <span class="block text-xs font-bold text-slate-700 dark:text-slate-200 mt-3">KTPA
                                Digital</span>
                        </a>

                        <!-- Menu 2: Pelatihan -->
                        <a href="{{ route('user-pelatihan.index') }}"
                            class="p-4 rounded-2xl bg-slate-50/80 hover:bg-purple-50/60 dark:bg-slate-800/40 dark:hover:bg-slate-800/80 border border-slate-100/80 dark:border-slate-800/80 text-center group transition-all duration-200">
                            <div
                                class="w-12 h-12 mx-auto rounded-2xl bg-purple-500/10 text-purple-600 dark:text-purple-400 flex items-center justify-center group-hover:scale-110 transition-transform shadow-sm">
                                <i class="fa-solid fa-graduation-cap text-lg"></i>
                            </div>
                            <span class="block text-xs font-bold text-slate-700 dark:text-slate-200 mt-3">Pelatihan</span>
                        </a>

                        <!-- Menu 3: Sertifikat -->
                        <a href="{{ route('sertifikat.index') }}"
                            class="p-4 rounded-2xl bg-slate-50/80 hover:bg-indigo-50/60 dark:bg-slate-800/40 dark:hover:bg-slate-800/80 border border-slate-100/80 dark:border-slate-800/80 text-center group transition-all duration-200">
                            <div
                                class="w-12 h-12 mx-auto rounded-2xl bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 flex items-center justify-center group-hover:scale-110 transition-transform shadow-sm">
                                <i class="fa-solid fa-award text-lg"></i>
                            </div>
                            <span class="block text-xs font-bold text-slate-700 dark:text-slate-200 mt-3">Sertifikat</span>
                        </a>



                    </div>
                </div>

                <!-- Activity / Request History -->
                <div
                    class="p-6 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200/70 dark:border-slate-800 shadow-sm">
                    <div class="flex items-center justify-between mb-5">
                        <h3 class="text-xs font-extrabold text-slate-400 dark:text-slate-400 uppercase tracking-wider">
                            Riwayat & Status Permohonan
                        </h3>
                        <span
                            class="inline-flex items-center gap-1.5 text-xs font-bold text-brand-600 dark:text-brand-400 bg-brand-50 dark:bg-brand-500/10 px-2.5 py-1 rounded-full">
                            <i class="fa-solid fa-clock-rotate-left text-[10px]"></i> Log Aktivitas
                        </span>
                    </div>

                    <div class="space-y-3">
                        @forelse($statusHistory as $status)
                            @php
                                $statusLower = strtolower($status->status);
                                $isApproved = in_array($statusLower, ['aktif', 'active', 'approved']);
                                $isRejected = in_array($statusLower, ['ditolak', 'rejected']);

                                $bgColor = $isApproved
                                    ? 'bg-emerald-500/10'
                                    : ($isRejected
                                        ? 'bg-rose-500/10'
                                        : 'bg-amber-500/10');
                                $textColor = $isApproved
                                    ? 'text-emerald-600 dark:text-emerald-400'
                                    : ($isRejected
                                        ? 'text-rose-600 dark:text-rose-400'
                                        : 'text-amber-600 dark:text-amber-400');
                                $icon = $isApproved ? 'fa-check' : ($isRejected ? 'fa-xmark' : 'fa-hourglass-half');
                            @endphp
                            <div
                                class="flex items-center justify-between p-4 rounded-2xl bg-slate-50/70 dark:bg-slate-800/30 border border-slate-100 dark:border-slate-800/80 hover:bg-slate-100/60 dark:hover:bg-slate-800/60 transition-colors">
                                <div class="flex items-center gap-3.5">
                                    <div
                                        class="w-10 h-10 rounded-xl {{ $bgColor }} {{ $textColor }} flex items-center justify-center shrink-0 shadow-sm">
                                        <i class="fa-solid {{ $icon }} text-xs font-bold"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-slate-800 dark:text-slate-200">
                                            {{ $status->keterangan ?? 'Pembaruan status keanggotaan' }}</p>
                                        <p class="text-[11px] text-slate-400 mt-0.5">
                                            {{ $status->created_at->isoFormat('D MMM Y, HH:mm') }}</p>
                                    </div>
                                </div>
                                <span
                                    class="text-[11px] px-3 py-1 rounded-full {{ $bgColor }} {{ $textColor }} font-bold tracking-wide uppercase">
                                    {{ ucfirst($status->status) }}
                                </span>
                            </div>
                        @empty
                            <div
                                class="flex items-center justify-between p-4 rounded-2xl bg-slate-50/70 dark:bg-slate-800/30 border border-slate-100 dark:border-slate-800/80">
                                <div class="flex items-center gap-3.5">
                                    <div
                                        class="w-10 h-10 rounded-xl bg-slate-500/10 text-slate-500 flex items-center justify-center shrink-0">
                                        <i class="fa-solid fa-circle-question text-xs"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-slate-800 dark:text-slate-200">Pengajuan
                                            Keanggotaan</p>
                                        <p class="text-[11px] text-slate-400 mt-0.5">Belum ada riwayat permohonan atau
                                            pengajuan yang tercatat.</p>
                                    </div>
                                </div>
                                <span
                                    class="text-[11px] px-3 py-1 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 font-bold">Belum
                                    Ada</span>
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>

            <!-- Right Side Panel: Profile Completion & CS Support (1 Col) -->
            <div class="space-y-6">

                <!-- Profile Progress Card -->
                <div
                    class="p-6 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200/70 dark:border-slate-800 shadow-sm">
                    <h3 class="text-xs font-extrabold text-slate-400 dark:text-slate-400 uppercase tracking-wider mb-4">
                        Kelengkapan Profil
                    </h3>

                    <div class="flex items-center justify-between text-xs font-bold mb-2">
                        <span class="text-slate-700 dark:text-slate-200">{{ $percentage }}% Terisi</span>
                        <span
                            class="text-brand-600 dark:text-brand-400">{{ $percentage > 70 ? 'Hampir Lengkap' : 'Perlu Dilengkapi' }}</span>
                    </div>
                    <!-- Progress Bar with Smooth Transition -->
                    <div class="w-full h-2.5 rounded-full bg-slate-100 dark:bg-slate-800 overflow-hidden mb-4 p-0.5">
                        <div class="h-full bg-gradient-to-r from-brand-500 to-indigo-600 rounded-full transition-all duration-500"
                            style="width: {{ $percentage }}%"></div>
                    </div>

                    <div
                        class="p-3.5 rounded-2xl bg-amber-50/80 dark:bg-amber-500/10 border border-amber-200/70 dark:border-amber-500/20 text-amber-900 dark:text-amber-300 text-xs leading-relaxed flex items-start gap-3">
                        <i class="fa-solid fa-triangle-exclamation text-amber-500 text-base mt-0.5 shrink-0"></i>
                        <div>
                            <span class="font-bold block mb-0.5">Validasi Data Diri</span>
                            <p class="text-[11px] text-amber-700/90 dark:text-amber-300/80 leading-relaxed">Pastikan nomor
                                telepon dan dokumen KTP Anda sudah sesuai pada menu pengaturan profil.</p>
                        </div>
                    </div>
                </div>

                <!-- Help / Support Panel -->
                <div
                    class="p-6 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200/70 dark:border-slate-800 shadow-sm flex flex-col justify-between">
                    <div>
                        <div
                            class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-400 flex items-center justify-center mb-4 shadow-sm">
                            <i class="fa-solid fa-headset text-lg"></i>
                        </div>
                        <h3
                            class="text-xs font-extrabold text-slate-400 dark:text-slate-400 uppercase tracking-wider mb-1">
                            Pusat Bantuan
                        </h3>
                        <h4 class="text-sm font-bold text-slate-900 dark:text-white mb-2">Butuh Bantuan Kendala Akun?</h4>
                        <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">
                            Jika terdapat kendala pada data keanggotaan atau proses pencetakan kartu fisik, silakan hubungi
                            tim layanan bantuan kami.
                        </p>
                    </div>

                    <div class="mt-6 pt-4 border-t border-slate-100 dark:border-slate-800">
                        <a href="https://wa.me/628123456789" target="_blank"
                            class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs transition-all duration-200 shadow-lg shadow-emerald-600/25 hover:scale-[1.01] active:scale-[0.99]">
                            <i class="fa-brands fa-whatsapp text-base"></i>
                            <span>Hubungi Admin via WhatsApp</span>
                        </a>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <!-- MODAL PANDUAN LAYANAN & ATURAN KEANGGOTAAN -->
    <div id="panduanModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-300">
        <div class="bg-white dark:bg-slate-900 rounded-3xl max-w-lg w-full mx-4 shadow-2xl border border-slate-100 dark:border-slate-800 transform scale-95 transition-transform duration-300 overflow-hidden" id="panduanModalContainer">
            
            <!-- Modal Header -->
            <div class="px-6 py-5 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between bg-slate-50/50 dark:bg-slate-800/50">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-brand-500/10 text-brand-600 dark:text-brand-400 flex items-center justify-center">
                        <i class="fa-solid fa-circle-info text-base"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-extrabold text-slate-900 dark:text-white uppercase tracking-wider">Panduan Layanan</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Ketentuan dan Syarat Keanggotaan</p>
                    </div>
                </div>
                <button type="button" onclick="closePanduanModal()" class="w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 flex items-center justify-center transition-colors">
                    <i class="fa-solid fa-xmark text-sm"></i>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-6 space-y-4 max-h-[70vh] overflow-y-auto">
                <div class="p-4 rounded-2xl bg-brand-50/50 dark:bg-brand-500/10 border border-brand-100 dark:border-brand-500/20 text-xs text-brand-900 dark:text-brand-200 leading-relaxed">
                    <span class="font-bold block mb-1">Selamat Datang di Portal Anggota!</span>
                    Untuk menjaga kualitas serta kredibilitas organisasi, setiap calon anggota wajib mematuhi alur dan ketentuan resmi yang berlaku.
                </div>

                <h4 class="text-xs font-extrabold text-slate-400 dark:text-slate-400 uppercase tracking-wider pt-2">Aturan Wajib Menjadi Anggota:</h4>

                <ul class="space-y-3 text-xs text-slate-600 dark:text-slate-300">
                    <li class="flex items-start gap-3 p-3 rounded-2xl bg-slate-50 dark:bg-slate-800/40 border border-slate-100 dark:border-slate-800">
                        <div class="w-6 h-6 rounded-full bg-purple-500/10 text-purple-600 dark:text-purple-400 flex items-center justify-center shrink-0 mt-0.5 font-bold">1</div>
                        <div>
                            <strong class="text-slate-900 dark:text-white block mb-0.5">Wajib Mengikuti Pelatihan</strong>
                            Setiap pendaftar atau calon anggota diwajibkan untuk mendaftar dan mengikuti program pelatihan yang telah disediakan oleh sistem organisasi melalui menu Pelatihan.
                        </div>
                    </li>

                    <li class="flex items-start gap-3 p-3 rounded-2xl bg-slate-50 dark:bg-slate-800/40 border border-slate-100 dark:border-slate-800">
                        <div class="w-6 h-6 rounded-full bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 flex items-center justify-center shrink-0 mt-0.5 font-bold">2</div>
                        <div>
                            <strong class="text-slate-900 dark:text-white block mb-0.5">Wajib Lulus Pelatihan</strong>
                            Kelulusan dalam pelatihan merupakan syarat mutlak. Permohonan status keanggotaan dan penerbitan Kartu Tanda Pengenal Anggota (KTPA) hanya akan diproses setelah peserta dinyatakan <strong class="text-emerald-600 dark:text-emerald-400 font-semibold">Lulus</strong> dan memperoleh sertifikat kompetensi.
                        </div>
                    </li>

                    <li class="flex items-start gap-3 p-3 rounded-2xl bg-slate-50 dark:bg-slate-800/40 border border-slate-100 dark:border-slate-800">
                        <div class="w-6 h-6 rounded-full bg-brand-500/10 text-brand-600 dark:text-brand-400 flex items-center justify-center shrink-0 mt-0.5 font-bold">3</div>
                        <div>
                            <strong class="text-slate-900 dark:text-white block mb-0.5">Kelengkapan Data Diri</strong>
                            Pastikan Anda melengkapi formulir profil dengan data yang valid (termasuk nomor KTP dan foto resmi) agar proses verifikasi berjalan lancar oleh admin.
                        </div>
                    </li>
                </ul>
            </div>

            <!-- Modal Footer -->
            <div class="px-6 py-4 border-t border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/50 flex justify-end gap-2">
                <button type="button" onclick="closePanduanModal()" class="px-5 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs transition-colors shadow-sm">
                    Saya Mengerti
                </button>
            </div>
        </div>
    </div>

    <!-- Script untuk Interaksi Modal -->
    @push('scripts')
    <script>
        function openPanduanModal() {
            const modal = document.getElementById('panduanModal');
            const container = document.getElementById('panduanModalContainer');
            modal.classList.remove('opacity-0', 'pointer-events-none');
            container.classList.remove('scale-95');
            container.classList.add('scale-100');
        }

        function closePanduanModal() {
            const modal = document.getElementById('panduanModal');
            const container = document.getElementById('panduanModalContainer');
            modal.classList.add('opacity-0', 'pointer-events-none');
            container.classList.remove('scale-100');
            container.classList.add('scale-95');
        }

        // Tutup modal ketika klik area luar (backdrop)
        window.addEventListener('click', function(e) {
            const modal = document.getElementById('panduanModal');
            if (e.target === modal) {
                closePanduanModal();
            }
        });
    </script>
    @endpush
@endsection