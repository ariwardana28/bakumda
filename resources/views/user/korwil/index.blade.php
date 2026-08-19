@extends('layouts.app')

@section('title', 'Daftar Korwil')

@section('content')
    <div class="max-w-6xl mx-auto py-8 px-4 space-y-6" x-data="{
        search: '',
        perPage: '10',
        provinces: [
            'Aceh', 'Sumatera Utara', 'Sumatera Barat', 'Riau', 'Kepulauan Riau',
            'Jambi', 'Sumatera Selatan', 'Bengkulu', 'Lampung', 'Kepulauan Bangka Belitung',
            'DKI Jakarta', 'Jawa Barat', 'Banten', 'Jawa Tengah', 'DI Yogyakarta',
            'Jawa Timur', 'Bali', 'Nusa Tenggara Barat', 'Nusa Tenggara Timur',
            'Kalimantan Barat', 'Kalimantan Tengah', 'Kalimantan Selatan', 'Kalimantan Timur', 'Kalimantan Utara',
            'Sulawesi Utara', 'Gorontalo', 'Sulawesi Tengah', 'Sulawesi Barat', 'Sulawesi Selatan', 'Sulawesi Tenggara',
            'Maluku', 'Maluku Utara', 'Papua', 'Papua Barat', 'Papua Selatan', 'Papua Tengah', 'Papua Pegunungan', 'Papua Barat Daya'
        ],
        get filteredProvinces() {
            let result = this.provinces.filter(p => p.toLowerCase().includes(this.search.toLowerCase()));
            if (this.perPage !== 'all') {
                return result.slice(0, parseInt(this.perPage));
            }
            return result;
        }
    }">

        {{-- Kartu Utama --}}
        <div
            class="bg-slate-50/70 border border-slate-200/80 rounded-3xl shadow-lg backdrop-blur-sm overflow-hidden relative">

            {{-- Header Background Banner (Merah Pekat / Sesuai Tema) --}}
            <div class="h-40 relative flex items-center justify-center px-6 text-center"
                style="background: linear-gradient(135deg, #be123c 0%, #881337 100%);">
                {{-- Dot Pattern Overlay --}}
                <div
                    class="absolute inset-0 bg-[radial-gradient(#ffffff_1px,transparent_1px)] [background-size:12px_12px] opacity-10">
                </div>

                <div class="relative z-10 text-white space-y-2">
                    <div
                        class="w-12 h-12 mx-auto rounded-2xl flex items-center justify-center text-lg shadow-md mb-2 bg-white text-rose-700">
                        <i class="fa-solid fa-sitemap"></i>
                    </div>
                    <h1 class="text-xl sm:text-2xl font-black tracking-tight">Daftar Koordinator Wilayah (Korwil)</h1>
                    <p class="text-xs text-rose-100 font-medium">Nama yang tercantum telah mendapat SK Mandat Oleh Direktorat Pimpinan Pusat BAKUMDA</p>
                </div>
            </div>

            {{-- Konten Tabel / Daftar Korwil --}}
            <div class="p-6 sm:p-10 space-y-6">

                {{-- Toolbar Filter (Pencarian & Show Entries) --}}
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                    {{-- Dropdown Jumlah Data --}}
                    <div class="flex items-center gap-2 text-xs sm:text-sm font-semibold text-slate-600 w-full sm:w-auto">
                        <span>Tampilkan</span>
                        <select x-model="perPage"
                            class="bg-white border border-slate-300 rounded-xl px-3 py-1.5 focus:outline-none focus:ring-2 focus:ring-rose-500 font-bold text-slate-700 shadow-sm cursor-pointer">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="all">Semua</option>
                        </select>
                        <span>data</span>
                    </div>

                    {{-- Kotak Pencarian --}}
                    <div class="relative w-full sm:w-72">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400">
                            <i class="fa-solid fa-magnifying-glass text-xs"></i>
                        </span>
                        <input type="text" x-model="search" placeholder="Cari nama provinsi..."
                            class="w-full pl-10 pr-4 py-2 bg-white border border-slate-300 rounded-2xl text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-rose-500 shadow-sm text-slate-800 placeholder-slate-400 font-medium transition">
                    </div>
                </div>

                {{-- Tabel Data --}}
                <div class="w-full overflow-x-auto rounded-2xl border border-slate-200/80 bg-white shadow-sm">
                    <table class="w-full text-left border-collapse text-xs sm:text-sm">
                        <thead>
                            <tr
                                class="bg-slate-100/75 text-slate-700 uppercase tracking-wider text-[11px] font-bold border-b border-slate-200">
                                <th class="py-3.5 px-4 text-center w-16">No</th>
                                <th class="py-3.5 px-4">Nama Provinsi</th>
                                <th class="py-3.5 px-4 text-center w-40">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200/60 font-medium text-slate-700">
                            <template x-for="(province, index) in filteredProvinces" :key="province">
                                <tr class="hover:bg-slate-50/80 transition-colors">
                                    <td class="py-3 px-4 text-center text-slate-500 font-semibold" x-text="index + 1"></td>
                                    <td class="py-3 px-4 font-bold text-slate-900" x-text="province"></td>
                                    <td class="py-3 px-4 text-center">
                                        <div class="flex items-center justify-center gap-1.5">
                                            <a :href="`{{ route('user.korwil.show', ':province') }}`.replace(':province',
                                                encodeURIComponent(province))"
                                                class="px-3 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-700 font-bold text-[11px] rounded-xl transition-colors border border-rose-200/60">
                                                Detail
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            </template>

                            {{-- Kondisi Jika Data Tidak Ditemukan --}}
                            <template x-if="filteredProvinces.length === 0">
                                <tr>
                                    <td colspan="3"
                                        class="py-8 text-center text-slate-400 font-medium text-xs sm:text-sm">
                                        <i class="fa-solid fa-folder-open text-2xl mb-2 block"></i>
                                        Data provinsi tidak ditemukan.
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>

                {{-- Tombol Kembali --}}
                <div class="pt-6 border-t border-slate-200/60 flex items-center justify-between">
                    <a href="javascript:history.back()"
                        class="py-2.5 px-5 rounded-2xl bg-white hover:bg-slate-100 text-slate-700 font-semibold text-xs uppercase tracking-wider transition flex items-center gap-2 border border-slate-200 shadow-sm cursor-pointer">
                        <i class="fa-solid fa-arrow-left text-rose-700"></i> <span>Kembali</span>
                    </a>
                    <span class="text-[11px] text-slate-400 font-medium">BAKUMDA &copy; 2024</span>
                </div>

            </div>
        </div>
    </div>
@endsection
