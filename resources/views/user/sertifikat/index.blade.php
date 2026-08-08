@extends('layouts.app')

@section('content')
    <div class="space-y-8 pb-10">
        <!-- Page Header Modern -->
        <div
            class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-slate-200/60 dark:border-slate-800 pb-5">
            <div>
                <h2 class="text-2xl font-black tracking-tight text-slate-800 dark:text-slate-100">Daftar Sertifikat</h2>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Daftar resmi transkrip nilai dan sertifikat
                    kompetensi dari pelatihan yang telah Anda ikuti.</p>
            </div>
            <div class="flex items-center gap-2">
                <span
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-indigo-50 text-indigo-600 dark:bg-indigo-500/10 dark:text-indigo-400 border border-indigo-100 dark:border-indigo-500/20 shadow-sm">
                    <i class="fa-solid fa-award text-[10px]"></i> Total: {{ count($daftarSertifikat ?? []) }} Sertifikat
                </span>
            </div>
        </div>

        <!-- Grid Daftar Sertifikat -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($daftarSertifikat ?? [] as $sertifikat)
                @php
                    $pelatihan = optional($sertifikat->nilai->first())->pelatihanAnggota->pelatihan ?? null;
                    $pelatihanAnggotaId = optional($sertifikat->nilai->first())->pelatihan_anggota_id;

                    // Ambil seluruh nilai berdasarkan pelatihan_anggota_id yang sama agar nilai dari semua materi (termasuk remidi/materi lain) terakumulasi
                    $daftarNilai = $pelatihanAnggotaId
                        ? \App\Models\Nilai::where('pelatihan_anggota_id', $pelatihanAnggotaId)->get()
                        : $sertifikat->nilai ?? collect();

                    $totalNilaiAkumulatif = $daftarNilai->sum('nilai');

                    // Menentukan Predikat & Styling Badge
                    $predikat = '';
                    $badgeColor = '';
                    if ($totalNilaiAkumulatif >= 85) {
                        $predikat = 'Sangat Baik';
                        $badgeColor =
                            'bg-emerald-50 text-emerald-600 border-emerald-200/60 dark:bg-emerald-500/10 dark:text-emerald-400 dark:border-emerald-500/20';
                    } elseif ($totalNilaiAkumulatif >= 70) {
                        $predikat = 'Baik';
                        $badgeColor =
                            'bg-blue-50 text-blue-600 border-blue-200/60 dark:bg-blue-500/10 dark:text-blue-400 dark:border-blue-500/20';
                    } elseif ($totalNilaiAkumulatif >= 55) {
                        $predikat = 'Cukup Baik';
                        $badgeColor =
                            'bg-amber-50 text-amber-600 border-amber-200/60 dark:bg-amber-500/10 dark:text-amber-400 dark:border-amber-500/20';
                    } elseif ($totalNilaiAkumulatif >= 40) {
                        $predikat = 'Kurang Baik';
                        $badgeColor =
                            'bg-orange-50 text-orange-600 border-orange-200/60 dark:bg-orange-500/10 dark:text-orange-400 dark:border-orange-500/20';
                    } else {
                        $predikat = 'Buruk';
                        $badgeColor =
                            'bg-rose-50 text-rose-600 border-rose-200/60 dark:bg-rose-500/10 dark:text-rose-400 dark:border-rose-500/20';
                    }
                @endphp

                <div
                    class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/80 dark:border-slate-800 shadow-sm hover:shadow-xl hover:border-indigo-500/30 dark:hover:border-indigo-500/40 transition-all duration-300 flex flex-col justify-between overflow-hidden group">
                    <!-- Bagian Atas Card -->
                    <div class="p-6 space-y-4">
                        <div class="flex items-start justify-between gap-2">
                            <span
                                class="inline-flex items-center gap-1 px-3 py-1 rounded-xl text-[10px] font-bold tracking-wide uppercase bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-300 border border-slate-200/60 dark:border-slate-700/60">
                                <i class="fa-solid fa-barcode text-slate-400"></i>
                                {{ $sertifikat->no_sertifikat ?? 'Belum Ada No.' }}
                            </span>
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-xl text-[10px] font-bold tracking-wide uppercase border {{ $badgeColor }}">
                                {{ $predikat ?: 'Selesai' }}
                            </span>
                        </div>

                        <div>
                            <h3
                                class="text-base font-extrabold text-slate-800 dark:text-slate-100 line-clamp-2 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                                {{ $pelatihan->judul ?? ($sertifikat->nama_pelatihan ?? 'Judul Pelatihan') }}
                            </h3>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-2 line-clamp-2 leading-relaxed">
                                {{ $pelatihan->deskripsi ?? 'Pelatihan resmi bersertifikat untuk meningkatkan kompetensi keahlian profesional.' }}
                            </p>
                        </div>

                        <!-- Informasi Ringkas Nilai (Modern Box Style) -->
                        <div
                            class="bg-slate-50/80 dark:bg-slate-800/50 p-3.5 rounded-2xl border border-slate-100 dark:border-slate-800 flex items-center justify-between text-xs">
                            <span class="text-slate-500 dark:text-slate-400 font-medium flex items-center gap-1.5">
                                <i class="fa-solid fa-chart-pie text-indigo-500"></i> Akumulasi Nilai:
                            </span>
                            <span
                                class="font-black text-slate-800 dark:text-slate-100 text-sm bg-white dark:bg-slate-900 px-2.5 py-1 rounded-xl shadow-xs border border-slate-200/50 dark:border-slate-700">
                                {{ number_format($totalNilaiAkumulatif, 2) }}
                            </span>
                        </div>
                    </div>

                    <!-- Bagian Bawah / Tombol Detail -->
                    <div class="p-6 pt-0 mt-auto">
                        <a href="{{ route('user.sertifikat', $pelatihan->id ?? 0) }}"
                            class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 bg-slate-900 hover:bg-indigo-600 dark:bg-slate-800 dark:hover:bg-indigo-600 text-white rounded-2xl text-xs font-bold tracking-wide shadow-sm transition-all duration-200 group/btn">
                            <i class="fa-regular fa-eye text-sm transition-transform group-hover/btn:scale-110"></i>
                            Lihat Detail Sertifikat
                        </a>
                    </div>
                </div>
            @empty
                <!-- Kondisi Jika Belum Ada Sertifikat (Clean Empty State) -->
                <div
                    class="col-span-full bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/80 dark:border-slate-800 p-16 text-center shadow-sm">
                    <div
                        class="w-16 h-16 bg-indigo-50 dark:bg-indigo-500/10 rounded-3xl flex items-center justify-center mx-auto mb-4 text-indigo-600 dark:text-indigo-400 border border-indigo-100 dark:border-indigo-500/20 shadow-inner">
                        <i class="fa-solid fa-folder-open text-2xl"></i>
                    </div>
                    <h3 class="text-base font-extrabold text-slate-800 dark:text-slate-100">Belum Ada Sertifikat</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 max-w-sm mx-auto leading-relaxed">Anda belum
                        menyelesaikan pelatihan apa pun atau belum ada sertifikat resmi yang diterbitkan untuk akun Anda.
                    </p>
                </div>
            @endforelse
        </div>
    </div>
@endsection
