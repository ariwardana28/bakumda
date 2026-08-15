@extends('layouts.admin')

@section('title', 'Tambah Produk Baru')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="produkForm()">
        {{-- Header Section --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8 gap-4">
            <div>
                <h2 class="text-3xl font-bold text-gray-850 tracking-tight">Tambah Produk Baru</h2>
                <p class="text-sm text-gray-500 mt-1">Buat dan tambahkan produk baru ke dalam sistem.</p>
            </div>
            <a href="{{ route('admin.produk.index') }}"
                class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold text-sm transition duration-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                    </path>
                </svg>
                Kembali ke Daftar
            </a>
        </div>

        <form action="{{ route('admin.produk.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Layout Grid Utama: Kiri (Galeri Foto), Kanan (Form Utama & Varian) --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">

                {{-- KOLOM KIRI (1 Span): Card Galeri Foto Produk (Multiple Insert & Live Preview) --}}
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8 space-y-6 sticky top-6">
                        <div class="flex items-center gap-3 border-b border-gray-100 pb-4">
                            <div class="p-2 bg-blue-50 rounded-xl text-blue-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-800">Galeri Foto</h3>
                                <p class="text-xs text-gray-400">Pilih banyak foto sekaligus</p>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <button type="button" @click="$refs.fileInput.click()"
                                class="w-full bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 font-semibold py-3 px-4 rounded-xl shadow-sm text-sm transition duration-200 inline-flex items-center justify-center gap-2">
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                                Pilih Foto-foto
                            </button>

                            <span class="text-xs text-gray-500 block text-center"
                                x-text="fileNames ? fileNames : 'Belum ada berkas dipilih'"></span>

                            <input type="file" name="gambar_produk[]" id="gambar" x-ref="fileInput" multiple
                                accept="image/*" @change="handleFiles($event)" class="hidden">

                            @error('gambar_produk.*')
                                <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                            @enderror

                            <!-- Container Pratinjau Grid -->
                            <div class="grid grid-cols-2 gap-3 pt-2" id="preview-container"
                                x-show="imagePreviews.length > 0" x-cloak>
                                <template x-for="(item, index) in imagePreviews" :key="index">
                                    <div
                                        class="relative border rounded-xl p-1.5 shadow-sm group bg-white border-gray-200 aspect-square">
                                        <img :src="item.url" class="w-full h-full object-cover rounded-lg"
                                            alt="Preview">
                                        <button type="button" @click="removeImage(index)"
                                            class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1 shadow-md hover:bg-red-600 transition">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- KOLOM KANAN (2 Span): Informasi Dasar, Varian Ukuran, & Editor --}}
                <div class="lg:col-span-2 space-y-8">

                    <!-- BAGIAN 1: Data Utama Produk -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8 space-y-6">
                        <div class="flex items-center gap-3 border-b border-gray-100 pb-4">
                            <div class="p-2 bg-blue-50 rounded-xl text-blue-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-800">Informasi Dasar Produk</h3>
                                <p class="text-xs text-gray-400">Nama, kategori, dan status ketersediaan</p>
                            </div>
                        </div>

                        <!-- Nama Produk -->
                        <div>
                            <label for="nama_produk"
                                class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2">
                                Nama Produk <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nama_produk" id="nama_produk" value="{{ old('nama_produk') }}"
                                required placeholder="Masukkan nama produk..."
                                class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 outline-none @error('nama_produk') border-red-500 bg-red-50/50 @enderror">
                            @error('nama_produk')
                                <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Kategori & Status (Grid) -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="kategori"
                                    class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2">
                                    Kategori Produk <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <select name="kategori" id="kategori" x-model="kategori" required
                                        class="w-full pl-4 pr-10 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 outline-none appearance-none @error('kategori') border-red-500 bg-red-50/50 @enderror">
                                        <option value="" disabled>-- Pilih Kategori --</option>
                                        <option value="Baju" {{ old('kategori') == 'Baju' ? 'selected' : '' }}>Baju
                                        </option>
                                        <option value="Topi" {{ old('kategori') == 'Topi' ? 'selected' : '' }}>Topi
                                        </option>
                                        <option value="Aksesoris" {{ old('kategori') == 'Aksesoris' ? 'selected' : '' }}>
                                            Aksesoris</option>
                                    </select>
                                    <svg class="w-5 h-5 absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                                @error('kategori')
                                    <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="status"
                                    class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2">
                                    Status Ketersediaan <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <select name="status" id="status" required
                                        class="w-full pl-4 pr-10 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 outline-none appearance-none @error('status') border-red-500 bg-red-50/50 @enderror">
                                        <option value="Tersedia" {{ old('status') == 'Tersedia' ? 'selected' : '' }}>
                                            Tersedia</option>
                                        <option value="Tidak Tersedia"
                                            {{ old('status') == 'Tidak Tersedia' ? 'selected' : '' }}>Tidak Tersedia
                                        </option>
                                        <option value="Pre-order" {{ old('status') == 'Pre-order' ? 'selected' : '' }}>
                                            Pre-order</option>
                                    </select>
                                    <svg class="w-5 h-5 absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                                @error('status')
                                    <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Deskripsi dengan CKEditor (#isi) -->
                        <div>
                            <label for="isi"
                                class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2">
                                Deskripsi Lengkap
                            </label>
                            <textarea name="deskripsi" id="isi" rows="5"
                                class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 outline-none @error('deskripsi') border-red-500 bg-red-50/50 @enderror">{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- BAGIAN 2: Varian Ukuran (Hanya tampil jika Kategori == Baju) -->
                    <div x-show="kategori === 'Baju'" x-cloak
                        class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8 space-y-6">
                        <div class="flex items-center gap-3 border-b border-gray-100 pb-4">
                            <div class="p-2 bg-blue-50 rounded-xl text-blue-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 7h6m0 10v-3m-3 3v.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-800">Varian Ukuran</h3>
                                <p class="text-xs text-gray-400">Tambahkan berbagai varian ukuran untuk kategori Baju</p>
                            </div>
                        </div>

                        <div x-data="variasiUkuran()">
                            <button type="button" @click="tambahVariasi()"
                                class="inline-flex items-center gap-1.5 bg-gray-600 hover:bg-gray-700 text-white font-bold py-2.5 px-5 rounded-xl text-sm transition duration-300 mb-6 shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4"></path>
                                </svg>
                                Tambah Ukuran Baru
                            </button>

                            <div class="space-y-6">
                                <template x-for="(variasi, index) in daftarVariasi" :key="index">
                                    <div
                                        class="grid grid-cols-1 md:grid-cols-12 gap-5 border border-gray-200 p-6 rounded-2xl relative bg-white shadow-sm">
                                        <button type="button" @click="hapusVariasi(index)"
                                            class="absolute -top-3 -right-3 bg-red-500 text-white rounded-full p-2 text-xs shadow-lg hover:bg-red-600 transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>

                                        <div class="md:col-span-3">
                                            <label
                                                class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2">Nama
                                                Ukuran <span class="text-red-500">*</span></label>
                                            {{-- Diubah menjadi ukurans[index][ukuran] agar sesuai dengan validasi controller --}}
                                            <input type="text" x-model="variasi.ukuran"
                                                :name="`ukurans[${index}][ukuran]`" :required="kategori === 'Baju'"
                                                placeholder="S / M / L"
                                                class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 text-sm focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                                        </div>

                                        <div class="md:col-span-3">
                                            <label
                                                class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2">Harga
                                                (Rp) <span class="text-red-500">*</span></label>
                                            <input type="number" x-model="variasi.harga"
                                                :name="`ukurans[${index}][harga]`" min="0"
                                                :required="kategori === 'Baju'" placeholder="0"
                                                class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 text-sm focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                                        </div>

                                        <div class="md:col-span-2">
                                            <label
                                                class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2">Stok
                                                <span class="text-red-500">*</span></label>
                                            <input type="number" x-model="variasi.stok" :name="`ukurans[${index}][stok]`"
                                                min="0" :required="kategori === 'Baju'" placeholder="0"
                                                class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 text-sm focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                                        </div>

                                        <div class="md:col-span-4">
                                            <label
                                                class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2">Status
                                                <span class="text-red-500">*</span></label>
                                            <select :name="`ukurans[${index}][status]`" x-model="variasi.status"
                                                :required="kategori === 'Baju'"
                                                class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 text-sm focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition appearance-none">
                                                <option value="Tersedia">Tersedia</option>
                                                <option value="Habis">Habis</option>
                                            </select>
                                        </div>

                                        <div class="md:col-span-12">
                                            <label
                                                class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2">Keterangan
                                                (Opsional)</label>
                                            <input type="text" x-model="variasi.keterangan"
                                                :name="`ukurans[${index}][keterangan]`"
                                                placeholder="Catatan tambahan ukuran..."
                                                class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 text-sm focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                                        </div>
                                    </div>
                                </template>
                            </div>
                            @if ($errors->has('ukurans.*'))
                                <p class="text-red-500 text-xs mt-3">Harap lengkapi seluruh varian ukuran dengan benar.</p>
                            @endif
                        </div>
                    </div>

                    <!-- BAGIAN 3: Tombol Aksi -->
                    <div class="flex items-center justify-end space-x-4 pt-4">
                        <a href="{{ route('admin.produk.index') }}"
                            class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-3 px-6 rounded-xl transition duration-300">
                            Batal
                        </a>
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg shadow-blue-200 transition duration-300">
                            Simpan Produk
                        </button>
                    </div>
                </div>

            </div>
        </form>
    </div>

    @push('scripts')
        <!-- CDN CKEditor 5 -->
        <script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>
        <script>
            function produkForm() {
                return {
                    kategori: '{{ old('kategori') }}',
                    fileNames: '',
                    imagePreviews: [],
                    filesList: [],
                    editorInstance: null,

                    init() {
                        // Inisialisasi CKEditor 5
                        ClassicEditor
                            .create(document.querySelector('#isi'))
                            .then(editor => {
                                this.editorInstance = editor;

                                // Sinkronisasi data ke textarea asli saat isi editor berubah
                                editor.model.document.on('change:data', () => {
                                    document.querySelector('#isi').value = editor.getData();
                                });
                            })
                            .catch(error => {
                                console.error(error);
                            });
                    },

                    handleFiles(event) {
                        const newFiles = Array.from(event.target.files);
                        this.filesList = this.filesList.concat(newFiles);
                        this.updateFileListAndPreviews();
                    },

                    removeImage(index) {
                        this.filesList.splice(index, 1);
                        this.updateFileListAndPreviews();
                    },

                    updateFileListAndPreviews() {
                        this.imagePreviews = [];

                        if (this.filesList.length > 0) {
                            this.fileNames = `${this.filesList.length} berkas dipilih`;

                            const dataTransfer = new DataTransfer();
                            this.filesList.forEach(file => {
                                dataTransfer.items.add(file);

                                const reader = new FileReader();
                                reader.onload = e => {
                                    this.imagePreviews.push({
                                        url: e.target.result
                                    });
                                };
                                reader.readAsDataURL(file);
                            });

                            this.$refs.fileInput.files = dataTransfer.files;
                        } else {
                            this.fileNames = '';
                            this.$refs.fileInput.value = '';
                        }
                    }
                }
            }

            function variasiUkuran() {
                return {
                    daftarVariasi: @json(old('ukurans', [])),
                    tambahVariasi() {
                        this.daftarVariasi.push({
                            ukuran: '',
                            harga: '',
                            stok: '',
                            status: 'Tersedia',
                            keterangan: ''
                        });
                    },
                    hapusVariasi(index) {
                        this.daftarVariasi.splice(index, 1);
                    }
                }
            }
        </script>
        <style>
            [x-cloak] {
                display: none !important;
            }

            /* Menjaga tinggi minimal editor CKEditor 5 agar proporsional */
            .ck-editor__editable_inline {
                min-height: 400px;
            }
        </style>
    @endpush
@endsection
