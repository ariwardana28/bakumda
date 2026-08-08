@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 py-6 sm:py-10 max-w-6xl">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white/90 dark:bg-slate-900/90 backdrop-blur-xl p-6 rounded-[2rem] border border-slate-200/80 dark:border-slate-800 shadow-xl">
            <div>
                <span class="text-[10px] font-bold text-brand-600 dark:text-brand-400 uppercase tracking-widest mb-1 block">Unduh Sertifikat</span>
                <h2 class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white tracking-tight">Preview Sertifikat</h2>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Pastikan tampilan sertifikat sesuai, lalu unduh PDF dengan tombol di samping.</p>
            </div>
            <div class="flex flex-col sm:flex-row items-center gap-3">
                <a href="{{ route('user.sertifikat.download.pdf', $pelatihan->id) }}"
                    class="inline-flex items-center justify-center gap-2 px-6 py-3 text-white rounded-xl text-xs font-bold shadow-lg shadow-brand-500/25 transition-all duration-200 hover:scale-[1.02]"
                    style="background: linear-gradient(90deg, #2563eb 0%, #3b82f6 100%); color: #ffffff;">
                    <i class="fa-solid fa-file-arrow-down"></i>
                    Unduh PDF
                </a>
                <a href="{{ route('user.sertifikat', $pelatihan->id) }}"
                    class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-slate-100 text-slate-900 rounded-xl text-xs font-bold border border-slate-200 hover:bg-slate-200 transition-all duration-200">
                    <i class="fa-solid fa-arrow-left"></i>
                    Kembali ke Sertifikat
                </a>
            </div>
        </div>

        <div class="mt-8 bg-white/90 dark:bg-slate-900/90 p-6 rounded-[2rem] border border-slate-200/80 dark:border-slate-800 shadow-xl">
            <div class="mb-4 text-sm text-slate-500 dark:text-slate-400">Halaman ini menampilkan pratinjau sertifikat sebelum diunduh sebagai PDF.</div>
            <div class="cert-wrapper w-full bg-slate-100 dark:bg-slate-950/50 rounded-2xl border border-slate-200 dark:border-slate-800 p-4 sm:p-6 overflow-auto">
                @php
                    $imagePath = public_path('serti.png');
                    $imageData = file_exists($imagePath) ? base64_encode(file_get_contents($imagePath)) : '';
                    $imageSrc = 'data:image/png;base64,' . $imageData;
                @endphp

                <div class="cert-container">
                    <div class="no-sertifikat-box">
                        <div class="box">{{ $sertifikat->no_sertifikat ?? '-' }}</div>
                    </div>

                    <div class="nama-peserta">
                        {{ $namaPeserta ?? 'NAMA LENGKAP PESERTA, S.H.' }}
                    </div>

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
                                        <td class="text-left">{{ optional($itemNilai->materi)->judul ?? 'Materi Pelatihan' }}</td>
                                        <td>{{ number_format($itemNilai->nilai_total_soal ?? $itemNilai->nilai, 2) }}</td>
                                        <td>{{ number_format($itemNilai->nilai ?? 0, 2) }}</td>
                                        <td><b>{{ strtoupper($itemNilai->status) }}</b></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-3 text-slate-500">Tidak ada data materi.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <div class="info-bawah-tabel">
                            <div>Hasil Pelatihan Peserta Mendapatkan Nilai : <b>{{ $predikat }}</b></div>
                            <div>Total Nilai : <b>{{ number_format($totalNilaiAkumulatif, 2) }}</b></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
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

        .cert-container {
            transform: scale(0.80);
            margin-bottom: -55mm;
        }

        @media (max-width: 1024px) {
            .cert-container {
                transform: scale(0.52);
                margin-bottom: -140mm;
            }
        }

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
    </style>
@endpush
