@extends('layouts.admin')

@section('title', 'Detail Kartu Anggota')

@section('content')
    <div class="space-y-6">

        @php
            $status = strtolower($anggotaCard->status ?? 'pending');
        @endphp

        @if (session('success'))
            <div
                class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 dark:bg-emerald-900/30 dark:border-emerald-800 dark:text-emerald-400 text-xs font-medium">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- KIRI: PREVIEW KARTU FISIK -->
            <div class="lg:col-span-1">
                <div
                    class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm text-center space-y-4">
                    <h3 class="text-xs uppercase tracking-wider font-semibold text-gray-400">Preview Kartu Anggota</h3>

                    <!-- CONTAINER KARTU FISIK -->
                    <div
                        class="relative w-[280px] h-[480px] mx-auto rounded-2xl overflow-hidden shadow-lg border border-gray-200 dark:border-gray-700 bg-white">

                        <!-- Layer 1: Background Template BAKUMDA -->
                        <img src="{{ asset('background.png') }}" class="absolute inset-0 w-full h-full object-cover z-0"
                            alt="Background ID Card">

                        <!-- Layer 2: Elemen Konten Kartu -->
                        <div class="relative z-10 w-full h-full">

                            <!-- 1. PAS FOTO -->
                            <div
                                class="absolute top-[201px] left-[50px] w-[95px] h-[129px] overflow-hidden rounded-sm flex items-center justify-center bg-black/10">
                                @if ($anggotaCard->anggota->foto ?? false)
                                    <img src="{{ asset('storage/' . $anggotaCard->anggota->foto) }}"
                                        class="w-full h-full object-cover">
                                @else
                                    <div class="flex flex-col items-center justify-center text-gray-300">
                                        <i class="fa-solid fa-user text-3xl"></i>
                                        <span class="text-[8px] mt-1">No Foto</span>
                                    </div>
                                @endif
                            </div>

                            <!-- 2. QR CODE + NIA -->
                            <div class="absolute top-[205px] left-[152px] w-[80px] flex flex-col items-center">
                                <div class="w-[78px] h-[78px] bg-white p-1 flex items-center justify-center">
                                    @if ($anggotaCard->qr_code)
                                        <img src="{{ asset('storage/' . $anggotaCard->qr_code) }}"
                                            class="w-full h-full object-contain">
                                    @else
                                        <div class="text-[8px] text-gray-400 text-center leading-tight">
                                            Belum<br>Terbit
                                        </div>
                                    @endif
                                </div>

                                @if ($anggotaCard->card_id)
                                    <span
                                        class="text-[8px] font-bold text-gray-900 font-sans tracking-tight mt-1 whitespace-nowrap">
                                        NIA. {{ $anggotaCard->card_id }}
                                    </span>
                                @endif
                            </div>

                            <!-- 3. NAMA & JABATAN -->
                            <div class="absolute top-[342px] inset-x-0 px-4 text-center">
                                <h2 class="text-[11px] font-extrabold text-gray-900 uppercase tracking-tight leading-snug">
                                    {{ $anggotaCard->anggota->user->name ?? '' }}
                                </h2>

                                @if (!empty($anggotaCard->jabatan))
                                    <p class="text-[9.5px] font-bold text-gray-800 uppercase tracking-wider mt-0.5">
                                        {{ $anggotaCard->jabatan }}
                                    </p>
                                @endif
                            </div>

                            <!-- 4. MASA BERLAKU -->
                            @if (!empty($anggotaCard->berlaku))
                                <div class="absolute bottom-[20px] left-[18px]">
                                    <p class="text-[8px] font-bold text-gray-900 tracking-tight">
                                        Berlaku s/d {{ \Carbon\Carbon::parse($anggotaCard->berlaku)->translatedFormat('d M Y') }}
                                    </p>
                                </div>
                            @endif

                        </div>
                    </div>

                    <p class="text-[11px] text-gray-400">
                        Tampilan presisi kartu anggota fisik BAKUMDA.
                    </p>
                </div>
            </div>

            <!-- KANAN: DETAIL BERDASARKAN STATUS -->
            <div class="lg:col-span-2 space-y-6">

                <!-- KONDISI 1: PENGAJUAN AWAL (PENDING) -->
                @if ($status === 'pending')
                    <div
                        class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm space-y-4">
                        <h3
                            class="text-sm font-bold text-gray-900 dark:text-gray-100 border-b border-gray-100 dark:border-gray-700 pb-3">
                            Detail Informasi Pendaftar
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
                            <div>
                                <span class="text-gray-400 block">NIK:</span>
                                <span
                                    class="font-medium text-gray-800 dark:text-gray-200">{{ $anggotaCard->anggota->user->nik ?? '-' }}</span>
                            </div>
                            <div>
                                <span class="text-gray-400 block">Email:</span>
                                <span
                                    class="font-medium text-gray-800 dark:text-gray-200">{{ $anggotaCard->anggota->user->email ?? '-' }}</span>
                            </div>
                            <div>
                                <span class="text-gray-400 block">No. HP:</span>
                                <span
                                    class="font-medium text-gray-800 dark:text-gray-200">{{ $anggotaCard->anggota->user->no_hp ?? '-' }}</span>
                            </div>
                            <div>
                                <span class="text-gray-400 block">Alamat:</span>
                                <span
                                    class="font-medium text-gray-800 dark:text-gray-200">{{ $anggotaCard->anggota->user->alamat ?? '-' }}</span>
                            </div>
                        </div>

                        <!-- Action Persetujuan Awal -->
                        <div class="pt-4 border-t border-gray-100 dark:border-gray-700 flex gap-2 justify-end">
                            <form action="{{ route('admin.anggota-card.status', $anggotaCard->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="approved">
                                <button type="submit"
                                    class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-medium rounded-xl transition">
                                    <i class="fa-solid fa-check mr-1"></i> Setujui Pengajuan
                                </button>
                            </form>

                            <form action="{{ route('admin.anggota-card.status', $anggotaCard->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="rejected">
                                <button type="submit"
                                    class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-xs font-medium rounded-xl transition">
                                    <i class="fa-solid fa-xmark mr-1"></i> Tolak
                                </button>
                            </form>
                        </div>
                    </div>
                @endif

                <!-- KONDISI 2: PERSETUJUAN / BELUM DITERBITKAN (APPROVED) -->
                @if ($status === 'approved')
                    <div
                        class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm space-y-4">
                        <div class="flex items-center justify-between border-b border-gray-100 dark:border-gray-700 pb-3">
                            <h3 class="text-sm font-bold text-gray-900 dark:text-gray-100 flex items-center gap-2">
                                <i class="fa-solid fa-id-card-clip text-brand-500"></i>
                                <span>Input Data Penerbitan Kartu</span>
                            </h3>
                            <span
                                class="px-2.5 py-1 text-[10px] font-semibold bg-emerald-50 text-emerald-600 rounded-full border border-emerald-200">
                                Status: Approved
                            </span>
                        </div>
                        <form action="{{ route('admin.anggota-card.simpan-kartu', $anggotaCard->id) }}" method="POST"
                            class="space-y-4">
                            @csrf

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="md:col-span-2">
                                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Jabatan
                                        Anggota</label>
                                    <input type="text" name="jabatan"
                                        value="{{ old('jabatan', $anggotaCard->jabatan ?? '') }}" required
                                        placeholder="Contoh: Advokat / Presiden Direktur"
                                        class="w-full text-xs rounded-xl bg-gray-50 dark:bg-gray-700/50 text-gray-800 dark:text-gray-100 border border-gray-200 dark:border-gray-600 focus:ring-2 focus:ring-brand-500 outline-none px-3 py-2">
                                </div>

                                <div>
                                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Tanggal
                                        Diterbitkan</label>
                                    <input type="date" name="diterbitkan"
                                        value="{{ old('diterbitkan', optional($anggotaCard->diterbitkan)->format('Y-m-d') ?? now()->format('Y-m-d')) }}"
                                        required
                                        class="w-full text-xs rounded-xl bg-gray-50 dark:bg-gray-700/50 text-gray-800 dark:text-gray-100 border border-gray-200 dark:border-gray-600 focus:ring-2 focus:ring-brand-500 outline-none px-3 py-2">
                                </div>

                                <div>
                                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Berakhir
                                        Kartu</label>
                                    <input type="date" name="berlaku"
                                        value="{{ old('berlaku', optional($anggotaCard->berlaku)->format('Y-m-d') ?? now()->addYears(5)->format('Y-m-d')) }}"
                                        required
                                        class="w-full text-xs rounded-xl bg-gray-50 dark:bg-gray-700/50 text-gray-800 dark:text-gray-100 border border-gray-200 dark:border-gray-600 focus:ring-2 focus:ring-brand-500 outline-none px-3 py-2">
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Catatan
                                    Tambahan (Opsional)</label>
                                <textarea name="keterangan" rows="2" placeholder="Tuliskan catatan opsional..."
                                    class="w-full text-xs rounded-xl bg-gray-50 dark:bg-gray-700/50 text-gray-800 dark:text-gray-100 border border-gray-200 dark:border-gray-600 focus:ring-2 focus:ring-brand-500 outline-none px-3 py-2">{{ old('keterangan', $anggotaCard->keterangan ?? '') }}</textarea>
                            </div>

                            <div class="flex justify-end pt-2">
                                <button type="submit"
                                    class="px-5 py-2.5 bg-brand-600 hover:bg-brand-700 text-white text-xs font-semibold rounded-xl transition shadow-sm flex items-center gap-2">
                                    <i class="fa-solid fa-floppy-disk"></i>
                                    <span>Simpan & Terbitkan Kartu</span>
                                </button>
                            </div>
                        </form>
                    </div>
                @endif

                <!-- KONDISI 3: KARTU AKTIF / DITERBITKAN (MENAMPILKAN SELURUH DATA LENGKAP) -->
                @if (in_array($status, ['diterbitkan', 'aktif', 'active']))
                    <div
                        class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm space-y-6">

                        <div class="flex items-center justify-between border-b border-gray-100 dark:border-gray-700 pb-3">
                            <h3 class="text-sm font-bold text-gray-900 dark:text-gray-100 flex items-center gap-2">
                                <i class="fa-solid fa-circle-check text-emerald-500"></i>
                                <span>Informasi Lengkap Kartu Anggota (Aktif)</span>
                            </h3>
                            <span
                                class="px-2.5 py-1 text-[10px] font-semibold bg-emerald-50 text-emerald-600 rounded-full border border-emerald-200">
                                Status: Aktif / Terbit
                            </span>
                        </div>

                        <!-- TAMPILKAN SEMUA DATA SECARA RINGKAS & RAPI -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-y-4 gap-x-6 text-xs">

                            <div class="space-y-1">
                                <span class="text-gray-400 block font-medium">Nama Lengkap</span>
                                <p class="font-bold text-gray-900 dark:text-gray-100 text-sm">
                                    {{ $anggotaCard->anggota->nama ?? '-' }}
                                </p>
                            </div>

                            <div class="space-y-1">
                                <span class="text-gray-400 block font-medium">Nomor Induk Anggota (NIA)</span>
                                <p class="font-bold text-brand-600 dark:text-brand-400 text-sm">
                                    {{ $anggotaCard->card_id ?? '-' }}
                                </p>
                            </div>

                            <div class="space-y-1">
                                <span class="text-gray-400 block font-medium">Jabatan</span>
                                <p class="font-medium text-gray-800 dark:text-gray-200">
                                    {{ $anggotaCard->jabatan ?? '-' }}
                                </p>
                            </div>

                            <div class="space-y-1">
                                <span class="text-gray-400 block font-medium">NIK / No. Identitas</span>
                                <p class="font-medium text-gray-800 dark:text-gray-200">
                                    {{ $anggotaCard->anggota->nik ?? '-' }}
                                </p>
                            </div>

                            <div class="space-y-1">
                                <span class="text-gray-400 block font-medium">Tanggal Diterbitkan</span>
                                <p class="font-medium text-gray-800 dark:text-gray-200">
                                    {{ optional($anggotaCard->diterbitkan)->translatedFormat('d F Y') ?? '-' }}
                                </p>
                            </div>

                            <div class="space-y-1">
                                <span class="text-gray-400 block font-medium">Masa Berlaku Kartu</span>
                                <p class="font-medium text-gray-800 dark:text-gray-200">
                                    {{ optional($anggotaCard->berlaku)->translatedFormat('d F Y') ?? '-' }}
                                </p>
                            </div>

                            <div class="space-y-1">
                                <span class="text-gray-400 block font-medium">Email</span>
                                <p class="font-medium text-gray-800 dark:text-gray-200">
                                    {{ $anggotaCard->anggota->email ?? '-' }}
                                </p>
                            </div>

                            <div class="space-y-1">
                                <span class="text-gray-400 block font-medium">Nomor HP / WhatsApp</span>
                                <p class="font-medium text-gray-800 dark:text-gray-200">
                                    {{ $anggotaCard->anggota->no_hp ?? '-' }}
                                </p>
                            </div>

                            <div class="md:col-span-2 space-y-1">
                                <span class="text-gray-400 block font-medium">Alamat Lengkap</span>
                                <p class="font-medium text-gray-800 dark:text-gray-200">
                                    {{ $anggotaCard->anggota->alamat ?? '-' }}
                                </p>
                            </div>

                            @if (!empty($anggotaCard->keterangan))
                                <div
                                    class="md:col-span-2 space-y-1 bg-gray-50 dark:bg-gray-700/30 p-3 rounded-xl border border-gray-100 dark:border-gray-700">
                                    <span class="text-gray-400 block font-medium">Catatan / Keterangan</span>
                                    <p class="font-medium text-gray-700 dark:text-gray-300">
                                        {{ $anggotaCard->keterangan }}
                                    </p>
                                </div>
                            @endif

                        </div>

                        <!-- TOMBOL AKSI CETAK ATAU UBAH DATA -->
                        <div class="pt-4 border-t border-gray-100 dark:border-gray-700 flex flex-wrap gap-2 justify-end">
                            <form action="{{ route('admin.anggota-card.status', $anggotaCard->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="approved">
                                <button type="submit"
                                    class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-xs font-semibold rounded-xl transition flex items-center gap-1.5">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                    <span>Edit Data Kartu</span>
                                </button>
                            </form>
                        </div>

                    </div>
                @endif

            </div>

        </div>
    </div>
@endsection