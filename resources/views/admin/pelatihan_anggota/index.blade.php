@extends('layouts.admin')

@section('content')
    <div class="container" x-data="{ activeModal: null, modalType: null, selectedItem: null }">
        {{-- Header Section --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8 gap-4">
            <div>
                <h2 class="text-3xl font-bold text-gray-800 tracking-tight">Verifikasi Pembayaran Pelatihan</h2>
                <p class="text-sm text-gray-500 mt-1">Kelola dan verifikasi daftar pembayaran dari peserta pelatihan.</p>
            </div>
        </div>

        {{-- 3 Button Navigasi Status Pembayaran --}}
        <div class="flex flex-wrap items-center gap-3 mb-6">
            <a href="{{ route('admin.pelatihan-anggota.index', ['status' => 'pending']) }}"
                class="px-4 py-2.5 rounded-xl text-sm font-semibold transition flex items-center gap-2 {{ request('status', 'pending') == 'pending' ? 'bg-amber-500 text-white shadow-md shadow-amber-500/20' : 'bg-white text-gray-600 hover:bg-gray-100 border border-gray-200' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Pembayaran Diproses
            </a>

            <a href="{{ route('admin.pelatihan-anggota.index', ['status' => 'diterima']) }}"
                class="px-4 py-2.5 rounded-xl text-sm font-semibold transition flex items-center gap-2 {{ request('status') == 'diterima' ? 'bg-emerald-600 text-white shadow-md shadow-emerald-600/20' : 'bg-white text-gray-600 hover:bg-gray-100 border border-gray-200' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Pembayaran Disetujui
            </a>

            <a href="{{ route('admin.pelatihan-anggota.index', ['status' => 'ditolak']) }}"
                class="px-4 py-2.5 rounded-xl text-sm font-semibold transition flex items-center gap-2 {{ request('status') == 'ditolak' ? 'bg-red-600 text-white shadow-md shadow-red-600/20' : 'bg-white text-gray-600 hover:bg-gray-100 border border-gray-200' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Pembayaran Ditolak
            </a>
        </div>

        {{-- Alert Notification --}}
        @if (session('success'))
            <div
                class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
                <button type="button" class="text-emerald-500 hover:text-emerald-700"
                    onclick="this.parentElement.remove();">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>
        @endif

        {{-- Main Card --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            {{-- Card Header / Toolbar --}}
            <div class="p-6 border-b border-gray-100 flex items-center gap-3">
                <div class="p-2 bg-indigo-50 rounded-xl text-indigo-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012-2m-6 9l2 2 4-4">
                        </path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-800">Daftar Verifikasi Pembayaran</h3>
                    <p class="text-xs text-gray-400">Pastikan bukti transfer valid sebelum menyetujui pembayaran</p>
                </div>
            </div>

            {{-- Table Section --}}
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr
                            class="bg-gray-50/70 border-b border-gray-100 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            <th class="py-4 px-6">No</th>
                            <th class="py-4 px-6">Nama Peserta</th>
                            <th class="py-4 px-6">Nama Pelatihan</th>
                            <th class="py-4 px-6">Jumlah Bayar</th>
                            <th class="py-4 px-6 text-center">Bukti Transfer</th>
                            <th class="py-4 px-6">Catatan Peserta</th>
                            <th class="py-4 px-6">Tanggal Upload</th>
                            <th class="py-4 px-6 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm text-gray-600">
                        @forelse($pembayaranList as $index => $item)
                            <tr class="hover:bg-gray-50/50 transition duration-150">
                                <td class="py-4 px-6 font-medium text-gray-400">
                                    {{ $pembayaranList->firstItem() + $index }}
                                </td>
                                <td class="py-4 px-6 font-semibold text-gray-800">
                                    {{ $item->user->name ?? '-' }}
                                </td>
                                <td class="py-4 px-6 text-gray-700">
                                    {{ $item->pelatihan->judul ?? '-' }}
                                </td>
                                <td class="py-4 px-6 font-semibold text-indigo-600 whitespace-nowrap">
                                    Rp {{ number_format($item->jumlah_pembayaran, 0, ',', '.') }}
                                </td>
                                <td class="py-4 px-6 text-center">
                                    @if ($item->bukti_pembayaran)
                                        <button type="button"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-cyan-50 text-cyan-600 hover:bg-cyan-100 rounded-lg text-xs font-semibold transition"
                                            @click="
                                                activeModal = true; 
                                                modalType = 'proof'; 
                                                selectedItem = {{ json_encode($item) }}; 
                                                selectedItem.user_name = '{{ addslashes($item->user->name ?? '-') }}'; 
                                                selectedItem.pelatihan_judul = '{{ addslashes($item->pelatihan->judul ?? '-') }}'; 
                                                selectedItem.bukti_url = '{{ $item->bukti_pembayaran ? asset('storage/' . $item->bukti_pembayaran) : '' }}'
                                            ">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                </path>
                                            </svg>
                                            Lihat
                                        </button>
                                    @else
                                        <span class="text-xs text-gray-400 italic">Tidak ada</span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 text-gray-500 text-xs">
                                    {{ $item->catatan ?? '-' }}
                                </td>
                                <td class="py-4 px-6 whitespace-nowrap text-xs text-gray-500">
                                    {{ $item->tanggal_pembayaran }}
                                </td>
                                <td class="py-4 px-6 text-center whitespace-nowrap">
                                    <div class="inline-flex items-center justify-center gap-1.5">
                                        {{-- Tombol Show Detail --}}
                                        <a href="{{ route('admin.pelatihan-anggota.show', $item->id) }}"
                                            class="p-2 bg-blue-50 text-blue-600 hover:bg-blue-100 rounded-lg transition inline-flex items-center justify-center"
                                            title="Detail Pembayaran">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </a>

                                        {{-- Tombol Verifikasi --}}
                                        <button type="button"
                                            class="p-2 bg-purple-50 text-purple-600 hover:bg-purple-100 rounded-lg transition"
                                            title="Verifikasi Pembayaran"
                                            @click="activeModal = true; modalType = 'verify'; selectedItem = {{ json_encode($item) }}; selectedItem.user_name = '{{ addslashes($item->user->name ?? '-') }}'; selectedItem.pelatihan_judul = '{{ addslashes($item->pelatihan->judul ?? '-') }}'; selectedItem.bukti_url = '{{ $item->bukti_pembayaran ? asset('storage/' . $item->bukti_pembayaran) : '' }}'">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                                </path>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="py-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div
                                            class="w-12 h-12 bg-gray-50 text-gray-400 rounded-full flex items-center justify-center mb-3">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012-2">
                                                </path>
                                            </svg>
                                        </div>
                                        <p class="text-sm font-semibold text-gray-600">Belum ada data pembayaran yang ditemukan.</p>
                                        <p class="text-xs text-gray-400 mt-0.5">Silakan pilih tab status lain di atas.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination Footer --}}
            @if ($pembayaranList->hasPages())
                <div class="p-6 border-t border-gray-100">
                    {{ $pembayaranList->withQueryString()->links() }}
                </div>
            @endif
        </div>

        {{-- Modal Wrapper Utama --}}
        <div x-show="activeModal" style="display: none;"
            class="fixed inset-0 z-50 overflow-y-auto bg-gray-900/50 backdrop-blur-sm flex items-center justify-center p-4">

            <div class="bg-white rounded-2xl shadow-2xl border border-gray-100 w-full max-w-lg overflow-hidden text-left"
                @click.outside="activeModal = null; selectedItem = null">

                {{-- KONTEN MODAL: VERIFIKASI (TERIMA / TOLAK) --}}
                <template x-if="modalType === 'verify' && selectedItem">
                    <form :action="'{{ url('admin/pelatihan/verifikasi-pembayaran') }}/' + selectedItem.id" method="POST"
                        x-data="{ actionType: 'diterima' }">
                        @csrf
                        <input type="hidden" name="aksi" :value="actionType === 'diterima' ? 'verified' : 'rejected'">

                        <div class="flex items-center justify-between border-b border-gray-100 px-6 py-4">
                            <h5 class="font-bold text-gray-800 text-base">Verifikasi Pembayaran Peserta</h5>
                            <button type="button" class="text-gray-400 hover:text-gray-600"
                                @click="activeModal = null; selectedItem = null">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>

                        <div class="p-6 space-y-4 text-sm">
                            <div class="bg-gray-50 p-3.5 rounded-xl border border-gray-100 space-y-1">
                                <p class="text-xs text-gray-500 font-medium">Peserta: <strong class="text-gray-800"
                                        x-text="selectedItem.user_name"></strong></p>
                                <p class="text-xs text-gray-500 font-medium">Pelatihan: <strong class="text-gray-800"
                                        x-text="selectedItem.pelatihan_judul"></strong></p>
                                <p class="text-xs text-gray-500 font-medium">Nominal: <strong class="text-indigo-600"
                                        x-text="'Rp ' + Number(selectedItem.jumlah_pembayaran).toLocaleString('id-ID')"></strong>
                                </p>
                            </div>

                            <div x-show="actionType === 'ditolak'" x-transition class="space-y-1.5">
                                <label for="keterangan_admin"
                                    class="text-xs font-semibold text-red-600 uppercase tracking-wider block">Alasan
                                    Penolakan:</label>
                                <textarea name="keterangan_admin"
                                    class="w-full p-3 bg-red-50/30 border border-red-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-red-500 focus:border-transparent outline-none transition"
                                    rows="3" placeholder="Contoh: Nominal transfer tidak sesuai atau foto bukti buram."
                                    :required="actionType === 'ditolak'"></textarea>
                            </div>

                            <div x-show="actionType === 'diterima'" class="text-xs text-gray-500 italic">
                                Klik tombol <strong>Setujui Pembayaran</strong> di bawah untuk memvalidasi, atau klik
                                <strong>Tolak</strong> jika ingin memberikan alasan penolakan.
                            </div>
                        </div>

                        <div class="flex items-center justify-between border-t border-gray-100 px-6 py-3.5 bg-gray-50/50">
                            <button type="button"
                                class="px-4 py-2 bg-gray-100 text-gray-600 hover:bg-gray-200 rounded-xl text-sm font-semibold transition"
                                @click="activeModal = null; selectedItem = null">Batal</button>

                            <div class="flex items-center gap-2">
                                <template x-if="actionType === 'diterima'">
                                    <button type="button" @click="actionType = 'ditolak'"
                                        class="px-4 py-2 bg-red-50 text-red-600 hover:bg-red-100 rounded-xl text-sm font-semibold transition">
                                        Tolak Pembayaran
                                    </button>
                                </template>
                                <template x-if="actionType === 'ditolak'">
                                    <button type="button" @click="actionType = 'diterima'"
                                        class="px-4 py-2 bg-gray-200 text-gray-700 hover:bg-gray-300 rounded-xl text-sm font-semibold transition">
                                        Kembali
                                    </button>
                                </template>

                                <button type="submit"
                                    :class="actionType === 'diterima' ?
                                        'bg-emerald-600 hover:bg-emerald-700 shadow-emerald-200' :
                                        'bg-red-600 hover:bg-red-700 shadow-red-200'"
                                    class="px-4 py-2 text-white rounded-xl text-sm font-semibold shadow-lg transition"
                                    @click="if(actionType === 'diterima') { return confirm('Yakin ingin menyetujui pembayaran ini?'); }"
                                    x-text="actionType === 'diterima' ? 'Setujui Pembayaran' : 'Kirim Penolakan'">
                                </button>
                            </div>
                        </div>
                    </form>
                </template>

                {{-- KONTEN MODAL: LIHAT BUKTI TRANSFER --}}
                <template x-if="modalType === 'proof' && selectedItem">
                    <div>
                        <div class="flex items-center justify-between border-b border-gray-100 px-6 py-4">
                            <h5 class="font-bold text-gray-800 text-base">Bukti Pembayaran Peserta</h5>
                            <button type="button" class="text-gray-400 hover:text-gray-600"
                                @click="activeModal = null; selectedItem = null">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>

                        <div class="p-6 space-y-4 text-sm text-gray-600">
                            <div class="bg-gray-50 p-3.5 rounded-xl border border-gray-100 space-y-1">
                                <p class="text-xs text-gray-500 font-medium">Peserta: <strong class="text-gray-800"
                                        x-text="selectedItem.user_name"></strong></p>
                                <p class="text-xs text-gray-500 font-medium">Pelatihan: <strong class="text-gray-800"
                                        x-text="selectedItem.pelatihan_judul"></strong></p>
                                <p class="text-xs text-gray-500 font-medium">Nominal: <strong class="text-indigo-600"
                                        x-text="'Rp ' + Number(selectedItem.jumlah_pembayaran || 0).toLocaleString('id-ID')"></strong>
                                </p>
                            </div>

                            <div
                                class="overflow-hidden rounded-xl border border-gray-200 bg-gray-900 flex items-center justify-center relative group min-h-[250px] max-h-[400px]">
                                <template x-if="selectedItem.bukti_url">
                                    <div class="relative w-full h-full flex items-center justify-center">
                                        <img :src="selectedItem.bukti_url" alt="Bukti Transfer"
                                            class="object-contain w-full max-h-[400px]">
                                        <div
                                            class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-3">
                                            <a :href="selectedItem.bukti_url" target="_blank"
                                                class="px-3 py-2 bg-white/90 hover:bg-white text-gray-800 rounded-lg text-xs font-semibold shadow transition flex items-center gap-1.5">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14">
                                                    </path>
                                                </svg>
                                                Perbesar / Tab Baru
                                            </a>
                                        </div>
                                    </div>
                                </template>
                                <template x-if="!selectedItem.bukti_url">
                                    <div class="p-8 text-center text-gray-400">
                                        <p class="text-sm">Bukti pembayaran belum diunggah oleh peserta.</p>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <div class="flex items-center justify-between border-t border-gray-100 px-6 py-3.5 bg-gray-50/50">
                            <template x-if="selectedItem.bukti_url">
                                <a :href="selectedItem.bukti_url" target="_blank"
                                    class="px-4 py-2 bg-cyan-50 text-cyan-600 hover:bg-cyan-100 rounded-xl text-sm font-semibold transition">
                                    Buka di Tab Baru
                                </a>
                            </template>
                            <div x-show="!selectedItem.bukti_url"></div>

                            <button type="button"
                                class="px-4 py-2 bg-gray-100 text-gray-600 hover:bg-gray-200 rounded-xl text-sm font-semibold transition"
                                @click="activeModal = null; selectedItem = null">Tutup</button>
                        </div>
                    </div>
                </template>

            </div>
        </div>

    </div>
@endsection