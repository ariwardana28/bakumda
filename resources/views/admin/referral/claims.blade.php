@extends('layouts.admin')

@section('title', 'Manajemen Klaim Referral')

@section('content')
    <div class="px-3 md:px-8 py-4 md:py-6 space-y-6 md:space-y-8 max-w-7xl mx-auto"
        x-data="{ openModal: false, selectedClaim: null }">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Manajemen Klaim Referral</h1>
                <p class="text-sm text-gray-500 mt-1">Tinjau dan proses permintaan klaim reward dari pengguna.</p>
            </div>
        </div>

        <!-- Main Content -->
        <div class="bg-white p-5 sm:p-6 md:p-8 rounded-2xl md:rounded-3xl border border-slate-200/80 shadow-sm">
            <!-- Tabs Filter -->
            <div class="border-b border-gray-200 mb-5">
                <nav class="-mb-px flex space-x-6" aria-label="Tabs">
                    <a href="{{ route('admin.referral.claims', ['status' => 'pending']) }}"
                        class="{{ $statusFilter == 'pending' ? 'border-red-500 text-red-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-3 px-1 border-b-2 font-bold text-xs uppercase tracking-wider flex items-center gap-2">
                        Pending
                        @if (($statusCounts['pending'] ?? 0) > 0)
                            <span
                                class="bg-red-100 text-red-600 text-[10px] font-bold px-2 py-0.5 rounded-full">{{ $statusCounts['pending'] }}</span>
                        @endif
                    </a>
                    <a href="{{ route('admin.referral.claims', ['status' => 'approved']) }}"
                        class="{{ $statusFilter == 'approved' ? 'border-green-500 text-green-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-3 px-1 border-b-2 font-bold text-xs uppercase tracking-wider">
                        Disetujui
                    </a>
                    <a href="{{ route('admin.referral.claims', ['status' => 'rejected']) }}"
                        class="{{ $statusFilter == 'rejected' ? 'border-gray-500 text-gray-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-3 px-1 border-b-2 font-bold text-xs uppercase tracking-wider">
                        Ditolak
                    </a>
                    <a href="{{ route('admin.referral.claims', ['status' => 'all']) }}"
                        class="{{ $statusFilter == 'all' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-3 px-1 border-b-2 font-bold text-xs uppercase tracking-wider">
                        Semua
                    </a>
                </nav>
            </div>

            <!-- Tabel Klaim -->
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs sm:text-sm">
                    <thead>
                        <tr
                            class="border-b border-slate-200 text-slate-400 font-semibold uppercase text-[11px] tracking-wider">
                            <th class="py-3 px-4">Pengguna</th>
                            <th class="py-3 px-4">Jumlah</th>
                            <th class="py-3 px-4">Rekening Tujuan</th>
                            <th class="py-3 px-4">Tanggal Pengajuan</th>
                            <th class="py-3 px-4">Status</th>
                            <th class="py-3 px-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700 font-medium">
                        @forelse($claims as $claim)
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="py-3.5 px-4">
                                    <div class="font-semibold text-slate-900">{{ $claim->user->name }}</div>
                                    <div class="text-slate-500 text-xs">{{ $claim->user->email }}</div>
                                </td>
                                <td class="py-3.5 px-4 font-mono font-bold text-emerald-600">
                                    Rp {{ number_format($claim->amount, 0, ',', '.') }}
                                </td>
                                <td class="py-3.5 px-4">
                                    <div class="font-semibold text-slate-900 uppercase">{{ $claim->bank_name }}</div>
                                    <div class="font-mono text-slate-500 text-xs">{{ $claim->account_number }}</div>
                                    <div class="text-slate-500 text-xs">a.n {{ $claim->account_name }}</div>
                                </td>
                                <td class="py-3.5 px-4 text-slate-500">
                                    {{ $claim->created_at->format('d M Y, H:i') }}
                                </td>
                                <td class="py-3.5 px-4">
                                    @if ($claim->status == 'pending')
                                        <span
                                            class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-50 text-amber-600 border border-amber-200 uppercase">
                                            {{ $claim->status }}
                                        </span>
                                    @elseif($claim->status == 'approved')
                                        <span
                                            class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-green-50 text-green-600 border border-green-200 uppercase">
                                            Disetujui
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-red-50 text-red-600 border border-red-200 uppercase">
                                            Ditolak
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4 text-center">
                                    <button @click="openModal = true; selectedClaim = {{ $claim->toJson() }}"
                                        class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-[10px] font-bold rounded-lg transition-all cursor-pointer">
                                        Tinjau
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-8 text-center text-slate-400 text-xs italic">
                                    Tidak ada data klaim dengan status '{{ $statusFilter }}'.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($claims->hasPages())
                <div class="pt-6">
                    {{ $claims->links() }}
                </div>
            @endif
        </div>

        <!-- MODAL TINJAU KLAIM -->
        <div x-show="openModal" style="display: none;"
            class="fixed inset-0 z-50 overflow-y-auto bg-stone-900/60 backdrop-blur-sm flex items-center justify-center p-4"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

            <div @click.away="openModal = false"
                class="bg-white rounded-2xl max-w-md w-full p-5 shadow-2xl border border-stone-100 space-y-4 relative text-stone-900"
                x-transition:enter="transition ease-out duration-300 transform"
                x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0">

                <!-- Header Modal -->
                <div class="flex items-center justify-between border-b border-stone-100 pb-3">
                    <div class="flex items-center gap-2.5">
                        <div
                            class="w-8 h-8 rounded-lg bg-red-100 text-red-700 flex items-center justify-center text-sm font-bold">
                            <i class="fa-solid fa-file-invoice-dollar"></i>
                        </div>
                        <div>
                            <h3 class="text-base font-black text-stone-900">Tinjau Permintaan Klaim</h3>
                            <p class="text-[11px] text-stone-500" x-text="selectedClaim?.user?.name"></p>
                        </div>
                    </div>
                    <button @click="openModal = false"
                        class="w-7 h-7 rounded-full bg-stone-100 hover:bg-stone-200 text-stone-500 flex items-center justify-center transition-colors cursor-pointer">
                        <i class="fa-solid fa-xmark text-xs"></i>
                    </button>
                </div>

                <!-- Detail Informasi Klaim -->
                <div class="space-y-3 text-xs">
                    <div class="bg-red-50 border border-red-200 p-3 rounded-xl space-y-2">
                        <div class="flex justify-between">
                            <span class="text-stone-500">Jumlah Klaim:</span>
                            <span class="font-extrabold text-red-700"
                                x-text="'Rp ' + new Intl.NumberFormat('id-ID').format(selectedClaim?.amount || 0)"></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-stone-500">Tanggal Pengajuan:</span>
                            <span class="font-semibold text-stone-700"
                                x-text="new Date(selectedClaim?.created_at).toLocaleString('id-ID', { day: 'numeric', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit' })"></span>
                        </div>
                    </div>

                    <div class="space-y-1">
                        <p class="font-bold text-stone-700 uppercase tracking-wide text-[10px]">Tujuan Rekening</p>
                        <div class="p-3 bg-stone-50 rounded-xl border border-stone-200 space-y-1 font-medium">
                            <div class="flex justify-between">
                                <span class="text-stone-500">Bank:</span>
                                <span class="font-bold text-stone-900 uppercase" x-text="selectedClaim?.bank_name"></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-stone-500">No. Rekening:</span>
                                <span class="font-mono font-bold text-stone-900"
                                    x-text="selectedClaim?.account_number"></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-stone-500">Atas Nama:</span>
                                <span class="font-bold text-stone-900" x-text="selectedClaim?.account_name"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Aksi (jika status pending) -->
                <template x-if="selectedClaim?.status === 'pending'">
                    <form :action="`/admin/referral/claims/${selectedClaim?.id}/update`" method="POST"
                        class="pt-2 border-t border-stone-100 space-y-3" x-data="{ action: 'approved' }">
                        @csrf
                        <input type="hidden" name="status" x-model="action">

                        <div class="space-y-1">
                            <label class="text-[11px] font-bold text-stone-700 uppercase tracking-wide">Aksi</label>
                            <div class="flex gap-2">
                                <button type="button" @click="action = 'approved'"
                                    :class="{ 'bg-green-600 text-white': action === 'approved', 'bg-stone-100 text-stone-700': action !== 'approved' }"
                                    class="flex-1 py-2 rounded-lg text-xs font-bold transition-all">Setujui</button>
                                <button type="button" @click="action = 'rejected'"
                                    :class="{ 'bg-red-600 text-white': action === 'rejected', 'bg-stone-100 text-stone-700': action !== 'rejected' }"
                                    class="flex-1 py-2 rounded-lg text-xs font-bold transition-all">Tolak</button>
                            </div>
                        </div>

                        <template x-if="action === 'rejected'">
                            <div class="space-y-1">
                                <label for="rejection_reason"
                                    class="text-[11px] font-bold text-stone-700 uppercase tracking-wide">Alasan
                                    Penolakan</label>
                                <textarea name="rejection_reason" id="rejection_reason" rows="2" required
                                    class="w-full px-3 py-1.5 rounded-lg border border-stone-200 text-xs font-medium text-stone-900 focus:ring-2 focus:ring-red-500 focus:outline-none"
                                    placeholder="Contoh: Nomor rekening tidak valid."></textarea>
                            </div>
                        </template>

                        <button type="submit"
                            class="w-full py-2.5 bg-stone-900 hover:bg-stone-800 text-white font-bold text-xs rounded-xl transition-all shadow-md cursor-pointer">
                            Konfirmasi Aksi
                        </button>
                    </form>
                </template>
            </div>
        </div>
    </div>
@endsection