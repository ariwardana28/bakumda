@csrf
@if (isset($pelatihan))
    @method('PUT')
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    {{-- KOLOM KIRI: Informasi Utama --}}
    <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8 space-y-6">
        <div class="flex items-center gap-3 border-b border-gray-100 pb-4">
            <div class="p-2 bg-indigo-50 rounded-xl text-indigo-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                    </path>
                </svg>
            </div>
            <div>
                <h3 class="text-lg font-bold text-gray-800">Informasi Utama Pelatihan</h3>
                <p class="text-xs text-gray-400">Judul, deskripsi, dan jadwal pelaksanaan</p>
            </div>
        </div>

        {{-- Judul Pelatihan --}}
        <div>
            <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2" for="judul">
                Judul Pelatihan <span class="text-red-500">*</span>
            </label>
            <input
                class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 outline-none @error('judul') border-red-500 bg-red-50/50 @enderror"
                id="judul" name="judul" type="text" placeholder="Masukkan judul pelatihan..."
                value="{{ old('judul', $pelatihan->judul ?? '') }}" required>
            @error('judul')
                <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
            @enderror
        </div>

        {{-- Tanggal Mulai & Selesai --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2"
                    for="tanggal_mulai">
                    Tanggal & Waktu Mulai <span class="text-red-500">*</span>
                </label>
                <input
                    class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 outline-none cursor-pointer @error('tanggal_mulai') border-red-500 bg-red-50/50 @enderror"
                    id="tanggal_mulai" name="tanggal_mulai" type="datetime-local"
                    value="{{ old('tanggal_mulai', isset($pelatihan) && $pelatihan->tanggal_mulai ? $pelatihan->tanggal_mulai->format('Y-m-d\TH:i') : '') }}"
                    required>
                @error('tanggal_mulai')
                    <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2"
                    for="tanggal_selesai">
                    Tanggal & Waktu Selesai <span class="text-red-500">*</span>
                </label>
                <input
                    class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 outline-none cursor-pointer @error('tanggal_selesai') border-red-500 bg-red-50/50 @enderror"
                    id="tanggal_selesai" name="tanggal_selesai" type="datetime-local"
                    value="{{ old('tanggal_selesai', isset($pelatihan) && $pelatihan->tanggal_selesai ? $pelatihan->tanggal_selesai->format('Y-m-d\TH:i') : '') }}"
                    required>
                @error('tanggal_selesai')
                    <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Deskripsi --}}
        <div>
            <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2" for="deskripsi">
                Deskripsi Lengkap <span class="text-red-500">*</span>
            </label>
            <textarea
                class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 outline-none resize-none @error('deskripsi') border-red-500 bg-red-50/50 @enderror"
                id="deskripsi" name="deskripsi" rows="5" placeholder="Tuliskan detail deskripsi pelatihan..." required>{{ old('deskripsi', $pelatihan->deskripsi ?? '') }}</textarea>
            @error('deskripsi')
                <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
            @enderror
        </div>

    </div>

    {{-- KOLOM KANAN: Atribut, Harga, & Banner --}}
    <div class="space-y-6">
        {{-- Pengaturan & Kuota --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8 space-y-6">
            <div class="flex items-center gap-3 border-b border-gray-100 pb-4">
                <div class="p-2 bg-indigo-50 rounded-xl text-indigo-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                        </path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-800">Biaya & Kapasitas</h3>
                    <p class="text-xs text-gray-400">Harga dan kuota peserta</p>
                </div>
            </div>

            {{-- Harga --}}
            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2" for="harga">
                    Harga (Rp) <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <span
                        class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-gray-400 text-sm font-semibold">Rp</span>
                    <input
                        class="w-full pl-11 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 outline-none @error('harga') border-red-500 bg-red-50/50 @enderror"
                        id="harga_formatted" type="text" placeholder="0"
                        value="{{ old('harga', isset($pelatihan->harga) ? number_format($pelatihan->harga, 0, ',', '.') : '0') }}" required>
                    
                    <input type="hidden" id="harga" name="harga" value="{{ old('harga', $pelatihan->harga ?? '0') }}">
                </div>
                @error('harga')
                    <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            {{-- Kuota --}}
            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2" for="kuota">
                    Kuota Peserta
                </label>
                <input
                    class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 outline-none @error('kuota') border-red-500 bg-red-50/50 @enderror"
                    id="kuota" name="kuota" type="number" placeholder="Contoh: 50"
                    value="{{ old('kuota', $pelatihan->kuota ?? '') }}" min="0">
                <p class="text-[11px] text-gray-400 mt-1">Kosongkan jika tidak ada batasan kuota.</p>
                @error('kuota')
                    <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            {{-- Status --}}
            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2" for="status">
                    Status Pelatihan <span class="text-red-500">*</span>
                </label>
                <select
                    class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 outline-none cursor-pointer @error('status') border-red-500 bg-red-50/50 @enderror"
                    id="status" name="status" required>
                    @php
                        $statuses = ['akan datang', 'berlangsung', 'selesai', 'dibatalkan'];
                        $selectedStatus = old('status', $pelatihan->status ?? 'akan datang');
                    @endphp
                    @foreach ($statuses as $st)
                        <option value="{{ $st }}" {{ $selectedStatus == $st ? 'selected' : '' }}>
                            {{ Str::title($st) }}</option>
                    @endforeach
                </select>
                @error('status')
                    <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Banner / Gambar --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8 space-y-6">
            <div class="flex items-center gap-3 border-b border-gray-100 pb-4">
                <div class="p-2 bg-indigo-50 rounded-xl text-indigo-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-800">Banner Pelatihan</h3>
                    <p class="text-xs text-gray-400">Gambar sampul kegiatan</p>
                </div>
            </div>

            <div class="flex flex-col items-center space-y-3">
                {{-- Informasi Ukuran Banner --}}
                <div class="w-full flex items-start gap-2 px-3.5 py-2.5 bg-amber-50/60 border border-amber-200/60 rounded-xl text-xs text-amber-800">
                    <svg class="w-4 h-4 text-amber-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Format: JPG/PNG, ukuran ideal: <strong>1200 x 675 piksel</strong> (Rasio 16:9), Maksimal 2MB.</span>
                </div>

                <div class="relative group w-full h-48 bg-gray-50 border-2 border-dashed border-gray-300 hover:border-indigo-500 rounded-2xl transition duration-200 flex flex-col items-center justify-center p-4 cursor-pointer overflow-hidden"
                    onclick="document.getElementById('gambar').click()">
                    <input id="gambar" name="gambar" type="file" class="hidden" accept="image/*"
                        onchange="previewBanner(this)">

                    <div id="placeholder-banner"
                        class="flex flex-col items-center text-center {{ isset($pelatihan) && $pelatihan->gambar ? 'hidden' : '' }}">
                        <div
                            class="p-3 bg-white rounded-full shadow-sm text-gray-400 group-hover:text-indigo-600 transition mb-2">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4"></path>
                            </svg>
                        </div>
                        <span class="text-xs font-semibold text-gray-600 group-hover:text-indigo-600">Klik untuk Unggah
                            Banner</span>
                        <span class="text-[10px] text-gray-400 mt-1">Format: JPG/PNG, Maks. 2MB</span>
                    </div>

                    <img id="preview-img"
                        src="{{ isset($pelatihan) && $pelatihan->gambar ? Storage::url($pelatihan->gambar) : '' }}"
                        class="{{ isset($pelatihan) && $pelatihan->gambar ? '' : 'hidden' }} w-full h-full object-cover absolute inset-0 rounded-2xl"
                        alt="Preview Banner">

                    <div
                        class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 flex items-center justify-center transition duration-200 text-white text-xs font-semibold rounded-2xl">
                        Ganti Gambar Banner
                    </div>
                </div>
                @error('gambar')
                    <p class="text-red-500 text-xs mt-1.5 w-full">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>
</div>

{{-- ACTION BUTTONS --}}
<div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-100">
    <a href="{{ route('admin.pelatihan.index') }}"
        class="px-6 py-3 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-600 font-semibold text-sm transition duration-200">
        Batal
    </a>
    <button type="submit"
        class="px-8 py-3 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-sm shadow-lg shadow-indigo-200 transition duration-200 flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
        </svg>
        Simpan Pelatihan
    </button>
</div>
</form>

<script>
    function previewBanner(input) {
        const img = document.getElementById('preview-img');
        const placeholder = document.getElementById('placeholder-banner');

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

    // Script otomatis format mata uang (Ribuan dengan titik) pada input harga
    document.addEventListener('DOMContentLoaded', function() {
        const hargaFormatted = document.getElementById('harga_formatted');
        const hargaInput = document.getElementById('harga');

        if (hargaFormatted) {
            hargaFormatted.addEventListener('input', function(e) {
                let value = this.value.replace(/[^0-9]/g, '');
                
                hargaInput.value = value;

                if (value) {
                    this.value = new Intl.NumberFormat('id-ID').format(value);
                } else {
                    this.value = '';
                }
            });
        }
    });
</script>