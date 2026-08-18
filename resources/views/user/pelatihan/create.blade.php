@extends('layouts.app')

@section('content')
    {{-- Tambahkan CDN CSS TomSelect di bagian atas --}}
    @push('styles')
        {{-- TomSelect CSS --}}
        <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">
        <style>
            .ts-control {
                padding: 0.75rem 1rem !important;
                font-size: 0.875rem !important;
                line-height: 1.25rem !important;
                border-radius: 0.75rem !important;
                border-color: rgb(229 231 235) !important;
                box-shadow: none !important;
                background-color: transparent !important;
            }

            .ts-wrapper.focus .ts-control {
                border-color: rgb(59 130 246) !important;
                box-shadow: 0 0 0 2px rgb(59 130 246 / 0.2) !important;
            }

            .ts-dropdown {
                border-radius: 0.75rem !important;
                margin-top: 4px !important;
                border-color: rgb(229 231 235) !important;
                box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1) !important;
                background-color: #fff !important;
            }

            .ts-dropdown .dropdown-input {
                border-radius: 0.5rem !important;
                padding: 0.5rem 0.75rem !important;
                margin: 8px !important;
                width: calc(100% - 16px) !important;
                border: 1px solid rgb(229 231 235) !important;
                background-color: #ffffff !important;
                color: #0f172a !important;
            }

            .ts-dropdown .dropdown-input::placeholder {
                color: #94a3b8 !important;
                opacity: 1;
            }
        </style>
    @endpush

    <div class="container mx-auto px-4 sm:px-6 py-6 sm:py-10 max-w-6xl relative space-y-6">

        {{-- Latar Belakang Dekoratif Glow Abstrak --}}
        <div class="absolute top-10 left-1/4 w-72 h-72 sm:w-96 sm:h-96 bg-orange-500/10 dark:bg-orange-500/5 rounded-full blur-3xl pointer-events-none -z-10"></div>
        <div class="absolute top-64 right-10 w-64 h-64 sm:w-80 sm:h-80 bg-orange-600/10 dark:bg-orange-600/5 rounded-full blur-3xl pointer-events-none -z-10"></div>

        {{-- Tombol Kembali --}}
        <div>
            <a href="{{ route('user-pelatihan.index') }}"
                class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white/80 dark:bg-slate-900/80 backdrop-blur-xl border border-slate-200/80 dark:border-slate-800 text-slate-600 dark:text-slate-300 hover:text-orange-600 dark:hover:text-orange-400 hover:border-orange-300 dark:hover:border-orange-700 font-bold text-xs shadow-xs transition-all duration-200 group">
                <div class="w-5 h-5 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 group-hover:bg-orange-500 group-hover:text-white flex items-center justify-center transition-all duration-200">
                    <svg class="w-3 h-3 transition-transform group-hover:-translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </div>
                <span>Kembali ke Daftar Pelatihan</span>
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 sm:gap-8">
            {{-- Sisi Kiri: Ringkasan Program --}}
            <div class="lg:col-span-1 space-y-6">
                <div class="bg-white/80 dark:bg-slate-900/80 backdrop-blur-2xl rounded-[2rem] shadow-xl shadow-slate-200/50 dark:shadow-none border border-slate-200/80 dark:border-slate-800 p-6 sticky top-6">
                    <h3 class="text-sm font-bold text-slate-900 dark:text-white mb-4 pb-3 border-b border-slate-100 dark:border-slate-800 uppercase tracking-wider">Ringkasan Program</h3>

                    <div class="relative h-40 w-full bg-slate-900 rounded-2xl overflow-hidden mb-4 group shadow-md">
                        @if ($pelatihan->gambar)
                            <img src="{{ asset('storage/' . $pelatihan->gambar) }}" alt="{{ $pelatihan->judul }}"
                                class="w-full h-full object-cover opacity-90 transition-transform duration-700 group-hover:scale-105">
                        @else
                            <div class="flex items-center justify-center h-full text-slate-400 bg-slate-800 text-xs font-semibold">Tidak ada gambar</div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent"></div>
                    </div>

                    <h4 class="font-extrabold text-slate-900 dark:text-white text-base mb-3 leading-snug">{{ $pelatihan->judul }}</h4>

                    <div class="space-y-3 pt-3 border-t border-slate-100 dark:border-slate-800 text-xs text-slate-600 dark:text-slate-300">
                        <div class="flex items-center justify-between p-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-800">
                            <span class="text-slate-400 font-bold uppercase tracking-wider text-[10px]">Jadwal:</span>
                            <span class="font-bold text-slate-800 dark:text-slate-200 text-right">
                                {{ \Carbon\Carbon::parse($pelatihan->tanggal_mulai)->format('d M Y') }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between p-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-800">
                            <span class="text-slate-400 font-bold uppercase tracking-wider text-[10px]">Biaya Investasi:</span>
                            <span class="font-extrabold {{ $pelatihan->harga == 0 ? 'text-emerald-600 dark:text-emerald-400' : 'text-orange-500 dark:text-orange-400' }}">
                                {{ $pelatihan->harga == 0 ? 'Gratis' : 'Rp ' . number_format($pelatihan->harga, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>

                    <div class="mt-6 p-4 rounded-2xl bg-orange-500/10 border border-orange-500/20 text-xs text-orange-700 dark:text-orange-300 leading-relaxed backdrop-blur-md">
                        <span class="font-bold block mb-1 uppercase tracking-wider text-[10px]">Catatan Penting:</span>
                        Pastikan seluruh dokumen diunggah dengan format yang benar dan data diri sesuai identitas resmi.
                    </div>
                </div>
            </div>

            {{-- Sisi Kanan: Form Pendaftaran Lengkap --}}
            <div class="lg:col-span-2">
                <div class="bg-white/80 dark:bg-slate-900/80 backdrop-blur-2xl rounded-[2rem] shadow-xl shadow-slate-200/50 dark:shadow-none border border-slate-200/80 dark:border-slate-800 p-6 sm:p-8">
                    <div class="mb-6 sm:mb-8">
                        <div class="inline-flex items-center gap-1.5 mb-2 px-3 py-1 bg-orange-500/10 text-orange-600 dark:text-orange-400 rounded-full text-[10px] font-bold uppercase tracking-wider border border-orange-500/20">
                            Formulir Registrasi Lengkap
                        </div>
                        <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight">Data Diri Peserta Pelatihan</h1>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Lengkapi data pribadi dan berkas persyaratan di bawah ini.</p>
                    </div>

                    @if ($errors->any())
                        <div class="mb-6 p-4 bg-red-50 dark:bg-red-950/40 border border-red-200 dark:border-red-900 rounded-2xl text-red-700 dark:text-red-300 text-xs space-y-1">
                            <span class="font-bold block text-sm mb-1">Terjadi Kesalahan Pengisian:</span>
                            <ul class="list-disc pl-4 space-y-0.5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form id="formPendaftaran" action="{{ route('user-pelatihan.store', $pelatihan->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf

                        {{-- Hidden Input untuk mengirim data approve pakta integritas --}}
                        <input type="hidden" name="pakta_integritas" id="hiddenPaktaIntegritas" value="{{ old('pakta_integritas') }}">

                        {{-- Hidden Input untuk kode referral --}}
                        <input type="hidden" name="referral_code" id="hiddenReferralCode" value="{{ old('referral_code') }}">

                        {{-- 1. Nama Lengkap & No KTP --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-[10px] sm:text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">Nama Lengkap (Beserta Gelar)</label>
                                <input type="text" name="nama" value="{{ old('nama', Auth::user()->name) }}" required
                                    placeholder="Contoh: Dr. Ahmad Fauzi, S.H., M.H."
                                    class="w-full px-4 py-3 text-xs sm:text-sm rounded-xl border border-slate-200 dark:border-slate-800 bg-white/50 dark:bg-slate-800/50 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-orange-500">
                            </div>
                            <div>
                                <label class="block text-[10px] sm:text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">Nomor KTP (NIK)</label>
                                <input type="text" name="no_ktp" value="{{ old('no_ktp') }}" required
                                    placeholder="16 digit nomor KTP" maxlength="16"
                                    class="w-full px-4 py-3 text-xs sm:text-sm rounded-xl border border-slate-200 dark:border-slate-800 bg-white/50 dark:bg-slate-800/50 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-orange-500">
                            </div>
                        </div>

                        {{-- 2. Tempat & Tanggal Lahir --}}
                        <div class="mt-5 grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-[10px] sm:text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">Tempat Lahir</label>
                                <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}" required
                                    placeholder="Contoh: Makassar"
                                    class="w-full px-4 py-3 text-xs sm:text-sm rounded-xl border border-slate-200 dark:border-slate-800 bg-white/50 dark:bg-slate-800/50 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-orange-500">
                            </div>
                            <div>
                                <label class="block text-[10px] sm:text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">Tanggal Lahir</label>
                                <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required
                                    class="w-full px-4 py-3 text-xs sm:text-sm rounded-xl border border-slate-200 dark:border-slate-800 bg-white/50 dark:bg-slate-800/50 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-orange-500">
                            </div>
                        </div>

                        {{-- 3. Jenis Kelamin & Agama --}}
                        <div class="mt-5 grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-[10px] sm:text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">Jenis Kelamin</label>
                                <select name="jenis_kelamin" required
                                    class="w-full px-4 py-3 text-xs sm:text-sm rounded-xl border border-slate-200 dark:border-slate-800 bg-white/50 dark:bg-slate-800/50 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-orange-500">
                                    <option value="">-- Pilih Jenis Kelamin --</option>
                                    <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-[10px] sm:text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">Agama</label>
                                <select name="agama" required
                                    class="w-full px-4 py-3 text-xs sm:text-sm rounded-xl border border-slate-200 dark:border-slate-800 bg-white/50 dark:bg-slate-800/50 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-orange-500">
                                    <option value="">-- Pilih Agama --</option>
                                    <option value="Islam" {{ old('agama') == 'Islam' ? 'selected' : '' }}>Islam</option>
                                    <option value="Kristen" {{ old('agama') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                                    <option value="Katolik" {{ old('agama') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                                    <option value="Hindu" {{ old('agama') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                    <option value="Buddha" {{ old('agama') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                                    <option value="Konghucu" {{ old('agama') == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                                </select>
                            </div>
                        </div>

                        {{-- 4. Status Perkawinan & Kewarganegaraan --}}
                        <div class="mt-5 grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-[10px] sm:text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">Status Perkawinan</label>
                                <select name="status_perkawinan" required
                                    class="w-full px-4 py-3 text-xs sm:text-sm rounded-xl border border-slate-200 dark:border-slate-800 bg-white/50 dark:bg-slate-800/50 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-orange-500">
                                    <option value="">-- Pilih Status --</option>
                                    <option value="Belum Menikah" {{ old('status_perkawinan') == 'Belum Menikah' ? 'selected' : '' }}>Belum Menikah</option>
                                    <option value="Menikah" {{ old('status_perkawinan') == 'Menikah' ? 'selected' : '' }}>Menikah</option>
                                    <option value="Cerai" {{ old('status_perkawinan') == 'Cerai' ? 'selected' : '' }}>Cerai</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-[10px] sm:text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">Kewarganegaraan</label>
                                <input type="text" name="kewarganegaraan" value="{{ old('kewarganegaraan', 'WNI') }}" required
                                    class="w-full px-4 py-3 text-xs sm:text-sm rounded-xl border border-slate-200 dark:border-slate-800 bg-white/50 dark:bg-slate-800/50 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-orange-500">
                            </div>
                        </div>

                        {{-- 5. Pekerjaan --}}
                        <div class="mt-5">
                            <label class="block text-[10px] sm:text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">Pekerjaan / Profesi</label>
                            <input type="text" name="pekerjaan" value="{{ old('pekerjaan') }}" required
                                placeholder="Contoh: Advokat / Pegawai Swasta / Mahasiswa"
                                class="w-full px-4 py-3 text-xs sm:text-sm rounded-xl border border-slate-200 dark:border-slate-800 bg-white/50 dark:bg-slate-800/50 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-orange-500">
                        </div>

                        {{-- 6. Kontak (No HP & Email) --}}
                        <div class="mt-5 grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-[10px] sm:text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">Nomor HP / WhatsApp</label>
                                <input type="text" name="no_hp" value="{{ old('no_hp') }}" required
                                    placeholder="08xxxxxxxxxx"
                                    class="w-full px-4 py-3 text-xs sm:text-sm rounded-xl border border-slate-200 dark:border-slate-800 bg-white/50 dark:bg-slate-800/50 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-orange-500">
                            </div>
                            <div>
                                <label class="block text-[10px] sm:text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">Alamat Email Aktif</label>
                                <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}" required
                                    placeholder="nama@domain.com"
                                    class="w-full px-4 py-3 text-xs sm:text-sm rounded-xl border border-slate-200 dark:border-slate-800 bg-white/50 dark:bg-slate-800/50 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-orange-500">
                            </div>
                        </div>

                        {{-- 7. Alamat Domisili --}}
                        <div class="mt-6 space-y-4 p-5 rounded-2xl bg-slate-50/80 dark:bg-slate-800/40 border border-slate-200/60 dark:border-slate-800 shadow-inner">
                            <span class="font-bold text-slate-900 dark:text-white text-xs uppercase tracking-wider block">Informasi Alamat Domisili</span>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                                <div>
                                    <label for="provinsi" class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-2">Provinsi</label>
                                    <select id="provinsi" name="provinsi" autocomplete="off" placeholder="Pilih Provinsi...">
                                        <option value="">-- Pilih Provinsi --</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="kota" class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-2">Kota/Kabupaten</label>
                                    <select id="kota" name="kota" autocomplete="off" placeholder="Pilih Kota/Kabupaten...">
                                        <option value="">-- Pilih Kota/Kabupaten --</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="kecamatan" class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-2">Kecamatan</label>
                                    <select id="kecamatan" name="kecamatan" autocomplete="off" placeholder="Pilih Kecamatan...">
                                        <option value="">-- Pilih Kecamatan --</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="kelurahan" class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-2">Kelurahan/Desa</label>
                                    <select id="kelurahan" name="kelurahan" autocomplete="off" placeholder="Pilih Kelurahan/Desa...">
                                        <option value="">-- Pilih Kelurahan/Desa --</option>
                                    </select>
                                </div>
                            </div>

                            <div>
                                <label class="block text-[10px] sm:text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">Alamat Lengkap (Jalan, No. Rumah, RT/RW)</label>
                                <textarea name="alamat" rows="2" required placeholder="Nama jalan, nomor rumah, RT/RW..."
                                    class="w-full px-4 py-3 text-xs sm:text-sm rounded-xl border border-slate-200 dark:border-slate-800 bg-white/50 dark:bg-slate-800/50 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-orange-500">{{ old('alamat') }}</textarea>
                            </div>
                        </div>

                        {{-- 8. Berkas Unggahan --}}
                        <div class="mt-6 space-y-4">
                            <span class="font-bold text-slate-900 dark:text-white text-xs uppercase tracking-wider block">Unggah Berkas Persyaratan</span>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="p-4 rounded-2xl bg-slate-50/80 dark:bg-slate-800/40 border border-slate-200/60 dark:border-slate-800 flex flex-col justify-between shadow-xs">
                                    <div>
                                        <label class="block text-[10px] sm:text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1">Foto / Scan KTP</label>
                                        <p class="text-[10px] text-slate-400 mb-3">Format: JPG, PNG, atau PDF.</p>
                                        <input type="file" name="foto_ktp" id="foto_ktp" accept="image/*,.pdf" required
                                            class="w-full text-xs text-slate-500 dark:text-slate-400 file:mr-2 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-[10px] file:font-bold file:bg-orange-500 file:text-white hover:file:bg-orange-600 cursor-pointer border border-slate-200 dark:border-slate-800 rounded-xl bg-white dark:bg-slate-900 p-1">
                                    </div>
                                    <div class="mt-3">
                                        <img id="preview_ktp" src="#" alt="Pratinjau KTP" class="hidden w-full h-28 object-cover rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
                                    </div>
                                </div>

                                <div class="p-4 rounded-2xl bg-slate-50/80 dark:bg-slate-800/40 border border-slate-200/60 dark:border-slate-800 flex flex-col justify-between shadow-xs">
                                    <div>
                                        <label class="block text-[10px] sm:text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1">Pas Foto Resmi</label>
                                        <p class="text-[10px] text-slate-400 mb-3">Latar Belakang Merah/Biru.</p>
                                        <input type="file" name="foto" id="foto" accept="image/*" required
                                            class="w-full text-xs text-slate-500 dark:text-slate-400 file:mr-2 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-[10px] file:font-bold file:bg-orange-500 file:text-white hover:file:bg-orange-600 cursor-pointer border border-slate-200 dark:border-slate-800 rounded-xl bg-white dark:bg-slate-900 p-1">
                                    </div>
                                    <div class="mt-3 flex justify-center">
                                        <img id="preview_foto" src="#" alt="Pratinjau Pas Foto" class="hidden w-20 h-28 object-cover rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Tombol Aksi --}}
                        <div class="mt-8 flex items-center justify-end gap-3 pt-5 border-t border-slate-100 dark:border-slate-800">
                            <a href="{{ route('user-pelatihan.index') }}"
                                class="px-5 py-3 rounded-xl border border-slate-200 dark:border-slate-800 text-xs font-bold text-slate-700 dark:text-slate-200 bg-white dark:bg-slate-800 hover:bg-slate-100 transition-colors shadow-xs">
                                Batal
                            </a>
                            <button type="button" id="btnOpenModal"
                                class="px-6 py-3 rounded-xl bg-orange-500 hover:bg-orange-600 text-white text-xs font-bold shadow-lg shadow-orange-500/25 transition-all duration-200 hover:scale-[1.02]">
                                Kirim Pendaftaran
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Syarat & Ketentuan / Pakta Integritas --}}
    <div id="modalSyarat" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-slate-950/60 backdrop-blur-sm p-4">
        <div class="bg-white dark:bg-slate-900 rounded-[2rem] max-w-lg w-full p-6 sm:p-8 shadow-2xl border border-slate-200 dark:border-slate-800 transform transition-all">
            <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100 dark:border-slate-800">
                <h3 class="text-base font-extrabold text-slate-900 dark:text-white uppercase tracking-wider">Syarat & Ketentuan / Pakta Integritas</h3>
                <button type="button" onclick="closeModalSyarat()" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <div class="max-h-60 overflow-y-auto text-xs text-slate-600 dark:text-slate-300 space-y-3 pr-2 mb-5 leading-relaxed">
                <p class="font-bold text-slate-800 dark:text-slate-200">Dengan menekan tombol setuju dan melanjutkan pendaftaran, saya menyatakan bahwa:</p>
                <ol class="list-decimal pl-4 space-y-2">
                    <li>Semua data dan informasi yang saya isikan pada formulir pendaftaran ini adalah benar, sah, dan sesuai dengan dokumen identitas resmi (KTP).</li>
                    <li>Saya sanggup mematuhi seluruh aturan, tata tertib, dan ketentuan yang berlaku selama mengikuti program pelatihan ini di BAKUMDA.</li>
                    <li>Saya bertanggung jawab penuh atas keaslian berkas-berkas yang diunggah, termasuk scan KTP dan pas foto.</li>
                    <li>Apabila di kemudian hari ditemukan ketidaksesuaian atau pelanggaran atas pernyataan ini, pihak penyelenggara berhak membatalkan status kepesertaan saya.</li>
                </ol>
            </div>

            <div class="p-4 rounded-xl bg-orange-500/10 border border-orange-500/20 mb-6">
                <label class="flex items-start gap-3 cursor-pointer">
                    <input type="checkbox" id="checkboxIntegritas"
                        class="mt-0.5 rounded border-slate-300 text-orange-500 focus:ring-orange-500 w-4 h-4 cursor-pointer">
                    <span class="text-xs font-bold text-orange-800 dark:text-orange-300 select-none">
                        Saya telah membaca, memahami, dan menyetujui seluruh syarat ketentuan serta pakta integritas di atas.
                    </span>
                </label>
            </div>

            <div class="flex items-center justify-end gap-3">
                <button type="button" onclick="closeModalSyarat()"
                    class="px-5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 text-xs font-bold text-slate-700 dark:text-slate-200 bg-white dark:bg-slate-800 hover:bg-slate-100 transition">
                    Batal
                </button>
                <button type="button" id="btnConfirmSubmit" disabled
                    class="px-6 py-2.5 rounded-xl bg-orange-500 text-white text-xs font-bold opacity-50 cursor-not-allowed shadow-md transition">
                    Setuju & Simpan Pendaftaran
                </button>
            </div>
        </div>
    </div>

    {{-- Modal Kode Referral --}}
    <div id="modalReferral" class="fixed inset-0 z-[60] hidden flex items-center justify-center bg-slate-950/60 backdrop-blur-sm p-4">
        <div class="bg-white dark:bg-slate-900 rounded-[2rem] max-w-sm w-full p-6 sm:p-8 shadow-2xl border border-slate-200 dark:border-slate-800 transform transition-all">
            <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100 dark:border-slate-800">
                <h3 class="text-base font-extrabold text-slate-900 dark:text-white uppercase tracking-wider">Punya Kode Referral?</h3>
                <button type="button" id="btnCloseReferralModal" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <div class="space-y-4">
                <p class="text-xs text-slate-600 dark:text-slate-300">
                    Jika Anda memiliki kode referral, masukkan di bawah ini untuk mendapatkan benefit. Jika tidak, Anda bisa melanjutkan pendaftaran.
                </p>

                <div>
                    <label for="referral_code_input" class="block text-[10px] sm:text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">Kode Referral</label>
                    <input type="text" id="referral_code_input" placeholder="Masukkan kode di sini"
                        class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 dark:border-slate-800 bg-white/50 dark:bg-slate-800/50 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-orange-500 uppercase tracking-widest font-mono">
                </div>
            </div>

            <div class="mt-6 flex flex-col sm:flex-row-reverse items-center gap-3 pt-4 border-t border-slate-100 dark:border-slate-800">
                <button type="button" id="btnApplyReferral"
                    class="w-full sm:w-auto px-6 py-2.5 rounded-xl bg-orange-500 hover:bg-orange-600 text-white text-xs font-bold shadow-md transition">
                    Terapkan & Lanjutkan
                </button>
                <button type="button" id="btnSkipReferral"
                    class="w-full sm:w-auto px-5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 text-xs font-bold text-slate-700 dark:text-slate-200 bg-white dark:bg-slate-800 hover:bg-slate-100 transition">
                    Lanjutkan Tanpa Kode
                </button>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
        <script>
            // 1. Script Image Preview
            function setupImagePreview(inputId, previewId) {
                const input = document.getElementById(inputId);
                const preview = document.getElementById(previewId);

                if (input) {
                    input.addEventListener('change', function(event) {
                        const file = event.target.files[0];
                        if (file && file.type.startsWith('image/')) {
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                preview.src = e.target.result;
                                preview.classList.remove('hidden');
                            }
                            reader.readAsDataURL(file);
                        } else {
                            preview.src = '#';
                            preview.classList.add('hidden');
                        }
                    });
                }
            }

            // 2. Inisialisasi TomSelect
            let provinceSelectInstance, regencySelectInstance, districtSelectInstance, villageSelectInstance;

            function initTomSelects() {
                const commonConfig = {
                    create: false,
                    sortField: { field: "text", direction: "asc" },
                    plugins: ['dropdown_input']
                };

                provinceSelectInstance = new TomSelect("#provinsi", commonConfig);
                regencySelectInstance = new TomSelect("#kota", commonConfig);
                districtSelectInstance = new TomSelect("#kecamatan", commonConfig);
                villageSelectInstance = new TomSelect("#kelurahan", commonConfig);
            }

            // 3. Logika Kontrol Modal & Sinkronisasi Checkbox ke Hidden Input
            const modalSyarat = document.getElementById('modalSyarat');
            const btnOpenModal = document.getElementById('btnOpenModal');
            const checkboxIntegritas = document.getElementById('checkboxIntegritas');
            const hiddenPaktaIntegritas = document.getElementById('hiddenPaktaIntegritas');
            const btnConfirmSubmit = document.getElementById('btnConfirmSubmit');
            const formPendaftaran = document.getElementById('formPendaftaran');
            const modalReferral = document.getElementById('modalReferral');
            const btnCloseReferralModal = document.getElementById('btnCloseReferralModal');
            const btnApplyReferral = document.getElementById('btnApplyReferral');
            const btnSkipReferral = document.getElementById('btnSkipReferral');
            const referralInput = document.getElementById('referral_code_input');
            const hiddenReferralCode = document.getElementById('hiddenReferralCode');

            btnOpenModal.addEventListener('click', function() {
                // if (formPendaftaran.checkValidity()) {
                    modalSyarat.classList.remove('hidden');
                // } else {
                //     formPendaftaran.reportValidity();
                // }
            });

            function closeModalSyarat() {
                modalSyarat.classList.add('hidden');
            }

            function openReferralModal() {
                modalReferral.classList.remove('hidden');
            }

            function closeReferralModal() {
                modalReferral.classList.add('hidden');
            }


            checkboxIntegritas.addEventListener('change', function() {
                if (this.checked) {
                    btnConfirmSubmit.disabled = false;
                    btnConfirmSubmit.classList.remove('opacity-50', 'cursor-not-allowed');
                } else {
                    btnConfirmSubmit.disabled = true;
                    btnConfirmSubmit.classList.add('opacity-50', 'cursor-not-allowed');
                }
            });

            btnConfirmSubmit.addEventListener('click', function() {
                if (checkboxIntegritas.checked) {
                    // Setujui pakta integritas
                    hiddenPaktaIntegritas.value = "approve";
                    // Tutup modal syarat dan buka modal referral
                    closeModalSyarat();
                    openReferralModal();
                }
            });

            // Logika Modal Referral
            btnCloseReferralModal.addEventListener('click', closeReferralModal);

            btnApplyReferral.addEventListener('click', function() {
                hiddenReferralCode.value = referralInput.value.trim().toUpperCase();
                formPendaftaran.submit();
            });

            btnSkipReferral.addEventListener('click', function() {
                formPendaftaran.submit();
            });

            // Sinkronisasi state jika terjadi redirect kembali karena error validasi
            document.addEventListener("DOMContentLoaded", function() {
                setupImagePreview('foto_ktp', 'preview_ktp');
                setupImagePreview('foto', 'preview_foto');
                initTomSelects();

                if (hiddenPaktaIntegritas.value) {
                    checkboxIntegritas.checked = true;
                    btnConfirmSubmit.disabled = false;
                    btnConfirmSubmit.classList.remove('opacity-50', 'cursor-not-allowed');
                }

                // Fetch Wilayah Indonesia (Provinsi, Kota, Kecamatan, Kelurahan)
                const provinceSelect = document.getElementById('provinsi');
                const regencySelect = document.getElementById('kota');
                const districtSelect = document.getElementById('kecamatan');
                const villageSelect = document.getElementById('kelurahan');
                
                const oldValues = {
                    provinsi: "{{ old('provinsi') }}",
                    kota: "{{ old('kota') }}",
                    kecamatan: "{{ old('kecamatan') }}",
                    kelurahan: "{{ old('kelurahan') }}"
                };

                function resetDropdown(instance, placeholder) {
                    instance.clear();
                    instance.clearOptions();
                    instance.addOption({ value: "", text: placeholder });
                    instance.setValue("");
                    instance.disable();
                }

                // Fetch Provinces
                fetch('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json').then(response => response.json()).then(provinces => {
                    provinceSelectInstance.clearOptions();
                    provinceSelectInstance.addOption({ value: "", text: "-- Pilih Provinsi --" });
                    provinces.forEach(p => provinceSelectInstance.addOption({ value: p.name, text: p.name, 'data-id': p.id }));
                    if (oldValues.provinsi) {
                        provinceSelectInstance.setValue(oldValues.provinsi);
                    } else {
                        provinceSelectInstance.setValue("");
                    }
                });

                // Province Change Event
                provinceSelectInstance.on('change', function(value) {
                    resetDropdown(regencySelectInstance, '-- Pilih Kota/Kabupaten --');
                    resetDropdown(districtSelectInstance, '-- Pilih Kecamatan --');
                    resetDropdown(villageSelectInstance, '-- Pilih Kelurahan/Desa --');

                    if (!value) return;

                    const provinceId = provinceSelectInstance.options[value]['data-id'];
                    regencySelectInstance.enable();
                    regencySelectInstance.load(function(callback) {
                        fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${provinceId}.json`)
                            .then(response => response.json())
                            .then(regencies => {
                                const options = regencies.map(r => ({ value: r.name, text: r.name, 'data-id': r.id }));
                                callback(options);
                                if (oldValues.kota) {
                                    regencySelectInstance.setValue(oldValues.kota);
                                    oldValues.kota = null; // Prevent re-triggering
                                }
                            }).catch(() => callback());
                    });
                });

                // Regency Change Event
                regencySelectInstance.on('change', function(value) {
                    resetDropdown(districtSelectInstance, '-- Pilih Kecamatan --');
                    resetDropdown(villageSelectInstance, '-- Pilih Kelurahan/Desa --');

                    if (!value) return;

                    const regencyId = regencySelectInstance.options[value]['data-id'];
                    districtSelectInstance.enable();
                    districtSelectInstance.load(function(callback) {
                        fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/districts/${regencyId}.json`)
                            .then(response => response.json())
                            .then(districts => {
                                const options = districts.map(d => ({ value: d.name, text: d.name, 'data-id': d.id }));
                                callback(options);
                                if (oldValues.kecamatan) {
                                    districtSelectInstance.setValue(oldValues.kecamatan);
                                    oldValues.kecamatan = null;
                                }
                            }).catch(() => callback());
                    });
                });

                // District Change Event
                districtSelectInstance.on('change', function(value) {
                    resetDropdown(villageSelectInstance, '-- Pilih Kelurahan/Desa --');

                    if (!value) return;

                    const districtId = districtSelectInstance.options[value]['data-id'];
                    villageSelectInstance.enable();
                    villageSelectInstance.load(function(callback) {
                        fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/villages/${districtId}.json`)
                            .then(response => response.json())
                            .then(villages => {
                                const options = villages.map(v => ({ value: v.name, text: v.name, 'data-id': v.id }));
                                callback(options);
                                if (oldValues.kelurahan) {
                                    villageSelectInstance.setValue(oldValues.kelurahan);
                                    oldValues.kelurahan = null;
                                }
                            }).catch(() => callback());
                    });
                });

                // Initial state
                if (!oldValues.provinsi) {
                    regencySelectInstance.clearOptions();
                    districtSelectInstance.disable();
                    villageSelectInstance.disable();
                }
            });
        </script>
    @endpush
@endsection