@php
    $pendaftaran = $item->userPendaftaran;
    $status =
        $pendaftaran && $pendaftaran->latestStatus
            ? strtolower($pendaftaran->latestStatus->status)
            : null;

    // Mapping warna aksen berdasarkan jenis pelatihan
    $jenisNama = $item->jenisPelatihan->nama ?? null;

    $isDiklatkum = $jenisNama && str_contains(strtolower($jenisNama), 'diklatkum');

    $cardBorderClass = $isDiklatkum ? 'border-indigo-200' : 'border-slate-100';
    $cardRingClass = $isDiklatkum ? 'ring-1 ring-indigo-100' : '';
    $badgeBgClass = $isDiklatkum ? 'bg-indigo-600/90' : 'bg-slate-900/80';
    $topBarClass = $isDiklatkum ? 'bg-indigo-500' : 'bg-transparent';
@endphp

<div
    class="relative bg-white rounded-3xl border {{ $cardBorderClass }} {{ $cardRingClass }} shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden flex flex-col justify-between group">

    {{-- Aksen garis atas untuk kategori DIKLATKUM --}}
    <div class="absolute top-0 left-0 right-0 h-1.5 {{ $topBarClass }}"></div>

    <div>
        {{-- Thumbnail & Badge --}}
        <div class="relative h-52 bg-slate-100 overflow-hidden">
            <img src="{{ $item->gambar ? Storage::url($item->gambar) : 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&w=600&q=80' }}"
                alt="{{ $item->judul }}"
                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">

            <div
                class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent opacity-60">
            </div>

            {{-- Badge Jenis Pelatihan --}}
            <div
                class="absolute top-3.5 left-3.5 {{ $badgeBgClass }} backdrop-blur-md text-white text-[11px] font-bold px-3 py-1 rounded-xl shadow-sm border border-white/10 uppercase tracking-wider">
                {{ $jenisNama ?? '-' }}
            </div>

            {{-- Rating Badge --}}
           
        </div>

        {{-- Content Body --}}
        <div class="p-6">
            <h3
                class="font-bold text-slate-900 text-base mb-3 leading-snug line-clamp-2 group-hover:text-sky-600 transition-colors">
                {{ $item->judul }}
            </h3>

            <div class="space-y-2 text-xs text-slate-500">
                <div class="flex items-center gap-2.5 font-medium">
                    <div
                        class="w-5 h-5 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center flex-shrink-0">
                        ✓</div>
                    <span>Kuota: <strong
                            class="text-slate-700">{{ $item->kuota ?? 'Unlimited' }}
                            peserta</strong></span>
                </div>
                <div class="flex items-center gap-2.5 font-medium">
                    <div
                        class="w-5 h-5 rounded-full bg-sky-50 text-sky-600 flex items-center justify-center flex-shrink-0">
                        ⏱</div>
                    <span>Mulai: <strong
                            class="text-slate-700">{{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M Y') }}</strong></span>
                </div>
            </div>
        </div>
    </div>

    {{-- Footer Harga & Tombol Aksi Dinamis --}}
    <div
        class="px-6 pb-6 pt-4 flex items-center justify-between border-t border-slate-100 bg-slate-50/50 mt-auto">
        <div>
            <span
                class="text-[10px] uppercase tracking-wider text-slate-400 font-bold block">Investasi</span>
            <span class="text-slate-900 font-extrabold text-base">Rp
                {{ number_format($item->harga, 0, ',', '.') }}</span>
        </div>

        <div class="w-full max-w-[160px]">
            @if ($item->status == 'akan datang')
                <a href="{{ route('user-pelatihan.show', $item) }}"
                    class="flex items-center justify-center w-full bg-amber-500 hover:bg-amber-600 text-white font-bold text-xs py-2.5 px-4 rounded-xl shadow-md transition-all">
                    Coming Soon
                </a>
            @elseif (!$pendaftaran)
                <a href="{{ route('user-pelatihan.show', $item) }}"
                    class="flex items-center justify-center w-full bg-sky-600 hover:bg-sky-505 text-white font-bold text-xs py-2.5 px-4 rounded-xl shadow-md transition-all">
                    Lihat Sekarang
                </a>
            @elseif ($status == 'menunggu pembayaran')
                <a href="{{ route('user-pelatihan.payment', $pendaftaran->id) }}"
                    class="flex items-center justify-center w-full bg-amber-600 hover:bg-amber-700 text-white font-bold text-xs py-2.5 px-4 rounded-xl shadow-md transition-all">
                     Pembayaran
                </a>
            @elseif ($status == 'pembayaran disetujui')
                <a href="{{ route('user-materi.index', $item) }}"
                    class="flex items-center justify-center w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs py-2.5 px-4 rounded-xl shadow-md transition-all">
                    Akses Materi
                </a>
            @else
                <a href="{{ route('user-pelatihan.status', $pendaftaran->id) }}"
                    class="flex items-center justify-center w-full bg-slate-700 hover:bg-slate-800 text-white font-bold text-xs py-2.5 px-4 rounded-xl shadow-md transition-all">
                    Cek Status
                </a>
            @endif
        </div>
    </div>
</div>