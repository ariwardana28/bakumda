<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BAKUMDA | Balai Bantuan Hukum Daerah</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            --legal-navy: #0a192f;
            --legal-navy-light: #1e293b;
            --gold-accent: #c5a059;
            --gold-hover: #b08d46;
        }

        body {
            font-family: 'Inter', sans-serif;
            color: #334155;
            background-color: #f8fafc;
        }

        h1, h2, h3, h4, h5 {
            font-family: 'Playfair Display', serif;
        }

        /* Hero & Section Styling */
        .hero-legal {
            background: linear-gradient(135deg, var(--legal-navy) 0%, var(--legal-navy-light) 100%);
            color: #ffffff;
            padding: 100px 0;
            border-bottom: 4px solid var(--gold-accent);
        }

        /* Professional Cards */
        .feature-card {
            border: 1px solid #e2e8f0;
            border-top: 4px solid var(--legal-navy);
            transition: all 0.4s ease;
        }

        .feature-card:hover {
            border-top-color: var(--gold-accent);
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(10, 25, 47, 0.08);
        }

        /* UI Elements & Buttons */
        .btn-gold {
            background-color: var(--gold-accent);
            color: white;
            border: none;
            padding: 10px 24px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-gold:hover {
            background-color: var(--gold-hover);
            color: white;
        }

        .text-gold {
            color: var(--gold-accent);
        }

        /* 3D Card Perspective Utilities */
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
</head>

<body class="d-flex flex-column min-vh-100">

    <!-- Navbar Formal & Modern -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white py-3 shadow-sm sticky-top border-bottom border-slate-100">
        <div class="container">
            <a class="navbar-brand fw-bold text-uppercase tracking-wider fs-4" href="#">
                <span class="text-gold font-serif">BAKUM</span><span style="color: var(--legal-navy);">DA</span>
            </a>
            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center gap-2">
                    <li class="nav-item"><a class="nav-link fw-medium text-slate-700 px-3" href="#profil">Profil</a></li>
                    <li class="nav-item"><a class="nav-link fw-medium text-slate-700 px-3" href="#layanan">Layanan</a></li>
                    <li class="nav-item"><a class="nav-link fw-medium text-slate-700 px-3" href="#regulasi">Regulasi</a></li>
                    <li class="nav-item ps-lg-3">
                        <a class="btn btn-sm px-4 py-2 rounded-pill font-semibold text-white shadow-sm" style="background-color: var(--legal-navy);" href="{{ route('login') }}">
                            <i class="fa-solid fa-lock me-1.5 text-xs text-gold"></i> Login Anggota
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    @php
        if (!isset($anggotaCard) && isset($anggota)) {
            $anggotaCard = $anggota->card;
        }

        $pendingEditRequest = $anggota->pendingEditRequest ?? null;
        $latestStatusRecord = $anggota->latest_status ?? ($anggotaCard->latestStatus ?? null);

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

        $catatanAdmin = $latestStatusRecord ? $latestStatusRecord->keterangan : $anggota->catatan_admin ?? '';
    @endphp

    <!-- Main Content Container -->
    <main class="flex-grow-1 container py-5">
        <div class="max-w-7xl mx-auto" x-data="{
            showEditModal: false,
            showCancelModal: false,
            showCancelRequestModal: false
        }">

            {{-- KONDISI KHUSUS: JIKA STATUS AKTIF / APPROVED DAN ADA CARD --}}
            @if ($currentStatus === 'aktif' && isset($anggotaCard))
                <div class="space-y-6" x-data="{ zoomCard: false }">

                    @if (session('success'))
                        <div class="p-4 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-700 dark:text-emerald-400 text-xs font-medium flex items-center gap-3 backdrop-blur-md shadow-sm mb-4">
                            <i class="fa-solid fa-circle-check text-base"></i>
                            <span>{{ session('success') }}</span>
                        </div>
                    @endif

                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start" x-data="{ isFlipped: false }">

                        <!-- KIRI: PREVIEW KARTU FISIK (Col 5) -->
                        <div class="lg:col-span-5">
                            <div class="bg-white/90 backdrop-blur-xl p-6 rounded-3xl border border-slate-200 shadow-xl shadow-slate-200/50 text-center space-y-6">

                                <div class="flex items-center justify-between px-1">
                                    <h3 class="text-xs uppercase tracking-wider font-bold text-slate-500 flex items-center gap-2">
                                        <i class="fa-solid fa-id-card text-gold"></i>
                                        <span>Pratinjau Kartu Anggota</span>
                                    </h3>
                                    <span class="text-[10px] font-bold px-3 py-1 rounded-full bg-[#c5a059]/10 text-[#c5a059] border border-[#c5a059]/20 shadow-inner"
                                        x-text="isFlipped ? 'Sisi Belakang' : 'Sisi Depan'"></span>
                                </div>

                                <!-- Wrapper Utama dengan Efek Perspektif -->
                                <div class="relative w-[280px] h-[480px] mx-auto perspective-1000">

                                    <!-- Kartu Flipper (Kontainer yang Berputar) -->
                                    <div class="relative w-full h-full duration-700 transform-style-3d transition-transform"
                                        :class="{ 'rotate-y-180': isFlipped }">

                                        <!-- SISI DEPAN KARTU -->
                                        <div class="absolute inset-0 w-full h-full rounded-2xl shadow-xl border border-slate-200 bg-white backface-hidden overflow-hidden transform-style-3d">
                                            <img src="{{ asset('background.png') }}" class="absolute inset-0 w-full h-full object-cover">

                                            <div class="relative z-10 w-full h-full">
                                                <!-- Foto -->
                                                <div class="absolute top-[190px] left-[50px] w-[95px] h-[129px] overflow-hidden rounded-sm flex items-center justify-center bg-slate-900 shadow-inner">
                                                    @if (optional($anggotaCard->anggota)->foto)
                                                        <img src="{{ asset('storage/' . optional($anggotaCard->anggota)->foto) }}" class="w-full h-full object-cover">
                                                    @else
                                                        <div class="flex flex-col items-center justify-center text-slate-400">
                                                            <i class="fa-solid fa-user text-3xl"></i>
                                                            <span class="text-[8px] mt-1 font-medium">Tanpa Foto</span>
                                                        </div>
                                                    @endif
                                                </div>

                                                <!-- QR Code + NIA -->
                                                <div class="absolute top-[205px] left-[152px] w-[80px] flex flex-col items-center">
                                                    <div class="w-[78px] h-[78px] bg-white p-1 rounded shadow-sm border border-slate-100 flex items-center justify-center">
                                                        @if ($anggotaCard->qr_code)
                                                            <img src="{{ asset('storage/' . $anggotaCard->qr_code) }}" class="w-full h-full object-contain">
                                                        @else
                                                            <div class="text-[8px] text-slate-400 text-center leading-tight font-medium">Belum<br>Terbit</div>
                                                        @endif
                                                    </div>
                                                    @if ($anggotaCard->card_id)
                                                        <span class="text-[8px] font-bold text-slate-900 font-mono tracking-tight mt-1 whitespace-nowrap">
                                                            {{ $anggotaCard->card_id }}
                                                        </span>
                                                    @endif
                                                </div>

                                                <!-- Nama & Jabatan -->
                                                <div class="absolute top-[342px] inset-x-0 px-4 text-center">
                                                    <h2 class="text-[11px] font-extrabold text-slate-900 uppercase tracking-tight leading-snug">
                                                        {{ optional($anggotaCard->anggota)->nama }}
                                                    </h2>
                                                    @if (!empty(optional($anggotaCard->latestBerlaku)->jabatan))
                                                        <p class="text-[9.5px] font-bold text-slate-700 uppercase tracking-wider mt-0.5">
                                                            {{ optional($anggotaCard->latestBerlaku)->jabatan }}
                                                        </p>
                                                    @endif
                                                </div>

                                                <!-- Masa Berlaku -->
                                                @if (!empty(optional($anggotaCard->latestBerlaku)->berlaku))
                                                    <div class="absolute bottom-[20px] left-[18px]">
                                                        <p class="text-[8px] font-bold text-slate-900 font-sans">
                                                            Berlaku s/d {{ \Carbon\Carbon::parse(optional($anggotaCard->latestBerlaku)->berlaku)->translatedFormat('d F Y') }}
                                                        </p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <!-- SISI BELAKANG KARTU -->
                                        <div class="absolute inset-0 w-full h-full rounded-2xl shadow-xl border border-slate-200 bg-white backface-hidden rotate-y-180 overflow-hidden transform-style-3d">
                                            <img src="{{ asset('belakang.png') }}" class="absolute inset-0 w-full h-full object-cover">

                                            <div class="relative z-10 w-full h-full">
                                                <div class="absolute top-[100px] left-[30px] pr-4 text-left">
                                                    <p class="text-[9px] font-bold text-slate-900 font-mono tracking-wide">
                                                        {{-- NIK/Identitas Tambahan --}}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <!-- Tombol Aksi Kartu -->
                                <div class="pt-2 flex flex-col gap-2.5">
                                    <button type="button" @click="isFlipped = !isFlipped"
                                        class="w-full px-4 py-2.5 text-xs font-bold rounded-xl bg-[#c5a059]/10 text-[#c5a059] hover:bg-[#c5a059]/20 border border-[#c5a059]/30 transition duration-200 flex items-center justify-center gap-2 shadow-sm">
                                        <i class="fa-solid fa-rotate transition-transform duration-500" :class="{ 'rotate-180': isFlipped }"></i>
                                        <span x-text="isFlipped ? 'Lihat Sisi Depan Kartu' : 'Putar ke Sisi Belakang'"></span>
                                    </button>

                                    <div class="grid grid-cols-2 gap-2">
                                        <button type="button" @click="zoomCard = true"
                                            class="px-3 py-2.5 text-xs font-bold rounded-xl border border-slate-200 bg-white text-slate-700 hover:bg-slate-50 transition duration-200 flex items-center justify-center gap-2 shadow-xs">
                                            <i class="fa-solid fa-magnifying-glass-plus text-[#c5a059]"></i>
                                            <span>Perbesar</span>
                                        </button>

                                        <a href="{{ route('admin.anggota-card.download', $anggotaCard->id) }}" target="_blank"
                                            class="px-3 py-2.5 text-xs font-bold rounded-xl text-white transition duration-200 flex items-center justify-center gap-2 shadow-md" style="background-color: var(--legal-navy);">
                                            <i class="fa-solid fa-download"></i>
                                            <span>Unduh Kartu</span>
                                        </a>
                                    </div>
                                </div>

                                <p class="text-[10px] text-slate-400 text-center font-medium">Tekan tombol putar atau perbesar untuk melihat detail kartu secara utuh.</p>
                            </div>
                        </div>

                        <!-- KANAN: INFORMASI LENGKAP KARTU (Col 7) -->
                        <div class="lg:col-span-7 space-y-6">
                            <div class="bg-white/90 backdrop-blur-xl p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-xl shadow-slate-200/50 space-y-6">

                                <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                                    <h3 class="text-sm font-black text-slate-900 flex items-center gap-2.5 font-serif">
                                        <div class="w-8 h-8 rounded-xl bg-emerald-500/10 text-emerald-600 flex items-center justify-center">
                                            <i class="fa-solid fa-shield-halved text-base"></i>
                                        </div>
                                        <span>Informasi Lengkap Kartu Anggota</span>
                                    </h3>
                                    <span class="px-3 py-1 text-[10px] font-bold bg-emerald-50 text-emerald-600 rounded-full border border-emerald-200">
                                        Aktif & Terverifikasi
                                    </span>
                                </div>

                                <!-- Grid Detail Informasi -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5 text-xs">
                                    <div class="bg-slate-50/80 p-3.5 rounded-2xl border border-slate-100">
                                        <span class="block text-slate-400 font-medium mb-1 text-[10px] uppercase tracking-wider">Nama Lengkap</span>
                                        <span class="font-bold text-slate-900 uppercase">{{ $anggotaCard->anggota->nama ?? '-' }}</span>
                                    </div>

                                    <div class="bg-slate-50/80 p-3.5 rounded-2xl border border-slate-100">
                                        <span class="block text-slate-400 font-medium mb-1 text-[10px] uppercase tracking-wider">Nomor Induk Anggota (NIA)</span>
                                        <span class="font-bold text-[#c5a059] font-mono text-[11.5px]">{{ $anggotaCard->card_id ?? '-' }}</span>
                                    </div>

                                    <div class="bg-slate-50/80 p-3.5 rounded-2xl border border-slate-100">
                                        <span class="block text-slate-400 font-medium mb-1 text-[10px] uppercase tracking-wider">Jabatan</span>
                                        <span class="font-bold text-slate-800">{{ optional($anggotaCard->latestBerlaku)->jabatan ?? '-' }}</span>
                                    </div>

                                    <div class="bg-slate-50/80 p-3.5 rounded-2xl border border-slate-100">
                                        <span class="block text-slate-400 font-medium mb-1 text-[10px] uppercase tracking-wider">Tanggal Diterbitkan</span>
                                        <span class="font-semibold text-slate-800">
                                            {{ optional($anggotaCard->latestBerlaku)->diterbitkan ? \Carbon\Carbon::parse(optional($anggotaCard->latestBerlaku)->diterbitkan)->translatedFormat('d F Y') : '-' }}
                                        </span>
                                    </div>

                                    <div class="bg-slate-50/80 p-3.5 rounded-2xl border border-slate-100 sm:col-span-2">
                                        <span class="block text-slate-400 font-medium mb-1 text-[10px] uppercase tracking-wider">Masa Berlaku Kartu</span>
                                        <span class="font-semibold text-slate-800">
                                            {{ optional($anggotaCard->latestBerlaku)->berlaku ? \Carbon\Carbon::parse(optional($anggotaCard->latestBerlaku)->berlaku)->translatedFormat('d F Y') : '-' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- MODAL PERBESAR (ZOOM) KARTU ANGGOTA -->
                    <div x-show="zoomCard" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;"
                        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

                        <div class="fixed inset-0 bg-slate-950/80 backdrop-blur-md transition-opacity" @click="zoomCard = false"></div>

                        <div class="flex items-center justify-center min-h-screen p-4 sm:p-6">
                            <div class="relative bg-white/95 backdrop-blur-2xl rounded-3xl p-6 sm:p-8 shadow-2xl z-10 max-w-md w-full flex flex-col items-center border border-slate-200">

                                <div class="flex justify-between items-center w-full mb-4 border-b border-slate-100 pb-3">
                                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-900 flex items-center gap-2 font-serif">
                                        <i class="fa-solid fa-expand text-[#c5a059]"></i>
                                        <span>Pratinjau Kartu Anggota</span>
                                    </h3>
                                    <button @click="zoomCard = false"
                                        class="w-8 h-8 rounded-xl bg-slate-100 text-slate-400 hover:text-slate-700 flex items-center justify-center transition-colors">
                                        <i class="fa-solid fa-xmark text-sm"></i>
                                    </button>
                                </div>

                                <div class="relative w-[280px] h-[480px] rounded-2xl overflow-hidden shadow-2xl border border-slate-200 my-2 bg-white">
                                    <img src="{{ asset('background.png') }}" class="absolute inset-0 w-full h-full object-cover z-0" alt="Background ID Card">
                                    <div class="relative z-10 w-full h-full">
                                        <div class="absolute top-[201px] left-[50px] w-[95px] h-[129px] overflow-hidden rounded-md flex items-center justify-center bg-slate-900 shadow-inner">
                                            @if ($anggotaCard->anggota->foto ?? false)
                                                <img src="{{ asset('storage/' . $anggotaCard->anggota->foto) }}" class="w-full h-full object-cover">
                                            @else
                                                <div class="flex flex-col items-center justify-center text-slate-300">
                                                    <i class="fa-solid fa-user text-3xl"></i>
                                                    <span class="text-[8px] mt-1 font-medium">Tanpa Foto</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            @else
                <div class="p-8 bg-white/90 backdrop-blur-xl rounded-3xl border border-slate-200 shadow-xl text-center space-y-4 max-w-lg mx-auto my-12">
                    <div class="w-14 h-14 rounded-2xl bg-amber-500/10 text-amber-600 flex items-center justify-center mx-auto text-xl shadow-inner">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                    </div>
                    <h3 class="text-base font-bold text-slate-900 font-serif">Kartu Identitas Anggota Belum Tersedia</h3>
                    <p class="text-xs text-slate-500 max-w-sm mx-auto leading-relaxed">Kartu anggota Anda belum diterbitkan oleh sistem atau akun Anda sedang dalam status peninjauan administratif.</p>
                </div>
            @endif

        </div>
    </main>

    <!-- Footer Formal -->
    <footer class="bg-slate-900 text-white py-4 mt-auto border-t border-slate-800 text-center text-xs">
        <div class="container">
            <p class="text-slate-400 mb-0">&copy; {{ date('Y') }} <span class="text-gold font-semibold">BAKUMDA</span>. Seluruh Hak Cipta Dilindungi Undang-Undang.</p>
        </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>

</html>