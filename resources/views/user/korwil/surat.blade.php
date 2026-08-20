@extends('layouts.app')

@section('title', 'Surat Penunjukan Korwil ' . $province)

@section('content')
    <div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8 space-y-6">

        {{-- Tombol Navigasi / Kembali --}}
        <div class="flex items-center justify-between no-print">
            <a href="{{ route('user.korwil.show', $province) }}"
                class="py-2 px-4 rounded-xl bg-white hover:bg-slate-100 text-slate-700 font-semibold text-xs uppercase tracking-wider transition flex items-center gap-2 border border-slate-200 shadow-sm">
                <i class="fa-solid fa-arrow-left text-rose-700"></i> <span>Kembali</span>
            </a>
            <button onclick="window.print()"
                class="py-2 px-4 rounded-xl bg-rose-700 hover:bg-rose-800 text-white font-semibold text-xs uppercase tracking-wider transition flex items-center gap-2 shadow-sm">
                {{-- <i class="fa-solid fa-print"></i> <span>Cetak Surat</span> --}}
            </button>
        </div>

        {{-- Lembar Surat Penunjukan (Kertas Dokumen Formal) --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-xl p-8 sm:p-14 text-slate-800 relative space-y-8">

            {{-- Kop Surat / Header Organisasi --}}
            <div class="text-center border-b-2 border-slate-900 pb-6 space-y-2">
                <div class="w-12 h-12 mx-auto rounded-xl bg-rose-700 text-white flex items-center justify-center text-xl shadow-md mb-2">
                    <i class="fa-solid fa-scale-balanced"></i>
                </div>
                <h2 class="text-lg sm:text-xl font-black uppercase tracking-wider text-slate-900">
                    PENGURUS PUSAT BAKUMDA
                </h2>
                <p class="text-xs text-slate-600 font-medium tracking-wide">
                    Badan Konsultasi dan Bantuan Hukum / Organisasi Daerah
                </p>
            </div>

            {{-- Judul Surat & Nomor --}}
            <div class="text-center space-y-1 pt-2">
                <h1 class="text-sm sm:text-base font-bold uppercase tracking-wide text-slate-900 underline underline-offset-4">
                    SURAT KEPUTUSAN PENGURUS PUSAT BAKUMDA
                </h1>
                <div class="pt-2">
                    <span class="text-xs font-bold text-slate-700 block uppercase">TENTANG</span>
                    <span class="text-xs font-semibold text-slate-900 uppercase">
                        PENUNJUKAN KOORDINATOR WILAYAH (KORWIL) PROVINSI {{ strtoupper($province) }}
                    </span>
                </div>
            </div>

            {{-- Bagian Menimbang --}}
            <div class="space-y-3 text-xs sm:text-sm text-justify leading-relaxed">
                <div class="font-bold uppercase tracking-wide text-slate-900">Menimbang:</div>
                <ol class="list-decimal list-inside space-y-2 pl-2 text-slate-700">
                    <li class="pl-1">
                        Bahwa dalam rangka memperluas jangkauan operasional dan efektivitas organisasi BAKUMDA di tingkat daerah, diperlukan adanya Koordinator Wilayah (Korwil).
                    </li>
                    <li class="pl-1">
                        Bahwa nama yang tercantum dalam surat ini dianggap cakap dan memenuhi syarat untuk mengemban amanah sebagai Korwil Provinsi.
                    </li>
                </ol>
            </div>

            {{-- Bagian Memutuskan / Menunjuk --}}
            <div class="space-y-4 text-xs sm:text-sm leading-relaxed">
                <div class="font-bold uppercase tracking-wide text-slate-900 text-center py-1 bg-slate-100 rounded-lg">
                    MEMUTUSKAN
                </div>
                
                <div class="space-y-1">
                    <span class="font-bold text-slate-900 block uppercase">Menunjuk:</span>
                </div>

                {{-- Kotak Detail Personil Korwil --}}
                <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 sm:p-5 space-y-2 text-xs sm:text-sm">
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-1">
                        <span class="font-semibold text-slate-500">Nama Lengkap</span>
                        <span class="sm:col-span-2 font-bold text-slate-900 uppercase">
                            : {{ optional($anggota)->nama ?? 'YASSER ARAFAT' }}
                        </span>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-1">
                        <span class="font-semibold text-slate-500">NIK / ID Anggota</span>
                        <span class="sm:col-span-2 font-bold font-mono text-rose-700">
                            : {{ optional($anggotaCard)->card_id ?? ($anggota->nia ?? 'KTPA.2026.0001') }}
                        </span>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-1">
                        <span class="font-semibold text-slate-500">Jabatan</span>
                        <span class="sm:col-span-2 font-bold text-slate-900 uppercase">
                            : Koordinator Wilayah (Korwil) Provinsi {{ $province }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Tugas dan Tanggung Jawab --}}
            <div class="space-y-3 text-xs sm:text-sm leading-relaxed">
                <div class="font-bold uppercase tracking-wide text-slate-900">Tugas dan Tanggung Jawab:</div>
                <ol class="list-decimal list-inside space-y-2 pl-2 text-slate-700">
                    <li class="pl-1">
                        Mengoordinasikan seluruh kegiatan organisasi BAKUMDA di wilayah Provinsi {{ $province }}.
                    </li>
                    <li class="pl-1">
                        Membangun komunikasi dan kerja sama dengan instansi terkait di tingkat daerah.
                    </li>
                    <li class="pl-1">
                        Melaporkan kegiatan secara berkala kepada Pengurus Pusat.
                    </li>
                </ol>
            </div>

            {{-- Penutup Surat --}}
            <div class="space-y-3 text-xs sm:text-sm text-justify leading-relaxed text-slate-700 pt-2">
                <p>
                    Surat penunjukan ini berlaku sejak tanggal ditetapkan hingga dilakukan evaluasi lebih lanjut oleh Pengurus Pusat.
                </p>
                <p>
                    Demikian surat penunjukan ini dibuat untuk dilaksanakan dengan penuh rasa tanggung jawab.
                </p>
            </div>

            {{-- Tanda Tangan & Penetapan --}}
            <div class="pt-8 flex flex-col sm:flex-row justify-between items-start sm:items-end text-xs sm:text-sm gap-6">
                <div class="space-y-1 text-slate-600">
                    <p class="font-semibold text-slate-900">Ditetapkan di: Makassar</p>
                    <p class="font-semibold text-slate-900">Pada tanggal: 18 Agustus 2026</p>
                </div>

                <div class="text-center sm:text-right space-y-16 w-full sm:w-auto">
                    <div>
                        <p class="font-bold uppercase text-slate-900">PENGURUS PUSAT BAKUMDA</p>
                        <p class="text-xs text-slate-500">Ketua Umum</p>
                    </div>
                    <div class="space-y-1">
                        <p class="font-bold underline uppercase text-slate-900">( _______________________ )</p>
                        <p class="text-[11px] text-slate-500 font-mono">NPA. PP BAKUMDA</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection