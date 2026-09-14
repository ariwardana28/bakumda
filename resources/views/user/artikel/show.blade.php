@extends('layouts.app')

@section('content')
    @push('styles')
        <style>
            .article-content {
                color: #334155;
                font-size: 1rem;
                line-height: 1.9;
            }

            .article-content p {
                margin: 0 0 1.25rem;
            }

            .article-content p:last-child {
                margin-bottom: 0;
            }

            .article-content br {
                content: '';
                display: block;
                margin-bottom: 0.65rem;
            }

            .article-content h1,
            .article-content h2,
            .article-content h3,
            .article-content h4 {
                color: #0f172a;
                font-weight: 800;
                line-height: 1.3;
                margin: 2rem 0 0.75rem;
            }

            .article-content h1 { font-size: 1.75rem; }
            .article-content h2 { font-size: 1.5rem; }
            .article-content h3 { font-size: 1.25rem; }
            .article-content h4 { font-size: 1.125rem; }

            .article-content ul,
            .article-content ol {
                margin: 0 0 1.25rem 1.5rem;
                padding-left: 1rem;
            }

            .article-content ul { list-style: disc; }
            .article-content ol { list-style: decimal; }

            .article-content li {
                margin-bottom: 0.45rem;
                padding-left: 0.25rem;
            }

            .article-content a {
                color: #2563eb;
                text-decoration: underline;
                text-underline-offset: 3px;
            }

            .article-content img {
                height: auto;
                max-width: 100%;
                border-radius: 0.75rem;
                margin: 1.5rem auto;
            }

            .article-content blockquote {
                margin: 1.5rem 0;
                padding: 0.75rem 1rem;
                border-left: 4px solid #2563eb;
                background: #eff6ff;
                color: #475569;
                border-radius: 0 0.5rem 0.5rem 0;
            }

            @media (min-width: 640px) {
                .article-content {
                    font-size: 1.125rem;
                }
            }
        </style>
    @endpush

    @php
        $canManage = auth()->check() && auth()->id() === $artikel->users_id;
        $backRoute = $canManage ? route('artikel.index') : route('artikel.index.public');
    @endphp

    <div class="min-h-screen bg-slate-50 py-8 sm:py-12">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Tombol Kembali & Aksi Atas -->
        <div class="mb-6 px-4 sm:px-0 flex items-center justify-between">
            <a href="{{ $backRoute }}"
                class="inline-flex items-center gap-2 text-xs font-bold text-slate-500 hover:text-blue-600 uppercase tracking-wider transition">
                <i class="fa-solid fa-arrow-left text-sm"></i>
                <span>{{ __('Kembali ke Daftar Artikel') }}</span>
            </a>

            <!-- Tombol Edit Cepat (Opsional jika ingin langsung edit dari halaman detail) -->
            @if ($canManage)
                <a href="{{ route('artikel.edit', $artikel) }}"
                    class="px-4 py-2 rounded-xl bg-indigo-50 dark:bg-indigo-950/50 text-indigo-600 dark:text-indigo-400 text-xs font-bold uppercase tracking-wider hover:bg-indigo-100 dark:hover:bg-indigo-900 transition flex items-center gap-2 shadow-xs">
                    <i class="fa-solid fa-pen-to-square text-xs"></i>
                    <span>{{ __('Edit Artikel') }}</span>
                </a>
            @endif
        </div>

        <!-- Main Card Container -->
        <article class="bg-white overflow-hidden rounded-3xl border border-slate-200 shadow-xl shadow-slate-200/50 relative">

            <!-- Background Ambient Accent -->
            <div class="absolute inset-x-0 top-0 h-1.5 bg-gradient-to-r from-blue-600 via-indigo-500 to-cyan-400"></div>

            <div class="p-6 sm:p-10 lg:p-14 relative z-10 space-y-8 text-slate-900">

                <!-- Meta Informasi (Kategori, Tanggal, & Status) -->
                <div
                    class="flex flex-wrap items-center gap-3 pb-5 border-b border-slate-100 text-xs">
                    <div class="flex flex-wrap items-center gap-2">
                        <!-- Badge Kategori -->
                        @if (isset($artikel->kategori))
                            <span
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-blue-50 text-blue-700 font-bold">
                                <i class="fa-solid fa-tag text-[10px]"></i>
                                {{ $artikel->kategori->nama }}
                            </span>
                        @endif

                        <!-- Tanggal Publikasi -->
                        <span class="inline-flex items-center gap-1.5 text-slate-500 font-medium">
                            <i class="fa-solid fa-calendar-day text-[10px]"></i>
                            {{ isset($artikel->tanggal) ? \Carbon\Carbon::parse($artikel->tanggal)->format('d F Y') : $artikel->created_at->format('d F Y') }}
                        </span>
                    </div>

                    @if ($canManage)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider {{ $artikel->status == 'published' ? 'bg-emerald-50 text-emerald-700' : 'bg-amber-50 text-amber-700' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ $artikel->status == 'published' ? 'bg-emerald-500' : 'bg-amber-500' }}"></span>
                            {{ $artikel->status == 'published' ? 'Published' : 'Draft' }}
                        </span>
                    @endif
                </div>

                <!-- Judul Artikel -->
                <div class="space-y-2">
                    <h1 class="text-3xl sm:text-4xl font-black text-slate-950 tracking-tight leading-tight">
                        {{ $artikel->judul }}
                    </h1>
                </div>

                <!-- Gambar Unggulan (Jika Ada) -->
                @if ($artikel->gambar)
                    <div
                        class="w-full aspect-[16/8] rounded-2xl overflow-hidden shadow-lg border border-slate-100 bg-slate-900">
                        <img src="{{ asset('storage/' . $artikel->gambar) }}" alt="{{ $artikel->judul }}"
                            class="w-full h-full object-cover">
                    </div>
                @endif

                <!-- Konten/Isi Artikel -->
                <div class="article-content max-w-none pt-2">
                    {!! $artikel->isi !!}
                </div>

                <!-- Footer Bagian Bawah Card -->
                <div
                    class="pt-6 border-t border-slate-100 flex items-center justify-between text-xs text-slate-400">
                    <span>Terakhir diperbarui {{ $artikel->updated_at->diffForHumans() }}</span>
                    <a href="{{ $backRoute }}"
                        class="font-bold text-blue-600 hover:text-blue-700 flex items-center gap-1.5">
                        <i class="fa-solid fa-arrow-left"></i>
                        <span>Kembali</span>
                    </a>
                </div>

            </div>
        </article>

        </div>
    </div>
@endsection
