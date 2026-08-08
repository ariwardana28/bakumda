<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Download Kartu Anggota - {{ $anggotaCard->anggota->nama ?? 'Anggota' }}</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- html2canvas Library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <style>
        /* Menggunakan font standar agar presisi */
        body {
            font-family: Arial, Helvetica, sans-serif;
        }
    </style>
</head>
<body class="bg-gray-100 flex flex-col items-center justify-center min-h-screen p-4">

    <!-- STATUS ALERT -->
    <div id="status-card" class="mb-4 p-4 bg-white rounded-xl shadow-md flex items-center gap-3 text-sm text-gray-700">
        <i id="status-icon" class="fa-solid fa-circle-notch fa-spin text-indigo-600 text-lg"></i>
        <span id="status-text">Miapkan & mengunduh gambar kartu anggota...</span>
    </div>

    <div class="flex flex-wrap items-start justify-center gap-8">
        <!-- KARTU DEPAN -->
        <div>
            <h3 class="text-center text-xs font-bold text-gray-600 mb-2">BAGIAN DEPAN</h3>
            <div id="card-to-capture" class="relative w-[280px] h-[480px] bg-white rounded-2xl overflow-hidden shadow-2xl border border-gray-200">
                
                <!-- Layer 1: Background Template BAKUMDA -->
                <img src="{{ asset('background.png') }}" class="absolute inset-0 w-full h-full object-cover z-0" alt="Background Card">

                <!-- Layer 2: Konten Kartu -->
                <div class="relative z-10 w-full h-full">

                    <!-- Pas Foto Anggota -->
                    <div class="absolute top-[190px] left-[50px] w-[95px] h-[129px] overflow-hidden rounded-sm flex items-center justify-center bg-black">
                        @if ($anggotaCard->anggota->foto ?? false)
                            <img src="{{ asset('storage/' . $anggotaCard->anggota->foto) }}" class="w-full h-full object-cover" crossorigin="anonymous">
                        @else
                            <div class="flex flex-col items-center justify-center text-gray-300">
                                <i class="fa-solid fa-user text-2xl"></i>
                            </div>
                        @endif
                    </div>

                    <!-- QR Code & NIA -->
                    <div class="absolute top-[205px] left-[152px] w-[80px] flex flex-col items-center">
                        <div class="w-[78px] h-[78px] bg-white p-1 flex items-center justify-center">
                            @if ($anggotaCard->qr_code)
                                <img src="{{ asset('storage/' . $anggotaCard->qr_code) }}" class="w-full h-full object-contain" crossorigin="anonymous">
                            @else
                                <div class="text-[8px] text-gray-400 text-center leading-tight">Belum<br>Terbit</div>
                            @endif
                        </div>

                        @if ($anggotaCard->card_id)
                            <span class="text-[8px] font-bold text-gray-900 tracking-tight mt-1 whitespace-nowrap">
                                {{ $anggotaCard->card_id }}
                            </span>
                        @endif
                    </div>

                    <!-- Nama & Jabatan -->
                    <div class="absolute top-[342px] inset-x-0 px-4 text-center">
                        <h2 class="text-[11px] font-extrabold text-gray-900 uppercase tracking-tight leading-snug">
                            {{ $anggotaCard->anggota->nama ?? '' }}
                        </h2>

                        @if (!empty(optional($anggotaCard->latestBerlaku)->jabatan))
                            <p class="text-[9.5px] font-bold text-gray-800 uppercase tracking-wider mt-0.5">
                                {{ optional($anggotaCard->latestBerlaku)->jabatan }}
                            </p>
                        @endif
                    </div>

                    <!-- Masa Berlaku -->
                    @if (!empty(optional($anggotaCard->latestBerlaku)->berlaku))
                        <div class="absolute bottom-[20px] left-[18px]">
                            <p class="text-[8px] font-bold text-gray-900">
                                Berlaku s/d {{ \Carbon\Carbon::parse(optional($anggotaCard->latestBerlaku)->berlaku)->translatedFormat('d F Y') }}
                            </p>
                        </div>
                    @endif

                </div>
            </div>
        </div>

        <!-- KARTU BELAKANG -->
        <div>
            <h3 class="text-center text-xs font-bold text-gray-600 mb-2">BAGIAN BELAKANG</h3>
            <div id="card-to-capture-back" class="relative w-[280px] h-[480px] bg-white rounded-2xl overflow-hidden shadow-2xl border border-gray-200">
                <!-- Layer 1: Background Template Belakang -->
                <img src="{{ asset('belakang.png') }}" class="absolute inset-0 w-full h-full object-cover z-0" alt="Background Card Belakang">
                <!-- Layer 2: Konten Kartu Belakang (jika ada) -->
                <div class="relative z-10 w-full h-full">
                    {{-- Konten untuk bagian belakang bisa ditambahkan di sini jika diperlukan --}}
                </div>
            </div>
        </div>
    </div>

    <!-- TOMBOL AKSI OPSIONAL -->
    <div class="mt-6 flex gap-3">
        <button onclick="downloadAllImages()" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold rounded-lg shadow transition flex items-center gap-2">
            <i class="fa-solid fa-download"></i> Unduh Ulang Gambar
        </button>
        <button onclick="window.close()" class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white text-xs font-semibold rounded-lg shadow transition">
            Tutup Halaman
        </button>
    </div>

    <!-- SCRIPT AUTO DOWNLOAD GAMBAR -->
    <script>
        async function downloadAllImages() {
            const statusIcon = document.getElementById('status-icon');
            const statusText = document.getElementById('status-text');

            // Set status loading
            statusIcon.className = "fa-solid fa-circle-notch fa-spin text-indigo-600 text-lg";
            statusText.innerText = "Mengolah gambar kartu... (1/2)";

            try {
                // Daftar kartu yang akan diunduh
                const cards = [
                    { id: 'card-to-capture', suffix: 'DEPAN' },
                    { id: 'card-to-capture-back', suffix: 'BELAKANG' }
                ];

                for (let i = 0; i < cards.length; i++) {
                    const card = cards[i];
                    const cardElement = document.getElementById(card.id);
                    statusText.innerText = `Mengolah gambar kartu... (${i + 1}/${cards.length})`;

                    const canvas = await html2canvas(cardElement, {
                        scale: 3, // Skala 3x agar resolusi gambar tajam (HD)
                        useCORS: true,
                        allowTaint: true,
                        backgroundColor: null
                    });

                    const link = document.createElement('a');
                    const baseName = "Kartu-Anggota-{{ Str::slug($anggotaCard->anggota->nama ?? 'Anggota') }}";
                    link.download = `${baseName}-${card.suffix}.png`;
                    link.href = canvas.toDataURL("image/png", 1.0);
                    link.click();

                    // Beri jeda singkat antar unduhan
                    await new Promise(resolve => setTimeout(resolve, 500));
                }

                 // Update status selesai
                 statusIcon.className = "fa-solid fa-circle-check text-emerald-600 text-lg";
                 statusText.innerText = "Semua gambar kartu berhasil diunduh!";

            } catch (error) {
                console.error("Error capturing image:", error);
                statusIcon.className = "fa-solid fa-circle-xmark text-red-600 text-lg";
                statusText.innerText = "Gagal mengunduh gambar kartu.";
            }
        }

        // Jalankan download otomatis 1 detik setelah halaman dimuat penuh
        window.addEventListener('load', () => {
            setTimeout(() => {
                downloadAllImages();
            }, 1000);
        });
    </script>
</body>
</html>