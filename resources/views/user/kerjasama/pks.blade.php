@extends('layouts.app')

@push('styles')
    <style>
        /* ===== Tampilan Kertas Ukuran A4 ===== */
        .pks-paper {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12pt;
            line-height: 1.5;
            color: #000;
            background: #fff;
            width: 210mm;
            min-height: 297mm;
            margin: 0 auto;
            padding: 25mm 20mm;
            box-shadow: 0 10px 30px -10px rgba(15, 23, 42, 0.2);
            border: 1px solid #cbd5e1;
            text-align: justify;
            box-sizing: border-box;
        }

        .pks-paper h1 {
            font-size: 14pt;
            font-weight: 700;
            text-align: center;
            text-transform: uppercase;
            line-height: 1.4;
            margin: 0;
        }

        .pks-paper .pks-nomor {
            text-align: center;
            font-weight: 700;
            border-top: 1px solid #000;
            margin-top: 8px;
            padding-top: 4px;
            width: 100%;
        }

        .pks-paper .pasal {
            text-align: center;
            font-weight: 700;
            text-transform: uppercase;
            margin: 20px 0 8px;
            break-after: avoid;
        }

        .pks-paper p {
            margin: 0 0 10px;
        }

        .pks-paper ol {
            margin: 0 0 10px;
            padding-left: 24px;
        }

        .pks-paper ol.alpha {
            list-style-type: lower-alpha;
            margin: 4px 0 4px;
        }

        .pks-paper ol li {
            margin-bottom: 4px;
        }

        .pks-paper table.pihak td {
            vertical-align: top;
            padding: 2px 0;
        }

        .pks-paper .pasal-blok {
            break-inside: avoid;
        }

        .pks-paper .ttd td {
            text-align: center;
            vertical-align: top;
            font-weight: 700;
        }

        .pks-paper .matrai {
            display: inline-block;
            border: 1px solid #000;
            font-size: 8pt;
            font-weight: 400;
            padding: 6px 12px;
            line-height: 1.25;
            margin-bottom: 10px;
        }

        /* ===== Cetak / Simpan PDF (Standard A4) ===== */
        @page {
            size: A4;
            margin: 0;
        }

        @media print {
            body * {
                visibility: hidden;
            }

            .pks-paper,
            .pks-paper * {
                visibility: visible;
            }

            .pks-paper {
                position: absolute;
                left: 0;
                top: 0;
                width: 210mm;
                min-height: 297mm;
                margin: 0;
                padding: 25mm 20mm;
                border: 0;
                box-shadow: none;
            }
        }
    </style>
@endpush

