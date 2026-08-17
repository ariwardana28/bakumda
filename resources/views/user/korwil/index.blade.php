@extends('layouts.app')

@section('title', 'Daftar Korwil')

@section('content')
    <div class="max-w-6xl mx-auto py-8 px-4 space-y-6">

        {{-- Kartu Utama --}}
        <div class="bg-slate-50/70 border border-slate-200/80 rounded-3xl shadow-lg backdrop-blur-sm overflow-hidden relative">

            {{-- Header Background Banner (Merah Pekat / Sesuai Tema) --}}
            <div class="h-40 relative flex items-center justify-center px-6 text-center"
                style="background: linear-gradient(135deg, #be123c 0%, #881337 100%);">
                {{-- Dot Pattern Overlay --}}
                <div class="absolute inset-0 bg-[radial-gradient(#ffffff_1px,transparent_1px)] [background-size:12px_12px] opacity-10"></div>

                <div class="relative z-10 text-white space-y-2">
                    <div class="w-12 h-12 mx-auto rounded-2xl flex items-center justify-center text-lg shadow-md mb-2 bg-white text-rose-700">
                        <i class="fa-solid fa-sitemap"></i>
                    </div>
                    <h1 class="text-xl sm:text-2xl font-black tracking-tight">Daftar Koordinator Wilayah (Korwil)</h1>
                    <p class="text-xs text-rose-100 font-medium">Direktorat Pimpinan Pusat BAKUMDA</p>
                </div>
            </div>

            {{-- Konten Tabel / Daftar Korwil --}}
            <div class="p-6 sm:p-10 space-y-6">

                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="text-xs sm:text-sm font-semibold text-slate-600">
                        Menampilkan data Koordinator Wilayah aktif yang terdaftar dalam sistem.
                    </div>
                </div>

                {{-- Tabel Data --}}
                <div class="w-full overflow-x-auto rounded-2xl border border-slate-200/80 bg-white shadow-sm">
                    <table class="w-full text-left border-collapse text-xs sm:text-sm">
                        <thead>
                            <tr class="bg-slate-100/75 text-slate-700 uppercase tracking-wider text-[11px] font-bold border-b border-slate-200">
                                <th class="py-3.5 px-4 text-center w-12">No</th>
                                <th class="py-3.5 px-4">Nama Anggota</th>
                                <th class="py-3.5 px-4">Jabatan</th>
                                <th class="py-3.5 px-4 text-center">Tanggal Bergabung</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200/60 font-medium text-slate-700">
                            @forelse ($korwils as $index => $item)
                                <tr class="hover:bg-slate-50/80 transition-colors">
                                    <td class="py-3.5 px-4 text-center text-slate-500">
                                        {{ $korwils->firstItem() + $index }}
                                    </td>
                                    <td class="py-3.5 px-4 font-bold text-slate-900">
                                        {{ optional(optional($item->anggotaCard)->anggota)->nama ?? 'Tidak Diketahui' }}
                                    </td>
                                    <td class="py-3.5 px-4">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-rose-50 text-rose-700 border border-rose-200/60">
                                            {{ $item->jabatan }}
                                        </span>
                                    </td>
                                    <td class="py-3.5 px-4 text-center text-slate-500">
                                        {{ $item->created_at ? $item->created_at->format('d M Y') : '-' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-8 text-center text-slate-400 font-medium">
                                        <div class="flex flex-col items-center justify-center space-y-2">
                                            <i class="fa-solid fa-folder-open text-2xl text-slate-300"></i>
                                            <span>Belum ada data Koordinator Wilayah (Korwil) yang tersedia.</span>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination Links --}}
                @if ($korwils->hasPages())
                    <div class="pt-2">
                        {{ $korwils->links() }}
                    </div>
                @endif

                {{-- Tombol Kembali --}}
                <div class="pt-6 border-t border-slate-200/60 flex items-center justify-between">
                    <a href="javascript:history.back()"
                        class="py-2.5 px-5 rounded-2xl bg-white hover:bg-slate-100 text-slate-700 font-semibold text-xs uppercase tracking-wider transition flex items-center gap-2 border border-slate-200 shadow-sm">
                        <i class="fa-solid fa-arrow-left text-rose-700"></i> <span>Kembali</span>
                    </a>
                    <span class="text-[11px] text-slate-400 font-medium">BAKUMDA &copy; 2024</span>
                </div>

            </div>
        </div>
    </div>
@endsection