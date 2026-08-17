@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8 relative overflow-hidden max-w-5xl" x-data="{ openModal: false }">

        {{-- Latar Belakang Dekoratif Glow Abstrak (Nuansa Emas/Amber) --}}
        <div
            class="absolute top-10 left-1/4 w-72 h-72 sm:w-96 sm:h-96 bg-[#FFD700]/10 dark:bg-[#FFD700]/5 rounded-full blur-3xl pointer-events-none -z-10">
        </div>
        <div
            class="absolute top-64 right-10 w-64 h-64 sm:w-80 sm:h-80 bg-amber-600/10 dark:bg-amber-600/5 rounded-full blur-3xl pointer-events-none -z-10">
        </div>

        {{-- Tombol Kembali ke Daftar Pelatihan --}}
        <div class="mb-5">
            <a href="{{ route('user-materi.index', $pelatihan->id) }}"
                class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white/80 dark:bg-slate-900/80 backdrop-blur-xl border border-slate-200/80 dark:border-slate-800 text-slate-600 dark:text-slate-300 hover:text-[#b39700] dark:hover:text-[#FFD700] hover:border-[#FFD700]/40 dark:hover:border-[#FFD700]/40 font-bold text-xs shadow-xs transition-all duration-200 group">
                <div
                    class="w-5 h-5 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 group-hover:bg-[#FFD700] group-hover:text-slate-950 flex items-center justify-center transition-all duration-200">
                    <svg class="w-3 h-3 transition-transform group-hover:-translate-x-0.5" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </div>
                <span>Kembali ke Daftar Materi</span>
            </a>
        </div>

        {{-- Main Card Materi --}}
        <div
            class="bg-white/80 dark:bg-slate-900/80 backdrop-blur-2xl rounded-[2.5rem] shadow-xl shadow-slate-200/50 dark:shadow-none border border-slate-200/80 dark:border-slate-800 overflow-hidden mb-8 transition-all relative z-10">

            {{-- Aksen Garis Atas Kartu (Emas) --}}
            <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-[#FFD700] to-amber-600"></div>

            {{-- Header Materi --}}
            <div
                class="p-6 sm:p-10 border-b border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/30 relative">
                <div
                    class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-[#FFD700]/10 text-[#b39700] dark:text-[#FFD700] text-xs font-bold uppercase tracking-wider mb-4 border border-[#FFD700]/30">
                    <span class="w-2 h-2 rounded-full bg-[#FFD700] animate-pulse"></span>
                    Pelatihan: {{ $pelatihan->judul }}
                </div>
                <h1 class="text-2xl sm:text-4xl font-extrabold text-slate-900 dark:text-white tracking-tight leading-snug">
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
                                class="w-20 h-20 mx-auto mb-6 rounded-3xl bg-[#FFD700]/20 border border-[#FFD700]/30 flex items-center justify-center text-[#FFD700] shadow-xl shadow-[#FFD700]/10 backdrop-blur-xl animate-bounce">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                            </div>
                            <p class="text-lg font-bold mb-3 text-slate-200">File Lampiran Tersedia</p>
                            <a href="{{ $filePath }}" target="_blank"
                                class="px-7 py-3.5 bg-[#FFD700] hover:bg-[#e6c200] text-slate-950 rounded-xl text-xs font-bold transition-all shadow-lg shadow-[#FFD700]/25 inline-flex items-center gap-2.5 hover:scale-105 active:scale-95">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
            <div class="p-6 sm:p-10">
                <h3 class="text-lg sm:text-xl font-extrabold text-slate-900 dark:text-white mb-4 flex items-center gap-3">
                    <span class="w-2 h-6 bg-[#FFD700] rounded-full"></span>
                    <span>Deskripsi & Isi Materi</span>
                </h3>
                <div
                    class="prose dark:prose-invert max-w-none text-slate-700 dark:text-slate-200 leading-relaxed whitespace-pre-line space-y-4 text-xs sm:text-sm font-normal">
                    {!! $materi->deskripsi !!}
                </div>
            </div>
        </div>

        {{-- Bagian Ujian / Soal (Tombol Pemicu Modal Kuis) --}}
        @if (isset($materi->soal) && $materi->soal->count() > 0)
            <div class="relative z-10">
                @if (isset($nilai))
                    @if ($nilai->nilai_total_soal >= 75)
                        {{-- KONDISI: LULUS (nilai_total_soal >= 75) --}}
                        <div
                            class="relative overflow-hidden bg-gradient-to-r from-emerald-600 to-teal-600 rounded-[2.5rem] p-6 sm:p-10 text-white shadow-xl shadow-emerald-500/20 flex flex-col sm:flex-row items-center justify-between gap-6 sm:gap-8 border border-emerald-500/30">
                            <div
                                class="absolute -right-10 -bottom-10 w-72 h-72 bg-white/10 rounded-full blur-3xl pointer-events-none">
                            </div>

                            <div class="relative z-10 text-center sm:text-left">
                                <div
                                    class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/20 backdrop-blur-md text-emerald-100 text-xs font-bold uppercase tracking-wider mb-3 border border-white/25 shadow-sm">
                                    <svg class="w-4 h-4 text-emerald-200" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Status: Lulus Berkompeten
                                </div>
                                <h3 class="text-xl sm:text-3xl font-extrabold mb-2 tracking-tight">Selamat, Anda Lulus!</h3>
                                <p class="text-emerald-50 text-xs sm:text-sm max-w-xl leading-relaxed">
                                    Skor total ujian Anda: <strong
                                        class="text-base sm:text-lg font-black bg-white/20 px-3.5 py-0.5 rounded-xl inline-block ml-1 shadow-inner border border-white/25 backdrop-blur-sm">{{ number_format($nilai->nilai_total_soal, 2) }}</strong>
                                </p>
                            </div>
                        </div>
                    @else
                        {{-- KONDISI: REMIDI (nilai_total_soal < 75) --}}
                        @php
                            $canRetake = \Carbon\Carbon::parse($nilai->updated_at)->addMinutes(1)->isPast();
                        @endphp
                        <div
                            class="relative overflow-hidden bg-gradient-to-r from-amber-600 to-[#b39700] rounded-[2.5rem] p-6 sm:p-10 text-white shadow-xl shadow-[#FFD700]/20 flex flex-col sm:flex-row items-center justify-between gap-6 sm:gap-8 border border-[#FFD700]/30">
                            <div
                                class="absolute -right-10 -bottom-10 w-72 h-72 bg-white/10 rounded-full blur-3xl pointer-events-none">
                            </div>

                            <div class="relative z-10 text-center sm:text-left">
                                <div
                                    class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/20 backdrop-blur-md text-amber-100 text-xs font-bold uppercase tracking-wider mb-3 border border-white/25 shadow-sm">
                                    <svg class="w-4 h-4 text-amber-200" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                        </path>
                                    </svg>
                                    Status: Remidi Diperlukan
                                </div>
                                <h3 class="text-xl sm:text-3xl font-extrabold mb-2 tracking-tight">Perlu Peningkatan Nilai
                                </h3>
                                <p class="text-amber-50 text-xs sm:text-sm max-w-xl leading-relaxed">
                                    Nilai Anda saat ini <strong
                                        class="font-bold bg-white/20 px-2.5 py-0.5 rounded-lg border border-white/20 backdrop-blur-sm">{{ number_format($nilai->nilai_total_soal, 2) }}</strong>
                                    (di bawah KKM 75). Silakan ambil remidi untuk memperbaikinya.
                                </p>
                            </div>
                            @if ($canRetake)
                                <button @click="openModal = true"
                                    data-url="{{ route('user-soal.remedi', [$pelatihan->id, $materi->id]) }}"
                                    type="button"
                                    class="remedi-button relative z-10 px-7 py-3.5 bg-[#FFD700] text-slate-950 font-bold text-xs sm:text-sm rounded-2xl shadow-lg hover:bg-[#e6c200] hover:scale-105 active:scale-95 transition-all duration-200 shrink-0 flex items-center gap-2.5 group">
                                    <span>Mulai Remidi</span>
                                    <svg class="w-4 h-4 transition-transform group-hover:rotate-90" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M4 4v5h5M20 20v-5h-5M4 4l16 16" />
                                    </svg>
                                </button>
                            @else
                                <button id="remidiCountdownButton" disabled
                                    data-url="{{ route('user-soal.remedi', [$pelatihan->id, $materi->id]) }}"
                                    data-expires="{{ \Carbon\Carbon::parse($nilai->updated_at)->addMinutes(1)->timestamp }}"
                                    class="remedi-button relative z-10 px-6 py-3.5 bg-black/25 backdrop-blur-md text-amber-100 font-semibold text-xs sm:text-sm rounded-2xl shadow-inner shrink-0 flex items-center gap-2.5 border border-white/15 cursor-not-allowed">
                                    <svg class="w-4 h-4 shrink-0 text-[#FFD700] animate-spin" fill="none"
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
                        class="relative overflow-hidden bg-gradient-to-r from-amber-600 to-[#b39700] rounded-[2.5rem] p-6 sm:p-10 text-white shadow-xl shadow-[#FFD700]/20 flex flex-col sm:flex-row items-center justify-between gap-6 sm:gap-8 border border-[#FFD700]/30">
                        <div
                            class="absolute -right-10 -bottom-10 w-72 h-72 bg-white/10 rounded-full blur-3xl pointer-events-none">
                        </div>

                        <div class="relative z-10 text-center sm:text-left">
                            <div
                                class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/20 backdrop-blur-md text-white text-xs font-bold uppercase tracking-wider mb-3 border border-white/30 shadow-sm">
                                Evaluasi Pembelajaran Interaktif
                            </div>
                            <h3 class="text-xl sm:text-3xl font-extrabold mb-2 tracking-tight">Siap Menguji Pemahaman Anda?
                            </h3>
                            <p class="text-amber-50 text-xs sm:text-sm max-w-xl leading-relaxed">Anda belum mengerjakan
                                evaluasi untuk materi ini. Klik tombol di samping untuk mulai menjawab rangkaian soal.</p>
                        </div>
                        <button @click="openModal = true"
                            data-url="{{ route('user-soal.index', [$pelatihan->id, $materi->id]) }}" type="button"
                            class="remedi-button relative z-10 px-7 py-3.5 bg-[#FFD700] text-slate-950 hover:bg-[#e6c200] font-bold text-xs sm:text-sm rounded-2xl shadow-lg hover:scale-105 active:scale-95 transition-all duration-200 shrink-0 flex items-center gap-2.5 group">
                            <span>Mulai Kuis Sekarang</span>
                            <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none"
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
            class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/70 backdrop-blur-sm p-4 overflow-y-auto"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

            <div class="bg-white dark:bg-slate-900 rounded-[2rem] max-w-lg w-full p-6 sm:p-8 shadow-2xl border border-slate-200 dark:border-slate-800 transform transition-all my-8 relative overflow-hidden"
                @click.away="openModal = false" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-6 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-6 sm:scale-95">

                {{-- Header Modal --}}
                <div
                    class="flex items-center justify-between pb-4 border-b border-slate-100 dark:border-slate-800 mb-5 relative z-10">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-10 h-10 rounded-xl bg-[#FFD700]/10 text-[#b39700] dark:text-[#FFD700] flex items-center justify-center border border-[#FFD700]/20 font-bold">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base sm:text-lg font-extrabold text-slate-900 dark:text-white tracking-tight">
                                Aturan & Ketentuan Kuis</h3>
                            <p class="text-[11px] text-slate-400">Harap baca dengan teliti sebelum mulai</p>
                        </div>
                    </div>
                    <button @click="openModal = false"
                        class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                {{-- Daftar Aturan --}}
                <div class="space-y-3 mb-6 text-slate-600 dark:text-slate-300 text-xs sm:text-sm relative z-10">
                    <div
                        class="flex items-start gap-3 p-3.5 rounded-xl bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-800">
                        <span
                            class="flex-shrink-0 w-6 h-6 rounded-lg bg-[#FFD700] text-slate-950 flex items-center justify-center font-bold text-xs mt-0.5">1</span>
                        <p class="leading-relaxed"><strong class="text-slate-800 dark:text-slate-200 font-bold">Waktu
                                Pengerjaan Terbatas:</strong> Durasi waktu ujian ini adalah <strong
                                class="text-[#b39700] dark:text-[#FFD700] font-bold">5 menit</strong> dan berjalan mundur
                            sejak halaman dibuka.</p>
                    </div>
                    <div
                        class="flex items-start gap-3 p-3.5 rounded-xl bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-800">
                        <span
                            class="flex-shrink-0 w-6 h-6 rounded-lg bg-[#FFD700] text-slate-950 flex items-center justify-center font-bold text-xs mt-0.5">2</span>
                        <p class="leading-relaxed"><strong
                                class="text-slate-800 dark:text-slate-200 font-bold">Auto-Submit:</strong> Jika durasi
                            waktu habis (00:00), sistem secara otomatis menutup dan menyimpan jawaban Anda.</p>
                    </div>
                    <div
                        class="flex items-start gap-3 p-3.5 rounded-xl bg-red-50/60 dark:bg-red-950/30 border border-red-200/60 dark:border-red-900/50">
                        <span
                            class="flex-shrink-0 w-6 h-6 rounded-lg bg-red-600 text-white flex items-center justify-center font-bold text-xs mt-0.5">3</span>
                        <p class="leading-relaxed text-red-900 dark:text-red-300"><strong class="font-bold">Larangan
                                Berpindah Tab:</strong> Berpindah tab atau keluar dari halaman ujian akan memberhentikan
                            kuis dan Anda dianggap <strong class="underline decoration-red-500">tidak lolos</strong>.</p>
                    </div>
                    <div
                        class="flex items-start gap-3 p-3.5 rounded-xl bg-amber-50/60 dark:bg-amber-950/30 border border-amber-200/60 dark:border-amber-900/50">
                        <span
                            class="flex-shrink-0 w-6 h-6 rounded-lg bg-amber-500 text-white flex items-center justify-center font-bold text-xs mt-0.5">4</span>
                        <p class="leading-relaxed text-amber-900 dark:text-amber-300"><strong class="font-bold">Standar
                                Kelulusan:</strong> Jika nilai akhir Anda berada <strong
                                class="underline decoration-amber-500">di bawah KKM (75)</strong>, Anda wajib mengulang dan
                            akses terbuka kembali setelah <strong class="font-bold">1 menit</strong>.</p>
                    </div>
                </div>

                {{-- Footer / Tombol Aksi Modal --}}
                <div
                    class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100 dark:border-slate-800 relative z-10">
                    <button @click="openModal = false" type="button"
                        class="px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 font-bold text-xs transition-all">
                        Batal
                    </button>
                    <a id="start-quiz-link" href="#"
                        class="px-5 py-2.5 bg-[#FFD700] hover:bg-[#e6c200] text-slate-950 font-bold text-xs rounded-xl shadow-md shadow-[#FFD700]/25 transition-all hover:scale-[1.02] active:scale-95 flex items-center gap-2">
                        <span>Saya Mengerti, Mulai Kuis</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                    button.classList.add('bg-[#FFD700]', 'text-slate-950', 'hover:bg-[#e6c200]', 'cursor-pointer');
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