@section('content')
    <div class="min-h-screen bg-[#f1f5f9] py-8 px-3 sm:px-6">

        <!-- Toolbar (tidak ikut tercetak) -->
        <div class="max-w-[210mm] mx-auto mb-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <a href="{{ route('user-kerjasamas.show', $kerjasama->id) }}"
                class="inline-flex items-center text-xs font-semibold text-[#64748b] hover:text-indigo-600 transition">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali ke detail
            </a>

            <button type="button" onclick="window.print()"
                class="inline-flex items-center justify-center px-4 py-2.5 rounded-xl bg-indigo-600 text-white text-sm font-semibold shadow-xs hover:bg-indigo-500 transition">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                Cetak / Simpan PDF
            </button>
        </div>

        @if ($status === 'pending')
            <div
                class="max-w-[210mm] mx-auto mb-4 p-3.5 rounded-xl bg-amber-50 border border-amber-200 text-xs text-amber-800">
                Dokumen ini masih berupa <b>draf</b> karena pengajuan belum disetujui oleh BAKUMDA.
            </div>
        @elseif (in_array($status, ['ditolak', 'dibatalkan']))
            <div
                class="max-w-[210mm] mx-auto mb-4 p-3.5 rounded-xl bg-rose-50 border border-rose-200 text-xs text-rose-800">
                Pengajuan ini berstatus <b>{{ $status }}</b>, sehingga dokumen tidak berlaku.
            </div>
        @endif

        <!-- ===================== DOKUMEN (A4) ===================== -->
        <div class="pks-paper">

            <h1>
                Surat Perjanjian Kerja Sama (PKS)<br>
                Tentang Penyelenggaraan Seminar dan Integrasi Sistem Portal<br>
                &amp; Aplikasi BAKUMDA
            </h1>
            <div class="pks-nomor">Nomor: {{ $pks['nomor'] }}</div>

            <p style="margin-top: 16px;">
                Pada hari ini, {{ $pks['hari'] }} tanggal {{ $pks['tanggal_terbilang'] }} bulan {{ $pks['bulan'] }}
                tahun {{ $pks['tahun_terbilang'] }} ({{ $pks['tanggal_angka'] }}), kami yang bertanda tangan di bawah
                ini:
            </p>

            <!-- PIHAK PERTAMA -->
            <table class="pihak" style="margin: 14px 0 8px 6px; width: 100%;">
                <tr>
                    <td style="width: 20px;">1.</td>
                    <td style="width: 80px;">Nama</td>
                    <td style="width: 10px;">:</td>
                    <td><b>Junaedi Hasyim, S.H., M.H, CPM.</b></td>
                </tr>
                <tr>
                    <td></td>
                    <td>Jabatan</td>
                    <td>:</td>
                    <td>Direktur Bakumda</td>
                </tr>
                <tr>
                    <td></td>
                    <td>Alamat</td>
                    <td>:</td>
                    <td>Ruko Royal, Kompleks Pettarani Square Jl. A. P. Pettarani No.2, Masale, Kec. Panakkukang, Kota
                        Makassar, Sulawesi Selatan 90231.</td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="3" style="padding-top: 4px;">Dalam hal ini bertindak untuk dan atas nama Pengelola
                        Sistem BAKUMDA, yang
                        selanjutnya disebut sebagai <b>PIHAK PERTAMA</b>.</td>
                </tr>
            </table>

            <!-- PIHAK KEDUA -->
            <table class="pihak" style="margin: 12px 0 12px 6px; width: 100%;">
                <tr>
                    <td style="width: 20px;">2.</td>
                    <td style="width: 80px;">Nama</td>
                    <td style="width: 10px;">:</td>
                    <td><b>{{ $pemohon->name ?? '..........................................' }}</b></td>
                </tr>
                <tr>
                    <td></td>
                    <td>Instansi</td>
                    <td>:</td>
                    <td>{{ $kerjasama->mitra }}</td>
                </tr>
                <tr>
                    <td></td>
                    <td>Alamat</td>
                    <td>:</td>
                    <td>{{ $pemohon->alamat ?? '..........................................' }}</td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="3" style="padding-top: 4px;">Dalam hal ini bertindak untuk dan atas nama
                        {{ $kerjasama->mitra }}, yang
                        selanjutnya disebut sebagai <b>PIHAK KEDUA</b>.</td>
                </tr>
            </table>

            <p>
                PIHAK PERTAMA dan PIHAK KEDUA secara bersama-sama disebut <b>"PARA PIHAK"</b>, sepakat untuk mengikatkan
                diri
                dalam Perjanjian Kerja Sama Penyelenggaraan Seminar dengan ketentuan dan syarat-syarat sebagai berikut:
            </p>

            <!-- PASAL 1 -->
            <div class="pasal-blok">
                <div class="pasal">Pasal 1<br>Maksud dan Tujuan</div>
                <ol style="list-style-type: decimal !important; padding-left: 20px;">
                    <li>Maksud kerja sama ini adalah untuk menyelenggarakan kegiatan Seminar
                        <b>{{ $kerjasama->judul }}</b> dengan memanfaatkan infrastruktur digital dan sistem BAKUMDA.
                    </li>
                    <li>Tujuan kerja sama ini adalah untuk memfasilitasi pendaftaran peserta, pengelolaan data, serta
                        penerbitan e-sertifikat ber-QR Code secara terintegrasi melalui Portal dan Aplikasi BAKUMDA.</li>
                </ol>
            </div>


            <!-- PASAL 2 -->
            <div class="pasal-blok">
                <br>
                <br>
                <br>
                <div class="pasal">Pasal 2<br>Ruang Lingkup Kerja Sama</div>
                <p style="margin-bottom: 4px;">Ruang lingkup kerja sama ini meliputi:</p>
                <ol style="list-style-type: decimal !important; padding-left: 20px;">
                    <li>Pendaftaran dan pendataan peserta seminar melalui portal/sistem pendaftaran BAKUMDA.</li>
                    <li>Integrasi validasi data peserta dengan e-KTA / Sistem Keanggotaan BAKUMDA (jika berlaku).</li>
                    <li>Publikasi dan promosi seminar pada dashboard/portal berita BAKUMDA.</li>
                    <li>Generasi dan distribusi e-sertifikat digital terverifikasi QR Code melalui sistem BAKUMDA setelah
                        pelaksanaan kegiatan.</li>
                </ol>
            </div>

            <!-- PASAL 3 -->
            <div class="pasal-blok">
                <div class="pasal">Pasal 3<br>Biaya dan Pembagian Hasil</div>
                <ol style="list-style-type: decimal !important; padding-left: 20px;">
                    <li>Biaya registrasi/keikutsertaan seminar ditetapkan sebesar
                        <b>Rp. {{ $pks['biaya'] }},-</b> ({{ $pks['biaya_terbilang'] }}) per peserta.
                    </li>
                    <li>Seluruh penerimaan pendapatan dari pendaftaran peserta seminar melalui Sistem BAKUMDA akan dibagi
                        hasil dengan porsi sebagai berikut:
                        <ol class="alpha">
                            <li>PIHAK PERTAMA (Pengelola Sistem BAKUMDA) memperoleh bagian sebesar
                                {{ $pks['persen_pertama'] }}% ({{ $pks['persen_pertama_terbilang'] }} persen) dari total
                                pendapatan gross registrasi peserta.</li>
                            <li>PIHAK KEDUA (Penyelenggara / Mitra) memperoleh bagian sebesar
                                {{ $pks['persen_kedua'] }}% ({{ $pks['persen_kedua_terbilang'] }} persen) dari total
                                pendapatan gross registrasi peserta.</li>
                        </ol>
                    </li>
                    <li>Pembayaran dan penyelesaian pembagian hasil (settlement) dilakukan paling lambat 7 (tujuh) hari
                        kerja setelah pelaksanaan kegiatan seminar selesai melalui transfer ke rekening masing-masing
                        pihak.</li>
                </ol>
            </div>

            <!-- PASAL 4 -->
            <div class="pasal-blok">
                <div class="pasal">Pasal 4<br>Hak dan Kewajiban</div>
                <ol style="list-style-type: decimal !important; padding-left: 20px;">
                    <li>Hak dan Kewajiban PIHAK PERTAMA:
                        <ol class="alpha">
                            <li>Membuka formulir pendaftaran seminar di sistem BAKUMDA.</li>
                            <li>Memastikan keandalan sistem selama proses pendaftaran dan distribusi e-sertifikat.</li>
                            <li>Menyediakan akses verifikasi keabsahan e-sertifikat berbasis QR Code.</li>
                            <li>Berhak menerima data dan materi seminar yang sah dari PIHAK KEDUA.</li>
                        </ol>
                    </li>
                    <li>Hak dan Kewajiban PIHAK KEDUA:
                        <ol class="alpha">
                            <li>Menyediakan materi, pemateri/narasumber, dan pelaksanaan teknis seminar.</li>
                            <li>Menyediakan data detail kegiatan (jadwal, susunan acara, desain sertifikat/logo) kepada
                                PIHAK PERTAMA.</li>
                            <li>Berhak mendapatkan fasilitas pendaftaran dan distribusi e-sertifikat melalui sistem
                                BAKUMDA.</li>
                        </ol>
                    </li>
                </ol>
            </div>

            <!-- PASAL 5 -->
            <div class="pasal-blok">
                <br>
                <br>
                <br>
                <div class="pasal">Pasal 5<br>Penyelesaian Perselisihan</div>
                <ol style="list-style-type: decimal !important; padding-left: 20px;">
                    <li>Apabila dikemudian hari timbul perbedaan pendapat atau perselisihan dalam pelaksanaan Perjanjian
                        Kerja Sama ini, PARA PIHAK sepakat untuk menyelesaikannya secara musyawarah untuk mufakat.</li>
                    <li>Apabila penyelesaian secara musyawarah tidak mencapai mufakat, maka PARA PIHAK sepakat untuk
                        menyelesaikannya sesuai dengan ketentuan hukum yang berlaku.</li>
                </ol>
            </div>

            <!-- PASAL 6 -->
            <div class="pasal-blok">
                <div class="pasal">Pasal 6<br>Penutup</div>
                <p>
                    Demikian Surat Perjanjian Kerja Sama Penyelenggaraan Seminar ini dibuat dan disetujui oleh PARA
                    PIHAK secara sadar dan penuh kesadaran. Perjanjian ini berlaku sejak tanggal
                    {{ $pks['mulai'] }} hingga {{ $pks['selesai'] }}, atau hingga seluruh hak dan kewajiban
                    masing-masing pihak terpenuhi.
                </p>
            </div>

            <!-- TANDA TANGAN -->
            <div class="pasal-blok" style="margin-top: 30px;">
                <table style="width: 55%; margin-bottom: 20px;">
                    <tr>
                        <td style="width: 35%;">Dibuat di</td>
                        <td>: Makassar</td>
                    </tr>
                    <tr>
                        <td>Pada Tanggal</td>
                        <td>: {{ $pks['tanggal_surat'] }}</td>
                    </tr>
                </table>

                <table class="ttd" style="width: 100%;">
                    <tr>
                        <td style="width: 50%;">
                            PIHAK PERTAMA,<br>DIREKTUR BAKUMDA
                        </td>
                        <td style="width: 50%;">
                            PIHAK KEDUA,<br>{{ $kerjasama->mitra }}
                        </td>
                    </tr>
                    <tr>
                        <td style="height: 70px; vertical-align: bottom;">
                            <div style="font-size: 8pt; color: #fff; user-select: none;">-</div>
                        </td>
                        <td style="height: 70px; vertical-align: bottom;">
                            <div class="matrai">Meterai Rp 10.000</div>
                        </td>
                    </tr>
                    <tr>
                        <td><b><u>Junaedi Hasyim, S.H., M.H, CPM.</u></b></td>
                        <td><b><u>( {{ $pemohon->name ?? '..........................................' }} )</u></b></td>
                    </tr>
                </table>
            </div>

        </div>

    </div>
@endsection
