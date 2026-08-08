@extends('layouts.admin')

@section('title', 'Pengajuan Anggota')

@section('content')
<!-- Filter Status Button Group & Search Bar -->
<div class="bg-white dark:bg-gray-800 p-4 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm flex flex-col xl:flex-row xl:items-center justify-between gap-4 mb-6">
    
    <!-- Button Filter berdasarkan Status dengan Badge Jumlah Data -->
    <div class="flex flex-wrap items-center gap-2">
        @php
            $currentStatus = request('status');
            // Data hitungan status sekarang dikirim dari controller ($statusCounts)
            $countSemua = $statusCounts->sum();
            $countProses = $statusCounts->get('proses', 0);
            $countMenungguPembayaran = $statusCounts->get('menunggu pembayaran', 0);
            $countPembayaranDiproses = $statusCounts->get('pembayaran diproses', 0);
            // Gabungkan hitungan untuk status 'aktif'
            $countAktif = $statusCounts->get('aktif', 0) + $statusCounts->get('approved', 0) + $statusCounts->get('disetujui', 0);
        @endphp

        <!-- Tombol Semua Status -->
        <a href="{{ request()->fullUrlWithQuery(['status' => null, 'page' => 1]) }}" 
           class="inline-flex items-center gap-2 px-3.5 py-2 text-xs font-medium rounded-xl transition-colors {{ empty($currentStatus) ? 'bg-brand-600 text-white shadow-sm' : 'bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200' }}">
            <span>Semua</span>
            <span class="px-1.5 py-0.5 text-[10px] rounded-md {{ empty($currentStatus) ? 'bg-white/20 text-white' : 'bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-200' }}">
                {{ $countSemua }}
            </span>
        </a>

        <!-- Tombol Proses -->
        <a href="{{ request()->fullUrlWithQuery(['status' => 'proses', 'page' => 1]) }}" 
           class="inline-flex items-center gap-2 px-3.5 py-2 text-xs font-medium rounded-xl transition-colors {{ $currentStatus == 'proses' ? 'bg-brand-600 text-white shadow-sm' : 'bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200' }}">
            <span>Proses</span>
            <span class="px-1.5 py-0.5 text-[10px] rounded-md {{ $currentStatus == 'proses' ? 'bg-white/20 text-white' : 'bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-200' }}">
                {{ $countProses }}
            </span>
        </a>

        <!-- Tombol Menunggu Pembayaran -->
        <a href="{{ request()->fullUrlWithQuery(['status' => 'menunggu pembayaran', 'page' => 1]) }}" 
           class="inline-flex items-center gap-2 px-3.5 py-2 text-xs font-medium rounded-xl transition-colors {{ $currentStatus == 'menunggu pembayaran' ? 'bg-brand-600 text-white shadow-sm' : 'bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200' }}">
            <span>Menunggu Pembayaran</span>
            <span class="px-1.5 py-0.5 text-[10px] rounded-md {{ $currentStatus == 'menunggu pembayaran' ? 'bg-white/20 text-white' : 'bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-200' }}">
                {{ $countMenungguPembayaran }}
            </span>
        </a>

        <!-- Tombol Pembayaran Diproses -->
        <a href="{{ request()->fullUrlWithQuery(['status' => 'pembayaran diproses', 'page' => 1]) }}" 
           class="inline-flex items-center gap-2 px-3.5 py-2 text-xs font-medium rounded-xl transition-colors {{ $currentStatus == 'pembayaran diproses' ? 'bg-brand-600 text-white shadow-sm' : 'bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200' }}">
            <span>Pembayaran Diproses</span>
            <span class="px-1.5 py-0.5 text-[10px] rounded-md {{ $currentStatus == 'pembayaran diproses' ? 'bg-white/20 text-white' : 'bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-200' }}">
                {{ $countPembayaranDiproses }}
            </span>
        </a>

        <!-- Tombol Aktif -->
        <a href="{{ request()->fullUrlWithQuery(['status' => 'aktif', 'page' => 1]) }}" 
           class="inline-flex items-center gap-2 px-3.5 py-2 text-xs font-medium rounded-xl transition-colors {{ $currentStatus == 'aktif' ? 'bg-brand-600 text-white shadow-sm' : 'bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200' }}">
            <span>Aktif</span>
            <span class="px-1.5 py-0.5 text-[10px] rounded-md {{ $currentStatus == 'aktif' ? 'bg-white/20 text-white' : 'bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-200' }}">
                {{ $countAktif }}
            </span>
        </a>
    </div>

    <!-- Search Bar -->
    <form method="GET" action="{{ request()->url() }}" class="flex flex-col sm:flex-row gap-3">
        @if(request('status'))
            <input type="hidden" name="status" value="{{ request('status') }}">
        @endif
        
        <div class="relative flex-1 sm:w-64">
            <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
            <input type="text" 
                   name="search" 
                   value="{{ request('search') }}" 
                   placeholder="Cari nama anggota..." 
                   class="w-full pl-9 pr-4 py-2 text-xs rounded-xl bg-gray-50 dark:bg-gray-700/50 text-gray-800 dark:text-gray-100 border border-gray-200 dark:border-gray-600 focus:ring-2 focus:ring-brand-500 outline-none transition">
        </div>

        <button type="submit" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 text-xs font-medium rounded-xl transition-colors">
            Cari
        </button>
    </form>
</div>

