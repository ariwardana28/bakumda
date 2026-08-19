@php
    // Gunakan file gambar beresolusi tinggi (misal 2480 x 3508 piksel untuk ukuran A4 300 DPI)
    $imagePath = public_path('serti.png');
    $imageData = file_exists($imagePath) ? base64_encode(file_get_contents($imagePath)) : '';
    $imageSrc = 'data:image/png;base64,' . $imageData;
@endphp
<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Sertifikat {{ $pelatihan->judul ?? '' }}</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 0;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Helvetica', 'Arial', sans-serif;
            background: #ffffff;
            -webkit-print-color-adjust: exact;
        }

        .cert-container {
            position: relative;
            width: 210mm;
            height: 297mm;
            margin: 0 auto;
            box-sizing: border-box;
            overflow: hidden;
        }

        .bg-sertifikat {
            position: absolute;
            top: 0;
            left: 0;
            width: 210mm;
            height: 297mm;
            z-index: 1;
        }

        .content-layer {
            position: absolute;
            top: 0;
            left: 0;
            width: 210mm;
            height: 297mm;
            z-index: 10;
            box-sizing: border-box;
        }

        .no-sertifikat-box {
            position: absolute;
            top: 25.5mm;
            right: 18mm;
            width: 45mm;
            text-align: center;
            font-size: 9px;
            font-weight: bold;
            color: #333;
        }

        .nama-peserta {
            position: absolute;
            top: 67mm;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            font-family: 'Times New Roman', serif;
            color: #1f1f1f;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .deskripsi-peserta {
            position: absolute;
            top: 80mm;
            left: 20mm;
            right: 20mm;
            text-align: center;
            font-size: 11px;
            color: #333;
            line-height: 1.5;
        }

        .tabel-materi-container {
            position: absolute;
            top: 99mm;
            left: 18mm;
            right: 18mm;
        }

        .tabel-materi {
            width: 100%;
            border-collapse: collapse;
            font-size: 9.5px;
            background: rgba(255, 255, 255, 0.95);
        }

        .tabel-materi th,
        .tabel-materi td {
            border: 1px solid #777;
            padding: 4px 6px;
            text-align: center;
            vertical-align: middle;
        }

        .tabel-materi th {
            background-color: #f4e8c1;
            color: #333;
            font-weight: bold;
            font-size: 10px;
        }

        .tabel-materi td.text-left {
            text-align: left;
        }

        .info-bawah-tabel {
            margin-top: 5px;
            font-size: 10px;
            font-weight: bold;
            color: #333;
            padding: 0 2px;
        }

        .info-bawah-tabel table {
            width: 100%;
            border-collapse: collapse;
        }

        .info-bawah-tabel td {
            padding: 0;
            border: none;
            background: transparent;
        }

        /* Bagian Bawah: QR Code & Tanda Tangan */
        .footer-section {
            position: absolute;
            bottom: 25mm;
            left: 18mm;
            right: 18mm;
            width: 100%;
        }

        .footer-table {
            width: 100%;
            border-collapse: collapse;
        }

        .footer-table td {
            vertical-align: bottom;
            border: none;
            background: transparent;
            padding: 0;
        }

        .qr-box {
            width: 25mm;
            text-align: left;
        }

        .qr-box img {
            width: 22mm;
            height: 22mm;
        }

        .qr-text {
            font-size: 8px;
            color: #444;
            margin-top: 4px;
            line-height: 1.2;
        }

        .ttd-box {
            text-align: right;
            padding-right: 15mm;
        }

        .ttd-container {
            display: inline-block;
            text-align: center;
            position: relative;
        }

        .ttd-title {
            font-size: 10.5px;
            font-weight: bold;
            color: #111;
            margin-bottom: 2px;
        }

        .ttd-subtitle {
            font-size: 9.5px;
            color: #333;
            margin-bottom: 12px;
        }

        .stempel-ttd-img {
            position: absolute;
            bottom: 12px;
            left: 50%;
            transform: translateX(-50%);
            width: 45mm;
            opacity: 0.85;
            z-index: 2;
        }

        .ttd-name {
            font-size: 10px;
            font-weight: bold;
            color: #111;
            margin-top: 28mm;
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="cert-container">
        <!-- Background menggunakan tag IMG agar resolusi gambar optimal dan tidak pecah saat di-render PDF -->
        @if($imageSrc)
            <img src="{{ $imageSrc }}" class="bg-sertifikat" alt="Background Sertifikat">
        @endif

        <div class="content-layer">
            <div class="no-sertifikat-box">
                {{ $sertifikat->no_sertifikat ?? '-' }}
            </div>

            <div class="nama-peserta">
                {{ $namaPeserta ?? 'NAMA LENGKAP PESERTA, S.H.' }}
            </div>

            <div class="deskripsi-peserta">
            </div>
            
            <div class="tabel-materi-container">
                <br>
                <br>
                <br>
                <table class="tabel-materi">
                    <thead>
                        <tr>
                            <th style="width: 6%;">No</th>
                            <th class="text-left">Materi / Modul Pelatihan</th>
                            <th style="width: 12%;">Nilai</th>
                            <th style="width: 12%;">Akumulatif</th>
                            <th style="width: 15%;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($daftarNilai as $index => $itemNilai)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td class="text-left">{{ optional($itemNilai->materi)->judul ?? 'Materi Pelatihan' }}</td>
                                <td>{{ number_format($itemNilai->nilai_total_soal ?? 0, 2) }}</td>
                                <td>{{ number_format($itemNilai->nilai ?? 0, 2) }}</td>
                                <td><b>{{ strtoupper($itemNilai->status) }}</b></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="padding: 10px; color: #555;">Tidak ada data materi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="info-bawah-tabel">
                    <table>
                        <tr>
                            <td style="text-align: left;">Hasil Pelatihan Peserta Mendapatkan Nilai : 
                                <b>{{ $predikat }}</b>
                            </td>
                            <td style="text-align: right;">Total Nilai : 
                                <b>{{ number_format($totalNilaiAkumulatif, 2) }}</b>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

          

        </div>
    </div>
</body>

</html>