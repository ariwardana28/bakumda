    @extends('layouts.admin')

    @section('title', 'Pendaftaran Anggota BAKUMDA')

    @section('page-title', 'Formulir Pendaftaran Anggota')

    @section('page-subtitle')
        Lengkapi formulir di bawah ini untuk mengajukan keanggotaan resmi Badan Advokasi & Konsultasi Hukum Daerah
        (BAKUMDA).
    @endsection

    @section('content')
        <div class="max-w-4xl mx-auto space-y-6">

            <!-- Header Glassmorphism Banner -->
            <div
                class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-brand-600 via-indigo-600 to-purple-600 p-6 sm:p-8 text-white shadow-xl shadow-brand-500/10">
                <div class="relative z-10 max-w-2xl">
                    <span
                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/20 backdrop-blur-md text-[11px] font-semibold tracking-wide uppercase mb-3">
                        <i class="fa-solid fa-id-card"></i> Form Keanggotaan Baru
                    </span>
                    <h2 class="text-xl sm:text-2xl font-extrabold leading-tight">
                        Daftarkan Diri Anda Di Sini
                    </h2>
                    <p class="text-xs sm:text-sm text-white/80 mt-2 leading-relaxed">
                        Bergabunglah bersama BAKUMDA untuk memperkuat jaringan advokasi, konsultasi hukum, dan pengabdian
                        masyarakat di wilayah Anda.
                    </p>
                </div>
                <!-- Decorative Glow Blur -->
                <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-white/10 rounded-full blur-2xl pointer-events-none">
                </div>
            </div>

            <!-- Alert Error Global -->
            @if ($errors->any())
                <div
                    class="p-4 rounded-2xl bg-rose-50 dark:bg-rose-950/30 border border-rose-200 dark:border-rose-900/50 text-rose-800 dark:text-rose-300 text-xs">
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
            <div
                class="p-6 sm:p-8 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800/80 shadow-sm">

                <form action="{{ route('user-anggota.store') }}" method="POST" enctype="multipart/form-data"
                    class="space-y-6">
                    @csrf

                    <!-- SECTION 1: INFORMASI IDENTITAS DIRI -->
                    <div>
                        <div class="flex items-center gap-2 mb-4 pb-2 border-b border-slate-100 dark:border-slate-800">
                            <div
                                class="w-7 h-7 rounded-lg bg-brand-50 text-brand-600 dark:bg-brand-500/10 dark:text-brand-400 flex items-center justify-center text-xs font-bold">
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
                                <input type="text" name="nama"
                                    value="{{ old('nama', $anggota->nama ?? (Auth::user()->name ?? '')) }}" required
                                    placeholder="Contoh: Nama Lengkap, S.H., M.H."
                                    class="w-full px-4 py-2.5 text-xs rounded-xl bg-slate-50 dark:bg-slate-800/60 text-slate-800 dark:text-slate-100 border border-slate-200 dark:border-slate-800 focus:border-brand-500/50 focus:ring-2 focus:ring-brand-500/10 outline-none transition-all @error('nama') border-rose-500 @enderror">
                                @error('nama')
                                    <span class="text-[10px] text-rose-500 mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- No. KTP / NIK -->
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">
                                    Nomor Induk Kependudukan (NIK/KTP) <span class="text-rose-500">*</span>
                                </label>
                                <input type="text" name="no_ktp" value="{{ old('no_ktp', $anggota->no_ktp ?? '') }}"
                                    maxlength="16" required placeholder="16 digit nomor KTP"
                                    class="w-full px-4 py-2.5 text-xs rounded-xl bg-slate-50 dark:bg-slate-800/60 text-slate-800 dark:text-slate-100 border border-slate-200 dark:border-slate-800 focus:border-brand-500/50 focus:ring-2 focus:ring-brand-500/10 outline-none transition-all @error('no_ktp') border-rose-500 @enderror">
                                @error('no_ktp')
                                    <span class="text-[10px] text-rose-500 mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Jenis Kelamin -->
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">
                                    Jenis Kelamin <span class="text-rose-500">*</span>
                                </label>
                                <select name="jenis_kelamin" required
                                    class="w-full px-4 py-2.5 text-xs rounded-xl bg-slate-50 dark:bg-slate-800/60 text-slate-800 dark:text-slate-100 border border-slate-200 dark:border-slate-800 focus:border-brand-500/50 focus:ring-2 focus:ring-brand-500/10 outline-none transition-all @error('jenis_kelamin') border-rose-500 @enderror">
                                    <option value="">-- Pilih Jenis Kelamin --</option>
                                    <option value="Laki-laki"
                                        {{ old('jenis_kelamin', $anggota->jenis_kelamin ?? '') == 'Laki-laki' ? 'selected' : '' }}>
                                        Laki-laki</option>
                                    <option value="Perempuan"
                                        {{ old('jenis_kelamin', $anggota->jenis_kelamin ?? '') == 'Perempuan' ? 'selected' : '' }}>
                                        Perempuan</option>
                                </select>
                                @error('jenis_kelamin')
                                    <span class="text-[10px] text-rose-500 mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Tempat Lahir -->
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">
                                    Tempat Lahir <span class="text-rose-500">*</span>
                                </label>
                                <input type="text" name="tempat_lahir"
                                    value="{{ old('tempat_lahir', $anggota->tempat_lahir ?? '') }}" required
                                    placeholder="Contoh: Ujung Pandang"
                                    class="w-full px-4 py-2.5 text-xs rounded-xl bg-slate-50 dark:bg-slate-800/60 text-slate-800 dark:text-slate-100 border border-slate-200 dark:border-slate-800 focus:border-brand-500/50 focus:ring-2 focus:ring-brand-500/10 outline-none transition-all @error('tempat_lahir') border-rose-500 @enderror">
                                @error('tempat_lahir')
                                    <span class="text-[10px] text-rose-500 mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Tanggal Lahir -->
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">
                                    Tanggal Lahir <span class="text-rose-500">*</span>
                                </label>
                                <input type="date" name="tanggal_lahir"
                                    value="{{ old('tanggal_lahir', $anggota->tanggal_lahir ?? '') }}" required
                                    class="w-full px-4 py-2.5 text-xs rounded-xl bg-slate-50 dark:bg-slate-800/60 text-slate-800 dark:text-slate-100 border border-slate-200 dark:border-slate-800 focus:border-brand-500/50 focus:ring-2 focus:ring-brand-500/10 outline-none transition-all @error('tanggal_lahir') border-rose-500 @enderror">
                                @error('tanggal_lahir')
                                    <span class="text-[10px] text-rose-500 mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Agama -->
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">
                                    Agama <span class="text-rose-500">*</span>
                                </label>
                                <select name="agama" required
                                    class="w-full px-4 py-2.5 text-xs rounded-xl bg-slate-50 dark:bg-slate-800/60 text-slate-800 dark:text-slate-100 border border-slate-200 dark:border-slate-800 focus:border-brand-500/50 focus:ring-2 focus:ring-brand-500/10 outline-none transition-all @error('agama') border-rose-500 @enderror">
                                    <option value="">-- Pilih Agama --</option>
                                    <option value="Islam"
                                        {{ old('agama', $anggota->agama ?? '') == 'Islam' ? 'selected' : '' }}>Islam
                                    </option>
                                    <option value="Kristen Protestan"
                                        {{ old('agama', $anggota->agama ?? '') == 'Kristen Protestan' ? 'selected' : '' }}>
                                        Kristen Protestan</option>
                                    <option value="Katolik"
                                        {{ old('agama', $anggota->agama ?? '') == 'Katolik' ? 'selected' : '' }}>Katolik
                                    </option>
                                    <option value="Hindu"
                                        {{ old('agama', $anggota->agama ?? '') == 'Hindu' ? 'selected' : '' }}>Hindu
                                    </option>
                                    <option value="Buddha"
                                        {{ old('agama', $anggota->agama ?? '') == 'Buddha' ? 'selected' : '' }}>Buddha
                                    </option>
                                    <option value="Khonghucu"
                                        {{ old('agama', $anggota->agama ?? '') == 'Khonghucu' ? 'selected' : '' }}>
                                        Khonghucu
                                    </option>
                                </select>
                                @error('agama')
                                    <span class="text-[10px] text-rose-500 mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Status Perkawinan -->
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">
                                    Status Perkawinan <span class="text-rose-500">*</span>
                                </label>
                                <select name="status_perkawinan" required
                                    class="w-full px-4 py-2.5 text-xs rounded-xl bg-slate-50 dark:bg-slate-800/60 text-slate-800 dark:text-slate-100 border border-slate-200 dark:border-slate-800 focus:border-brand-500/50 focus:ring-2 focus:ring-brand-500/10 outline-none transition-all @error('status_perkawinan') border-rose-500 @enderror">
                                    <option value="">-- Pilih Status --</option>
                                    <option value="Belum Kawin"
                                        {{ old('status_perkawinan', $anggota->status_perkawinan ?? '') == 'Belum Kawin' ? 'selected' : '' }}>
                                        Belum Kawin</option>
                                    <option value="Kawin"
                                        {{ old('status_perkawinan', $anggota->status_perkawinan ?? '') == 'Kawin' ? 'selected' : '' }}>
                                        Kawin</option>
                                    <option value="Cerai Hidup"
                                        {{ old('status_perkawinan', $anggota->status_perkawinan ?? '') == 'Cerai Hidup' ? 'selected' : '' }}>
                                        Cerai Hidup</option>
                                    <option value="Cerai Mati"
                                        {{ old('status_perkawinan', $anggota->status_perkawinan ?? '') == 'Cerai Mati' ? 'selected' : '' }}>
                                        Cerai Mati</option>
                                </select>
                                @error('status_perkawinan')
                                    <span class="text-[10px] text-rose-500 mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Pekerjaan -->
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">
                                    Pekerjaan / Profesi <span class="text-rose-500">*</span>
                                </label>
                                <input type="text" name="pekerjaan"
                                    value="{{ old('pekerjaan', $anggota->pekerjaan ?? '') }}" required
                                    placeholder="Contoh: Advokat / Wiraswasta"
                                    class="w-full px-4 py-2.5 text-xs rounded-xl bg-slate-50 dark:bg-slate-800/60 text-slate-800 dark:text-slate-100 border border-slate-200 dark:border-slate-800 focus:border-brand-500/50 focus:ring-2 focus:ring-brand-500/10 outline-none transition-all @error('pekerjaan') border-rose-500 @enderror">
                                @error('pekerjaan')
                                    <span class="text-[10px] text-rose-500 mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Kewarganegaraan -->
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">
                                    Kewarganegaraan <span class="text-rose-500">*</span>
                                </label>
                                <select name="kewarganegaraan" required
                                    class="w-full px-4 py-2.5 text-xs rounded-xl bg-slate-50 dark:bg-slate-800/60 text-slate-800 dark:text-slate-100 border border-slate-200 dark:border-slate-800 focus:border-brand-500/50 focus:ring-2 focus:ring-brand-500/10 outline-none transition-all @error('kewarganegaraan') border-rose-500 @enderror">
                                    <option value="WNI"
                                        {{ old('kewarganegaraan', $anggota->kewarganegaraan ?? 'WNI') == 'WNI' ? 'selected' : '' }}>
                                        WNI (Warga Negara Indonesia)</option>
                                    <option value="WNA"
                                        {{ old('kewarganegaraan', $anggota->kewarganegaraan ?? '') == 'WNA' ? 'selected' : '' }}>
                                        WNA (Warga Negara Asing)</option>
                                </select>
                                @error('kewarganegaraan')
                                    <span class="text-[10px] text-rose-500 mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- SECTION 2: KONTAK & ALAMAT DOMISILI -->
                    <div>
                        <div class="flex items-center gap-2 mb-4 pb-2 border-b border-slate-100 dark:border-slate-800">
                            <div
                                class="w-7 h-7 rounded-lg bg-indigo-50 text-indigo-600 dark:bg-indigo-500/10 dark:text-indigo-400 flex items-center justify-center text-xs font-bold">
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
                                <input type="email" name="email"
                                    value="{{ old('email', $anggota->email ?? (Auth::user()->email ?? '')) }}" required
                                    placeholder="nama@email.com"
                                    class="w-full px-4 py-2.5 text-xs rounded-xl bg-slate-50 dark:bg-slate-800/60 text-slate-800 dark:text-slate-100 border border-slate-200 dark:border-slate-800 focus:border-brand-500/50 focus:ring-2 focus:ring-brand-500/10 outline-none transition-all @error('email') border-rose-500 @enderror">
                                @error('email')
                                    <span class="text-[10px] text-rose-500 mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Nomor HP / WhatsApp -->
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">
                                    No. WhatsApp / HP <span class="text-rose-500">*</span>
                                </label>
                                <input type="tel" name="no_hp" value="{{ old('no_hp', $anggota->no_hp ?? '') }}"
                                    required placeholder="081234567890"
                                    class="w-full px-4 py-2.5 text-xs rounded-xl bg-slate-50 dark:bg-slate-800/60 text-slate-800 dark:text-slate-100 border border-slate-200 dark:border-slate-800 focus:border-brand-500/50 focus:ring-2 focus:ring-brand-500/10 outline-none transition-all @error('no_hp') border-rose-500 @enderror">
                                @error('no_hp')
                                    <span class="text-[10px] text-rose-500 mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Provinsi -->
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">
                                    Provinsi <span class="text-rose-500">*</span>
                                </label>
                                <select name="provinsi" id="provinsi" required
                                    class="w-full px-4 py-2.5 text-xs rounded-xl bg-slate-50 dark:bg-slate-800/60 text-slate-800 dark:text-slate-100 border border-slate-200 dark:border-slate-800 focus:border-brand-500/50 focus:ring-2 focus:ring-brand-500/10 outline-none transition-all">
                                    <option value="">-- Pilih Provinsi --</option>
                                </select>
                            </div>

                            <!-- Kota/Kabupaten -->
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">
                                    Kota/Kabupaten <span class="text-rose-500">*</span>
                                </label>
                                <select name="kota" id="kota" required
                                    class="w-full px-4 py-2.5 text-xs rounded-xl bg-slate-50 dark:bg-slate-800/60 text-slate-800 dark:text-slate-100 border border-slate-200 dark:border-slate-800 focus:border-brand-500/50 focus:ring-2 focus:ring-brand-500/10 outline-none transition-all">
                                    <option value="">-- Pilih Kota/Kabupaten --</option>
                                </select>
                            </div>

                            <!-- Kecamatan -->
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">
                                    Kecamatan <span class="text-rose-500">*</span>
                                </label>
                                <select name="kecamatan" id="kecamatan" required
                                    class="w-full px-4 py-2.5 text-xs rounded-xl bg-slate-50 dark:bg-slate-800/60 text-slate-800 dark:text-slate-100 border border-slate-200 dark:border-slate-800 focus:border-brand-500/50 focus:ring-2 focus:ring-brand-500/10 outline-none transition-all">
                                    <option value="">-- Pilih Kecamatan --</option>
                                </select>
                            </div>

                            <!-- Kelurahan/Desa -->
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">
                                    Kelurahan / Desa <span class="text-rose-500">*</span>
                                </label>
                                <select name="kelurahan" id="kelurahan" required
                                    class="w-full px-4 py-2.5 text-xs rounded-xl bg-slate-50 dark:bg-slate-800/60 text-slate-800 dark:text-slate-100 border border-slate-200 dark:border-slate-800 focus:border-brand-500/50 focus:ring-2 focus:ring-brand-500/10 outline-none transition-all">
                                    <option value="">-- Pilih Kelurahan/Desa --</option>
                                </select>
                            </div>

                            <!-- Alamat Lengkap (Detail Jalan/RT/RW) -->
                            <div class="sm:col-span-2">
                                <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">
                                    Detail Alamat (Nama Jalan, No. Rumah, RT/RW) <span class="text-rose-500">*</span>
                                </label>
                                <textarea name="alamat" rows="2" required placeholder="Contoh: Jl. Pettarani No. 12, RT 001 / RW 002"
                                    class="w-full px-4 py-2.5 text-xs rounded-xl bg-slate-50 dark:bg-slate-800/60 text-slate-800 dark:text-slate-100 border border-slate-200 dark:border-slate-800 focus:border-brand-500/50 focus:ring-2 focus:ring-brand-500/10 outline-none transition-all @error('alamat') border-rose-500 @enderror">{{ old('alamat', $anggota->alamat ?? '') }}</textarea>
                                @error('alamat')
                                    <span class="text-[10px] text-rose-500 mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- SECTION 3: UPLOAD DOKUMEN PENDUKUNG -->
                    <div>
                        <div class="flex items-center gap-2 mb-4 pb-2 border-b border-slate-100 dark:border-slate-800">
                            <div
                                class="w-7 h-7 rounded-lg bg-purple-50 text-purple-600 dark:bg-purple-500/10 dark:text-purple-400 flex items-center justify-center text-xs font-bold">
                                3
                            </div>
                            <h3 class="text-sm font-extrabold text-slate-900 dark:text-white uppercase tracking-wider">
                                Upload Dokumen Berkas
                            </h3>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <!-- Upload Pas Foto dengan Live Preview -->
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">
                                    Pas Foto (3x4) <span class="text-rose-500">*</span>
                                </label>
                                <div
                                    class="relative p-4 rounded-2xl border-2 border-dashed border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/30 text-center hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">

                                    <!-- Area Preview Pas Foto -->
                                    <div id="preview-foto-container" class="hidden mb-3">
                                        <img id="preview-foto" src="#" alt="Preview Pas Foto"
                                            class="mx-auto h-32 w-24 object-cover rounded-lg border border-slate-200 dark:border-slate-700 shadow-sm">
                                    </div>

                                    <!-- Placeholder Icon saat belum upload -->
                                    <div id="placeholder-foto">
                                        <i class="fa-solid fa-camera text-slate-400 text-xl mb-1"></i>
                                        <p class="text-[11px] text-slate-500 dark:text-slate-400">JPG/PNG (Maks 2MB)</p>
                                    </div>

                                    <!-- Input File -->
                                    <input type="file" name="foto" id="input-foto" accept="image/*" required
                                        onchange="previewImage(this, 'preview-foto', 'preview-foto-container', 'placeholder-foto')"
                                        class="mt-2 text-xs text-slate-500 w-full file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-[11px] file:font-semibold file:bg-brand-50 file:text-brand-600 dark:file:bg-brand-500/10 dark:file:text-brand-400 hover:file:bg-brand-100">
                                </div>
                                @error('foto')
                                    <span class="text-[10px] text-rose-500 mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Upload Foto KTP dengan Live Preview -->
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">
                                    Scan / Foto KTP <span class="text-rose-500">*</span>
                                </label>
                                <div
                                    class="relative p-4 rounded-2xl border-2 border-dashed border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/30 text-center hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">

                                    <!-- Area Preview KTP -->
                                    <div id="preview-ktp-container" class="hidden mb-3">
                                        <img id="preview-ktp" src="#" alt="Preview KTP"
                                            class="mx-auto h-24 w-36 object-cover rounded-lg border border-slate-200 dark:border-slate-700 shadow-sm">
                                    </div>

                                    <!-- Placeholder Icon saat belum upload -->
                                    <div id="placeholder-ktp">
                                        <i class="fa-solid fa-address-card text-slate-400 text-xl mb-1"></i>
                                        <p class="text-[11px] text-slate-500 dark:text-slate-400">JPG/PNG/PDF (Maks 2MB)
                                        </p>
                                    </div>

                                    <!-- Input File -->
                                    <input type="file" name="foto_ktp" id="input-ktp" accept="image/*,.pdf" required
                                        onchange="previewImage(this, 'preview-ktp', 'preview-ktp-container', 'placeholder-ktp')"
                                        class="mt-2 text-xs text-slate-500 w-full file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-[11px] file:font-semibold file:bg-brand-50 file:text-brand-600 dark:file:bg-brand-500/10 dark:file:text-brand-400 hover:file:bg-brand-100">
                                </div>
                                @error('foto_ktp')
                                    <span class="text-[10px] text-rose-500 mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Upload Pakta Integritas -->
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">
                                    Pakta Integritas <span class="text-slate-400 font-normal">(Opsional)</span>
                                </label>
                                <div
                                    class="p-4 rounded-2xl border-2 border-dashed border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/30 text-center hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                                    <i class="fa-solid fa-file-contract text-slate-400 text-xl mb-1"></i>
                                    <p class="text-[11px] text-slate-500 dark:text-slate-400">PDF (Maks 5MB)</p>
                                    <input type="file" name="pakta_integritas" accept=".pdf"
                                        class="mt-2 text-xs text-slate-500 w-full file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-[11px] file:font-semibold file:bg-brand-50 file:text-brand-600 dark:file:bg-brand-500/10 dark:file:text-brand-400 hover:file:bg-brand-100">
                                </div>
                                @error('pakta_integritas')
                                    <span class="text-[10px] text-rose-500 mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- SECTION 4: KETERANGAN TAMBAHAN -->
                    <div>
                        <div class="flex items-center gap-2 mb-4 pb-2 border-b border-slate-100 dark:border-slate-800">
                            <div
                                class="w-7 h-7 rounded-lg bg-emerald-50 text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-400 flex items-center justify-center text-xs font-bold">
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
                            <textarea name="keterangan" rows="2"
                                placeholder="Catatan khusus atau keahlian tambahan yang ingin disampaikan..."
                                class="w-full px-4 py-2.5 text-xs rounded-xl bg-slate-50 dark:bg-slate-800/60 text-slate-800 dark:text-slate-100 border border-slate-200 dark:border-slate-800 focus:border-brand-500/50 focus:ring-2 focus:ring-brand-500/10 outline-none transition-all @error('keterangan') border-rose-500 @enderror">{{ old('keterangan', $anggota->keterangan ?? '') }}</textarea>
                            @error('keterangan')
                                <span class="text-[10px] text-rose-500 mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-end gap-3">
                        <button type="reset" onclick="resetPreviews()"
                            class="px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 font-semibold text-xs transition-colors">
                            Reset Form
                        </button>
                        <button type="submit"
                            class="px-6 py-2.5 rounded-xl bg-brand-600 hover:bg-brand-700 text-white font-semibold text-xs shadow-lg shadow-brand-500/25 transition-all duration-200 hover:scale-[1.02] flex items-center gap-2"
                            @if (
                                $anggota &&
                                    $anggota->card &&
                                    $anggota->card->latestStatus &&
                                    in_array($anggota->card->latestStatus->status, ['proses', 'aktif'])) disabled @endif>
                            <i class="fa-solid fa-paper-plane text-xs"></i>
                            <span>
                                {{ $anggota ? 'Perbarui & Ajukan Kembali' : 'Kirim Permohonan Pendaftaran' }}
                            </span>
                        </button>
                    </div>

                </form>

            </div>

        </div>

        <script>
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

            // Dynamic Dependent Dropdowns (Wilayah Indonesia)
            document.addEventListener('DOMContentLoaded', function() {
                const provinsiSelect = document.getElementById('provinsi');
                const kotaSelect = document.getElementById('kota');
                const kecamatanSelect = document.getElementById('kecamatan');
                const kelurahanSelect = document.getElementById('kelurahan');

                function fetchAndPopulate(url, selectElement, next) {
                    fetch(url)
                        .then(response => response.json())
                        .then(data => {
                            data.forEach(item => {
                                const option = document.createElement('option');
                                option.value = item.nama;
                                option.dataset.id = item.id;
                                option.textContent = item.nama;
                                selectElement.appendChild(option);
                            });
                        }).catch(error => console.error(`Error fetching ${selectElement.id}:`, error));
                }

                // Initial Load
                fetchAndPopulate('/api/get-provinces', provinsiSelect);

                // Event Listeners
                provinsiSelect.addEventListener('change', function() {
                    const selectedOption = this.options[this.selectedIndex];
                    const provinsiId = selectedOption.dataset.id;
                    kotaSelect.innerHTML = '<option value="">-- Pilih Kota/Kabupaten --</option>';
                    kecamatanSelect.innerHTML = '<option value="">-- Pilih Kecamatan --</option>';
                    kelurahanSelect.innerHTML = '<option value="">-- Pilih Kelurahan/Desa --</option>';
                    if (provinsiId) {
                        fetchAndPopulate(`/api/get-cities?province_id=${provinsiId}`, kotaSelect);
                    }
                });

                kotaSelect.addEventListener('change', function() {
                    const selectedOption = this.options[this.selectedIndex];
                    const kotaId = selectedOption.dataset.id;
                    kecamatanSelect.innerHTML = '<option value="">-- Pilih Kecamatan --</option>';
                    kelurahanSelect.innerHTML = '<option value="">-- Pilih Kelurahan/Desa --</option>';
                    if (kotaId) {
                        fetchAndPopulate(`/api/get-districts?city_id=${kotaId}`, kecamatanSelect);
                    }
                });

                kecamatanSelect.addEventListener('change', function() {
                    const selectedOption = this.options[this.selectedIndex];
                    const kecamatanId = selectedOption.dataset.id;
                    kelurahanSelect.innerHTML = '<option value="">-- Pilih Kelurahan/Desa --</option>';
                    if (kecamatanId) {
                        fetchAndPopulate(`/api/get-villages?district_id=${kecamatanId}`, kelurahanSelect);
                    }
                });
            });
        </script>
        @push('scripts')
            <script>
                // Preview Image Helper
                function previewImage(input, previewId, containerId, placeholderId) {
                    const container = document.getElementById(containerId);
                    const placeholder = document.getElementById(placeholderId);
                    const preview = document.getElementById(previewId);

                    if (input.files && input.files[0]) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            preview.src = e.target.result;
                            container.classList.remove('hidden');
                            placeholder.classList.add('hidden');
                        }
                        reader.readAsDataURL(input.files[0]);
                    }
                }

                // Dependent Dropdown Wilayah Indonesia (Menggunakan API Publik e.g., Wilayah Indonesia / Fikkri)
                document.addEventListener("DOMContentLoaded", function() {
                    const provinceSelect = document.getElementById('provinsi');
                    const regencySelect = document.getElementById('kota');
                    const districtSelect = document.getElementById('kecamatan');
                    const villageSelect = document.getElementById('kelurahan');

                    // 1. Ambil Data Provinsi
                    fetch('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json')
                        .then(response => response.json())
                        .then(provinces => {
                            provinceSelect.innerHTML = '<option value="">-- Pilih Provinsi --</option>';
                            provinces.forEach(province => {
                                provinceSelect.innerHTML +=
                                    `<option value="${province.id}" data-name="${province.name}">${province.name}</option>`;
                            });
                        });

                    // 2. Event ketika Provinsi dipilih -> Load Kota/Kabupaten
                    provinceSelect.addEventListener('change', function() {
                        const provinceId = this.value;
                        regencySelect.innerHTML = '<option value="">-- Pilih Kota/Kabupaten --</option>';
                        districtSelect.innerHTML = '<option value="">-- Pilih Kecamatan --</option>';
                        villageSelect.innerHTML = '<option value="">-- Pilih Kelurahan/Desa --</option>';

                        if (provinceId) {
                            fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${provinceId}.json`)
                                .then(response => response.json())
                                .then(regencies => {
                                    regencies.forEach(regency => {
                                        regencySelect.innerHTML +=
                                            `<option value="${regency.id}" data-name="${regency.name}">${regency.name}</option>`;
                                    });
                                });
                        }
                    });

                    // 3. Event ketika Kota/Kabupaten dipilih -> Load Kecamatan
                    regencySelect.addEventListener('change', function() {
                        const regencyId = this.value;
                        districtSelect.innerHTML = '<option value="">-- Pilih Kecamatan --</option>';
                        villageSelect.innerHTML = '<option value="">-- Pilih Kelurahan/Desa --</option>';

                        if (regencyId) {
                            fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/districts/${regencyId}.json`)
                                .then(response => response.json())
                                .then(districts => {
                                    districts.forEach(district => {
                                        districtSelect.innerHTML +=
                                            `<option value="${district.id}" data-name="${district.name}">${district.name}</option>`;
                                    });
                                });
                        }
                    });

                    // 4. Event ketika Kecamatan dipilih -> Load Kelurahan/Desa
                    districtSelect.addEventListener('change', function() {
                        const districtId = this.value;
                        villageSelect.innerHTML = '<option value="">-- Pilih Kelurahan/Desa --</option>';

                        if (districtId) {
                            fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/villages/${districtId}.json`)
                                .then(response => response.json())
                                .then(villages => {
                                    villages.forEach(village => {
                                        villageSelect.innerHTML +=
                                            `<option value="${village.id}" data-name="${village.name}">${village.name}</option>`;
                                    });
                                });
                        }
                    });
                });
            </script>
        @endpush

    @endsection