<!-- Data Table Card -->
<div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50/70 dark:bg-gray-700/40 border-b border-gray-100 dark:border-gray-700 text-gray-500 dark:text-gray-400 text-xs uppercase font-semibold tracking-wider">
                    <th class="px-6 py-4">Nama</th>
                    <th class="px-6 py-4">STATUS TERBARU</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-700 text-sm">
                @forelse ($anggotaCards as $anggotaCard)
                    <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-700/30 transition-colors">
                        <!-- Nama Anggota -->
                        <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900 dark:text-gray-100">
                            {{ $anggotaCard->anggota->nama ?? '-' }}
                        </td>

                        <!-- Status Badge (Mengikuti status db anggota_status) -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold border {{ $anggotaCard->status_classes->badge }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $anggotaCard->status_classes->dot }}"></span>
                                {{ ucfirst($anggotaCard->display_status) }}
                            </span>
                        </td>

                        <!-- Action Button -->
                        <td class="px-6 py-4 whitespace-nowrap text-right space-x-2">
                            <!-- Tombol Log Status (Modal Trigger) -->
                            <button type="button"
                                    onclick="openLogModal({{ json_encode($anggotaCard->statuses) }}, '{{ e($anggotaCard->anggota->nama ?? 'Anggota') }}')"
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-amber-600 hover:text-amber-700 bg-amber-50 hover:bg-amber-100 dark:bg-amber-600/10 dark:text-amber-400 dark:hover:bg-brand-600/20 rounded-xl transition-colors">
                                <i class="fa-solid fa-clock-rotate-left"></i>
                                <span>Status Log</span>
                            </button>

                            @can('kartu-anggota-create')
                            <!-- Tombol Lihat Detail dengan Class Dinamis Berdasarkan Status -->
                            <a href="{{ route('admin.anggota-card.show', $anggotaCard->id) }}" 
                               class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium {{ $anggotaCard->status_classes->action }} rounded-xl transition-colors">
                                <i class="fa-solid fa-qrcode"></i>
                                <span>Lihat</span>
                            </a>
                            @endcan
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-6 py-12 text-center text-gray-400 dark:text-gray-500">
                            <div class="flex flex-col items-center justify-center">
                                <i class="fa-solid fa-id-card text-4xl mb-3 text-gray-300 dark:text-gray-600"></i>
                                <p class="text-sm font-medium">Tidak ada data pengajuan anggota.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination Footer -->
    @if($anggotaCards->hasPages())
        <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/50">
            {{ $anggotaCards->appends(request()->query())->links() }}
        </div>
    @endif
</div>

<!-- ================= MODAL LOG / RIWAYAT STATUS ================= -->
<div id="logModal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-gray-900/50 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="relative w-full max-w-lg bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-700 overflow-hidden transform transition-all">
        
        <!-- Header Modal -->
        <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center">
            <div>
                <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100">Riwayat Status</h3>
                <p id="logNamaAnggota" class="text-xs text-gray-500 dark:text-gray-400 mt-0.5"></p>
            </div>
            <button type="button" onclick="closeLogModal()" class="text-gray-400 hover:text-gray-500 focus:outline-none">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        <!-- Content Modal (Timeline Status) -->
        <div class="p-6 max-h-96 overflow-y-auto">
            <div id="timelineContainer" class="relative pl-6 border-l-2 border-gray-200 dark:border-gray-700 space-y-6">
                <!-- Data status akan diisi via JavaScript -->
            </div>
        </div>

        <!-- Footer Modal -->
        <div class="px-6 py-3 bg-gray-50 dark:bg-gray-700/30 border-t border-gray-100 dark:border-gray-700 flex justify-end">
            <button type="button" onclick="closeLogModal()" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 text-xs font-medium rounded-xl transition-colors">
                Tutup
            </button>
        </div>
    </div>
</div>

<!-- JavaScript Modal Control -->
<script>
    function openLogModal(statusLogs, namaAnggota) {
        const modal = document.getElementById('logModal');
        const container = document.getElementById('timelineContainer');
        const namaEl = document.getElementById('logNamaAnggota');

        namaEl.innerText = `Anggota: ${namaAnggota}`;
        container.innerHTML = '';

        if (!statusLogs || statusLogs.length === 0) {
            container.innerHTML = `<p class="text-xs text-gray-400 italic">Belum ada riwayat status.</p>`;
        } else {
            const sortedLogs = [...statusLogs].reverse();

            sortedLogs.forEach((log, index) => {
                const statusName = log.status ? log.status.toUpperCase() : 'UNKNOWN';
                const keterangan = log.keterangan || 'Tidak ada catatan keterangan';
                
                let tanggalStr = '-';
                if (log.created_at) {
                    const dateObj = new Date(log.created_at);
                    tanggalStr = dateObj.toLocaleString('id-ID', {
                        day: '2-digit',
                        month: 'short',
                        year: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit'
                    });
                }

                let dotColor = index === 0 ? 'bg-brand-500 ring-4 ring-brand-100 dark:ring-brand-900/50' : 'bg-gray-300 dark:bg-gray-600';

                const timelineItem = `
                    <div class="relative">
                        <span class="absolute -left-[31px] top-1 w-3 h-3 rounded-full ${dotColor}"></span>
                        
                        <div class="flex flex-col gap-1">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold text-gray-800 dark:text-gray-200 tracking-wide">
                                    ${statusName} ${index === 0 ? '<span class="text-[10px] text-brand-600 bg-brand-50 px-1.5 py-0.5 rounded-md ml-1 font-normal">Terbaru</span>' : ''}
                                </span>
                                <span class="text-[11px] text-gray-400">${tanggalStr}</span>
                            </div>
                            <p class="text-xs text-gray-600 dark:text-gray-400 bg-gray-50 dark:bg-gray-700/40 p-2.5 rounded-xl border border-gray-100 dark:border-gray-700/60 mt-1">
                                ${keterangan}
                            </p>
                        </div>
                    </div>
                `;
                container.innerHTML += timelineItem;
            });
        }

        modal.classList.remove('hidden');
    }

    function closeLogModal() {
        document.getElementById('logModal').classList.add('hidden');
    }
</script>
@endsection