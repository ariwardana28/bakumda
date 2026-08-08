@extends('layouts.admin')

@section('title', 'Formulir Pendaftaran Sertifikasi')

@section('content')
<div class="max-w-4xl mx-auto">
        
    <!-- Main Card Container -->
    <div class="bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800/80 rounded-2xl shadow-sm overflow-hidden transition-colors duration-200">
        
        <!-- Card Top Banner / Accent Line -->
        <div class="h-1.5 bg-gradient-to-r from-brand-600 via-indigo-500 to-amber-500"></div>

        <div class="p-6 sm:p-10">
            
            <form action="#" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf

                <!-- Section 1: Informasi Paket / Gelombang -->
                <div class="space-y-4">
                    <div class="flex items-center gap-2 pb-2 border-b border-slate-100 dark:border-slate-800">
                        <div class="w-7 h-7 rounded-lg bg-brand-50 text-brand-600 dark:bg-brand-500/20 dark:text-brand-400 flex items-center justify-center text-xs font-bold">1</div>
                        <h2 class="text-xs font-bold uppercase tracking-wider text-slate-800 dark:text-slate-200">Pilihan Gelombang / Batch Pelatihan</h2>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 mb-2">
                            Pilih Gelombang Sertifikasi <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <select name="batch_id" required 
                                class="w-full bg-slate-50/80 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700/80 rounded-xl px-4 py-3 text-xs text-slate-800 dark:text-slate-100 focus:outline-none focus:border-brand-500 focus:bg-white dark:focus:bg-slate-900 focus:ring-4 focus:ring-brand-500/10 transition-all appearance-none cursor-pointer">
                                <option value="" disabled selected>-- Pilih Gelombang Sertifikasi --</option>
                                <option value="1">Batch I - Tahun 2026 (Kelas Eksekutif Akhir Pekan)</option>
                                <option value="2">Batch II - Tahun 2026 (Kelas Reguler / Intensif)</option>
                            </select>
                            <i class="fa-solid fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 text-xs pointer-events-none"></i>
                        </div>
                    </div>
                </div>

                <!-- Section 2: Data Diri Peserta -->
                <div class="space-y-4">
                    <div class="flex items-center gap-2 pb-2 border-b border-slate-100 dark:border-slate-800">
                        <div class="w-7 h-7 rounded-lg bg-brand-50 text-brand-600 dark:bg-brand-500/20 dark:text-brand-400 flex items-center justify-center text-xs font-bold">2</div>
                        <h2 class="text-xs font-bold uppercase tracking-wider text-slate-800 dark:text-slate-200">Informasi Data Diri</h2>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <!-- Nama Lengkap -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 mb-2">
                                Nama Lengkap & Gelar <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="nama_lengkap" required placeholder="Contoh: Dr. Rahmat Hidayat, S.H., M.H."
                                class="w-full bg-slate-50/80 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700/80 rounded-xl px-4 py-3 text-xs text-slate-800 dark:text-slate-100 focus:outline-none focus:border-brand-500 focus:bg-white dark:focus:bg-slate-900 focus:ring-4 focus:ring-brand-500/10 transition-all">
                            <span class="text-[11px] text-slate-400 mt-1 block">Digunakan untuk pencetakan sertifikat resmi.</span>
                        </div>

                        <!-- NIK / No. Identitas -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 mb-2">
                                NIK (Nomor Induk Kependudukan) <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="nik" required placeholder="Masukkan 16 digit NIK" maxlength="16"
                                class="w-full bg-slate-50/80 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700/80 rounded-xl px-4 py-3 text-xs text-slate-800 dark:text-slate-100 focus:outline-none focus:border-brand-500 focus:bg-white dark:focus:bg-slate-900 focus:ring-4 focus:ring-brand-500/10 transition-all">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <!-- Nomor WhatsApp / Telepon -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 mb-2">
                                Nomor WhatsApp Aktif <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs">+62</span>
                                <input type="tel" name="whatsapp" required placeholder="81234567890"
                                    class="w-full pl-11 pr-4 bg-slate-50/80 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700/80 rounded-xl py-3 text-xs text-slate-800 dark:text-slate-100 focus:outline-none focus:border-brand-500 focus:bg-white dark:focus:bg-slate-900 focus:ring-4 focus:ring-brand-500/10 transition-all">
                            </div>
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 mb-2">
                                Alamat Email <span class="text-rose-500">*</span>
                            </label>
                            <input type="email" name="email" required placeholder="nama@domain.com"
                                class="w-full bg-slate-50/80 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700/80 rounded-xl px-4 py-3 text-xs text-slate-800 dark:text-slate-100 focus:outline-none focus:border-brand-500 focus:bg-white dark:focus:bg-slate-900 focus:ring-4 focus:ring-brand-500/10 transition-all">
                        </div>
                    </div>

                    <!-- Latar Belakang Pendidikan / Instansi -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 mb-2">
                                Latar Belakang Pendidikan <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative">
                                <select name="pendidikan_terakhir" required 
                                    class="w-full bg-slate-50/80 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700/80 rounded-xl px-4 py-3 text-xs text-slate-800 dark:text-slate-100 focus:outline-none focus:border-brand-500 focus:bg-white dark:focus:bg-slate-900 focus:ring-4 focus:ring-brand-500/10 transition-all appearance-none cursor-pointer">
                                    <option value="" disabled selected>-- Pilih Pendidikan --</option>
                                    <option value="S1 Hukum">S1 Ilmu Hukum</option>
                                    <option value="S2 Hukum">S2 / Magister Hukum</option>
                                    <option value="Lainnya">Lainnya (Non-Hukum)</option>
                                </select>
                                <i class="fa-solid fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 text-xs pointer-events-none"></i>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 mb-2">
                                Asal Instansi / Kantor / Universitas
                            </label>
                            <input type="text" name="instansi" placeholder="Nama Kantor Hukum / Universitas"
                                class="w-full bg-slate-50/80 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700/80 rounded-xl px-4 py-3 text-xs text-slate-800 dark:text-slate-100 focus:outline-none focus:border-brand-500 focus:bg-white dark:focus:bg-slate-900 focus:ring-4 focus:ring-brand-500/10 transition-all">
                        </div>
                    </div>
                </div>

                <!-- Section 3: Unggah Berkas Persyaratan -->
                <div class="space-y-4">
                    <div class="flex items-center gap-2 pb-2 border-b border-slate-100 dark:border-slate-800">
                        <div class="w-7 h-7 rounded-lg bg-brand-50 text-brand-600 dark:bg-brand-500/20 dark:text-brand-400 flex items-center justify-center text-xs font-bold">3</div>
                        <h2 class="text-xs font-bold uppercase tracking-wider text-slate-800 dark:text-slate-200">Unggah Berkas Persyaratan</h2>
                    </div>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <!-- Scan Ijazah -->
                        <div class="p-4 rounded-xl border border-dashed border-slate-300 dark:border-slate-700 hover:border-brand-500 dark:hover:border-brand-500 transition-colors bg-slate-50/50 dark:bg-slate-800/20">
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                                Scan Ijazah Terakhir <span class="text-rose-500">*</span>
                            </label>
                            <p class="text-[11px] text-slate-400 mb-3">Format: PDF, JPG, atau PNG (Maks. 2MB)</p>
                            <input type="file" name="file_ijazah" accept=".pdf,.jpg,.jpeg,.png" required
                                class="w-full text-xs text-slate-500 dark:text-slate-400 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-[11px] file:font-semibold file:bg-brand-50 file:text-brand-600 dark:file:bg-brand-500/20 dark:file:text-brand-400 hover:file:bg-brand-100 transition cursor-pointer">
                        </div>

                        <!-- Pas Foto -->
                        <div class="p-4 rounded-xl border border-dashed border-slate-300 dark:border-slate-700 hover:border-brand-500 dark:hover:border-brand-500 transition-colors bg-slate-50/50 dark:bg-slate-800/20">
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                                Pas Foto Formal Berjas <span class="text-rose-500">*</span>
                            </label>
                            <p class="text-[11px] text-slate-400 mb-3">Format: JPG atau PNG (Background Merah/Biru)</p>
                            <input type="file" name="file_foto" accept=".jpg,.jpeg,.png" required
                                class="w-full text-xs text-slate-500 dark:text-slate-400 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-[11px] file:font-semibold file:bg-brand-50 file:text-brand-600 dark:file:bg-brand-500/20 dark:file:text-brand-400 hover:file:bg-brand-100 transition cursor-pointer">
                        </div>
                    </div>
                </div>

                <!-- Informasi Catatan / Alert Box -->
                <div class="bg-amber-50 dark:bg-amber-950/20 border border-amber-200/60 dark:border-amber-900/30 rounded-xl p-4 flex gap-3 text-xs text-amber-800 dark:text-amber-300">
                    <i class="fa-solid fa-circle-exclamation text-amber-500 text-sm shrink-0 mt-0.5"></i>
                    <div class="space-y-1">
                        <p class="font-bold">Catatan Penting Pendaftaran:</p>
                        <p class="leading-relaxed opacity-90">1. Pastikan seluruh data nama dan gelar sudah benar untuk keperluan pencetakan sertifikat resmi.</p>
                        <p class="leading-relaxed opacity-90">2. Setelah menekan tombol kirim, data Anda akan otomatis masuk ke antrean validasi panel admin.</p>
                    </div>
                </div>

                <!-- Tombol Aksi -->
                <div class="pt-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-end gap-3">
                    <a href="#" 
                        class="px-5 py-2.5 rounded-xl text-xs font-semibold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                        Batal
                    </a>
                    <button type="submit" 
                        class="px-6 py-2.5 bg-brand-600 hover:bg-brand-700 text-white text-xs font-bold rounded-xl shadow-lg shadow-brand-500/20 transition-all duration-200 flex items-center gap-2">
                        <i class="fa-solid fa-paper-plane text-xs"></i> Kirim Pendaftaran
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>
@endsection