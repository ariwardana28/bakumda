@extends('layouts.app') {{-- Sesuaikan dengan layout utama Anda --}}

@section('content')
    <div class="container mx-auto px-4 py-10 md:py-16">
        <div class="max-w-xl mx-auto bg-white/95 dark:bg-slate-900/95 backdrop-blur-2xl border border-blue-100 dark:border-slate-800 rounded-3xl shadow-2xl shadow-blue-500/10 dark:shadow-none overflow-hidden text-slate-800 dark:text-slate-100 relative transition-all duration-300"
            x-data="qrScanner()">

            {{-- Aksen Glow Halus Latar Belakang (Biru) --}}
            <div class="absolute -top-20 -right-20 w-64 h-64 bg-blue-500/10 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-20 -left-20 w-64 h-64 bg-sky-500/10 rounded-full blur-3xl pointer-events-none"></div>

            <div class="px-6 sm:px-8 py-8 md:py-10 relative z-10">

                {{-- Header Judul --}}
                <div class="text-center mb-8">
                    <div class="w-16 h-16 mx-auto mb-4 bg-blue-50 dark:bg-blue-950/50 border border-blue-200/60 dark:border-blue-800/50 rounded-2xl flex items-center justify-center text-blue-600 dark:text-blue-400 shadow-sm relative group">
                        <div class="absolute inset-0 bg-blue-500/20 rounded-2xl blur-md opacity-0 group-hover:opacity-100 transition duration-300"></div>
                        <i class="fa-solid fa-qrcode text-3xl relative z-10"></i>
                    </div>
                    <h2 class="text-2xl sm:text-3xl font-black tracking-tight text-slate-900 dark:text-white mb-2">
                        Validasi Data
                    </h2>
                    <p class="text-slate-500 dark:text-slate-400 text-xs sm:text-sm max-w-sm mx-auto leading-relaxed">
                        Pilih salah satu metode verifikasi di bawah untuk memeriksa keabsahan kartu anggota atau sertifikat.
                    </p>
                </div>

                {{-- Alert Error --}}
                @if (session('error'))
                    <div class="bg-rose-50 dark:bg-rose-950/40 border border-rose-200/80 dark:border-rose-900/50 text-rose-600 dark:text-rose-400 px-4 py-3.5 rounded-2xl relative mb-6 text-xs flex items-center gap-3 shadow-sm animate-bounce"
                        role="alert">
                        <div class="w-8 h-8 rounded-xl bg-rose-100 dark:bg-rose-900/60 flex items-center justify-center shrink-0">
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
                    class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                    {{-- Tombol Pilihan 1: Scan QR Code --}}
                    <button @click="changeTab('scan')"
                        class="group p-6 rounded-2xl bg-white dark:bg-slate-800/40 border border-blue-100 dark:border-slate-800 hover:border-blue-500/50 hover:bg-gradient-to-b hover:from-blue-50/50 hover:to-white dark:hover:from-blue-950/20 dark:hover:to-transparent transition-all duration-300 text-center flex flex-col items-center justify-center shadow-sm hover:shadow-lg hover:shadow-blue-500/10 relative overflow-hidden">
                        <div class="w-14 h-14 rounded-2xl bg-blue-50 dark:bg-blue-950/60 border border-blue-200/60 dark:border-blue-800/60 flex items-center justify-center text-blue-600 dark:text-blue-400 mb-4 group-hover:scale-110 group-hover:rotate-3 transition-all duration-300 shadow-inner">
                            <i class="fa-solid fa-id-card text-2xl"></i>
                        </div>
                        <h3 class="font-extrabold text-slate-900 dark:text-white text-sm mb-1 uppercase tracking-wider group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                            Scan Kartu Anggota
                        </h3>
                        <p class="text-[11px] text-slate-500 dark:text-slate-400 leading-relaxed">
                            Gunakan kamera untuk memindai QR Code pada Kartu Anggota (KTPA).
                        </p>
                    </button>

                    {{-- Tombol Pilihan 2: Input Nomor Sertifikat Manual --}}
                    <button @click="changeTab('manual')"
                        class="group p-6 rounded-2xl bg-white dark:bg-slate-800/40 border border-blue-100 dark:border-slate-800 hover:border-blue-500/50 hover:bg-gradient-to-b hover:from-blue-50/50 hover:to-white dark:hover:from-blue-950/20 dark:hover:to-transparent transition-all duration-300 text-center flex flex-col items-center justify-center shadow-sm hover:shadow-lg hover:shadow-blue-500/10 relative overflow-hidden">
                        <div class="w-14 h-14 rounded-2xl bg-blue-50 dark:bg-blue-950/60 border border-blue-200/60 dark:border-blue-800/60 flex items-center justify-center text-blue-600 dark:text-blue-400 mb-4 group-hover:scale-110 group-hover:-rotate-3 transition-all duration-300 shadow-inner">
                            <i class="fa-solid fa-award text-2xl"></i>
                        </div>
                        <h3 class="font-extrabold text-slate-900 dark:text-white text-sm mb-1 uppercase tracking-wider group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                            Nomor Sertifikat
                        </h3>
                        <p class="text-[11px] text-slate-500 dark:text-slate-400 leading-relaxed">
                            Cek validasi dengan memasukkan nomor sertifikat secara manual.
                        </p>
                    </button>

                </div>

                {{-- TAHAP 2A: Manual Input Form --}}
                <div x-show="tab === 'manual'" x-cloak x-transition:enter="transition ease-out duration-300"
                    class="space-y-4">
                    <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-800">
                        <span class="text-xs font-bold uppercase tracking-wider text-blue-600 dark:text-blue-400 flex items-center gap-2">
                            <i class="fa-solid fa-keyboard"></i> Masukkan Nomor Sertifikat
                        </span>
                        <button @click="changeTab('menu')"
                            class="text-xs text-slate-500 hover:text-slate-800 dark:hover:text-slate-200 flex items-center gap-1 transition-colors font-medium">
                            <i class="fa-solid fa-arrow-left text-[10px]"></i> Kembali
                        </button>
                    </div>

                    <form action="{{ route('sertifikat.cek.submit') }}" method="POST" id="manual-form" class="pt-2 space-y-4">
                        @csrf
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-blue-400">
                                <i class="fa-solid fa-barcode text-sm"></i>
                            </div>
                            <input id="no_sertifikat" type="text" name="no_sertifikat" value="{{ old('no_sertifikat') }}"
                                required placeholder="Contoh: CERT-XXXX-YYYY"
                                class="w-full pl-11 pr-4 py-3.5 text-center sm:text-left text-sm rounded-2xl bg-blue-50/30 dark:bg-slate-800/60 text-slate-800 dark:text-slate-100 border border-blue-200/80 dark:border-slate-700/80 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition-all duration-200 font-semibold tracking-wider placeholder:font-normal">
                            @error('no_sertifikat')
                                <span class="text-[10px] text-rose-500 mt-1.5 block text-center sm:text-left font-medium">{{ $message }}</span>
                            @enderror
                        </div>
                        <button type="submit"
                            class="w-full inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-2xl bg-gradient-to-r from-blue-600 via-blue-500 to-sky-500 hover:from-blue-700 hover:to-sky-600 text-white font-black text-xs uppercase tracking-wider shadow-lg shadow-blue-500/25 transition-all duration-200 transform hover:-translate-y-0.5 active:scale-95">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <span>Cek Validasi Sertifikat</span>
                        </button>
                    </form>
                </div>

                {{-- TAHAP 2B: QR Code Scanner --}}
                <div x-show="tab === 'scan'" x-cloak x-transition:enter="transition ease-out duration-300"
                    class="space-y-4">
                    <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-800">
                        <span class="text-xs font-bold uppercase tracking-wider text-blue-600 dark:text-blue-400 flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-blue-500 animate-ping"></span>
                            Pemindai Kamera Aktif
                        </span>
                        <button @click="changeTab('menu')"
                            class="text-xs text-slate-500 hover:text-slate-800 dark:hover:text-slate-200 flex items-center gap-1 transition-colors font-medium">
                            <i class="fa-solid fa-arrow-left text-[10px]"></i> Kembali
                        </button>
                    </div>

                    <div class="relative rounded-3xl overflow-hidden border border-blue-100 dark:border-slate-800 bg-slate-900 p-2 shadow-inner group">
                        <form action="{{ route('kartu-anggota.cek.submit') }}" method="POST" id="qr-form" class="hidden">
                            @csrf
                            <input type="text" name="card_id" id="qr_card_id">
                        </form>
                        
                        <div id="qr-reader" class="w-full rounded-2xl overflow-hidden [&_video]:rounded-2xl [&_video]:object-cover"></div>
                    </div>
                    
                    <div id="qr-reader-results" class="text-center"></div>
                    
                    <div class="bg-blue-50 dark:bg-blue-950/30 border border-blue-200/60 dark:border-blue-800/40 rounded-2xl p-3 text-center">
                        <p class="text-xs text-blue-600 dark:text-blue-400 font-medium flex items-center justify-center gap-2">
                            <i class="fa-solid fa-camera animate-pulse"></i>
                            Posisikan QR Code di dalam area pemindai.
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('scripts')
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
                                width: 240,
                                height: 240
                            }
                        };

                        await this.stopScanner();

                        await this.scanner.start({
                                facingMode: "environment"
                            },
                            config,
                            (decodedText) => {
                                this.stopScanner();
                                const input = document.getElementById('qr_card_id');
                                if (input) {
                                    input.value = decodedText;
                                    document.getElementById('qr-form').submit();
                                }
                            },
                            (errorMessage) => {}
                        );
                    } catch (err) {
                        console.error("Gagal memulai kamera:", err);

                        let errorMsg = "Gagal mengakses kamera.";
                        if (location.protocol !== 'https:' && location.hostname !== 'localhost' && location.hostname !== '127.0.0.1') {
                            errorMsg = "Akses kamera memerlukan protokol HTTPS! Silakan gunakan HTTPS.";
                        } else {
                            errorMsg = "Izin kamera ditolak atau perangkat tidak mendeteksi kamera belakang. Pastikan Anda mengizinkan akses kamera di pengaturan browser.";
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