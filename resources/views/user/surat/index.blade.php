@extends('layouts.app')

@section('content')
    <div class="space-y-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

        {{-- Draft Dokumen Hukum & Korporat (10 Jenis Surat) --}}
        <div class="mb-8">
            {{-- Section Header --}}
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-6">
                <div>
                    <h3 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                        Draft Dokumen Hukum & Korporat
                    </h3>
                    <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1">
                        Pilih template dokumen legalitas dan perjanjian yang sesuai dengan kebutuhan Anda.
                    </p>
                </div>
                <div class="self-start sm:self-auto">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-orange-500/10 text-orange-600 dark:text-orange-400 border border-orange-500/20 backdrop-blur-sm">
                        <i class="fa-solid fa-layer-group text-[10px]"></i> 10 Template Tersedia
                    </span>
                </div>
            </div>
            
            {{-- Template Grid --}}
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3.5 sm:gap-5">
                
                {{-- 1. Surat Perjanjian Kerja Waktu Tertentu (PKWT) --}}
                <a href="{{ url('user-surat/surat-perjanjian-kerja-waktu-tertentu-pkwt') }}" 
                   class="group relative bg-white dark:bg-slate-800/90 rounded-2xl p-4 border border-slate-200/80 dark:border-slate-700/60 shadow-sm hover:shadow-xl hover:border-orange-500/40 dark:hover:border-orange-500/40 transition-all duration-300 hover:-translate-y-1.5 flex flex-col justify-between overflow-hidden">
                    <div class="absolute -right-4 -top-4 w-16 h-16 bg-orange-500/5 rounded-full blur-xl group-hover:bg-orange-500/15 transition-all duration-500"></div>
                    <div>
                        <div class="w-11 h-11 rounded-xl bg-orange-500/10 text-orange-600 dark:text-orange-400 flex items-center justify-center mb-3.5 group-hover:scale-110 group-hover:bg-orange-500 group-hover:text-white transition-all duration-300 shadow-sm">
                            <i class="fa-solid fa-file-contract text-base"></i>
                        </div>
                        <h4 class="text-xs sm:text-sm font-bold text-slate-800 dark:text-slate-100 line-clamp-2 leading-snug mb-1 group-hover:text-orange-600 dark:group-hover:text-orange-400 transition-colors">
                            Perjanjian Kerja (PKWT)
                        </h4>
                        <p class="text-[10px] sm:text-xs text-slate-400 dark:text-slate-500 font-medium">Hubungan Industrial</p>
                    </div>
                    <div class="mt-4 pt-3 border-t border-slate-100 dark:border-slate-700/50 flex items-center justify-between text-[11px] font-bold text-orange-600 dark:text-orange-400">
                        <span>Buka Draf</span>
                        <i class="fa-solid fa-arrow-right text-[10px] transform group-hover:translate-x-1 transition-transform"></i>
                    </div>
                </a>

                {{-- 2. Surat Perjanjian Hutang-Piutang --}}
                <a href="{{ url('user-surat/surat-perjanjian-hutang-piutang') }}" 
                   class="group relative bg-white dark:bg-slate-800/90 rounded-2xl p-4 border border-slate-200/80 dark:border-slate-700/60 shadow-sm hover:shadow-xl hover:border-sky-500/40 dark:hover:border-sky-500/40 transition-all duration-300 hover:-translate-y-1.5 flex flex-col justify-between overflow-hidden">
                    <div class="absolute -right-4 -top-4 w-16 h-16 bg-sky-500/5 rounded-full blur-xl group-hover:bg-sky-500/15 transition-all duration-500"></div>
                    <div>
                        <div class="w-11 h-11 rounded-xl bg-sky-500/10 text-sky-600 dark:text-sky-400 flex items-center justify-center mb-3.5 group-hover:scale-110 group-hover:bg-sky-500 group-hover:text-white transition-all duration-300 shadow-sm">
                            <i class="fa-solid fa-file-invoice-dollar text-base"></i>
                        </div>
                        <h4 class="text-xs sm:text-sm font-bold text-slate-800 dark:text-slate-100 line-clamp-2 leading-snug mb-1 group-hover:text-sky-600 dark:group-hover:text-sky-400 transition-colors">
                            Perjanjian Hutang-Piutang
                        </h4>
                        <p class="text-[10px] sm:text-xs text-slate-400 dark:text-slate-500 font-medium">Pinjaman & Jaminan</p>
                    </div>
                    <div class="mt-4 pt-3 border-t border-slate-100 dark:border-slate-700/50 flex items-center justify-between text-[11px] font-bold text-sky-600 dark:text-sky-400">
                        <span>Buka Draf</span>
                        <i class="fa-solid fa-arrow-right text-[10px] transform group-hover:translate-x-1 transition-transform"></i>
                    </div>
                </a>

                {{-- 3. Surat Perjanjian Kerja Sama Usaha --}}
                <a href="{{ url('user-surat/surat-perjanjian-kerja-sama') }}" 
                   class="group relative bg-white dark:bg-slate-800/90 rounded-2xl p-4 border border-slate-200/80 dark:border-slate-700/60 shadow-sm hover:shadow-xl hover:border-indigo-500/40 dark:hover:border-indigo-500/40 transition-all duration-300 hover:-translate-y-1.5 flex flex-col justify-between overflow-hidden">
                    <div class="absolute -right-4 -top-4 w-16 h-16 bg-indigo-500/5 rounded-full blur-xl group-hover:bg-indigo-500/15 transition-all duration-500"></div>
                    <div>
                        <div class="w-11 h-11 rounded-xl bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 flex items-center justify-center mb-3.5 group-hover:scale-110 group-hover:bg-indigo-500 group-hover:text-white transition-all duration-300 shadow-sm">
                            <i class="fa-solid fa-handshake-angle text-base"></i>
                        </div>
                        <h4 class="text-xs sm:text-sm font-bold text-slate-800 dark:text-slate-100 line-clamp-2 leading-snug mb-1 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                            Kerja Sama Usaha (KSU)
                        </h4>
                        <p class="text-[10px] sm:text-xs text-slate-400 dark:text-slate-500 font-medium">Kemitraan Bisnis</p>
                    </div>
                    <div class="mt-4 pt-3 border-t border-slate-100 dark:border-slate-700/50 flex items-center justify-between text-[11px] font-bold text-indigo-600 dark:text-indigo-400">
                        <span>Buka Draf</span>
                        <i class="fa-solid fa-arrow-right text-[10px] transform group-hover:translate-x-1 transition-transform"></i>
                    </div>
                </a>

                {{-- 4. Surat Permohonan --}}
                <a href="{{ url('user-surat/surat-permohonan') }}" 
                   class="group relative bg-white dark:bg-slate-800/90 rounded-2xl p-4 border border-slate-200/80 dark:border-slate-700/60 shadow-sm hover:shadow-xl hover:border-teal-500/40 dark:hover:border-teal-500/40 transition-all duration-300 hover:-translate-y-1.5 flex flex-col justify-between overflow-hidden">
                    <div class="absolute -right-4 -top-4 w-16 h-16 bg-teal-500/5 rounded-full blur-xl group-hover:bg-teal-500/15 transition-all duration-500"></div>
                    <div>
                        <div class="w-11 h-11 rounded-xl bg-teal-500/10 text-teal-600 dark:text-teal-400 flex items-center justify-center mb-3.5 group-hover:scale-110 group-hover:bg-teal-500 group-hover:text-white transition-all duration-300 shadow-sm">
                            <i class="fa-solid fa-file-pen text-base"></i>
                        </div>
                        <h4 class="text-xs sm:text-sm font-bold text-slate-800 dark:text-slate-100 line-clamp-2 leading-snug mb-1 group-hover:text-teal-600 dark:group-hover:text-teal-400 transition-colors">
                            Surat Permohonan
                        </h4>
                        <p class="text-[10px] sm:text-xs text-slate-400 dark:text-slate-500 font-medium">Administrasi Resmi</p>
                    </div>
                    <div class="mt-4 pt-3 border-t border-slate-100 dark:border-slate-700/50 flex items-center justify-between text-[11px] font-bold text-teal-600 dark:text-teal-400">
                        <span>Buka Draf</span>
                        <i class="fa-solid fa-arrow-right text-[10px] transform group-hover:translate-x-1 transition-transform"></i>
                    </div>
                </a>

                {{-- 5. Surat Pengunduran Diri --}}
                <a href="{{ url('user-surat/surat-pengunduran-diri') }}" 
                   class="group relative bg-white dark:bg-slate-800/90 rounded-2xl p-4 border border-slate-200/80 dark:border-slate-700/60 shadow-sm hover:shadow-xl hover:border-violet-500/40 dark:hover:border-violet-500/40 transition-all duration-300 hover:-translate-y-1.5 flex flex-col justify-between overflow-hidden">
                    <div class="absolute -right-4 -top-4 w-16 h-16 bg-violet-500/5 rounded-full blur-xl group-hover:bg-violet-500/15 transition-all duration-500"></div>
                    <div>
                        <div class="w-11 h-11 rounded-xl bg-violet-500/10 text-violet-600 dark:text-violet-400 flex items-center justify-center mb-3.5 group-hover:scale-110 group-hover:bg-violet-500 group-hover:text-white transition-all duration-300 shadow-sm">
                            <i class="fa-solid fa-right-from-bracket text-base"></i>
                        </div>
                        <h4 class="text-xs sm:text-sm font-bold text-slate-800 dark:text-slate-100 line-clamp-2 leading-snug mb-1 group-hover:text-violet-600 dark:group-hover:text-violet-400 transition-colors">
                            Surat Pengunduran Diri
                        </h4>
                        <p class="text-[10px] sm:text-xs text-slate-400 dark:text-slate-500 font-medium">Resign Karyawan</p>
                    </div>
                    <div class="mt-4 pt-3 border-t border-slate-100 dark:border-slate-700/50 flex items-center justify-between text-[11px] font-bold text-violet-600 dark:text-violet-400">
                        <span>Buka Draf</span>
                        <i class="fa-solid fa-arrow-right text-[10px] transform group-hover:translate-x-1 transition-transform"></i>
                    </div>
                </a>

                {{-- 6. Surat Keterangan Kerja (Paklaring) --}}
                <a href="{{ url('user-surat/surat-keterangan-kerja') }}" 
                   class="group relative bg-white dark:bg-slate-800/90 rounded-2xl p-4 border border-slate-200/80 dark:border-slate-700/60 shadow-sm hover:shadow-xl hover:border-emerald-500/40 dark:hover:border-emerald-500/40 transition-all duration-300 hover:-translate-y-1.5 flex flex-col justify-between overflow-hidden">
                    <div class="absolute -right-4 -top-4 w-16 h-16 bg-emerald-500/5 rounded-full blur-xl group-hover:bg-emerald-500/15 transition-all duration-500"></div>
                    <div>
                        <div class="w-11 h-11 rounded-xl bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 flex items-center justify-center mb-3.5 group-hover:scale-110 group-hover:bg-emerald-500 group-hover:text-white transition-all duration-300 shadow-sm">
                            <i class="fa-solid fa-briefcase text-base"></i>
                        </div>
                        <h4 class="text-xs sm:text-sm font-bold text-slate-800 dark:text-slate-100 line-clamp-2 leading-snug mb-1 group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors">
                            Surat Keterangan Kerja
                        </h4>
                        <p class="text-[10px] sm:text-xs text-slate-400 dark:text-slate-500 font-medium">Paklaring Resmi</p>
                    </div>
                    <div class="mt-4 pt-3 border-t border-slate-100 dark:border-slate-700/50 flex items-center justify-between text-[11px] font-bold text-emerald-600 dark:text-emerald-400">
                        <span>Buka Draf</span>
                        <i class="fa-solid fa-arrow-right text-[10px] transform group-hover:translate-x-1 transition-transform"></i>
                    </div>
                </a>

                {{-- 7. Surat Jual Beli (Tanah / Kendaraan / Aset) --}}
                <a href="{{ url('user-surat/surat-jual-beli') }}" 
                   class="group relative bg-white dark:bg-slate-800/90 rounded-2xl p-4 border border-slate-200/80 dark:border-slate-700/60 shadow-sm hover:shadow-xl hover:border-amber-500/40 dark:hover:border-amber-500/40 transition-all duration-300 hover:-translate-y-1.5 flex flex-col justify-between overflow-hidden">
                    <div class="absolute -right-4 -top-4 w-16 h-16 bg-amber-500/5 rounded-full blur-xl group-hover:bg-amber-500/15 transition-all duration-500"></div>
                    <div>
                        <div class="w-11 h-11 rounded-xl bg-amber-500/10 text-amber-600 dark:text-amber-400 flex items-center justify-center mb-3.5 group-hover:scale-110 group-hover:bg-amber-500 group-hover:text-white transition-all duration-300 shadow-sm">
                            <i class="fa-solid fa-file-signature text-base"></i>
                        </div>
                        <h4 class="text-xs sm:text-sm font-bold text-slate-800 dark:text-slate-100 line-clamp-2 leading-snug mb-1 group-hover:text-amber-600 dark:group-hover:text-amber-400 transition-colors">
                            Surat Jual Beli Aset
                        </h4>
                        <p class="text-[10px] sm:text-xs text-slate-400 dark:text-slate-500 font-medium">Tanah & Kendaraan</p>
                    </div>
                    <div class="mt-4 pt-3 border-t border-slate-100 dark:border-slate-700/50 flex items-center justify-between text-[11px] font-bold text-amber-600 dark:text-amber-400">
                        <span>Buka Draf</span>
                        <i class="fa-solid fa-arrow-right text-[10px] transform group-hover:translate-x-1 transition-transform"></i>
                    </div>
                </a>

                {{-- 8. Surat Sewa Menyewa (Rumah / Ruko / Aset) --}}
                <a href="{{ url('user-surat/surat-sewa') }}" 
                   class="group relative bg-white dark:bg-slate-800/90 rounded-2xl p-4 border border-slate-200/80 dark:border-slate-700/60 shadow-sm hover:shadow-xl hover:border-blue-500/40 dark:hover:border-blue-500/40 transition-all duration-300 hover:-translate-y-1.5 flex flex-col justify-between overflow-hidden">
                    <div class="absolute -right-4 -top-4 w-16 h-16 bg-blue-500/5 rounded-full blur-xl group-hover:bg-blue-500/15 transition-all duration-500"></div>
                    <div>
                        <div class="w-11 h-11 rounded-xl bg-blue-500/10 text-blue-600 dark:text-blue-400 flex items-center justify-center mb-3.5 group-hover:scale-110 group-hover:bg-blue-500 group-hover:text-white transition-all duration-300 shadow-sm">
                            <i class="fa-solid fa-house-chimney text-base"></i>
                        </div>
                        <h4 class="text-xs sm:text-sm font-bold text-slate-800 dark:text-slate-100 line-clamp-2 leading-snug mb-1 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                            Sewa Menyewa Aset
                        </h4>
                        <p class="text-[10px] sm:text-xs text-slate-400 dark:text-slate-500 font-medium">Properti & Kendaraan</p>
                    </div>
                    <div class="mt-4 pt-3 border-t border-slate-100 dark:border-slate-700/50 flex items-center justify-between text-[11px] font-bold text-blue-600 dark:text-blue-400">
                        <span>Buka Draf</span>
                        <i class="fa-solid fa-arrow-right text-[10px] transform group-hover:translate-x-1 transition-transform"></i>
                    </div>
                </a>

                {{-- 9. Surat Perjanjian Perdamaian --}}
                <a href="{{ url('user-surat/surat-perjanjian-perdamaian') }}" 
                   class="group relative bg-white dark:bg-slate-800/90 rounded-2xl p-4 border border-slate-200/80 dark:border-slate-700/60 shadow-sm hover:shadow-xl hover:border-yellow-500/40 dark:hover:border-yellow-500/40 transition-all duration-300 hover:-translate-y-1.5 flex flex-col justify-between overflow-hidden">
                    <div class="absolute -right-4 -top-4 w-16 h-16 bg-yellow-500/5 rounded-full blur-xl group-hover:bg-yellow-500/15 transition-all duration-500"></div>
                    <div>
                        <div class="w-11 h-11 rounded-xl bg-yellow-500/10 text-yellow-600 dark:text-yellow-400 flex items-center justify-center mb-3.5 group-hover:scale-110 group-hover:bg-yellow-500 group-hover:text-white transition-all duration-300 shadow-sm">
                            <i class="fa-solid fa-handshake text-base"></i>
                        </div>
                        <h4 class="text-xs sm:text-sm font-bold text-slate-800 dark:text-slate-100 line-clamp-2 leading-snug mb-1 group-hover:text-yellow-600 dark:group-hover:text-yellow-400 transition-colors">
                            Perjanjian Perdamaian
                        </h4>
                        <p class="text-[10px] sm:text-xs text-slate-400 dark:text-slate-500 font-medium">Penyelesaian Sengketa</p>
                    </div>
                    <div class="mt-4 pt-3 border-t border-slate-100 dark:border-slate-700/50 flex items-center justify-between text-[11px] font-bold text-yellow-600 dark:text-yellow-400">
                        <span>Buka Draf</span>
                        <i class="fa-solid fa-arrow-right text-[10px] transform group-hover:translate-x-1 transition-transform"></i>
                    </div>
                </a>

                {{-- 10. Surat Pencabutan Kuasa --}}
                <a href="{{ url('user-surat/surat-pencabutan-kuasa') }}" 
                   class="group relative bg-white dark:bg-slate-800/90 rounded-2xl p-4 border border-slate-200/80 dark:border-slate-700/60 shadow-sm hover:shadow-xl hover:border-rose-500/40 dark:hover:border-rose-500/40 transition-all duration-300 hover:-translate-y-1.5 flex flex-col justify-between overflow-hidden">
                    <div class="absolute -right-4 -top-4 w-16 h-16 bg-rose-500/5 rounded-full blur-xl group-hover:bg-rose-500/15 transition-all duration-500"></div>
                    <div>
                        <div class="w-11 h-11 rounded-xl bg-rose-500/10 text-rose-600 dark:text-rose-400 flex items-center justify-center mb-3.5 group-hover:scale-110 group-hover:bg-rose-500 group-hover:text-white transition-all duration-300 shadow-sm">
                            <i class="fa-solid fa-file-shield text-base"></i>
                        </div>
                        <h4 class="text-xs sm:text-sm font-bold text-slate-800 dark:text-slate-100 line-clamp-2 leading-snug mb-1 group-hover:text-rose-600 dark:group-hover:text-rose-400 transition-colors">
                            Pencabutan Kuasa
                        </h4>
                        <p class="text-[10px] sm:text-xs text-slate-400 dark:text-slate-500 font-medium">Pencabutan Resmi</p>
                    </div>
                    <div class="mt-4 pt-3 border-t border-slate-100 dark:border-slate-700/50 flex items-center justify-between text-[11px] font-bold text-rose-600 dark:text-rose-400">
                        <span>Buka Draf</span>
                        <i class="fa-solid fa-arrow-right text-[10px] transform group-hover:translate-x-1 transition-transform"></i>
                    </div>
                </a>

            </div>
        </div>

        {{-- Slider Script --}}
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const slider = document.getElementById('adSlider');
                if (!slider) return;

                const dots = document.querySelectorAll('.ad-dot');
                const totalSlides = dots.length;
                let currentSlide = 0;

                function updateDots() {
                    dots.forEach((dot, index) => {
                        if (index === currentSlide) {
                            dot.classList.remove('bg-white/60', 'w-2');
                            dot.classList.add('bg-white', 'w-5');
                        } else {
                            dot.classList.remove('bg-white', 'w-5');
                            dot.classList.add('bg-white/60', 'w-2');
                        }
                    });
                }

                function nextSlide() {
                    currentSlide = (currentSlide + 1) % totalSlides;
                    slider.style.transform = `translateX(-${currentSlide * 100}%)`;
                    updateDots();
                }

                let slideInterval = setInterval(nextSlide, 4000);

                slider.addEventListener('mouseenter', () => clearInterval(slideInterval));
                slider.addEventListener('mouseleave', () => {
                    slideInterval = setInterval(nextSlide, 4000);
                });

                updateDots();
            });
        </script>
    </div>
@endsection