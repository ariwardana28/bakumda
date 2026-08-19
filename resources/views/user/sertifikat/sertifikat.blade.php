@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 py-6 sm:py-10 max-w-5xl relative space-y-6">

        {{-- Latar Belakang Dekoratif Glow Abstrak --}}
        <div class="absolute top-10 left-1/4 w-72 h-72 sm:w-96 sm:h-96 bg-brand-500/10 dark:bg-brand-500/5 rounded-full blur-3xl pointer-events-none -z-10"></div>
        <div class="absolute top-64 right-10 w-64 h-64 sm:w-80 sm:h-80 bg-brand-600/10 dark:bg-brand-600/5 rounded-full blur-3xl pointer-events-none -z-10"></div>

        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white/80 dark:bg-slate-900/80 backdrop-blur-xl p-6 rounded-[2rem] border border-slate-200/80 dark:border-slate-800 shadow-xl">
            <div>
                <span class="text-[10px] font-bold text-brand-600 dark:text-brand-400 uppercase tracking-widest mb-1 block">Transkrip & Sertifikat</span>
                <h2 class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white tracking-tight">{{ $pelatihan->judul ?? 'Sertifikat Pelatihan' }}</h2>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Manajemen data peserta, nomor sertifikat, dan transkrip nilai pelatihan.</p>
            </div>
            <div class="flex items-center gap-3 shrink-0">
                  <a href="{{ route('user.sertifikat.download.pdf', $pelatihan->id) }}" target="_blank"
                    class="inline-flex items-center justify-center gap-2 px-6 py-3 text-white rounded-xl text-xs font-bold shadow-lg shadow-brand-500/25 transition-all duration-200 hover:scale-[1.02]"
                    style="background: linear-gradient(90deg, #2563eb 0%, #3b82f6 100%); color: #ffffff;">
                    <i class="fa-solid fa-file-arrow-down"></i>
                    Unduh PDF
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
            <div class="bg-white/80 dark:bg-slate-900/80 backdrop-blur-xl p-5 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-sm flex items-center gap-4">
                <div class="w-10 h-10 rounded-xl bg-brand-500/10 text-brand-600 dark:text-brand-400 flex items-center justify-center font-bold text-sm shrink-0">
                    <i class="fa-solid fa-barcode"></i>
                </div>
                <div class="overflow-hidden">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Nomor Sertifikat</p>
                    <p class="text-xs sm:text-sm font-black text-slate-800 dark:text-slate-200 mt-0.5 font-mono truncate">{{ $sertifikat->no_sertifikat ?? '-' }}</p>
                </div>
            </div>

            <div class="bg-white/80 dark:bg-slate-900/80 backdrop-blur-xl p-5 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-sm flex items-center gap-4">
                <div class="w-10 h-10 rounded-xl bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 flex items-center justify-center font-bold text-sm shrink-0">
                    <i class="fa-solid fa-user-graduate"></i>
                </div>
                <div class="overflow-hidden">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Nama Peserta</p>
                    <p class="text-xs sm:text-sm font-black text-indigo-600 dark:text-indigo-400 mt-0.5 truncate">{{ $namaPeserta ?? 'NAMA LENGKAP PESERTA, S.H.' }}</p>
                </div>
            </div>

            <div class="bg-white/80 dark:bg-slate-900/80 backdrop-blur-xl p-5 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-sm flex items-center gap-4">
                <div class="w-10 h-10 rounded-xl bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 flex items-center justify-center font-bold text-sm shrink-0">
                    <i class="fa-solid fa-award"></i>
                </div>
                <div class="overflow-hidden">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Predikat Akhir</p>
                    <p class="text-xs sm:text-sm font-black text-emerald-600 dark:text-emerald-400 mt-0.5 truncate">{{ $predikat ?: '-' }} <span class="text-xs font-normal text-slate-500">({{ number_format($totalNilaiAkumulatif, 2) }})</span></p>
                </div>
            </div>
        </div>

        <!-- Pratinjau Dokumen Sertifikat -->
        <div class="bg-white/80 dark:bg-slate-900/80 backdrop-blur-2xl rounded-[2rem] border border-slate-200/80 dark:border-slate-800 p-5 sm:p-8 shadow-xl flex flex-col items-center">
            <div class="w-full text-left mb-4 flex items-center justify-between">
                <h3 class="text-xs sm:text-sm font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider flex items-center gap-2">
                    <i class="fa-solid fa-eye text-brand-500"></i>
                    Pratinjau Tampilan Sertifikat (A4 Potret)
                </h3>
            </div>

            <div class="cert-wrapper w-full bg-slate-100 dark:bg-slate-950/50 rounded-2xl border border-slate-200 dark:border-slate-800 p-2 sm:p-6 flex justify-center overflow-hidden">
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
                                        <td style="color: #000">{{ $index + 1 }}</td>
                                        <td class="text-left" style="color: #000">
                                            {{ optional($itemNilai->materi)->judul ?? 'Materi Pelatihan' }}</td>
                                        <td style="color: #000">{{ number_format($itemNilai->nilai_total_soal ?? $itemNilai->nilai, 2) }}</td>
                                        <td style="color: #000">{{ number_format($itemNilai->nilai ?? 0, 2) }}</td>
                                        <td style="color: #000">
                                            <b>{{ strtoupper($itemNilai->status) }}</b>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-3 text-slate-500" style="color: #000">Tidak ada data materi.
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
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
                overflow: hidden;
                transform-origin: top center;
                background-color: #fff;
                flex-shrink: 0;
                border-radius: 8px;
            }

            /* Ukuran default / Desktop */
            .cert-container {
                transform: scale(0.80);
                margin-bottom: -55mm;
            }

            /* Tablet / Laptop Kecil */
            @media (max-width: 1024px) {
                .cert-container {
                    transform: scale(0.52);
                    margin-bottom: -140mm;
                }
            }

            /* Mode HP / Mobile */
            @media (max-width: 640px) {
                .cert-container {
                    transform: scale(0.34);
                    margin-bottom: -200mm;
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
                    border-radius: 0;
                }
            }
        </style>
    @endpush
@endsection