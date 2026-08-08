@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8 relative overflow-hidden" x-data="{ openModal: false }">

        {{-- Background Ambient Glow Effects --}}
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-indigo-400/10 rounded-full blur-[120px] pointer-events-none"></div>
        <div class="absolute top-1/3 right-10 w-96 h-96 bg-pink-400/10 rounded-full blur-[140px] pointer-events-none"></div>

        {{-- Tombol Kembali ke Daftar Pelatihan --}}
        <div class="mb-5">
            <a href="{{ route('user-pelatihan.index') }}"
                class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white/80 dark:bg-slate-900/80 backdrop-blur-xl border border-slate-200/80 dark:border-slate-800 text-slate-600 dark:text-slate-300 hover:text-brand-600 dark:hover:text-brand-400 hover:border-brand-300 dark:hover:border-brand-700 font-bold text-xs shadow-xs transition-all duration-200 group">
                <div
                    class="w-5 h-5 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 group-hover:bg-brand-600 group-hover:text-white flex items-center justify-center transition-all duration-200">
                    <svg class="w-3 h-3 transition-transform group-hover:-translate-x-0.5" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </div>
                <span>Kembali ke Daftar Pelatihan</span>
            </a>
        </div>
        {{-- Main Card Materi --}}
        <div
            class="bg-white/90 backdrop-blur-2xl rounded-[2.5rem] shadow-[0_20px_50px_rgba(79,70,229,0.08)] border border-indigo-50 overflow-hidden mb-8 transition-all relative z-10">

            {{-- Aksen Gradient Glow di Pojok Header --}}
            <div
                class="absolute top-0 right-0 w-[450px] h-[450px] bg-gradient-to-br from-indigo-500/15 via-purple-500/10 to-pink-500/0 rounded-full blur-3xl pointer-events-none">
            </div>
            <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500">
            </div>

            {{-- Header Materi --}}
            <div
                class="p-8 sm:p-12 border-b border-indigo-50/60 bg-gradient-to-br from-indigo-50/80 via-purple-50/30 to-white/60 relative">
                <div
                    class="inline-flex items-center gap-3 px-4.5 py-2 rounded-2xl bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 text-white text-xs font-black uppercase tracking-wider mb-6 shadow-lg shadow-indigo-500/30 border border-white/20">
                    <span class="relative flex h-2.5 w-2.5">
                        <span
                            class="animate-ping absolute inline-flex h-full w-full rounded-full bg-pink-300 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-white"></span>
                    </span>
                    Pelatihan: {{ $pelatihan->judul }}
                </div>
                <h1
                    class="text-3xl sm:text-5xl font-black text-transparent bg-clip-text bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-800 tracking-tight leading-[1.15]">
                    {{ $materi->judul }}
                </h1>
            </div>

            {{-- Media / File Preview Section (Gambar / Video / Dokumen) --}}
            @if ($materi->file || $materi->gambar)
                <div
                    class="bg-slate-950 w-full flex items-center justify-center relative overflow-hidden shadow-inner border-y border-slate-800/80">
                    <div
                        class="absolute inset-0 bg-gradient-to-t from-slate-950 via-transparent to-slate-950/40 pointer-events-none z-10">
                    </div>
                    @php
                        $filePath = $materi->file ? asset('storage/' . $materi->file) : null;
                        $imagePath = $materi->gambar ? asset('storage/' . $materi->gambar) : null;
                        $extension = $materi->file ? pathinfo($materi->file, PATHINFO_EXTENSION) : null;
                    @endphp

                    {{-- Jika file berupa Video --}}
                    @if (in_array($extension, ['mp4', 'webm', 'ogg']))
                        <video controls class="w-full max-h-[600px] object-contain shadow-2xl relative z-0">
                            <source src="{{ $filePath }}" type="video/{{ $extension }}">
                            Browser Anda tidak mendukung pemutar video.
                        </video>

                        {{-- Jika file berupa Gambar atau ada cover gambar --}}
                    @elseif($imagePath && !$filePath)
                        <img src="{{ $imagePath }}" alt="{{ $materi->judul }}"
                            class="w-full max-h-[600px] object-contain relative z-0">

                        {{-- Jika file berupa PDF --}}
                    @elseif($extension === 'pdf')
                        <div
                            class="w-full h-[650px] bg-slate-900 flex flex-col items-center justify-center p-4 sm:p-6 relative z-0">
                            <iframe src="{{ $filePath }}"
                                class="w-full h-full rounded-2xl border border-slate-800 shadow-2xl"></iframe>
                        </div>

                        {{-- Format File Lainnya --}}
                    @elseif($filePath)
                        <div class="p-16 text-center text-white relative z-20">
                            <div
                                class="w-24 h-24 mx-auto mb-6 rounded-3xl bg-gradient-to-tr from-indigo-500 via-purple-500 to-pink-500 border border-white/30 flex items-center justify-center text-white shadow-2xl shadow-pink-500/40 backdrop-blur-xl animate-bounce duration-1000">
                                <svg class="w-10 h-10 drop-shadow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                            </div>
                            <p
                                class="text-xl font-extrabold mb-3 bg-clip-text text-transparent bg-gradient-to-r from-white via-indigo-100 to-purple-200">
                                File Lampiran Tersedia</p>
                            <a href="{{ $filePath }}" target="_blank"
                                class="px-8 py-4 bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 hover:from-indigo-500 hover:to-pink-500 text-white rounded-2xl text-sm font-extrabold transition-all shadow-xl shadow-purple-600/40 inline-flex items-center gap-3 hover:scale-105 active:scale-95 border border-white/20">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                                Download / Buka File
                            </a>
                        </div>
                    @endif
                </div>
            @endif

            {{-- Deskripsi / Isi Materi --}}
            <div class="p-8 sm:p-12">
                <h3 class="text-xl font-extrabold text-slate-900 mb-6 flex items-center gap-3.5">
                    <span
                        class="w-3 h-7 bg-gradient-to-b from-indigo-500 via-purple-600 to-pink-600 rounded-full shadow-lg shadow-indigo-500/50"></span>
                    <span class="bg-clip-text text-transparent bg-gradient-to-r from-slate-900 to-indigo-950">Deskripsi &
                        Isi Materi</span>
                </h3>
                <div
                    class="prose max-w-none text-slate-600 leading-relaxed whitespace-pre-line space-y-4 text-base font-normal">
                    {!! $materi->deskripsi !!}
                </div>
            </div>
        </div>

        {{-- Bagian Ujian / Soal (Tombol Pemicu Modal Kuis) --}}
        @if (isset($materi->soal) && $materi->soal->count() > 0)
            <div class="relative z-10">
                {{-- Logika untuk menampilkan status kuis berdasarkan nilai_total_soal --}}
                @if (isset($nilai))
                    @if ($nilai->nilai_total_soal >= 75)
                        {{-- KONDISI: LULUS (nilai_total_soal >= 75) --}}
                        <div
                            class="relative overflow-hidden bg-gradient-to-br from-emerald-500 via-teal-600 to-cyan-700 rounded-[2.5rem] p-8 sm:p-10 text-white shadow-2xl shadow-emerald-500/30 flex flex-col sm:flex-row items-center justify-between gap-8 border border-emerald-400/40">
                            <div
                                class="absolute -right-10 -bottom-10 w-72 h-72 bg-white/10 rounded-full blur-3xl pointer-events-none">
                            </div>
                            <div
                                class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-emerald-300 via-teal-200 to-cyan-300">
                            </div>

                            <div class="relative z-10 text-center sm:text-left">
                                <div
                                    class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/20 backdrop-blur-md text-emerald-100 text-xs font-black uppercase tracking-wider mb-3 border border-white/25 shadow-sm">
                                    <svg class="w-4 h-4 text-emerald-200" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Status: Lulus Berkompeten
                                </div>
                                <h3 class="text-2xl sm:text-4xl font-black mb-2 tracking-tight">Selamat, Anda Lulus!</h3>
                                <p class="text-emerald-100 text-sm sm:text-base max-w-xl leading-relaxed">
                                    Skor total ujian Anda: <strong
                                        class="text-2xl font-black bg-white/25 px-4 py-1 rounded-2xl inline-block ml-1 shadow-inner border border-white/30 backdrop-blur-sm">{{ number_format($nilai->nilai_total_soal, 2) }}</strong>
                                </p>
                            </div>
                            {{-- <a href="#" class="relative z-10 px-8 py-4 bg-white text-emerald-800 font-extrabold text-sm rounded-2xl shadow-xl shadow-emerald-950/20 hover:bg-emerald-50 hover:scale-105 active:scale-95 transition-all duration-200 shrink-0 flex items-center gap-3 group">
                                <span>Lihat Detail Nilai</span>
                                <svg class="w-5 h-5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                            </a> --}}
                        </div>
                    @else
                        {{-- KONDISI: REMIDI (nilai_total_soal < 75) --}}
                        @php
                            $canRetake = \Carbon\Carbon::parse($nilai->updated_at)->addMinutes(1)->isPast();
                        @endphp
                        <div
                            class="relative overflow-hidden bg-gradient-to-br from-amber-500 via-orange-600 to-rose-700 rounded-[2.5rem] p-8 sm:p-10 text-white shadow-2xl shadow-orange-500/30 flex flex-col sm:flex-row items-center justify-between gap-8 border border-amber-400/40">
                            <div
                                class="absolute -right-10 -bottom-10 w-72 h-72 bg-white/10 rounded-full blur-3xl pointer-events-none">
                            </div>
                            <div
                                class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-amber-300 via-orange-300 to-rose-300">
                            </div>

                            <div class="relative z-10 text-center sm:text-left">
                                <div
                                    class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/20 backdrop-blur-md text-amber-100 text-xs font-black uppercase tracking-wider mb-3 border border-white/25 shadow-sm">
                                    <svg class="w-4 h-4 text-amber-200" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                        </path>
                                    </svg>
                                    Status: Remidi Diperlukan
                                </div>
                                <h3 class="text-2xl sm:text-4xl font-black mb-2 tracking-tight">Perlu Peningkatan Nilai</h3>
                                <p class="text-amber-100 text-sm sm:text-base max-w-xl leading-relaxed">
                                    Nilai Anda saat ini <strong
                                        class="font-extrabold bg-white/25 px-3 py-1 rounded-xl border border-white/20 backdrop-blur-sm">{{ number_format($nilai->nilai_total_soal, 2) }}</strong>
                                    (di bawah KKM 75). Silakan ambil remidi untuk memperbaikinya.
                                </p>
                            </div>
                            @if ($canRetake)
                                <button @click="openModal = true"
                                    data-url="{{ route('user-soal.remedi', [$pelatihan->id, $materi->id]) }}"
                                    type="button"
                                    class="remedi-button relative z-10 px-8 py-4 bg-white text-orange-800 font-extrabold text-sm rounded-2xl shadow-xl shadow-orange-950/20 hover:bg-orange-50 hover:scale-105 active:scale-95 transition-all duration-200 shrink-0 flex items-center gap-3 group">
                                    <span>Mulai Remidi</span>
                                    <svg class="w-5 h-5 transition-transform group-hover:rotate-90" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M4 4v5h5M20 20v-5h-5M4 4l16 16" />
                                    </svg>
                                </button>
                            @else
                                <button id="remidiCountdownButton" disabled
                                    data-url="{{ route('user-soal.remedi', [$pelatihan->id, $materi->id]) }}"
                                    data-expires="{{ \Carbon\Carbon::parse($nilai->updated_at)->addMinutes(1)->timestamp }}"
                                    class="remedi-button relative z-10 px-6 py-4 bg-black/25 backdrop-blur-md text-amber-100 font-semibold text-xs sm:text-sm rounded-2xl shadow-inner shrink-0 flex items-center gap-3 border border-white/15 cursor-not-allowed">
                                    <svg class="w-5 h-5 shrink-0 text-amber-200 animate-spin" fill="none"
                                        viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10"
                                            stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                                    </svg>
                                    <span>Remidi tersedia dalam <span
                                            class="timer-text">{{ \Carbon\Carbon::parse($nilai->updated_at)->addMinutes(1)->diffForHumans(null, true) }}</span></span>
                                </button>
                            @endif
                        </div>
                    @endif
                @else
                    {{-- KONDISI: BELUM MELAKUKAN KUIS --}}
                    <div
                        class="relative overflow-hidden bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-600 rounded-[2.5rem] p-8 sm:p-12 text-white shadow-2xl shadow-indigo-600/30 flex flex-col sm:flex-row items-center justify-between gap-8 border border-indigo-400/40">
                        <div
                            class="absolute -right-16 -bottom-16 w-80 h-80 bg-white/15 rounded-full blur-3xl pointer-events-none">
                        </div>
                        <div
                            class="absolute -left-16 -top-16 w-80 h-80 bg-pink-500/20 rounded-full blur-3xl pointer-events-none">
                        </div>
                        <div
                            class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-indigo-300 via-purple-300 to-pink-300">
                        </div>

                        <div class="relative z-10 text-center sm:text-left">
                            <div
                                class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/20 backdrop-blur-md text-indigo-100 text-xs font-black uppercase tracking-wider mb-3 border border-white/25 shadow-sm">
                                Evaluasi Pembelajaran Interaktif
                            </div>
                            <h3 class="text-2xl sm:text-4xl font-black mb-2 tracking-tight">Siap Menguji Pemahaman Anda?
                            </h3>
                            <p class="text-indigo-100 text-sm sm:text-base max-w-xl leading-relaxed">Anda belum mengerjakan
                                evaluasi untuk materi ini. Klik tombol di samping untuk mulai menjawab rangkaian soal.</p>
                        </div>
                        <button @click="openModal = true"
                            data-url="{{ route('user-soal.index', [$pelatihan->id, $materi->id]) }}" type="button"
                            class="remedi-button relative z-10 px-8 py-4 bg-white text-indigo-700 font-extrabold text-sm rounded-2xl shadow-xl shadow-purple-950/30 hover:bg-indigo-50 hover:scale-105 active:scale-95 transition-all duration-200 shrink-0 flex items-center gap-3 group">
                            <span>Mulai Kuis Sekarang</span>
                            <svg class="w-5 h-5 transition-transform group-hover:translate-x-1.5" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </button>
                    </div>
                @endif
            </div>
        @endif

        {{-- MODAL ATURAN KUIS --}}
        <div x-cloak x-show="openModal"
            class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/80 backdrop-blur-md p-4 overflow-y-auto"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

            <div class="bg-white/95 backdrop-blur-2xl rounded-[2.5rem] max-w-lg w-full p-6 sm:p-8 shadow-[0_25px_60px_rgba(79,70,229,0.25)] border border-indigo-50 transform transition-all my-8 relative overflow-hidden"
                @click.away="openModal = false" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-6 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-6 sm:scale-95">

                {{-- Aksen Gradient Top Modal --}}
                <div class="absolute top-0 left-0 right-0 h-2 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500">
                </div>
                <div
                    class="absolute -right-16 -top-16 w-48 h-48 bg-indigo-500/10 rounded-full blur-2xl pointer-events-none">
                </div>

                {{-- Header Modal --}}
                <div class="flex items-center justify-between pb-5 border-b border-slate-100 mb-6 mt-2 relative z-10">
                    <div class="flex items-center gap-3.5">
                        <div
                            class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-indigo-600 via-purple-600 to-pink-600 flex items-center justify-center text-white shadow-lg shadow-indigo-500/30">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3
                                class="text-xl font-black bg-clip-text text-transparent bg-gradient-to-r from-slate-900 to-indigo-950 tracking-tight">
                                Aturan & Ketentuan Kuis</h3>
                            <p class="text-xs text-slate-500 font-bold">Harap baca dengan teliti sebelum mulai</p>
                        </div>
                    </div>
                    <button @click="openModal = false"
                        class="w-10 h-10 rounded-2xl bg-slate-100 hover:bg-rose-50 text-slate-500 hover:text-rose-600 flex items-center justify-center transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                {{-- Daftar Aturan (List dengan Gradasi Halus) --}}
                <div class="space-y-3.5 mb-8 text-slate-600 text-sm relative z-10">
                    <div
                        class="flex items-start gap-3.5 p-4 rounded-2xl bg-gradient-to-r from-indigo-50/60 to-purple-50/20 border border-indigo-100/60 transition hover:shadow-md">
                        <span
                            class="flex-shrink-0 w-7 h-7 rounded-xl bg-gradient-to-br from-indigo-600 to-indigo-700 text-white flex items-center justify-center font-black text-xs shadow-md shadow-indigo-500/30 mt-0.5">1</span>
                        <p class="leading-relaxed"><strong class="text-slate-900 font-extrabold">Waktu Pengerjaan
                                Terbatas:</strong> Durasi waktu ujian ini adalah <strong
                                class="text-indigo-600 font-extrabold">5 menit</strong> dan berjalan mundur sejak halaman
                            dibuka.</p>
                    </div>
                    <div
                        class="flex items-start gap-3.5 p-4 rounded-2xl bg-gradient-to-r from-indigo-50/60 to-purple-50/20 border border-indigo-100/60 transition hover:shadow-md">
                        <span
                            class="flex-shrink-0 w-7 h-7 rounded-xl bg-gradient-to-br from-purple-600 to-violet-700 text-white flex items-center justify-center font-black text-xs shadow-md shadow-purple-500/30 mt-0.5">2</span>
                        <p class="leading-relaxed"><strong class="text-slate-900 font-extrabold">Auto-Submit:</strong>
                            Jika durasi waktu habis (00:00), sistem secara otomatis menutup dan menyimpan jawaban Anda.</p>
                    </div>
                    <div
                        class="flex items-start gap-3.5 p-4 rounded-2xl bg-gradient-to-r from-rose-50/80 to-orange-50/40 border border-rose-200/60 transition hover:shadow-md">
                        <span
                            class="flex-shrink-0 w-7 h-7 rounded-xl bg-gradient-to-br from-rose-600 to-red-700 text-white flex items-center justify-center font-black text-xs shadow-md shadow-rose-500/30 mt-0.5">3</span>
                        <p class="leading-relaxed text-rose-950"><strong class="text-rose-900 font-extrabold">Larangan
                                Berpindah Tab:</strong> Berpindah tab atau keluar dari halaman ujian akan memberhentikan
                            kuis dan Anda dianggap <strong class="font-black underline decoration-rose-500">tidak
                                lolos</strong>.</p>
                    </div>
                    <div
                        class="flex items-start gap-3.5 p-4 rounded-2xl bg-gradient-to-r from-amber-50/80 to-yellow-50/40 border border-amber-200/60 transition hover:shadow-md">
                        <span
                            class="flex-shrink-0 w-7 h-7 rounded-xl bg-gradient-to-br from-amber-500 to-orange-600 text-white flex items-center justify-center font-black text-xs shadow-md shadow-amber-500/30 mt-0.5">4</span>
                        <p class="leading-relaxed text-amber-950"><strong class="text-amber-900 font-extrabold">Standar
                                Kelulusan:</strong> Jika nilai akhir Anda berada <strong
                                class="underline decoration-amber-500 decoration-2 font-black">di bawah KKM (75)</strong>,
                            Anda wajib mengulang dan akses terbuka kembali setelah <strong class="font-extrabold">1
                                menit</strong>.</p>
                    </div>
                    <div
                        class="flex items-start gap-3.5 p-4 rounded-2xl bg-gradient-to-r from-indigo-50/60 to-purple-50/20 border border-indigo-100/60 transition hover:shadow-md">
                        <span
                            class="flex-shrink-0 w-7 h-7 rounded-xl bg-gradient-to-br from-pink-600 to-rose-600 text-white flex items-center justify-center font-black text-xs shadow-md shadow-pink-500/30 mt-0.5">5</span>
                        <p class="leading-relaxed"><strong class="text-slate-900 font-extrabold">Jawab dengan
                                Teliti:</strong> Pastikan seluruh pertanyaan telah terisi dengan benar sebelum menekan
                            tombol kumpul.</p>
                    </div>
                </div>

                {{-- Footer / Tombol Aksi Modal --}}
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100 relative z-10">
                    <button @click="openModal = false" type="button"
                        class="px-5 py-3 rounded-2xl border border-slate-200 text-slate-600 hover:bg-slate-100 font-bold text-sm transition-all">
                        Batal
                    </button>
                    <a id="start-quiz-link" href="#"
                        class="px-7 py-3.5 bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 hover:from-indigo-700 hover:to-pink-700 text-white font-extrabold text-sm rounded-2xl shadow-xl shadow-purple-600/30 transition-all hover:scale-[1.02] active:scale-95 flex items-center gap-2">
                        <span>Saya Mengerti, Mulai Kuis</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                </div>

            </div>
        </div>

    </div>
    @push('scripts')
        <script>
            function updateTimerDisplay(button, secondsLeft) {
                const textEl = button.querySelector('.timer-text');
                if (!textEl) return;
                if (secondsLeft <= 0) {
                    textEl.textContent = 'Mulai Remidi';
                    button.disabled = false;
                    button.classList.remove('bg-black/25', 'cursor-not-allowed');
                    button.classList.add('bg-white', 'text-orange-800', 'hover:bg-orange-50', 'cursor-pointer');
                    button.querySelector('svg').classList.remove('animate-spin');
                    button.addEventListener('click', function() {
                        window.location.href = this.dataset.url;
                    }, {
                        once: true
                    });
                    return;
                }

                const minutes = Math.floor(secondsLeft / 60);
                const seconds = secondsLeft % 60;
                textEl.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            }

            function startRemidiTimer() {
                const button = document.getElementById('remidiCountdownButton');
                if (!button) return;

                const expiresAt = parseInt(button.dataset.expires, 10) * 1000;
                const timer = setInterval(() => {
                    const now = Date.now();
                    const secondsLeft = Math.max(0, Math.ceil((expiresAt - now) / 1000));

                    updateTimerDisplay(button, secondsLeft);

                    if (secondsLeft <= 0) {
                        clearInterval(timer);
                    }
                }, 1000);
            }

            document.addEventListener('DOMContentLoaded', function() {
                const modalLink = document.getElementById('start-quiz-link');
                document.querySelectorAll('.remedi-button').forEach(button => {
                    button.addEventListener('click', function() {
                        modalLink.href = this.dataset.url;
                    });
                });

                startRemidiTimer();
            });
        </script>
    @endpush
@endsection
