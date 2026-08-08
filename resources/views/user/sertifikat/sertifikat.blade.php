@extends('layouts.admin')

@section('content')
    <div class="space-y-6">
        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-xl font-bold text-slate-800">{{ $pelatihan->judul ?? 'Sertifikat Pelatihan' }}</h2>
                <p class="text-xs text-slate-500 mt-0.5">Manajemen data peserta, nomor sertifikat, dan transkrip nilai pelatihan.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="#" onclick="window.print()"
                    class="inline-flex items-center gap-2 px-4 py-2.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 rounded-xl text-xs font-semibold shadow-sm transition">
                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z">
                        </path>
                    </svg>
                    Cetak / Unduh PDF
                </a>
            </div>
        </div>

        @php
            // Ambil pelatihan_anggota_id dari data nilai pertama yang terhubung ke sertifikat
            $pelatihanAnggotaId = optional($sertifikat->nilai->first())->pelatihan_anggota_id;

            // Ambil seluruh data nilai berdasarkan pelatihan_anggota_id yang sama agar semua materi/remidi masuk
            $daftarNilai = $pelatihanAnggotaId 
                ? \App\Models\Nilai::where('pelatihan_anggota_id', $pelatihanAnggotaId)->get() 
                : ($sertifikat->nilai ?? collect());

            $totalNilaiAkumulatif = $daftarNilai->sum('nilai');

            $predikat = '';
            if ($totalNilaiAkumulatif >= 85) {
                $predikat = 'Sangat Baik';
            } elseif ($totalNilaiAkumulatif >= 70) {
                $predikat = 'Baik';
            } elseif ($totalNilaiAkumulatif >= 55) {
                $predikat = 'Cukup Baik';
            } elseif ($totalNilaiAkumulatif >= 40) {
                $predikat = 'Kurang Baik';
            } else {
                $predikat = 'Buruk';
            }
        @endphp

        <!-- Informasi Singkat Peserta -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm">
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Nomor Sertifikat</p>
                <p class="text-sm font-bold text-slate-800 mt-1">{{ $sertifikat->no_sertifikat ?? '-' }}</p>
            </div>
            <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm">
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Nama Peserta</p>
                <p class="text-sm font-bold text-indigo-600 mt-1">{{ $namaPeserta ?? 'NAMA LENGKAP PESERTA, S.H.' }}</p>
            </div>
            <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm">
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Predikat Akhir</p>
                <p class="text-sm font-bold text-emerald-600 mt-1">{{ $predikat ?: '-' }} (Total: {{ number_format($totalNilaiAkumulatif, 2) }})</p>
            </div>
        </div>

        <!-- Pratinjau Dokumen Sertifikat -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-4 sm:p-6 shadow-sm flex flex-col items-center">
            <div class="w-full text-left mb-4">
                <h3 class="text-sm font-bold text-slate-700">Pratinjau Tampilan Sertifikat (A4 Potret)</h3>
            </div>

            <div class="cert-wrapper w-full bg-slate-100 rounded-xl border border-slate-200 p-2 sm:p-6 flex justify-center overflow-hidden">
                @php
                    $imagePath = public_path('serti.png');
                    $imageData = file_exists($imagePath) ? base64_encode(file_get_contents($imagePath)) : '';
                    $imageSrc = 'data:image/png;base64,' . $imageData;
                @endphp

                <div class="cert-container">
                    <!-- Nomor Sertifikat Tepat di Dalam Kotak Kanan Atas -->
                    <div class="no-sertifikat-box">
                        <div class="box">{{ $sertifikat->no_sertifikat ?? '-' }}</div>
                    </div>

                    <!-- Nama Peserta -->
                    <div class="nama-peserta">
                        {{ $namaPeserta ?? 'NAMA LENGKAP PESERTA, S.H.' }}
                    </div>

                    <!-- Tabel Materi dan Nilai -->
                    <div class="tabel-materi-container">
                        <br><br><br>
                        <table class="tabel-materi">
                            <thead>
                                <tr>
                                    <th style="width: 6%;">No</th>
                                    <th class="text-left">Materi / Modul Pelatihan</th>
                                    <th style="width: 10%;">Nilai</th>
                                    <th style="width: 12%;">Akumulatif</th>
                                    <th style="width: 15%;">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($daftarNilai as $index => $itemNilai)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td class="text-left">
                                            {{ optional($itemNilai->materi)->judul ?? 'Materi Pelatihan' }}</td>
                                        <td>{{ number_format($itemNilai->nilai_total_soal ?? $itemNilai->nilai, 2) }}</td>
                                        <td>{{ number_format($itemNilai->nilai ?? 0, 2) }}</td>
                                        <td>
                                            <b>{{ strtoupper($itemNilai->status) }}</b>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-3 text-slate-500">Tidak ada data materi.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <!-- Tambahan teks di bawah tabel -->
                        <div class="info-bawah-tabel">
                            <div>Hasil Pelatihan Peserta Mendapatkan Nilai : <b>{{ $predikat }}</b></div>
                            <div>Total Nilai : <b>{{ number_format($totalNilaiAkumulatif, 2) }}</b></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            /* Styling khusus pratinjau sertifikat agar responsif di semua ukuran layar */
            .cert-wrapper {
                width: 100%;
                display: flex;
                justify-content: center;
            }

            .cert-container {
                position: relative;
                width: 210mm;
                height: 297mm;
                background-image: url("{{ $imageSrc }}");
                background-size: cover;
                background-position: center;
                background-repeat: no-repeat;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
                overflow: hidden;
                transform-origin: top center;
                background-color: #fff;
                flex-shrink: 0;
            }

            /* Ukuran default / Desktop */
            .cert-container {
                transform: scale(0.85);
                margin-bottom: -45mm;
            }

            /* Tablet / Laptop Kecil */
            @media (max-width: 1024px) {
                .cert-container {
                    transform: scale(0.55);
                    margin-bottom: -130mm;
                }
            }

            /* Mode HP / Mobile */
            @media (max-width: 640px) {
                .cert-container {
                    transform: scale(0.36);
                    margin-bottom: -190mm;
                }
            }

            .no-sertifikat-box {
                position: absolute;
                top: 100px;
                right: 73px;
                text-align: center;
                width: 140px;
            }

            .no-sertifikat-box .box {
                font-size: 9px;
                font-weight: bold;
                color: #000;
                white-space: nowrap;
            }

            .nama-peserta {
                position: absolute;
                top: 268px;
                width: 100%;
                text-align: center;
                font-size: 26px;
                font-weight: bold;
                font-family: 'Georgia', serif;
                color: #1a1a1a;
                letter-spacing: 1px;
                text-transform: uppercase;
            }

            .tabel-materi-container {
                position: absolute;
                top: 375px;
                left: 100px;
                right: 100px;
            }

            .tabel-materi {
                width: 100%;
                border-collapse: collapse;
                font-size: 12px;
                background: rgba(255, 255, 255, 0.90);
            }

            .tabel-materi th,
            .tabel-materi td {
                border: 1px solid #999;
                padding: 4px 6px;
                text-align: center;
            }

            .tabel-materi th {
                background-color: #f4e8c1;
                color: #333;
                font-weight: bold;
            }

            .tabel-materi td.text-left {
                text-align: left;
            }

            .info-bawah-tabel {
                margin-top: 8px;
                display: flex;
                justify-content: space-between;
                align-items: center;
                font-size: 12px;
                font-weight: bold;
                color: #000;
            }

            @media print {
                body * {
                    visibility: hidden;
                }

                .cert-container,
                .cert-container * {
                    visibility: visible;
                }

                .cert-container {
                    position: absolute;
                    left: 0;
                    top: 0;
                    transform: scale(1) !important;
                    margin: 0;
                    box-shadow: none;
                }
            }
        </style>
    @endpush
@endsection