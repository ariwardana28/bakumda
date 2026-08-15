@extends('layouts.app') {{-- Sesuaikan dengan layout utama Anda --}}

@section('content')
    <div class="container mx-auto px-4 py-12">
        <div class="max-w-xl mx-auto bg-white/90 dark:bg-slate-900/90 backdrop-blur-2xl border border-slate-200/80 dark:border-slate-800 rounded-3xl shadow-2xl shadow-slate-300/50 dark:shadow-none overflow-hidden text-slate-800 dark:text-slate-100 relative"
            x-data="qrScanner()">

            {{-- Aksen Glow Halus & Pola Abstrak Latar Belakang --}}
            <div class="absolute -top-16 -right-16 w-56 h-56 bg-orange-500/10 rounded-full blur-3xl pointer-events-none">
            </div>
            <div class="absolute -bottom-16 -left-16 w-56 h-56 bg-amber-500/10 rounded-full blur-3xl pointer-events-none">
            </div>

            <div class="px-6 sm:px-8 py-8 relative z-10">

                {{-- Header Judul --}}
                <div class="text-center mb-8">
                    <div
                        class="w-14 h-14 mx-auto mb-3.5 bg-orange-50 dark:bg-orange-950/50 border border-orange-200/60 dark:border-orange-800/50 rounded-2xl flex items-center justify-center text-orange-600 dark:text-orange-400 shadow-sm">
                        <i class="fa-solid fa-qrcode text-2xl"></i>
                    </div>
                    <h2 class="text-2xl font-black tracking-tight text-slate-900 dark:text-white mb-2">Validasi Data</h2>
                    <p class="text-slate-500 dark:text-slate-400 text-xs sm:text-sm">Silakan pilih salah satu metode
                        verifikasi di bawah untuk melanjutkan.</p>
                </div>

                {{-- Alert Error --}}
                @if (session('error'))
                    <div class="bg-rose-50 dark:bg-rose-950/50 border border-rose-200 dark:border-rose-900/50 text-rose-600 dark:text-rose-400 px-4 py-3.5 rounded-2xl relative mb-6 text-xs flex items-center gap-3 shadow-sm animate-shake"
                        role="alert">
                        <div
                            class="w-8 h-8 rounded-xl bg-rose-100 dark:bg-rose-900/50 flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-triangle-exclamation text-rose-600 dark:text-rose-400"></i>
                        </div>
                        <div>
                            <strong class="font-bold block uppercase tracking-wider text-[10px]">Gagal Verifikasi</strong>
                            <span>{{ session('error') }}</span>
                        </div>
                    </div>
                @endif

                {{-- TAHAP 1: 2 TOMBOL BESAR UTAMA --}}
                <div x-show="tab === 'menu'" x-transition:enter="transition ease-out duration-300"
                    class="grid grid-cols-1 sm:grid-cols-2 gap-4 my-2">

                    {{-- Tombol Pilihan 1: Scan QR Code --}}
                    <button @click="changeTab('scan')"
                        class="group p-6 rounded-2xl bg-slate-50/80 dark:bg-slate-800/40 border border-slate-200/80 dark:border-slate-800 hover:border-orange-500/50 hover:bg-orange-50/40 dark:hover:bg-orange-950/20 transition-all duration-300 text-center flex flex-col items-center justify-center shadow-xs hover:shadow-md">
                        <div
                            class="w-14 h-14 rounded-2xl bg-orange-100 dark:bg-orange-950/60 border border-orange-200/60 dark:border-orange-800/60 flex items-center justify-center text-orange-600 dark:text-orange-400 mb-4 group-hover:scale-110 transition-transform shadow-2xs">
                            <i class="fa-solid fa-qrcode text-xl"></i>
                        </div>
                        <h3 class="font-bold text-slate-900 dark:text-white text-sm mb-1 uppercase tracking-wider">Scan QR
                            Code</h3>
                        <p class="text-[11px] text-slate-500 dark:text-slate-400">Gunakan kamera untuk memindai QR
                            sertifikat.</p>
                    </button>

                    {{-- Tombol Pilihan 2: Input Nomor Sertifikat --}}
                    <button @click="changeTab('manual')"
                        class="group p-6 rounded-2xl bg-slate-50/80 dark:bg-slate-800/40 border border-slate-200/80 dark:border-slate-800 hover:border-orange-500/50 hover:bg-orange-50/40 dark:hover:bg-orange-950/20 transition-all duration-300 text-center flex flex-col items-center justify-center shadow-xs hover:shadow-md">
                        <div
                            class="w-14 h-14 rounded-2xl bg-orange-100 dark:bg-orange-950/60 border border-orange-200/60 dark:border-orange-800/60 flex items-center justify-center text-orange-600 dark:text-orange-400 mb-4 group-hover:scale-110 transition-transform shadow-2xs">
                            <i class="fa-solid fa-id-card text-2xl"></i>
                        </div>
                        <h3 class="font-bold text-slate-900 dark:text-white text-sm mb-1 uppercase tracking-wider">Nomor
                            Kartu</h3>
                        <p class="text-[11px] text-slate-500 dark:text-slate-400">Input nomor kartu anggota secara manual.
                        </p>
                    </button>

                </div>

                {{-- TAHAP 2A: Manual Input Form --}}
                <div x-show="tab === 'manual'" x-cloak x-transition:enter="transition ease-out duration-300"
                    class="space-y-4">
                    <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-800">
                        <span
                            class="text-xs font-bold uppercase tracking-wider text-orange-600 dark:text-orange-400 flex items-center gap-2">
                            <i class="fa-solid fa-keyboard"></i> Masukkan Nomor Kartu Anggota
                        </span>
                        <button @click="changeTab('menu')"
                            class="text-xs text-slate-500 hover:text-slate-800 dark:hover:text-slate-200 flex items-center gap-1 transition-colors">
                            <i class="fa-solid fa-arrow-left"></i> Kembali
                        </button>
                    </div>

                    <form action="{{ route('kartu-anggota.cek.submit') }}" method="POST" id="manual-form"
                        class="pt-2 space-y-4">
                        @csrf
                        <div class="relative">
                            <input id="card_id" type="text" name="card_id" value="{{ old('card_id') }}" required
                                placeholder="Contoh: KTPA.2024.0001"
                                class="w-full text-center px-6 py-4 text-sm rounded-2xl bg-slate-50 dark:bg-slate-800/60 text-slate-800 dark:text-slate-100 border border-slate-200 dark:border-slate-700/80 focus:border-orange-500/50 focus:ring-2 focus:ring-orange-500/20 outline-none transition-all">
                            @error('card_id')
                                <span
                                    class="text-[10px] text-rose-500 mt-1.5 block text-center font-medium">{{ $message }}</span>
                            @enderror
                        </div>
                        <button type="submit"
                            class="w-full inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-xl bg-orange-600 hover:bg-orange-700 text-white font-bold text-xs uppercase tracking-wider shadow-lg shadow-orange-600/25 transition-all duration-200 hover:scale-[1.02] active:scale-[0.98]">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <span>Cek Kartu Anggota</span>
                        </button>
                    </form>
                </div>

                {{-- TAHAP 2B: QR Code Scanner --}}
                <div x-show="tab === 'scan'" x-cloak x-transition:enter="transition ease-out duration-300"
                    class="space-y-4">
                    <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-800">
                        <span
                            class="text-xs font-bold uppercase tracking-wider text-orange-600 dark:text-orange-400 flex items-center gap-2">
                            <i class="fa-solid fa-qrcode"></i> Scan QR Code
                        </span>
                        <button @click="changeTab('menu')"
                            class="text-xs text-slate-500 hover:text-slate-800 dark:hover:text-slate-200 flex items-center gap-1 transition-colors">
                            <i class="fa-solid fa-arrow-left"></i> Kembali
                        </button>
                    </div>

                    <div
                        class="relative rounded-2xl overflow-hidden border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-800/40 p-2 shadow-inner">
                        <div id="qr-reader" class="w-full rounded-xl overflow-hidden"></div>
                    </div>
                    <div id="qr-reader-results" class="text-center"></div>
                    <p
                        class="text-center text-xs text-slate-500 dark:text-slate-400 flex items-center justify-center gap-2">
                        <i class="fa-solid fa-camera text-orange-500 animate-pulse"></i>
                        Posisikan QR Code sertifikat di dalam area pemindai kamera.
                    </p>
                </div>

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

                changeTab(newTab) {
                    if (this.tab === 'scan' && newTab !== 'scan') {
                        this.stopScanner();
                    }

                    this.tab = newTab;

                    if (newTab === 'scan') {
                        this.$nextTick(() => {
                            this.startScanner();
                        });
                    }
                },

                async startScanner() {
                    try {
                        if (!this.scanner) {
                            this.scanner = new Html5Qrcode("qr-reader");
                        }

                        const config = {
                            fps: 10,
                            qrbox: {
                                width: 250,
                                height: 250
                            }
                        };

                        await this.stopScanner();

                        await this.scanner.start({
                                facingMode: "environment"
                            },
                            config,
                            (decodedText) => {
                                this.stopScanner();
                                const input = document.getElementById('card_id');
                                if (input) {
                                    input.value = decodedText;
                                    document.getElementById('manual-form').submit();
                                }
                            },
                            (errorMessage) => {
                                // Error saat proses scanning frame (normal diabaikan)
                            }
                        );
                    } catch (err) {
                        console.error("Gagal memulai kamera:", err);

                        // Deteksi spesifik penyebab error kamera
                        let errorMsg = "Gagal mengakses kamera.";
                        if (location.protocol !== 'https:' && location.hostname !== 'localhost' && location.hostname !==
                            '127.0.0.1') {
                            errorMsg = "Akses kamera memerlukan protokol HTTPS! Silakan gunakan HTTPS.";
                        } else {
                            errorMsg =
                                "Izin kamera ditolak atau perangkat tidak mendeteksi kamera belakang. Pastikan Anda mengizinkan akses kamera di pengaturan browser.";
                        }

                        alert(errorMsg);
                    }
                },

                async stopScanner() {
                    if (this.scanner && this.scanner.isScanning) {
                        try {
                            await this.scanner.stop();
                            await this.scanner.clear();
                        } catch (err) {
                            console.error("Gagal menghentikan scanner:", err);
                        }
                    }
                }
            }
        }
    </script>
@endpush
