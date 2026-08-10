@extends('layouts.app') {{-- Sesuaikan dengan layout utama Anda --}}

@section('content')
<div class="container mx-auto px-4 py-12">
    <div class="max-w-xl mx-auto bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden">
        <div class="px-6 py-8">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-2 text-center">Verifikasi Kartu Anggota</h2>
            <p class="text-gray-600 dark:text-gray-400 mb-6 text-center">Masukkan Nomor Kartu Tanda Anggota (KTPA) untuk melihat keabsahan data.</p>

            @if(session('error'))
                <div class="bg-rose-100 border border-rose-400 text-rose-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <strong class="font-bold">Gagal!</strong>
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <form action="{{ route('kartu-anggota.cek.submit') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="no_kartu" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">
                        Nomor Kartu Anggota
                    </label>
                    <input id="no_kartu" name="no_kartu" type="text" placeholder="Contoh: KTPA.2024.0001"
                           class="shadow-sm appearance-none border rounded w-full py-3 px-4 text-gray-700 dark:text-gray-200 dark:bg-gray-700 dark:border-gray-600 leading-tight focus:outline-none focus:ring focus:ring-blue-300 @error('no_kartu') border-rose-500 @enderror"
                           value="{{ old('no_kartu') }}" required>
                    @error('no_kartu')
                        <p class="text-rose-500 text-xs italic mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-center mt-6">
                    <button type="submit"
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded focus:outline-none focus:shadow-outline transition duration-150 ease-in-out">
                        Cek Kartu
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    {{-- Script section is now empty --}}
@endpush

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
                tab: 'manual',
                scanner: null,
                init() {
                    // Inisialisasi scanner saat komponen Alpine dimuat
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
                        
                        // Ekstrak nomor kartu dari URL
                        try {
                            const url = new URL(decodedText);
                            const pathParts = url.pathname.split('/');
                            const cardNumber = pathParts.pop() || pathParts.pop(); // Handle trailing slash

                            if (cardNumber) {
                                // Isi field input dan submit form
                                document.getElementById('no_kartu').value = cardNumber;
                                document.getElementById('manual-form').submit();
                                this.stopScanner();
                            }
                        } catch (e) {
                            console.error("Bukan URL valid atau format tidak sesuai:", e);
                            // Jika bukan URL, anggap text adalah nomor kartu
                            document.getElementById('no_kartu').value = decodedText;
                            document.getElementById('manual-form').submit();
                            this.stopScanner();
                        }
                    };
                    this.scanner.start({ facingMode: "environment" }, config, onScanSuccess);
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