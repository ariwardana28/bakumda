@extends('layouts.admin')

@section('content')
    <div class="container mx-auto px-4 py-6 max-w-7xl">
        {{-- Header Section --}}
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-800 tracking-tight">Detail Lengkap Pendaftaran & Pembayaran Peserta
                </h2>
                <p class="text-sm text-gray-500 mt-0.5">Informasi data diri, dokumen pendukung, dan transaksi pelatihan.</p>
            </div>
            <a href="{{ route('admin.pelatihan-anggota.index') }}"
                class="px-4 py-2 bg-gray-100 text-gray-600 hover:bg-gray-200 rounded-xl text-sm font-semibold transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                    </path>
                </svg>
                Kembali
            </a>
        </div>

        {{-- Notifikasi Sukses / Gagal --}}
        @if (session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl text-sm font-medium">
                {{ session('success') }}
            </div>
        @endif

        {{-- Grid Utama (2 Kolom: Kiri untuk Data Diri & Transaksi, Kanan untuk Dokumen & Bukti) --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            {{-- KOLOM KIRI: Data Diri & Informasi Pelatihan --}}
            <div class="space-y-6">

                {{-- Data Diri Peserta --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-4">
                    <h3
                        class="text-sm font-bold text-gray-800 uppercase tracking-wider border-b border-gray-100 pb-3 flex items-center gap-2">
                        <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Data Diri Peserta
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="text-xs text-gray-400 uppercase tracking-wider block">Nama Lengkap</span>
                            <span
                                class="font-bold text-gray-800 text-base">{{ $pembayaran->pelatihanAnggota->nama ?? ($pembayaran->user->name ?? '-') }}</span>
                        </div>
                        <div>
                            <span class="text-xs text-gray-400 uppercase tracking-wider block">Nomor KTP (NIK)</span>
                            <span
                                class="font-semibold text-gray-700">{{ $pembayaran->pelatihanAnggota->no_ktp ?? '-' }}</span>
                        </div>
                        <div>
                            <span class="text-xs text-gray-400 uppercase tracking-wider block">Jenis Kelamin</span>
                            <span class="text-gray-700">{{ $pembayaran->pelatihanAnggota->jenis_kelamin ?? '-' }}</span>
                        </div>
                        <div>
                            <span class="text-xs text-gray-400 uppercase tracking-wider block">TTL</span>
                            <span class="text-gray-700">{{ $pembayaran->pelatihanAnggota->tempat_lahir ?? '-' }},
                                {{ $pembayaran->pelatihanAnggota->tanggal_lahir ? \Carbon\Carbon::parse($pembayaran->pelatihanAnggota->tanggal_lahir)->translatedFormat('d F Y') : '-' }}</span>
                        </div>
                        <div>
                            <span class="text-xs text-gray-400 uppercase tracking-wider block">Agama</span>
                            <span class="text-gray-700">{{ $pembayaran->pelatihanAnggota->agama ?? '-' }}</span>
                        </div>
                        <div>
                            <span class="text-xs text-gray-400 uppercase tracking-wider block">Status Perkawinan</span>
                            <span class="text-gray-700">{{ $pembayaran->pelatihanAnggota->status_perkawinan ?? '-' }}</span>
                        </div>
                        <div>
                            <span class="text-xs text-gray-400 uppercase tracking-wider block">Pekerjaan</span>
                            <span class="text-gray-700">{{ $pembayaran->pelatihanAnggota->pekerjaan ?? '-' }}</span>
                        </div>
                        <div>
                            <span class="text-xs text-gray-400 uppercase tracking-wider block">Kewarganegaraan</span>
                            <span class="text-gray-700">{{ $pembayaran->pelatihanAnggota->kewarganegaraan ?? '-' }}</span>
                        </div>
                        <div>
                            <span class="text-xs text-gray-400 uppercase tracking-wider block">Email</span>
                            <span
                                class="text-gray-700">{{ $pembayaran->pelatihanAnggota->email ?? ($pembayaran->user->email ?? '-') }}</span>
                        </div>
                        <div>
                            <span class="text-xs text-gray-400 uppercase tracking-wider block">No. HP / WhatsApp</span>
                            <span
                                class="text-gray-700 font-medium">{{ $pembayaran->pelatihanAnggota->no_hp ?? '-' }}</span>
                        </div>
                    </div>

                    <div class="border-t border-gray-100 pt-3 mt-2 text-sm space-y-2">
                        <div>
                            <span class="text-xs text-gray-400 uppercase tracking-wider block">Alamat Lengkap</span>
                            <span
                                class="text-gray-700 font-medium">{{ $pembayaran->pelatihanAnggota->alamat ?? '-' }}</span>
                        </div>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-2 pt-1 text-xs">
                            <div class="bg-gray-50 p-2 rounded-lg">
                                <span class="text-gray-400 block">Kelurahan</span>
                                <span
                                    class="font-medium text-gray-700">{{ $pembayaran->pelatihanAnggota->kelurahan ?? '-' }}</span>
                            </div>
                            <div class="bg-gray-50 p-2 rounded-lg">
                                <span class="text-gray-400 block">Kecamatan</span>
                                <span
                                    class="font-medium text-gray-700">{{ $pembayaran->pelatihanAnggota->kecamatan ?? '-' }}</span>
                            </div>
                            <div class="bg-gray-50 p-2 rounded-lg">
                                <span class="text-gray-400 block">Kota/Kab</span>
                                <span
                                    class="font-medium text-gray-700">{{ $pembayaran->pelatihanAnggota->kota ?? '-' }}</span>
                            </div>
                            <div class="bg-gray-50 p-2 rounded-lg">
                                <span class="text-gray-400 block">Provinsi</span>
                                <span
                                    class="font-medium text-gray-700">{{ $pembayaran->pelatihanAnggota->provinsi ?? '-' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Pas Foto, Foto KTP, & Pakta Integritas --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-4">
                    <h3
                        class="text-sm font-bold text-gray-800 uppercase tracking-wider border-b border-gray-100 pb-3 flex items-center gap-2">
                        <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 19a2 2 0 01-2-2V7a2 2 0 012-2h4l2 2h4a2 2 0 012 2v1M5 19h14a2 2 0 002-2v-5a2 2 0 00-2-2H9a2 2 0 00-2 2v5a2 2 0 01-2 2z">
                            </path>
                        </svg>
                        Dokumen & Berkas Peserta
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-center">
                        {{-- Pas Foto --}}
                        <div class="space-y-2">
                            <span class="text-xs font-semibold text-gray-500 block">Pas Foto</span>
                            @if ($pembayaran->pelatihanAnggota->foto)
                                <div
                                    class="h-32 border rounded-xl overflow-hidden bg-gray-50 flex items-center justify-center">
                                    <img src="{{ asset('storage/' . $pembayaran->pelatihanAnggota->foto) }}"
                                        alt="Foto Peserta" class="object-cover h-full w-full">
                                </div>
                                <a href="{{ asset('storage/' . $pembayaran->pelatihanAnggota->foto) }}" target="_blank"
                                    class="text-xs text-indigo-600 hover:underline inline-block">Lihat Foto</a>
                            @else
                                <div
                                    class="h-32 border border-dashed rounded-xl flex items-center justify-center text-gray-400 text-xs bg-gray-50">
                                    Tidak ada</div>
                            @endif
                        </div>

                        {{-- Foto KTP --}}
                        <div class="space-y-2">
                            <span class="text-xs font-semibold text-gray-500 block">Foto KTP</span>
                            @if ($pembayaran->pelatihanAnggota->foto_ktp)
                                <div
                                    class="h-32 border rounded-xl overflow-hidden bg-gray-50 flex items-center justify-center">
                                    <img src="{{ asset('storage/' . $pembayaran->pelatihanAnggota->foto_ktp) }}"
                                        alt="Foto KTP" class="object-cover h-full w-full">
                                </div>
                                <a href="{{ asset('storage/' . $pembayaran->pelatihanAnggota->foto_ktp) }}" target="_blank"
                                    class="text-xs text-indigo-600 hover:underline inline-block">Lihat
                                    KTP</a>
                            @else
                                <div
                                    class="h-32 border border-dashed rounded-xl flex items-center justify-center text-gray-400 text-xs bg-gray-50">
                                    Tidak ada</div>
                            @endif
                        </div>

                        {{-- Pakta Integritas --}}
                        <div class="space-y-2">
                            <span class="text-xs font-semibold text-gray-500 block">Pakta Integritas</span>
                            @if ($pembayaran->pelatihanAnggota->pakta_integritas)
                                <div
                                    class="h-32 border rounded-xl overflow-hidden bg-gray-50 flex flex-col items-center justify-center p-2">
                                    <svg class="w-10 h-10 text-red-500 mb-1" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    <span class="text-[10px] text-gray-500 truncate w-full">Dokumen Terlampir</span>
                                </div>
                                <a href="{{ asset('storage/' . $pembayaran->pelatihanAnggota->pakta_integritas) }}"
                                    target="_blank" class="text-xs text-indigo-600 hover:underline inline-block">Unduh /
                                    Lihat</a>
                            @else
                                <div
                                    class="h-32 border border-dashed rounded-xl flex items-center justify-center text-gray-400 text-xs bg-gray-50">
                                    Tidak ada</div>
                            @endif
                        </div>
                    </div>
                </div>

            </div>

            {{-- KOLOM KANAN: Dokumen, Foto, & Bukti Transfer --}}
            <div class="space-y-6">

                {{-- Bukti Transfer --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col justify-between">
                    <div>
                        <h3
                            class="text-sm font-bold text-gray-800 uppercase tracking-wider border-b border-gray-100 pb-3 mb-4 flex items-center gap-2">
                            <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                                </path>
                            </svg>
                            Bukti Transfer Pembayaran
                        </h3>

                        @if ($pembayaran->bukti_pembayaran)
                            <div
                                class="overflow-hidden rounded-xl border border-gray-200 bg-gray-900 flex items-center justify-center relative group max-h-[280px]">
                                <img src="{{ asset('storage/' . $pembayaran->bukti_pembayaran) }}" alt="Bukti Transfer"
                                    class="object-contain w-full max-h-[280px]">
                            </div>
                            <div class="mt-3">
                                <a href="{{ asset('storage/' . $pembayaran->bukti_pembayaran) }}" target="_blank"
                                    class="w-full py-2 bg-cyan-600 hover:bg-cyan-700 text-white rounded-xl text-xs font-semibold shadow transition flex items-center justify-center gap-2">
                                    Perbesar Bukti Transfer (Tab Baru)
                                </a>
                            </div>
                        @else
                            <div
                                class="h-36 flex items-center justify-center text-gray-400 border border-dashed border-gray-200 rounded-xl bg-gray-50">
                                <p class="text-xs">Bukti pembayaran belum diunggah.</p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Informasi Pelatihan & Pembayaran --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-4">
                    <h3
                        class="text-sm font-bold text-gray-800 uppercase tracking-wider border-b border-gray-100 pb-3 flex items-center gap-2">
                        <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                        Informasi Pelatihan & Transaksi
                    </h3>

                    <div class="space-y-3 text-sm">
                        <div>
                            <span class="text-xs text-gray-400 uppercase tracking-wider block">Judul Pelatihan</span>
                            <span
                                class="font-bold text-gray-800 text-base">{{ $pembayaran->pelatihan->judul ?? '-' }}</span>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <span class="text-xs text-gray-400 uppercase tracking-wider block">Nominal
                                    Pembayaran</span>
                                <span class="text-lg font-extrabold text-indigo-600">Rp
                                    {{ number_format($pembayaran->jumlah_pembayaran ?? 0, 0, ',', '.') }}</span>
                            </div>
                            <div>
                                <span class="text-xs text-gray-400 uppercase tracking-wider block">Status Pembayaran</span>
                                <span
                                    class="inline-block mt-1 px-2.5 py-1 rounded-full text-xs font-semibold 
                                    {{ $pembayaran->status_pembayaran == 'diterima' ? 'bg-emerald-50 text-emerald-600' : ($pembayaran->status_pembayaran == 'ditolak' ? 'bg-red-50 text-red-600' : 'bg-amber-50 text-amber-600') }}">
                                    {{ ucfirst($pembayaran->status_pembayaran ?? 'Menunggu') }}
                                </span>
                            </div>
                        </div>

                        <div>
                            <span class="text-xs text-gray-400 uppercase tracking-wider block">Catatan Pembayaran dari
                                Peserta</span>
                            <p class="text-sm text-gray-600 bg-gray-50 p-3 rounded-xl border border-gray-100 mt-1 italic">
                                {{ $pembayaran->catatan ?? 'Tidak ada catatan.' }}
                            </p>
                        </div>

                        <div>
                            <span class="text-xs text-gray-400 uppercase tracking-wider block">Keterangan / Tambahan</span>
                            <p class="text-sm text-gray-600 bg-gray-50 p-3 rounded-xl border border-gray-100 mt-1">
                                {{ $pembayaran->pelatihanAnggota->keterangan ?? 'Tidak ada keterangan.' }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- CARD AKSI VERIFIKASI PEMBAYARAN --}}
                @if ($pembayaran->status_pembayaran == 'pending')
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-4">
                        <h3
                            class="text-sm font-bold text-gray-800 uppercase tracking-wider border-b border-gray-100 pb-3 flex items-center gap-2">
                            <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Aksi Verifikasi Pembayaran
                        </h3>

                        <form action="{{ route('admin.pelatihan.verifikasi.update', $pembayaran->id) }}" method="POST"
                            class="space-y-4">
                            @csrf
                            {{-- Karena menggunakan route POST, hapus @method('PUT') atau @method('PATCH') --}}

                            <div>
                                <label for="aksi"
                                    class="block text-xs text-gray-400 uppercase tracking-wider mb-1 font-semibold">Ubah
                                    Status
                                    Pembayaran</label>
                                <select name="aksi" id="aksi"
                                    class="w-full rounded-xl border-gray-200 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="verified"
                                        {{ $pembayaran->status_pembayaran == 'verified' ? 'selected' : '' }}>Terima
                                        (Setujui)
                                    </option>
                                <option value="rejected"
                                        {{ $pembayaran->status_pembayaran == 'rejected' ? 'selected' : '' }}>Tolak</option>
                                </select>
                            </div>

                            <div>
                                <label for="keterangan_admin"
                                    class="block text-xs text-gray-400 uppercase tracking-wider mb-1 font-semibold">Catatan
                                    /
                                    Alasan (Opsional)</label>
                                <textarea name="keterangan_admin" id="keterangan_admin" rows="2"
                                    placeholder="Masukkan catatan jika diperlukan..."
                                    class="w-full rounded-xl border-gray-200 text-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                            </div>

                            <div class="flex items-center gap-3 pt-2">
                                <button type="submit"
                                    class="flex-1 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-sm font-semibold shadow transition text-center">
                                    Simpan Verifikasi
                                </button>
                            </div>
                        </form>
                    </div>
                @endif



            </div>

        </div>
    </div>
@endsection
