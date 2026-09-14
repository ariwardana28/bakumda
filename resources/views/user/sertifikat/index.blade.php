@extends('layouts.app')

@section('content')
    <div class="space-y-8 pt-6 sm:pt-8 pb-12 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div
            class="relative overflow-hidden bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 dark:from-slate-900 dark:via-slate-900 dark:to-slate-950 rounded-3xl p-6 md:p-8 border border-slate-800 shadow-xl">
            <div class="absolute -top-16 -right-16 w-64 h-64 bg-indigo-500/10 rounded-full blur-3xl pointer-events-none">
            </div>
            <div class="absolute -bottom-16 -left-16 w-64 h-64 bg-blue-500/10 rounded-full blur-3xl pointer-events-none">
            </div>

            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="space-y-2">
                    <div
                        class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-500/10 border border-indigo-500/20 text-indigo-300 text-xs font-semibold">
                        <span class="w-2 h-2 rounded-full bg-indigo-400 animate-pulse"></span>
                        Transkrip & Kompetensi Resmi
                    </div>
                    <h2 class="text-2xl md:text-3xl font-black tracking-tight text-white">
                        Daftar Sertifikat
                    </h2>
                    <p class="text-xs md:text-sm text-slate-300 max-w-xl leading-relaxed">
                        Kelola dan pantau seluruh daftar resmi transkrip nilai serta sertifikat kompetensi dari pelatihan
                        yang telah Anda tuntaskan.
                    </p>
                </div>

                <div class="flex items-center gap-3 shrink-0">
                    <div
                        class="bg-white/5 backdrop-blur-md border border-white/10 px-5 py-3 rounded-2xl flex items-center gap-3 shadow-inner">
                        <div
                            class="w-10 h-10 rounded-xl bg-indigo-600/20 border border-indigo-400/30 flex items-center justify-center text-indigo-400">
                            <i class="fa-solid fa-award text-lg"></i>
                        </div>
                        <div>
                            <span class="block text-[10px] text-slate-400 uppercase tracking-wider font-semibold">Total
                                Dimiliki</span>
                            <span class="text-lg font-black text-white">{{ count($daftarSertifikat ?? []) }} <span
                                    class="text-xs font-normal text-slate-400">Sertifikat</span></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/80 dark:border-slate-800 p-5 shadow-sm">
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-4">

                <div class="flex items-center gap-3">
                    <div
                        class="w-9 h-9 rounded-xl bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 border border-indigo-100 dark:border-indigo-500/20 flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-magnifying-glass text-sm"></i>
                    </div>
                    <div>
                        <h4 class="text-xs font-bold text-slate-800 dark:text-slate-200 uppercase tracking-wider">Pencarian
                            Sertifikat</h4>
                        <p class="text-[11px] text-slate-500 dark:text-slate-400">Filter cepat sertifikat berdasarkan nama
                            atau nomor resmi</p>
                    </div>
                </div>

                <div class="relative w-full sm:w-80">
                    <i
                        class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    <input type="text" id="searchSertifikat" placeholder="Cari nama atau no. sertifikat..."
                        class="w-full pl-9 pr-9 py-2.5 bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700/80 rounded-2xl text-xs text-slate-800 dark:text-slate-100 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:bg-white dark:focus:bg-slate-900 transition-all duration-200">
                    <button type="button" id="clearSearch"
                        class="hidden absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 text-xs">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="sertifikatGrid">
            @forelse($daftarSertifikat ?? [] as $sertifikat)
                @php
                    $pelatihan = optional($sertifikat->nilai->first())->pelatihanAnggota->pelatihan ?? null;
                    $pelatihanAnggotaId = optional($sertifikat->nilai->first())->pelatihan_anggota_id;

                    $daftarNilai = $pelatihanAnggotaId
                        ? \App\Models\Nilai::where('pelatihan_anggota_id', $pelatihanAnggotaId)->get()
                        : $sertifikat->nilai ?? collect();

                    $totalNilaiAkumulatif = $daftarNilai->sum('nilai');

                    if ($totalNilaiAkumulatif >= 85) {
                        $predikat = 'Sangat Baik';
                        $badgeStyle = 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border-emerald-500/20';
                        $glowColor = 'hover:border-emerald-500/30';
                    } elseif ($totalNilaiAkumulatif >= 70) {
                        $predikat = 'Baik';
                        $badgeStyle = 'bg-blue-500/10 text-blue-600 dark:text-blue-400 border-blue-500/20';
                        $glowColor = 'hover:border-blue-500/30';
                    } elseif ($totalNilaiAkumulatif >= 55) {
                        $predikat = 'Cukup Baik';
                        $badgeStyle = 'bg-amber-500/10 text-amber-600 dark:text-amber-400 border-amber-500/20';
                        $glowColor = 'hover:border-amber-500/30';
                    } elseif ($totalNilaiAkumulatif >= 40) {
                        $predikat = 'Kurang Baik';
                        $badgeStyle = 'bg-orange-500/10 text-orange-600 dark:text-orange-400 border-orange-500/20';
                        $glowColor = 'hover:border-orange-500/30';
                    } else {
                        $predikat = 'Buruk';
                        $badgeStyle = 'bg-rose-500/10 text-rose-600 dark:text-rose-400 border-rose-500/20';
                        $glowColor = 'hover:border-rose-500/30';
                    }

                    $judulPelatihan = $pelatihan->judul ?? ($sertifikat->nama_pelatihan ?? 'Judul Pelatihan');
                    $noSertifikat = $sertifikat->no_sertifikat ?? 'Belum Ada No.';
                @endphp

                <div class="sertifikat-item bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/80 dark:border-slate-800/80 shadow-sm hover:shadow-xl {{ $glowColor }} transition-all duration-300 flex flex-col justify-between overflow-hidden group relative"
                    data-search="{{ strtolower($judulPelatihan . ' ' . $noSertifikat) }}">

                    <div
                        class="h-1.5 w-full bg-gradient-to-r from-indigo-500 via-blue-500 to-indigo-600 opacity-80 group-hover:opacity-100 transition duration-300">
                    </div>

                    <div class="p-6 space-y-4">
                        <div class="flex items-center justify-between gap-2">
                            <span
                                class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl text-[10px] font-bold tracking-wider uppercase bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-300 border border-slate-200/80 dark:border-slate-700/60 shadow-xs">
                                <i class="fa-solid fa-barcode text-slate-400"></i>
                                {{ $noSertifikat }}
                            </span>
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-xl text-[10px] font-extrabold tracking-wider uppercase border {{ $badgeStyle }} shadow-xs">
                                {{ $predikat }}
                            </span>
                        </div>

                        <div class="space-y-1.5">
                            <h3
                                class="text-base font-extrabold text-slate-900 dark:text-slate-100 line-clamp-2 leading-snug group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                                {{ $judulPelatihan }}
                            </h3>
                            <p class="text-xs text-slate-500 dark:text-slate-400 line-clamp-2 leading-relaxed">
                                {{ $pelatihan->deskripsi ?? 'Pelatihan resmi bersertifikat untuk meningkatkan kompetensi keahlian profesional Anda.' }}
                            </p>
                        </div>

                        <div
                            class="bg-gradient-to-r from-slate-50 to-indigo-50/30 dark:from-slate-800/60 dark:to-slate-800/20 p-3.5 rounded-2xl border border-slate-100 dark:border-slate-800/80 flex items-center justify-between text-xs">
                            <span class="text-slate-500 dark:text-slate-400 font-semibold flex items-center gap-2">
                                <span
                                    class="w-7 h-7 rounded-lg bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 flex items-center justify-center">
                                    <i class="fa-solid fa-chart-pie text-xs"></i>
                                </span>
                                Akumulasi Nilai
                            </span>
                            <span
                                class="font-black text-slate-900 dark:text-slate-100 text-sm bg-white dark:bg-slate-900 px-3 py-1 rounded-xl shadow-xs border border-slate-200/60 dark:border-slate-700/80">
                                {{ number_format($totalNilaiAkumulatif, 2) }}
                            </span>
                        </div>
                    </div>

                    <div class="p-6 pt-0 mt-auto">
                        <a href="{{ route('user.sertifikat', $pelatihan->id ?? 0) }}"
                            class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 bg-slate-900 hover:bg-indigo-600 dark:bg-slate-800 dark:hover:bg-indigo-600 text-white rounded-2xl text-xs font-bold tracking-wide shadow-md hover:shadow-indigo-500/20 transition-all duration-300 group/btn">
                            <i
                                class="fa-regular fa-eye text-sm transition-transform duration-300 group-hover/btn:scale-110"></i>
                            <span>Lihat Detail Sertifikat</span>
                            <i
                                class="fa-solid fa-arrow-right text-[10px] opacity-0 group-hover/btn:opacity-100 -translate-x-1 group-hover/btn:translate-x-0 transition-all duration-300"></i>
                        </a>
                    </div>
                </div>
            @empty
                <div
                    class="col-span-full bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/80 dark:border-slate-800/80 p-12 md:p-16 text-center shadow-sm relative overflow-hidden">
                    <div class="relative z-10 space-y-4">
                        <div
                            class="w-20 h-20 bg-indigo-500/10 rounded-3xl flex items-center justify-center mx-auto text-indigo-600 dark:text-indigo-400 border border-indigo-500/20 shadow-inner">
                            <i class="fa-solid fa-folder-open text-3xl"></i>
                        </div>
                        <div class="space-y-1.5">
                            <h3 class="text-base md:text-lg font-extrabold text-slate-800 dark:text-slate-100">
                                Belum Ada Sertifikat Diterbitkan
                            </h3>
                            <p
                                class="text-xs md:text-sm text-slate-500 dark:text-slate-400 max-w-md mx-auto leading-relaxed">
                                Anda belum menyelesaikan pelatihan apa pun atau sertifikat resmi Anda sedang dalam proses
                                verifikasi oleh sistem.
                            </p>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>

        <div id="noSearchResult"
            class="hidden bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/80 dark:border-slate-800 p-10 text-center">
            <div
                class="w-12 h-12 bg-slate-100 dark:bg-slate-800 text-slate-400 rounded-2xl flex items-center justify-center mx-auto mb-3">
                <i class="fa-solid fa-magnifying-glass text-lg"></i>
            </div>
            <p class="text-sm font-bold text-slate-700 dark:text-slate-300">Sertifikat tidak ditemukan</p>
            <p class="text-xs text-slate-400 mt-1">Coba gunakan kata kunci pencarian yang lain.</p>
        </div>
    </div>

    {{-- 🌟 DIUBAH: script dibungkus IIFE + guard supaya tidak error "already declared"
         jika halaman/partial ini kebetulan ter-load lebih dari sekali. --}}
    <script>
        (function() {
            const searchInput = document.getElementById('searchSertifikat');
            const clearBtn = document.getElementById('clearSearch');
            const items = document.querySelectorAll('.sertifikat-item');
            const noResult = document.getElementById('noSearchResult');

            if (!searchInput) return;

            function filterSertifikat() {
                const query = searchInput.value.toLowerCase().trim();
                let hasMatch = false;

                if (query.length > 0) {
                    clearBtn?.classList.remove('hidden');
                } else {
                    clearBtn?.classList.add('hidden');
                }

                items.forEach(item => {
                    const text = item.getAttribute('data-search');
                    if (text.includes(query)) {
                        item.style.display = 'flex';
                        hasMatch = true;
                    } else {
                        item.style.display = 'none';
                    }
                });

                if (!hasMatch && items.length > 0) {
                    noResult?.classList.remove('hidden');
                } else {
                    noResult?.classList.add('hidden');
                }
            }

            searchInput.addEventListener('input', filterSertifikat);

            clearBtn?.addEventListener('click', function() {
                searchInput.value = '';
                filterSertifikat();
                searchInput.focus();
            });
        })();
    </script>
@endsection
