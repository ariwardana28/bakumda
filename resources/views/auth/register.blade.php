@extends('layouts.app')

@section('title', 'Daftar Akun - BAKUMDA')

@section('content')
    <!-- Kontainer Form Registrasi -->
    <div class="w-full max-w-2xl mx-auto flex flex-col justify-center pb-12 2xl:hidden" x-data="regionSelector()">
        <!-- Card Pembungkus Utama -->
        <div
            class="bg-white shadow-xl shadow-slate-900/10 border border-slate-100 rounded-[2.5rem] p-6 sm:p-10 space-y-6 w-full text-slate-900">

            <!-- Logo & Judul Sambutan -->
            <div class="text-center space-y-2">
                <div class="w-44 h-20 mx-auto flex items-center justify-center overflow-hidden">
                    <img src="{{ asset('log.png') }}" alt="Logo BAKUMDA" class="w-full h-full object-contain">
                </div>
                <div class="space-y-1">
                    <h1 class="text-xl sm:text-2xl font-black text-gray-900 tracking-tight">Bergabung Sekarang</h1>
                    <p class="text-xs sm:text-sm text-gray-500 font-medium">Lengkapi data diri Anda untuk membuat akun baru
                    </p>
                </div>
            </div>

            <!-- Notifikasi Error Validasi Laravel -->
            @if ($errors->any())
                <div
                    class="p-4 rounded-3xl bg-rose-50/80 border border-rose-200/80 text-rose-600 text-xs font-medium space-y-2 shadow-sm backdrop-blur-sm">
                    <div class="flex items-center gap-2 font-bold uppercase tracking-wider text-[10px]">
                        <i class="fa-solid fa-triangle-exclamation text-sm"></i>
                        <span>Mohon periksa kembali formulir Anda</span>
                    </div>
                    <ul class="list-disc list-inside space-y-1 pl-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form Register -->
            <form method="POST" action="{{ route('register') }}" class="space-y-6">
                @csrf

                <!-- SECTION 1: Informasi Kontak & Identitas Utama -->
                <div class="bg-slate-50/60 border border-slate-200/60 rounded-3xl p-5 space-y-4">
                    <div
                        class="flex items-center gap-2 text-xs font-bold text-slate-700 uppercase tracking-wider pb-1 border-b border-slate-200/60">
                        <i class="fa-solid fa-id-card text-blue-600"></i>
                        <span>Informasi Identitas & Kontak</span>
                    </div>

                    <!-- Nama Lengkap -->
                    <div class="space-y-1.5">
                        <label class="block text-[11px] font-bold text-gray-700 uppercase tracking-wider">Nama
                            Lengkap</label>
                        <div class="relative group">
                            <span
                                class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-blue-600 transition-colors">
                                <i class="fa-solid fa-user text-sm"></i>
                            </span>
                            <input type="text" name="name" value="{{ old('name') }}" required autofocus
                                autocomplete="name"
                                class="w-full pl-11 pr-4 py-3.5 text-xs sm:text-sm rounded-2xl bg-white border border-gray-200/80 focus:ring-4 focus:ring-blue-500/15 focus:border-blue-600 outline-none transition-all duration-200 text-gray-900 font-semibold placeholder:text-gray-400 placeholder:font-normal @error('name') border-rose-500 bg-rose-50/30 focus:ring-rose-500/15 focus:border-rose-500 @enderror"
                                placeholder="Masukkan nama lengkap Anda">
                        </div>
                    </div>

                    <!-- No. HP & Jenis Kelamin -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="space-y-1.5">
                            <label class="block text-[11px] font-bold text-gray-700 uppercase tracking-wider">No. HP /
                                WhatsApp</label>
                            <div class="relative group">
                                <span
                                    class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-blue-600 transition-colors">
                                    <i class="fa-solid fa-phone text-sm"></i>
                                </span>
                                <input type="tel" name="no_hp" value="{{ old('no_hp') }}" required
                                    class="w-full pl-11 pr-4 py-3.5 text-xs sm:text-sm rounded-2xl bg-white border border-gray-200/80 focus:ring-4 focus:ring-blue-500/15 focus:border-blue-600 outline-none transition-all duration-200 text-gray-900 font-semibold placeholder:text-gray-400 placeholder:font-normal @error('no_hp') border-rose-500 bg-rose-50/30 focus:ring-rose-500/15 focus:border-rose-500 @enderror"
                                    placeholder="Contoh: 081234567890">
                            </div>
                        </div>

                        <div class="space-y-1.5">
                            <label class="block text-[11px] font-bold text-gray-700 uppercase tracking-wider">Jenis
                                Kelamin</label>
                            <select name="jenis_kelamin" required
                                class="w-full px-4 py-3.5 text-xs sm:text-sm rounded-2xl bg-white border border-gray-200/80 focus:ring-4 focus:ring-blue-500/15 focus:border-blue-600 outline-none transition-all duration-200 text-gray-900 font-semibold @error('jenis_kelamin') border-rose-500 bg-rose-50/30 focus:ring-rose-500/15 focus:border-rose-500 @enderror">
                                <option value="" disabled {{ old('jenis_kelamin') ? '' : 'selected' }}>Pilih Jenis
                                    Kelamin</option>
                                <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>
                                    Laki-laki</option>
                                <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>
                                    Perempuan</option>
                            </select>
                        </div>
                    </div>

                    <!-- Tempat & Tanggal Lahir -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="space-y-1.5">
                            <label class="block text-[11px] font-bold text-gray-700 uppercase tracking-wider">Tempat
                                Lahir</label>
                            <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}" required
                                class="w-full px-4 py-3.5 text-xs sm:text-sm rounded-2xl bg-white border border-gray-200/80 focus:ring-4 focus:ring-blue-500/15 focus:border-blue-600 outline-none transition-all duration-200 text-gray-900 font-semibold placeholder:text-gray-400 placeholder:font-normal @error('tempat_lahir') border-rose-500 bg-rose-50/30 focus:ring-rose-500/15 focus:border-rose-500 @enderror"
                                placeholder="Kota Kelahiran">
                        </div>
                        <div class="space-y-1.5">
                            <label class="block text-[11px] font-bold text-gray-700 uppercase tracking-wider">Tgl.
                                Lahir</label>
                            <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required
                                class="w-full px-4 py-3.5 text-xs sm:text-sm rounded-2xl bg-white border border-gray-200/80 focus:ring-4 focus:ring-blue-500/15 focus:border-blue-600 outline-none transition-all duration-200 text-gray-900 font-semibold @error('tanggal_lahir') border-rose-500 bg-rose-50/30 focus:ring-rose-500/15 focus:border-rose-500 @enderror">
                        </div>
                    </div>
                </div>

                <!-- SECTION 2: Alamat & Wilayah (Dengan Fitur Pencarian Dropdown) -->
                <div class="bg-slate-50/60 border border-slate-200/60 rounded-3xl p-5 space-y-4">
                    <div
                        class="flex items-center gap-2 text-xs font-bold text-slate-700 uppercase tracking-wider pb-1 border-b border-slate-200/60">
                        <i class="fa-solid fa-map-location-dot text-blue-600"></i>
                        <span>Alamat & Wilayah Domisili</span>
                    </div>

                    <!-- Alamat -->
                    <div class="space-y-1.5">
                        <label class="block text-[11px] font-bold text-gray-700 uppercase tracking-wider">Alamat
                            Lengkap</label>
                        <textarea name="alamat" rows="2" required
                            class="w-full px-4 py-3.5 text-xs sm:text-sm rounded-2xl bg-white border border-gray-200/80 focus:ring-4 focus:ring-blue-500/15 focus:border-blue-600 outline-none transition-all duration-200 text-gray-900 font-semibold placeholder:text-gray-400 placeholder:font-normal @error('alamat') border-rose-500 bg-rose-50/30 focus:ring-rose-500/15 focus:border-rose-500 @enderror"
                            placeholder="Masukkan alamat sesuai KTP">{{ old('alamat') }}</textarea>
                    </div>

                    <!-- Detail Alamat API dengan Custom Search Dropdown -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                        <!-- PROVINSI -->
                        <div class="space-y-1.5 relative" @click.away="openProvinsi = false">
                            <label
                                class="block text-[11px] font-bold text-gray-700 uppercase tracking-wider">Provinsi</label>
                            <input type="hidden" name="provinsi" x-model="selectedProvinsi">
                            <div @click="openProvinsi = !openProvinsi"
                                class="w-full px-4 py-3.5 text-xs sm:text-sm rounded-2xl bg-white border border-gray-200/80 focus-within:ring-4 focus-within:ring-blue-500/15 focus-within:border-blue-600 outline-none transition-all duration-200 text-gray-900 font-semibold cursor-pointer flex items-center justify-between">
                                <span x-text="selectedProvinsi || 'Pilih Provinsi'"></span>
                                <i class="fa-solid fa-chevron-down text-xs text-gray-400"></i>
                            </div>

                            <!-- Dropdown Search Panel -->
                            <div x-show="openProvinsi"
                                class="absolute z-50 mt-1 w-full bg-white border border-gray-200 shadow-xl rounded-2xl p-2 space-y-2 max-h-60 overflow-y-auto">
                                <input type="text" x-model="searchProvinsi" placeholder="Cari provinsi..."
                                    class="w-full px-3 py-2 text-xs rounded-xl bg-gray-50 border border-gray-200 focus:outline-none focus:border-blue-600">
                                <div class="space-y-0.5">
                                    <template x-for="prov in filteredProvinsis" :key="prov.id">
                                        <div @click="selectedProvinsi = prov.name; openProvinsi = false; searchProvinsi = ''; getKabupaten()"
                                            class="px-3 py-2 text-xs hover:bg-blue-50 hover:text-blue-600 rounded-xl cursor-pointer font-medium transition-colors"
                                            x-text="prov.name"></div>
                                    </template>
                                    <div x-show="filteredProvinsis.length === 0"
                                        class="px-3 py-2 text-xs text-gray-400 text-center">Tidak ditemukan</div>
                                </div>
                            </div>
                        </div>

                        <!-- KOTA / KABUPATEN -->
                        <div class="space-y-1.5 relative" @click.away="openKota = false">
                            <label
                                class="block text-[11px] font-bold text-gray-700 uppercase tracking-wider">Kota/Kab.</label>
                            <input type="hidden" name="kota" x-model="selectedKota">
                            <div @click="if(selectedProvinsi) openKota = !openKota"
                                :class="!selectedProvinsi ? 'opacity-50 cursor-not-allowed' : 'cursor-pointer'"
                                class="w-full px-4 py-3.5 text-xs sm:text-sm rounded-2xl bg-white border border-gray-200/80 focus-within:ring-4 focus-within:ring-blue-500/15 focus-within:border-blue-600 outline-none transition-all duration-200 text-gray-900 font-semibold flex items-center justify-between">
                                <span x-text="selectedKota || 'Pilih Kota/Kab'"></span>
                                <i class="fa-solid fa-chevron-down text-xs text-gray-400"></i>
                            </div>

                            <!-- Dropdown Search Panel -->
                            <div x-show="openKota"
                                class="absolute z-50 mt-1 w-full bg-white border border-gray-200 shadow-xl rounded-2xl p-2 space-y-2 max-h-60 overflow-y-auto">
                                <input type="text" x-model="searchKota" placeholder="Cari kota/kabupaten..."
                                    class="w-full px-3 py-2 text-xs rounded-xl bg-gray-50 border border-gray-200 focus:outline-none focus:border-blue-600">
                                <div class="space-y-0.5">
                                    <template x-for="kab in filteredKabupatens" :key="kab.id">
                                        <div @click="selectedKota = kab.name; openKota = false; searchKota = ''; getKecamatan()"
                                            class="px-3 py-2 text-xs hover:bg-blue-50 hover:text-blue-600 rounded-xl cursor-pointer font-medium transition-colors"
                                            x-text="kab.name"></div>
                                    </template>
                                    <div x-show="filteredKabupatens.length === 0"
                                        class="px-3 py-2 text-xs text-gray-400 text-center">Tidak ditemukan</div>
                                </div>
                            </div>
                        </div>

                        <!-- KECAMATAN -->
                        <div class="space-y-1.5 relative" @click.away="openKecamatan = false">
                            <label
                                class="block text-[11px] font-bold text-gray-700 uppercase tracking-wider">Kecamatan</label>
                            <input type="hidden" name="kecamatan" x-model="selectedKecamatan">
                            <div @click="if(selectedKota) openKecamatan = !openKecamatan"
                                :class="!selectedKota ? 'opacity-50 cursor-not-allowed' : 'cursor-pointer'"
                                class="w-full px-4 py-3.5 text-xs sm:text-sm rounded-2xl bg-white border border-gray-200/80 focus-within:ring-4 focus-within:ring-blue-500/15 focus-within:border-blue-600 outline-none transition-all duration-200 text-gray-900 font-semibold flex items-center justify-between">
                                <span x-text="selectedKecamatan || 'Pilih Kecamatan'"></span>
                                <i class="fa-solid fa-chevron-down text-xs text-gray-400"></i>
                            </div>

                            <!-- Dropdown Search Panel -->
                            <div x-show="openKecamatan"
                                class="absolute z-50 mt-1 w-full bg-white border border-gray-200 shadow-xl rounded-2xl p-2 space-y-2 max-h-60 overflow-y-auto">
                                <input type="text" x-model="searchKecamatan" placeholder="Cari kecamatan..."
                                    class="w-full px-3 py-2 text-xs rounded-xl bg-gray-50 border border-gray-200 focus:outline-none focus:border-blue-600">
                                <div class="space-y-0.5">
                                    <template x-for="kec in filteredKecamatans" :key="kec.id">
                                        <div @click="selectedKecamatan = kec.name; openKecamatan = false; searchKecamatan = ''; getKelurahan()"
                                            class="px-3 py-2 text-xs hover:bg-blue-50 hover:text-blue-600 rounded-xl cursor-pointer font-medium transition-colors"
                                            x-text="kec.name"></div>
                                    </template>
                                    <div x-show="filteredKecamatans.length === 0"
                                        class="px-3 py-2 text-xs text-gray-400 text-center">Tidak ditemukan</div>
                                </div>
                            </div>
                        </div>

                        <!-- KELURAHAN -->
                        <div class="space-y-1.5 relative" @click.away="openKelurahan = false">
                            <label
                                class="block text-[11px] font-bold text-gray-700 uppercase tracking-wider">Kelurahan</label>
                            <input type="hidden" name="kelurahan" x-model="selectedKelurahan">
                            <div @click="if(selectedKecamatan) openKelurahan = !openKelurahan"
                                :class="!selectedKecamatan ? 'opacity-50 cursor-not-allowed' : 'cursor-pointer'"
                                class="w-full px-4 py-3.5 text-xs sm:text-sm rounded-2xl bg-white border border-gray-200/80 focus-within:ring-4 focus-within:ring-blue-500/15 focus-within:border-blue-600 outline-none transition-all duration-200 text-gray-900 font-semibold flex items-center justify-between">
                                <span x-text="selectedKelurahan || 'Pilih Kelurahan'"></span>
                                <i class="fa-solid fa-chevron-down text-xs text-gray-400"></i>
                            </div>

                            <!-- Dropdown Search Panel -->
                            <div x-show="openKelurahan"
                                class="absolute z-50 mt-1 w-full bg-white border border-gray-200 shadow-xl rounded-2xl p-2 space-y-2 max-h-60 overflow-y-auto">
                                <input type="text" x-model="searchKelurahan" placeholder="Cari kelurahan..."
                                    class="w-full px-3 py-2 text-xs rounded-xl bg-gray-50 border border-gray-200 focus:outline-none focus:border-blue-600">
                                <div class="space-y-0.5">
                                    <template x-for="kel in filteredKelurahans" :key="kel.id">
                                        <div @click="selectedKelurahan = kel.name; openKelurahan = false; searchKelurahan = ''"
                                            class="px-3 py-2 text-xs hover:bg-blue-50 hover:text-blue-600 rounded-xl cursor-pointer font-medium transition-colors"
                                            x-text="kel.name"></div>
                                    </template>
                                    <div x-show="filteredKelurahans.length === 0"
                                        class="px-3 py-2 text-xs text-gray-400 text-center">Tidak ditemukan</div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- SECTION 3: Data Tambahan (Agama, Status, Pekerjaan) -->
                <div class="bg-slate-50/60 border border-slate-200/60 rounded-3xl p-5 space-y-4">
                    <div
                        class="flex items-center gap-2 text-xs font-bold text-slate-700 uppercase tracking-wider pb-1 border-b border-slate-200/60">
                        <i class="fa-solid fa-circle-info text-blue-600"></i>
                        <span>Informasi Tambahan</span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="space-y-1.5">
                            <label class="block text-[11px] font-bold text-gray-700 uppercase tracking-wider">Agama</label>
                            <select name="agama" required
                                class="w-full px-4 py-3.5 text-xs sm:text-sm rounded-2xl bg-white border border-gray-200/80 focus:ring-4 focus:ring-blue-500/15 focus:border-blue-600 outline-none transition-all duration-200 text-gray-900 font-semibold">
                                <option value="" disabled {{ old('agama') ? '' : 'selected' }}>Pilih Agama</option>
                                <option value="Islam" {{ old('agama') == 'Islam' ? 'selected' : '' }}>Islam</option>
                                <option value="Kristen" {{ old('agama') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                                <option value="Katolik" {{ old('agama') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                                <option value="Hindu" {{ old('agama') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                <option value="Buddha" {{ old('agama') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                                <option value="Konghucu" {{ old('agama') == 'Konghucu' ? 'selected' : '' }}>Konghucu
                                </option>
                            </select>
                        </div>

                        <div class="space-y-1.5">
                            <label class="block text-[11px] font-bold text-gray-700 uppercase tracking-wider">Status
                                Kawin</label>
                            <select name="status_perkawinan" required
                                class="w-full px-4 py-3.5 text-xs sm:text-sm rounded-2xl bg-white border border-gray-200/80 focus:ring-4 focus:ring-blue-500/15 focus:border-blue-600 outline-none transition-all duration-200 text-gray-900 font-semibold">
                                <option value="" disabled {{ old('status_perkawinan') ? '' : 'selected' }}>Pilih
                                    Status</option>
                                <option value="Belum Menikah"
                                    {{ old('status_perkawinan') == 'Belum Menikah' ? 'selected' : '' }}>Belum Menikah
                                </option>
                                <option value="Menikah" {{ old('status_perkawinan') == 'Menikah' ? 'selected' : '' }}>
                                    Menikah</option>
                                <option value="Cerai" {{ old('status_perkawinan') == 'Cerai' ? 'selected' : '' }}>Cerai
                                </option>
                            </select>
                        </div>

                        <div class="space-y-1.5">
                            <label
                                class="block text-[11px] font-bold text-gray-700 uppercase tracking-wider">Pekerjaan</label>
                            <input type="text" name="pekerjaan" value="{{ old('pekerjaan') }}" required
                                class="w-full px-4 py-3.5 text-xs sm:text-sm rounded-2xl bg-white border border-gray-200/80 focus:ring-4 focus:ring-blue-500/15 focus:border-blue-600 outline-none transition-all duration-200 text-gray-900 font-semibold placeholder:text-gray-400 placeholder:font-normal"
                                placeholder="Pekerjaan saat ini">
                        </div>

                        <div class="space-y-1.5">
                            <label class="block text-[11px] font-bold text-gray-700 uppercase tracking-wider">Warga
                                Negara</label>
                            <select name="kewarganegaraan" required
                                class="w-full px-4 py-3.5 text-xs sm:text-sm rounded-2xl bg-white border border-gray-200/80 focus:ring-4 focus:ring-blue-500/15 focus:border-blue-600 outline-none transition-all duration-200 text-gray-900 font-semibold">
                                <option value="WNI" {{ old('kewarganegaraan', 'WNI') == 'WNI' ? 'selected' : '' }}>WNI
                                </option>
                                <option value="WNA" {{ old('kewarganegaraan') == 'WNA' ? 'selected' : '' }}>WNA
                                </option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- SECTION 4: Keamanan Akun (Email, Kata Sandi, & Konfirmasi Sandi) -->
                <div class="bg-blue-50/40 border border-blue-100 rounded-3xl p-5 space-y-4 shadow-sm">
                    <div
                        class="flex items-center gap-2 text-xs font-bold text-blue-900 uppercase tracking-wider pb-1 border-b border-blue-100">
                        <i class="fa-solid fa-shield-halved text-blue-600"></i>
                        <span>Keamanan & Kredensial Akun</span>
                    </div>

                    <!-- Email Card Field -->
                    <div class="space-y-1.5">
                        <label class="block text-[11px] font-bold text-gray-700 uppercase tracking-wider">Alamat Email
                            (Untuk Login)</label>
                        <div class="relative group">
                            <span
                                class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-blue-600 transition-colors">
                                <i class="fa-solid fa-envelope text-sm"></i>
                            </span>
                            <input type="email" name="email" value="{{ old('email') }}" required
                                autocomplete="username"
                                class="w-full pl-11 pr-4 py-3.5 text-xs sm:text-sm rounded-2xl bg-white border border-gray-200/80 focus:ring-4 focus:ring-blue-500/15 focus:border-blue-600 outline-none transition-all duration-200 text-gray-900 font-semibold placeholder:text-gray-400 placeholder:font-normal @error('email') border-rose-500 bg-rose-50/30 focus:ring-rose-500/15 focus:border-rose-500 @enderror"
                                placeholder="nama@domain.com">
                        </div>
                    </div>

                    <!-- Kata Sandi & Konfirmasi Kata Sandi -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Password Input -->
                        <div class="space-y-1.5" x-data="{ showPassword: false }">
                            <label class="block text-[11px] font-bold text-gray-700 uppercase tracking-wider">Kata
                                Sandi</label>
                            <div class="relative group">
                                <span
                                    class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-blue-600 transition-colors">
                                    <i class="fa-solid fa-lock text-sm"></i>
                                </span>
                                <input :type="showPassword ? 'text' : 'password'" name="password" required
                                    autocomplete="new-password"
                                    class="w-full pl-11 pr-12 py-3.5 text-xs sm:text-sm rounded-2xl bg-white border border-gray-200/80 focus:ring-4 focus:ring-blue-500/15 focus:border-blue-600 outline-none transition-all duration-200 text-gray-900 font-semibold placeholder:text-gray-400 placeholder:font-normal @error('password') border-rose-500 bg-rose-50/30 focus:ring-rose-500/15 focus:border-rose-500 @enderror"
                                    placeholder="Minimal 8 karakter">
                                <button type="button" @click="showPassword = !showPassword"
                                    class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-gray-600 focus:outline-none transition-colors">
                                    <i class="fa-solid text-sm" :class="showPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Confirm Password Input -->
                        <div class="space-y-1.5" x-data="{ showConfirmPassword: false }">
                            <label class="block text-[11px] font-bold text-gray-700 uppercase tracking-wider">Konfirmasi
                                Kata Sandi</label>
                            <div class="relative group">
                                <span
                                    class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-blue-600 transition-colors">
                                    <i class="fa-solid fa-lock text-sm"></i>
                                </span>
                                <input :type="showConfirmPassword ? 'text' : 'password'" name="password_confirmation"
                                    required autocomplete="new-password"
                                    class="w-full pl-11 pr-12 py-3.5 text-xs sm:text-sm rounded-2xl bg-white border border-gray-200/80 focus:ring-4 focus:ring-blue-500/15 focus:border-blue-600 outline-none transition-all duration-200 text-gray-900 font-semibold placeholder:text-gray-400 placeholder:font-normal @error('password_confirmation') border-rose-500 bg-rose-50/30 focus:ring-rose-500/15 focus:border-rose-500 @enderror"
                                    placeholder="Ulangi kata sandi">
                                <button type="button" @click="showConfirmPassword = !showConfirmPassword"
                                    class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-gray-600 focus:outline-none transition-colors">
                                    <i class="fa-solid text-sm"
                                        :class="showConfirmPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tombol Aksi Register & Redirect Login -->
                <div class="pt-4 space-y-3">
                    <button type="submit"
                        class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-extrabold py-4 px-6 rounded-2xl shadow-xl shadow-blue-600/25 active:scale-[0.99] transition-all duration-200 flex items-center justify-center gap-2.5 text-xs tracking-wider uppercase">
                        <span>Daftar Akun Baru</span>
                        <i class="fa-solid fa-arrow-right text-xs"></i>
                    </button>

                    <div class="relative flex py-1 items-center">
                        <div class="flex-grow border-t border-gray-100"></div>
                        <span
                            class="flex-shrink mx-4 text-gray-400 text-[10px] font-bold uppercase tracking-widest">Atau</span>
                        <div class="flex-grow border-t border-gray-100"></div>
                    </div>

                    <a href="{{ route('login') }}"
                        class="w-full bg-gray-50 hover:bg-gray-100 text-gray-700 border border-gray-200/80 font-bold py-3.5 px-6 rounded-2xl shadow-sm hover:shadow transition-all duration-200 flex items-center justify-center gap-2 text-xs tracking-wider uppercase">
                        <i class="fa-solid fa-right-to-bracket text-blue-600"></i>
                        <span>Sudah punya akun? Masuk</span>
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Script Alpine.js dengan Fitur Pencarian Real-Time (Autocomplete) -->
    <script>
        function regionSelector() {
            return {
                provinsis: [],
                kabupatens: [],
                kecamatans: [],
                kelurahans: [],

                selectedProvinsi: '{{ old('provinsi') }}',
                selectedKota: '{{ old('kota') }}',
                selectedKecamatan: '{{ old('kecamatan') }}',
                selectedKelurahan: '{{ old('kelurahan') }}',

                openProvinsi: false,
                openKota: false,
                openKecamatan: false,
                openKelurahan: false,

                searchProvinsi: '',
                searchKota: '',
                searchKecamatan: '',
                searchKelurahan: '',

                get filteredProvinsis() {
                    if (this.searchProvinsi === '') {
                        return this.provinsis;
                    }
                    return this.provinsis.filter(p => p.name.toLowerCase().includes(this.searchProvinsi.toLowerCase()));
                },

                get filteredKabupatens() {
                    if (this.searchKota === '') {
                        return this.kabupatens;
                    }
                    return this.kabupatens.filter(k => k.name.toLowerCase().includes(this.searchKota.toLowerCase()));
                },

                get filteredKecamatans() {
                    if (this.searchKecamatan === '') {
                        return this.kecamatans;
                    }
                    return this.kecamatans.filter(kc => kc.name.toLowerCase().includes(this.searchKecamatan
                    .toLowerCase()));
                },

                get filteredKelurahans() {
                    if (this.searchKelurahan === '') {
                        return this.kelurahans;
                    }
                    return this.kelurahans.filter(kl => kl.name.toLowerCase().includes(this.searchKelurahan
                    .toLowerCase()));
                },

                init() {
                    fetch('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json')
                        .then(response => response.json())
                        .then(data => {
                            this.provinsis = data;
                            if (this.selectedProvinsi) {
                                let prov = this.provinsis.find(p => p.name === this.selectedProvinsi);
                                if (prov) this.getKabupatenInit(prov.id);
                            }
                        });
                },

                getKabupaten() {
                    this.kabupatens = [];
                    this.kecamatans = [];
                    this.kelurahans = [];
                    this.selectedKota = '';
                    this.selectedKecamatan = '';
                    this.selectedKelurahan = '';
                    this.searchKota = '';
                    this.searchKecamatan = '';
                    this.searchKelurahan = '';

                    let prov = this.provinsis.find(p => p.name === this.selectedProvinsi);
                    if (prov) {
                        fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${prov.id}.json`)
                            .then(response => response.json())
                            .then(data => {
                                this.kabupatens = data;
                            });
                    }
                },

                getKabupatenInit(provId) {
                    fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${provId}.json`)
                        .then(response => response.json())
                        .then(data => {
                            this.kabupatens = data;
                            let kab = this.kabupatens.find(k => k.name === this.selectedKota);
                            if (kab) this.getKecamatanInit(kab.id);
                        });
                },

                getKecamatan() {
                    this.kecamatans = [];
                    this.kelurahans = [];
                    this.selectedKecamatan = '';
                    this.selectedKelurahan = '';
                    this.searchKecamatan = '';
                    this.searchKelurahan = '';

                    let kab = this.kabupatens.find(k => k.name === this.selectedKota);
                    if (kab) {
                        fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/districts/${kab.id}.json`)
                            .then(response => response.json())
                            .then(data => {
                                this.kecamatans = data;
                            });
                    }
                },

                getKecamatanInit(kabId) {
                    fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/districts/${kabId}.json`)
                        .then(response => response.json())
                        .then(data => {
                            this.kecamatans = data;
                            let kec = this.kecamatans.find(kc => kc.name === this.selectedKecamatan);
                            if (kec) this.getKelurahanInit(kec.id);
                        });
                },

                getKelurahan() {
                    this.kelurahans = [];
                    this.selectedKelurahan = '';
                    this.searchKelurahan = '';

                    let kec = this.kecamatans.find(kc => kc.name === this.selectedKecamatan);
                    if (kec) {
                        fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/villages/${kec.id}.json`)
                            .then(response => response.json())
                            .then(data => {
                                this.kelurahans = data;
                            });
                    }
                },

                getKelurahanInit(kecId) {
                    fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/villages/${kecId}.json`)
                        .then(response => response.json())
                        .then(data => {
                            this.kelurahans = data;
                        });
                }
            }
        }
    </script>
@endsection
