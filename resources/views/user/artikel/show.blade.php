@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

        <!-- Tombol Kembali & Aksi Atas -->
        <div class="mb-6 px-4 sm:px-0 flex items-center justify-between">
            <a href="{{ route('user.artikel.index') }}"
                class="inline-flex items-center gap-2 text-xs font-bold text-gray-600 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 uppercase tracking-wider transition">
                <i class="fa-solid fa-arrow-left text-sm"></i>
                <span>{{ __('Kembali ke Daftar Artikel') }}</span>
            </a>

            <!-- Tombol Edit Cepat (Opsional jika ingin langsung edit dari halaman detail) -->
            @if (Route::has('user.artikel.edit'))
                <a href="{{ route('user.artikel.edit', $artikel) }}"
                    class="px-4 py-2 rounded-xl bg-indigo-50 dark:bg-indigo-950/50 text-indigo-600 dark:text-indigo-400 text-xs font-bold uppercase tracking-wider hover:bg-indigo-100 dark:hover:bg-indigo-900 transition flex items-center gap-2 shadow-xs">
                    <i class="fa-solid fa-pen-to-square text-xs"></i>
                    <span>{{ __('Edit Artikel') }}</span>
                </a>
            @endif
        </div>

        <!-- Main Card Container -->
        <div
            class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100 dark:border-gray-700 relative">

            <!-- Background Ambient Accent -->
            <div
                class="absolute -top-24 right-0 w-64 h-64 bg-indigo-500/5 dark:bg-indigo-500/10 rounded-full blur-3xl pointer-events-none">
            </div>

            <div class="p-6 sm:p-10 relative z-10 space-y-6 text-gray-900 dark:text-gray-100">

                <!-- Meta Informasi (Kategori, Tanggal, & Status) -->
                <div
                    class="flex flex-wrap items-center justify-between gap-4 pb-4 border-b border-gray-100 dark:border-gray-700 text-xs">
                    <div class="flex items-center gap-3">
                        <!-- Badge Kategori -->
                        @if (isset($artikel->kategori))
                            <span
                                class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-indigo-50 dark:bg-indigo-950/60 text-indigo-600 dark:text-indigo-400 font-bold">
                                <i class="fa-solid fa-tag text-[10px]"></i>
                                {{ $artikel->kategori->nama }}
                            </span>
                        @endif

                        <!-- Tanggal Publikasi -->
                        <span class="inline-flex items-center gap-1.5 text-gray-500 dark:text-gray-400 font-medium">
                            <i class="fa-solid fa-calendar-day text-[10px]"></i>
                            {{ isset($artikel->tanggal) ? \Carbon\Carbon::parse($artikel->tanggal)->format('d F Y') : $artikel->created_at->format('d F Y') }}
                        </span>
                    </div>

                    <!-- Badge Status Publikasi -->
                    <span
                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg text-xs font-bold uppercase tracking-wider {{ $artikel->status == 'published' ? 'bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 border border-emerald-200/50 dark:border-emerald-800/50' : 'bg-amber-50 dark:bg-amber-950/60 text-amber-600 dark:text-amber-400 border border-amber-200/50 dark:border-amber-800/50' }}">
                        <span
                            class="w-1.5 h-1.5 rounded-full {{ $artikel->status == 'published' ? 'bg-emerald-500' : 'bg-amber-500' }}"></span>
                        {{ $artikel->status == 'published' ? 'Published' : 'Draft' }}
                    </span>
                </div>

                <!-- Judul Artikel -->
                <div class="space-y-2">
                    <h1 class="text-xl sm:text-2xl font-black text-gray-900 dark:text-white tracking-tight leading-snug">
                        {{ $artikel->judul }}
                    </h1>
                </div>

                <!-- Gambar Unggulan (Jika Ada) -->
                @if ($artikel->gambar)
                    <div
                        class="w-full h-72 sm:h-96 rounded-2xl overflow-hidden shadow-inner border border-gray-100 dark:border-gray-700 bg-gray-900">
                        <img src="{{ asset('storage/' . $artikel->gambar) }}" alt="{{ $artikel->judul }}"
                            class="w-full h-full object-cover">
                    </div>
                @endif

                <!-- Konten/Isi Artikel -->
                <div
                    class="prose dark:prose-invert max-w-none text-sm sm:text-base leading-relaxed text-gray-700 dark:text-gray-300 pt-2">
                    {!! $artikel->isi !!}
                </div>

                <!-- Footer Bagian Bawah Card -->
                <div
                    class="pt-6 border-t border-gray-100 dark:border-gray-700 flex items-center justify-between text-xs text-gray-400">
                    <span>Terakhir diperbarui: {{ $artikel->updated_at->diffForHumans() }}</span>
                    <a href="{{ route('user.artikel.index') }}"
                        class="font-bold text-indigo-600 dark:text-indigo-400 hover:underline flex items-center gap-1.5">
                        <i class="fa-solid fa-arrow-left"></i>
                        <span>Kembali</span>
                    </a>
                </div>

            </div>
        </div>

    </div>
@endsection
