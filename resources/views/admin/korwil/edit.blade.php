@extends('layouts.admin')

@section('title', 'Edit Anggota Berlaku')
@section('page-subtitle', 'Perbarui data masa berlaku kartu anggota.')

@section('content')

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl lg:text-3xl font-bold text-slate-800 dark:text-slate-100">Edit Anggota Berlaku</h1>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Perbarui data masa berlaku kartu anggota.</p>
        </div>
    </div>

    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700/80">
        <div class="px-6 py-5 border-b border-slate-100 dark:border-slate-700">
            <h3 class="text-base font-semibold text-slate-800 dark:text-slate-100">Formulir Edit Anggota Berlaku</h3>
        </div>
        <div class="p-6">
            <form action="{{ route('admin.korwil.update', $korwil->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="space-y-5">
                    {{-- Anggota Card ID --}}
                    <div>
                        <label for="anggota_card_id"
                            class="block text-sm font-medium mb-1 text-slate-700 dark:text-slate-300">ID Kartu Anggota <span
                                class="text-red-500">*</span></label>
                        <input type="number" id="anggota_card_id" name="anggota_card_id"
                            value="{{ old('anggota_card_id', $korwil->anggota_card_id) }}"
                            class="w-full px-3 py-2 rounded-lg bg-slate-50 border border-slate-200 dark:bg-slate-700 dark:border-slate-600 text-sm focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 outline-none transition @error('anggota_card_id') border-red-500 @enderror"
                            required placeholder="Masukkan ID kartu anggota (angka)">
                        @error('anggota_card_id')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Jabatan --}}
                    <div>
                        <label for="jabatan"
                            class="block text-sm font-medium mb-1 text-slate-700 dark:text-slate-300">Jabatan</label>
                        <input type="text" id="jabatan" name="jabatan" value="{{ old('jabatan', $korwil->jabatan) }}"
                            class="w-full px-3 py-2 rounded-lg bg-slate-50 border border-slate-200 dark:bg-slate-700 dark:border-slate-600 text-sm focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 outline-none transition @error('jabatan') border-red-500 @enderror"
                            placeholder="Contoh: Koordinator Wilayah">
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
                            <option value="Aktif"
                                {{ old('status_kartu', $korwil->status_kartu) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="Tidak Aktif"
                                {{ old('status_kartu', $korwil->status_kartu) == 'Tidak Aktif' ? 'selected' : '' }}>Tidak
                                Aktif</option>
                            <option value="Expired"
                                {{ old('status_kartu', $korwil->status_kartu) == 'Expired' ? 'selected' : '' }}>Expired
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
                            <input type="date" id="diterbitkan" name="diterbitkan"
                                value="{{ old('diterbitkan', $korwil->diterbitkan ? $korwil->diterbitkan->format('Y-m-d') : '') }}"
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
                            <input type="date" id="berlaku" name="berlaku"
                                value="{{ old('berlaku', $korwil->berlaku ? $korwil->berlaku->format('Y-m-d') : '') }}"
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
                            placeholder="Catatan tambahan (opsional)">{{ old('keterangan', $korwil->keterangan) }}</textarea>
                        @error('keterangan')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 mt-6">
                    <a href="{{ route('admin.korwil.index') }}"
                        class="px-4 py-2 rounded-lg bg-slate-100 hover:bg-slate-200 dark:bg-slate-700 dark:hover:bg-slate-600 text-sm font-semibold text-slate-700 dark:text-slate-200 transition-all">Batal</a>
                    <button type="submit"
                        class="px-4 py-2 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-sm font-semibold text-white transition-all">Perbarui</button>
                </div>
            </form>
        </div>
    </div>

@endsection
