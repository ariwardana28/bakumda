@extends('layouts.app')

@section('title', 'Verifikasi Sertifikat')

@section('content')
    <div class="max-w-2xl mx-auto py-10" x-data="qrScanner()">
        <div
            class="bg-white/80 dark:bg-slate-900/80 backdrop-blur-2xl rounded-3xl shadow-xl shadow-slate-200/50 dark:shadow-none border border-slate-200/80 dark:border-slate-800 p-8 sm:p-12 text-center space-y-6">

            <div class="relative w-20 h-20 mx-auto flex items-center justify-center">
                <div class="absolute inset-0 rounded-2xl bg-orange-500/20 blur-xl"></div>
                <div
                    class="relative w-20 h-20 rounded-2xl bg-gradient-to-br from-orange-500 to-amber-600 text-white flex items-center justify-center text-3xl shadow-lg shadow-orange-500/30">
                    <i class="fa-solid fa-award"></i>
                </div>
            </div>

            <div class="space-y-2">
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-white tracking-tight">
                    Verifikasi Keaslian Sertifikat
                </h1>
                <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 leading-relaxed max-w-md mx-auto">
                    Pilih metode verifikasi di bawah untuk memeriksa validitas dan detail kelulusan sertifikat.
                </p>
            </div>

            @if (session('error'))
                <div
                    class="p-3 rounded-xl bg-rose-50 border border-rose-200 text-rose-700 dark:bg-rose-900/30 dark:border-rose-800 dark:text-rose-400 text-xs font-medium text-left">
                    {{ session('error') }}
                </div>
            @endif

            {{-- TAHAP 1: 2 TOMBOL BESAR UTAMA (Scan QR Code di Atas, Input Manual di Bawah) --}}
            <div x-show="tab === 'menu'" x-transition:enter="transition ease-out duration-300" class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                
                {{-- Tombol Pilihan 1: Scan QR Code (Di Atas) --}}
                <button @click="changeTab('scan')"
                    class="group p-6 rounded-2xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-800 hover:border-orange-500/50 hover:bg-orange-50/40 transition-all duration-300 text-center flex flex-col items-center justify-center shadow-sm hover:shadow-md">
                    <div class="w-14 h-14 rounded-2xl bg-orange-100 dark:bg-orange-950/50 border border-orange-200 dark:border-orange-900 flex items-center justify-center text-orange-600 dark:text-orange-400 mb-4 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-qrcode text-2xl"></i>
                    </div>
                    <h3 class="font-bold text-slate-900 dark:text-white text-sm mb-1 uppercase tracking-wider">Scan QR Code</h3>
                    <p class="text-[11px] text-slate-500 dark:text-slate-400">Gunakan kamera untuk memindai QR sertifikat.</p>
                </button>

                {{-- Tombol Pilihan 2: Input Nomor Sertifikat (Di Bawah) --}}
                <button @click="changeTab('manual')"
                    class="group p-6 rounded-2xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-800 hover:border-orange-500/50 hover:bg-orange-50/40 transition-all duration-300 text-center flex flex-col items-center justify-center shadow-sm hover:shadow-md">
                    <div class="w-14 h-14 rounded-2xl bg-orange-100 dark:bg-orange-950/50 border border-orange-200 dark:border-orange-900 flex items-center justify-center text-orange-600 dark:text-orange-400 mb-4 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-keyboard text-2xl"></i>
                    </div>
                    <h3 class="font-bold text-slate-900 dark:text-white text-sm mb-1 uppercase tracking-wider">Nomor Sertifikat</h3>
                    <p class="text-[11px] text-slate-500 dark:text-slate-400">Input nomor unik sertifikat secara manual.</p>
                </button>

            </div>

            {{-- TAHAP 2A: Manual Input Form (Muncul saat tab === 'manual') --}}
            <div x-show="tab === 'manual'" x-cloak x-transition:enter="transition ease-out duration-300" class="text-left space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-800">
                    <span class="text-xs font-bold uppercase tracking-wider text-orange-600 dark:text-orange-400 flex items-center gap-2">
                        <i class="fa-solid fa-keyboard"></i> Masukkan Nomor Sertifikat
                    </span>
                    <button @click="changeTab('menu')" class="text-xs text-slate-500 hover:text-slate-800 dark:hover:text-slate-200 flex items-center gap-1 transition-colors">
                        <i class="fa-solid fa-arrow-left"></i> Kembali
                    </button>
                </div>

                <form action="{{ route('sertifikat.cek.submit') }}" method="POST" id="manual-form" class="pt-2 space-y-4">
                    @csrf
                    <div class="relative">
                        <input id="no_sertifikat" type="text" name="no_sertifikat" value="{{ old('no_sertifikat') }}" required
                            placeholder="Contoh: CERT-65D5B1-2024"
                            class="w-full text-center px-6 py-4 text-sm rounded-2xl bg-slate-50 dark:bg-slate-800/60 text-slate-800 dark:text-slate-100 border border-slate-200 dark:border-slate-800 focus:border-orange-500/50 focus:ring-2 focus:ring-orange-500/20 outline-none transition-all">
                        @error('no_sertifikat')
                            <span class="text-[10px] text-rose-500 mt-1 block text-center">{{ $message }}</span>
                        @enderror
                    </div>
                    <button type="submit"
                        class="w-full inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-xl bg-orange-600 hover:bg-orange-700 text-white font-bold text-sm shadow-lg shadow-orange-600/25 transition-all duration-200 hover:scale-[1.02]">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <span>Cek Sertifikat</span>
                    </button>
                </form>
            </div>

            {{-- TAHAP 2B: QR Code Scanner (Muncul saat tab === 'scan') --}}
            <div x-show="tab === 'scan'" x-cloak x-transition:enter="transition ease-out duration-300" class="text-left space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-800">
                    <span class="text-xs font-bold uppercase tracking-wider text-orange-600 dark:text-orange-400 flex items-center gap-2">
                        <i class="fa-solid fa-qrcode"></i> Scan QR Code Sertifikat
                    </span>
                    <button @click="changeTab('menu')" class="text-xs text-slate-500 hover:text-slate-800 dark:hover:text-slate-200 flex items-center gap-1 transition-colors">
                        <i class="fa-solid fa-arrow-left"></i> Kembali
                    </button>
                </div>

                <div class="relative rounded-2xl overflow-hidden border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-800/60 p-2 shadow-sm">
                    <div id="qr-reader" class="w-full rounded-xl overflow-hidden"></div>
                </div>
                <div id="qr-reader-results" class="text-center"></div>
                <p class="text-center text-xs text-slate-500 dark:text-slate-400 flex items-center justify-center gap-2">
                    <i class="fa-solid fa-camera text-orange-500 animate-pulse"></i>
                    Posisikan QR Code sertifikat di dalam area pemindai kamera.
                </p>
            </div>

        </div>
    </div>
