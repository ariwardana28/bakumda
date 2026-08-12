@csrf
<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100 dark:border-gray-700 p-6 sm:p-8 space-y-6">
    <!-- Nama Jenis Surat -->
    <div class="space-y-1.5">
        <label for="nama" class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
            {{ __('Nama Jenis Surat') }}
        </label>
        <div class="relative">
            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                <i class="fa-solid fa-tag text-sm"></i>
            </span>
            <input id="nama" name="nama" type="text"
                value="{{ old('nama', $suratJeni->nama ?? '') }}" required autofocus
                class="w-full pl-11 pr-4 py-3 text-sm rounded-xl bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 focus:ring-2 focus:ring-indigo-500 focus:bg-white dark:focus:bg-gray-900 outline-none transition text-gray-900 dark:text-white font-medium @error('nama') border-rose-500 @enderror"
                placeholder="Contoh: Surat Permohonan Bantuan Hukum" />
        </div>
        @error('nama')
            <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Deskripsi -->
    <div class="space-y-1.5">
        <label for="deskripsi" class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
            {{ __('Deskripsi') }}
        </label>
        <textarea id="deskripsi" name="deskripsi" rows="4"
            class="w-full p-4 text-sm rounded-xl bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white font-medium @error('deskripsi') border-rose-500 @enderror"
            placeholder="Jelaskan secara singkat kegunaan dari jenis surat ini...">{{ old('deskripsi', $suratJeni->deskripsi ?? '') }}</textarea>
        @error('deskripsi')
            <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
        @enderror
    </div>
</div>

<!-- Tombol Aksi -->
<div class="flex items-center justify-end gap-3 pt-2">
    <a href="{{ route('admin.surat-jenis.index') }}"
        class="px-5 py-2.5 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 text-xs font-bold uppercase tracking-wider hover:bg-gray-50 dark:hover:bg-gray-600 transition shadow-xs">
        {{ __('Batal') }}
    </a>
    <button type="submit"
        class="px-6 py-2.5 rounded-xl bg-gray-800 dark:bg-gray-200 text-white dark:text-gray-800 text-xs font-bold uppercase tracking-wider hover:bg-gray-700 dark:hover:bg-white transition flex items-center gap-2 shadow-sm">
        <i class="fa-solid fa-floppy-disk text-xs"></i>
        <span>{{ isset($suratJeni) ? __('Simpan Perubahan') : __('Simpan') }}</span>
    </button>
</div>