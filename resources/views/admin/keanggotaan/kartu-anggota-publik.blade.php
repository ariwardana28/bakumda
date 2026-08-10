@extends('layouts.app') {{-- Sesuaikan dengan layout utama Anda --}}

@section('content')
    <div class="max-w-md mx-auto space-y-6 py-6" x-data="{ zoomCard: false }">

        @if (session('success'))
            <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-semibold flex items-center gap-3 shadow-sm">
                <div class="w-7 h-7 rounded-xl bg-emerald-100 flex items-center justify-center shrink-0">
                    <i class="fa-solid fa-check text-emerald-600"></i>
                </div>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <div class="bg-white border border-slate-200 p-6 sm:p-8 rounded-[2rem] shadow-xl text-center relative overflow-hidden text-slate-800" x-data="{ isFlipped: false }">
            
            {{-- Aksen Glow Dekoratif Terang --}}
            <div class="absolute -top-16 -right-16 w-48 h-48 bg-orange-500/10 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-16 -left-16 w-48 h-48 bg-amber-500/10 rounded-full blur-3xl pointer-events-none"></div>

            <h3 class="text-xs uppercase tracking-widest font-extrabold text-slate-400 mb-6 relative z-10 flex items-center justify-center gap-2">
                <i class="fa-solid fa-id-card text-orange-500"></i> Preview Kartu Anggota
            </h3>

            <!-- CONTAINER KARTU FISIK 3D -->
            <style>
                .perspective-1000 {
                    perspective: 1000px;
                }
                .transform-style-3d {
                    transform-style: preserve-3d;
                }
                .backface-hidden {
                    backface-visibility: hidden;
                    -webkit-backface-visibility: hidden;
                }
                .rotate-y-180 {
                    transform: rotateY(180deg);
                }
            </style>
            
            <div class="relative w-[280px] h-[480px] mx-auto perspective-1000 my-4 group cursor-pointer" @click="isFlipped = !isFlipped">
                <div class="relative w-full h-full duration-700 transform-style-3d transition-transform shadow-xl rounded-2xl"
                    :class="{ 'rotate-y-180': isFlipped }">

                    <!-- SISI DEPAN KARTU -->
                    <div class="absolute inset-0 w-full h-full rounded-2xl shadow-lg border border-slate-200 bg-white backface-hidden overflow-hidden transform-style-3d">
                        <img src="{{ asset('background.png') }}" class="absolute inset-0 w-full h-full object-cover">
                        <div class="relative z-10 w-full h-full">
                            <div class="absolute top-[201px] left-[50px] w-[95px] h-[129px] overflow-hidden rounded-md flex items-center justify-center bg-slate-100 border border-slate-200">
                                @if ($anggotaCard->anggota->foto ?? false)
                                    <img src="{{ asset('storage/' . $anggotaCard->anggota->foto) }}" class="w-full h-full object-cover">
                                @else
                                    <div class="flex flex-col items-center justify-center text-slate-400">
                                        <i class="fa-solid fa-user text-2xl"></i>
                                        <span class="text-[8px] mt-1 font-medium">No Foto</span>
                                    </div>
                                @endif
                            </div>
                            <div class="absolute top-[205px] left-[152px] w-[80px] flex flex-col items-center">
                                <div class="w-[78px] h-[78px] bg-white p-1 rounded-lg flex items-center justify-center shadow-sm border border-slate-100">
                                    @if ($anggotaCard->qr_code)
                                        <img src="{{ asset('storage/' . $anggotaCard->qr_code) }}" class="w-full h-full object-contain">
                                    @else
                                        <div class="text-[8px] text-slate-400 text-center leading-tight font-medium">
                                            Belum<br>Terbit
                                        </div>
                                    @endif
                                </div>
                                @if ($anggotaCard->card_id)
                                    <span class="text-[8px] font-mono font-bold text-slate-900 bg-slate-100 px-2 py-0.5 rounded-full mt-1.5 shadow-sm tracking-tighter whitespace-nowrap border border-slate-200">
                                        NIA. {{ $anggotaCard->card_id }}
                                    </span>
                                @endif
                            </div>
                            <div class="absolute top-[342px] inset-x-0 px-4 text-center">
                                <h2 class="text-[11px] font-black text-slate-900 uppercase tracking-tight leading-snug">
                                    {{ $anggotaCard->anggota->nama ?? '' }}
                                </h2>
                                @if (!empty(optional($latestBerlaku)->jabatan))
                                    <p class="text-[9.5px] font-bold text-orange-600 uppercase tracking-wider mt-0.5">
                                        {{ $latestBerlaku->jabatan }}
                                    </p>
                                @endif
                            </div>
                            @if (!empty(optional($latestBerlaku)->berlaku))
                                <div class="absolute bottom-[20px] left-[18px]">
                                    <p class="text-[8px] font-bold text-slate-900/90 font-sans tracking-tight">
                                        Berlaku s/d {{ \Carbon\Carbon::parse($latestBerlaku->berlaku)->translatedFormat('d F Y') }}
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- SISI BELAKANG KARTU -->
                    <div class="absolute inset-0 w-full h-full rounded-2xl shadow-lg border border-slate-200 bg-white backface-hidden rotate-y-180 overflow-hidden transform-style-3d">
                        <img src="{{ asset('belakang.png') }}" class="absolute inset-0 w-full h-full object-cover">
                    </div>
                </div>
            </div>

            <p class="text-[11px] text-slate-500 mb-6 italic">Klik kartu untuk membalik sisi depan/belakang</p>

            <!-- TOMBOL AKSI TERANG & MODERN -->
            <div class="space-y-3 relative z-10">
                <button type="button" @click="isFlipped = !isFlipped"
                    class="w-full py-3 px-4 text-xs font-bold rounded-2xl bg-slate-100 text-slate-700 hover:bg-slate-200 border border-slate-200 transition-all duration-300 flex items-center justify-center gap-2 shadow-sm">
                    <i class="fa-solid fa-rotate transition-transform duration-500 text-orange-500"
                        :class="{ 'rotate-180': isFlipped }"></i>
                    <span x-text="isFlipped ? 'Lihat Sisi Depan Kartu' : 'Putar ke Sisi Belakang'"></span>
                </button>

                <div class="grid grid-cols-2 gap-3">
                    <button type="button" @click="zoomCard = true"
                        class="py-3 px-4 text-xs font-bold rounded-2xl bg-slate-50 text-slate-700 hover:bg-slate-100 border border-slate-200 transition-all duration-300 flex items-center justify-center gap-2 shadow-sm">
                        <i class="fa-solid fa-magnifying-glass-plus text-orange-500"></i>
                        <span>Perbesar</span>
                    </button>

                    <a href="{{ route('admin.anggota-card.download', $anggotaCard->id) }}" target="_blank"
                        class="py-3 px-4 text-xs font-bold rounded-2xl bg-gradient-to-r from-orange-500 to-amber-500 hover:from-orange-600 hover:to-amber-600 text-white transition-all duration-300 flex items-center justify-center gap-2 shadow-md shadow-orange-500/20">
                        <i class="fa-solid fa-download"></i>
                        <span>Unduh Kartu</span>
                    </a>
                </div>
            </div>

        </div>

        <!-- MODAL PERBESAR (ZOOM) KARTU ANGGOTA -->
        <div x-show="zoomCard" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm transition-opacity" @click="zoomCard = false"></div>
            <div class="flex items-center justify-center min-h-screen p-4">
                <div class="relative bg-white border border-slate-200 rounded-3xl p-6 shadow-2xl z-10 max-w-sm w-full flex flex-col items-center text-slate-800">
                    <div class="flex justify-between items-center w-full mb-4 pb-3 border-b border-slate-100">
                        <h3 class="text-sm font-black uppercase tracking-wider text-slate-800 flex items-center gap-2">
                            <i class="fa-solid fa-id-card text-orange-500"></i> Detail Kartu Anggota
                        </h3>
                        <button @click="zoomCard = false" class="w-8 h-8 rounded-xl bg-slate-100 flex items-center justify-center text-slate-500 hover:text-slate-800 transition-colors">
                            <i class="fa-solid fa-xmark text-sm"></i>
                        </button>
                    </div>

                    <!-- KARTU UKURAN DIPERBESAR -->
                    <div class="relative w-[280px] h-[480px] rounded-2xl overflow-hidden shadow-xl border border-slate-200 my-4">
                        <img src="{{ asset('background.png') }}" class="absolute inset-0 w-full h-full object-cover z-0" alt="Background ID Card">
                        <div class="relative z-10 w-full h-full">
                            <div class="absolute top-[201px] left-[50px] w-[95px] h-[129px] overflow-hidden rounded-md flex items-center justify-center bg-slate-100 border border-slate-200">
                                @if ($anggotaCard->anggota->foto ?? false)
                                    <img src="{{ asset('storage/' . $anggotaCard->anggota->foto) }}" class="w-full h-full object-cover">
                                @else
                                    <div class="flex flex-col items-center justify-center text-slate-400">
                                        <i class="fa-solid fa-user text-2xl"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="absolute top-[205px] left-[152px] w-[80px] flex flex-col items-center">
                                <div class="w-[78px] h-[78px] bg-white p-1 rounded-lg flex items-center justify-center shadow-sm border border-slate-100">
                                    @if ($anggotaCard->qr_code)
                                        <img src="{{ asset('storage/' . $anggotaCard->qr_code) }}" class="w-full h-full object-contain">
                                    @endif
                                </div>
                                @if ($anggotaCard->card_id)
                                    <span class="text-[8px] font-mono font-bold text-slate-900 bg-slate-100 px-2 py-0.5 rounded-full mt-1.5 shadow-sm tracking-tighter whitespace-nowrap border border-slate-200">
                                        NIA. {{ $anggotaCard->card_id }}
                                    </span>
                                @endif
                            </div>
                            <div class="absolute top-[342px] inset-x-0 px-4 text-center">
                                <h2 class="text-[11px] font-black text-slate-900 uppercase tracking-tight leading-snug">
                                    {{ $anggotaCard->anggota->nama ?? '' }}
                                </h2>
                                @if (!empty(optional($latestBerlaku)->jabatan))
                                    <p class="text-[9.5px] font-bold text-orange-600 uppercase tracking-wider mt-0.5">
                                        {{ $latestBerlaku->jabatan }}
                                    </p>
                                @endif
                            </div>
                            @if (!empty(optional($latestBerlaku)->berlaku))
                                <div class="absolute bottom-[20px] left-[18px]">
                                    <p class="text-[8px] font-bold text-slate-900/90 font-sans tracking-tight">
                                        Berlaku s/d {{ \Carbon\Carbon::parse($latestBerlaku->berlaku)->translatedFormat('d F Y') }}
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="mt-4 w-full">
                        <button type="button" @click="zoomCard = false"
                            class="w-full py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold uppercase tracking-wider rounded-2xl transition-colors border border-slate-200">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection