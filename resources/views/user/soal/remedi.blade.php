@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-6 max-w-7xl" x-data="{ answeredCount: 0 }">

        {{-- Layout 2 Kolom: Kiri untuk Info/Timer (Sticky), Kanan untuk Soal Kuis --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

            {{-- KOLOM KIRI: Informasi Materi, Status, Tombol Fullscreen, & Timer (Sticky) --}}
            <div class="lg:col-span-4 sticky top-4 self-start space-y-4 z-30">
                <div
                    class="bg-white/90 backdrop-blur-xl rounded-2xl p-5 shadow-lg shadow-slate-100 border border-slate-100 flex flex-col gap-4 transition-all">

                    {{-- Judul & Status Materi --}}
                    <div class="text-left">
                        <span
                            class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-amber-50 text-amber-600 text-[10px] font-bold uppercase tracking-wider mb-2 border border-amber-100/60 shadow-sm">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-600 animate-pulse"></span>
                            Remidi Kuis (Secure Mode)
                        </span>
                        <h1 class="text-base sm:text-lg font-black text-slate-900 tracking-tight leading-snug">
                            {{ $materi->judul }}</h1>
                        <p class="text-[11px] text-slate-500 mt-1 font-medium">
                            Nilai Sebelumnya: <span
                                class="font-bold text-slate-700">{{ number_format($nilai->nilai_total_soal, 2) }}</span>
                            (Minimal Kelulusan: 75)
                        </p>
                    </div>

                    {{-- Kotak Timer Mundur --}}
                    <div id="timer-container"
                        class="flex items-center gap-3 px-4 py-3 bg-amber-50/80 backdrop-blur border border-amber-200/60 rounded-xl text-amber-700 font-extrabold shadow-sm transition-all duration-300 w-full justify-between">
                        <div class="flex items-center gap-2.5">
                            <div
                                class="w-8 h-8 rounded-lg bg-amber-600 text-white flex items-center justify-center shadow-md shadow-amber-500/20 shrink-0">
                                <svg class="w-4 h-4 animate-spin-slow" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="flex flex-col text-left">
                                <span class="text-[9px] text-slate-400 uppercase tracking-widest font-bold">Sisa Waktu
                                    Remidi</span>
                                <span id="countdown" class="text-sm tracking-tight">05:00</span>
                            </div>
                        </div>
                    </div>

                    {{-- Tombol Fullscreen Manual (Jika keluar fullscreen) --}}
                    <button type="button" id="btn-fullscreen" onclick="toggleFullscreen()"
                        class="w-full px-3 py-2 bg-slate-900 text-white text-[11px] font-bold rounded-xl hover:bg-amber-600 transition shadow-sm hidden">
                        Fullscreen-kan Layar
                    </button>

                    <div class-[11px] text-slate-400 font-medium leading-relaxed border-t border-slate-100 pt-3">
                        * Perhatian: Nilai remidi hanya memperbarui skor jika lebih tinggi/sama dengan nilai sebelumnya.
                        Dilarang keluar fullscreen atau beralih tab.
                    </div>
                </div>
            </div>

            {{-- KOLOM KANAN: Form Soal Kuis Remidi --}}
            <div class="lg:col-span-8">
                <form id="quiz-form" action="{{ route('user-soal.store-remedi', [$pelatihan->id, $materi->id]) }}"
                    method="POST">
                    @csrf

                    <div class="space-y-4">
                        @forelse($materi->soal as $index => $item)
                            <div
                                class="bg-white rounded-2xl p-5 sm:p-6 shadow-md shadow-slate-100/70 border border-slate-100 transition-all duration-300 hover:shadow-xl hover:shadow-slate-200/50 group">

                                {{-- Pertanyaan --}}
                                <div class="flex items-start gap-3 mb-4">
                                    <span
                                        class="flex-shrink-0 w-8 h-8 flex items-center justify-center bg-gradient-to-tr from-slate-100 to-slate-200 text-slate-700 rounded-xl font-black text-xs shadow-sm group-hover:from-amber-600 group-hover:to-orange-600 group-hover:text-white transition-all duration-300">
                                        {{ $index + 1 }}
                                    </span>
                                    <div class="text-slate-900 font-semibold text-xs sm:text-sm leading-relaxed pt-1">
                                        {{ $item->soal }}
                                    </div>
                                </div>

                                {{-- Pilihan Opsi Jawaban (A, B, C, D, E) Diacak --}}
                                <div class="space-y-2 pl-0 sm:pl-11">
                                    @php $opsiKeys = ['a', 'b', 'c', 'd', 'e']; @endphp

                                    @foreach ($item->jawaban as $jawabanIndex => $jawaban)
                                        @if (isset($opsiKeys[$jawabanIndex]))
                                            <label
                                                class="relative flex items-center gap-3 p-3 rounded-xl border border-slate-200/80 bg-slate-50/40 hover:bg-amber-50/40 hover:border-amber-400 cursor-pointer transition-all duration-200 shadow-sm">
                                                <input type="radio" name="jawaban[{{ $item->id }}]"
                                                    value="{{ $jawaban->id }}" class="peer sr-only">

                                                {{-- Custom Radio Circle Indicator --}}
                                                <div
                                                    class="w-4 h-4 rounded-full border-2 border-slate-300 peer-checked:border-amber-600 peer-checked:bg-amber-600 flex items-center justify-center transition-all duration-200 shrink-0 shadow-sm">
                                                    <div
                                                        class="w-1.5 h-1.5 rounded-full bg-white scale-0 peer-checked:scale-100 transition-transform duration-200">
                                                    </div>
                                                </div>

                                                <span
                                                    class="text-slate-700 font-medium text-xs sm:text-sm select-none flex-1">
                                                    <strong
                                                        class="uppercase mr-1.5 px-1.5 py-0.5 rounded bg-slate-200/60 text-slate-700 font-bold text-[10px] peer-checked:bg-amber-100 peer-checked:text-amber-700">{{ $opsiKeys[$jawabanIndex] }}</strong>
                                                    {{ $jawaban->jawaban }}
                                                </span>

                                                {{-- Active Overlay Highlight for Label --}}
                                                <div
                                                    class="absolute inset-0 rounded-xl border-2 border-amber-600 opacity-0 peer-checked:opacity-100 pointer-events-none transition-opacity duration-200 bg-amber-50/10">
                                                </div>
                                            </label>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @empty
                            <div
                                class="text-center py-12 bg-white rounded-2xl border border-dashed border-slate-200 shadow-sm">
                                <div
                                    class="w-12 h-12 mx-auto mb-3 rounded-xl bg-slate-100 flex items-center justify-center text-slate-400">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <p class="text-slate-500 font-medium text-xs">Belum ada soal remidi yang tersedia untuk
                                    materi ini.</p>
                            </div>
                        @endforelse

                        {{-- Tombol Kirim Jawaban Remidi --}}
                        @if (isset($materi->soal) && $materi->soal->count() > 0)
                            <div
                                class="flex flex-col sm:flex-row items-center justify-between gap-3 pt-4 bg-white/50 backdrop-blur p-4 rounded-2xl border border-slate-100">
                                <div class="text-[11px] text-slate-500 font-medium text-center sm:text-left">
                                    Pastikan seluruh soal remidi terjawab sebelum melakukan pengiriman.
                                </div>
                                <button type="submit" onclick="isSubmitted = true;"
                                    class="w-full sm:w-auto px-6 py-3 bg-gradient-to-r from-amber-600 to-orange-600 hover:from-amber-700 hover:to-orange-700 text-white font-extrabold text-xs rounded-xl shadow-lg shadow-amber-600/30 transition-all duration-200 hover:scale-[1.02] active:scale-95 flex items-center justify-center gap-2 group">
                                    <span>Selesai & Kumpulkan Remidi</span>
                                    <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                    </svg>
                                </button>
                            </div>
                        @endif
                    </div>
                </form>
            </div>

        </div>
    </div>

    {{-- Script JavaScript untuk Timer, Fullscreen, Proteksi Tab, dan Anti-Refresh --}}
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

            document.addEventListener("DOMContentLoaded", function() {
                // 1. Deteksi Refresh / Reload Halaman menggunakan Performance Navigation API
                const perfEntries = performance.getEntriesByType("navigation");
                if (perfEntries.length > 0 && perfEntries[0].type === "reload") {
                    alert(
                        "PERHATIAN: Me-refresh halaman selama ujian remidi adalah pelanggaran! Soal telah diacak ulang.");
                }

                // 2. Cegah tombol F5 / Ctrl+R / Cmd+R agar tidak disalahgunakan untuk refresh manual
                document.addEventListener("keydown", function(e) {
                    if (e.key === "F5" || (e.ctrlKey && e.key === "r") || (e.metaKey && e.key === "r")) {
                        e.preventDefault();
                        alert("Tombol Refresh (F5 / Reload) dikunci selama ujian remidi berlangsung!");
                    }
                });

                // 3. Paksa masuk Fullscreen saat halaman dimuat
                toggleFullscreen();

                // Deteksi jika user keluar dari fullscreen
                document.addEventListener("fullscreenchange", function() {
                    if (!document.fullscreenElement && !isSubmitted) {
                        document.getElementById("btn-fullscreen").classList.remove("hidden");
                        alert(
                            "PERHATIAN: Anda keluar dari mode Fullscreen! Harap kembali ke mode fullscreen untuk melanjutkan remidi.");
                    } else {
                        document.getElementById("btn-fullscreen").classList.add("hidden");
                    }
                });

                // 4. Proteksi Pindah Tab / Minimalkan Browser (Visibility API)
                document.addEventListener("visibilitychange", function() {
                    if (document.hidden && !isSubmitted) {
                        warningCount++;
                        if (warningCount <= maxWarnings) {
                            alert(
                                `PERINGATAN (${warningCount}/${maxWarnings}): Anda terdeteksi mencoba membuka tab/aplikasi lain! Ujian remidi ini harus dikerjakan tanpa beralih halaman.`);
                            toggleFullscreen();
                        } else {
                            alert(
                                "Anda telah melanggar aturan ujian berkali-kali. Remidi akan dikirimkan secara otomatis.");
                            isSubmitted = true;
                            document.getElementById("quiz-form").submit();
                        }
                    }
                });

                // 5. Timer Mundur Ujian Remidi
                let totalTime = 300; // 5 Menit
                const countdownElement = document.getElementById("countdown");
                const quizForm = document.getElementById("quiz-form");
                const timerContainer = document.getElementById("timer-container");

                const timer = setInterval(function() {
                    let minutes = Math.floor(totalTime / 60);
                    let seconds = totalTime % 60;

                    minutes = minutes < 10 ? "0" + minutes : minutes;
                    seconds = seconds < 10 ? "0" + seconds : seconds;

                    countdownElement.textContent = `${minutes}:${seconds}`;

                    if (totalTime <= 60) {
                        timerContainer.classList.remove("bg-amber-50/80", "border-amber-200/60",
                            "text-amber-700");
                        timerContainer.classList.add("bg-red-50", "border-red-200", "text-red-600",
                            "animate-pulse");
                    }

                    if (totalTime <= 0) {
                        clearInterval(timer);
                        isSubmitted = true;
                        alert("Waktu remidi telah habis! Jawaban Anda akan disimpan secara otomatis.");
                        quizForm.submit();
                    }

                    totalTime--;
                }, 1000);
            });
        </script>
    @endpush
@endsection
