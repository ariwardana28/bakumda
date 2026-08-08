@extends('layouts.admin')

@section('content')
    <div class="container mx-auto px-4 py-8 max-w-7xl" x-data="{ answeredCount: 0 }">

        {{-- Layout 2 Kolom: Kiri untuk Info/Timer (Sticky), Kanan untuk Soal Kuis --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            {{-- KOLOM KIRI: Informasi Materi, Status, Tombol Fullscreen, & Timer (Sticky) --}}
            <div class="lg:col-span-4 lg:sticky lg:top-6 space-y-6 z-30">
                <div class="bg-white/90 backdrop-blur-xl rounded-3xl p-6 shadow-xl shadow-slate-100 border border-slate-100 flex flex-col gap-6 transition-all">
                    
                    {{-- Judul & Status Materi --}}
                    <div class="text-left">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-blue-50 text-blue-600 text-xs font-bold uppercase tracking-wider mb-3 border border-blue-100/60 shadow-sm">
                            <span class="w-2 h-2 rounded-full bg-blue-600 animate-pulse"></span>
                            Evaluasi Materi (Secure Mode)
                        </span>
                        <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight leading-snug">{{ $materi->judul }}</h1>
                    </div>

                    {{-- Kotak Timer Mundur --}}
                    <div id="timer-container" class="flex items-center gap-3 px-5 py-4 bg-blue-50/80 backdrop-blur border border-blue-200/60 rounded-2xl text-blue-700 font-extrabold shadow-sm transition-all duration-300 w-full justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-blue-600 text-white flex items-center justify-center shadow-md shadow-blue-500/20 shrink-0">
                                <svg class="w-5 h-5 animate-spin-slow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="flex flex-col text-left">
                                <span class="text-[10px] text-slate-400 uppercase tracking-widest font-bold">Sisa Waktu</span>
                                <span id="countdown" class="text-lg tracking-tight">05:00</span>
                            </div>
                        </div>
                    </div>

                    {{-- Tombol Fullscreen Manual (Jika keluar fullscreen) --}}
                    <button type="button" id="btn-fullscreen" onclick="toggleFullscreen()" class="w-full px-4 py-3 bg-slate-900 text-white text-xs font-bold rounded-xl hover:bg-blue-600 transition shadow-sm hidden">
                        Fullscreen-kan Layar
                    </button>

                    <div class="text-xs text-slate-400 font-medium leading-relaxed border-t border-slate-100 pt-4">
                        * Dilarang keluar dari mode fullscreen, beralih tab browser, atau me-refresh halaman selama ujian berlangsung.
                    </div>
                </div>
            </div>

            {{-- KOLOM KANAN: Form Soal Kuis --}}
            <div class="lg:col-span-8">
                <form id="quiz-form" action="{{ route('user-soal.store', [$pelatihan->id, $materi->id]) }}" method="POST">
                    @csrf

                    <div class="space-y-6">
                        @forelse($materi->soal as $index => $item)
                            <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-xl shadow-slate-100/70 border border-slate-100 transition-all duration-300 hover:shadow-2xl hover:shadow-slate-200/50 group">
                                
                                {{-- Pertanyaan --}}
                                <div class="flex items-start gap-4 mb-6">
                                    <span class="flex-shrink-0 w-10 h-10 flex items-center justify-center bg-gradient-to-tr from-slate-100 to-slate-200 text-slate-700 rounded-2xl font-black text-sm shadow-sm group-hover:from-blue-600 group-hover:to-indigo-600 group-hover:text-white transition-all duration-300">
                                        {{ $index + 1 }}
                                    </span>
                                    <div class="text-slate-900 font-bold text-base sm:text-lg leading-relaxed pt-1.5">
                                        {{ $item->soal }}
                                    </div>
                                </div>

                                {{-- Pilihan Opsi Jawaban (A, B, C, D, E) Diacak juga --}}
                                <div class="space-y-3 pl-0 sm:pl-14">
                                    @php $opsiKeys = ['a', 'b', 'c', 'd', 'e']; @endphp

                                    @foreach($item->jawaban as $jawabanIndex => $jawaban)
                                        @if(isset($opsiKeys[$jawabanIndex]))
                                            <label class="relative flex items-center gap-4 p-4 rounded-2xl border border-slate-200/80 bg-slate-50/40 hover:bg-blue-50/40 hover:border-blue-400 cursor-pointer transition-all duration-200 shadow-sm">
                                                <input type="radio" 
                                                       name="jawaban[{{ $item->id }}]" 
                                                       value="{{ $jawaban->id }}" 
                                                       class="peer sr-only">
                                                
                                                {{-- Custom Radio Circle Indicator --}}
                                                <div class="w-5 h-5 rounded-full border-2 border-slate-300 peer-checked:border-blue-600 peer-checked:bg-blue-600 flex items-center justify-center transition-all duration-200 shrink-0 shadow-sm">
                                                    <div class="w-2 h-2 rounded-full bg-white scale-0 peer-checked:scale-100 transition-transform duration-200"></div>
                                                </div>

                                                <span class="text-slate-700 font-medium text-sm sm:text-base select-none flex-1">
                                                    <strong class="uppercase mr-2 px-2 py-0.5 rounded-lg bg-slate-200/60 text-slate-700 font-bold text-xs peer-checked:bg-blue-100 peer-checked:text-blue-700">{{ $opsiKeys[$jawabanIndex] }}</strong> 
                                                    {{ $jawaban->jawaban }}
                                                </span>

                                                {{-- Active Overlay Highlight for Label --}}
                                                <div class="absolute inset-0 rounded-2xl border-2 border-blue-600 opacity-0 peer-checked:opacity-100 pointer-events-none transition-opacity duration-200 bg-blue-50/10"></div>
                                            </label>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-20 bg-white rounded-3xl border border-dashed border-slate-200 shadow-sm">
                                <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-slate-100 flex items-center justify-center text-slate-400">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                </div>
                                <p class="text-slate-500 font-medium text-base">Belum ada soal yang tersedia untuk materi ini.</p>
                            </div>
                        @endforelse

                        {{-- Tombol Kirim Jawaban --}}
                        @if(isset($materi->soal) && $materi->soal->count() > 0)
                            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-6 bg-white/50 backdrop-blur p-6 rounded-3xl border border-slate-100">
                                <div class="text-xs text-slate-500 font-medium text-center sm:text-left">
                                    Pastikan semua pertanyaan telah dijawab sebelum mengirimkan.
                                </div>
                                <button type="submit" onclick="isSubmitted = true;" class="w-full sm:w-auto px-8 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-extrabold text-sm rounded-2xl shadow-xl shadow-blue-600/30 transition-all duration-200 hover:scale-[1.02] active:scale-95 flex items-center justify-center gap-3 group">
                                    <span>Selesai & Kumpulkan Jawaban</span>
                                    <svg class="w-5 h-5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                    </svg>
                                </button>
                            </div>
                        @endif
                    </div>
                </form>
            </div>

        </div>
    </div>

    {{-- Script JavaScript untuk Timer Real-Time, Fullscreen, Proteksi Tab, dan Anti-Refresh --}}
    @push('scripts')
    <script>
        let isSubmitted = false;
        let warningCount = 0;
        const maxWarnings = 2; // Batas maksimal melanggar sebelum auto submit

        function toggleFullscreen() {
            if (!document.fullscreenElement) {
                document.documentElement.requestFullscreen().catch(err => {
                    console.log("Error attempting to enable fullscreen:", err.message);
                });
            }
        }

        document.addEventListener("DOMContentLoaded", function () {
            // 1. Deteksi Refresh / Reload Halaman menggunakan Performance Navigation API
            const perfEntries = performance.getEntriesByType("navigation");
            if (perfEntries.length > 0 && perfEntries[0].type === "reload") {
                alert("PERHATIAN: Me-refresh halaman selama ujian adalah pelanggaran! Soal telah diacak ulang.");
            }

            // 2. Cegah tombol F5 / Ctrl+R / Cmd+R agar tidak disalahgunakan untuk refresh manual
            document.addEventListener("keydown", function (e) {
                if (e.key === "F5" || (e.ctrlKey && e.key === "r") || (e.metaKey && e.key === "r")) {
                    e.preventDefault();
                    alert("Tombol Refresh (F5 / Reload) dikunci selama ujian berlangsung!");
                }
            });

            // 3. Paksa masuk Fullscreen saat halaman dimuat
            toggleFullscreen();
            
            // Deteksi jika user keluar dari fullscreen
            document.addEventListener("fullscreenchange", function () {
                if (!document.fullscreenElement && !isSubmitted) {
                    document.getElementById("btn-fullscreen").classList.remove("hidden");
                    alert("PERHATIAN: Anda keluar dari mode Fullscreen! Harap kembali ke mode fullscreen untuk melanjutkan ujian.");
                } else {
                    document.getElementById("btn-fullscreen").classList.add("hidden");
                }
            });

            // 4. Proteksi Pindah Tab / Minimalkan Browser (Visibility API)
            document.addEventListener("visibilitychange", function () {
                if (document.hidden && !isSubmitted) {
                    warningCount++;
                    if (warningCount <= maxWarnings) {
                        alert(`PERINGATAN (${warningCount}/${maxWarnings}): Anda terdeteksi mencoba membuka tab/aplikasi lain! Ujian ini harus dikerjakan tanpa beralih halaman.`);
                        toggleFullscreen();
                    } else {
                        alert("Anda telah melanggar aturan ujian berkali-kali. Ujian akan dikirimkan secara otomatis.");
                        isSubmitted = true;
                        localStorage.removeItem("quiz_end_time_{{ $materi->id }}");
                        document.getElementById("quiz-form").submit();
                    }
                }
            });

            // 5. Timer Mundur Real-Time Murni Berbasis Waktu Sistem
            const durationInSeconds = 300; // 5 Menit (bisa disesuaikan dari backend misal: {{ $materi->durasi * 60 }})
            const countdownElement = document.getElementById("countdown");
            const quizForm = document.getElementById("quiz-form");
            const timerContainer = document.getElementById("timer-container");

            // Buat kunci unik localStorage per materi agar tidak bentrok antar halaman ujian
            const storageKey = "quiz_end_time_{{ $materi->id }}";
            let endTime = localStorage.getItem(storageKey);
            const now = Date.now();

            // Jika belum ada atau waktu sebelumnya sudah lewat, buat target waktu baru dari detik ini
            if (!endTime || parseInt(endTime) < now) {
                endTime = now + (durationInSeconds * 1000);
                localStorage.setItem(storageKey, endTime);
            }

            const realTimeInterval = setInterval(function () {
                const currentTime = Date.now();
                const timeLeft = Math.max(0, Math.floor((parseInt(endTime) - currentTime) / 1000));

                let minutes = Math.floor(timeLeft / 60);
                let seconds = timeLeft % 60;

                minutes = minutes < 10 ? "0" + minutes : minutes;
                seconds = seconds < 10 ? "0" + seconds : seconds;

                countdownElement.textContent = `${minutes}:${seconds}`;

                // Ubah warna container jadi merah saat sisa waktu <= 60 detik (1 menit)
                if (timeLeft <= 60) {
                    timerContainer.classList.remove("bg-blue-50/80", "border-blue-200/60", "text-blue-700");
                    timerContainer.classList.add("bg-red-50", "border-red-200", "text-red-600", "animate-pulse");
                }

                // Jika waktu habis
                if (timeLeft <= 0) {
                    clearInterval(realTimeInterval);
                    localStorage.removeItem(storageKey);
                    if (!isSubmitted) {
                        isSubmitted = true;
                        alert("Waktu ujian telah habis! Jawaban Anda akan disimpan secara otomatis.");
                        quizForm.submit();
                    }
                }
            }, 1000);

            // Bersihkan localStorage saat form berhasil dikirim secara normal
            quizForm.addEventListener("submit", function() {
                localStorage.removeItem(storageKey);
            });
        });
    </script>
    @endpush
@endsection