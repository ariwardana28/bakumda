@extends('layouts.app') {{-- Sesuaikan dengan layout utama Anda --}}

@section('content')
    <div class="container mx-auto px-4 py-12">
        <div class="max-w-xl mx-auto bg-white border border-slate-200 rounded-3xl shadow-xl overflow-hidden text-slate-800 relative"
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
                        class="w-12 h-12 mx-auto mb-3 bg-orange-100 border border-orange-200 rounded-2xl flex items-center justify-center text-orange-600 shadow-sm">
                        <i class="fa-solid fa-id-card text-xl"></i>
                    </div>
                    <h2 class="text-2xl font-black tracking-tight text-slate-900 mb-2">Verifikasi Kartu Anggota</h2>
                    <p class="text-slate-500 text-xs sm:text-sm">Silakan pilih salah satu metode verifikasi di bawah untuk
                        melanjutkan.</p>
                </div>

                {{-- Alert Error --}}
                @if (session('error'))
                    <div class="bg-rose-50 border border-rose-200 text-rose-600 px-4 py-3.5 rounded-2xl relative mb-6 text-xs flex items-center gap-3 shadow-sm animate-shake"
                        role="alert">
                        <div class="w-8 h-8 rounded-xl bg-rose-100 flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-triangle-exclamation text-rose-600"></i>
                        </div>
                        <div>
                            <strong class="font-bold block uppercase tracking-wider text-[10px]">Gagal Verifikasi</strong>
                            <span>{{ session('error') }}</span>
                        </div>
                    </div>
                @endif

                {{-- TAHAP 1: 2 TOMBOL BESAR UTAMA (QR Code di atas) --}}
                <div x-show="tab === 'menu'" x-transition:enter="transition ease-out duration-300"
                    class="grid grid-cols-1 sm:grid-cols-2 gap-4 my-4">

                    {{-- Tombol Pilihan 1: Scan QR Code --}}
                    <button @click="changeTab('scan')"
                        class="group p-6 rounded-2xl bg-slate-50 border border-slate-200 hover:border-orange-500/50 hover:bg-orange-50/40 transition-all duration-300 text-center flex flex-col items-center justify-center shadow-sm hover:shadow-md">
                        <div
                            class="w-14 h-14 rounded-2xl bg-orange-100 border border-orange-200 flex items-center justify-center text-orange-600 mb-4 group-hover:scale-110 transition-transform">
                            <i class="fa-solid fa-qrcode text-2xl"></i>
                        </div>
                        <h3 class="font-bold text-slate-900 text-sm mb-1 uppercase tracking-wider">Scan QR Code</h3>
                        <p class="text-[11px] text-slate-500">Gunakan kamera untuk memindai QR kartu.</p>
                    </button>

                    {{-- Tombol Pilihan 2: Input Nomor KTPA --}}
                    <button @click="changeTab('manual')"
                        class="group p-6 rounded-2xl bg-slate-50 border border-slate-200 hover:border-orange-500/50 hover:bg-orange-50/40 transition-all duration-300 text-center flex flex-col items-center justify-center shadow-sm hover:shadow-md">
                        <div
                            class="w-14 h-14 rounded-2xl bg-orange-100 border border-orange-200 flex items-center justify-center text-orange-600 mb-4 group-hover:scale-110 transition-transform">
                            <i class="fa-solid fa-keyboard text-2xl"></i>
                        </div>
                        <h3 class="font-bold text-slate-900 text-sm mb-1 uppercase tracking-wider">Nomor KTPA</h3>
                        <p class="text-[11px] text-slate-500">Input nomor kartu anggota secara manual.</p>
                    </button>

                </div>

                {{-- TAHAP 2A: Manual Input Form (Muncul saat tab === 'manual') --}}
                <div x-show="tab === 'manual'" x-cloak x-transition:enter="transition ease-out duration-300">
                    <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100">
                        <span class="text-xs font-bold uppercase tracking-wider text-orange-600 flex items-center gap-2">
                            <i class="fa-solid fa-keyboard"></i> Masukkan Nomor KTPA
                        </span>
                        <button @click="changeTab('menu')"
                            class="text-xs text-slate-500 hover:text-slate-800 flex items-center gap-1 transition-colors">
                            <i class="fa-solid fa-arrow-left"></i> Kembali
                        </button>
                    </div>

                    <form action="{{ route('kartu-anggota.cek.submit') }}" method="POST" id="manual-form"
                        class="space-y-5">
                        @csrf
                        <div>
                            <label for="no_kartu"
                                class="block text-slate-700 text-xs font-bold uppercase tracking-wider mb-2">
                                Nomor Kartu Anggota (KTPA)
                            </label>
                            <div class="relative">
                                <span
                                    class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                                    <i class="fa-solid fa-hashtag text-sm"></i>
                                </span>
                                <input id="no_kartu" name="no_kartu" type="text"
                                    placeholder="Contoh: 7371 2094 0000 3127"
                                    class="w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl text-slate-900 placeholder-slate-400 text-sm font-mono focus:outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition-all shadow-sm @error('no_kartu') !border-rose-500 !ring-rose-500/20 @enderror"
                                    value="{{ old('no_kartu') }}" required>
                            </div>
                            @error('no_kartu')
                                <p class="text-rose-500 text-xs mt-2 flex items-center gap-1.5 font-medium">
                                    <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <button type="submit"
                            class="w-full bg-gradient-to-r from-orange-500 to-amber-500 hover:from-orange-600 hover:to-amber-600 text-white font-black text-xs uppercase tracking-widest py-4 px-6 rounded-2xl shadow-md shadow-orange-500/20 focus:outline-none focus:ring-4 focus:ring-orange-500/30 transition-all duration-300 flex items-center justify-center gap-2 group">
                            <span>Cek Keabsahan Kartu</span>
                            <i class="fa-solid fa-arrow-right-long group-hover:translate-x-1 transition-transform"></i>
                        </button>
                    </form>
                </div>

                {{-- TAHAP 2B: QR Code Scanner (Muncul saat tab === 'scan') --}}
                <div x-show="tab === 'scan'" x-cloak x-transition:enter="transition ease-out duration-300"
                    class="space-y-4">
                    <div class="flex items-center justify-between mb-2 pb-3 border-b border-slate-100">
                        <span class="text-xs font-bold uppercase tracking-wider text-orange-600 flex items-center gap-2">
                            <i class="fa-solid fa-qrcode"></i> Scan QR Code
                        </span>
                        <button @click="changeTab('menu')"
                            class="text-xs text-slate-500 hover:text-slate-800 flex items-center gap-1 transition-colors">
                            <i class="fa-solid fa-arrow-left"></i> Kembali
                        </button>
                    </div>

                    <div class="relative rounded-2xl overflow-hidden border border-slate-200 bg-slate-50 p-2 shadow-sm">
                        <div id="qr-reader" class="w-full rounded-xl overflow-hidden"></div>
                    </div>
                    <div id="qr-reader-results" class="text-center"></div>
                    <p class="text-center text-xs text-slate-500 flex items-center justify-center gap-2">
                        <i class="fa-solid fa-camera text-orange-500 animate-pulse"></i>
                        Posisikan QR Code kartu anggota di dalam area pemindai kamera.
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
                    const config = {
                        fps: 10,
                        qrbox: {
                            width: 250,
                            height: 250
                        }
                    };
                    const onScanSuccess = (decodedText, decodedResult) => {
                        console.log(`Scan result: ${decodedText}`, decodedResult);

                        try {
                            const url = new URL(decodedText);
                            const pathParts = url.pathname.split('/');
                            const cardNumber = pathParts.pop() || pathParts.pop();

                            if (cardNumber) {
                                document.getElementById('no_kartu').value = cardNumber;
                                document.getElementById('manual-form').submit();
                                this.stopScanner();
                            }
                        } catch (e) {
                            console.error("Bukan URL valid atau format tidak sesuai:", e);
                            document.getElementById('no_kartu').value = decodedText;
                            document.getElementById('manual-form').submit();
                            this.stopScanner();
                        }
                    };
                    this.scanner.start({
                        facingMode: "environment"
                    }, config, onScanSuccess).catch(err => {
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
