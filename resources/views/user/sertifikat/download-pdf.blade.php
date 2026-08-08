@php
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
            background-image: url("{{ $imageSrc }}");
            background-size: 210mm 297mm;
            background-position: top left;
            background-repeat: no-repeat;
            box-sizing: border-box;
            overflow: hidden;
        }

        .no-sertifikat-box {
            position: absolute;
            top: 96px;
            right: 68px;
            width: 150px;
            text-align: center;
            font-size: 9px;
            font-weight: bold;
            color: #111;
        }

        .nama-peserta {
            position: absolute;
            top: 255px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 26px;
            font-weight: bold;
            font-family: 'Times New Roman', serif;
            color: #1a1a1a;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .tabel-materi-container {
            position: absolute;
            top: 360px;
            left: 65px;
            right: 65px;
        }

        .tabel-materi {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
            background: rgba(255, 255, 255, 0.98);
        }

        .tabel-materi th,
        .tabel-materi td {
            border: 1px solid #777;
            padding: 5px 8px;
            text-align: center;
            vertical-align: middle;
        }

        .tabel-materi th {
            background-color: #f4e8c1;
            color: #222;
            font-weight: bold;
            font-size: 11px;
        }

        .tabel-materi td.text-left {
            text-align: left;
        }

        .info-bawah-tabel {
            margin-top: 6px;
            width: 100%;
            font-size: 11px;
            font-weight: bold;
            color: #111;
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
    </style>
</head>

<body>
    <div class="cert-container">
        <div class="no-sertifikat-box">
            {{ $sertifikat->no_sertifikat ?? '-' }}
        </div>

        <div class="nama-peserta">
            {{ $namaPeserta ?? 'NAMA LENGKAP PESERTA, S.H.' }}
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
                            <td>{{ number_format($itemNilai->nilai_total_soal ?? $itemNilai->nilai, 2) }}</td>
                            <td>{{ number_format($itemNilai->nilai ?? 0, 2) }}</td>
                            <td><b>{{ strtoupper($itemNilai->status) }}</b></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="padding: 12px; color: #555;">Tidak ada data materi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="info-bawah-tabel">
                <table>
                    <tr>
                        <td style="text-align: left;">Hasil Pelatihan Peserta Mendapatkan Nilai :
                            <b>{{ $predikat }}</b></td>
                        <td style="text-align: right;">Total Nilai :
                            <b>{{ number_format($totalNilaiAkumulatif, 2) }}</b></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</body>

</html>
