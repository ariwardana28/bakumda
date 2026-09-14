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
        body {
            font-family: Arial, Helvetica, sans-serif;
        }
    </style>
</head>

<body class="bg-gray-100 flex flex-col items-center justify-center min-h-screen p-4">

    <!-- STATUS ALERT -->
    <div id="status-card" class="mb-4 p-4 bg-white rounded-xl shadow-md flex items-center gap-3 text-sm text-gray-700">
        <i id="status-icon" class="fa-solid fa-circle-notch fa-spin text-indigo-600 text-lg"></i>
        <span id="status-text">Menyiapkan & mengunduh gambar kartu anggota...</span>
    </div>

    <div class="flex flex-wrap items-start justify-center gap-8">
        <!-- KARTU DEPAN -->
        <div>
            <h3 class="text-center text-xs font-bold text-gray-600 mb-2">BAGIAN DEPAN</h3>
            <div id="card-to-capture"
                class="relative w-[280px] h-[480px] bg-white rounded-2xl overflow-hidden shadow-2xl border border-gray-200">

                <!-- Layer 1: Background Template BAKUMDA -->
                <img src="{{ asset('background.png') }}" class="absolute inset-0 w-full h-full object-cover z-0"
                    alt="Background Card" crossorigin="anonymous">

                <!-- Layer 2: Konten Kartu -->
                <div class="relative z-10 w-full h-full">

                    <!-- Pas Foto Anggota -->
                    <div
                        class="absolute top-[190px] left-[50px] w-[95px] h-[129px] overflow-hidden rounded-sm flex items-center justify-center bg-black">
                        @if ($anggotaCard->anggota->foto ?? false)
                            <img src="{{ asset('storage/' . $anggotaCard->anggota->foto) }}"
                                class="w-full h-full object-cover" crossorigin="anonymous">
                        @else
                            <div class="flex flex-col items-center justify-center text-gray-300">
                                <i class="fa-solid fa-user text-2xl"></i>
                            </div>
                        @endif
                    </div>

                    <!-- QR Code & NIA -->
                    <div class="absolute top-[202px] left-[152px] w-[78px] flex flex-col items-center justify-center">
                        <div class="w-[78px] h-[78px] bg-white p-1 flex items-center justify-center rounded-xs overflow-hidden">
                            @if ($anggotaCard->qr_code)
                                {{-- PERBAIKAN: style width/height 100% langsung di inline agar html2canvas tidak memotong skala gambar --}}
                                <img src="{{ asset('storage/' . $anggotaCard->qr_code) }}"
                                    style="width: 100% !important; height: 100% !important; object-fit: contain !important;"
                                    class="block" crossorigin="anonymous" id="qr-image">
                            @else
                                <div class="text-[7px] text-gray-400 text-center leading-tight">
                                    Belum<br>Terbit
                                </div>
                            @endif
                        </div>
                        @if ($anggotaCard->card_id)
                            <span
                                class="text-[7.5px] font-bold text-gray-900 font-sans tracking-tight mt-1 whitespace-nowrap block text-center">
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
                                Berlaku s/d
                                {{ \Carbon\Carbon::parse(optional($anggotaCard->latestBerlaku)->berlaku)->translatedFormat('d F Y') }}
                            </p>
                        </div>
                    @endif

                </div>
            </div>
        </div>

        <!-- KARTU BELAKANG -->
        <div>
            <h3 class="text-center text-xs font-bold text-gray-600 mb-2">BAGIAN BELAKANG</h3>
            <div id="card-to-capture-back"
                class="relative w-[280px] h-[480px] bg-white rounded-2xl overflow-hidden shadow-2xl border border-gray-200">
                <!-- Layer 1: Background Template Belakang -->
                <img src="{{ asset('belakang.png') }}" class="absolute inset-0 w-full h-full object-cover z-0"
                    alt="Background Card Belakang" crossorigin="anonymous">
                <!-- Layer 2: Konten Kartu Belakang -->
                <div class="relative z-10 w-full h-full">
                </div>
            </div>
        </div>
    </div>

    <!-- TOMBOL AKSI -->
    <div class="mt-6 flex gap-3">
        <button onclick="downloadAllImages()"
            class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold rounded-lg shadow transition flex items-center gap-2">
            <i class="fa-solid fa-download"></i> Unduh Ulang Gambar
        </button>
        <button onclick="window.close()"
            class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white text-xs font-semibold rounded-lg shadow transition">
            Tutup Halaman
        </button>
    </div>

    <!-- SCRIPT AUTO DOWNLOAD GAMBAR -->
    <script>
        // PERBAIKAN: html2canvas tidak mendukung `object-fit` dengan andal
        // (contoh nyata: gambar QR jadi ter-crop/zoom ke satu sudut pattern-nya
        // saja alih-alih diperkecil utuh ke dalam kotak). Solusinya: setiap
        // gambar di-fetch, lalu digambar ulang secara manual ke <canvas>
        // dengan perhitungan cover/contain yang benar sesuai object-fit
        // aslinya, sehingga hasil akhirnya sudah pas persis dengan ukuran
        // kotak dan html2canvas tinggal menyalin apa adanya.

        async function fetchAsDataURL(url) {
            const response = await fetch(url, { mode: 'cors', cache: 'no-store' });
            if (!response.ok) throw new Error('HTTP ' + response.status);
            const blob = await response.blob();
            return await new Promise((resolve, reject) => {
                const reader = new FileReader();
                reader.onloadend = () => resolve(reader.result);
                reader.onerror = reject;
                reader.readAsDataURL(blob);
            });
        }

        function loadImageFromSrc(src) {
            return new Promise((resolve, reject) => {
                const img = new Image();
                img.onload = () => resolve(img);
                img.onerror = reject;
                img.src = src;
            });
        }

        // Gambar ulang `img` ke kanvas berukuran (boxWidth x boxHeight) dengan
        // logika object-fit 'cover' atau 'contain', lalu kembalikan data URL
        // hasilnya. scaleFactor menaikkan resolusi agar tetap tajam saat
        // di-capture dengan scale:3 oleh html2canvas.
        function fitDataURL(img, boxWidth, boxHeight, mode, scaleFactor = 4) {
            const canvas = document.createElement('canvas');
            canvas.width = Math.max(1, Math.round(boxWidth * scaleFactor));
            canvas.height = Math.max(1, Math.round(boxHeight * scaleFactor));
            const ctx = canvas.getContext('2d');

            // Latar putih agar tidak transparan/hitam di area kosong (mode contain)
            ctx.fillStyle = '#ffffff';
            ctx.fillRect(0, 0, canvas.width, canvas.height);

            const iw = img.naturalWidth || img.width;
            const ih = img.naturalHeight || img.height;
            const scale = mode === 'cover'
                ? Math.max(canvas.width / iw, canvas.height / ih)
                : Math.min(canvas.width / iw, canvas.height / ih);
            const drawW = iw * scale;
            const drawH = ih * scale;
            const offsetX = (canvas.width - drawW) / 2;
            const offsetY = (canvas.height - drawH) / 2;

            ctx.drawImage(img, offsetX, offsetY, drawW, drawH);
            return canvas.toDataURL('image/png', 1.0);
        }

        async function preloadAndConvertImages(element) {
            const imgs = Array.from(element.querySelectorAll('img'));
            await Promise.all(imgs.map(async (img) => {
                if (!img.src) return;

                const boxWidth = img.clientWidth || img.offsetWidth || img.naturalWidth || 100;
                const boxHeight = img.clientHeight || img.offsetHeight || img.naturalHeight || 100;
                const computedFit = window.getComputedStyle(img).objectFit || 'fill';

                try {
                    const rawDataUrl = await fetchAsDataURL(img.src);

                    if (computedFit === 'cover' || computedFit === 'contain') {
                        const loadedImg = await loadImageFromSrc(rawDataUrl);
                        img.src = fitDataURL(loadedImg, boxWidth, boxHeight, computedFit);
                        // Gambar sudah pas persis ukurannya, object-fit tak lagi dibutuhkan
                        img.style.objectFit = 'fill';
                    } else {
                        img.src = rawDataUrl;
                    }
                } catch (err) {
                    console.warn('Gagal memuat gambar:', img.src, err);
                    // Gagal dimuat -> sembunyikan agar tidak muncul ikon rusak
                    img.style.visibility = 'hidden';
                }
            }));
        }

        async function downloadAllImages() {
            const statusIcon = document.getElementById('status-icon');
            const statusText = document.getElementById('status-text');

            statusIcon.className = "fa-solid fa-circle-notch fa-spin text-indigo-600 text-lg";
            statusText.innerText = "Mengolah gambar kartu... (1/2)";

            try {
                const cards = [
                    { id: 'card-to-capture', suffix: 'DEPAN' },
                    { id: 'card-to-capture-back', suffix: 'BELAKANG' }
                ];

                for (let i = 0; i < cards.length; i++) {
                    const card = cards[i];
                    const cardElement = document.getElementById(card.id);
                    statusText.innerText = `Mengolah gambar kartu... (${i + 1}/${cards.length})`;

                    // Tunggu semua gambar dikonversi ke base64 di DOM
                    await preloadAndConvertImages(cardElement);

                    // Tambahkan jeda rendering 300ms untuk memastikan kestabilan
                    await new Promise(resolve => setTimeout(resolve, 300));

                    const canvas = await html2canvas(cardElement, {
                        scale: 3,
                        useCORS: true,
                        allowTaint: false,
                        backgroundColor: null,
                        scrollX: 0,
                        scrollY: 0,
                        foreignObjectRendering: false // Matikan SVG foreignObject agar tidak crop gambar
                    });

                    const link = document.createElement('a');
                    const baseName = "Kartu-Anggota-{{ Str::slug($anggotaCard->anggota->nama ?? 'Anggota') }}";
                    link.download = `${baseName}-${card.suffix}.png`;
                    link.href = canvas.toDataURL("image/png", 1.0);
                    link.click();

                    await new Promise(resolve => setTimeout(resolve, 500));
                }

                statusIcon.className = "fa-solid fa-circle-check text-emerald-600 text-lg";
                statusText.innerText = "Semua gambar kartu berhasil diunduh!";

            } catch (error) {
                console.error("Error capturing image:", error);
                statusIcon.className = "fa-solid fa-circle-xmark text-red-600 text-lg";
                statusText.innerText = "Gagal mengunduh gambar kartu.";
            }
        }

        // Jalankan download otomatis setelah halaman dimuat penuh
        window.addEventListener('load', () => {
            setTimeout(() => {
                downloadAllImages();
            }, 1000);
        });
    </script>
</body>

</html>
