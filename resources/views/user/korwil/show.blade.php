@extends('layouts.app')

@section('title', 'Detail Korwil ' . $province)

@section('content')
    <div class="p-6 sm:p-10">
        @if ($korwils->isNotEmpty())
            <div class="space-y-12">
                @foreach ($korwils as $item)
                    @php
                        $anggotaCard = $item->anggotaCard;
                        $anggota = optional(optional($item->anggotaCard)->anggota);
                        $latestBerlaku = optional($item->anggotaCard)->latestBerlaku;
                    @endphp

                    {{-- Card Style Mengikuti Referensi Gambar (Profil Lingkaran Menjorok ke Banner) --}}
                    <div
                        class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden relative max-w-3xl mx-auto">

                        {{-- Banner atas kartu --}}
                        <div class="h-32 relative" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);">
                            <div
                                class="absolute inset-0 bg-[radial-gradient(#ffffff_1px,transparent_1px)] [background-size:12px_12px] opacity-10">
                            </div>
                        </div>

                        {{-- Foto Profil Bulat yang Menjorok ke Atas (Overlap Banner & Content) --}}
                        <div class="flex justify-center -mt-16 relative z-10 px-4">
                            <div class="relative">
                                <div class="w-32 h-32 rounded-full p-1.5 bg-white shadow-md">
                                    @if (optional($anggota)->foto)
                                        <img src="{{ asset('storage/' . optional($anggota)->foto) }}"
                                            class="w-full h-full object-cover rounded-full">
                                    @else
                                        <div
                                            class="w-full h-full bg-slate-100 rounded-full flex flex-col items-center justify-center text-slate-400">
                                            <i class="fa-solid fa-user text-3xl"></i>
                                        </div>
                                    @endif
                                </div>
                                {{-- Badge Status Aktif / Centang Hijau --}}
                                <span
                                    class="absolute bottom-1 right-1 w-7 h-7 bg-emerald-500 border-2 border-white rounded-full flex items-center justify-center text-white text-xs shadow">
                                    <i class="fa-solid fa-check"></i>
                                </span>
                            </div>
                        </div>

                        {{-- Informasi Identitas Singkat --}}
                        <div class="text-center px-6 pt-3 pb-6 space-y-1 border-b border-slate-100">
                            <h2 class="text-lg sm:text-xl font-black text-slate-900 uppercase tracking-tight">
                                {{ optional($anggota)->nama ?? 'YASSER ARAFAT' }}
                            </h2>
                            <p class="text-xs font-semibold text-rose-700 uppercase tracking-wider">
                                {{ optional($latestBerlaku)->jabatan ?? ($item->jabatan ?? 'Koordinator Wilayah') }}
                            </p>

                        </div>

                        {{-- Bagian Informasi Detail & Legal/Organisasi --}}
                        <div class="p-6 sm:p-8 space-y-6 bg-slate-50/50">
                            {{-- <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400">Informasi & Detail
                                Anggota</h3> --}}

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                                {{-- Card 1: Surat Penunjukan --}}
                                <a href="{{ route('user.korwil.surat', optional($anggotaCard)->id) }}"
                                    class="bg-white p-5 rounded-3xl border border-slate-200/80 shadow-sm hover:shadow-md hover:border-rose-300 transition flex items-center gap-4 group">

                                    {{-- Kotak Ikon Merah --}}
                                    <div
                                        class="w-12 h-12 rounded-2xl bg-rose-700 text-white flex items-center justify-center text-lg shadow-sm group-hover:scale-105 transition shrink-0">
                                        <i class="fa-solid fa-file-lines"></i>
                                    </div>

                                    {{-- Teks Info --}}
                                    <div class="space-y-0.5 overflow-hidden">
                                        <h3
                                            class="text-sm font-bold text-slate-900 group-hover:text-rose-700 transition truncate">
                                            Surat Penunjukan
                                        </h3>
                                        <p class="text-xs text-slate-400 font-medium truncate">
                                            Dokumen Resmi Korwil
                                        </p>
                                    </div>
                                </a>

                                {{-- Card 2: Hubungi Korwil (WhatsApp) --}}
                                @php
                                    // Mengambil nomor HP dan membersihkannya dari karakter non-angka
                                    $rawPhone = optional($anggota)->no_hp ?? '085350439065';
                                    $cleanedPhone = preg_replace('/[^0-9]/', '', $rawPhone);

                                    // Mengubah awalan '0' menjadi kode negara '62'
                                    if (substr($cleanedPhone, 0, 1) === '0') {
                                        $cleanedPhone = '62' . substr($cleanedPhone, 1);
                                    }

                                    // Mendapatkan nama pengguna yang sedang login menggunakan Auth::user()
                                    $namaPengirim = Auth::user() ? Auth::user()->name : 'Nama Anda';
                                    $namaKorwil = optional($anggota)->nama ?? 'Bapak/Ibu';

                                    // Format pesan WhatsApp dengan nama otomatis
                                    $pesanWhatsApp = "Halo Bapak/Ibu {$namaKorwil}, Saya {$namaPengirim} saat ini kami sedang menghadapi kendala, saya mohon arahan atau petunjuk dari Bapak/Ibu selaku Korwil Provinsi agar langkah yang kami ambil tetap sejalan dengan kebijakan pusat. Mohon kesediaan waktu Bapak/Ibu jika ada kesempatan untuk berdiskusi lebih lanjut. Terima kasih.";

                                    $waLink = "https://wa.me/{$cleanedPhone}?text=" . urlencode($pesanWhatsApp);
                                @endphp

                                <a href="{{ $waLink }}" target="_blank"
                                    class="bg-white p-5 rounded-3xl border border-slate-200/80 shadow-sm hover:shadow-md hover:border-emerald-300 transition flex items-center gap-4 group">

                                    {{-- Kotak Ikon Hijau WhatsApp --}}
                                    <div
                                        class="w-12 h-12 rounded-2xl bg-emerald-600 text-white flex items-center justify-center text-lg shadow-sm group-hover:scale-105 transition shrink-0">
                                        <i class="fa-brands fa-whatsapp"></i>
                                    </div>

                                    {{-- Teks Info --}}
                                    <div class="space-y-0.5 overflow-hidden">
                                        <h3
                                            class="text-sm font-bold text-slate-900 group-hover:text-emerald-700 transition truncate">
                                            Hubungi Korwil
                                        </h3>
                                        <p class="text-xs text-slate-400 font-medium truncate font-mono">
                                            {{ optional($anggota)->no_hp ?? '085350439065' }}
                                        </p>
                                    </div>
                                </a>

                            </div>

                            {{-- Alamat Lengkap --}}
                            <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-sm space-y-1">
                                <span class="text-[10px] font-medium text-slate-400 block">Alamat Lengkap</span>
                                <p class="text-xs font-bold text-slate-900 leading-relaxed">
                                    {{ optional($anggota)->alamat ?? 'Samboja' }}
                                    @if (optional($anggota)->kelurahan ?? false)
                                        , Kel. {{ $anggota->kelurahan }}
                                    @endif
                                    @if (optional($anggota)->kecamatan ?? false)
                                        , Kec. {{ $anggota->kecamatan }}
                                    @endif
                                    @if (optional($anggota)->kota ?? false)
                                        , {{ $anggota->kota }}
                                    @endif
                                    , Prov. {{ optional($anggota)->provinsi ?? $province }}
                                </p>
                            </div>

                       
                        </div>

                    </div>
                @endforeach
            </div>
        @else
            {{-- Pesan Jika Data Kosong --}}
            <div
                class="py-16 text-center text-slate-500 font-medium bg-slate-100/80 rounded-2xl border border-slate-200/80">
                <i class="fa-solid fa-folder-open text-4xl text-slate-300 mb-3"></i>
                <p class="text-sm font-bold text-slate-600">Data Belum Tersedia</p>
                <p class="text-xs max-w-xs mx-auto mt-1">Saat ini belum ada data Koordinator Wilayah (Korwil) yang
                    terisi untuk provinsi {{ $province }}.</p>
            </div>
        @endif

        {{-- Tombol Kembali --}}
        <div class="mt-10 pt-6 border-t border-slate-200/60 flex items-center justify-between">
            <a href="{{ route('korwil') }}"
                class="py-2.5 px-5 rounded-2xl bg-white hover:bg-slate-100 text-slate-700 font-semibold text-xs uppercase tracking-wider transition flex items-center gap-2 border border-slate-200 shadow-sm">
                <i class="fa-solid fa-arrow-left text-rose-700"></i> <span>Kembali ke Daftar Provinsi</span>
            </a>
            <span class="text-[11px] text-slate-400 font-medium">BAKUMDA &copy; {{ date('Y') }}</span>
        </div>
    </div>

@endsection
