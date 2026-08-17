@extends('layouts.admin')

@push('styles')
    {{-- Tom Select untuk searchable dropdown --}}
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
@endpush

@section('title', 'Tambah Anggota Berlaku Baru')
@section('page-subtitle', 'Buat data masa berlaku kartu anggota baru.')

@section('content')

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl lg:text-3xl font-bold text-slate-800 dark:text-slate-100">Tambah Anggota Berlaku Baru</h1>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Buat data masa berlaku kartu anggota baru.</p>
        </div>
    </div>

    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700/80">
        <div class="px-6 py-5 border-b border-slate-100 dark:border-slate-700">
            <h3 class="text-base font-semibold text-slate-800 dark:text-slate-100">Formulir Tambah Anggota Berlaku</h3>
        </div>
        <div class="p-6">
            <form action="{{ route('admin.korwil.store') }}" method="POST">
                @csrf
                <div class="space-y-5">
                    {{-- Anggota Card ID --}}
                    <div>
                        <label for="select-anggota"
                            class="block text-sm font-medium mb-1 text-slate-700 dark:text-slate-300">Anggota <span
                                class="text-red-500">*</span></label>
                        <select id="select-anggota" name="anggota_card_id" required
                            placeholder="Cari nama atau nomor kartu anggota...">
                            <option value="">Cari nama atau nomor kartu anggota...</option>
                            @isset($anggotaCards)
                                @foreach ($anggotaCards as $card)
                                    <option value="{{ $card->id }}"
                                        {{ old('anggota_card_id') == $card->id ? 'selected' : '' }}>
                                        {{ $card->anggota->nama }} ({{ $card->card_id }})
                                    </option>
                                @endforeach
                            @endisset
                        </select>
                        @error('anggota_card_id')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Jabatan --}}
                    <div>
                        <label for="provinsi"
                            class="block text-sm font-medium mb-1 text-slate-700 dark:text-slate-300">Jabatan</label>
                        <div class="flex items-stretch">
                            <span
                                class="inline-flex items-center px-3 py-2 bg-slate-100 dark:bg-slate-700 border border-r-0 border-slate-200 dark:border-slate-600 rounded-l-lg text-sm font-medium text-slate-600 dark:text-slate-300 whitespace-nowrap">
                                KORWIL -
                            </span>
                            <select id="provinsi"
                                class="w-full px-3 py-2 rounded-r-lg bg-slate-50 border border-slate-200 dark:bg-slate-700 dark:border-slate-600 text-sm focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 outline-none transition @error('jabatan') border-red-500 @enderror">
                                <option value="">-- Pilih Provinsi --</option>
                                @isset($provinces)
                                    @foreach ($provinces as $province)
                                        <option value="{{ $province }}">{{ $province }}</option>
                                    @endforeach
                                @endisset
                            </select>
                        </div>
                        {{-- Hidden input untuk menyimpan nilai gabungan --}}
                        <input type="hidden" name="jabatan" id="jabatan_hidden" value="{{ old('jabatan') }}">
                        @error('jabatan')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Status Kartu --}}
                    <div>
                        <label for="status_kartu"
                            class="block text-sm font-medium mb-1 text-slate-700 dark:text-slate-300">Status Kartu <span
                                class="text-red-500">*</span></label>
                        <select id="status_kartu" name="status_kartu"
                            class="w-full px-3 py-2 rounded-lg bg-slate-50 border border-slate-200 dark:bg-slate-700 dark:border-slate-600 text-sm focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 outline-none transition @error('status_kartu') border-red-500 @enderror"
                            required>
                            <option value="">-- Pilih Status Kartu --</option>
                            <option value="Aktif" {{ old('status_kartu') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="Tidak Aktif" {{ old('status_kartu') == 'Tidak Aktif' ? 'selected' : '' }}>Tidak
                                Aktif</option>
                            <option value="Expired" {{ old('status_kartu') == 'Expired' ? 'selected' : '' }}>Expired
                            </option>
                        </select>
                        @error('status_kartu')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        {{-- Diterbitkan --}}
                        <div>
                            <label for="diterbitkan"
                                class="block text-sm font-medium mb-1 text-slate-700 dark:text-slate-300">Tanggal
                                Diterbitkan <span class="text-red-500">*</span></label>
                            <input type="date" id="diterbitkan" name="diterbitkan" value="{{ old('diterbitkan') }}"
                                class="w-full px-3 py-2 rounded-lg bg-slate-50 border border-slate-200 dark:bg-slate-700 dark:border-slate-600 text-sm focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 outline-none transition @error('diterbitkan') border-red-500 @enderror"
                                required>
                            @error('diterbitkan')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Berlaku --}}
                        <div>
                            <label for="berlaku"
                                class="block text-sm font-medium mb-1 text-slate-700 dark:text-slate-300">Tanggal Berlaku
                                (Expired) <span class="text-red-500">*</span></label>
                            <input type="date" id="berlaku" name="berlaku" value="{{ old('berlaku') }}"
                                class="w-full px-3 py-2 rounded-lg bg-slate-50 border border-slate-200 dark:bg-slate-700 dark:border-slate-600 text-sm focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 outline-none transition @error('berlaku') border-red-500 @enderror"
                                required>
                            @error('berlaku')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Keterangan --}}
                    <div>
                        <label for="keterangan"
                            class="block text-sm font-medium mb-1 text-slate-700 dark:text-slate-300">Keterangan</label>
                        <textarea id="keterangan" name="keterangan" rows="3"
                            class="w-full px-3 py-2 rounded-lg bg-slate-50 border border-slate-200 dark:bg-slate-700 dark:border-slate-600 text-sm focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 outline-none transition @error('keterangan') border-red-500 @enderror"
                            placeholder="Catatan tambahan (opsional)">{{ old('keterangan') }}</textarea>
                        @error('keterangan')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 mt-6">
                    <a href="{{ route('admin.korwil.index') }}"
                        class="px-4 py-2 rounded-lg bg-slate-100 hover:bg-slate-200 dark:bg-slate-700 dark:hover:bg-slate-600 text-sm font-semibold text-slate-700 dark:text-slate-200 transition-all">Batal</a>
                    <button type="submit"
                        class="px-4 py-2 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-sm font-semibold text-white transition-all">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    {{-- Tom Select JS --}}
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const provinceSelect = document.getElementById('provinsi');
            const jabatanHiddenInput = document.getElementById('jabatan_hidden');
            const statusKartuSelect = document.getElementById('status_kartu');
            const diterbitkanInput = document.getElementById('diterbitkan');
            const berlakuInput = document.getElementById('berlaku');

            // Inisialisasi TomSelect untuk dropdown anggota
            const tomSelectAnggota = new TomSelect("#select-anggota", {
                create: false,
                onChange: function (value) {
                    // Jika ada anggota yang dipilih
                    if (value) {
                        // Panggil API untuk mendapatkan data terakhir
                        fetch(`/admin/korwil/get-latest-data/${value}`)
                            .then(response => response.json())
                            .then(result => {
                                if (result.data) {
                                    // Isi status kartu
                                    statusKartuSelect.value = result.data.status_kartu || '';

                                    // Cek dan format tanggal diterbitkan
                                    if (result.data.diterbitkan) {
                                        // Ambil hanya bagian tanggal (YYYY-MM-DD) dari string timestamp
                                        diterbitkanInput.value = result.data.diterbitkan.split('T')[0];
                                    }

                                    // Cek dan format tanggal berlaku
                                    if (result.data.berlaku) {
                                        berlakuInput.value = result.data.berlaku.split('T')[0];
                                    }
                                } else {
                                    // Kosongkan form jika tidak ada data
                                    statusKartuSelect.value = '';
                                    diterbitkanInput.value = '';
                                    berlakuInput.value = '';
                                }
                            });
                    }
                }
            });

            function updateJabatan() {
                const selectedProvince = provinceSelect.value;
                if (selectedProvince) {
                    jabatanHiddenInput.value = 'KORWIL - ' + selectedProvince;
                } else {
                    jabatanHiddenInput.value = '';
                }
            }

            provinceSelect.addEventListener('change', updateJabatan);
            updateJabatan();
        });
    </script>
@endpush
