@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-slate-50 py-8 sm:py-12">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mb-8 flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <a href="{{ url('/') }}" class="mb-3 inline-flex items-center gap-2 text-xs font-semibold text-slate-500 hover:text-blue-600">
                        <i class="fa-solid fa-arrow-left"></i>
                        Kembali ke Beranda
                    </a>
                    <h1 class="text-2xl font-black tracking-tight text-slate-900 sm:text-3xl">Artikel & Informasi</h1>
                    <p class="mt-1 text-sm text-slate-500">Baca berita dan informasi hukum terbaru dari BAKUMDA.</p>
                </div>

                <form action="{{ route('artikel.index.public') }}" method="GET" class="flex w-full max-w-md items-center gap-2">
                    <label for="search" class="sr-only">Cari artikel</label>
                    <div class="relative flex-1">
                        <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-xs text-slate-400"></i>
                        <input id="search" name="search" value="{{ $search }}" type="search"
                            placeholder="Cari artikel..."
                            class="w-full rounded-xl border border-slate-200 bg-white py-3 pl-10 pr-4 text-sm text-slate-900 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                    </div>
                    <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-blue-600 px-4 py-3 text-sm font-bold text-white shadow-sm transition hover:bg-blue-700" title="Cari artikel">
                        <i class="fa-solid fa-arrow-right"></i>
                    </button>
                </form>
            </div>

            @if ($search)
                <p class="mb-5 text-xs font-medium text-slate-500">Hasil pencarian untuk: <strong class="text-slate-800">{{ $search }}</strong></p>
            @endif

            <div class="grid grid-cols-1 gap-5 md:grid-cols-2 xl:grid-cols-3">
                @forelse ($artikels as $artikel)
                    <a href="{{ route('artikel.show.public', $artikel->slug) }}"
                        class="group overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition hover:-translate-y-0.5 hover:border-blue-200 hover:shadow-lg">
                        <div class="h-48 overflow-hidden bg-slate-100">
                            <img src="{{ $artikel->gambar ? asset('storage/' . $artikel->gambar) : 'https://images.unsplash.com/photo-1589829545856-d10d557cf95f?w=700&auto=format&fit=crop&q=80' }}"
                                alt="{{ $artikel->judul }}" class="h-full w-full object-cover transition duration-300 group-hover:scale-105">
                        </div>
                        <div class="p-5">
                            <div class="flex items-center gap-2 text-[11px] font-semibold text-slate-400">
                                <span>{{ $artikel->kategori->nama ?? 'Umum' }}</span>
                                <span>•</span>
                                <span>{{ \Carbon\Carbon::parse($artikel->tanggal)->diffForHumans() }}</span>
                            </div>
                            <h2 class="mt-2 line-clamp-2 text-base font-extrabold leading-snug text-slate-900 transition group-hover:text-blue-600">{{ $artikel->judul }}</h2>
                            <p class="mt-2 line-clamp-3 text-sm leading-relaxed text-slate-500">{{ Str::limit(strip_tags($artikel->isi), 150) }}</p>
                            <span class="mt-4 inline-flex items-center gap-2 text-xs font-bold text-blue-600">Baca selengkapnya <i class="fa-solid fa-arrow-right text-[10px]"></i></span>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full rounded-2xl border border-dashed border-slate-300 bg-white py-16 text-center">
                        <i class="fa-regular fa-newspaper mb-3 text-3xl text-slate-300"></i>
                        <p class="text-sm font-semibold text-slate-500">Belum ada artikel yang ditemukan.</p>
                    </div>
                @endforelse
            </div>

            @if ($artikels->hasPages())
                <div class="mt-8">{{ $artikels->links() }}</div>
            @endif
        </div>
    </div>
@endsection