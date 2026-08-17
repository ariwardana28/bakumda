<!-- Card Item -->
<a href="{{ route('user-pelatihan.show', $pelatihan) }}"
    class="snap-start shrink-0 w-4/5 sm:w-3/5 md:w-full bg-gradient-to-br {{ $bgGradient }} rounded-2xl p-6 text-white shadow-md flex flex-col justify-between h-[180px] transition-transform duration-300 md:hover:scale-105">
    <div>
        <h4 class="font-black text-base tracking-wide">{{ $pelatihan->judul }}</h4>
        <div class="mt-2 text-xs opacity-90 space-y-1 font-medium">
            <p>• Mulai:
                {{ \Carbon\Carbon::parse($pelatihan->tanggal_mulai)->translatedFormat('d F Y') }}</p>
            <p class="text-sm font-extrabold text-amber-400 mt-1">
                Rp {{ number_format($pelatihan->harga, 0, ',', '.') }}
            </p>
        </div>
    </div>
    <div class="bg-white text-slate-900 font-bold text-xs px-4 py-2 rounded-full shadow w-max">
        Lihat Detail
    </div>
</a>