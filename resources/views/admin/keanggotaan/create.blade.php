@extends('layouts.admin')

@section('title', 'Pendaftaran Anggota BAKUMDA')

@section('page-title', 'Formulir Pendaftaran Anggota')

@section('page-subtitle')
    Lengkapi formulir di bawah ini untuk mengajukan keanggotaan resmi Badan Advokasi & Konsultasi Hukum Daerah (BAKUMDA).
@endsection

@section('content')
    <div class="max-w-4xl mx-auto space-y-6">

        <!-- Header Glassmorphism Banner -->
        <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-brand-600 via-indigo-600 to-purple-600 p-6 sm:p-8 text-white shadow-xl shadow-brand-500/10">
            <div class="relative z-10 max-w-2xl">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/20 backdrop-blur-md text-[11px] font-semibold tracking-wide uppercase mb-3">
                    <i class="fa-solid fa-id-card"></i> Form Keanggotaan Baru
                </span>
                <h2 class="text-xl sm:text-2xl font-extrabold leading-tight">
                    Daftarkan Diri Anda Di Sini
                </h2>
                <p class="text-xs sm:text-sm text-white/80 mt-2 leading-relaxed">
                    Bergabunglah bersama BAKUMDA untuk memperkuat jaringan advokasi, konsultasi hukum, dan pengabdian masyarakat di wilayah Anda.
                </p>
            </div>
            <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-white/10 rounded-full blur-2xl pointer-events-none"></div>
        </div>

        <!-- Alert Error Global -->
        @if ($errors->any())
            <div class="p-4 rounded-2xl bg-rose-50 dark:bg-rose-950/30 border border-rose-200 dark:border-rose-900/50 text-rose-800 dark:text-rose-300 text-xs">
                <div class="flex items-center gap-2 font-bold mb-1">
                    <i class="fa-solid fa-circle-exclamation text-rose-500"></i> Terjadi kesalahan input:
                </div>
                <ul class="list-disc list-inside space-y-0.5 text-[11px]">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Registration Form Card -->
        <div class="p-6 sm:p-8 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800/80 shadow-sm">

            <form id="registrationForm" action="{{ route('user-anggota.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                
                <!-- Hidden input untuk membawa nomor sertifikat yang sudah divalidasi ke controller -->
                <input type="hidden" name="nomor_sertifikat" id="hidden_nomor_sertifikat" value="{{ old('nomor_sertifikat', '') }}">
                
                <!-- Hidden input untuk membawa nilai 'approve' saat syarat & ketentuan dicentang -->
                <input type="hidden" name="pakta_integritas" id="hidden_pakta_integritas" value="{{ old('pakta_integritas', '') }}">

                <!-- SECTION 1: INFORMASI IDENTITAS DIRI -->
                <div>
                    <div class="flex items-center gap-2 mb-4 pb-2 border-b border-slate-100 dark:border-slate-800">
                        <div class="w-7 h-7 rounded-lg bg-brand-50 text-brand-600 dark:bg-brand-500/10 dark:text-brand-400 flex items-center justify-center text-xs font-bold">
                            1
                        </div>
                        <h3 class="text-sm font-extrabold text-slate-900 dark:text-white uppercase tracking-wider">
                            Informasi Identitas Diri
                        </h3>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Nama Lengkap -->
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">
                                Nama Lengkap & Gelar <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="nama" value="{{ old('nama', Auth::user()->name ?? '') }}" required placeholder="Contoh: Nama Lengkap, S.H., M.H." 
                                   class="w-full px-4 py-2.5 text-xs rounded-xl bg-slate-50 dark:bg-slate-800/60 text-slate-800 dark:text-slate-100 border border-slate-200 dark:border-slate-800 focus:border-brand-500/50 focus:ring-2 focus:ring-brand-500/10 outline-none transition-all @error('nama') border-rose-500 @enderror">
                            @error('nama') <span class="text-[10px] text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- No. KTP / NIK -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">
                                Nomor Induk Kependudukan (NIK/KTP) <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="no_ktp" value="{{ old('no_ktp', '') }}" maxlength="16" required placeholder="16 digit nomor KTP" 
                                   class="w-full px-4 py-2.5 text-xs rounded-xl bg-slate-50 dark:bg-slate-800/60 text-slate-800 dark:text-slate-100 border border-slate-200 dark:border-slate-800 focus:border-brand-500/50 focus:ring-2 focus:ring-brand-500/10 outline-none transition-all @error('no_ktp') border-rose-500 @enderror">
                            @error('no_ktp') <span class="text-[10px] text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Jenis Kelamin -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">
                                Jenis Kelamin <span class="text-rose-500">*</span>
                            </label>
                            <select name="jenis_kelamin" required class="w-full px-4 py-2.5 text-xs rounded-xl bg-slate-50 dark:bg-slate-800/60 text-slate-800 dark:text-slate-100 border border-slate-200 dark:border-slate-800 focus:border-brand-500/50 focus:ring-2 focus:ring-brand-500/10 outline-none transition-all @error('jenis_kelamin') border-rose-500 @enderror">
                                <option value="">-- Pilih Jenis Kelamin --</option>
                                <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            @error('jenis_kelamin') <span class="text-[10px] text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Tempat Lahir -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">
                                Tempat Lahir <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', '') }}" required placeholder="Contoh: Ujung Pandang" 
                                   class="w-full px-4 py-2.5 text-xs rounded-xl bg-slate-50 dark:bg-slate-800/60 text-slate-800 dark:text-slate-100 border border-slate-200 dark:border-slate-800 focus:border-brand-500/50 focus:ring-2 focus:ring-brand-500/10 outline-none transition-all @error('tempat_lahir') border-rose-500 @enderror">
                            @error('tempat_lahir') <span class="text-[10px] text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Tanggal Lahir -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">
                                Tanggal Lahir <span class="text-rose-500">*</span>
                            </label>
                            <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', '') }}" required 
                                   class="w-full px-4 py-2.5 text-xs rounded-xl bg-slate-50 dark:bg-slate-800/60 text-slate-800 dark:text-slate-100 border border-slate-200 dark:border-slate-800 focus:border-brand-500/50 focus:ring-2 focus:ring-brand-500/10 outline-none transition-all @error('tanggal_lahir') border-rose-500 @enderror">
                            @error('tanggal_lahir') <span class="text-[10px] text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Agama -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">
                                Agama <span class="text-rose-500">*</span>
                            </label>
                            <select name="agama" required class="w-full px-4 py-2.5 text-xs rounded-xl bg-slate-50 dark:bg-slate-800/60 text-slate-800 dark:text-slate-100 border border-slate-200 dark:border-slate-800 focus:border-brand-500/50 focus:ring-2 focus:ring-brand-500/10 outline-none transition-all @error('agama') border-rose-500 @enderror">
                                <option value="">-- Pilih Agama --</option>
                                <option value="Islam" {{ old('agama') == 'Islam' ? 'selected' : '' }}>Islam</option>
                                <option value="Kristen Protestan" {{ old('agama') == 'Kristen Protestan' ? 'selected' : '' }}>Kristen Protestan</option>
                                <option value="Katolik" {{ old('agama') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                                <option value="Hindu" {{ old('agama') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                <option value="Buddha" {{ old('agama') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                                <option value="Khonghucu" {{ old('agama') == 'Khonghucu' ? 'selected' : '' }}>Khonghucu</option>
                            </select>
                            @error('agama') <span class="text-[10px] text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Status Perkawinan -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">
                                Status Perkawinan <span class="text-rose-500">*</span>
                            </label>
                            <select name="status_perkawinan" required class="w-full px-4 py-2.5 text-xs rounded-xl bg-slate-50 dark:bg-slate-800/60 text-slate-800 dark:text-slate-100 border border-slate-200 dark:border-slate-800 focus:border-brand-500/50 focus:ring-2 focus:ring-brand-500/10 outline-none transition-all @error('status_perkawinan') border-rose-500 @enderror">
                                <option value="">-- Pilih Status --</option>
                                <option value="Belum Kawin" {{ old('status_perkawinan') == 'Belum Kawin' ? 'selected' : '' }}>Belum Kawin</option>
                                <option value="Kawin" {{ old('status_perkawinan') == 'Kawin' ? 'selected' : '' }}>Kawin</option>
                                <option value="Cerai Hidup" {{ old('status_perkawinan') == 'Cerai Hidup' ? 'selected' : '' }}>Cerai Hidup</option>
                                <option value="Cerai Mati" {{ old('status_perkawinan') == 'Cerai Mati' ? 'selected' : '' }}>Cerai Mati</option>
                            </select>
                            @error('status_perkawinan') <span class="text-[10px] text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Pekerjaan -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">
                                Pekerjaan / Profesi <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="pekerjaan" value="{{ old('pekerjaan', '') }}" required placeholder="Contoh: Advokat / Wiraswasta" 
                                   class="w-full px-4 py-2.5 text-xs rounded-xl bg-slate-50 dark:bg-slate-800/60 text-slate-800 dark:text-slate-100 border border-slate-200 dark:border-slate-800 focus:border-brand-500/50 focus:ring-2 focus:ring-brand-500/10 outline-none transition-all @error('pekerjaan') border-rose-500 @enderror">
                            @error('pekerjaan') <span class="text-[10px] text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Kewarganegaraan -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">
                                Kewarganegaraan <span class="text-rose-500">*</span>
                            </label>
                            <select name="kewarganegaraan" required class="w-full px-4 py-2.5 text-xs rounded-xl bg-slate-50 dark:bg-slate-800/60 text-slate-800 dark:text-slate-100 border border-slate-200 dark:border-slate-800 focus:border-brand-500/50 focus:ring-2 focus:ring-brand-500/10 outline-none transition-all @error('kewarganegaraan') border-rose-500 @enderror">
                                <option value="WNI" {{ old('kewarganegaraan', 'WNI') == 'WNI' ? 'selected' : '' }}>WNI (Warga Negara Indonesia)</option>
                                <option value="WNA" {{ old('kewarganegaraan') == 'WNA' ? 'selected' : '' }}>WNA (Warga Negara Asing)</option>
                            </select>
                            @error('kewarganegaraan') <span class="text-[10px] text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <!-- SECTION 2: KONTAK & ALAMAT DOMISILI -->
                <div>
                    <div class="flex items-center gap-2 mb-4 pb-2 border-b border-slate-100 dark:border-slate-800">
                        <div class="w-7 h-7 rounded-lg bg-indigo-50 text-indigo-600 dark:bg-indigo-500/10 dark:text-indigo-400 flex items-center justify-center text-xs font-bold">
                            2
                        </div>
                        <h3 class="text-sm font-extrabold text-slate-900 dark:text-white uppercase tracking-wider">
                            Kontak & Alamat Domisili
                        </h3>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Email -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">
                                Alamat Email <span class="text-rose-500">*</span>
                            </label>
                            <input type="email" name="email" value="{{ old('email', Auth::user()->email ?? '') }}" required placeholder="nama@email.com" 
                                   class="w-full px-4 py-2.5 text-xs rounded-xl bg-slate-50 dark:bg-slate-800/60 text-slate-800 dark:text-slate-100 border border-slate-200 dark:border-slate-800 focus:border-brand-500/50 focus:ring-2 focus:ring-brand-500/10 outline-none transition-all @error('email') border-rose-500 @enderror">
                            @error('email') <span class="text-[10px] text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Nomor HP / WhatsApp -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">
                                No. WhatsApp / HP <span class="text-rose-500">*</span>
                            </label>
                            <input type="tel" name="no_hp" value="{{ old('no_hp', '') }}" required placeholder="081234567890" 
                                   class="w-full px-4 py-2.5 text-xs rounded-xl bg-slate-50 dark:bg-slate-800/60 text-slate-800 dark:text-slate-100 border border-slate-200 dark:border-slate-800 focus:border-brand-500/50 focus:ring-2 focus:ring-brand-500/10 outline-none transition-all @error('no_hp') border-rose-500 @enderror">
                            @error('no_hp') <span class="text-[10px] text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Provinsi -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">
                                Provinsi <span class="text-rose-500">*</span>
                            </label>
                            <select name="provinsi" id="provinsi" required class="w-full px-4 py-2.5 text-xs rounded-xl bg-slate-50 dark:bg-slate-800/60 text-slate-800 dark:text-slate-100 border border-slate-200 dark:border-slate-800 focus:border-brand-500/50 focus:ring-2 focus:ring-brand-500/10 outline-none transition-all @error('provinsi') border-rose-500 @enderror">
                                <option value="">-- Pilih Provinsi --</option>
                            </select>
                            @error('provinsi') <span class="text-[10px] text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Kota / Kabupaten -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">
                                Kota / Kabupaten <span class="text-rose-500">*</span>
                            </label>
                            <select name="kota" id="kota" required class="w-full px-4 py-2.5 text-xs rounded-xl bg-slate-50 dark:bg-slate-800/60 text-slate-800 dark:text-slate-100 border border-slate-200 dark:border-slate-800 focus:border-brand-500/50 focus:ring-2 focus:ring-brand-500/10 outline-none transition-all @error('kota') border-rose-500 @enderror">
                                <option value="">-- Pilih Kota/Kabupaten --</option>
                            </select>
                            @error('kota') <span class="text-[10px] text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Kecamatan -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">
                                Kecamatan <span class="text-rose-500">*</span>
                            </label>
                            <select name="kecamatan" id="kecamatan" required class="w-full px-4 py-2.5 text-xs rounded-xl bg-slate-50 dark:bg-slate-800/60 text-slate-800 dark:text-slate-100 border border-slate-200 dark:border-slate-800 focus:border-brand-500/50 focus:ring-2 focus:ring-brand-500/10 outline-none transition-all @error('kecamatan') border-rose-500 @enderror">
                                <option value="">-- Pilih Kecamatan --</option>
                            </select>
                            @error('kecamatan') <span class="text-[10px] text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Kelurahan / Desa -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">
                                Kelurahan / Desa <span class="text-rose-500">*</span>
                            </label>
                            <select name="kelurahan" id="kelurahan" required class="w-full px-4 py-2.5 text-xs rounded-xl bg-slate-50 dark:bg-slate-800/60 text-slate-800 dark:text-slate-100 border border-slate-200 dark:border-slate-800 focus:border-brand-500/50 focus:ring-2 focus:ring-brand-500/10 outline-none transition-all @error('kelurahan') border-rose-500 @enderror">
                                <option value="">-- Pilih Kelurahan/Desa --</option>
                            </select>
                            @error('kelurahan') <span class="text-[10px] text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Alamat Lengkap -->
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">
                                Alamat Lengkap (Detail Jalan, No. Rumah, RT/RW) <span class="text-rose-500">*</span>
                            </label>
                            <textarea name="alamat" rows="2" required placeholder="Detail Jalan, No. Rumah, RT/RW..."
                                      class="w-full px-4 py-2.5 text-xs rounded-xl bg-slate-50 dark:bg-slate-800/60 text-slate-800 dark:text-slate-100 border border-slate-200 dark:border-slate-800 focus:border-brand-500/50 focus:ring-2 focus:ring-brand-500/10 outline-none transition-all @error('alamat') border-rose-500 @enderror">{{ old('alamat', '') }}</textarea>
                            @error('alamat') <span class="text-[10px] text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                    </div>
                </div>

                <!-- SECTION 3: UPLOAD DOKUMEN PENDUKUNG -->
                <div>
                    <div class="flex items-center gap-2 mb-4 pb-2 border-b border-slate-100 dark:border-slate-800">
                        <div class="w-7 h-7 rounded-lg bg-purple-50 text-purple-600 dark:bg-purple-500/10 dark:text-purple-400 flex items-center justify-center text-xs font-bold">
                            3
                        </div>
                        <h3 class="text-sm font-extrabold text-slate-900 dark:text-white uppercase tracking-wider">
                            Upload Dokumen Berkas
                        </h3>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Upload Pas Foto dengan Live Preview -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">
                                Pas Foto (3x4) <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative p-4 rounded-2xl border-2 border-dashed border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/30 text-center hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                                <div id="preview-foto-container" class="hidden mb-3">
                                    <img id="preview-foto" src="#" alt="Preview Pas Foto" class="mx-auto h-32 w-24 object-cover rounded-lg border border-slate-200 dark:border-slate-700 shadow-sm">
                                </div>
                                <div id="placeholder-foto">
                                    <i class="fa-solid fa-camera text-slate-400 text-xl mb-1"></i>
                                    <p class="text-[11px] text-slate-500 dark:text-slate-400">JPG/PNG (Maks 2MB)</p>
                                </div>
                                <input type="file" name="foto" id="input-foto" accept="image/*" required 
                                       onchange="previewImage(this, 'preview-foto', 'preview-foto-container', 'placeholder-foto')"
                                       class="mt-2 text-xs text-slate-500 w-full file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-[11px] file:font-semibold file:bg-brand-50 file:text-brand-600 dark:file:bg-brand-500/10 dark:file:text-brand-400 hover:file:bg-brand-100">
                            </div>
                            @error('foto') <span class="text-[10px] text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Upload Foto KTP dengan Live Preview -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">
                                Scan / Foto KTP <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative p-4 rounded-2xl border-2 border-dashed border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/30 text-center hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                                <div id="preview-ktp-container" class="hidden mb-3">
                                    <img id="preview-ktp" src="#" alt="Preview KTP" class="mx-auto h-24 w-36 object-cover rounded-lg border border-slate-200 dark:border-slate-700 shadow-sm">
                                </div>
                                <div id="placeholder-ktp">
                                    <i class="fa-solid fa-address-card text-slate-400 text-xl mb-1"></i>
                                    <p class="text-[11px] text-slate-500 dark:text-slate-400">JPG/PNG/PDF (Maks 2MB)</p>
                                </div>
                                <input type="file" name="foto_ktp" id="input-ktp" accept="image/*,.pdf" required 
                                       onchange="previewImage(this, 'preview-ktp', 'preview-ktp-container', 'placeholder-ktp')"
                                       class="mt-2 text-xs text-slate-500 w-full file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-[11px] file:font-semibold file:bg-brand-50 file:text-brand-600 dark:file:bg-brand-500/10 dark:file:text-brand-400 hover:file:bg-brand-100">
                            </div>
                            @error('foto_ktp') <span class="text-[10px] text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <!-- SECTION 4: KETERANGAN TAMBAHAN -->
                <div>
                    <div class="flex items-center gap-2 mb-4 pb-2 border-b border-slate-100 dark:border-slate-800">
                        <div class="w-7 h-7 rounded-lg bg-emerald-50 text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-400 flex items-center justify-center text-xs font-bold">
                            4
                        </div>
                        <h3 class="text-sm font-extrabold text-slate-900 dark:text-white uppercase tracking-wider">
                            Catatan / Keterangan
                        </h3>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">
                            Keterangan Tambahan <span class="text-slate-400 font-normal">(Opsional)</span>
                        </label>
                        <textarea name="keterangan" rows="2" placeholder="Catatan khusus atau keahlian tambahan yang ingin disampaikan..."
                                class="w-full px-4 py-2.5 text-xs rounded-xl bg-slate-50 dark:bg-slate-800/60 text-slate-800 dark:text-slate-100 border border-slate-200 dark:border-slate-800 focus:border-brand-500/50 focus:ring-2 focus:ring-brand-500/10 outline-none transition-all @error('keterangan') border-rose-500 @enderror">{{ old('keterangan', '') }}</textarea>
                        @error('keterangan') <span class="text-[10px] text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="pt-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-end gap-3">
                    <button type="reset" onclick="resetPreviews()" class="px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 font-semibold text-xs transition-colors">
                        Reset Form
                    </button>
                    <!-- Tombol ini memicu Modal Input & Verifikasi Nomor Sertifikat -->
                    <button type="button" onclick="openCertificateModal()" class="px-6 py-2.5 rounded-xl bg-brand-600 hover:bg-brand-700 text-white font-semibold text-xs shadow-lg shadow-brand-500/25 transition-all duration-200 hover:scale-[1.02] flex items-center gap-2">
                        <i class="fa-solid fa-paper-plane text-xs"></i>
                        <span>Kirim Permohonan Pendaftaran</span>
                    </button>
                </div>

            </form>

        </div>
    </div>

    <!-- MODAL 1: INPUT & VERIFIKASI NOMOR SERTIFIKAT PELATIHAN -->
    <div id="certificateModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/60 backdrop-blur-sm hidden">
        <div class="w-full max-w-md p-6 bg-white dark:bg-slate-900 rounded-3xl shadow-2xl border border-slate-200 dark:border-slate-800 space-y-4 m-4">
            
            <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-800">
                <h3 class="font-extrabold text-sm text-slate-900 dark:text-white uppercase tracking-wider flex items-center gap-2">
                    <i class="fa-solid fa-id-card text-brand-500"></i> Masukkan Nomor Sertifikat
                </h3>
                <button onclick="closeModal()" class="text-slate-400 hover:text-slate-600 dark:hover:text-white">
                    <i class="fa-solid fa-xmark text-base"></i>
                </button>
            </div>

            <div class="space-y-4">
                <div class="p-4 rounded-2xl bg-brand-50/50 dark:bg-brand-950/20 border border-brand-100 dark:border-brand-900/30 space-y-2">
                    <label class="block text-xs font-bold text-slate-800 dark:text-slate-200">
                        Nomor Sertifikat Pelatihan <span class="text-rose-500">*</span>
                    </label>
                    <p class="text-[11px] text-slate-500 dark:text-slate-400">
                        Masukkan nomor sertifikat pelatihan yang Anda peroleh untuk diverifikasi sebelum melanjutkan ke tahap persetujuan.
                    </p>
                    <input type="text" id="modal_input_sertifikat" placeholder="Contoh: CERT/BAKUMDA/2026/001" 
                           class="w-full px-4 py-2.5 text-xs rounded-xl bg-white dark:bg-slate-800 text-slate-800 dark:text-slate-100 border border-slate-200 dark:border-slate-700 focus:border-brand-500 focus:ring-2 focus:ring-brand-500/10 outline-none transition-all">
                </div>

                <!-- Bagian Status Loading / Hasil Pengecekan -->
                <div id="modalLoading" class="flex items-center justify-center gap-2 py-3 hidden">
                    <i class="fa-solid fa-spinner fa-spin text-brand-600 text-lg"></i>
                    <span class="text-xs text-slate-600 dark:text-slate-300 font-medium">Memeriksa keabsahan sertifikat...</span>
                </div>

                <div id="modalResult" class="hidden p-3 rounded-xl text-xs font-semibold"></div>
            </div>

            <div class="flex items-center justify-end gap-2 pt-2 border-t border-slate-100 dark:border-slate-800">
                <button type="button" onclick="closeModal()" class="px-4 py-2 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-semibold text-xs">
                    Batal
                </button>
                <button type="button" id="modalVerifyBtn" onclick="verifyCertificate()" class="px-5 py-2 rounded-xl bg-brand-600 hover:bg-brand-700 text-white font-semibold text-xs flex items-center gap-1.5">
                    <i class="fa-solid fa-check"></i>
                    <span>Verifikasi Sertifikat</span>
                </button>
            </div>
        </div>
    </div>

    <!-- MODAL 2: PERSETUJUAN SYARAT & KETENTUAN (Muncul jika sertifikat valid) -->
    <div id="termsModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/60 backdrop-blur-sm hidden">
        <div class="w-full max-w-lg p-6 bg-white dark:bg-slate-900 rounded-3xl shadow-2xl border border-slate-200 dark:border-slate-800 space-y-4 m-4">
            
            <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-800">
                <h3 class="font-extrabold text-sm text-slate-900 dark:text-white uppercase tracking-wider flex items-center gap-2">
                    <i class="fa-solid fa-file-shield text-brand-500"></i> Syarat & Ketentuan Keanggotaan
                </h3>
                <button onclick="closeTermsModal()" class="text-slate-400 hover:text-slate-600 dark:hover:text-white">
                    <i class="fa-solid fa-xmark text-base"></i>
                </button>
            </div>

            <div class="space-y-3">
                <div class="h-44 overflow-y-auto p-3.5 text-xs text-slate-600 dark:text-slate-300 bg-slate-50 dark:bg-slate-800/60 rounded-xl border border-slate-200 dark:border-slate-700 space-y-2 leading-relaxed">
                    <p class="font-semibold text-slate-900 dark:text-white">Dengan mengajukan permohonan keanggotaan BAKUMDA, Anda menyatakan dan menyetujui hal-hal berikut:</p>
                    <p>1. Seluruh data identitas dan berkas dokumen yang dilampirkan adalah benar, sah, dan dapat dipertanggungjawabkan secara hukum.</p>
                    <p>2. Bersedia mematuhi Anggaran Dasar, Anggaran Rumah Tangga (AD/ART), serta seluruh peraturan yang berlaku di lingkungan Badan Advokasi & Konsultasi Hukum Daerah (BAKUMDA).</p>
                    <p>3. Menjunjung tinggi kode etik profesi, integritas, serta menjaga nama baik organisasi dalam menjalankan fungsi advokasi dan pengabdian masyarakat.</p>
                    <p>4. Pihak BAKUMDA berhak menolak atau mencabut keanggotaan apabila ditemukan pelanggaran terhadap ketentuan yang berlaku.</p>
                </div>

                <label class="flex items-start gap-2.5 cursor-pointer pt-1">
                    <input type="checkbox" id="agreeCheckbox" onchange="handleAgreeCheckbox(this)" class="mt-0.5 rounded border-slate-300 text-brand-600 focus:ring-brand-500">
                    <span class="text-xs text-slate-700 dark:text-slate-300 font-medium leading-normal">
                        Saya telah membaca, memahami, dan menyetujui seluruh syarat & ketentuan keanggotaan BAKUMDA (Pakta Integritas).
                    </span>
                </label>
            </div>

            <div class="flex items-center justify-end gap-2 pt-2 border-t border-slate-100 dark:border-slate-800">
                <button type="button" onclick="closeTermsModal()" class="px-4 py-2 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-semibold text-xs">
                    Kembali
                </button>
                <button type="button" id="finalSubmitBtn" disabled onclick="submitRegistrationForm()" class="px-5 py-2 rounded-xl bg-brand-600 hover:bg-brand-700 text-white font-semibold text-xs flex items-center gap-1.5 disabled:opacity-50 disabled:cursor-not-allowed">
                    <i class="fa-solid fa-paper-plane"></i>
                    <span>Kirim Permohonan Sekarang</span>
                </button>
            </div>
        </div>
    </div>

    <script>
        function handleAgreeCheckbox(checkbox) {
            const submitBtn = document.getElementById('finalSubmitBtn');
            const hiddenPaktaIntegritas = document.getElementById('hidden_pakta_integritas');

            if (checkbox.checked) {
                submitBtn.disabled = false;
                hiddenPaktaIntegritas.value = 'approve';
            } else {
                submitBtn.disabled = true;
                hiddenPaktaIntegritas.value = '';
            }
        }

        function openCertificateModal() {
            const modal = document.getElementById('certificateModal');
            const inputField = document.getElementById('modal_input_sertifikat');
            const hiddenInput = document.getElementById('hidden_nomor_sertifikat');
            
            inputField.value = hiddenInput.value;
            document.getElementById('modalResult').classList.add('hidden');
            document.getElementById('modalLoading').classList.add('hidden');
            
            modal.classList.remove('hidden');
            inputField.focus();
        }

        function closeModal() {
            document.getElementById('certificateModal').classList.add('hidden');
        }

        function closeTermsModal() {
            document.getElementById('termsModal').classList.add('hidden');
        }

        function verifyCertificate() {
            const noSertifikat = document.getElementById('modal_input_sertifikat').value.trim();
            const loading = document.getElementById('modalLoading');
            const result = document.getElementById('modalResult');
            const verifyBtn = document.getElementById('modalVerifyBtn');

            if (!noSertifikat) {
                alert('Nomor Sertifikat Pelatihan wajib diisi!');
                document.getElementById('modal_input_sertifikat').focus();
                return;
            }

            loading.classList.remove('hidden');
            result.classList.add('hidden');
            verifyBtn.disabled = true;

            fetch("{{ route('user-anggota.check-certificate') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ nomor_sertifikat: noSertifikat })
            })
            .then(async response => {
                const data = await response.json();
                return { status: response.status, body: data };
            })
            .then(res => {
                loading.classList.add('hidden');
                result.classList.remove('hidden');
                verifyBtn.disabled = false;

                if (res.status === 200 && res.body.valid) {
                    result.className = "p-3 rounded-xl text-xs font-semibold bg-emerald-50 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-900";
                    result.innerHTML = `<i class="fa-solid fa-circle-check mr-1"></i> ${res.body.message}`;
                    
                    document.getElementById('hidden_nomor_sertifikat').value = noSertifikat;

                    setTimeout(() => {
                        document.getElementById('certificateModal').classList.add('hidden');
                        document.getElementById('termsModal').classList.remove('hidden');
                        
                        // Reset checkbox & hidden pakta integritas setiap kali modal dibuka
                        document.getElementById('agreeCheckbox').checked = false;
                        document.getElementById('hidden_pakta_integritas').value = '';
                        document.getElementById('finalSubmitBtn').disabled = true;
                    }, 800);
                } else {
                    result.className = "p-3 rounded-xl text-xs font-semibold bg-rose-50 text-rose-700 dark:bg-rose-950/40 dark:text-rose-300 border border-rose-200 dark:border-rose-900";
                    result.innerHTML = `<i class="fa-solid fa-circle-xmark mr-1"></i> ${res.body.message || 'Nomor sertifikat tidak valid atau tidak terdaftar.'}`;
                }
            })
            .catch(error => {
                loading.classList.add('hidden');
                result.classList.remove('hidden');
                verifyBtn.disabled = false;
                result.className = "p-3 rounded-xl text-xs font-semibold bg-rose-50 text-rose-700 dark:bg-rose-950/40 dark:text-rose-300";
                result.innerHTML = `<i class="fa-solid fa-triangle-exclamation mr-1"></i> Terjadi kesalahan koneksi sistem.`;
            });
        }

        function submitRegistrationForm() {
            document.getElementById('registrationForm').submit();
        }

        function previewImage(input, imgId, containerId, placeholderId) {
            const file = input.files[0];
            const previewImg = document.getElementById(imgId);
            const container = document.getElementById(containerId);
            const placeholder = document.getElementById(placeholderId);

            if (file) {
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImg.src = e.target.result;
                        container.classList.remove('hidden');
                        if (placeholder) placeholder.classList.add('hidden');
                    }
                    reader.readAsDataURL(file);
                } else {
                    container.classList.add('hidden');
                    if (placeholder) {
                        placeholder.classList.remove('hidden');
                        placeholder.querySelector('p').textContent = file.name;
                    }
                }
            }
        }

        function resetPreviews() {
            document.getElementById('hidden_nomor_sertifikat').value = '';
            document.getElementById('hidden_pakta_integritas').value = '';
            ['foto', 'ktp'].forEach(type => {
                const container = document.getElementById(`preview-${type}-container`);
                const placeholder = document.getElementById(`placeholder-${type}`);
                if (container) container.classList.add('hidden');
                if (placeholder) {
                    placeholder.classList.remove('hidden');
                    if (type === 'foto') {
                        placeholder.querySelector('p').textContent = 'JPG/PNG (Maks 2MB)';
                    } else {
                        placeholder.querySelector('p').textContent = 'JPG/PNG/PDF (Maks 2MB)';
                    }
                }
            });
        }
    </script>

    @push('scripts')
    <script src="{{ asset('js/wilayah.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const config = {
                provinsiEl: 'provinsi',
                kotaEl: 'kota',
                kecamatanEl: 'kecamatan',
                kelurahanEl: 'kelurahan',
                oldData: {
                    provinsi: @json(old('provinsi')),
                    kota: @json(old('kota')),
                    kecamatan: @json(old('kecamatan')),
                    kelurahan: @json(old('kelurahan'))
                }
            };
            initWilayahDropdowns(config);
        });
    </script>
    @endpush
@endsection