@endsection

@push('scripts')
    <!-- Pustaka untuk QR Scanner -->
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

    <script>
        function qrScanner() {
            return {
                tab: 'menu',
                scanner: null,
                init() {
                    this.scanner = new Html5Qrcode("qr-reader");
                },
                changeTab(newTab) {
                    this.tab = newTab;
                    if (newTab === 'scan') {
                        this.startScanner();
                    } else {
                        this.stopScanner();
                    }
                },
                startScanner() {
                    const config = { fps: 10, qrbox: { width: 250, height: 250 } };
                    const onScanSuccess = (decodedText, decodedResult) => {
                        console.log(`Scan result: ${decodedText}`, decodedResult);
                        
                        try {
                            const url = new URL(decodedText);
                            const pathParts = url.pathname.split('/');
                            const certNumber = pathParts.pop() || pathParts.pop();

                            if (certNumber) {
                                document.getElementById('no_sertifikat').value = certNumber;
                                document.getElementById('manual-form').submit();
                                this.stopScanner();
                            }
                        } catch (e) {
                            console.error("Bukan URL valid atau format tidak sesuai:", e);
                            document.getElementById('no_sertifikat').value = decodedText;
                            document.getElementById('manual-form').submit();
                            this.stopScanner();
                        }
                    };
                    this.scanner.start({ facingMode: "environment" }, config, onScanSuccess).catch(err => {
                        console.error("Gagal memulai kamera scanner:", err);
                    });
                },
                stopScanner() {
                    if (this.scanner && this.scanner.isScanning) {
                        this.scanner.stop().catch(err => console.error("Gagal menghentikan scanner:", err));
                    }
                }
            }
        }
    </script>
@endpush