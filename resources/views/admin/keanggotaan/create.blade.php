@extends('layouts.app')

@section('title', 'Pendaftaran Anggota BAKUMDA')

@section('page-title', 'Formulir Pendaftaran Anggota')

@section('page-subtitle')
    Lengkapi formulir di bawah ini untuk mengajukan keanggotaan resmi Badan Advokasi & Konsultasi Hukum Daerah (BAKUMDA).
@endsection

@section('content')
    <div class="max-w-4xl mx-auto space-y-4 md:space-y-6">

        <!-- Header Glassmorphism Banner -->
        <div class="relative overflow-hidden rounded-2xl md:rounded-3xl bg-gradient-to-r from-orange-600 via-indigo-600 to-purple-600 p-5 sm:p-8 text-white shadow-xl shadow-orange-500/10">
            <div class="relative z-10 max-w-2xl">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/20 backdrop-blur-md text-[10px] md:text-[11px] font-semibold tracking-wide uppercase mb-2 md:mb-3">
                    <i class="fa-solid fa-id-card"></i> Form Keanggotaan Baru
                </span>
                <h2 class="text-lg sm:text-2xl font-extrabold leading-tight">
                    Daftarkan Diri Anda Di Sini
                </h2>
                <p class="text-xs sm:text-sm text-white/80 mt-1.5 md:mt-2 leading-relaxed">
                    Bergabunglah bersama BAKUMDA untuk memperkuat jaringan advokasi, konsultasi hukum, dan pengabdian masyarakat di wilayah Anda.
                </p>
            </div>
            <div class="absolute -right-10 -bottom-10 w-48 md:w-64 h-48 md:h-64 bg-white/10 rounded-full blur-2xl pointer-events-none"></div>
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
        <div class="p-4 sm:p-8 rounded-2xl md:rounded-3xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800/80 shadow-sm">

            <form id="registrationForm" action="{{ route('user-anggota.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                
                <!-- Hidden input untuk membawa nomor sertifikat yang sudah divalidasi ke controller -->
                <input type="hidden" name="nomor_sertifikat" id="hidden_nomor_sertifikat" value="{{ old('nomor_sertifikat', '') }}">
                
                <!-- Hidden input untuk membawa nilai 'approve' saat syarat & ketentuan disetujui -->
                <input type="hidden" name="pakta_integritas" id="hidden_pakta_integritas" value="{{ old('pakta_integritas', '') }}">

                <!-- SECTION 1: INFORMASI IDENTITAS DIRI -->
                <div>
                    <div class="flex items-center gap-2 mb-3 md:mb-4 pb-2 border-b border-slate-100 dark:border-slate-800">
                        <div class="w-6 h-6 md:w-7 md:h-7 rounded-lg bg-orange-50 text-orange-600 dark:bg-orange-500/10 dark:text-orange-400 flex items-center justify-center text-xs font-bold">
                            1
                        </div>
                        <h3 class="text-xs md:text-sm font-extrabold text-slate-900 dark:text-white uppercase tracking-wider">
                            Informasi Identitas Diri
                        </h3>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5 md:gap-4">
                        <!-- Nama Lengkap -->
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">
                                Nama Lengkap & Gelar <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="nama" value="{{ old('nama', Auth::user()->name ?? '') }}" required placeholder="Contoh: Nama Lengkap, S.H., M.H." 
                                   class="w-full px-3.5 md:px-4 py-2.5 text-xs rounded-xl bg-slate-50 dark:bg-slate-800/60 text-slate-800 dark:text-slate-100 border border-slate-200 dark:border-slate-800 focus:border-orange-500/50 focus:ring-2 focus:ring-orange-500/10 outline-none transition-all @error('nama') border-rose-500 @enderror">
                            @error('nama') <span class="text-[10px] text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- No. KTP / NIK -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">
                                Nomor Induk Kependudukan (NIK/KTP) <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="no_ktp" value="{{ old('no_ktp', '') }}" maxlength="16" required placeholder="16 digit nomor KTP" 
                                   class="w-full px-3.5 md:px-4 py-2.5 text-xs rounded-xl bg-slate-50 dark:bg-slate-800/60 text-slate-800 dark:text-slate-100 border border-slate-200 dark:border-slate-800 focus:border-orange-500/50 focus:ring-2 focus:ring-orange-500/10 outline-none transition-all @error('no_ktp') border-rose-500 @enderror">
                            @error('no_ktp') <span class="text-[10px] text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Jenis Kelamin -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">
                                Jenis Kelamin <span class="text-rose-500">*</span>
                            </label>
                            <select name="jenis_kelamin" required class="w-full px-3.5 md:px-4 py-2.5 text-xs rounded-xl bg-slate-50 dark:bg-slate-800/60 text-slate-800 dark:text-slate-100 border border-slate-200 dark:border-slate-800 focus:border-orange-500/50 focus:ring-2 focus:ring-orange-500/10 outline-none transition-all @error('jenis_kelamin') border-rose-500 @enderror">
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
                                   class="w-full px-3.5 md:px-4 py-2.5 text-xs rounded-xl bg-slate-50 dark:bg-slate-800/60 text-slate-800 dark:text-slate-100 border border-slate-200 dark:border-slate-800 focus:border-orange-500/50 focus:ring-2 focus:ring-orange-500/10 outline-none transition-all @error('tempat_lahir') border-rose-500 @enderror">
                            @error('tempat_lahir') <span class="text-[10px] text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Tanggal Lahir -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">
                                Tanggal Lahir <span class="text-rose-500">*</span>
                            </label>
                            <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', '') }}" required 
                                   class="w-full px-3.5 md:px-4 py-2.5 text-xs rounded-xl bg-slate-50 dark:bg-slate-800/60 text-slate-800 dark:text-slate-100 border border-slate-200 dark:border-slate-800 focus:border-orange-500/50 focus:ring-2 focus:ring-orange-500/10 outline-none transition-all @error('tanggal_lahir') border-rose-500 @enderror">
                            @error('tanggal_lahir') <span class="text-[10px] text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Agama -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">
                                Agama <span class="text-rose-500">*</span>
                            </label>
                            <select name="agama" required class="w-full px-3.5 md:px-4 py-2.5 text-xs rounded-xl bg-slate-50 dark:bg-slate-800/60 text-slate-800 dark:text-slate-100 border border-slate-200 dark:border-slate-800 focus:border-orange-500/50 focus:ring-2 focus:ring-orange-500/10 outline-none transition-all @error('agama') border-rose-500 @enderror">
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
                            <select name="status_perkawinan" required class="w-full px-3.5 md:px-4 py-2.5 text-xs rounded-xl bg-slate-50 dark:bg-slate-800/60 text-slate-800 dark:text-slate-100 border border-slate-200 dark:border-slate-800 focus:border-orange-500/50 focus:ring-2 focus:ring-orange-500/10 outline-none transition-all @error('status_perkawinan') border-rose-500 @enderror">
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
                                   class="w-full px-3.5 md:px-4 py-2.5 text-xs rounded-xl bg-slate-50 dark:bg-slate-800/60 text-slate-800 dark:text-slate-100 border border-slate-200 dark:border-slate-800 focus:border-orange-500/50 focus:ring-2 focus:ring-orange-500/10 outline-none transition-all @error('pekerjaan') border-rose-500 @enderror">
                            @error('pekerjaan') <span class="text-[10px] text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Kewarganegaraan -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">
                                Kewarganegaraan <span class="text-rose-500">*</span>
                            </label>
                            <select name="kewarganegaraan" required class="w-full px-3.5 md:px-4 py-2.5 text-xs rounded-xl bg-slate-50 dark:bg-slate-800/60 text-slate-800 dark:text-slate-100 border border-slate-200 dark:border-slate-800 focus:border-orange-500/50 focus:ring-2 focus:ring-orange-500/10 outline-none transition-all @error('kewarganegaraan') border-rose-500 @enderror">
                                <option value="WNI" {{ old('kewarganegaraan', 'WNI') == 'WNI' ? 'selected' : '' }}>WNI (Warga Negara Indonesia)</option>
                            </select>
                            @error('kewarganegaraan') <span class="text-[10px] text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <!-- SECTION 2: KONTAK & ALAMAT DOMISILI -->
                <div>
                    <div class="flex items-center gap-2 mb-3 md:mb-4 pb-2 border-b border-slate-100 dark:border-slate-800">
                        <div class="w-6 h-6 md:w-7 md:h-7 rounded-lg bg-indigo-50 text-indigo-600 dark:bg-indigo-500/10 dark:text-indigo-400 flex items-center justify-center text-xs font-bold">
                            2
                        </div>
                        <h3 class="text-xs md:text-sm font-extrabold text-slate-900 dark:text-white uppercase tracking-wider">
                            Kontak & Alamat Domisili
                        </h3>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5 md:gap-4">
                        <!-- Email -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">
                                Alamat Email <span class="text-rose-500">*</span>
                            </label>
                            <input type="email" name="email" value="{{ old('email', Auth::user()->email ?? '') }}" required placeholder="nama@email.com" 
                                   class="w-full px-3.5 md:px-4 py-2.5 text-xs rounded-xl bg-slate-50 dark:bg-slate-800/60 text-slate-800 dark:text-slate-100 border border-slate-200 dark:border-slate-800 focus:border-orange-500/50 focus:ring-2 focus:ring-orange-500/10 outline-none transition-all @error('email') border-rose-500 @enderror">
                            @error('email') <span class="text-[10px] text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Nomor HP / WhatsApp -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">
                                No. WhatsApp / HP <span class="text-rose-500">*</span>
                            </label>
                            <input type="tel" name="no_hp" value="{{ old('no_hp', '') }}" required placeholder="081234567890" 
                                   class="w-full px-3.5 md:px-4 py-2.5 text-xs rounded-xl bg-slate-50 dark:bg-slate-800/60 text-slate-800 dark:text-slate-100 border border-slate-200 dark:border-slate-800 focus:border-orange-500/50 focus:ring-2 focus:ring-orange-500/10 outline-none transition-all @error('no_hp') border-rose-500 @enderror">
                            @error('no_hp') <span class="text-[10px] text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Provinsi -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">
                                Provinsi <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400">
                                    <i class="fa-solid fa-magnifying-glass text-xs"></i>
                                </span>
                                <input type="text" id="provinsiSearch" placeholder="Cari atau pilih Provinsi..." autocomplete="off"
                                       class="w-full pl-9 pr-4 py-2.5 text-xs rounded-xl bg-slate-50 dark:bg-slate-800/60 text-slate-800 dark:text-slate-100 border border-slate-200 dark:border-slate-800 focus:border-orange-500/50 focus:ring-2 focus:ring-orange-500/10 outline-none transition-all @error('provinsi') border-rose-500 @enderror">
                                <input type="hidden" name="provinsi" id="provinsiValue" value="{{ old('provinsi', '') }}">
                                
                                <div id="provinsiDropdown" class="absolute z-30 left-0 right-0 mt-1 max-h-56 overflow-y-auto bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl shadow-lg hidden">
                                    <div class="p-1.5 space-y-0.5" id="provinsiOptionsContainer"></div>
                                </div>
                            </div>
                            @error('provinsi') <span class="text-[10px] text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Kota / Kabupaten -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">
                                Kota / Kabupaten <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400">
                                    <i class="fa-solid fa-magnifying-glass text-xs"></i>
                                </span>
                                <input type="text" id="kotaSearch" placeholder="Pilih provinsi terlebih dahulu..." autocomplete="off" disabled
                                       class="w-full pl-9 pr-4 py-2.5 text-xs rounded-xl bg-slate-100 dark:bg-slate-800/30 text-slate-800 dark:text-slate-100 border border-slate-200 dark:border-slate-800 focus:border-orange-500/50 focus:ring-2 focus:ring-orange-500/10 outline-none transition-all disabled:opacity-60 disabled:cursor-not-allowed @error('kota') border-rose-500 @enderror">
                                <input type="hidden" name="kota" id="kotaValue" value="{{ old('kota', '') }}">
                                
                                <div id="kotaDropdown" class="absolute z-30 left-0 right-0 mt-1 max-h-56 overflow-y-auto bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl shadow-lg hidden">
                                    <div class="p-1.5 space-y-0.5" id="kotaOptionsContainer"></div>
                                </div>
                            </div>
                            @error('kota') <span class="text-[10px] text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Kecamatan -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">
                                Kecamatan <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400">
                                    <i class="fa-solid fa-magnifying-glass text-xs"></i>
                                </span>
                                <input type="text" id="kecamatanSearch" placeholder="Pilih kota/kabupaten terlebih dahulu..." autocomplete="off" disabled
                                       class="w-full pl-9 pr-4 py-2.5 text-xs rounded-xl bg-slate-100 dark:bg-slate-800/30 text-slate-800 dark:text-slate-100 border border-slate-200 dark:border-slate-800 focus:border-orange-500/50 focus:ring-2 focus:ring-orange-500/10 outline-none transition-all disabled:opacity-60 disabled:cursor-not-allowed @error('kecamatan') border-rose-500 @enderror">
                                <input type="hidden" name="kecamatan" id="kecamatanValue" value="{{ old('kecamatan', '') }}">
                                
                                <div id="kecamatanDropdown" class="absolute z-30 left-0 right-0 mt-1 max-h-56 overflow-y-auto bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl shadow-lg hidden">
                                    <div class="p-1.5 space-y-0.5" id="kecamatanOptionsContainer"></div>
                                </div>
                            </div>
                            @error('kecamatan') <span class="text-[10px] text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Kelurahan / Desa -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">
                                Kelurahan / Desa <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400">
                                    <i class="fa-solid fa-magnifying-glass text-xs"></i>
                                </span>
                                <input type="text" id="kelurahanSearch" placeholder="Pilih kecamatan terlebih dahulu..." autocomplete="off" disabled
                                       class="w-full pl-9 pr-4 py-2.5 text-xs rounded-xl bg-slate-100 dark:bg-slate-800/30 text-slate-800 dark:text-slate-100 border border-slate-200 dark:border-slate-800 focus:border-orange-500/50 focus:ring-2 focus:ring-orange-500/10 outline-none transition-all disabled:opacity-60 disabled:cursor-not-allowed @error('kelurahan') border-rose-500 @enderror">
                                <input type="hidden" name="kelurahan" id="kelurahanValue" value="{{ old('kelurahan', '') }}">
                                
                                <div id="kelurahanDropdown" class="absolute z-30 left-0 right-0 mt-1 max-h-56 overflow-y-auto bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl shadow-lg hidden">
                                    <div class="p-1.5 space-y-0.5" id="kelurahanOptionsContainer"></div>
                                </div>
                            </div>
                            @error('kelurahan') <span class="text-[10px] text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Alamat Lengkap -->
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">
                                Alamat Lengkap (Detail Jalan, No. Rumah, RT/RW) <span class="text-rose-500">*</span>
                            </label>
                            <textarea name="alamat" rows="2" required placeholder="Detail Jalan, No. Rumah, RT/RW..."
                                      class="w-full px-3.5 md:px-4 py-2.5 text-xs rounded-xl bg-slate-50 dark:bg-slate-800/60 text-slate-800 dark:text-slate-100 border border-slate-200 dark:border-slate-800 focus:border-orange-500/50 focus:ring-2 focus:ring-orange-500/10 outline-none transition-all @error('alamat') border-rose-500 @enderror">{{ old('alamat', '') }}</textarea>
                            @error('alamat') <span class="text-[10px] text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <!-- SECTION 3: UPLOAD DOKUMEN PENDUKUNG -->
                <div>
                    <div class="flex items-center gap-2 mb-3 md:mb-4 pb-2 border-b border-slate-100 dark:border-slate-800">
                        <div class="w-6 h-6 md:w-7 md:h-7 rounded-lg bg-purple-50 text-purple-600 dark:bg-purple-500/10 dark:text-purple-400 flex items-center justify-center text-xs font-bold">
                            3
                        </div>
                        <h3 class="text-xs md:text-sm font-extrabold text-slate-900 dark:text-white uppercase tracking-wider">
                            Upload Dokumen Berkas
                        </h3>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5 md:gap-4">
                        <!-- Upload Pas Foto dengan Live Preview -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">
                                Pas Foto (3x4) <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative p-4 rounded-xl md:rounded-2xl border-2 border-dashed border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/30 text-center hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                                <div id="preview-foto-container" class="hidden mb-3">
                                    <img id="preview-foto" src="#" alt="Preview Pas Foto" class="mx-auto h-28 w-20 md:h-32 md:w-24 object-cover rounded-lg border border-slate-200 dark:border-slate-700 shadow-sm">
                                </div>
                                <div id="placeholder-foto">
                                    <i class="fa-solid fa-camera text-slate-400 text-lg md:text-xl mb-1"></i>
                                    <p class="text-[10px] md:text-[11px] text-slate-500 dark:text-slate-400">JPG/PNG (Maks 2MB)</p>
                                </div>
                                <input type="file" name="foto" id="input-foto" accept="image/*" required 
                                       onchange="previewImage(this, 'preview-foto', 'preview-foto-container', 'placeholder-foto')"
                                       class="mt-2 text-xs text-slate-500 w-full file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-[11px] file:font-semibold file:bg-orange-50 file:text-orange-600 dark:file:bg-orange-500/10 dark:file:text-orange-400 hover:file:bg-orange-100">
                            </div>
                            @error('foto') <span class="text-[10px] text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Upload Foto KTP dengan Live Preview -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">
                                Scan / Foto KTP <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative p-4 rounded-xl md:rounded-2xl border-2 border-dashed border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/30 text-center hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                                <div id="preview-ktp-container" class="hidden mb-3">
                                    <img id="preview-ktp" src="#" alt="Preview KTP" class="mx-auto h-20 w-32 md:h-24 md:w-36 object-cover rounded-lg border border-slate-200 dark:border-slate-700 shadow-sm">
                                </div>
                                <div id="placeholder-ktp">
                                    <i class="fa-solid fa-address-card text-slate-400 text-lg md:text-xl mb-1"></i>
                                    <p class="text-[10px] md:text-[11px] text-slate-500 dark:text-slate-400">JPG/PNG/PDF (Maks 2MB)</p>
                                </div>
                                <input type="file" name="foto_ktp" id="input-ktp" accept="image/*,.pdf" required 
                                       onchange="previewImage(this, 'preview-ktp', 'preview-ktp-container', 'placeholder-ktp')"
                                       class="mt-2 text-xs text-slate-500 w-full file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-[11px] file:font-semibold file:bg-orange-50 file:text-orange-600 dark:file:bg-orange-500/10 dark:file:text-orange-400 hover:file:bg-orange-100">
                            </div>
                            @error('foto_ktp') <span class="text-[10px] text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <!-- SECTION 4: KETERANGAN TAMBAHAN -->
                <div>
                    <div class="flex items-center gap-2 mb-3 md:mb-4 pb-2 border-b border-slate-100 dark:border-slate-800">
                        <div class="w-6 h-6 md:w-7 md:h-7 rounded-lg bg-emerald-50 text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-400 flex items-center justify-center text-xs font-bold">
                            4
                        </div>
                        <h3 class="text-xs md:text-sm font-extrabold text-slate-900 dark:text-white uppercase tracking-wider">
                            Catatan / Keterangan
                        </h3>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">
                            Keterangan Tambahan <span class="text-slate-400 font-normal">(Opsional)</span>
                        </label>
                        <textarea name="keterangan" rows="2" placeholder="Catatan khusus atau keahlian tambahan yang ingin disampaikan..."
                                  class="w-full px-3.5 md:px-4 py-2.5 text-xs rounded-xl bg-slate-50 dark:bg-slate-800/60 text-slate-800 dark:text-slate-100 border border-slate-200 dark:border-slate-800 focus:border-orange-500/50 focus:ring-2 focus:ring-orange-500/10 outline-none transition-all @error('keterangan') border-rose-500 @enderror">{{ old('keterangan', '') }}</textarea>
                        @error('keterangan') <span class="text-[10px] text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="pt-4 border-t border-slate-100 dark:border-slate-800 flex flex-col sm:flex-row items-center justify-end gap-3">
                    <button type="reset" onclick="resetFormCustom()" class="w-full sm:w-auto px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 font-semibold text-xs transition-colors">
                        Reset Form
                    </button>
                    <!-- Tombol ini memicu Modal Input & Verifikasi Nomor Sertifikat -->
                    <button type="button" onclick="openCertificateModal()" class="w-full sm:w-auto px-6 py-2.5 rounded-xl bg-orange-600 hover:bg-orange-700 text-white font-semibold text-xs shadow-lg shadow-orange-500/25 transition-all duration-200 hover:scale-[1.02] flex items-center justify-center gap-2">
                        <i class="fa-solid fa-paper-plane text-xs"></i>
                        <span>Kirim Permohonan Pendaftaran</span>
                    </button>
                </div>

            </form>

        </div>
    </div>

    <!-- MODAL 1: INPUT & VERIFIKASI NOMOR SERTIFIKAT -->
    <div id="certificateModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/60 backdrop-blur-sm hidden p-3 sm:p-4">
        <div class="w-full max-w-md p-5 sm:p-6 bg-white dark:bg-slate-900 rounded-2xl md:rounded-3xl shadow-2xl border border-slate-200 dark:border-slate-800 space-y-4">
            
            <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-800">
                <h3 class="font-extrabold text-xs sm:text-sm text-slate-900 dark:text-white uppercase tracking-wider flex items-center gap-2">
                    <i class="fa-solid fa-id-card text-orange-500"></i> Masukkan Nomor Sertifikat
                </h3>
                <button onclick="closeCertificateModal()" class="text-slate-400 hover:text-slate-600 dark:hover:text-white">
                    <i class="fa-solid fa-xmark text-base"></i>
                </button>
            </div>

            <div class="space-y-4">
                <div class="p-4 rounded-2xl bg-orange-50/50 dark:bg-orange-950/20 border border-orange-100 dark:border-orange-900/30 space-y-2">
                    <label class="block text-xs font-bold text-slate-800 dark:text-slate-200">
                        Nomor Sertifikat Pelatihan <span class="text-rose-500">*</span>
                    </label>
                    <p class="text-[11px] text-slate-500 dark:text-slate-400">
                        Masukkan nomor sertifikat pelatihan yang Anda peroleh untuk diverifikasi sebelum melanjutkan ke tahap persetujuan.
                    </p>
                    <input type="text" id="modal_input_sertifikat" placeholder="Contoh: CERT/BAKUMDA/2026/001" 
                           class="w-full px-3.5 sm:px-4 py-2.5 text-xs rounded-xl bg-white dark:bg-slate-800 text-slate-800 dark:text-slate-100 border border-slate-200 dark:border-slate-700 focus:border-orange-500 focus:ring-2 focus:ring-orange-500/10 outline-none transition-all">
                </div>

                <div id="modalLoading" class="flex items-center justify-center gap-2 py-3 hidden">
                    <i class="fa-solid fa-spinner fa-spin text-orange-600 text-lg"></i>
                    <span class="text-xs text-slate-600 dark:text-slate-300 font-medium">Memeriksa keabsahan sertifikat...</span>
                </div>

                <div id="modalResult" class="hidden p-3 rounded-xl text-xs font-semibold"></div>
            </div>

            <div class="flex items-center justify-end gap-2 pt-2 border-t border-slate-100 dark:border-slate-800">
                <button type="button" onclick="closeCertificateModal()" class="px-4 py-2 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-semibold text-xs">Batal</button>
                <button type="button" onclick="verifyCertificate()" class="px-5 py-2 rounded-xl bg-orange-600 hover:bg-orange-700 text-white font-semibold text-xs shadow-md">Verifikasi & Lanjut</button>
            </div>

        </div>
    </div>

    <!-- MODAL 2: SYARAT & KETENTUAN (PAKTA INTEGRITAS) -->
    <div id="termsModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/60 backdrop-blur-sm hidden p-3 sm:p-4">
        <div class="w-full max-w-lg p-5 sm:p-6 bg-white dark:bg-slate-900 rounded-2xl md:rounded-3xl shadow-2xl border border-slate-200 dark:border-slate-800 space-y-4">
            
            <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-800">
                <h3 class="font-extrabold text-xs sm:text-sm text-slate-900 dark:text-white uppercase tracking-wider flex items-center gap-2">
                    <i class="fa-solid fa-file-contract text-indigo-500"></i> Syarat & Ketentuan (Pakta Integritas)
                </h3>
                <button onclick="closeTermsModal()" class="text-slate-400 hover:text-slate-600 dark:hover:text-white">
                    <i class="fa-solid fa-xmark text-base"></i>
                </button>
            </div>

            <div class="space-y-4">
                <!-- Box Konten Pakta Integritas -->
                <div class="h-44 overflow-y-auto p-3.5 rounded-xl bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 text-xs text-slate-600 dark:text-slate-300 space-y-2 leading-relaxed">
                    <p class="font-bold text-slate-800 dark:text-slate-100">PAKTA INTEGRITAS KEANGGOTAAN BAKUMDA</p>
                    <p>Dengan ini, saya yang mendaftarkan diri sebagai anggota Badan Advokasi & Konsultasi Hukum Daerah (BAKUMDA) menyatakan dengan sesungguhnya bahwa:</p>
                    <ol class="list-decimal list-inside space-y-1">
                        <li>Seluruh data dan dokumen yang saya unggah pada formulir pendaftaran ini adalah benar, sah, dan dapat dipertanggungjawabkan secara hukum.</li>
                        <li>Senantiasa menjunjung tinggi etika profesi, hukum, serta nama baik lembaga BAKUMDA dalam menjalankan setiap tugas dan pengabdian masyarakat.</li>
                        <li>Bersedia mematuhi seluruh Anggaran Dasar, Anggaran Rumah Tangga (AD/ART), serta peraturan dan keputusan yang berlaku di lingkungan BAKUMDA.</li>
                        <li>Apabila dikemudian hari terbukti melanggar ketentuan di atas atau memberikan data palsu, saya bersedia menerima sanksi administratif hingga pencabutan status keanggotaan.</li>
                    </ol>
                </div>

                <!-- Checkbox Persetujuan -->
                <div class="flex items-start gap-2.5 p-3 rounded-xl bg-indigo-50/50 dark:bg-indigo-950/20 border border-indigo-100 dark:border-indigo-900/30">
                    <input type="checkbox" id="modal_checkbox_pakta" 
                           class="mt-0.5 h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500 dark:bg-slate-800 dark:border-slate-700">
                    <label for="modal_checkbox_pakta" class="text-xs text-slate-700 dark:text-slate-300 font-medium cursor-pointer leading-relaxed">
                        Saya telah membaca, memahami, dan menyetujui seluruh Syarat & Ketentuan serta Pakta Integritas yang berlaku di BAKUMDA.
                    </label>
                </div>

                <div id="termsErrorMsg" class="text-[11px] text-rose-500 font-semibold hidden">
                    * Anda wajib menyetujui syarat & ketentuan (Pakta Integritas) terlebih dahulu.
                </div>
            </div>

            <div class="flex items-center justify-end gap-2 pt-2 border-t border-slate-100 dark:border-slate-800">
                <button type="button" onclick="closeTermsModal()" class="px-4 py-2 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-semibold text-xs">Kembali</button>
                <button type="button" onclick="confirmAndSubmitForm()" class="px-5 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-xs shadow-md">Setuju & Kirim Form</button>
            </div>

        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        fetchProvinces();

        setupSearchDropdown('provinsi', 'provinsiSearch', 'provinsiValue', 'provinsiDropdown', 'provinsiOptionsContainer', (id) => {
            resetDependentDropdowns('kota');
            fetchRegencies(id);
        });

        setupSearchDropdown('kota', 'kotaSearch', 'kotaValue', 'kotaDropdown', 'kotaOptionsContainer', (id) => {
            resetDependentDropdowns('kecamatan');
            fetchDistricts(id);
        });

        setupSearchDropdown('kecamatan', 'kecamatanSearch', 'kecamatanValue', 'kecamatanDropdown', 'kecamatanOptionsContainer', (id) => {
            resetDependentDropdowns('kelurahan');
            fetchVillages(id);
        });

        setupSearchDropdown('kelurahan', 'kelurahanSearch', 'kelurahanValue', 'kelurahanDropdown', 'kelurahanOptionsContainer', () => {});

        document.addEventListener('click', function(e) {
            ['provinsi', 'kota', 'kecamatan', 'kelurahan'].forEach(type => {
                const searchInput = document.getElementById(type + 'Search');
                const dropdown = document.getElementById(type + 'Dropdown');
                if (searchInput && dropdown && !searchInput.contains(e.target) && !dropdown.contains(e.target)) {
                    dropdown.classList.add('hidden');
                }
            });
        });
    });

    let provincesData = [];
    let regenciesData = [];
    let districtsData = [];
    let villagesData = [];

    function fetchProvinces() {
        fetch('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json')
            .then(response => response.json())
            .then(data => {
                provincesData = data;
                populateOptions('provinsi', data);
                
                const oldVal = document.getElementById('provinsiValue').value;
                if (oldVal) {
                    const found = data.find(item => item.name === oldVal);
                    if (found) {
                        document.getElementById('provinsiSearch').value = found.name;
                        fetchRegencies(found.id);
                    }
                }
            }).catch(err => console.error('Gagal memuat data provinsi:', err));
    }

    function fetchRegencies(provinceId) {
        fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${provinceId}.json`)
            .then(response => response.json())
            .then(data => {
                regenciesData = data;
                populateOptions('kota', data);
                
                const kotaInput = document.getElementById('kotaSearch');
                kotaInput.disabled = false;
                kotaInput.classList.remove('bg-slate-100', 'dark:bg-slate-800/30', 'cursor-not-allowed');

                const oldVal = document.getElementById('kotaValue').value;
                if (oldVal) {
                    const found = data.find(item => item.name === oldVal);
                    if (found) {
                        document.getElementById('kotaSearch').value = found.name;
                        fetchDistricts(found.id);
                    }
                }
            }).catch(err => console.error('Gagal memuat data kota:', err));
    }

    function fetchDistricts(regencyId) {
        fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/districts/${regencyId}.json`)
            .then(response => response.json())
            .then(data => {
                districtsData = data;
                populateOptions('kecamatan', data);

                const kecInput = document.getElementById('kecamatanSearch');
                kecInput.disabled = false;
                kecInput.classList.remove('bg-slate-100', 'dark:bg-slate-800/30', 'cursor-not-allowed');

                const oldVal = document.getElementById('kecamatanValue').value;
                if (oldVal) {
                    const found = data.find(item => item.name === oldVal);
                    if (found) {
                        document.getElementById('kecamatanSearch').value = found.name;
                        fetchVillages(found.id);
                    }
                }
            }).catch(err => console.error('Gagal memuat kecamatan:', err));
    }

    function fetchVillages(districtId) {
        fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/villages/${districtId}.json`)
            .then(response => response.json())
            .then(data => {
                villagesData = data;
                populateOptions('kelurahan', data);

                const kelInput = document.getElementById('kelurahanSearch');
                kelInput.disabled = false;
                kelInput.classList.remove('bg-slate-100', 'dark:bg-slate-800/30', 'cursor-not-allowed');

                const oldVal = document.getElementById('kelurahanValue').value;
                if (oldVal) {
                    const found = data.find(item => item.name === oldVal);
                    if (found) {
                        document.getElementById('kelurahanSearch').value = found.name;
                    }
                }
            }).catch(err => console.error('Gagal memuat kelurahan:', err));
    }

    function populateOptions(type, data) {
        const container = document.getElementById(type + 'OptionsContainer');
        container.innerHTML = '';

        data.forEach(item => {
            const div = document.createElement('div');
            div.className = "px-3 py-2 text-xs text-slate-700 dark:text-slate-200 hover:bg-orange-50 dark:hover:bg-slate-700/60 rounded-lg cursor-pointer transition-colors";
            div.textContent = item.name;
            div.onclick = function() {
                selectOption(type, item);
            };
            container.appendChild(div);
        });
    }

    function setupSearchDropdown(type, searchId, valueId, dropdownId, containerId, onSelectCallback) {
        const searchInput = document.getElementById(searchId);
        const valueInput = document.getElementById(valueId);
        const dropdown = document.getElementById(dropdownId);
        const container = document.getElementById(containerId);

        searchInput.addEventListener('focus', function() {
            if(!this.disabled) dropdown.classList.remove('hidden');
        });

        searchInput.addEventListener('input', function() {
            const keyword = this.value.toLowerCase();
            valueInput.value = '';

            let dataset = [];
            if (type === 'provinsi') dataset = provincesData;
            else if (type === 'kota') dataset = regenciesData;
            else if (type === 'kecamatan') dataset = districtsData;
            else if (type === 'kelurahan') dataset = villagesData;

            const filtered = dataset.filter(item => item.name.toLowerCase().includes(keyword));
            
            container.innerHTML = '';
            if (filtered.length > 0) {
                filtered.forEach(item => {
                    const div = document.createElement('div');
                    div.className = "px-3 py-2 text-xs text-slate-700 dark:text-slate-200 hover:bg-orange-50 dark:hover:bg-slate-700/60 rounded-lg cursor-pointer transition-colors";
                    div.textContent = item.name;
                    div.onclick = function() {
                        selectOption(type, item);
                    };
                    container.appendChild(div);
                });
            } else {
                container.innerHTML = '<div class="px-3 py-2 text-xs text-slate-400 text-center">Data tidak ditemukan</div>';
            }

            dropdown.classList.remove('hidden');
        });
    }

    function selectOption(type, item) {
        document.getElementById(type + 'Search').value = item.name;
        document.getElementById(type + 'Value').value = item.name;
        document.getElementById(type + 'Dropdown').classList.add('hidden');

        if (typeof item.id !== 'undefined') {
            if (type === 'provinsi') fetchRegencies(item.id);
            if (type === 'kota') fetchDistricts(item.id);
            if (type === 'kecamatan') fetchVillages(item.id);
        }
    }

    function resetDependentDropdowns(level) {
        if (level === 'kota') {
            document.getElementById('kotaSearch').value = '';
            document.getElementById('kotaValue').value = '';
            document.getElementById('kotaSearch').disabled = true;
            document.getElementById('kotaSearch').classList.add('bg-slate-100', 'dark:bg-slate-800/30', 'cursor-not-allowed');
            regenciesData = [];
            
            resetDependentDropdowns('kecamatan');
        } else if (level === 'kecamatan') {
            document.getElementById('kecamatanSearch').value = '';
            document.getElementById('kecamatanValue').value = '';
            document.getElementById('kecamatanSearch').disabled = true;
            document.getElementById('kecamatanSearch').classList.add('bg-slate-100', 'dark:bg-slate-800/30', 'cursor-not-allowed');
            districtsData = [];

            resetDependentDropdowns('kelurahan');
        } else if (level === 'kelurahan') {
            document.getElementById('kelurahanSearch').value = '';
            document.getElementById('kelurahanValue').value = '';
            document.getElementById('kelurahanSearch').disabled = true;
            document.getElementById('kelurahanSearch').classList.add('bg-slate-100', 'dark:bg-slate-800/30', 'cursor-not-allowed');
            villagesData = [];
        }
    }

    function resetFormCustom() {
        resetPreviews();
        resetDependentDropdowns('kota');
        document.getElementById('provinsiSearch').value = '';
        document.getElementById('provinsiValue').value = '';
    }

    function previewImage(input, previewId, containerId, placeholderId) {
        const container = document.getElementById(containerId);
        const placeholder = document.getElementById(placeholderId);
        const preview = document.getElementById(previewId);

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function (e) {
                preview.src = e.target.result;
                container.classList.remove('hidden');
                placeholder.classList.add('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function resetPreviews() {
        document.getElementById('preview-foto-container').classList.add('hidden');
        document.getElementById('placeholder-foto').classList.remove('hidden');
        document.getElementById('preview-ktp-container').classList.add('hidden');
        document.getElementById('placeholder-ktp').classList.remove('hidden');
    }

    // Alur Modal 1: Buka Modal Sertifikat
    function openCertificateModal() {
        document.getElementById('certificateModal').classList.remove('hidden');
    }

    function closeCertificateModal() {
        document.getElementById('certificateModal').classList.add('hidden');
        document.getElementById('modalResult').classList.add('hidden');
        document.getElementById('modal_input_sertifikat').value = '';
    }

    // Verifikasi Nomor Sertifikat > Jika Sukses, Tutup Modal 1 dan Buka Modal 2 (Syarat & Ketentuan)
    function verifyCertificate() {
        const noSertifikat = document.getElementById('modal_input_sertifikat').value.trim();
        const loading = document.getElementById('modalLoading');
        const result = document.getElementById('modalResult');

        if (!noSertifikat) {
            alert('Nomor sertifikat wajib diisi!');
            return;
        }

        loading.classList.remove('hidden');
        result.classList.add('hidden');

        setTimeout(() => {
            loading.classList.add('hidden');
            result.classList.remove('hidden');
            
            // Simpan nomor sertifikat ke hidden input form utama
            document.getElementById('hidden_nomor_sertifikat').value = noSertifikat;
            result.className = "p-3 rounded-xl text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200";
            result.innerHTML = '<i class="fa-solid fa-circle-check"></i> Sertifikat valid!';

            setTimeout(() => {
                closeCertificateModal();
                openTermsModal(); // Lanjut buka Modal Syarat & Ketentuan
            }, 800);
        }, 1000);
    }

    // Alur Modal 2: Buka Modal Syarat & Ketentuan
    function openTermsModal() {
        document.getElementById('termsModal').classList.remove('hidden');
        document.getElementById('modal_checkbox_pakta').checked = false;
        document.getElementById('termsErrorMsg').classList.add('hidden');
    }

    function closeTermsModal() {
        document.getElementById('termsModal').classList.add('hidden');
    }

    // Konfirmasi Persetujuan Pakta Integritas dan Submit Form
    function confirmAndSubmitForm() {
        const isChecked = document.getElementById('modal_checkbox_pakta').checked;
        const errorMsg = document.getElementById('termsErrorMsg');

        if (!isChecked) {
            errorMsg.classList.remove('hidden');
            return;
        }

        errorMsg.classList.add('hidden');
        // Otomatis mengisi field hidden pakta_integritas dengan nilai "approve"
        document.getElementById('hidden_pakta_integritas').value = 'approve';
        
        closeTermsModal();
        
        // Kirim (submit) form utama secara otomatis
        document.getElementById('registrationForm').submit();
    }
</script>
@endpush