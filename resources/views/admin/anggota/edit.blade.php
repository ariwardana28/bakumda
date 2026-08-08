@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-6xl">
    {{-- Header --}}
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-gray-800 tracking-tight">Ubah Data Anggota</h2>
        <p class="text-sm text-gray-500 mt-1">Perbarui informasi identitas atau berkas dokumen anggota yang sudah terdaftar.</p>
    </div>

    {{-- Alert Error --}}
    @if ($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-r-xl mb-6 shadow-sm" role="alert">
            <div class="flex items-center mb-1">
                <svg class="w-5 h-5 mr-2 fill-current text-red-500" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"/></svg>
                <strong class="font-semibold">Terjadi beberapa kesalahan:</strong>
            </div>
            <ul class="list-disc list-inside text-sm space-y-1 pl-7">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.anggota.update', $anggota->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf
        @method('PUT')

        {{-- SECTION 1: DATA DIRI --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
            <div class="flex items-center gap-3 border-b border-gray-100 pb-4 mb-6">
                <div class="p-2 bg-indigo-50 rounded-xl text-indigo-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-800">Ubah Data Diri</h3>
                    <p class="text-xs text-gray-400">Perbarui informasi identitas & kontak anggota</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Nama Lengkap --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2" for="nama">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </span>
                        <input class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 outline-none" id="nama" name="nama" type="text" placeholder="Masukkan nama lengkap" value="{{ old('nama', $anggota->nama) }}" required>
                    </div>
                </div>

                {{-- No. KTP --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2" for="no_ktp">
                        No. KTP (NIK)
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3 3 0 00-3 3h6a3 3 0 00-3-3z"></path></svg>
                        </span>
                        <input class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 outline-none" id="no_ktp" name="no_ktp" type="text" placeholder="16 digit Nomor KTP" value="{{ old('no_ktp', $anggota->no_ktp) }}">
                    </div>
                </div>

                {{-- Email --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2" for="email">
                        Email
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </span>
                        <input class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 outline-none" id="email" name="email" type="email" placeholder="contoh@domain.com" value="{{ old('email', $anggota->email) }}">
                    </div>
                </div>

                {{-- No HP --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2" for="no_hp">
                        No. HP / WhatsApp
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                        </span>
                        <input class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 outline-none" id="no_hp" name="no_hp" type="text" placeholder="08xxxxxxxxxx" value="{{ old('no_hp', $anggota->no_hp) }}">
                    </div>
                </div>

                {{-- Jenis Kelamin --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2" for="jenis_kelamin">
                        Jenis Kelamin
                    </label>
                    <select name="jenis_kelamin" id="jenis_kelamin" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 outline-none cursor-pointer">
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="Laki-laki" @if(old('jenis_kelamin', $anggota->jenis_kelamin) == 'Laki-laki') selected @endif>Laki-laki</option>
                        <option value="Perempuan" @if(old('jenis_kelamin', $anggota->jenis_kelamin) == 'Perempuan') selected @endif>Perempuan</option>
                    </select>
                </div>

                {{-- Pekerjaan --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2" for="pekerjaan">
                        Pekerjaan / Jabatan
                    </label>
                    <input class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 outline-none" id="pekerjaan" name="pekerjaan" type="text" placeholder="Pekerjaan" value="{{ old('pekerjaan', $anggota->pekerjaan) }}">
                </div>

                {{-- Tempat Lahir --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2" for="tempat_lahir">
                        Tempat Lahir
                    </label>
                    <input class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 outline-none" id="tempat_lahir" name="tempat_lahir" type="text" placeholder="Tempat Lahir" value="{{ old('tempat_lahir', $anggota->tempat_lahir) }}">
                </div>

                {{-- Tanggal Lahir --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2" for="tanggal_lahir">
                        Tanggal Lahir
                    </label>
                    <input class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 outline-none cursor-pointer" id="tanggal_lahir" name="tanggal_lahir" type="date" value="{{ old('tanggal_lahir', $anggota->tanggal_lahir) }}">
                </div>

                {{-- Agama --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2" for="agama">
                        Agama
                    </label>
                    <select name="agama" id="agama" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 outline-none cursor-pointer">
                        <option value="">-- Pilih Agama --</option>
                        <option value="Islam" {{ old('agama', $anggota->agama) == 'Islam' ? 'selected' : '' }}>Islam</option>
                        <option value="Kristen Protestan" {{ old('agama', $anggota->agama) == 'Kristen Protestan' ? 'selected' : '' }}>Kristen Protestan</option>
                        <option value="Katolik" {{ old('agama', $anggota->agama) == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                        <option value="Hindu" {{ old('agama', $anggota->agama) == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                        <option value="Buddha" {{ old('agama', $anggota->agama) == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                        <option value="Khonghucu" {{ old('agama', $anggota->agama) == 'Khonghucu' ? 'selected' : '' }}>Khonghucu</option>
                    </select>
                </div>

                {{-- Status Perkawinan --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2" for="status_perkawinan">
                        Status Perkawinan
                    </label>
                    <select name="status_perkawinan" id="status_perkawinan" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 outline-none cursor-pointer">
                        <option value="">-- Pilih Status --</option>
                        <option value="Belum Kawin" {{ old('status_perkawinan', $anggota->status_perkawinan) == 'Belum Kawin' ? 'selected' : '' }}>Belum Kawin</option>
                        <option value="Kawin" {{ old('status_perkawinan', $anggota->status_perkawinan) == 'Kawin' ? 'selected' : '' }}>Kawin</option>
                        <option value="Cerai Hidup" {{ old('status_perkawinan', $anggota->status_perkawinan) == 'Cerai Hidup' ? 'selected' : '' }}>Cerai Hidup</option>
                        <option value="Cerai Mati" {{ old('status_perkawinan', $anggota->status_perkawinan) == 'Cerai Mati' ? 'selected' : '' }}>Cerai Mati</option>
                    </select>
                </div>

                {{-- Provinsi --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2" for="provinsi_id">
                        Provinsi
                    </label>
                    <select name="provinsi_id" id="provinsi_id" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 outline-none cursor-pointer">
                        <option value="">Pilih Provinsi</option>
                    </select>
                    <input type="hidden" name="provinsi" id="provinsi" value="{{ old('provinsi', $anggota->provinsi) }}">
                </div>

                {{-- Kota/Kabupaten --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2" for="kota_id">
                        Kota/Kabupaten
                    </label>
                    <select name="kota_id" id="kota_id" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 outline-none cursor-pointer" disabled>
                        <option value="">Pilih Kota/Kabupaten</option>
                    </select>
                    <input type="hidden" name="kota" id="kota" value="{{ old('kota', $anggota->kota) }}">
                </div>

                {{-- Kecamatan --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2" for="kecamatan_id">
                        Kecamatan
                    </label>
                    <select name="kecamatan_id" id="kecamatan_id" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 outline-none cursor-pointer" disabled>
                        <option value="">Pilih Kecamatan</option>
                    </select>
                    <input type="hidden" name="kecamatan" id="kecamatan" value="{{ old('kecamatan', $anggota->kecamatan) }}">
                </div>

                {{-- Kelurahan/Desa --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2" for="kelurahan_id">
                        Kelurahan/Desa
                    </label>
                    <select name="kelurahan_id" id="kelurahan_id" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 outline-none cursor-pointer" disabled>
                        <option value="">Pilih Kelurahan/Desa</option>
                    </select>
                    <input type="hidden" name="kelurahan" id="kelurahan" value="{{ old('kelurahan', $anggota->kelurahan) }}">
                </div>

                {{-- Kewarganegaraan --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2" for="kewarganegaraan">
                        Kewarganegaraan
                    </label>
                    <select name="kewarganegaraan" id="kewarganegaraan" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 outline-none cursor-pointer">
                        <option value="WNI" {{ old('kewarganegaraan', $anggota->kewarganegaraan) == 'WNI' ? 'selected' : '' }}>WNI (Warga Negara Indonesia)</option>
                        <option value="WNA" {{ old('kewarganegaraan', $anggota->kewarganegaraan) == 'WNA' ? 'selected' : '' }}>WNA (Warga Negara Asing)</option>
                    </select>
                </div>

                {{-- Alamat --}}
                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2" for="alamat">
                        Alamat Lengkap
                    </label>
                    <textarea class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 outline-none resize-none" id="alamat" name="alamat" rows="2" placeholder="Detail Jalan, No. Rumah, RT/RW">{{ old('alamat', $anggota->alamat) }}</textarea>
                </div>
                
                {{-- Keterangan --}}
                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2" for="keterangan">
                        Keterangan
                    </label>
                    <textarea class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 outline-none resize-none" id="keterangan" name="keterangan" rows="2" placeholder="Keterangan tambahan">{{ old('keterangan', $anggota->keterangan) }}</textarea>
                </div>
            </div>
        </div>

        {{-- SECTION 2: LAMPIRAN & FOTO --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
            <div class="flex items-center gap-3 border-b border-gray-100 pb-4 mb-6">
                <div class="p-2 bg-indigo-50 rounded-xl text-indigo-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-800">Ubah Berkas Lampiran</h3>
                    <p class="text-xs text-gray-400">Kosongkan/biarkan jika tidak ingin mengubah berkas yang ada</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                {{-- 1. FOTO PROFILE --}}
                <div class="flex flex-col items-center">
                    <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2 text-center w-full">
                        Foto Profile
                    </label>

                    <div class="relative group w-full h-52 bg-gray-50 border-2 border-dashed border-gray-300 hover:border-indigo-500 rounded-2xl transition duration-200 flex flex-col items-center justify-center p-4 cursor-pointer overflow-hidden" onclick="document.getElementById('foto').click()">
                        <input id="foto" name="foto" type="file" class="hidden" accept="image/*" onchange="previewMedia(this, 'preview-foto', 'placeholder-foto')">

                        <div id="placeholder-foto" class="flex flex-col items-center text-center {{ $anggota->foto ? 'hidden' : '' }}">
                            <div class="p-3 bg-white rounded-full shadow-sm text-gray-400 group-hover:text-indigo-600 transition mb-2">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            </div>
                            <span class="text-xs font-semibold text-gray-600 group-hover:text-indigo-600">Klik untuk Ganti Foto</span>
                            <span class="text-[10px] text-gray-400 mt-1">PNG, JPG up to 2MB</span>
                        </div>

                        <img id="preview-foto" src="{{ $anggota->foto ? asset('storage/' . $anggota->foto) : '' }}" class="{{ $anggota->foto ? '' : 'hidden' }} w-full h-full object-cover absolute inset-0 rounded-2xl" alt="Foto Profile">
                        
                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 flex items-center justify-center transition duration-200 text-white text-xs font-semibold rounded-2xl">
                            Klik untuk ganti gambar
                        </div>
                    </div>
                </div>

                {{-- 2. FOTO KTP --}}
                <div class="flex flex-col items-center">
                    <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2 text-center w-full">
                        Foto KTP
                    </label>

                    <div class="relative group w-full h-52 bg-gray-50 border-2 border-dashed border-gray-300 hover:border-indigo-500 rounded-2xl transition duration-200 flex flex-col items-center justify-center p-4 cursor-pointer overflow-hidden" onclick="document.getElementById('foto_ktp').click()">
                        <input id="foto_ktp" name="foto_ktp" type="file" class="hidden" accept="image/*" onchange="previewMedia(this, 'preview-foto-ktp', 'placeholder-foto-ktp')">

                        <div id="placeholder-foto-ktp" class="flex flex-col items-center text-center {{ $anggota->foto_ktp ? 'hidden' : '' }}">
                            <div class="p-3 bg-white rounded-full shadow-sm text-gray-400 group-hover:text-indigo-600 transition mb-2">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            </div>
                            <span class="text-xs font-semibold text-gray-600 group-hover:text-indigo-600">Klik untuk Ganti Foto KTP</span>
                            <span class="text-[10px] text-gray-400 mt-1">PNG, JPG up to 2MB</span>
                        </div>

                        <img id="preview-foto-ktp" src="{{ $anggota->foto_ktp ? asset('storage/' . $anggota->foto_ktp) : '' }}" class="{{ $anggota->foto_ktp ? '' : 'hidden' }} w-full h-full object-cover absolute inset-0 rounded-2xl" alt="Foto KTP">

                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 flex items-center justify-center transition duration-200 text-white text-xs font-semibold rounded-2xl">
                            Klik untuk ganti KTP
                        </div>
                    </div>
                </div>

                {{-- 3. PAKTA INTEGRITAS --}}
                <div class="flex flex-col items-center">
                    <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2 text-center w-full">
                        Pakta Integritas
                    </label>

                    <div class="relative group w-full h-52 bg-gray-50 border-2 border-dashed border-gray-300 hover:border-indigo-500 rounded-2xl transition duration-200 flex flex-col items-center justify-center p-4 cursor-pointer overflow-hidden" onclick="document.getElementById('pakta_integritas').click()">
                        <input id="pakta_integritas" name="pakta_integritas" type="file" class="hidden" accept="image/*,.pdf" onchange="previewPakta(this)">

                        <div id="placeholder-pakta" class="flex flex-col items-center text-center {{ $anggota->pakta_integritas ? 'hidden' : '' }}">
                            <div class="p-3 bg-white rounded-full shadow-sm text-gray-400 group-hover:text-indigo-600 transition mb-2">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                            </div>
                            <span class="text-xs font-semibold text-gray-600 group-hover:text-indigo-600">Klik untuk Unggah Pakta</span>
                            <span class="text-[10px] text-gray-400 mt-1">PDF, Gambar up to 5MB</span>
                        </div>

                        @php
                            $isPaktaPdf = $anggota->pakta_integritas && Str::endsWith(strtolower($anggota->pakta_integritas), '.pdf');
                        @endphp

                        <img id="preview-pakta-img" src="{{ ($anggota->pakta_integritas && !$isPaktaPdf) ? asset('storage/' . $anggota->pakta_integritas) : '' }}" class="{{ ($anggota->pakta_integritas && !$isPaktaPdf) ? '' : 'hidden' }} w-full h-full object-cover absolute inset-0 rounded-2xl" alt="Pakta Integritas">

                        <div id="preview-pakta-pdf" class="{{ $isPaktaPdf ? 'flex' : 'hidden' }} flex-col items-center justify-center text-center p-4">
                            <svg class="w-12 h-12 text-red-500 mb-2" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"></path></svg>
                            <span id="pdf-filename" class="text-xs font-bold text-gray-700 break-all line-clamp-2">
                                {{ $isPaktaPdf ? basename($anggota->pakta_integritas) : '' }}
                            </span>
                            <a href="{{ asset('storage/' . $anggota->pakta_integritas) }}" target="_blank" onclick="event.stopPropagation();" class="mt-2 text-[11px] text-indigo-600 hover:underline font-semibold">Lihat Berkas PDF ↗</a>
                        </div>

                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 flex items-center justify-center transition duration-200 text-white text-xs font-semibold rounded-2xl">
                            Klik untuk ganti berkas
                        </div>
                    </div>
                </div>

            </div>
        </div>

        {{-- ACTION BUTTONS --}}
        <div class="flex items-center justify-end gap-4">
            <a href="{{ route('admin.anggota.index') }}" class="px-6 py-3 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-600 font-semibold text-sm transition duration-200">
                Batal
            </a>
            <button type="submit" class="px-8 py-3 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-sm shadow-lg shadow-indigo-200 transition duration-200 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                Perbarui Data Anggota
            </button>
        </div>
    </form>
</div>

{{-- SCRIPT JAVASCRIPT UNTUK REALTIME PREVIEW & WILAYAH --}}
<script>
    function previewMedia(input, imgId, placeholderId) {
        const img = document.getElementById(imgId);
        const placeholder = document.getElementById(placeholderId);

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                img.src = e.target.result;
                img.classList.remove('hidden');
                if (placeholder) placeholder.classList.add('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function previewPakta(input) {
        const img = document.getElementById('preview-pakta-img');
        const pdfContainer = document.getElementById('preview-pakta-pdf');
        const pdfFilename = document.getElementById('pdf-filename');
        const placeholder = document.getElementById('placeholder-pakta');

        if (input.files && input.files[0]) {
            const file = input.files[0];

            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    img.src = e.target.result;
                    img.classList.remove('hidden');
                    pdfContainer.classList.add('hidden');
                    if (placeholder) placeholder.classList.add('hidden');
                }
                reader.readAsDataURL(file);
            } else if (file.type === 'application/pdf') {
                img.classList.add('hidden');
                pdfFilename.innerText = file.name;
                pdfContainer.classList.remove('hidden');
                pdfContainer.classList.add('flex');
                if (placeholder) placeholder.classList.add('hidden');
            }
        }
    }
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const provinceSelect = document.getElementById('provinsi_id');
        const regencySelect = document.getElementById('kota_id');
        const districtSelect = document.getElementById('kecamatan_id');
        const villageSelect = document.getElementById('kelurahan_id');

        const inputProvinsi = document.getElementById('provinsi');
        const inputKota = document.getElementById('kota');
        const inputKecamatan = document.getElementById('kecamatan');
        const inputKelurahan = document.getElementById('kelurahan');

        // Ambil Data Provinsi
        fetch('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json')
            .then(response => response.json())
            .then(provinces => {
                provinces.forEach(prov => {
                    let option = document.createElement('option');
                    option.value = prov.id;
                    option.textContent = prov.name;
                    if (prov.name === inputProvinsi.value) {
                        option.selected = true;
                        loadRegencies(prov.id, inputKota.value);
                    }
                    provinceSelect.appendChild(option);
                });
            });

        // Event ketika Provinsi dipilih
        provinceSelect.addEventListener('change', function () {
            let provId = this.value;
            let provName = this.options[this.selectedIndex].text;
            inputProvinsi.value = provId ? provName : '';

            regencySelect.innerHTML = '<option value="">Pilih Kota/Kabupaten</option>';
            regencySelect.disabled = true;
            districtSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
            districtSelect.disabled = true;
            villageSelect.innerHTML = '<option value="">Pilih Kelurahan/Desa</option>';
            villageSelect.disabled = true;

            inputKota.value = '';
            inputKecamatan.value = '';
            inputKelurahan.value = '';

            if (provId) {
                loadRegencies(provId);
            }
        });

        // Event ketika Kota/Kabupaten dipilih
        regencySelect.addEventListener('change', function () {
            let regId = this.value;
            let regName = this.options[this.selectedIndex].text;
            inputKota.value = regId ? regName : '';

            districtSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
            districtSelect.disabled = true;
            villageSelect.innerHTML = '<option value="">Pilih Kelurahan/Desa</option>';
            villageSelect.disabled = true;

            inputKecamatan.value = '';
            inputKelurahan.value = '';

            if (regId) {
                loadDistricts(regId);
            }
        });

        // Event ketika Kecamatan dipilih
        districtSelect.addEventListener('change', function () {
            let distId = this.value;
            let distName = this.options[this.selectedIndex].text;
            inputKecamatan.value = distId ? distName : '';

            villageSelect.innerHTML = '<option value="">Pilih Kelurahan/Desa</option>';
            villageSelect.disabled = true;
            inputKelurahan.value = '';

            if (distId) {
                loadVillages(distId);
            }
        });

        // Event ketika Kelurahan dipilih
        villageSelect.addEventListener('change', function () {
            let villName = this.options[this.selectedIndex].text;
            inputKelurahan.value = this.value ? villName : '';
        });

        function loadRegencies(provId, selectedRegencyName = null) {
            fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${provId}.json`)
                .then(response => response.json())
                .then(regencies => {
                    regencySelect.innerHTML = '<option value="">Pilih Kota/Kabupaten</option>';
                    regencies.forEach(reg => {
                        let option = document.createElement('option');
                        option.value = reg.id;
                        option.textContent = reg.name;
                        if (selectedRegencyName && reg.name === selectedRegencyName) {
                            option.selected = true;
                            loadDistricts(reg.id, inputKecamatan.value);
                        }
                        regencySelect.appendChild(option);
                    });
                    regencySelect.disabled = false;
                });
        }

        function loadDistricts(regId, selectedDistrictName = null) {
            fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/districts/${regId}.json`)
                .then(response => response.json())
                .then(districts => {
                    districtSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
                    districts.forEach(dist => {
                        let option = document.createElement('option');
                        option.value = dist.id;
                        option.textContent = dist.name;
                        if (selectedDistrictName && dist.name === selectedDistrictName) {
                            option.selected = true;
                            loadVillages(dist.id, inputKelurahan.value);
                        }
                        districtSelect.appendChild(option);
                    });
                    districtSelect.disabled = false;
                });
        }

        function loadVillages(distId, selectedVillageName = null) {
            fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/villages/${distId}.json`)
                .then(response => response.json())
                .then(villages => {
                    villageSelect.innerHTML = '<option value="">Pilih Kelurahan/Desa</option>';
                    villages.forEach(vill => {
                        let option = document.createElement('option');
                        option.value = vill.id;
                        option.textContent = vill.name;
                        if (selectedVillageName && vill.name === selectedVillageName) {
                            option.selected = true;
                        }
                        villageSelect.appendChild(option);
                    });
                    villageSelect.disabled = false;
                });
        }
    });
</script>
@endsection