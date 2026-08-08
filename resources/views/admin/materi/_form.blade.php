{{-- Pelatihan ID --}}
<input type="hidden" name="pelatihan_id" value="{{ $materi->pelatihan_id ?? $pelatihan->id }}">

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    {{-- KOLOM KIRI: Detail Utama Materi --}}
    <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8 space-y-6">
        <div class="flex items-center gap-3 border-b border-gray-100 pb-4">
            <div class="p-2 bg-indigo-50 rounded-xl text-indigo-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                    </path>
                </svg>
            </div>
            <div>
                <h3 class="text-lg font-bold text-gray-800">Informasi Materi</h3>
                <p class="text-xs text-gray-400">Judul, deskripsi singkat, dan dokumen materi</p>
            </div>
        </div>

        {{-- Judul Materi --}}
        <div>
            <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2" for="judul">
                Judul Materi <span class="text-red-500">*</span>
            </label>
            <input
                class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 outline-none @error('judul') border-red-500 bg-red-50/50 @enderror"
                id="judul" name="judul" type="text" placeholder="Contoh: Modul 1 - Pengenalan Dasar"
                value="{{ old('judul', $materi->judul ?? '') }}" required>
            @error('judul')
                <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
            @enderror
        </div>

        {{-- Deskripsi Materi --}}
        <div>
            <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2" for="deskripsi">
                Deskripsi <span class="text-red-500">*</span>
            </label>
            <textarea
                class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 outline-none resize-none @error('deskripsi') border-red-500 bg-red-50/50 @enderror"
                id="deskripsi" name="deskripsi" rows="5" placeholder="Jelaskan secara singkat isi dari materi ini..." required>{{ old('deskripsi', $materi->deskripsi ?? '') }}</textarea>
            @error('deskripsi')
                <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
            @enderror
        </div>

        {{-- Upload File Modul/Dokumen --}}
        <div>
            <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2" for="file_materi">
                File Dokumen / Video Materi
            </label>
            <div class="relative flex items-center">
                <input type="file" id="file_materi" name="file" 
                    accept=".pdf,.doc,.docx,.ppt,.pptx,.zip,.rar,video/*"
                    class="w-full text-sm text-gray-500 border border-gray-200 rounded-xl bg-gray-50 cursor-pointer focus:outline-none file:mr-4 file:py-2.5 file:px-4 file:rounded-l-xl file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-600 hover:file:bg-indigo-100 transition duration-200">
            </div>
            @if(isset($materi) && $materi->file)
                @php
                    $fileExtension = pathinfo($materi->file, PATHINFO_EXTENSION);
                    $videoExtensions = ['mp4', 'mov', 'webm', 'ogv'];
                @endphp
                @if(in_array(strtolower($fileExtension), $videoExtensions))
                    <div class="mt-4">
                        <video src="{{ Storage::url($materi->file) }}" controls class="w-full rounded-lg shadow-md"></video>
                    </div>
                @else
                    <p class="text-xs text-indigo-600 mt-2 flex items-center gap-1 font-medium">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                        File saat ini: <a href="{{ Storage::url($materi->file) }}" target="_blank" class="underline hover:text-indigo-800">Unduh Dokumen</a>
                    </p>
                @endif
            @endif
            @error('file')
                <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
            @enderror
        </div>
    </div>

    {{-- KOLOM KANAN: Status & Gambar Sampul --}}
    <div class="space-y-6">
        {{-- Status Publikasi --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8 space-y-6">
            <div class="flex items-center gap-3 border-b border-gray-100 pb-4">
                <div class="p-2 bg-indigo-50 rounded-xl text-indigo-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z">
                        </path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-800">Status</h3>
                    <p class="text-xs text-gray-400">Pengaturan aksesibilitas materi</p>
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2" for="status">
                    Status Publikasi <span class="text-red-500">*</span>
                </label>
                <select
                    class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 outline-none cursor-pointer @error('status') border-red-500 bg-red-50/50 @enderror"
                    id="status" name="status" required>
                    @php
                        $statusOptions = ['published' => 'Published', 'draft' => 'Draft'];
                        $selectedStatus = old('status', $materi->status ?? 'published');
                    @endphp
                    @foreach ($statusOptions as $val => $label)
                        <option value="{{ $val }}" {{ $selectedStatus == $val ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
                @error('status')
                    <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Gambar Sampul Materi --}}
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
                    <h3 class="text-lg font-bold text-gray-800">Gambar Sampul</h3>
                    <p class="text-xs text-gray-400">Thumbnail modul (Opsional)</p>
                </div>
            </div>

            <div class="flex flex-col items-center">
                <div class="relative group w-full h-48 bg-gray-50 border-2 border-dashed border-gray-300 hover:border-indigo-500 rounded-2xl transition duration-200 flex flex-col items-center justify-center p-4 cursor-pointer overflow-hidden"
                    onclick="document.getElementById('gambar').click()">
                    <input id="gambar" name="gambar" type="file" class="hidden" accept="image/*"
                        onchange="previewGambar(this)">

                    <div id="placeholder-gambar"
                        class="flex flex-col items-center text-center {{ isset($materi) && $materi->gambar ? 'hidden' : '' }}">
                        <div class="p-3 bg-white rounded-full shadow-sm text-gray-400 group-hover:text-indigo-600 transition mb-2">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                        </div>
                        <span class="text-xs font-semibold text-gray-600 group-hover:text-indigo-600">Klik untuk Unggah Sampul</span>
                        <span class="text-[10px] text-gray-400 mt-1">Maks. 2MB (JPG, PNG, WEBP)</span>
                    </div>

                    <img id="preview-img-materi"
                        src="{{ isset($materi) && $materi->gambar ? Storage::url($materi->gambar) : '' }}"
                        class="{{ isset($materi) && $materi->gambar ? '' : 'hidden' }} w-full h-full object-cover absolute inset-0 rounded-2xl"
                        alt="Preview Gambar">

                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 flex items-center justify-center transition duration-200 text-white text-xs font-semibold rounded-2xl">
                        Ganti Gambar Sampul
                    </div>
                </div>
                @error('gambar')
                    <p class="text-red-500 text-xs mt-1.5 w-full">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>
</div>

<script>
    function previewGambar(input) {
        const img = document.getElementById('preview-img-materi');
        const placeholder = document.getElementById('placeholder-gambar');

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
</script>