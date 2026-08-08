@extends('layouts.admin')

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
            }

            .ts-dropdown .dropdown-input {
                border-radius: 0.5rem !important;
                padding: 0.5rem 0.75rem !important;
                margin: 8px !important;
                width: calc(100% - 16px) !important;
                border: 1px solid rgb(229 231 235) !important;
            }
        </style>
    @endpush

    <div class="container mx-auto">
        {{-- Tombol Kembali --}}
        <div class="mb-6">
            <a href="{{ route('user-pelatihan.index') }}"
                class="inline-flex items-center gap-2 text-sm font-semibold text-gray-600 hover:text-blue-600 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Daftar Pelatihan
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Sisi Kiri: Ringkasan Program --}}
            <div class="lg:col-span-1 space-y-6">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-6">
                    <h3 class="text-base font-bold text-gray-900 mb-4 pb-3 border-b border-gray-100">Ringkasan Program</h3>

                    <div class="relative h-36 w-full bg-slate-100 rounded-xl overflow-hidden mb-4">
                        @if ($pelatihan->gambar)
                            <img src="{{ asset('storage/' . $pelatihan->gambar) }}" alt="{{ $pelatihan->judul }}"
                                class="w-full h-full object-cover">
                        @else
                            <div class="flex items-center justify-center h-full text-gray-400 bg-gray-50 text-xs">Tidak ada
                                gambar</div>
                        @endif
                    </div>

                    <h4 class="font-bold text-gray-900 text-base mb-2 leading-snug">{{ $pelatihan->judul }}</h4>

                    <div class="space-y-3 pt-3 border-t border-gray-100 text-xs text-gray-600">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-500">Jadwal:</span>
                            <span class="font-semibold text-gray-800 text-right">
                                {{ \Carbon\Carbon::parse($pelatihan->tanggal_mulai)->format('d M Y') }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-500">Biaya Investasi:</span>
                            <span class="font-bold {{ $pelatihan->harga == 0 ? 'text-emerald-600' : 'text-blue-600' }}">
                                {{ $pelatihan->harga == 0 ? 'Gratis' : 'Rp ' . number_format($pelatihan->harga, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>

                    <div
                        class="mt-6 p-4 rounded-xl bg-blue-50/50 border border-blue-100 text-xs text-blue-800 leading-relaxed">
                        <span class="font-bold block mb-1">Catatan Penting:</span>
                        Pastikan seluruh dokumen (KTP, Foto, Pakta Integritas) diunggah dengan format yang benar dan data
                        diri sesuai identitas resmi.
                    </div>
                </div>
            </div>

            {{-- Sisi Kanan: Form Pendaftaran Lengkap --}}
            <div class="lg:col-span-2">
                <div class="bg-white rounded-3xl shadow-xl border border-gray-100 p-6 md:p-8">
                    <div class="mb-8">
                        <div
                            class="inline-flex items-center gap-2 mb-2 px-3 py-1 bg-blue-50 text-blue-600 rounded-full text-xs font-bold uppercase tracking-wider">
                            Formulir Registrasi Lengkap
                        </div>
                        <h1 class="text-2xl font-extrabold text-gray-900 tracking-tight">Data Diri Peserta Pelatihan</h1>
                        <p class="text-sm text-gray-500 mt-1">Lengkapi data pribadi dan berkas persyaratan di bawah ini.</p>
                    </div>

                    @if ($errors->any())
                        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-2xl text-red-700 text-xs space-y-1">
                            <span class="font-bold block text-sm mb-1">Terjadi Kesalahan Pengisian:</span>
                            <ul class="list-disc pl-4 space-y-0.5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('user-pelatihan.store', $pelatihan->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf

                        {{-- 1. Nama Lengkap & No KTP --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-2">Nama
                                    Lengkap (Beserta Gelar)</label>
                                <input type="text" name="nama" value="{{ old('nama', Auth::user()->name) }}" required
                                    placeholder="Contoh: Dr. Ahmad Fauzi, S.H., M.H."
                                    class="w-full px-4 py-3 text-sm rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-2">Nomor KTP
                                    (NIK)</label>
                                <input type="text" name="no_ktp" value="{{ old('no_ktp') }}" required
                                    placeholder="16 digit nomor KTP" maxlength="16"
                                    class="w-full px-4 py-3 text-sm rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>

                        {{-- 2. Tempat & Tanggal Lahir --}}
                        <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-2">Tempat
                                    Lahir</label>
                                <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}" required
                                    placeholder="Contoh: Makassar"
                                    class="w-full px-4 py-3 text-sm rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-2">Tanggal
                                    Lahir</label>
                                <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required
                                    class="w-full px-4 py-3 text-sm rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>

                        {{-- 3. Jenis Kelamin & Agama --}}
                        <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-2">Jenis
                                    Kelamin</label>
                                <select name="jenis_kelamin" required
                                    class="w-full px-4 py-3 text-sm rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                                    <option value="">-- Pilih Jenis Kelamin --</option>
                                    <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>
                                        Laki-laki</option>
                                    <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>
                                        Perempuan</option>
                                </select>
                            </div>
                            <div>
                                <label
                                    class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-2">Agama</label>
                                <select name="agama" required
                                    class="w-full px-4 py-3 text-sm rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                                    <option value="">-- Pilih Agama --</option>
                                    <option value="Islam" {{ old('agama') == 'Islam' ? 'selected' : '' }}>Islam</option>
                                    <option value="Kristen" {{ old('agama') == 'Kristen' ? 'selected' : '' }}>Kristen
                                    </option>
                                    <option value="Katolik" {{ old('agama') == 'Katolik' ? 'selected' : '' }}>Katolik
                                    </option>
                                    <option value="Hindu" {{ old('agama') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                    <option value="Buddha" {{ old('agama') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                                    <option value="Konghucu" {{ old('agama') == 'Konghucu' ? 'selected' : '' }}>Konghucu
                                    </option>
                                </select>
                            </div>
                        </div>

                        {{-- 4. Status Perkawinan & Kewarganegaraan --}}
                        <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-2">Status
                                    Perkawinan</label>
                                <select name="status_perkawinan" required
                                    class="w-full px-4 py-3 text-sm rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                                    <option value="">-- Pilih Status --</option>
                                    <option value="Belum Menikah"
                                        {{ old('status_perkawinan') == 'Belum Menikah' ? 'selected' : '' }}>Belum Menikah
                                    </option>
                                    <option value="Menikah" {{ old('status_perkawinan') == 'Menikah' ? 'selected' : '' }}>
                                        Menikah</option>
                                    <option value="Cerai" {{ old('status_perkawinan') == 'Cerai' ? 'selected' : '' }}>
                                        Cerai</option>
                                </select>
                            </div>
                            <div>
                                <label
                                    class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-2">Kewarganegaraan</label>
                                <input type="text" name="kewarganegaraan" value="{{ old('kewarganegaraan', 'WNI') }}"
                                    required
                                    class="w-full px-4 py-3 text-sm rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>

                        {{-- 5. Pekerjaan --}}
                        <div class="mt-6">
                            <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-2">Pekerjaan /
                                Profesi</label>
                            <input type="text" name="pekerjaan" value="{{ old('pekerjaan') }}" required
                                placeholder="Contoh: Advokat / Pegawai Swasta / Mahasiswa"
                                class="w-full px-4 py-3 text-sm rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        {{-- 6. Kontak (No HP & Email) --}}
                        <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-2">Nomor HP
                                    / WhatsApp</label>
                                <input type="text" name="no_hp" value="{{ old('no_hp') }}" required
                                    placeholder="08xxxxxxxxxx"
                                    class="w-full px-4 py-3 text-sm rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-2">Alamat
                                    Email Aktif</label>
                                <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}" required
                                    placeholder="nama@domain.com"
                                    class="w-full px-4 py-3 text-sm rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>

                        {{-- 7. Alamat Domisili (Dropdown Wilayah dengan Fitur Pencarian) --}}
                        <div class="mt-6 space-y-4 p-5 rounded-2xl bg-gray-50 border border-gray-200">
                            <span class="font-bold text-gray-900 text-sm block">Informasi Alamat Domisili</span>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                {{-- Provinsi --}}
                                <div>
                                    <label for="provinsi"
                                        class="block text-sm font-medium text-gray-700 mb-2">Provinsi</label>
                                    <select id="provinsi" name="provinsi" autocomplete="off"
                                        placeholder="Pilih Provinsi...">
                                        <option value="">-- Pilih Provinsi --</option>
                                    </select>
                                </div>

                                {{-- Kota/Kabupaten --}}
                                <div>
                                    <label for="kota"
                                        class="block text-sm font-medium text-gray-700 mb-2">Kota/Kabupaten</label>
                                    <select id="kota" name="kota" autocomplete="off"
                                        placeholder="Pilih Kota/Kabupaten...">
                                        <option value="">-- Pilih Kota/Kabupaten --</option>
                                    </select>
                                </div>

                                {{-- Kecamatan --}}
                                <div>
                                    <label for="kecamatan"
                                        class="block text-sm font-medium text-gray-700 mb-2">Kecamatan</label>
                                    <select id="kecamatan" name="kecamatan" autocomplete="off"
                                        placeholder="Pilih Kecamatan...">
                                        <option value="">-- Pilih Kecamatan --</option>
                                    </select>
                                </div>

                                {{-- Kelurahan/Desa --}}
                                <div>
                                    <label for="kelurahan"
                                        class="block text-sm font-medium text-gray-700 mb-2">Kelurahan/Desa</label>
                                    <select id="kelurahan" name="kelurahan" autocomplete="off"
                                        placeholder="Pilih Kelurahan/Desa...">
                                        <option value="">-- Pilih Kelurahan/Desa --</option>
                                    </select>
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-2">Alamat
                                    Lengkap (Jalan, No. Rumah, RT/RW)</label>
                                <textarea name="alamat" rows="2" required placeholder="Nama jalan, nomor rumah, RT/RW..."
                                    class="w-full px-4 py-3 text-sm rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">{{ old('alamat') }}</textarea>
                            </div>
                        </div>

                        {{-- 8. Berkas Unggahan (Card Terpisah) --}}
                        <div class="mt-6 space-y-4">
                            <span class="font-bold text-gray-900 text-sm block">Unggah Berkas Persyaratan</span>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                {{-- Card 1: Upload KTP --}}
                                <div
                                    class="p-4 rounded-2xl bg-blue-50/40 border border-blue-100 flex flex-col justify-between">
                                    <div>
                                        <label
                                            class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-2">Foto
                                            / Scan KTP</label>
                                        <p class="text-[11px] text-gray-500 mb-3">Format: JPG, PNG, atau PDF.</p>
                                        <input type="file" name="foto_ktp" id="foto_ktp" accept="image/*,.pdf"
                                            class="w-full text-xs text-gray-500 file:mr-2 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-[11px] file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-700 cursor-pointer border border-gray-200 rounded-xl bg-white p-1">
                                    </div>
                                    <div class="mt-3">
                                        <img id="preview_ktp" src="#" alt="Pratinjau KTP"
                                            class="hidden w-full h-28 object-cover rounded-lg border border-gray-200 shadow-sm">
                                    </div>
                                </div>

                                {{-- Card 2: Upload Pas Foto --}}
                                <div
                                    class="p-4 rounded-2xl bg-blue-50/40 border border-blue-100 flex flex-col justify-between">
                                    <div>
                                        <label
                                            class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-2">Pas
                                            Foto Resmi</label>
                                        <p class="text-[11px] text-gray-500 mb-3">Latar Belakang Merah/Biru.</p>
                                        <input type="file" name="foto" id="foto" accept="image/*"
                                            class="w-full text-xs text-gray-500 file:mr-2 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-[11px] file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-700 cursor-pointer border border-gray-200 rounded-xl bg-white p-1">
                                    </div>
                                    <div class="mt-3 flex justify-center">
                                        <img id="preview_foto" src="#" alt="Pratinjau Pas Foto"
                                            class="hidden w-20 h-28 object-cover rounded-lg border border-gray-200 shadow-sm">
                                    </div>
                                </div>

                                {{-- Card 3: Upload Pakta Integritas --}}
                                <div
                                    class="p-4 rounded-2xl bg-blue-50/40 border border-blue-100 flex flex-col justify-between">
                                    <div>
                                        <label
                                            class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-2">Pakta
                                            Integritas</label>
                                        <p class="text-[11px] text-gray-500 mb-3">Dokumen Pendukung (Opsional).</p>
                                        <input type="file" name="pakta_integritas" id="pakta_integritas"
                                            accept="image/*,.pdf"
                                            class="w-full text-xs text-gray-500 file:mr-2 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-[11px] file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-700 cursor-pointer border border-gray-200 rounded-xl bg-white p-1">
                                    </div>
                                    <div class="mt-3">
                                        <img id="preview_pakta" src="#" alt="Pratinjau Dokumen"
                                            class="hidden w-full h-28 object-cover rounded-lg border border-gray-200 shadow-sm">
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Tombol Aksi --}}
                        <div class="mt-8 flex items-center justify-end gap-4 pt-4 border-t border-gray-100">
                            <a href="{{ route('user-pelatihan.index') }}"
                                class="px-6 py-3 rounded-xl border border-gray-200 text-sm font-semibold text-gray-600 hover:bg-gray-50 transition-colors">
                                Batal
                            </a>
                            <button type="submit"
                                class="px-8 py-3 rounded-xl bg-blue-600 text-white text-sm font-semibold shadow-lg shadow-blue-500/30 hover:bg-blue-700 transition-all">
                                Kirim Pendaftaran
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        {{-- TomSelect JS --}}
        <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
        <script>
            // 1. Script Image Preview untuk masing-masing input
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

            // 2. Inisialisasi TomSelect dengan plugin 'dropdown_input'
            let provinceSelectInstance, regencySelectInstance, districtSelectInstance, villageSelectInstance;

            function initTomSelects() {
                const commonConfig = {
                    create: false,
                    sortField: {
                        field: "text",
                        direction: "asc"
                    },
                    plugins: ['dropdown_input']
                };

                provinceSelectInstance = new TomSelect("#provinsi", commonConfig);
                regencySelectInstance = new TomSelect("#kota", commonConfig);
                districtSelectInstance = new TomSelect("#kecamatan", commonConfig);
                villageSelectInstance = new TomSelect("#kelurahan", commonConfig);
            }

            // 3. Dependent Dropdown Wilayah & Event Listener
            document.addEventListener("DOMContentLoaded", function() {
                // Setup preview untuk ketiga input berkas
                setupImagePreview('foto_ktp', 'preview_ktp');
                setupImagePreview('foto', 'preview_foto');
                setupImagePreview('pakta_integritas', 'preview_pakta');

                initTomSelects();

                const provinceSelect = document.getElementById('provinsi');
                const regencySelect = document.getElementById('kota');
                const districtSelect = document.getElementById('kecamatan');
                const villageSelect = document.getElementById('kelurahan');

                // Ambil Data Provinsi
                fetch('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json')
                    .then(response => response.json())
                    .then(provinces => {
                        provinceSelectInstance.clearOptions();
                        provinceSelectInstance.addOption({
                            value: "",
                            text: "-- Pilih Provinsi --"
                        });
                        provinces.forEach(province => {
                            provinceSelectInstance.addOption({
                                value: province.name,
                                text: province.name,
                                data_id: province.id
                            });
                        });
                        provinceSelectInstance.setValue("");
                    });

                // Event Provinsi Dipilih -> Load Kota/Kabupaten
                provinceSelect.addEventListener('change', function() {
                    const selectedValue = this.value;
                    let provinceId = "";
                    let options = provinceSelectInstance.options;
                    for (let key in options) {
                        if (options[key].value === selectedValue) {
                            provinceId = options[key].data_id;
                            break;
                        }
                    }

                    regencySelectInstance.clearOptions();
                    regencySelectInstance.addOption({
                        value: "",
                        text: "-- Pilih Kota/Kabupaten --"
                    });
                    regencySelectInstance.setValue("");

                    districtSelectInstance.clearOptions();
                    districtSelectInstance.addOption({
                        value: "",
                        text: "-- Pilih Kecamatan --"
                    });
                    districtSelectInstance.setValue("");

                    villageSelectInstance.clearOptions();
                    villageSelectInstance.addOption({
                        value: "",
                        text: "-- Pilih Kelurahan/Desa --"
                    });
                    villageSelectInstance.setValue("");

                    if (provinceId) {
                        fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${provinceId}.json`)
                            .then(response => response.json())
                            .then(regencies => {
                                regencies.forEach(regency => {
                                    regencySelectInstance.addOption({
                                        value: regency.name,
                                        text: regency.name,
                                        data_id: regency.id
                                    });
                                });
                            });
                    }
                });

                // Event Kota/Kabupaten Dipilih -> Load Kecamatan
                regencySelect.addEventListener('change', function() {
                    const selectedValue = this.value;
                    let regencyId = "";
                    let options = regencySelectInstance.options;
                    for (let key in options) {
                        if (options[key].value === selectedValue) {
                            regencyId = options[key].data_id;
                            break;
                        }
                    }

                    districtSelectInstance.clearOptions();
                    districtSelectInstance.addOption({
                        value: "",
                        text: "-- Pilih Kecamatan --"
                    });
                    districtSelectInstance.setValue("");

                    villageSelectInstance.clearOptions();
                    villageSelectInstance.addOption({
                        value: "",
                        text: "-- Pilih Kelurahan/Desa --"
                    });
                    villageSelectInstance.setValue("");

                    if (regencyId) {
                        fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/districts/${regencyId}.json`)
                            .then(response => response.json())
                            .then(districts => {
                                districts.forEach(district => {
                                    districtSelectInstance.addOption({
                                        value: district.name,
                                        text: district.name,
                                        data_id: district.id
                                    });
                                });
                            });
                    }
                });

                // Event Kecamatan Dipilih -> Load Kelurahan/Desa
                districtSelect.addEventListener('change', function() {
                    const selectedValue = this.value;
                    let districtId = "";
                    let options = districtSelectInstance.options;
                    for (let key in options) {
                        if (options[key].value === selectedValue) {
                            districtId = options[key].data_id;
                            break;
                        }
                    }

                    villageSelectInstance.clearOptions();
                    villageSelectInstance.addOption({
                        value: "",
                        text: "-- Pilih Kelurahan/Desa --"
                    });
                    villageSelectInstance.setValue("");

                    if (districtId) {
                        fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/villages/${districtId}.json`)
                            .then(response => response.json())
                            .then(villages => {
                                villages.forEach(village => {
                                    villageSelectInstance.addOption({
                                        value: village.name,
                                        text: village.name,
                                        data_id: village.id
                                    });
                                });
                            });
                    }
                });
            });
        </script>
    @endpush
@endsection
