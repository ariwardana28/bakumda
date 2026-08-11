@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

        <!-- Header Informasi Form Utama -->
        <div class="mb-6 px-4 sm:px-0">
            <h3 class="text-base font-bold text-gray-900 dark:text-white">Edit Artikel</h3>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Perbarui detail judul, isi, dan informasi
                tambahan artikel Anda di bawah ini.</p>
        </div>

        <!-- Notifikasi Error Validasi -->
        @if ($errors->any())
            <div
                class="mb-6 p-4 rounded-xl bg-rose-50 dark:bg-rose-950/40 border border-rose-200 dark:border-rose-800 text-rose-600 dark:text-rose-400 text-xs font-medium space-y-1 shadow-xs">
                <div class="font-bold flex items-center gap-2">
                    <i class="fa-solid fa-triangle-exclamation text-sm"></i>
                    <span>{{ __('Whoops! Ada beberapa kesalahan pada input Anda.') }}</span>
                </div>
                <ul class="list-disc list-inside space-y-0.5 pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form Edit Artikel -->
        <form action="{{ route('user.artikel.update', $artikel->id) }}" method="POST" enctype="multipart/form-data"
            class="space-y-6">
            @csrf
            @method('PUT')

            <!-- CARD 1: Judul & Isi Artikel -->
            <div
                class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100 dark:border-gray-700 p-6 sm:p-8 relative space-y-6">
                <!-- Judul Artikel -->
                <div class="space-y-1.5">
                    <label for="judul"
                        class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                        {{ __('Judul Artikel') }}
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                            <i class="fa-solid fa-heading text-sm"></i>
                        </span>
                        <input id="judul" name="judul" type="text"
                            value="{{ old('judul', $artikel->judul) }}" required autofocus
                            class="w-full pl-11 pr-4 py-3 text-sm rounded-xl bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 focus:ring-2 focus:ring-indigo-500 focus:bg-white dark:focus:bg-gray-900 outline-none transition text-gray-900 dark:text-white font-medium @error('judul') border-rose-500 @enderror"
                            placeholder="Masukkan judul artikel yang menarik..." />
                    </div>
                    <x-input-error class="mt-1" :messages="$errors->get('judul')" />
                </div>

                <!-- Isi Artikel dengan TinyMCE -->
                <div class="space-y-1.5">
                    <label for="isi"
                        class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                        {{ __('Isi Artikel') }}
                    </label>
                    <textarea id="isi" name="isi" rows="12"
                        class="w-full p-4 text-sm rounded-xl bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white font-medium @error('isi') border-rose-500 @enderror"
                        placeholder="Tulis atau ketik isi artikel Anda di sini...">{{ old('isi', $artikel->isi) }}</textarea>
                    <x-input-error class="mt-1" :messages="$errors->get('isi')" />
                </div>
            </div>

            <!-- CARD 2: Status, Kategori, Tanggal, & Gambar -->
            <div
                class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100 dark:border-gray-700 p-6 sm:p-8 relative space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Kategori Artikel -->
                    <div class="space-y-1.5">
                        <label for="kategori_id"
                            class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('Kategori') }}
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                                <i class="fa-solid fa-tags text-sm"></i>
                            </span>
                            <select id="kategori_id" name="kategori_id" required
                                class="w-full pl-11 pr-4 py-3.5 text-sm rounded-xl bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 focus:ring-2 focus:ring-indigo-500 focus:bg-white dark:focus:bg-gray-900 outline-none transition text-gray-900 dark:text-white font-medium @error('kategori_id') border-rose-500 @enderror">
                                <option value="" disabled>Pilih Kategori</option>
                                @foreach ($kategoris as $kategori)
                                    <option value="{{ $kategori->id }}"
                                        {{ old('kategori_id', $artikel->kategori_id) == $kategori->id ? 'selected' : '' }}>
                                        {{ $kategori->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <x-input-error class="mt-1" :messages="$errors->get('kategori_id')" />
                    </div>

                    <!-- Tanggal Publikasi -->
                    <div class="space-y-1.5">
                        <label for="tanggal"
                            class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('Tanggal') }}
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                                <i class="fa-solid fa-calendar-day text-sm"></i>
                            </span>
                            <input id="tanggal" name="tanggal" type="date"
                                value="{{ old('tanggal', \Carbon\Carbon::parse($artikel->tanggal)->format('Y-m-d')) }}"
                                required
                                class="w-full pl-11 pr-4 py-3 text-sm rounded-xl bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 focus:ring-2 focus:ring-indigo-500 focus:bg-white dark:focus:bg-gray-900 outline-none transition text-gray-900 dark:text-white font-medium @error('tanggal') border-rose-500 @enderror" />
                        </div>
                        <x-input-error class="mt-1" :messages="$errors->get('tanggal')" />
                    </div>

                    <!-- Status Artikel -->
                    <div class="space-y-1.5">
                        <label for="status"
                            class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('Status Publikasi') }}
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                                <i class="fa-solid fa-signal text-sm"></i>
                            </span>
                            <select id="status" name="status"
                                class="w-full pl-11 pr-4 py-3.5 text-sm rounded-xl bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 focus:ring-2 focus:ring-indigo-500 focus:bg-white dark:focus:bg-gray-900 outline-none transition text-gray-900 dark:text-white font-medium @error('status') border-rose-500 @enderror">
                                <option value="published"
                                    {{ old('status', $artikel->status) == 'published' ? 'selected' : '' }}>
                                    Published (Publikasikan)</option>
                                <option value="draft" {{ old('status', $artikel->status) == 'draft' ? 'selected' : '' }}>
                                    Draft (Simpan Sementara)</option>
                            </select>
                        </div>
                        <x-input-error class="mt-1" :messages="$errors->get('status')" />
                    </div>
                </div>

                <!-- Gambar Unggulan -->
                <div class="space-y-1.5 pt-2">
                    <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                        {{ __('Gambar Unggulan') }}
                    </label>

                    <div class="w-full">
                        <div id="upload-wrapper"
                            class="flex flex-col items-center justify-center w-full h-40 border-2 border-gray-300 dark:border-gray-700 border-dashed rounded-xl cursor-pointer bg-gray-50 dark:bg-gray-900 hover:bg-gray-100 dark:hover:bg-gray-700/50 transition relative overflow-hidden"
                            role="button" tabindex="0">

                            <!-- Placeholder awal -->
                            <div id="upload-placeholder"
                                class="flex flex-col items-center justify-center pt-5 pb-6 px-4 text-center">
                                <i class="fa-solid fa-cloud-arrow-up text-xl text-gray-400 mb-2"></i>
                                <p class="text-xs text-gray-500 dark:text-gray-400 font-semibold">
                                    <span class="font-bold text-indigo-600 dark:text-indigo-400">Klik untuk
                                        unggah</span> atau seret file
                                </p>
                                <p class="text-[10px] text-gray-400 mt-0.5">PNG, JPG, atau WEBP (Kosongkan jika tidak ingin mengubah)</p>
                            </div>

                            <!-- Wadah Pratinjau Gambar (hidden by default) -->
                            <div id="preview-container"
                                class="hidden absolute inset-0 w-full h-full bg-gray-900 items-center justify-center z-20">
                                <img id="image-preview" src="" alt="Pratinjau Gambar"
                                    class="w-full h-full object-cover" />
                                <div
                                    class="absolute bottom-2 right-2 bg-black/60 text-white text-[10px] px-2 py-1 rounded-md backdrop-blur-xs">
                                    Ganti Gambar
                                </div>
                            </div>

                            <input id="gambar" name="gambar" type="file"
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10 image-input"
                                accept="image/*"
                                @if ($artikel->gambar) data-existing-url="{{ asset('storage/' . $artikel->gambar) }}" @endif />
                        </div>
                    </div>
                    <x-input-error class="mt-1" :messages="$errors->get('gambar')" />
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="flex items-center justify-end gap-3 pt-2">
                <a href="{{ route('user.artikel.index') }}"
                    class="px-5 py-2.5 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 text-xs font-bold uppercase tracking-wider hover:bg-gray-50 dark:hover:bg-gray-600 transition shadow-xs">
                    {{ __('Batal') }}
                </a>
                <button type="submit"
                    class="px-6 py-2.5 rounded-xl bg-gray-800 dark:bg-gray-200 text-white dark:text-gray-800 text-xs font-bold uppercase tracking-wider hover:bg-gray-700 dark:hover:bg-white transition flex items-center gap-2 shadow-sm">
                    <i class="fa-solid fa-floppy-disk text-xs"></i>
                    <span>{{ __('Simpan Perubahan') }}</span>
                </button>
            </div>
        </form>

    </div>

    <!-- Script Inisialisasi yang Aman untuk Desktop & Mobile -->
    @push('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.3/tinymce.min.js" referrerpolicy="no-referrer"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                // Inisialisasi Pratinjau Gambar Aman (lebih robust untuk desktop & mobile)
                (function() {
                    const fileInput = document.getElementById('gambar');
                    const previewContainer = document.getElementById('preview-container');
                    const previewImageEl = document.getElementById('image-preview');
                    const placeholder = document.getElementById('upload-placeholder');

                    if (!fileInput) return;

                    const showPreview = (url) => {
                        if (url && previewImageEl && previewContainer && placeholder) {
                            previewImageEl.src = url;
                            previewImageEl.style.width = '100%';
                            previewImageEl.style.height = '100%';
                            previewImageEl.style.objectFit = 'cover';

                            previewContainer.style.display = 'flex';
                            previewContainer.style.zIndex = '30';
                            previewContainer.style.position = 'absolute';
                            placeholder.style.display = 'none';
                        }
                    };

                    fileInput.addEventListener('change', function(event) {
                        const file = event.target.files && event.target.files[0];
                        if (!file) {
                            // Jika tidak ada file dipilih, coba tampilkan gambar lama jika ada
                            if (fileInput.dataset.existingUrl) {
                                showPreview(fileInput.dataset.existingUrl);
                            } else if (previewContainer && placeholder) {
                                previewContainer.style.display = 'none';
                                placeholder.style.display = 'flex';
                            }
                            return;
                        }

                        const objectUrl = URL.createObjectURL(file);
                        showPreview(objectUrl);

                        previewImageEl.onload = () => {
                            try {
                                URL.revokeObjectURL(objectUrl);
                            } catch (e) {}
                        };
                    });

                    // Tampilkan gambar yang sudah ada saat halaman dimuat
                    if (fileInput.dataset.existingUrl) {
                        showPreview(fileInput.dataset.existingUrl);
                    }
                })();

                // Inisialisasi TinyMCE
                const isDarkMode = document.documentElement.classList.contains('dark') || localStorage.getItem(
                    'theme') === 'dark';

                if (typeof tinymce !== 'undefined') {
                    tinymce.init({
                        selector: '#isi',
                        height: 400,
                        menubar: false,
                        plugins: 'advlist autolink lists link image charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table help wordcount',
                        toolbar: 'undo redo | formatselect | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
                        skin: isDarkMode ? 'oxide-dark' : 'oxide',
                        content_css: isDarkMode ? 'dark' : 'default',
                        setup: function(editor) {
                            editor.on('change', function() {
                                editor.save();
                            });
                        }
                    });
                }
            });
        </script>
    @endpush
@endsection