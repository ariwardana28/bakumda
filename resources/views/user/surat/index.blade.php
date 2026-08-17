@extends('layouts.app')

@section('content')
    <div class="space-y-6">

        {{-- Draft Dokumen Hukum & Korporat (10 Jenis Surat) --}}
        <div class="px-5 mb-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl md:text-2xl font-black text-white tracking-tight">Draft Dokumen Hukum & Korporat</h3>
                <span class="text-xs text-orange-500 font-semibold">Pilih Template</span>
            </div>
            
            <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-5 gap-3 sm:gap-4">
                
                {{-- 1. Surat Perjanjian Kerja Waktu Tertentu (PKWT) --}}
                <a href="{{ url('user-surat/surat-perjanjian-kerja-waktu-tertentu-pkwt') }}" class="bg-white rounded-3xl p-4 shadow-sm border border-gray-100 flex flex-col justify-between hover:border-orange-200 hover:shadow-md transition group">
                    <div>
                        <div class="w-12 h-12 rounded-2xl bg-orange-50 text-orange-600 flex items-center justify-center mb-3 group-hover:scale-105 transition">
                            <i class="fa-solid fa-file-contract text-lg"></i>
                        </div>
                        <h4 class="text-xs font-bold text-gray-900 line-clamp-2 leading-snug mb-1">Perjanjian Kerja (PKWT)</h4>
                        <p class="text-[10px] text-gray-400">Hubungan Industrial</p>
                    </div>
                    <div class="mt-3 pt-3 border-t border-gray-50 flex items-center justify-between text-[11px] font-bold text-orange-600">
                        <span>Buka Draf</span>
                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </div>
                </a>

                {{-- 2. Surat Perjanjian Hutang-Piutang --}}
                <a href="{{ url('user-surat/surat-perjanjian-hutang-piutang') }}" class="bg-white rounded-3xl p-4 shadow-sm border border-gray-100 flex flex-col justify-between hover:border-orange-200 hover:shadow-md transition group">
                    <div>
                        <div class="w-12 h-12 rounded-2xl bg-sky-50 text-sky-600 flex items-center justify-center mb-3 group-hover:scale-105 transition">
                            <i class="fa-solid fa-file-invoice-dollar text-lg"></i>
                        </div>
                        <h4 class="text-xs font-bold text-gray-900 line-clamp-2 leading-snug mb-1">Perjanjian Hutang-Piutang</h4>
                        <p class="text-[10px] text-gray-400">Pinjaman & Jaminan</p>
                    </div>
                    <div class="mt-3 pt-3 border-t border-gray-50 flex items-center justify-between text-[11px] font-bold text-sky-600">
                        <span>Buka Draf</span>
                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </div>
                </a>

                {{-- 3. Surat Perjanjian Kerja Sama Usaha --}}
                <a href="{{ url('user-surat/surat-perjanjian-kerja-sama') }}" class="bg-white rounded-3xl p-4 shadow-sm border border-gray-100 flex flex-col justify-between hover:border-orange-200 hover:shadow-md transition group">
                    <div>
                        <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center mb-3 group-hover:scale-105 transition">
                            <i class="fa-solid fa-handshake-angle text-lg"></i>
                        </div>
                        <h4 class="text-xs font-bold text-gray-900 line-clamp-2 leading-snug mb-1">Kerja Sama Usaha (KSU)</h4>
                        <p class="text-[10px] text-gray-400">Kemitraan Bisnis</p>
                    </div>
                    <div class="mt-3 pt-3 border-t border-gray-50 flex items-center justify-between text-[11px] font-bold text-indigo-600">
                        <span>Buka Draf</span>
                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </div>
                </a>

                {{-- 4. Surat Permohonan --}}
                <a href="{{ url('user-surat/surat-permohonan') }}" class="bg-white rounded-3xl p-4 shadow-sm border border-gray-100 flex flex-col justify-between hover:border-orange-200 hover:shadow-md transition group">
                    <div>
                        <div class="w-12 h-12 rounded-2xl bg-teal-50 text-teal-600 flex items-center justify-center mb-3 group-hover:scale-105 transition">
                            <i class="fa-solid fa-file-pen text-lg"></i>
                        </div>
                        <h4 class="text-xs font-bold text-gray-900 line-clamp-2 leading-snug mb-1">Surat Permohonan</h4>
                        <p class="text-[10px] text-gray-400">Administrasi Resmi</p>
                    </div>
                    <div class="mt-3 pt-3 border-t border-gray-50 flex items-center justify-between text-[11px] font-bold text-teal-600">
                        <span>Buka Draf</span>
                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </div>
                </a>

                {{-- 5. Surat Pengunduran Diri --}}
                <a href="{{ url('user-surat/surat-pengunduran-diri') }}" class="bg-white rounded-3xl p-4 shadow-sm border border-gray-100 flex flex-col justify-between hover:border-orange-200 hover:shadow-md transition group">
                    <div>
                        <div class="w-12 h-12 rounded-2xl bg-violet-50 text-violet-600 flex items-center justify-center mb-3 group-hover:scale-105 transition">
                            <i class="fa-solid fa-right-from-bracket text-lg"></i>
                        </div>
                        <h4 class="text-xs font-bold text-gray-900 line-clamp-2 leading-snug mb-1">Surat Pengunduran Diri</h4>
                        <p class="text-[10px] text-gray-400">Resign Karyawan</p>
                    </div>
                    <div class="mt-3 pt-3 border-t border-gray-50 flex items-center justify-between text-[11px] font-bold text-violet-600">
                        <span>Buka Draf</span>
                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </div>
                </a>

                {{-- 6. Surat Keterangan Kerja (Paklaring) --}}
                <a href="{{ url('user-surat/surat-keterangan-kerja') }}" class="bg-white rounded-3xl p-4 shadow-sm border border-gray-100 flex flex-col justify-between hover:border-orange-200 hover:shadow-md transition group">
                    <div>
                        <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center mb-3 group-hover:scale-105 transition">
                            <i class="fa-solid fa-briefcase text-lg"></i>
                        </div>
                        <h4 class="text-xs font-bold text-gray-900 line-clamp-2 leading-snug mb-1">Surat Keterangan Kerja</h4>
                        <p class="text-[10px] text-gray-400">Paklaring Resmi[cite: 9]</p>
                    </div>
                    <div class="mt-3 pt-3 border-t border-gray-50 flex items-center justify-between text-[11px] font-bold text-emerald-600">
                        <span>Buka Draf</span>
                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </div>
                </a>

                {{-- 7. Surat Jual Beli (Tanah / Kendaraan / Aset) --}}
                <a href="{{ url('user-surat/surat-jual-beli') }}" class="bg-white rounded-3xl p-4 shadow-sm border border-gray-100 flex flex-col justify-between hover:border-orange-200 hover:shadow-md transition group">
                    <div>
                        <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center mb-3 group-hover:scale-105 transition">
                            <i class="fa-solid fa-file-signature text-lg"></i>
                        </div>
                        <h4 class="text-xs font-bold text-gray-900 line-clamp-2 leading-snug mb-1">Surat Jual Beli Aset</h4>
                        <p class="text-[10px] text-gray-400">Tanah & Kendaraan</p>
                    </div>
                    <div class="mt-3 pt-3 border-t border-gray-50 flex items-center justify-between text-[11px] font-bold text-amber-600">
                        <span>Buka Draf</span>
                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </div>
                </a>

                {{-- 8. Surat Sewa Menyewa (Rumah / Ruko / Aset) --}}
                <a href="{{ url('user-surat/surat-sewa') }}" class="bg-white rounded-3xl p-4 shadow-sm border border-gray-100 flex flex-col justify-between hover:border-orange-200 hover:shadow-md transition group">
                    <div>
                        <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center mb-3 group-hover:scale-105 transition">
                            <i class="fa-solid fa-house-chimney text-lg"></i>
                        </div>
                        <h4 class="text-xs font-bold text-gray-900 line-clamp-2 leading-snug mb-1">Sewa Menyewa Aset</h4>
                        <p class="text-[10px] text-gray-400">Properti & Kendaraan[cite: 8]</p>
                    </div>
                    <div class="mt-3 pt-3 border-t border-gray-50 flex items-center justify-between text-[11px] font-bold text-blue-600">
                        <span>Buka Draf</span>
                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </div>
                </a>

                {{-- 9. Surat Perjanjian Perdamaian --}}
                <a href="{{ url('user-surat/surat-perjanjian-perdamaian') }}" class="bg-white rounded-3xl p-4 shadow-sm border border-gray-100 flex flex-col justify-between hover:border-orange-200 hover:shadow-md transition group">
                    <div>
                        <div class="w-12 h-12 rounded-2xl bg-yellow-50 text-yellow-600 flex items-center justify-center mb-3 group-hover:scale-105 transition">
                            <i class="fa-solid fa-handshake text-lg"></i>
                        </div>
                        <h4 class="text-xs font-bold text-gray-900 line-clamp-2 leading-snug mb-1">Perjanjian Perdamaian</h4>
                        <p class="text-[10px] text-gray-400">Penyelesaian Sengketa</p>
                    </div>
                    <div class="mt-3 pt-3 border-t border-gray-50 flex items-center justify-between text-[11px] font-bold text-yellow-600">
                        <span>Buka Draf</span>
                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </div>
                </a>

                {{-- 10. Surat Pencabutan Kuasa --}}
                <a href="{{ url('user-surat/surat-pencabutan-kuasa') }}" class="bg-white rounded-3xl p-4 shadow-sm border border-gray-100 flex flex-col justify-between hover:border-orange-200 hover:shadow-md transition group">
                    <div>
                        <div class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center mb-3 group-hover:scale-105 transition">
                            <i class="fa-solid fa-file-shield text-lg"></i>
                        </div>
                        <h4 class="text-xs font-bold text-gray-900 line-clamp-2 leading-snug mb-1">Pencabutan Kuasa</h4>
                        <p class="text-[10px] text-gray-400">Pencabutan Resmi</p>
                    </div>
                    <div class="mt-3 pt-3 border-t border-gray-50 flex items-center justify-between text-[11px] font-bold text-rose-600">
                        <span>Buka Draf</span>
                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </div>
                </a>

            </div>
        </div>

   

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